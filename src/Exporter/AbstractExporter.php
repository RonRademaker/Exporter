<?php

namespace RonRademaker\Exporter\Exporter;

use RonRademaker\Exporter\Data\DataInterface;
use RonRademaker\Exporter\Option\OptionInterface;
use RonRademaker\Exporter\Option\OutputOptionInterface;

/**
 * Base abstract exporter
 *
 * @author Ron Rademaker
 */
abstract class AbstractExporter implements ExporterInterface
{
    /**
     * Active options
     *
     * @var array
     */
    private $options;

    /**
     * Input to process
     *
     * @var DataInterface
     */
    private $input;

    /**
     * Create a new exporter with $options
     *
     * @param array $options - an array of OptionInterface of key value pair resolvable as an option
     */
    public function __construct(array $options = array())
    {
        $this->options = $options;
    }

    /**
     * Explicitly set an option
     *
     * @param OptionInterface $option
     * @param boolean $overwrite - Overwrite existing option if it exists
     */
    public function setOption(OptionInterface $option, $overwrite = false)
    {
        if ($overwrite === true) {
            foreach ($this->options as $index => $setOption) {
                if (get_class($setOption) === get_class($option)) {
                    $this->options[$index] = $option;
                    return;
                }
                // @codeCoverageIgnoreStart
            }
        }
        // @codeCoverageIgnoreEnd

        $this->options[] = $option;
    }

    /**
     * Explicitly set input data
     *
     * @param mixed $input
     */
    public function setInput(DataInterface $input)
    {
        $this->input = $input;
    }

    /**
     * Gets the set options
     *
     * @return array
     */
    protected function getOptions()
    {
        return $this->options;
    }

    /**
     * Gets the input
     *
     * @return DataInterface
     */
    protected function getInput()
    {
        return $this->input;
    }

    /**
     * Outputs the result as defined by options
     *
     * @param string $result
     * @param array $options
     */
    protected function outputResult($result, array $options)
    {
        foreach ($options as $option) {
            if ($option instanceof OutputOptionInterface) {
                $option->stream($result);
            }
        }
    }
}
