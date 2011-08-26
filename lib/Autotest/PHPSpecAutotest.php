<?php
/*
 * This file is part of PHPAutotest
 *
 * (c) Guillermo Gutiérrez Almazor <guille@ggalmazor.com>
 * (c) Luis Cordoval <cordoval@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Autotest;

class PHPSpecAutotest extends Autotest {

  public function executeTest() {
    $this->clearScreen();
    $output = shell_exec("phpspec {$this->file} -c");
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
    return strpos($lines[sizeof($lines) - 2], 'failure') !== false;
  }

}