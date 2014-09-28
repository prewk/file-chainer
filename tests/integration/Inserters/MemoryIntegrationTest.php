<?php

namespace Prewk\FileChainer\Inserters;

use TestCase;

class MemoryIntegrationTest extends TestCase
{
    public function test_that_it_inserts()
    {
        $inserter = new Memory;

        $path = tempnam(sys_get_temp_dir(), "file-chainer");

        $handle = fopen($path, "w+");
        fwrite($handle, "foobar");
        fseek($handle, 3);

        $inserter->insert($handle, "baz");

        fclose($handle);

        $this->assertEquals("foobazbar", file_get_contents($path));

        unlink($path);
    }
}