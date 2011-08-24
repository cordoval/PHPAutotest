<?php

namespace Autotest;

require_once 'Autotest.php';

class BehatAutotest extends Autotest {

    public function executeTest() {
        $this->clearScreen();
        $output = shell_exec("behat {$this->file} --colors");
        $this->renderOutput($output);
        $this->notifyResult($output);
    }

    protected function renderOutput($output) {
        echo "{$output}\n\n";
    }

    protected function notifyResult($output) {
        $lines = explode("\n", $output);
        $command = $this->notifyCommandFactory($this->hasFailed($lines));
        exec($command);
    }

    protected function hasFailed($lines) {
        return strpos($lines[sizeof($lines) - 3], 'failed') !== false;
    }

}