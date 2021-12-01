<?php

declare(strict_types=1);

namespace MueR\AdventOfCode\AdventOfCode2021\Day01;

use JetBrains\PhpStorm\Pure;
use MueR\AdventOfCode\AbstractSolver;

/**
 * Day 1 puzzle.
 *
 * @property array{int} $input
 */
class Day01 extends AbstractSolver
{
    #[Pure]
    public function partOne(): int
    {
        $result = 0;
        $previous = $this->input[0];

        foreach($this->input as $v) {
            if (intval($v)) {
                if ($v > $previous) {
                    $result++;
                }
                $previous = $v;
            }
        }

        return $result;
    }

    #[Pure]
    public function partTwo(): int
    {
        $result = 0;
        $newArray = [];

        foreach($this->input as $v) {
            if (intval($v)) {
                $newArray[] = $v;
                end($newArray);
                $k = key($newArray);

                if (!empty($newArray[$k-1])) { $newArray[$k-1] += $v; }
                if (!empty($newArray[$k-2])) { $newArray[$k-2] += $v; }
            }
        }

        /** remove last 2 elements from array */
        array_slice($newArray, 0, -2);

        $previous = $newArray[0];

        foreach($newArray as $v) {
            if (intval($v)) {
                if ($v > $previous) {
                    $result++;
                }
                $previous = $v;
            }
        }

        return $result;
    }
}
