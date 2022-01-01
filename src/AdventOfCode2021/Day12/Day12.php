<?php

declare(strict_types=1);

namespace MueR\AdventOfCode\AdventOfCode2021\Day12;

use JetBrains\PhpStorm\Pure;
use MueR\AdventOfCode\AbstractSolver;

/**
 * Day 12 puzzle.
 *
 * @property array{int} $input
 */
class Day12 extends AbstractSolver
{
    private array $paths = [];
    private array $routes = [];

    #[Pure]
    public function partOne(): int
    {
        $this->arrangeInput();

        $this->makeRoutes();

        return count($this->routes);
    }

    #[Pure]
    public function partTwo(): int
    {
        $this->makeRoutes(2);

        return count($this->routes);
    }

    public function arrangeInput()
    {
        foreach($this->input as $l)
        {
            if (empty($l)) { continue; }

            [$one, $two] = preg_split('/-/', $l);

            if (! array_key_exists($one, $this->paths)) {
                $this->paths[$one] = [];
            }

            if (! array_key_exists($two, $this->paths)) {
                $this->paths[$two] = [];
            }

            if ($two !== 'start') {
                $this->paths[$one][] = $two;
            }

            if ($one !== 'start') {
                $this->paths[$two][] = $one;
            }
        }
    }

    public function makeRoutes($part = 1)
    {
        $routeEnd = 0;
        $this->routes = [['start']];

        while($routeEnd < count($this->routes))
        {
            $routeEnd = 0;
            $newRoutes = [];

            foreach($this->routes as $k => $route)
            {
                $lastElement = end($route);

                if ($lastElement === 'end') {
                    $newRoutes[] = $route;
                    $routeEnd++;
                    continue;
                }

                foreach ($this->paths[$lastElement] as $path) {
                    $newRoute = $route;

                    if (ctype_lower($path)) {
                        if (in_array($path, $newRoute)) {
                            $continue = false;

                            if ($part === 2) {
                                $counts = array_count_values($newRoute);

                                foreach($counts as $k => $c) {
                                    if (ctype_lower($k) && $c === 2) {
                                        $continue = true;
                                        break;
                                    }
                                }
                            }


                            if ($part === 1 || $continue) {
                                continue;
                            }
                        }
                    }

                    $newRoute[] = $path;
                    $newRoutes[] = $newRoute;

                    if ($path === 'end') {
                        $routeEnd++;
                    }
                }
            }

            $this->routes = $newRoutes;
        }
    }
}
