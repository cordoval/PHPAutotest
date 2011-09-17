<?php
namespace MineSweeper;

class Reducer implements ReducerInterface
{
   /**
    * returns the total mines per neighbor per grid (grid) for a cell in $x,$y position
    *
    * @param array $grid
    * @param int $x
    * @param int $y
    *
    * @return value
    */
   public function reduce(array $grid, int $x, int $y)
   {
        // adds up if $cell is a '*'
        $addMines = function ($sum, $cell)
        {
            return $sum += ($cell == '*') ? 1 : 0;
        };

        // count neighbors that are mines
        $mineCount = array_reduce($findNeighborsPerCell($grid, $x, $y), $addMines);

        // if current position is a mine just output a mine else the mines count surrounding it
        return ($grid[$y][$x] == "*") ? '*' : $mineCount;
   }
}
