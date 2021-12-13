<?php

declare(strict_types=1);

namespace MueR\AdventOfCode\AdventOfCode2021\Day07;

use JetBrains\PhpStorm\Pure;
use MueR\AdventOfCode\AbstractSolver;

/**
 * Day 7 puzzle.
 *
 * @property array{int} $input
 */
class Day07 extends AbstractSolver
{
    private $crabPositions = [];
    private $mode;
    private $median;
    private $average;

    #[Pure]
    public function partOne(): int
    {
        $this->crabPositions = explode(',', $this->input[0]);
        sort($this->crabPositions);

        $this->median = $this->crabPositions[round(count($this->crabPositions) / 2)];

        $freq = array();
        for($i=0; $i<count($this->crabPositions); $i++)
        {
            if(isset($freq[$this->crabPositions[$i]])==false)
            {
                $freq[$this->crabPositions[$i]] = 1;
            }
            else
            {
                $freq[$this->crabPositions[$i]]++;
            }
        }
        $maxs = array_keys($freq, max($freq));

        for($i=0; $i<count($maxs); $i++)
        {
            var_dump('Modus: ' . $maxs[$i] . ' - aantal: ' . $freq[$maxs[$i]]);
        }

        return 0;
    }

    #[Pure]
    public function partTwo(): int
    {
        return 0;
    }
}
