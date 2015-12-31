<?php
namespace RonRademaker\Exporter\Data;

use Iterator;

/**
 * Interface defining input data format
 *
 * @author Ron Rademaker
 */
interface DataInterface extends Iterator
{
    /**
     * Gets the depth of the information in this DataInterface
     *
     * @return integer
     */
    public function getDepth();
}
