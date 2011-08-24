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

$fileMTime = getFileMTime($test);

$iconPass = '/usr/share/icons/Humanity/actions/48/dialog-apply.svg';
$iconFail = '/usr/share/icons/Humanity/emblems/48/emblem-important.svg';
$titlePass = 'Test Pass';
$titleFail = 'Test Fail';
$messagePass = 'Passing Spec';
$messageFail = 'Failing Spec';

while (true) {
    $output = shell_exec("phpspec ${test} -c");
    echo "${output}\n\n";
    $lines = explode("\n", $output);
    if (strpos(array_pop($lines), 'failure') !== false) {
        $strCommand = buildNotifyCommand($iconFail, $titleFail, $messageFail);
    } else {
        $strCommand = buildNotifyCommand($iconPass, $titlePass, $messagePass);
    }
    exec($strCommand, $text);
//    watchForKeypress();
//    waitForFileChange();
    sleep(1);

    $output_text = trim(implode("\n", $text));
    echo $output_text."\n\n";
    //$strCommand = "phpspec ${test} | tail -n1 | grep \"failure\"";
    if ( $fail ) {

}

function buildNotifyCommand($icon, $title, $message) {
    return "notify-send --hint=string:x-canonical-private-synchronous: -i \"${icon}\" \"${title}\" \"${message}\"";
}

function watchForKeypress() {
    readline_callback_handler_install('Press \'r\' key to launch it again', 'execute');
}

function waitForFileChange($file) {
    $command = getFileMTimeCommand($file);
    do {
        $currentFileMTime = getFileMTime($file);
        echo ".";
        sleep(1);
    } while ($currentFileMTime != $fileMTime);
    $fileMTime = $currentFileMTime;
}

function getFileMTime($file) {
    return exec(sprintf(getFileMTimeCommandTemplate($file), $file));
}

function getFileMTimeCommandTemplate($file) {
    switch (getSystem()) {
        case 'linux': 
            return "ls -l --full-time %s 2> /dev/null | awk '{print $7}'";
            break;
        case 'osx': 
            return "ls -lT %s 2> /dev/null | awk '{print $8}'";
            break;
    }
}

function getSystem() {
    return strtolower(PHP_OS);
}

?>
