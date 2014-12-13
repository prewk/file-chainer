<?php

namespace Prewk\FileChainer\Inserters;

/**
 * Temporary file inserter method using fputcsv
 */
class CsvFile extends AbstractInserter
{
    /**
     * Insert a CSV data into a file stream with the help of a temporary file stream
     *
     * @param     $handle     File handle
     * @param     $string     String to insert
     * @param int $bufferSize Buffer size
     * @return void
     */
    public function _insert($handle, $fields, $delimiter = ',', $enclosure = '"', $bufferSize = 16384)
    {
        $insertionPoint = ftell($handle);

        // Create a temp file to stream into
        $tempPath = tempnam(sys_get_temp_dir(), "file-chainer");
        $lastPartHandle = fopen($tempPath, "w+");

        // Read in everything from the insertion point and forward
        while (!feof($handle)) {
            fwrite($lastPartHandle, fread($handle, $bufferSize), $bufferSize);
        }

        // Rewind to the insertion point
        fseek($handle, $insertionPoint);

        // Rewind the temporary stream
        rewind($lastPartHandle);

        // Write back everything starting with the string to insert
        fputcsv($handle, $fields, $delimiter, $enclosure);
        $currentPosition = ftell($handle);

        while (!feof($lastPartHandle)) {
            fwrite($handle, fread($lastPartHandle, $bufferSize), $bufferSize);
        }

        // Close the last part handle and delete it
        fclose($lastPartHandle);
        unlink($tempPath);

        // Re-set pointer
        fseek($handle, $currentPosition);
    }
}
