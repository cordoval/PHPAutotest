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
    protected $grid = array();

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
            $parseDotInto0 = function ($cell) { if($cell == '.') { return '0'; } else { return '*'; }  };
            $row = array_map($parseDotInto0, $row);
            $this->grid[$key] = $row;
        }
    }

    /**
     * @When /^I run filter with neighbor awareness$/
     */
    public function iRunFilterWithNeighborAwareness()
    {
        foreach ($this->grid as $key => $row) {
            $parseDotInto0 = function ($cell) { if($cell == '.') { return '0'; } else { return '*'; }  };

            $findNeighbors = function ($grid, $x, $y) {
              $coords = array(
                  '0' => array(-1,-1),
                  '1' => array(-1, 1),
                  '2' => array(-1, 1),
                  '3' => array( 0,-1),
                  '4' => array( 0, 1),
                  '5' => array( 1,-1),
                  '6' => array( 1, 0),
                  '7' => array( 1, 1),
              );

              $callbackCoords = function ($c) use ($grid, $x, $y) {
                  return $grid[$y + $c[2]][$x + $c[1]];
              };

              return array_map( $callbackCoords , $coords );
            };
            $row = array_map($parseDotInto0, $row);
            $this->grid[$key] = $row;
        }
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
