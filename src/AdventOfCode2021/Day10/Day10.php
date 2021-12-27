<?php

declare(strict_types=1);

namespace MueR\AdventOfCode\AdventOfCode2021\Day10;

use JetBrains\PhpStorm\Pure;
use MueR\AdventOfCode\AbstractSolver;

/**
 * Day 10 puzzle.
 *
 * @property array{int} $input
 */
class Day10 extends AbstractSolver
{
    private array $errorScore = [")" => 3, "]" => 57, "}" => 1197, ">" => 25137];
    private array $completionScore = [")" => 1, "]" => 2, "}" => 3, ">" => 4];
    private array $navigation = [];
    private array $completion = [];

    #[Pure]
    public function partOne(): int
    {
        $this->deductNavigationLines();

        return $this->getErrorScore();
    }

    #[Pure]
    public function partTwo(): int
    {
        $result = 0;

        $this->discardCorruptedLines();
        $this->completeNavigationLines();

        return $this->getCompletionScore();
    }

    public function deductNavigationLines()
    {
        $this->input = array_filter($this->input);
        foreach($this->input as  $navLine)
        {
            $length = strlen($navLine);
            $newLength = 0;

            while($newLength < $length) {
                $length = strlen($navLine);

                $navLine = str_replace(['()', '[]', '{}', '<>'], '', $navLine);

                $newLength = strlen($navLine);
            }
            $this->navigation[] = $navLine;
        }
    }

    public function getErrorScore(): int
    {
        $total = 0;

        foreach($this->navigation as $n)
        {
            /** find first occurence of ],},>,) */
            $found = strpbrk($n, ')>]}');

            if ($found) {
                $total += $this->errorScore[substr($found, 0, 1)];
            }
        }

        return $total;
    }

    public function discardCorruptedLines()
    {
        foreach($this->navigation as $k => $n)
        {
            /** find first occurence of ],},>,) */
            if (strpbrk($n, ')>]}')) {
                unset($this->navigation[$k]);
            }
        }
    }

    public function completeNavigationLines()
    {
        foreach($this->navigation as $n)
        {
            $this->completion[] = str_replace(['(', '[', '{', '<'], [')', ']', '}', '>'], strrev($n));
        }
    }

    public function getCompletionScore()
    {
        $allScores = [];
        foreach($this->completion as $line)
        {
            $scorePerLine = 0;

            foreach(str_split($line) as $c) {
                $scorePerLine *= 5;
                $scorePerLine += $this->completionScore[$c];
            }

            $allScores[] = $scorePerLine;
        }
        sort($allScores);
        var_dump($allScores);
        return $allScores[ceil(count($allScores)/2)-1];
    }
}
