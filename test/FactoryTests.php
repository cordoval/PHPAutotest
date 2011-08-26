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

require_once ('Hamcrest/hamcrest.php');

class FactoryTests extends \PHPUnit_Framework_TestCase {
  /**
   * @test
   */
  public function creates_PHPUnitAutotest_instances() {
    $file = realpath(__DIR__) . '/dummy/ChuChuTest.php';
    $at = Autotest\Factory::create($file, "phpunit");
    assertThat($at, anInstanceOf('Autotest\PHPUnitAutotest'));
  }

  /**
   * @test
   */
  public function creates_PHPSpecAutotest_instances() {
    $file = realpath(__DIR__) . '/dummy/ChuChuSpec.php';
    $at = Autotest\Factory::create($file, 'phpspec');
    assertThat($at, anInstanceOf('Autotest\PHPSpecAutotest'));
  }

  /**
   * @test
   */
  public function creates_BehatAutotest_instances() {
    $file = realpath(__DIR__) . '/dummy/ChuChu.feature';
    $at = Autotest\Factory::create($file, 'behat');
    assertThat($at, anInstanceOf('Autotest\BehatAutotest'));
  }

  /**
   * @test
   */
  public function autodetects_framework_for_PHPUnit_test_files() {
    $file = realpath(__DIR__) . '/dummy/ChuChuTest.php';
    $at = Autotest\Factory::create($file);
    assertThat($at, anInstanceOf('Autotest\PHPUnitAutotest'));
  }

  /**
   * @test
   */
  public function autodetects_framework_for_PHPSpec_test_files() {
    $file = realpath(__DIR__) . '/dummy/ChuChuSpec.php';
    $at = Autotest\Factory::create($file);
    assertThat($at, anInstanceOf('Autotest\PHPSpecAutotest'));
  }

  /**
   * @test
   */
  public function autodetects_framework_for_Behat_test_files() {
    $file = realpath(__DIR__) . '/dummy/ChuChu.feature';
    $at = Autotest\Factory::create($file);
    assertThat($at, anInstanceOf('Autotest\BehatAutotest'));
  }
}