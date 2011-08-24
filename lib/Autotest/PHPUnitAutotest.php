<?php

namespace Autotest;

require_once 'Autotest.php';

class PHPUnitAutotest extends Autotest {

    public function executeTest() {
        $this->clearScreen();
        $output = shell_exec("phpunit --colors {$this->file}");
        $this->renderOutput($output);
        $this->notifyResult($output);
    }

    private function renderOutput($output) {
        echo "{$output}\n\n";
    }

    private function notifyResult($output) {
        $lines = explode("\n", $output);
        $hasFailed = $this->hasFailed($lines);
        $command = $this->notifyCommandFactory($hasFailed);
        exec($command);
    }

    private function hasFailed($lines) {
        return strpos($lines[sizeof($lines) - 3], 'FAILURES') !== false;
    }

}

?>
