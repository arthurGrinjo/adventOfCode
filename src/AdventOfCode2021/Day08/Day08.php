<?php

declare(strict_types=1);

namespace MueR\AdventOfCode\AdventOfCode2021\Day08;

use JetBrains\PhpStorm\Pure;
use MueR\AdventOfCode\AbstractSolver;

/**
 * Day 8 puzzle.
 *
 * @property array{int} $input
 */
class Day08 extends AbstractSolver
{
    #[Pure]
    public function partOne(): int
    {
        $result = 0;
        $this->input = $this->getInput();

        foreach ($this->input as $v) {
            if (!empty($v)) {
                foreach($v[1] as $number) {
                    $result += (in_array(strlen($number), [2, 3, 4, 7])) ? 1 : 0;
                }
            }
        }

        return $result;
    }

    #[Pure]
    public function partTwo(): int
    {
        $result = 0;

        foreach($this->input as $line) {
            /** solution */
            $s =  $this->getDigitalNumberSolution($line[0]);

            $code = $line[1];

            $result += (int) sprintf("%d%d%d%d", $s[$code[0]], $s[$code[1]], $s[$code[2]], $s[$code[3]]);
        }

        return $result;
    }

    public function getInput(): array
    {
        /** split by | */
        return array_map(function ($one) {
            if (empty($one)) { return; }

            /** split by whitespace */
            return array_map(function ($two) {

                /** sort alphabetically */
                return array_map(function ($three) {
                    $stringAsArray = str_split($three);
                    sort($stringAsArray);
                    return implode('', $stringAsArray);
                }, preg_split("/\s/i", $two));
            }, preg_split("/\s\|\s/i", $one));
        }, array_filter($this->input));
    }

    public function getDigitalNumberSolution(array $input): array
    {
        $solution = [];

        usort($input, '\MueR\AdventOfCode\AdventOfCode2021\Day08\Day08::sort');

        /** solved by number of characters */
        $solution[1] = $input[0];
        unset($input[0]);

        $solution[7] = $input[1];
        unset($input[1]);

        $solution[4] = $input[2];
        unset($input[2]);

        $solution[8] = $input[9];
        unset($input[9]);

        /** solved by deduction */
        foreach ($input as $i) {
            $iAsArray = str_split($i);
            if (strlen($i) === 5) {
                /** Number 3 */
                if (count(array_diff($iAsArray, str_split($solution[1]))) === 3) {
                    $solution[3] = $i;
                    continue;
                }

                /** Number 2 */
                if (count(array_diff($iAsArray, str_split($solution[4]))) === 3) {
                    $solution[2] = $i;
                    continue;
                }

                /** Number 5 */
                $solution[5] = $i;
            }

            if (strlen($i) === 6) {
                /** Number 9 */
                if (count(array_diff($iAsArray, str_split($solution[4]))) === 2) {
                    $solution[9] = $i;
                    continue;
                }

                /** Number 6 */
                if (count(array_diff($iAsArray, str_split($solution[5]))) === 1) {
                    $solution[6] = $i;
                    continue;
                }

                /** Number 0 */
                $solution[0] = $i;
            }
        }
        return array_flip($solution);
    }

    private static function sort($a,$b){
        return strlen($a)-strlen($b);
    }
}
