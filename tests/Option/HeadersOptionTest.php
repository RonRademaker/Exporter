<?php

namespace RonRademaker\Exporter\Option\Test;

use PHPUnit_Framework_TestCase;

/**
 * Unit test for the option to define headers
 *
 * @author Ron Radmeaker
 */
class HeadersOptionTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test getting the set headers
     */
    public function testGetHeaders()
    {
        $headerOption = new \RonRademaker\Exporter\Option\HeadersOption(['foo', 'bar']);

        $this->assertEquals(['foo', 'bar'], $headerOption->getFields());
        $this->assertEquals(['foo', 'bar'], $headerOption->getValue());
    }
}
