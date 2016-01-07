<?php

namespace RonRademaker\Exporter\Data;

/**
 * Representation of data in an array
 *
 * @author Ron Rademaker
 */
class ArrayData implements DataInterface
{
    /**
     * The array holding the data
     *
     * @var array
     */
    private $data;

    /**
     * The keys of the data
     *
     * @var array
     */
    private $keys;

    /**
     * The current position
     *
     * @var integer
     */
    private $position = 0;

    /**
     * Creates a new ArrayData
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->keys = array_keys($data);
    }

    /**
     * Retrieve the original data
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Retrieve the keys
     *
     * @return array
     */
    public function getKeys()
    {
        return $this->keys;
    }

    /**
     * Gets the depth of the information in this DataInterface
     *
     * @return integer
     */
    public function getDepth()
    {
        return $this->determineArrayDepth($this->data);
    }

    /**
     * Gets the current element
     *
     * @return mixed
     */
    public function current()
    {
        $current = $this->data[$this->key()];
        if (is_array($current)) {
            return new ArrayData($current);
        } else {
            return $current;
        }
    }

    /**
     * Gets the key of the current eleemnt
     *
     * @return mixed
     */
    public function key()
    {
        return $this->keys[$this->position];
    }

    /**
     * Move the pointer to the next element
     */
    public function next()
    {
        $this->position++;
    }

    /**
     * Move the pointer to the start
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * Checks if the current position is valid
     *
     * @return boolean
     */
    public function valid()
    {
        return isset($this->keys[$this->position]);
    }

    /**
     * Determine how deep this array goes
     *
     * @param array $data
     * @param integer $depth
     * @return integer
     */
    private function determineArrayDepth(array $data, $depth = 1)
    {
        $depths = [$depth];
        foreach ($data as $row) {
            if (is_array($row)) {
                $depths[] = max([$depth, $this->determineArrayDepth($row, $depth+1)]);
            }
        }

        return max($depths);
    }
}
