<?php

namespace RonRademaker\Exporter\Option\Test;

use PHPUnit_Framework_TestCase;
use RonRademaker\Exporter\Option\FileOption;

/**
 * Unit test for outputting to a file
 *
 * @author Ron Rademaker
 */
class FileOptionTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test outputting Hello World to a file
     */
    public function testOutputHelloWorld()
    {
        $fileOption = new FileOption('hello.txt');

        $fileOption->stream('Hello World!');

        $this->assertFileExists('hello.txt');
        $this->assertEquals('Hello World!', file_get_contents('hello.txt'));

        unlink('hello.txt');
    }
}
