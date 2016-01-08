<?php

namespace RonRademaker\Exporter\Data\Test;

use PHPUnit_Framework_TestCase;
use RonRademaker\Exporter\Data\ArrayData;

/**
 * Unit test for ArrayData
 *
 * @author Ron Rademaker
 */
class ArrayDataTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test getting the depth
     *
     * @dataProvider provideDepthTestData
     */
    public function testGetDepth(array $data, $depth)
    {
        $arrayData = new ArrayData($data);

        $this->assertEquals($depth, $arrayData->getDepth());
    }

    /**
     * Test basic iterator functions
     *
     * @dataProvider provideIteratorTestData
     */
    public function testIterator($data)
    {
        if ($data instanceof ArrayData) {
            $arrayData = $data;
            $data = $arrayData->getData();
        } else {
            $arrayData = new ArrayData($data);
        }

        foreach ($arrayData as $key => $value) {
            if ($value instanceof ArrayData) {
                $this->testIterator($value);
            } else {
                $this->assertEquals(
                    $data[$key],
                    $value,
                    sprintf(
                        'Expected %s at %s, found %s instead',
                        $data[$key],
                        $key,
                        $value
                    )
                );
            }
        }
    }

    /**
     * Test getting the keys of an array
     */
    public function testGetKeys()
    {
        $array = ['foo'=>'hello','bar'=>'world'];

        $data = new ArrayData($array);

        $this->assertEquals(['foo', 'bar'], $data->getKeys());
    }

    /**
     * Gets some array to test the Iterator with
     *
     * @return array
     */
    public function provideIteratorTestData()
    {
        return [
            [['a', 'b', 'c']],
            [['a', ['b'], [['c']]]],
            [['a' => 'b', 'c']],
            [['a' => ['b', 'c']]],
            [['a' => ['b', ['c']], 'd' => 'e']],
        ];
    }

    /**
     * Provide test data for depth
     *
     * @return array
     */
    public function provideDepthTestData()
    {
        return [
            [
                ['a'],
                1
            ],
            [
                ['a', 'b', 'c'],
                1
            ],
            [
                ['a', ['b'], 'c'],
                2
            ],
            [
                ['a', ['b'], [['c']]],
                3
            ]
        ];
    }
}
