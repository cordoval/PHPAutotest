<?php

require_once 'bootstrap.php';

use MineSweeper\Sweeper;

class DescribeSweeper extends \PHPSpec\Context
{
    function itSweepsAMineFieldRevealingMines()
    {
        $reducerMock = \Mock();
        reduce($grid, $x, $y);

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
        $mineSweeper->sweep($grid)->should->be($gridResult);
    }
}