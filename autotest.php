#!/usr/bin/php
<?php
/*
 * This version of autotest.php is geared towards the usage
 * with phpspec (see phpspec.net)
 * The second step is to turn this script now php into
 * a Symfony2 Command
 */

$classFile = 'NewBowlingGameSpec.php';
$class = 'NewBowlingGameSpec.php';
$test = $class;

$iconPass = '/usr/share/icons/Humanity/actions/48/dialog-apply.svg';
$iconFail = '/usr/share/icons/Humanity/emblems/48/emblem-important.svg';
$titlePass = 'Test Pass';
$titleFail = 'Test Fail';
$messagePass= 'Passing Spec';
$messageFail = 'Failing Spec';

while (true) {

    $text = '';
    exec("inotifywait -q -e modify ${class}", $text);
    $text = '';
    exec("phpspec ${test} -c", $text);
    // serach on $output_text if last line has failure word
    // get last sentence
    $fail = $text[sizeof($text)-1];
    preg_match('/^failure/', $fail, $matches);
    print_r($matches);
    $output_text = trim(implode("\n", $text));
    echo $output_text."\n\n";
    //$strCommand = "phpspec ${test} | tail -n1 | grep \"failure\"";
    if ( $fail ) {
        $strCommand = buildNotifyCommand($iconFail, $titleFail, $messageFail);
    } else {
        $strCommand = buildNotifyCommand($iconPass, $titlePass, $messagePass);
    }
    exec($strCommand, $text);
}

function buildNotifyCommand($icon, $title, $message) {
    return "notify-send --hint=string:x-canonical-private-synchronous: -i \"${icon}\" \"${title}\" \"${message}\"";
}
?>
