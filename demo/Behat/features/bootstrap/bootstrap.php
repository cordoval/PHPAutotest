<?php

//set_include_path(get_include_path() . PATH_SEPARATOR . realpath(dirname(__FILE__) . '/../../../lib/MineSweeper'));

if (!class_exists('Behat\Behat\ClassLoader\UniversalClassLoader')) {
    require_once __DIR__ . '/../../../../../../vendor/behat/Behat/src/Behat/Behat/ClassLoader/UniversalClassLoader.php';
}
use Behat\Behat\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    'MineSweeper' => __DIR__ . '/../../../../../../vendor/PHPAutotest/demo/lib',
));
$loader->register();
