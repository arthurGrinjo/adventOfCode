<?php

declare(strict_types=1);

namespace MueR\AdventOfCode\AdventOfCode2021\Day09;

use JetBrains\PhpStorm\Pure;
use MueR\AdventOfCode\AbstractSolver;

/**
 * Day 9 puzzle.
 *
 * @property array{int} $input
 */
class Day09 extends AbstractSolver
{
    private array $lowPointScore = [];
    private array $lowCoordinates = [];
    private array $basins = [];

    #[Pure]
    public function partOne(): int
    {
        $result = 0;
        $this->findLowPoints();

        foreach ($this->lowPointScore as $s) {
            $result += ($s + 1);
        }

        return $result;
    }

    #[Pure]
    public function partTwo(): int
    {
        $this->findBassins();
        rsort($this->basins);

        $result = $this->basins[0] * $this->basins[1] * $this->basins[2];

        return $result;
    }

    public function findLowPoints()
    {
        $this->input = array_filter($this->input);

        foreach($this->input as $i => $l) {
            $this->input[$i] = str_split((string) $l);

            foreach($this->input[$i] as $k => $v) {
                /** check left */
                if (array_key_exists($k-1, $this->input[$i]) && $this->input[$i][$k-1] <= $v) {
                    continue;
                }

                /** check right */
                if (array_key_exists($k+1, $this->input[$i]) && $this->input[$i][$k+1] <= $v) {
                    continue;
                }

                /** check up */
                if (array_key_exists($i-1, $this->input) && $this->input[$i-1][$k] <= $v) {
                    continue;
                }

                /** check down */
                if (array_key_exists($i+1, $this->input) && $this->input[$i+1][$k] <= $v) {
                    continue;
                }

                $this->lowCoordinates[] = $i . '-' . $k;
                $this->lowPointScore[] = $v;
            }
        }
    }

    public function findBassins()
    {
        foreach ($this->lowCoordinates as $k => $coordinate){
            $basin = [$coordinate];
            $score = [$this->lowPointScore[$k]];

            $i = 0;
            while ($i < count($basin)) {
                /** split coordinate */
                [$y, $x] = preg_split("/-/", $basin[$i]);

                /** check left */
                if (
                    array_key_exists($x-1, $this->input[$y])
                    && $this->input[$y][$x-1] >= $score[$i]
                    && $this->input[$y][$x-1] != 9
                    && !in_array($y .'-'. $x-1, $basin)
                ) {
                    $basin[] = $y .'-'. $x-1;
                    $score[] = $this->input[$y][$x-1];
                }

                /** check right */
                if (
                    array_key_exists($x+1, $this->input[$y])
                    && $this->input[$y][$x+1] >= $score[$i]
                    && $this->input[$y][$x+1] != 9
                    && !in_array($y .'-'. $x+1, $basin)
                ) {
                    $basin[] = $y .'-'. $x+1;
                    $score[] = $this->input[$y][$x+1];
                }

                /** check up */
                if (
                    array_key_exists($y+1, $this->input)
                    && $this->input[$y+1][$x] >= $score[$i]
                    && $this->input[$y+1][$x] != 9
                    && !in_array($y+1 .'-'. $x, $basin)
                ) {
                    $basin[] = $y+1 .'-'. $x;
                    $score[] = $this->input[$y+1][$x];
                }

                /** check down */
                if (
                    array_key_exists($y-1, $this->input)
                    && $this->input[$y-1][$x] >= $score[$i]
                    && $this->input[$y-1][$x] != 9
                    && !in_array($y-1 .'-'. $x, $basin)
                ) {
                    $basin[] = $y-1 .'-'. $x;
                    $score[] = $this->input[$y-1][$x];
                }

                $i++;
            }

            $this->basins[] = count($basin);
        }
    }
}
