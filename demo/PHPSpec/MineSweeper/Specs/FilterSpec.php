<?php

require_once __DIR__ . '/../../bootstrap.php';

use MineSweeper\Filter;

class DescribeFilter extends \PHPSpec\Context
{
    public $x;
    public $y;
    public $grid;
    public $neighborFilter;
    public $stencilerMock;

    function beforeAll()
    {
        $this->grid = array(
            array('*', '.', '.'),
            array('.', '.', '.'),
            array('.', '.', '*'),
        );

        $this->stencilerMock = \Mockery::mock('stenciler object', 'alias:MineSweeper\StencilerInterface');
        $this->stencilerMock->shouldReceive('getStencil')->withNoArgs()->andReturn(
            array(
                '0' => array(-1, -1),
                '1' => array(-1, 0),
                '2' => array(-1, 1),
                '3' => array(0, -1),
                '4' => array(0, 1),
                '5' => array(1, -1),
                '6' => array(1, 0),
                '7' => array(1, 1),
            )
        );

        $this->neighborFilter = $this->spec(new Filter($this->stencilerMock));
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