<?php


namespace Prewk\FileChainer\Inserters;


use Prewk\FileChainer\InserterInterface;

class Memory implements InserterInterface
{
    /**
     * @var int Buffer size
     */
    protected $bufferSize = 16384;

    public function insert($handle, $string)
    {
        $insertionPoint = ftell($handle);

        // Read in everything from the insertion point and forward
        $data = "";
        while (!feof($handle)) {
            $data .= fread($handle, $this->bufferSize);
        }

        // Rewind to the insertion point
        fseek($handle, $insertionPoint);

        // Write back everything starting with the string to insert
        fwrite($handle, $string . $data);
    }
}
