<?php

//require_once __DIR__ . '/../../demo/lib/MineSweeper/MineField.php';
require_once __DIR__ . '/../../demo/PHPSpec/MineField.php';

use MineSweeper\MineField;

class DescribeMineField extends \PHPSpec\Context
{
    function itSweepsAMineFieldRevealingMines()
    {
        $mineField = $this->spec(new MineField);
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
        $mineField->gridSweep($grid)->should->be($gridResult);
    }
}