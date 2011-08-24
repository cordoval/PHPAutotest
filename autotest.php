#!/usr/bin/php
<?php
/*
 * This version of autotest.php is geared towards the usage
 * with phpspec (see phpspec.net)
 * The second step is to turn this script now php into
 * a Symfony2 Command
 */

$autotest = new Autotest("NewBowlingGameSpec.php");

while (true) {
    $autotest->executeTest();
    while (!$autotest->canRetry()) {
        // we wait while prompting for retry key press
    }
}

class Autotest {
    const ICON_PASS = '/usr/share/icons/Humanity/actions/48/dialog-apply.svg';
    const ICON_FAIL = '/usr/share/icons/Humanity/emblems/48/emblem-important.svg';
    const TITLE_PASS = 'Test Pass';
    const TITLE_FAIL = 'Test Fail';
    const MESSAGE_PASS = 'Passing Spec';
    const MESSAGE_FAIL = 'Failing Spec';
    
    const NOTIFY_COMMAND_TEMPLATE = 'notify-send --hint=string:x-canonical-private-synchronous: -i "%s" "%s" "%s"';
    const FILEMTIME_COMMAND_LINUX = 'ls -l --full-time %s 2> /dev/null | awk \'{print $7}\'';
    const FILEMTIME_COMMAND_OSX = 'ls -lT %s 2> /dev/null | awk \'{print $8}\'';
    
    private $file;
    private $fileMTime;
    
    public function __construct($file) {
        $this->file = $file;
        $this->fileMTime = $this->getFileMTime();
    }

    public function executeTest() {
        $this->clearScreen();
        $output = shell_exec("phpspec {$this->file} -c");
        $this->renderOutput($output);
        $this->notifyResult($output);
    }
    
    public function canRetry() {
        return $this->fileChanged() || $this->retryKeyPressed();
    }
    
    private function fileChanged() {
        $newFileMTime = $this->getFileMTime($this->file);
        if ($newFileMTime != $this->fileMTime) {
            $this->fileMTime = $newFileMTime;
            return true;
        }
        return false;
    }

    private function retryKeyPressed() {
        $keystroke = shell_exec('bash scripts/readchar');
        $keystroke = trim(str_replace("\n", "", $keystroke));
        return 'r' == $keystroke;
    }
    
    private function clearScreen() {
        system('bash scripts/clear');
    }
    
    private function renderOutput($output) {
        echo "{$output}\n\n";
    }
    
    private function notifyResult($output) {
        $lines = explode("\n", $output);
        $command = $this->notifyCommandFactory($this->hasFailed($lines));
        exec($command);
    }
    
    private function notifyCommandFactory($hasFailed) {
        if ($hasFailed)
            return sprintf(Autotest::NOTIFY_COMMAND_TEMPLATE, Autotest::ICON_FAIL, Autotest::TITLE_FAIL, Autotest::MESSAGE_FAIL);
        return sprintf(Autotest::NOTIFY_COMMAND_TEMPLATE, Autotest::ICON_PASS, Autotest::TITLE_PASS, Autotest::MESSAGE_PASS);
    }
    
    private function hasFailed($lines) {
        return strpos($lines[sizeof($lines) - 2], 'failure') !== false;
    }

    private function getFileMTime() {
        $command = sprintf($this->getFileMTimeCommandFactoryFor($this->getSystem()), $this->file);
        return exec($command);
    }

    private function getFileMTimeCommandFactoryFor($os) {
        switch ($os) {
            case 'linux':
                return Autotest::FILEMTIME_COMMAND_LINUX;
            case 'osx':
                return Autotest::FILEMTIME_COMMAND_OSX;
        }
    }

    private function getSystem() {
        return strtolower(PHP_OS);
    }

}
?>
