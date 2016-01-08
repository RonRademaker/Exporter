<?php

namespace RonRademaker\Exporter\Exporter\Test;

use PHPUnit_Framework_TestCase;
use RonRademaker\Exporter\Data\ArrayData;
use RonRademaker\Exporter\Data\DataInterface;
use RonRademaker\Exporter\Exception\UnsupportedDataException;
use RonRademaker\Exporter\Exporter\CSVExporter;
use RonRademaker\Exporter\Option\FileOption;
use RonRademaker\Exporter\Option\HeadersOption;

/**
 * Unit test for the CSV exporter
 *
 * @author Ron Rademaker
 */
class CSVExporterTest extends PHPUnit_Framework_TestCase
{
    /**
     * Tests if the exporter exports as expected to files
     *
     * @dataProvider provideCSVFileData
     *
     * @param DataInterface $input
     * @param array $options
     * @param array $expectedFiles
     * @param string $expectedContent
     */
    public function testExportToFile(DataInterface $input, array $options, array $expectedFiles, $expectedContent)
    {
        $exporter = new CSVExporter($options);
        $exporter->setInput($input);
        $exporter->export();

        foreach ($expectedFiles as $file) {
            $this->assertFileExists($file);
            $this->assertEquals($expectedContent, file_get_contents($file));

            unlink($file);
        }
    }

    /**
     * Test if unsupported data structures cause an exception
     */
    public function testUnsupportedDataStructureThrowsException()
    {
        $this->setExpectedException(UnsupportedDataException::class);

        $input = new ArrayData(
            [
                [
                    ['hello world']
                ]
            ]
        );

        $exporter = new CSVExporter();
        $exporter->setInput($input);
        $exporter->export();
    }

    /**
     * Tests setting the option for output
     *
     * @dataProvider provideOptionTestData
     */
    public function testSettingTheOption(FileOption $option, $overwrite)
    {
        $data = [
            ['foo' => 'foo', 'bar' => 'foobar'],
            ['foo' => 'bar', 'bar' => 'foo'],
            ['bar' => 'bar','foo' => 'foo', 'baz' => 'foobar']
        ];

        $input = new ArrayData($data);
        $exporter = new CSVExporter([new FileOption('foo.bar')]);
        $exporter->setInput($input);
        $exporter->setOption($option, $overwrite);
        $exporter->export();

        $this->assertEquals("foo,bar,baz\nfoo,foobar,\nbar,foo,\nfoo,bar,foobar\n", file_get_contents($option->getValue()));
        if ($overwrite === true) {
            $this->assertFileNotExists('foo.bar');
        } else {
            $this->assertEquals("foo,bar,baz\nfoo,foobar,\nbar,foo,\nfoo,bar,foobar\n", file_get_contents('foo.bar'));
            unlink('foo.bar');
        }

        unlink($option->getValue());
    }

    /**
     * Provide test data for setting the FileOption
     *
     * @return array
     */
    public function provideOptionTestData()
    {
        return [
            [new FileOption('foo.csv'), false],
            [new FileOption('foo.csv'), true]
        ];
    }

    /**
     * Gets some test data to create CSV
     *
     * @return array
     */
    public function provideCSVFileData()
    {
        $data = [
            ['foo' => 'foo', 'bar' => 'foobar'],
            ['foo' => 'bar', 'bar' => 'foo'],
            ['bar' => 'bar','foo' => 'foo', 'baz' => 'foobar']
        ];

        return [
            [
                new ArrayData($data),
                [new FileOption('test.csv')],
                ['test.csv'],
                "foo,bar,baz\nfoo,foobar,\nbar,foo,\nfoo,bar,foobar\n"
            ],
            [
                new ArrayData($data),
                [new FileOption('test.csv'), new FileOption('foobar.csv')],
                ['test.csv', 'foobar.csv'],
                "foo,bar,baz\nfoo,foobar,\nbar,foo,\nfoo,bar,foobar\n"
            ],
            [
                new ArrayData($data),
                [new FileOption('test.csv'), new HeadersOption(['foo'])],
                ['test.csv'],
                "foo\nfoo\nbar\nfoo\n"
            ],
            [
                new ArrayData($data),
                [new FileOption('test.csv'), new HeadersOption(['foo', 'does not exist'])],
                ['test.csv'],
                "foo,\"does not exist\"\nfoo,\nbar,\nfoo,\n"
            ]
        ];
    }
}
