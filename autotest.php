#!/usr/bin/php
<?php
/*
 * This version of autotest.php is geared towards the usage
 * with phpspec (see phpspec.net)
 * The second step is to turn this script now php into
 * a Symfony2 Command
 */

require_once 'lib/Autotest.php';

checkArguments($argv);

$autotest = new Autotest($argv[1]);
while (true) {
    $autotest->executeTest();
    while (!$autotest->canRetry()) {
        // we wait while prompting for retry key press
    }
}

function checkArguments($argv) {
    if (count($argv) != 2)
        throw new Exception("You need to provide an argument with the file you want to test");
}
?>
