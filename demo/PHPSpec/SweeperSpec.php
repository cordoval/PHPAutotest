<?php

require_once __DIR__ . '/../../demo/PHPSpec/Sweeper.php';

use MineSweeper\Sweeper;

class DescribeSweeper extends \PHPSpec\Context
{
    function itSweepsAMineFieldRevealingMines()
    {
        $mineSweeper = $this->spec(new Sweeper());
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