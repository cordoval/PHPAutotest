#!/usr/bin/php
<?php
/*
 * This version of autotest.php is geared towards the usage
 * with phpspec (see phpspec.net)
 * The second step is to turn this script now php into
 * a Symfony2 Command
 */

require_once 'lib/Autotest.php';

$autotest = new Autotest("NewBowlingGameSpec.php");

while (true) {
    $autotest->executeTest();
    while (!$autotest->canRetry()) {
        // we wait while prompting for retry key press
    }
}


?>
