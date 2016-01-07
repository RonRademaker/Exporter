<?php

namespace RonRademaker\Exporter\Option;

/**
 * Option to output to a file
 *
 * @author Ron Rademaker
 */
class FileOption implements OutputOptionInterface
{
    /**
     * The filename to output to
     *
     * @var string
     */
    private $filename;

    /**
     * Creates the option for $filename
     *
     * @param string $filename
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    /**
     * Gets the filename to output to
     *
     * @return string
     */
    public function getValue()
    {
        return $this->filename;
    }

    /**
     * Write output to the set file
     *
     * @param string $output
     */
    public function stream($output)
    {
        file_put_contents($this->getValue(), $output);
    }
}
