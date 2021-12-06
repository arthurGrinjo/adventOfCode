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

    #[Pure]
    public function partOne(): int
    {

        $this->lanternFish = explode(',', $this->input[0]);
        $i = 0;

        while ($i < 80) {
            $this->growLanternFish();
            $i++;
        }

        return count($this->lanternFish);
    }

    #[Pure]
    public function partTwo(): int
    {
        $result = 0;

        return $result;
    }

    public function growLanternFish()
    {
        foreach($this->lanternFish as $i => $fish)
        {
            if ($fish == 0) {
                $this->lanternFish[] = 8;
                $this->lanternFish[$i] = 6;
            } else {
                $this->lanternFish[$i]--;
            }
        }
    }
}
