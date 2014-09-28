<?php


namespace Prewk\FileChainer\Inserters;


use Prewk\FileChainer\InserterInterface;

class Memory implements InserterInterface
{
    public function insert($handle, $string, $bufferSize = 16384)
    {
        $insertionPoint = ftell($handle);

        // Read in everything from the insertion point and forward
        $data = "";
        while (!feof($handle)) {
            $data .= fread($handle, $bufferSize);
        }

        // Rewind to the insertion point
        fseek($handle, $insertionPoint);

        // Write back everything starting with the string to insert

        fwrite($handle, $string . $data);
    }
}
