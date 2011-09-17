<?php
namespace MineSweeper;

class Filter implements FilterInterface
{
    protected $stenciler;

    public function __construct(StencilerInterface $stenciler) {
        $this->stenciler = $stenciler;
    }

    /**
     * find neighbors of a cell in $x,$y position within a $grid array
     *
     * @param array $grid
     * @param int $x
     * @param int $y
     * 
     * @return value
     */
    public function process($grid, $x, $y) {

        // gets the numeral on each neighbor coordinate
        $stencilMasker = function ($c) use ($grid, $x, $y)
        {
            $xPointer = $x + $c[0];
            $yPointer = $y + $c[1];
            $xLimit = sizeof($grid[0]);
            $yLimit = sizeof(array_keys($grid));
            $out = (($xPointer < 0) || ($yPointer < 0) ||
                ($xPointer >= $xLimit) ||
                ($yPointer >= $yLimit)) ? '.' : $grid[$yPointer][$xPointer];
            return $out;
        };

        // map-processes and returns the array of neighbors numerals
        return array_map($stencilMasker, $this->stenciler->getStencil());
   }
}

