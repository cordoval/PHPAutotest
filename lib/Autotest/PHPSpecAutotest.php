<?php

namespace Autotest;

require_once 'Autotest.php';

class PHPSpecAutotest extends Autotest {

    public function executeTest() {
        $this->clearScreen();
        $output = shell_exec("phpspec {$this->file} -c");
        $this->renderOutput($output);
        $this->notifyResult($output);
    }

    private function renderOutput($output) {
        echo "{$output}\n\n";
    }

    private function notifyResult($output) {
        $lines = explode("\n", $output);
        $command = $this->notifyCommandFactory($this->hasFailed($lines));
        exec($command);
    }

    private function hasFailed($lines) {
        return strpos($lines[sizeof($lines) - 2], 'failure') !== false;
    }

}

?>
