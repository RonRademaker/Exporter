<?php

namespace RonRademaker\Exporter\Option;

/**
 * Interface for options that define the fields to be included in an export
 *
 * @author Ron Rademaker
 */
interface FieldOptionInterface extends OptionInterface
{
    /**
     * Gets the fields defined in this option
     *
     * @return array
     */
    public function getFields();
}
