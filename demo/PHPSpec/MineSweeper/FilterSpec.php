<?php

require_once 'bootstrap.php';

use MineSweeper\Filter;

class DescribeFilter extends \PHPSpec\Context
{
    public $x;
    public $y;
    public $grid;
    public $neighborFilter;

    function beforeAll()
    {
        $this->grid = array(
            array('*', '.', '.'),
            array('.', '.', '.'),
            array('.', '.', '*'),
        );

        $this->neighborFilter = $this->spec(new Filter());
    }

    function itFiltersA3x3StencilOnXYGridIntoANeighborsVector()
    {
        $this->x = 1;
        $this->y = 1;
        
        $this->neighborFilter->process($this->grid, $this->x, $this->y)->should->be(
            array('*','.','.','.','.','.','.','*')
        );
    }

}