<?php

namespace RonRademaker\Exporter\Option;

/**
 * Option defining how to output the result
 *
 * @author Ron Rademaker
 */
interface OutputOptionInterface extends OptionInterface
{
    /**
     * Stream $output to wherever it needs to go
     *
     * @param string $output
     */
    public function stream($output);
}
