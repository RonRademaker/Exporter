<?php

namespace RonRademaker\Exporter\Exporter\Test;

use PHPUnit_Framework_TestCase;
use RonRademaker\Exporter\Data\ArrayData;
use RonRademaker\Exporter\Data\DataInterface;
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
