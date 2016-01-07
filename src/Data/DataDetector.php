<?php
namespace RonRademaker\Exporter\Data;

/**
 * Detector to create Data objects
 *
 * @author Ron Rademaker
 */
class DataDetector
{
    /**
     * Try to detect what $data is and return a Data object for it
     *
     * @param mixed $data
     * @return DataInterface
     */
    public static function detect($data)
    {
        if (is_array($data)) {
            return new ArrayData($data);
        }
    }
}
