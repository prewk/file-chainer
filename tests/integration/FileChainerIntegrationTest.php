<?php


namespace Prewk\FileChainer;

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
            ->finsert("baz")
            ->fseek(8)
            ->finsert("lorem")
            ->rewind()
            ->finsertcsv(array("foo", "bar"))
            ->fclose();

        $this->assertEquals("foo,bar\nbazfoobaloremr", file_get_contents($path));

        unlink($path);
    }

    /**
     * @expectedException Prewk\FileChainer\MissingHandleException
     */
    public function test_that_chaining_without_a_handle_throws_an_exception()
    {
        FileChainer::make()
            ->fwrite("foobar");
    }
} 