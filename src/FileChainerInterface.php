<?php


namespace Prewk;

interface FileChainerInterface
{
    public function getHandle();

    public function fopen($filename, $mode, $use_include_path = false, $context = null);

    public function fwrite($string, $length = null);

    public function fread($length);

    public function fseek($offset, $whence = SEEK_SET);

    public function rewind();

    public function insert($string);
}