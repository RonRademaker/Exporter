<?php
namespace RonRademaker\Exporter\Option;

/**
 * Option defining headers for an output format
 *
 * @author Ron Rademaker
 */
class HeadersOption implements FieldOptionInterface
{
    /**
     * The headers
     *
     * @var array
     */
    private $headers;

    /**
     * Creates the option for $headers
     *
     * @param array $headers
     */
    public function __construct(array $headers)
    {
        $this->headers = $headers;
    }

    /**
     * Gets the fields to use as headers
     *
     * @return array
     */
    public function getFields()
    {
        return $this->headers;
    }

    /**
     * Gets this option's value
     * 
     * @return mixed
     */
    public function getValue()
    {
        return $this->headers;
    }
}
