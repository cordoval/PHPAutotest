<?php

require_once __DIR__ . '/../../bootstrap.php';

use MineSweeper\Reducer;

class DescribeReducer extends \PHPSpec\Context
{
    public $grid;
    public $x;
    public $y;
    public $stencilReducer;

    function beforeAll()
    {
        $this->grid = array(
            array('*', '.', '.'),
            array('.', '.', '.'),
            array('.', '.', '*'),
        );

        $this->filterMock = \Mockery::mock('filter object', 'alias:MineSweeper\FilterInterface');
        $this->filterMock->shouldReceive('process')->withAnyArgs()->andReturn(
            array('*','.','.','.','.','.','.','*')
        );

        $this->stencilReducer = $this->spec(new Reducer($this->filterMock));
    }

    function itReducesA3x3StencilOnXYGridIntoANumberWhenNotAMine()
    {
        $this->x = 1;
        $this->y = 1;

        $this->stencilReducer->reduce($this->grid, $this->x, $this->y)->should->be('2');
    }

    function itReducesA3x3StencilOnXYGridIntoAMineWhenOnAMine()
    {
        $this->x = 0;
        $this->y = 0;

        $this->stencilReducer->reduce($this->grid, $this->x, $this->y)->should->be('*');
    }
}