<?php
/**
 * @author Oskar Thornblad <oskar.thornblad@gmail.com>
 */

namespace Prewk\FileChainer;

use Prewk\FileChainer\Inserters\File;
use Prewk\FileChainerInterface;

/**
 * Chainable native file stream methods with insert support
 */
class FileChainer implements FileChainerInterface
{
    /**
     * @var InserterInterface
     */
    private $inserter;

    public function __construct(
        InserterInterface $inserter
    )
    {
        $this->inserter = $inserter;
    }

    /**
     * @var Resource File handle
     */
    protected $handle;

    public function getHandle()
    {
        return $this->handle;
    }

    /**
     * Native fopen()
     *
     * @param string $filename         Filename
     * @param string $mode             Mode
     * @param bool   $use_include_path Use include path
     * @param null   $context          Context
     * @return FileChainerInterface
     */
    public function fopen($filename, $mode, $use_include_path = false, $context = null)
    {
        if (isset($context)) {
            $this->handle = fopen($filename, $mode, $use_include_path, $context);
        } else {
            $this->handle = fopen($filename, $mode, $use_include_path);
        }


        return $this;
    }

    /**
     * Native fwrite()
     *
     * @param string $string          String
     * @param null   $length          Length
     * @throws MissingHandleException if no file handle was set
     * @return FileChainerInterface
     */
    public function fwrite($string, $length = null)
    {
        if (!isset($this->handle)) {
            throw new MissingHandleException("Missing handle");
        }

        if (isset($length)) {
            fwrite($this->handle, $string, $length);
        } else {
            fwrite($this->handle, $string);
        }


        return $this;
    }

    /**
     * Native fread()
     *
     * @param $length Length
     * @throws MissingHandleException if no file handle was set
     * @return FileChainerInterface
     */
    public function fread($length)
    {
        if (!isset($this->handle)) {
            throw new MissingHandleException("Missing handle");
        }

        fread($this->handle, $length);

        return $this;
    }

    /**
     * Native fseek()
     *
     * @param int $offset           Offset
     * @param int $whence           Whence
     * @throws MissingHandleException if no file handle was set
     * @return FileChainerInterface
     */
    public function fseek($offset, $whence = SEEK_SET)
    {
        if (!isset($this->handle)) {
            throw new MissingHandleException("Missing handle");
        }

        fseek($this->handle, $offset, $whence);

        return $this;
    }

    /**
     * Native rewind()
     *
     * @throws MissingHandleException if no file handle was set
     * @return FileChainerInterface
     */
    public function rewind()
    {
        if (!isset($this->handle)) {
            throw new MissingHandleException("Missing handle");
        }

        rewind($this->handle);

        return $this;
    }

    /**
     * Insert a string at current file handle position without overwriting
     *
     * @param $string String to insert
     * @throws MissingHandleException if no file handle was set
     * @return FileChainerInterface
     */
    public function insert($string, $bufferSize = 16384)
    {
        if (!isset($this->handle)) {
            throw new MissingHandleException("Missing handle");
        }

        $this->inserter->insert($this->handle, $string, $bufferSize);

        return $this;
    }

    /**
     * Create a file chainer with the File inserter
     *
     * @return FileChainerInterface
     */
    public static function make()
    {
        return new static(new File);
    }

    /**
     * Native fclose()
     *
     * @throws MissingHandleException if no file handle was set
     * @return FileChainerInterface
     */
    public function fclose()
    {
        if (!isset($this->handle)) {
            throw new MissingHandleException("Missing handle");
        }

        fclose($this->handle);
    }

    /**
     * Insert a csv at current file handle position without overwriting
     *
     * @param array $fields An array of values
     * @param string $delimiter The optional delimiter parameter sets the field delimiter (one character only).
     * @param string $enclosure The optional enclosure parameter sets the field enclosure (one character only).
     * @throws MissingHandleException if no file handle was set
     * @return FileChainerInterface
     */
    public function finsertcsv(array $fields, $delimiter = ",", $enclosure = "\"", $bufferSize = 16384)
    {
        if (!isset($this->handle)) {
            throw new MissingHandleException("Missing handle");
        }

        $this->inserter->insertCSV($this->handle, $fields, $delimiter, $enclosure, $bufferSize);

        return $this;
    }
}