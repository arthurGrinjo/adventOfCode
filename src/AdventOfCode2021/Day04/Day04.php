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
    private $drawnNumbers = null;
    private $board = [];
    private $drawnNumber = 0;
    private $bingo = 0;

    #[Pure]
    public function partOne(): int
    {
        $this->readInput();
        $this->processDrawnNumbers(1);

        return $this->calculateResult();
//        return 0;
    }

    #[Pure]
    public function partTwo(): int
    {
        $this->drawnNumber = 0;
        $this->bingo = 0;

        $this->readInput();
        $this->processDrawnNumbers(2);

        return $this->calculateResult();
    }

    public function readInput()
    {
        $this->board = [];

        if (empty($this->drawnNumbers)) {
            $this->drawnNumbers = explode(',', $this->input[0]);
        }

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

    public function processDrawnNumbers($mode = 1)
    {
        var_dump(count($this->drawnNumbers), count($this->board));
        foreach ($this->drawnNumbers as $n)
        {
            if ($n == "") { continue; }

            if ($this->drawnNumber != 0) {
                return;
            }

            foreach ($this->board as $index => $board)
            {
                if ($this->drawnNumber != 0) {
                    return;
                }

                for ($i = 0; $i<5; $i++) {
                    $this->board[$index]['horizontal'][$i] = array_filter($this->board[$index]['horizontal'][$i],
                            function($v) use ($n) { return $v != $n; }
                    );

                    $this->board[$index]['vertical'][$i] = array_filter($this->board[$index]['vertical'][$i],
                        function($v) use ($n) { return $v != $n; }
                    );

                    if (empty($this->board[$index]['horizontal'][$i]) || empty($this->board[$index]['vertical'][$i])) {
                        if ($mode == 1) {
                            $this->drawnNumber = (int) $n;
                            $this->bingo = $index;
                        }

                        if (count($this->board) == 1) {
                            $this->drawnNumber = (int) $n;
                            $this->bingo = $index;
                            $i = 6;
                        }

                        if ($mode == 2 && count($this->board) > 1) {
                            unset($this->board[$index]);
                            $i = 6;
                        }
                    }
                }
            }
        }
    }

    public function calculateResult(): int
    {
        $total = 0;

        foreach ($this->board[$this->bingo]['horizontal'] as $row) {
            $total += array_sum($row);
        }

        return $this->drawnNumber * $total;
    }
}
