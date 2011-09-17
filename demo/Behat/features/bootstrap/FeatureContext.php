<?php

use Behat\Behat\Context\ClosuredContextInterface,
Behat\Behat\Context\TranslatedContextInterface,
Behat\Behat\Context\BehatContext,
Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
Behat\Gherkin\Node\TableNode;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureContext extends BehatContext
{
    protected $grid;

    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param   array   $parameters     context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        // Initialize your context here
        $this->grid = null;
    }

//
// Place your definition and hook methods here:
//
//    /**
//     * @Given /^I have done something with "([^"]*)"$/
//     */
//    public function iHaveDoneSomethingWith($argument)
//    {
//        doSomethingWith($argument);
//    }
//

    /**
     * @Given /^I pass a grid:$/
     */
    public function iPassAGrid(TableNode $table)
    {
        $hash = $table->getRows();
        foreach ($hash as $key => $row) {
            $this->grid[$key] = $row;
        }
    }

    /**
     * @When /^I run filter$/
     */
    public function iRunFilter()
    {
        foreach ($this->grid as $key => $row) {
            $parseDotInto0 = function ($cell)
            {
                if ($cell == '.') {
                    return '0';
                } else {
                    return '*';
                }
            };
            $row = array_map($parseDotInto0, $row);
            $this->grid[$key] = $row;
        }
    }

    /**
     * @When /^I run filter with neighbor awareness$/
     */
    public function iRunFilterWithNeighborAwareness()
    {

        $coords = array(
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
         * find neighbors of a cell in $x,$y position within a $grid array
         */
        $findNeighborsPerCell = function ($grid, $x, $y) use ($coords)
        {

            // gets the numeral on each neighbor coordinate
            $callbackCoords = function ($c) use ($grid, $x, $y)
            {
                $xPointer = $x + $c[0] ;
                $yPointer = $y + $c[1] ;
                $xLimit = sizeof($grid[0]);
                $yLimit = sizeof(array_keys($grid));
                $out = (($xPointer < 0) || ($yPointer < 0) ||
                        ($xPointer >= $xLimit) ||
                        ($yPointer >= $yLimit) ) ? '.' : $grid[$yPointer][$xPointer] ;
                return $out;
            };

            // map-processes and returns the array of neighbors numerals
            return array_map($callbackCoords, $coords);

        };

        /**
         * returns the total mines per neighbor per grid (grid) for a cell in $x,$y position
         */
        $mineCountPerCell = function ($grid, $x, $y) use ($findNeighborsPerCell)
        {

            // adds up if $cell is a '*'
            $addMines = function ($sum, $cell)
            {
                return $sum += ($cell == '*') ? 1 : 0;
            };

            // count neighbors that are mines
            $mineCount = array_reduce($findNeighborsPerCell($grid, $x, $y), $addMines);

            // if current position is a mine just output a mine
            return ($grid[$y][$x] == "*") ? '*' : $mineCount;
        };

        /**
         * returns converted grid with each cell mines count
         */
        $gridConverter = function($grid) use ($mineCountPerCell)
        {
            // returns the grid with counts
            $countGrid = function ($grid) use ($mineCountPerCell)
            {
                for ($y = 0; $y < sizeof(array_keys($grid)); $y++) {
                    $row = null;
                    for ($x = 0; $x < sizeof($grid[0]); $x++) {
                        $row[] = $mineCountPerCell($grid, $x, $y);
                    }
                    $grid_converted[] = $row;
                }
                return $grid_converted;
            };
            
            return $countGrid($grid);
        };

        $this->grid = $gridConverter($this->grid);
    }


    /**
     * @Then /^I should get:$/
     */
    public function iShouldGet(TableNode $table)
    {
        $hash = $table->getRows();
        foreach ($hash as $key => $row) {
            if ($this->grid[$key] != $row) {
                throw new Exception(
                    "Actual output is:\n" . print_r($this->grid, true)
                );
            }
        }
    }

}
