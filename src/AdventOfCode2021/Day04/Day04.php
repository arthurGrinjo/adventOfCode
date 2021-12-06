<?php

declare(strict_types=1);

namespace MueR\AdventOfCode\AdventOfCode2021\Day04;

use JetBrains\PhpStorm\Pure;
use MueR\AdventOfCode\AbstractSolver;

/**
 * Day 4 puzzle.
 *
 * @property array{int} $input
 */
class Day04 extends AbstractSolver
{
    private $drawnNumbers = [];
    private $board = [];
    private $solution = 0;

    #[Pure]
    public function partOne(): int
    {
        $result = 0;

        $this->readInput();
        $this->processDrawnNumbers();
//        $result = $this->calculateSolution();
        return (int) $this->solution;
    }

    #[Pure]
    public function partTwo(): int
    {
        $result = 0;

        return $result;
    }

    public function readInput()
    {
        /** @var array drawnNumbers */
        $this->drawnNumbers = explode(',', $this->input[0]);

        /** remove first line from array */
        array_shift($this->input);

        $boardNumber = 0;
        foreach ($this->input as $line)
        {
            if (empty($line)) {
                $boardNumber++;
                $this->board[$boardNumber] = ['horizontal' => [], 'vertical' => []];
                continue;
            }

            $line = trim($line);

            $splitted = preg_split('/\s+/', $line);

            /** create horizontal board */
            $this->board[$boardNumber]['horizontal'][] = $splitted;

            /** create vertical board */
            for ($i=0; $i<count($splitted); $i++) {
                $this->board[$boardNumber]['vertical'][$i][] = $splitted[$i];
            }
        }

        array_pop($this->board);
    }

    public function processDrawnNumbers()
    {
        foreach ($this->drawnNumbers as $n)
        {
            if ($this->solution != 0) {
                return;
            }

            foreach ($this->board as $index => $board)
            {
                if ($this->solution != 0) {
                    return;
                }

                for ($i = 0; $i<5; $i++) {
                    array_map(function($v, $k) use ($n, $index, $i) {
                        if ($v == $n) {
                            unset($this->board[$index]['horizontal'][$i][$k]);
                            if (empty($this->board[$index]['vertical'][$i])) {
                                $this->solution = $n;
                            }
                        }
                    }, $board['horizontal'][$i], array_keys($board['horizontal'][$i]));

                    array_map(function ($v, $k) use ($n, $index, $i) {
                        if ($v == $n) {
                            unset($this->board[$index]['vertical'][$i][$k]);
                            if (empty($this->board[$index]['vertical'][$i])) {
                                $this->solution = $n;
                            }
                        }
                    }, $board['vertical'][$i], array_keys($board['vertical'][$i]));
                }
            }
        }
    }

//    public function calculateResult()
//    {
//
//    }
}
