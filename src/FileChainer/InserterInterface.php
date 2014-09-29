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
     * @param     $handle     File handle
     * @param     $string     String to insert
     * @param int $bufferSize Buffer size
     * @return void
     */
    public function _insert($handle, $string, $bufferSize = 16384);
} 