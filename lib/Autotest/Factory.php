<?php
namespace Autotest;

require_once 'lib/Autotest/PHPUnitAutotest.php';
require_once 'lib/Autotest/PHPSpecAutotest.php';
require_once 'lib/Autotest/BehatAutotest.php';

use Autotest\PHPUnitAutotest;
use Autotest\PHPSpecAutotest;
use Autotest\BehatAutotest;

class Factory {
    const PHPUNIT = "phpunit";
    const PHPSPEC = "phpspec";
    const BEHAT = "behat";

    public static function create($file) {
        // here we detect:
        //  - *Spec.php
        //  - *Test.php
        //  - *.feature
        //  - or fail gentle
        if (strpos($file, "Spec") !== false) {
            $framework = Factory::PHPSPEC;
        } elseif (strpos($file, "Spec") !== false) {
            $framework = Factory::PHPUNIT;
        } elseif (strpos($file, "feature") !== false) {
            $framework = Factory::BEHAT;
        } else {
            echo <<<EOT

Error: Framework not recognized

Usage: autotest <file>

Notice: File must end up in *Spec.php, *Test.php, or *.feature

EOT;
            return false;
        }

        switch ($framework) {
            case Factory::PHPUNIT:
                return new PHPUnitAutotest($file);
            case Factory::PHPSPEC:
                return new PHPSpecAutotest($file);
            case Factory::BEHAT:
                return new BehatAutotest($file);
        }
        throw new Exception("Wrong framework");

        return true;
    }

}