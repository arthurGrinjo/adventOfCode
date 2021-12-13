<?php

declare(strict_types=1);

namespace MueR\AdventOfCode\AdventOfCode2021\Day06;

use JetBrains\PhpStorm\Pure;
use MueR\AdventOfCode\AbstractSolver;

/**
 * Day 6 puzzle.
 *
 * @property array{int} $input
 */
class Day06 extends AbstractSolver
{
    private $lanternFish = [];
    private $solutions = [0 => 0, 1 => 1, 2 => 1, 3 => 1, 4 => 1, 5 => 1, 6 => 1];

    #[Pure]
    public function partOne(): int
    {
        $this->lanternFish = explode(',', $this->input[0]);
        $result = $this->growLanternFish(80);

        return $result;
    }

    #[Pure]
    public function partTwo(): int
    {
        $this->lanternFish = explode(',', $this->input[0]);
        $result = $this->growLanternFish(256);

        return $result;
    }

    public function growLanternFish(int $iterations): int
    {
        $finalResult = 0;

        $iterations += 6;
        for ($i = 7; $i < $iterations; $i++) {
            $this->solve($i);
        }

        foreach ($this->lanternFish as $timer) {
            $finalResult += $this->solutions[($iterations - $timer)];
        }

        return $finalResult;
    }

    public function solve(int $iterations)
    {
        if (isset($this->solutions[$iterations])) {
            return;
        }

        $n = $iterations - 7;
        $result = 1;

        while ($n >= 0) {
            if ($n - 2 > 0) {
                $result += $this->solutions[$n - 2];
            } else {
                $result += 1;
            }
            $n -= 7;
        }

        /** save to solutions */
        $this->solutions[$iterations] = $result;
    }
}
