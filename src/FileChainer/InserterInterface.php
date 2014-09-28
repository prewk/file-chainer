<?php


namespace Prewk\FileChainer;

interface InserterInterface
{
    public function _insert($handle, $string, $bufferSize = 16384);
} 