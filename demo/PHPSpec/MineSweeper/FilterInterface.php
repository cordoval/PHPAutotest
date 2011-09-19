<?php
namespace MineSweeper;

interface FilterInterface
{
    /**
     * find neighbors of a cell in $x,$y position within a $grid array
     *
     * @param array $grid
     * @param int $x
     * @param int $y
     *
     * @return array
     */
    function process(array $grid, $x, $y);

}
