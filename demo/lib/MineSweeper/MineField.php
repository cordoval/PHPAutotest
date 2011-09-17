<?php

namespace MineSweeper;

class MineField
{
    protected $sweeper;

    public function __construct(SweeperInterface $sweeper)
    {
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
}