<?php


namespace Prewk\FileChainer\Inserters;


use Prewk\FileChainer\InserterInterface;

class File implements InserterInterface
{
    /**
     * @var int Buffer size
     */
    protected $bufferSize = 16384;

    public function insert($handle, $string)
    {
        $insertionPoint = ftell($handle);

        // Create a temp file to stream into
        $tempPath = tempnam(sys_get_temp_dir(), "file-chainer");
        $lastPartHandle = fopen($tempPath, "w+");

        // Read in everything from the insertion point and forward
        while (!feof($handle)) {
            fwrite($lastPartHandle, fread($handle, $this->bufferSize), $this->bufferSize);
        }

        // Rewind to the insertion point
        fseek($handle, $insertionPoint);

        // Rewind the temporary stream
        rewind($lastPartHandle);

        // Write back everything starting with the string to insert
        fwrite($handle, $string);
        while (!feof($lastPartHandle)) {
            fwrite($handle, fread($lastPartHandle, $this->bufferSize), $this->bufferSize);
        }

        // Close the last part handle and delete it
        fclose($lastPartHandle);
        unlink($tempPath);
    }
}