<?php
namespace Autotest;

require_once 'lib/Autotest/PHPUnitAutotest.php';
require_once 'lib/Autotest/PHPSpecAutotest.php';

use Autotest\PHPUnitAutotest;
use Autotest\PHPSpecAutotest;

class Factory {
    const PHPUNIT = "phpunit";
    const PHPSPEC = "phpspec";
    const BEHAT = "behat";

    public static function create($framework, $file) {
        switch ($framework) {
            case Factory::PHPUNIT:
                return new PHPUnitAutotest($file);
            case Factory::PHPSPEC:
                return new PHPSpecAutotest($file);
            case Factory::BEHAT:
                throw new Exception("Autotest for Behat is not yet implemented");
        }
        throw new Exception("Wrong framework");
    }

}

?>
