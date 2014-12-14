<?php
/**
 * @author Oskar Thornblad <oskar.thornblad@gmail.com>
 */

namespace Prewk\FileChainer\Inserters;
use Prewk\FileChainer\InserterInterface;

/**
 * Temporary file inserter method
 */
class File implements InserterInterface
{
    /**
     * Insert a string into a file stream with the help of a temporary file stream
     *
     * @param     $handle     File handle
     * @param     $string     String to insert
     * @param int $bufferSize Buffer size
     * @return void
     */
    public static function finsert($handle, $string, $bufferSize = 16384)
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
        fwrite($handle, $string);
        while (!feof($lastPartHandle)) {
            fwrite($handle, fread($lastPartHandle, $bufferSize), $bufferSize);
        }

        // Close the last part handle and delete it
        fclose($lastPartHandle);
        unlink($tempPath);

        // Re-set pointer
        fseek($handle, $insertionPoint + strlen($string));
    }


    /**
     * Insert CSV fputcsv style at stream handle pointer position
     *
     * @param resource $handle File handle
     * @param array $fields An array of values
     * @param string $delimiter The optional delimiter parameter sets the field delimiter (one character only).
     * @param string $enclosure The optional enclosure parameter sets the field enclosure (one character only).
     * @param int $bufferSize Buffer size
     * @return void
     */
    public static function finsertcsv($handle, array $fields, $delimiter = ",", $enclosure = "\"", $bufferSize = 16384)
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