<?php


namespace Prewk\FileChainer\Inserters;


use TestCase;

class FileIntegrationTest extends TestCase
{
    public function test_that_it_inserts()
    {
        $inserter = new File;

        $path = tempnam(sys_get_temp_dir(), "file-chainer");

        $handle = fopen($path, "w+");
        fwrite($handle, "foobar");
        fseek($handle, 3);

        $inserter->insert($handle, "baz");

        fclose($handle);

        $this->assertEquals("foobazbar", file_get_contents($path));

        unlink($path);
    }

    public function test_that_it_inserts_static()
    {
        $path = tempnam(sys_get_temp_dir(), "file-chainer");

        $handle = fopen($path, "w+");
        fwrite($handle, "foobar");
        fseek($handle, 3);

        File::insert($handle, "baz");

        fclose($handle);

        $this->assertEquals("foobazbar", file_get_contents($path));

        unlink($path);
    }
}