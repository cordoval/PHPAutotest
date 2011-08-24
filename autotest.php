#!/bin/php
<?php
/*
 * This version of autotest.php is geared towards the usage
 * with phpspec (see phpspec.net)
 * The second step is to turn this script now php into
 * a Symfony2 Command
 *
 *
 */

$classFile = "ExampleSpec.php"

$iconPass = "/usr/share/icons/Humanity/actions/48/dialog-apply.svg";
$iconFail = "/usr/share/icons/Humanity/emblems/48/emblem-important.svg";
$titlePass = "Test Pass";
$titleFail = "Test Fail";
$messagePass= "Passing Spec";
$messageFail = "Failing Spec";

while (true) {
    exec('inotifywait -q -e modify '.$class);
    if ( exec($test." | tail -n2 | grep \"OK\"") ) {
        exec('notify-send --hint=string:x-canonical-private-synchronous: -i '.$iconPass.' '.$titlePass.' '.$messagePass);
    } else {
        exec('notify-send --hint=string:x-canonical-private-synchronous: -i '.$iconFail.' '.$titleFail.' '.$messageFail);
    }
}
?>