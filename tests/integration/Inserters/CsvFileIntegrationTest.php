<?php

namespace Prewk\FileChainer\Inserters;

use TestCase;

class CsvFileIntegrationTest extends TestCase
{
    public function testInsertCsvDataAtBeginning()
    {
        $file = fopen('php://temp', 'w');
        fwrite($file, 'testline');

        $csvData = array('field1' => 'value1', 'field2' => 'value2');

        rewind($file);
        CsvFile::insert($file, $csvData);

        rewind($file);
        $contents = explode("\n", stream_get_contents($file));
        $this->assertEquals('value1,value2', $contents[0]);
        $this->assertEquals('testline', $contents[1]);
    }

    public function testInsertCsvDataInMiddle()
    {
        $file = fopen('php://temp', 'w');
        fwrite($file, 'testline');

        $csvData = array('field1' => 'value1', 'field2' => 'value2');

        fseek($file, 4);

        CsvFile::insert($file, $csvData);
        rewind($file);
        $contents = explode("\n", stream_get_contents($file));
        $this->assertEquals('testvalue1,value2', $contents[0]);
        $this->assertEquals('line', $contents[1]);
    }

    public function testInsertCsvDataAtEnd()
    {
        $file = fopen('php://temp', 'w');
        fwrite($file, 'testline');

        $csvData = array('field1' => 'value1', 'field2' => 'value2');

        CsvFile::insert($file, $csvData);
        rewind($file);
        $contents = explode("\n", stream_get_contents($file));
        $this->assertEquals('testlinevalue1,value2', $contents[0]);
    }

    public function testInsertCsvDataObeysDelimiterAndEnclosure()
    {
        $file = fopen('php://temp', 'w');

        $csvData = array('field1' => 'value|1', 'field2' => 'value|2');

        CsvFile::insert($file, $csvData, '|', '~');
        rewind($file);
        $contents = explode("\n", stream_get_contents($file));
        $this->assertEquals('~value|1~|~value|2~', $contents[0]);
    }
}
