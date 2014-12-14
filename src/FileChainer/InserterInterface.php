<?php
/**
 * @author Oskar Thornblad <oskar.thornblad@gmail.com>
 */

namespace Prewk\FileChainer;

/**
 * InserterInterface describes a file stream inserter
 */
interface InserterInterface
{
    /**
     * Insert a string into a file stream
     *
     * @param resource $handle     File handle
     * @param          $string     String to insert
     * @param int      $bufferSize Buffer size
     * @return void
     */
    public static function finsert($handle, $string, $bufferSize = 16384);

    /**
     * Insert CSV fputcsv style at stream handle pointer position
     *
     * @param resource $handle      File handle
     * @param array    $fields      An array of values
     * @param string   $delimiter   The optional delimiter parameter sets the field delimiter (one character only).
     * @param string   $enclosure   The optional enclosure parameter sets the field enclosure (one character only).
     * @param int      $bufferSize  Buffer size
     * @return void
     */
    public static function finsertcsv($handle, array $fields, $delimiter = ",", $enclosure = "\"", $bufferSize = 16384);
}