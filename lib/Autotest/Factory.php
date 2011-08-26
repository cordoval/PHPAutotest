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

use Autotest\PHPUnitAutotest;
use Autotest\PHPSpecAutotest;
use Autotest\BehatAutotest;

class Factory {
  const PHPUNIT = "phpunit";
  const PHPSPEC = "phpspec";
  const BEHAT = "behat";

  public static function create($file, $framework = null) {
    if (null == $framework)
      $framework = self::detectFramework($file);

    switch ($framework) {
      case Factory::PHPUNIT:
        return new PHPUnitAutotest($file);
      case Factory::PHPSPEC:
        return new PHPSpecAutotest($file);
      case Factory::BEHAT:
        return new BehatAutotest($file);
    }
    throw new \Exception("Wrong framework");

    return true;
  }

  private static function detectFramework($file) {
    if (self::isPHPUnit($file))
      return self::PHPUNIT;
    if (self::isPHPSpec($file))
      return self::PHPSPEC;
    if (self::isBehat($file))
      return self::BEHAT;
    throw new \Exception('Can\'t detect framework');
  }

  private static function isBehat($file) {
    return preg_match('/\.feature$/i', $file);
  }

  private static function isPHPUnit($file) {
    return strpos($file, 'Test') !== false;
  }

  private static function isPHPSpec($file) {
    return strpos($file, 'Spec') !== false;
  }
}