<?php
namespace RonRademaker\Exporter\Exporter;

use RonRademaker\Exporter\Data\DataInterface;
use RonRademaker\Exporter\Option\OptionInterface;

/**
 * API for exporters
 *
 * @author Ron Rademaker
 */
interface ExporterInterface
{
    /**
     * Create a new exporter with $options
     *
     * @param array $options - an array of OptionInterface of key value pair resolvable as an option
     */
    public function __construct(array $options = array());

    /**
     * Export the data
     *
     * @param mixed $input - required unless already set using setInput
     * @param array $options - an array of OptionInterface of key value pair resolvable as an option
     */
    public function export(DataInterface $input = null, array $options = array());

    /**
     * Explicitly set an option
     *
     * @param OptionInterface $option
     * @param boolean $overwrite - Overwrite existing option if it exists
     */
    public function setOption(OptionInterface $option, $overwrite = false);

    /**
     * Explicitly set input data
     *
     * @param mixed $input
     */
    public function setInput(DataInterface $input);

    /**
     * Verifies if this ExporterInterface is able to export $input
     *
     * @param mixed $input
     * @return boolean
     */
    public function supports(DataInterface $input);
}
