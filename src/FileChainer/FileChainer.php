<?php

namespace Prewk\FileChainer;

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
        $this->handle = fopen($filename, $mode, $use_include_path, $context);

        return $this;
    }

    public function fwrite($string, $length = null)
    {
        fwrite($this->handle, $string, $length);

        return $this;
    }

    public function fread($length)
    {
        fread($this->handle, $length);

        return $this;
    }

    public function fseek($offset, $whence = SEEK_SET)
    {
        fseek($offset, $whence);

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
    }
}