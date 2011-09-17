<?php

namespace MineSweeper;

class MineField
{

    protected $stenciler;
    protected $masker;
    protected $reducer;
    protected $sweeper;

    public function __construct(StencilerInterface $stenciler, MaskerInterface $masker, ReducerInterface $reducer, SweeperInterface $sweeper)
    {
        $this->stenciler = $stenciler;
        $this->masker = $masker;
        $this->reducer = $reducer;
        $this->sweeper = $sweeper;
    }

    /**
     * returns converted grid with each cell mines count
     *
     * @param array $grid
     *
     * @return array $grid_converted
     */
    public function gridSweep(array $grid) {
        return $this->sweeper->sweep($grid);
    }




/**
 * find neighbors of a cell in $x,$y position within a $grid array
 */
$findNeighborsPerCell = function ($grid, $x, $y) use ($stencil)
{

    // gets the numeral on each neighbor coordinate
    $stencilMasker = function ($c) use ($grid, $x, $y)
    {
        $xPointer = $x + $c[0];
        $yPointer = $y + $c[1];
        $xLimit = sizeof($grid[0]);
        $yLimit = sizeof(array_keys($grid));
        $out = (($xPointer < 0) || ($yPointer < 0) ||
                ($xPointer >= $xLimit) ||
                ($yPointer >= $yLimit)) ? '.' : $grid[$yPointer][$xPointer];
        return $out;
    };

    // map-processes and returns the array of neighbors numerals
    return array_map($stencilMasker, $stencil);
};

/**
 * returns the total mines per neighbor per grid (grid) for a cell in $x,$y position
 */
$mineCountPerCell = function ($grid, $x, $y) use ($findNeighborsPerCell)
{

    // adds up if $cell is a '*'
    $addMines = function ($sum, $cell)
    {
        return $sum += ($cell == '*') ? 1 : 0;
    };

    // count neighbors that are mines
    $mineCount = array_reduce($findNeighborsPerCell($grid, $x, $y), $addMines);

    // if current position is a mine just output a mine
    return ($grid[$y][$x] == "*") ? '*' : $mineCount;
};


}