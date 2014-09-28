<?php


namespace Prewk\FileChainer;


use Prewk\FileChainer\Inserters\Memory;
use TestCase;

class FileChainerIntegrationTest extends TestCase
{
    public function test_chainability()
    {
        $path = tempnam(sys_get_temp_dir(), "file-chainer");

        FileChainer::make()
            ->fopen($path, "w+")
            ->fwrite("foobar")
            ->rewind()
            ->insert("baz")
            ->fseek(8)
            ->insert("lorem")
            ->fclose();

        $this->assertEquals("bazfoobaloremr", file_get_contents($path));

        unlink($path);
    }
} 