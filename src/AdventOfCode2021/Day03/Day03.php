<?php

declare(strict_types=1);

namespace MueR\AdventOfCode\AdventOfCode2021\Day03;

use JetBrains\PhpStorm\Pure;
use MueR\AdventOfCode\AbstractSolver;

/**
 * Day 3 puzzle.
 *
 * @property array{int} $input
 */
class Day03 extends AbstractSolver
{
    #[Pure]
    public function partOne(): int
    {
        $result = [];
        $gamma = [];
        $epsilon = [];

        foreach ($this->input as $binary) {
            if (!empty($binary)) {
                $binArray = str_split($binary);

                foreach ($binArray as $i => $b) {
                    $result[$i] = (empty($result[$i])) ? 0 : $result[$i];
                    $result[$i] = ($b === '0') ? $result[$i]-1 : $result[$i]+1;
                }
            }
        }

        foreach ($result as $i => $r) {
            $gamma[$i] = ($r > 0) ? '1' : '0';
            $epsilon[$i] = ($r <= 0) ? '1' : '0';
        }

        return bindec(implode($gamma)) * bindec(implode($epsilon));
    }

    #[Pure]
    public function partTwo(): int
    {
        $position = 0;
        $oxygen = $this->input;
        $co2 = $this->input;

        while (strlen($this->input[0]) > $position)
        {
            $bit1 = $this->getMostCommon($oxygen, $position, 1);
            $oxygen = $this->filterInput($oxygen, $position, $bit1);

            $bit2 = $this->getMostCommon($co2, $position, 0);
            $co2 = $this->filterInput($co2, $position, $bit2);

            $position++;
        }

        return bindec(implode($oxygen)) * bindec(implode($co2));
    }

    public function getMostCommon(array $input, int $position, int $bool): int
    {
        $result = 0;

        foreach ($input as $b) {
            if (!empty($b)) {
                $val = str_split($b);
                $result = ((int) $val[$position] === $bool) ? $result + 1 : $result - 1;
            }
        }

        if ($result === 0) {
            return $bool;
        }
        return ($result < 0) ? 0 : 1;
    }

    public function filterInput(array $input, int $position, int $bit): array
    {
        if (count($input)===1) {
            return $input;
        }

        foreach ($input as $i => $b) {
            $val = str_split($b);

            if ((int) $val[$position] !== $bit || $input[$i] == "") {
                unset($input[$i]);
            }
        }
        return $input;
    }
}
