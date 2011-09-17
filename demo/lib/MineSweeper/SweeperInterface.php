<?php
namespace MineSweeper;

use MineSweeper\ReducerInterface;

interface SweeperInterface
{
    function __construct(ReducerInterface $reducer)
    function sweep(array $grid);
}
