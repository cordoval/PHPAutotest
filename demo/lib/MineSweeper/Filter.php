<?php
namespace MineSweeper;

class Filter implements FilterInterface
{
    protected $stenciler;

    protected $x;
    protected $y;
    protected $grid;

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
        $this->x = $x;
        $this->y = $y;
        $this->grid = $grid;

        // map-processes and returns the array of neighbors numerals
        return array_map(array($this, 'stencilMask'), $this->stenciler->getStencil());
    }

    /**
     * gets the numeral on each neighbor coordinate
     *
     * @param int $c
     *
     * @return value
     */
    public function stencilMask(int $c)
    {
        $xPointer = $this->x + $c[0];
        $yPointer = $this->y + $c[1];
        $xLimit = sizeof($this->grid[0]);
        $yLimit = sizeof(array_keys($this->grid));
        $out = (($xPointer < 0) || ($yPointer < 0) ||
            ($xPointer >= $xLimit) ||
            ($yPointer >= $yLimit)) ? '.' : $this->grid[$yPointer][$xPointer];
        return $out;
   }
}

