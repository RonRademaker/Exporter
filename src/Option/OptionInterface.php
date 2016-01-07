<?php

namespace RonRademaker\Exporter\Option;

/**
 * Option controlling exporter behavior
 *
 * @author Ron Rademaker
 */
interface OptionInterface
{
    /**
     * Gets the value of this option
     *
     * @return mixed
     */
    public function getValue();
}
