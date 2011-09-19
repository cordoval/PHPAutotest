<?php

namespace MineSweeper;

class Sweeper implements SweeperInterface
{
    public function __construct(ReducerInterface $reducer) {
        $this->reducer = $reducer;
    }
    
    /**
     * sweeps over the 2d grid mine field
     *
     * @param array $grid
     * @return array
     */
    public function sweep(array $grid) {
        for ($y = 0; $y < sizeof(array_keys($grid)); $y++) {
            $row = null;
            for ($x = 0; $x < sizeof($grid[0]); $x++) {
                $row[] = $this->reducer->reduce($grid, $x, $y);
            }
            $grid_converted[] = $row;
        }
        return $grid_converted;
    }
}