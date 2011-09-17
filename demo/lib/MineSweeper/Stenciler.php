<?php
namespace MineSweeper;

class Stenciler implements StencilerInterface
{
    /**
     * @var array
     */
    protected $stencil = array(
        '0' => array(-1, -1),
        '1' => array(-1, 0),
        '2' => array(-1, 1),
        '3' => array(0, -1),
        '4' => array(0, 1),
        '5' => array(1, -1),
        '6' => array(1, 0),
        '7' => array(1, 1),
    );

    /**
     * gets stencil
     * 
     * @return array
     */
    public function getStencil() {
        return $this->stencil;
   }
}
