<?php

namespace Autotest\Demo;

require "SomeClass.php";

class DescribeSomeClass extends \PHPSpec\Context {

    private $someObject = null;

    public function before() {
        $this->someObject = $this->spec(new SomeClass());
    }

    public function itShouldReturnTrue() {
        $this->someObject->someMethod()->should->equal(true);
    }

}