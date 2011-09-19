<?php

require_once 'bootstrap.php';

use MineSweeper\Sweeper;

class DescribeSweeper extends \PHPSpec\Context
{
    function itSweepsAMineFieldRevealingMines()
    {
        $reducerMock = \Mockery::mock('reducer object', 'alias:MineSweeper\ReducerInterface');
        $reducerMock->shouldReceive('reduce')->withAnyArgs()->andReturn('x');

        $mineSweeper = $this->spec(new Sweeper($reducerMock));
        $grid = array(
            array('*', '.', '.'),
            array('.', '.', '.'),
            array('.', '.', '*'),
        );
        $gridResult = array(
            array('*', '1', '0'),
            array('1', '2', '1'),
            array('0', '1', '*'),
        );
        $gridMockResult = array(
            array('x', 'x', 'x'),
            array('x', 'x', 'x'),
            array('x', 'x', 'x'),
        );
        $mineSweeper->sweep($grid)->should->be($gridMockResult);
    }
}