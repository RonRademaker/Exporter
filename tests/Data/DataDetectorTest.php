<?php

namespace RonRademaker\Exporter\Data\Test;

use PHPUnit_Framework_TestCase;
use RonRademaker\Exporter\Data\ArrayData;
use RonRademaker\Exporter\Data\DataDetector;

/**
 * Unit test for the DataDetector
 *
 * @author Ron Rademaker
 */
class DataDetectorTest extends PHPUnit_Framework_TestCase
{
    /**
     * Tests if the correct data type is detected
     *
     * @dataProvider provideDetectableData
     */
    public function testDataDetector($data, $expected)
    {
        $input = DataDetector::detect($data);

        $this->assertInstanceOf($expected, $input);
    }

    /**
     * Test if undetectable data is detected as null
     */
    public function testUndetectableIsNull()
    {
        $input = DataDetector::detect(null);

        $this->assertNull($input);
    }

    /**
     * Provide detectable data
     *
     * @return array
     */
    public function provideDetectableData()
    {
        return [
            [
                ['foo', 'bar'],
                ArrayData::class
            ]
        ];
    }
}
