#!/usr/bin/php
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

include('bootstrap.php');

list($file, $framework) = parseArguments($argv);

try {
  $autotest = Autotest\Factory::create($file, $framework);
} catch (\Exception $e) {
  die(printUsage($e->getMessage()));
}

while (true && $autotest) {
  $autotest->executeTest();
  while (!$autotest->canRetry()) {
    // we wait while prompting for retry key press
  }
}

function parseArguments($args) {
  if (3 == count($args))
    return array($args[2], $args[1]);
  if (2 == count($args))
    return array($args[1], null);
  die(printUsage("Wrong argument count"));
}

function printUsage($error) {
  return <<<EOT

    {$error}

    Usage:

    autotest <file/path>

    or

    autotest <phpunit|phpspec|behat> <file/path>


EOT;
}

