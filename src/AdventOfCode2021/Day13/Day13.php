<?php

declare(strict_types=1);

namespace MueR\AdventOfCode\AdventOfCode2021\Day13;

use JetBrains\PhpStorm\Pure;
use MueR\AdventOfCode\AbstractSolver;

/**
 * Day 13 puzzle.
 *
 * @property array{int} $input
 */
class Day13 extends AbstractSolver
{
    private array $paper = [];
    private array $folds = [];

    #[Pure]
    public function partOne(): int
    {
        $this->arrangeInput();

        $this->foldPaper();

        return count($this->paper);
    }

    #[Pure]
    public function partTwo(): int
    {
        $this->foldPaper(2);

        $this->dumpOutput();

        return 0;
    }

    public function arrangeInput()
    {
        foreach($this->input as $line)
        {
            if (empty($line)) { continue; }

            $input = str_replace('fold along ', '', $line, $count);

            if ($count === 0) {
                $p = explode(',', $line);
                $this->paper[] = [(int)$p[0], (int)$p[1]];
            } else {
                $this->folds[] = explode('=', $input);
            }
        }
    }

    public function foldPaper($mode = 1)
    {
        foreach($this->folds as $key => $fold) {
            /** skip first step */
            if ($mode === 2 && $key === 0) {
                continue;
            }

            if ($fold[0] === 'x') {
                $this->paper = array_map(function($c) use ($fold) {
                    if ($c[0] > $fold[1]) {
                        (int) $c[0] = 2 * $fold[1] - $c[0];
                    }

                    return $c;
                }, $this->paper);
            }

            if ($fold[0] === 'y') {
                $this->paper = array_map(function($c) use ($fold) {
                    if ($c[1] > $fold[1]) {
                        (int) $c[1] = 2 * $fold[1] - $c[1];
                    }

                    return $c;
                }, $this->paper);
            }

            $this->removeDoubles();

            if ($mode === 1) {
                break;
            }
        }
    }

    public function removeDoubles()
    {
        $paper = [];

        foreach($this->paper as $key => $p) {
            $point = $p[0] .','. $p[1];

            if (in_array($point, $paper)) {
                unset($this->paper[$key]);
                continue;
            }

            $paper[] = $point;
        }
    }

    public function dumpOutput()
    {
        $output = [];

        foreach($this->paper as $point)
        {
            if (empty($output[$point[1]])) {
                $output[$point[1]] = [];
            }

            $output[$point[1]][] = $point[0];
        }

        for ($y=0; $y<count($output); $y++) {
            sort($output[$y]);
            $string = '';

            for ($x=0; $x<=end($output[$y]); $x++) {
                $string .= (in_array($x, $output[$y])) ? '#' : '.';
            }
            var_dump($string);
        }
    }
}
