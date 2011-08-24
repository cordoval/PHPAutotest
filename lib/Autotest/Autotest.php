<?php

namespace Autotest;

abstract class Autotest {
    const ICON_PASS = '/usr/share/icons/Humanity/actions/48/dialog-apply.svg';
    const ICON_FAIL = '/usr/share/icons/Humanity/emblems/48/emblem-important.svg';
    const TITLE_PASS = 'Test Pass';
    const TITLE_FAIL = 'Test Fail';
    const MESSAGE_PASS = 'Passing Spec';
    const MESSAGE_FAIL = 'Failing Spec';

    const NOTIFY_COMMAND_TEMPLATE = 'notify-send --hint=string:x-canonical-private-synchronous: -i "%s" "%s" "%s"';
    const FILEMTIME_COMMAND_TEMPLATE_LINUX = 'ls -l --full-time %s 2> /dev/null | awk \'{print $7}\'';
    const FILEMTIME_COMMAND_TEMPLATE_OSX = 'ls -lT %s 2> /dev/null | awk \'{print $8}\'';

    protected $file;
    private $fileMTime;

    public function __construct($file) {
        $this->checkFile($file);
        $this->file = $file;
        $this->fileMTime = $this->getFileMTime();
    }

    protected function clearScreen() {
        system('bash -c "clear"');
    }

    public function canRetry() {
        return $this->fileChanged() || $this->retryKeyPressed();
    }
    
    abstract public function executeTest();

    abstract protected function renderOutput($output);

    abstract protected function notifyResult($output);

    abstract protected function hasFailed($lines);

    private function checkFile($file) {
        if (!file_exists($file) || !is_readable($file))
            throw new \Exception("{$file} doesn't exist or is not readable");
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
        $keystroke = exec('bash -c "read -p\".\" -s -t1 -n1 keystroke ; echo \$keystroke"');
        $keystroke = trim(str_replace("\n", "", $keystroke));
        return 'r' == $keystroke;
    }

    protected function notifyCommandFactory($hasFailed) {
        if ($hasFailed)
            return sprintf(Autotest::NOTIFY_COMMAND_TEMPLATE, Autotest::ICON_FAIL, Autotest::TITLE_FAIL, Autotest::MESSAGE_FAIL);
        return sprintf(Autotest::NOTIFY_COMMAND_TEMPLATE, Autotest::ICON_PASS, Autotest::TITLE_PASS, Autotest::MESSAGE_PASS);
    }

    private function getFileMTime() {
        $command = sprintf($this->getFileMTimeCommandFactoryFor($this->getSystem()), $this->file);
        return exec($command);
    }

    private function getFileMTimeCommandFactoryFor($os) {
        switch ($os) {
            case 'linux':
                return Autotest::FILEMTIME_COMMAND_TEMPLATE_LINUX;
            case 'osx':
                return Autotest::FILEMTIME_COMMAND_TEMPLATE_OSX;
        }
    }

    private function getSystem() {
        return strtolower(PHP_OS);
    }

}