<?php
/**
 * @author Oskar Thornblad <oskar.thornblad@gmail.com>
 */

namespace Prewk\FileChainer\Inserters;

use Prewk\FileChainer\InserterInterface;

/**
 * Abstract inserter class to allow both static and class method access with magic methods
 */
abstract class AbstractInserter implements InserterInterface
{
    /**
     * Magic static call method
     *
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        if ($name === "insert") {
            $name = "_insert";
        }
        return call_user_func_array([new static, $name], $arguments);
    }

    /**
     * Magic class call method
     *
     * @param      $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if ($name === "insert") {
            $name = "_insert";
        }
        return call_user_func_array([$this, $name], $arguments);
    }
}