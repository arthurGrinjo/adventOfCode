<?php

declare(strict_types=1);

namespace MueR\AdventOfCode\AdventOfCode2021\Day05;

use JetBrains\PhpStorm\Pure;
use MueR\AdventOfCode\AbstractSolver;

/**
 * Day 5 puzzle.
 *
 * @property array{int} $input
 */
class Day05 extends AbstractSolver
{
    private $diagram = [];
    private $coordinates = [];

    #[Pure]
    public function partOne(): int
    {
        $this->readInput();
        $this->createDiagram();
        $result = $this->findSolution();

        return $result;
    }

    #[Pure]
    public function partTwo(): int
    {
        $this->diagram = [];

        $this->createDiagram(2);
        $result = $this->findSolution();

        return $result;
    }

    public function readInput()
    {
        foreach ($this->input as $l) {
            preg_match_all('/\d+,\d+/', $l, $matches);
            $this->coordinates[] = $matches[0];
        }
    }

    public function createDiagram($mode = 1)
    {
        foreach ($this->coordinates as $coordinate) {
            if (empty($coordinate)) { continue; }

            [$x1, $y1] = explode(',', $coordinate[0]);
            [$x2, $y2] = explode(',', $coordinate[1]);

            if ($x1 != $x2 && $y1 != $y2) {
                if ($mode === 1) {
                    continue;
                }

                while ($x1 != $x2) {
                    /** get smallest x and y coordinate */
                    $x = ($x1 < $x2) ? $x1 : $x2;
                    $y = ($x1 < $x2) ? $y1 : $y2;

                    if (empty($this->diagram[$y])) {
                        $this->diagram[$y] = [];
                    }

                    if (empty($this->diagram[$y][$x])) {
                        $this->diagram[$y][$x] = 1;
                    } else {
                        $this->diagram[$y][$x]++;
                    }

                    if ($x == $x1) {
                        ($y1 < $y2) ? $y1++ : $y1--;
                    } else {
                        ($y2 < $y1) ? $y2++ : $y2--;
                    }

                    ($x1 < $x2) ? $x1++ : $x2++;
                }
            }

            while ($x1 != $x2) {
                /** get smallest x coordinate */
                $x = ($x1 < $x2) ? $x1 : $x2;

                /** create row */
                if (empty($this->diagram[$y1])) {
                    $this->diagram[$y1] = [];
                }

                if (empty($this->diagram[$y1][$x])) {
                    $this->diagram[$y1][$x] = 1;
                } else {
                    $this->diagram[$y1][$x]++;
                }

                ($x1 < $x2) ? $x1++ : $x2++;
            }

            while ($y1 != $y2) {
                /** get smallest y coordinate */
                $y = ($y1 < $y2) ? $y1 : $y2;

                /** create row */
                if (empty($this->diagram[$y])) {
                    $this->diagram[$y] = [];
                }

                if (empty($this->diagram[$y][$x1])) {
                    $this->diagram[$y][$x1] = 1;
                } else {
                    $this->diagram[$y][$x1]++;
                }

                ($y1 < $y2) ? $y1++ : $y2++;
            }

            /**
             * add last one
             * (x1 == x2)
             * (y1 == y2)
             */
            if (empty($this->diagram[$y1][$x1])) {
                $this->diagram[$y1][$x1] = 1;
            } else {
                $this->diagram[$y1][$x1]++;
            }
        }
    }

    public function findSolution(): int
    {
        $total = 0;
        foreach ($this->diagram as $index => $row)
        {
            foreach ($row as $field) {
                if ($field > 1) {
                    $total++;
                }
            }
        }

        return $total;
    }
}
