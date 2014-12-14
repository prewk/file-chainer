file-chainer [![Build Status](https://travis-ci.org/prewk/file-chainer.svg?branch=master)](https://travis-ci.org/prewk/file-chainer)
============
## What is it?
A small wrapper for some php file streaming functions with support for inserting data into streams without overwriting. (Also: chainable.)

## Installation
Add to composer:

````json
require: {
    "prewk/file-chainer": "dev-master"
}
````

And run `composer install`.

## Usage

Two new file stream methods:

* `finsert` inserts a string at the current file stream position
* `finsertcsv` inserts a csv (like [fputcsv](http://se2.php.net/manual/en/function.fputcsv.php)) line at the current file stream position

### Inserting & chaining

````php
Prewk\FileChainer::make()
    ->fopen("/foo/bar.txt", "w+")
    ->fwrite("foo")
    ->rewind()
    ->finsert("bar")
    ->fclose();

echo file_get_contents("/foo/bar.txt");
// Output: barfoo
// The handle's file pointer = 3
````

### Inserting with static method
````php
$handle = fopen("/foo/bar.txt", "w+");
fwrite($handle, "foo");
rewind($handle);

// Statically, using the default "temporary file stream" method
Prewk\FileChainer\Inserters\File::finsert($handle, "bar");

fclose($handle);

echo file_get_contents("/foo/bar.txt");
// Output: barfoo
// The handle's file pointer = 3
````
