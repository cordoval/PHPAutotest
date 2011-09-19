<?php

require_once __DIR__ . '/../../bootstrap.php';

use MineSweeper\Sweeper;
use MineSweeper\Reducer;
use MineSweeper\Filter;
use MineSweeper\Stenciler;

define("PHPSPEC_INTEGRATION", true);

class DescribeSweeper extends \PHPSpec\Context
{
    function itSweepsAMineFieldRevealingMines()
    {
        if (PHPSPEC_INTEGRATION) {
            $stenciler  = new Stenciler();
            $stencilFilter = new Filter($stenciler);
            $reducer = new Reducer($stencilFilter);
        } else {
            $reducerMock = \Mockery::mock('reducer object', 'alias:MineSweeper\ReducerInterface');
            $reducerMock->shouldReceive('reduce')->withAnyArgs()->andReturn('x');
            $reducer = $reducerMock;
        }

        $mineSweeper = $this->spec(new Sweeper($reducer));

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

        if (PHPSPEC_INTEGRATION) {
            $gridResult = $gridResult;
        } else {
            $gridResult = $gridMockResult;
        }

        $mineSweeper->sweep($grid)->should->be($gridResult);
    }
}