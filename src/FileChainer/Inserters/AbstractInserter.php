<?php


namespace Prewk\FileChainer\Inserters;

use Prewk\FileChainer\InserterInterface;

abstract class AbstractInserter implements InserterInterface
{
    public static function __callStatic($name, $arguments)
    {
        if ($name === "insert") {
            $name = "_insert";
        }
        return call_user_func_array(array(new static, $name), $arguments);
    }

    public function __call($name, $arguments)
    {
        if ($name === "insert") {
            $name = "_insert";
        }
        return call_user_func_array(array($this, $name), $arguments);
    }
}