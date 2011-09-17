<?php
namespace MineSweeper;

interface ReducerInterface
{
   function reduce(array $grid, int $x, int $y);
}
