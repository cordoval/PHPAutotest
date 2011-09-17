<?php
namespace MineSweeper;

use MineSweeper\ReducerInterface;

class Sweeper implements SweeperInterface
{
    public function __construct(ReducerInterface $reducer) {
        $this->reducer = $reducer;
    }

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
