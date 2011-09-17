<?php
namespace MineSweeper;

interface FilterInterface
{
    function process(array $grid, int $x, int $y);
}
