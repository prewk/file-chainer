<?php


namespace Prewk;

/**
 * Interface FileChainerInterface
 * @package Prewk
 */
interface FileChainerInterface
{
    /**
     * Get the current resource handle
     * @return resource The file handle
     */
    public function getHandle();

    public function fopen($filename, $mode, $use_include_path = false, $context = null);

    public function fwrite($string, $length = null);

    public function fread($length);

    public function fseek($offset, $whence = SEEK_SET);

    public function fclose();

    public function rewind();

    /**
     * Create a file chainer with the File inserter
     *
     * @return FileChainerInterface
     */
    public static function make();

    /**
     * Insert a string at current file handle position without overwriting
     *
     * @param $string String to insert
     * @return FileChainerInterface
     */
    public function insert($string);
}