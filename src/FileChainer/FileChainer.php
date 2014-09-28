<?php

namespace Prewk\FileChainer;

use Prewk\FileChainer\Inserters\Memory;
use Prewk\FileChainerInterface;

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

    public function fopen($filename, $mode, $use_include_path = false, $context = null)
    {
        if (isset($context)) {
            $this->handle = fopen($filename, $mode, $use_include_path, $context);
        } else {
            $this->handle = fopen($filename, $mode, $use_include_path);
        }


        return $this;
    }

    public function fwrite($string, $length = null)
    {
        if (isset($length)) {
            fwrite($this->handle, $string, $length);
        } else {
            fwrite($this->handle, $string);
        }


        return $this;
    }

    public function fread($length)
    {
        fread($this->handle, $length);

        return $this;
    }

    public function fseek($offset, $whence = SEEK_SET)
    {
        fseek($this->handle, $offset, $whence);

        return $this;
    }

    public function rewind()
    {
        rewind($this->handle);

        return $this;
    }

    public function insert($string)
    {
        $this->inserter->insert($this->handle, $string);

        return $this;
    }

    /**
     * Create a file chainer with the File inserter
     *
     * @return FileChainerInterface
     */
    public static function make()
    {
        return new static(new Memory);
    }

    public function fclose()
    {
        fclose($this->handle);
    }
}