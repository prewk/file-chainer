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

    public function test_that_file_pointer_gets_set_to_after_insert()
    {
        $path = tempnam(sys_get_temp_dir(), "file-chainer");

        $handle = fopen($path, "w+");
        fwrite($handle, "foobar");
        fseek($handle, 3);

        File::insert($handle, "baz");

        $this->assertEquals(6, ftell($handle));

        fclose($handle);
        unlink($path);
    }

    public function test_that_insert_csv_data_at_beginning()
    {
        $handle = fopen("php://temp", "w");
        fwrite($handle, "testline");

        $csvData = array("field1" => "value1", "field2" => "value2");

        rewind($handle);
        File::insertCSV($handle, $csvData);

        rewind($handle);
        $contents = explode("\n", stream_get_contents($handle));
        $this->assertEquals("value1,value2", $contents[0]);
        $this->assertEquals("testline", $contents[1]);
    }

    public function test_that_insert_csv_data_in_middle()
    {
        $handle = fopen("php://temp", "w");
        fwrite($handle, "testline");

        $csvData = array("field1" => "value1", "field2" => "value2");

        fseek($handle, 4);

        File::insertCSV($handle, $csvData);
        rewind($handle);
        $contents = explode("\n", stream_get_contents($handle));
        $this->assertEquals("testvalue1,value2", $contents[0]);
        $this->assertEquals("line", $contents[1]);
    }

    public function test_that_insert_csv_data_at_end()
    {
        $file = fopen("php://temp", "w");
        fwrite($file, "testline");

        $csvData = array("field1" => "value1", "field2" => "value2");

        File::insertCSV($file, $csvData);
        rewind($file);
        $contents = explode("\n", stream_get_contents($file));
        $this->assertEquals("testlinevalue1,value2", $contents[0]);
    }

    public function test_that_insert_csv_data_obeys_delimiter_and_enclosure()
    {
        $file = fopen("php://temp", "w");

        $csvData = array("field1" => "value|1", "field2" => "value|2");

        File::insertCSV($file, $csvData, "|", "~");
        rewind($file);
        $contents = explode("\n", stream_get_contents($file));
        $this->assertEquals("~value|1~|~value|2~", $contents[0]);
    }
}