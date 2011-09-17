<?php
namespace MineSweeper;

class Reducer implements ReducerInterface
{
    protected $filter;
    
    public function __construct(FilterInterface $filter)
    {
        $this->filter = $filter;
    }
    
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
       // count neighbors that are mines
       $arrayFiltered = $this->filter->process($grid, $x, $y);
       $mineCount = array_reduce($arrayFiltered, array($this, 'addMines'));

       // if current position is a mine just output a mine else the mines count surrounding it
       return ($grid[$y][$x] == "*") ? '*' : $mineCount;
   }

   /**
    * adds up if $cell is a '*'
    *
    * @param int $sum
    * @param string $cell
    *
    * @return value
    */
   public function addMines(int $sum, string $cell)
   {
       return $sum += ($cell == '*') ? 1 : 0;
   }
}
