<?php

require_once(__dir__ . "/../vendor/autoload.php");

abstract class TestCase extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }
}