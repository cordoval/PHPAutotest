<?php

require_once 'bootstrap.php';

use MineSweeper\Reducer;
use \Mockery as m;

class DescribeReducer extends \PHPSpec\Context
{
    function itReducesA3x3StencilOnXYGridIntoAMineOrANumber()
    {
        $grid = array(
            array('*', '.', '.'),
            array('.', '.', '.'),
            array('.', '.', '*'),
        );
        $x = 1;
        $y = 1;

        $stencilReducer = $this->spec(new Reducer());

        $stencilReducer->reduce($grid, $x, $y)->should->be(2);
    }
}