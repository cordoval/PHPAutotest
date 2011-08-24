<?php

require 'SomeClass.php';

class SomeClassTests extends \PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    public function some_method_returns_true() {
        $someObject = new SomeClass();
        $this->assertEquals(true, $someObject->someMethod());
    }

}
