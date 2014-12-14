<?php
/**
 * @author Oskar Thornblad <oskar.thornblad@gmail.com>
 */


namespace Prewk\FileChainer\Inserters;

/**
 * Temporary memory inserter method
 */
class Memory extends AbstractInserter
{
    /**
     * Insert a string into a file stream by storing the file contents as a variable
     *
     * @param     $handle     File handle
     * @param     $string     String to insert
     * @param int $bufferSize Buffer size
     * @return void
     */
    public function _insert($handle, $string, $bufferSize = 16384)
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
    public function _insertCSV($handle, array $fields, $delimiter = ",", $enclosure = "\"", $bufferSize = 16384)
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
        fputcsv($handle, $fields, $delimiter, $enclosure);
        $rewindPosition = ftell($handle);
        fwrite($handle, $data);

        // Re-set pointer
        fseek($handle, $insertionPoint + $rewindPosition);
    }
}
