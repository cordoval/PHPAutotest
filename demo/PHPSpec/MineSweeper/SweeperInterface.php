<?php
namespace MineSweeper;

interface SweeperInterface
{
    /**
     * sweeps over the 2d grid mine field
     *
     * @param array $grid
     * @return array
     */
    function sweep(array $grid);
}
