<?php


namespace Prewk\FileChainer;

interface InserterInterface
{
    public function insert($handle, $string, $bufferSize = 16384);
} 