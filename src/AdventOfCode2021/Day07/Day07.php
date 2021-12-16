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
    private $median;

    #[Pure]
    public function partOne(): int
    {
        $this->crabPositions = explode(',', $this->input[0]);
        sort($this->crabPositions);

        $this->median = $this->findMedian();

        [$line, $fuel] = $this->findLine(1);

        return $fuel;
    }

    #[Pure]
    public function partTwo(): int
    {
        [$line, $fuel] = $this->findLine(2);
        return $fuel;
    }

    public function findLine(int $mode): array
    {
        $solution = 0;

        $i = 0;
        $line = $this->median;
        $steps = $this->calculateSteps();
        $direction = 1;

        while (!empty($steps[$i]) && $solution < 2) {
            if ($mode === 1) {
                $firstLine = $this->calculateLine($line);
                $secondLine = $this->calculateLine(($direction === 1) ? ($line + $steps[$i]) : ($line - $steps[$i]));
            }

            if ($mode === 2) {
                $firstLine = $this->calculateLine2($line);
                $secondLine = $this->calculateLine2(($direction === 1) ? ($line + $steps[$i]) : ($line - $steps[$i]));
            }

//            var_dump('-----------');
//            var_dump($line);
//            var_dump($firstLine);
//            var_dump($secondLine);

            if ($secondLine > $firstLine) {
                $direction = ($direction === 1) ? 0 : 1;
                $solution++;

                if ($solution === 2) {
                    $solution = 0;
                    $i++;
                }
                continue;
            }

            if ($secondLine < $firstLine) {
                $solution = 0;
                $line = ($direction === 1) ?  ($line + $steps[$i]) : ($line - $steps[$i]);
            }
        }
        return [$line, $firstLine];
    }

    public function calculateLine($line): int
    {
        $newArray = array_map(function ($v) use ($line) {
            return abs($v - $line);
        }, $this->crabPositions);

        return array_sum($newArray);
    }

    public function calculateLine2($line): int
    {
        $newArray = array_map(function ($v) use ($line) {
            return array_sum(range(1, abs($v - $line)));
        }, $this->crabPositions);

        return array_sum($newArray);
    }

    public function calculateSteps(): array
    {
        $step = end($this->crabPositions);
        $steps = [];
        $divisor = 10;

        while (round($step / $divisor) > 1) {
            $steps[] = (int) round($step / $divisor);
            $step = (int) round($step / $divisor);
        }

        $steps[] = 1;

        return $steps;
    }

    public function findMedian(): int
    {
        return (int) $this->crabPositions[round(count($this->crabPositions) / 2)];
    }
}
