<?php
namespace MineSweeper;

interface SweeperInterface
{
    function __construct(ReducerInterface $reducer);

    function sweep(array $grid);
}
