<?php
/**
 * @author Oskar Thornblad <oskar.thornblad@gmail.com>
 */

namespace Prewk;

use Prewk\FileChainer\MissingHandleException;

/**
 * FileChainerInterface describes a FileChainer
 */
interface FileChainerInterface
{
    /**
     * Get the current resource handle
     * @return resource The file handle
     */
    public function getHandle();

    /**
     * Native fopen()
     *
     * @param string $filename         Filename
     * @param string $mode             Mode
     * @param bool   $use_include_path Use include path
     * @param null   $context          Context
     * @return FileChainerInterface
     */
    public function fopen($filename, $mode, $use_include_path = false, $context = null);

    /**
     * Native fwrite()
     *
     * @param string $string          String
     * @param null   $length          Length
     * @throws MissingHandleException if no file handle was set
     * @return FileChainerInterface
     */
    public function fwrite($string, $length = null);

    /**
     * Native fread()
     *
     * @param $length Length
     * @throws MissingHandleException if no file handle was set
     * @return FileChainerInterface
     */
    public function fread($length);

    /**
     * Native fseek()
     *
     * @param int $offset           Offset
     * @param int $whence           Whence
     * @throws MissingHandleException if no file handle was set
     * @return FileChainerInterface
     */
    public function fseek($offset, $whence = SEEK_SET);

    /**
     * Native fclose()
     *
     * @throws MissingHandleException if no file handle was set
     * @return FileChainerInterface
     */
    public function fclose();

    /**
     * Native rewind()
     *
     * @throws MissingHandleException if no file handle was set
     * @return FileChainerInterface
     */
    public function rewind();

    /**
     * Create a file chainer with the File inserter
     *
     * @throws MissingHandleException if no file handle was set
     * @return FileChainerInterface
     */
    public static function make();

    /**
     * Insert a string at current file handle position without overwriting
     *
     * @param $string String to insert
     * @throws MissingHandleException if no file handle was set
     * @return FileChainerInterface
     */
    public function insert($string);
}