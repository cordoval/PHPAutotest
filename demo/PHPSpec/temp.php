<?php

function cube($n){
    return $n * $n * $n;
}

class MyClass {
    private $data;

    public function __construct(){
        $this->data = array(1,3,5,7,9);
    }

    public function filteredDataByClosure(){
        return array_map(function($cell) {return $cell * $cell; }, $this->data);
    }

    public function filteredDataByGlobalFunction(){
        return array_map('cube', $this->data);
    }

    public function filteredDataByStaticMethod(){
        return array_map(array('MyClass', 'minusOne'), $this->data);
    }

    public function filteredDataByMethod(){
        return array_map(array($this, 'plusOne'), $this->data);
    }

    public static function minusOne($n){
        return --$n;
    }

    public function plusOne($n){
        return ++$n;
    }
}

$mc = new MyClass();
var_dump($mc->filteredDataByClosure());
echo "<br />";
var_dump($mc->filteredDataByGlobalFunction());
echo "<br />";
var_dump($mc->filteredDataByStaticMethod());
echo "<br />";
var_dump($mc->filteredDataByMethod());
echo "<br />";