<?php

namespace MineSweeper;

class MineField
{

    protected $stenciler;
    protected $masker;
    protected $reducer;
    protected $sweeper;

public __construct(StencilerInterface $stenciler, MaskerInterface $masker, ReducerInterface $reducer, SweeperInterface $sweeper)
{
    $this->stenciler = $stenciler;
    $this->masker = $masker;
    $this->reducer = $reducer;
    $this->sweeper = $seeper;
}

$stencil = array(
    '0' => array(-1, -1),
    '1' => array(-1, 0),
    '2' => array(-1, 1),
    '3' => array(0, -1),
    '4' => array(0, 1),
    '5' => array(1, -1),
    '6' => array(1, 0),
    '7' => array(1, 1),
);

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

/**
 * returns converted grid with each cell mines count
 */
$gridSweeper = function($grid) use ($mineCountPerCell)
{
    for ($y = 0; $y < sizeof(array_keys($grid)); $y++) {
        $row = null;
        for ($x = 0; $x < sizeof($grid[0]); $x++) {
            $row[] = $mineCountPerCell($grid, $x, $y);
        }
        $grid_converted[] = $row;
    }
    return $grid_converted;
};

}