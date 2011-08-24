#!/usr/bin/php
<?php
/*
 * This version of autotest.php is geared towards the usage
 * with phpspec (see phpspec.net)
 * The second step is to turn this script now php into
 * a Symfony2 Command
 */

require_once 'lib/Autotest/Factory.php';

checkArguments($argv);

$autotest = Autotest\Factory::create($argv[1], $argv[2]);
while (true) {
    $autotest->executeTest();
    while (!$autotest->canRetry()) {
        // we wait while prompting for retry key press
    }
}

function checkArguments($argv) {
    if (count($argv) != 3) {
        printUsage();
        die();
    }
}

function printUsage() {
    echo <<<EOT
   
Error: Wrong argument count

Usage: autotest <phpunit|phpspec|behat> <file>


EOT;
}

