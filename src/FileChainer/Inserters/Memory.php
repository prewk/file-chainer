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
}
