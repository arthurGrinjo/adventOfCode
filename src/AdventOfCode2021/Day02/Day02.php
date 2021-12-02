<?php

declare(strict_types=1);

namespace MueR\AdventOfCode\AdventOfCode2021\Day02;

use JetBrains\PhpStorm\Pure;
use MueR\AdventOfCode\AbstractSolver;

/**
 * Day 2 puzzle.
 *
 * @property array{int} $input
 */
class Day02 extends AbstractSolver
{
    #[Pure]
    public function partOne(): int
    {
        $horizontal = 0;
        $vertical = 0;

        foreach ($this->input as $command) {
            list ($k, $v) = explode(' ', $command);

            switch($k) {
                case 'up':
                    $vertical = $vertical - (int) $v;
                    break;
                case 'down':
                    $vertical += (int) $v;
                    break;
                case 'forward':
                    $horizontal += (int) $v;
            }
        }

        return $horizontal * $vertical;
    }

    #[Pure]
    public function partTwo(): int
    {
        $horizontal = 0;
        $vertical = 0;
        $aim = 0;

        foreach ($this->input as $command) {
            list ($k, $v) = explode(' ', $command);

            switch($k) {
                case 'up':
                    $aim = $aim - (int) $v;
                    break;
                case 'down':
                    $aim += (int) $v;
                    break;
                case 'forward':
                    $horizontal += (int) $v;
                    $vertical += ($aim * (int) $v);
            }
        }

        return $horizontal * $vertical;
    }
}
