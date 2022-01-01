<?php

declare(strict_types=1);

namespace MueR\AdventOfCode\AdventOfCode2021\Day11;

use JetBrains\PhpStorm\Pure;
use MueR\AdventOfCode\AbstractSolver;

/**
 * Day 11 puzzle.
 *
 * @property array{int} $input
 */
class Day11 extends AbstractSolver
{
    private array $octopussies = [];
    private array $matrix = [[-1, -1], [-1, 0], [-1, 1], [0, -1], [0, 0], [0, 1], [1, -1], [1, 0], [1, 1]];
    private int $flashes = 0;
    private int $flashesThisStep = 0;

    #[Pure]
    public function partOne(): int
    {
        $this->reformatInput();
        $this->flashTheOctoos(100);

        return $this->flashes;
    }

    #[Pure]
    public function partTwo(): int
    {
        $steps = 100;
        while ($this->flashesThisStep < 100) {
            $steps++;
            $this->flashTheOctoos(1);
        }

        return $steps-1;
    }

    public function reformatInput()
    {
        foreach(array_filter($this->input) as $line)
        {
            $this->octopussies[] = str_split($line);
        }
    }

    public function flashTheOctoos(int $numberOfSteps = 4)
    {
        $steps = 0;
        while ($steps < $numberOfSteps) {
            $this->flashesThisStep = 0;

            /** value + 1 */
            foreach ($this->octopussies as $i => $row) {
                $this->octopussies[$i] = array_map(function ($v) {
                    if ((int)$v === 0) { $this->flashesThisStep++; }
                    return ((int)$v === 9) ? 'x' : $v+1;
                }, $row);
            }

            $adjust = 1;
            while ($adjust === 1) {
                $adjust = 0;

                foreach ($this->octopussies as $i => $row) {
                    foreach ($row as $k => $octo) {
                        if ($octo === 'x') {
                            /** flashing */
                            $this->flashes++;

                            $this->octopussies[$i][$k] = 0;
                            $adjust = 1;

                            foreach ($this->matrix as $c) {
                                if (array_key_exists($i + $c[0], $this->octopussies)) {
                                    if (array_key_exists($k + $c[1], $this->octopussies[$i + $c[0]])) {
                                        $v = (int)$this->octopussies[$i + $c[0]][$k + $c[1]];

                                        if ($v !== 0) {
                                            $this->octopussies[$i + $c[0]][$k + $c[1]] = ($v === 9) ? 'x' : $v+1;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $steps++;
        }
    }
}
