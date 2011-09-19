<?php
namespace MineSweeper;

interface ReducerInterface
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
   function reduce(array $grid, $x, $y);

}
