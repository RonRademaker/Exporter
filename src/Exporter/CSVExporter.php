<?php

namespace RonRademaker\Exporter\Exporter;

use League\Csv\Writer;
use RonRademaker\Exporter\Data\DataInterface;
use RonRademaker\Exporter\Exception\UnsupportedDataException;
use RonRademaker\Exporter\Option\FieldOptionInterface;
use SplTempFileObject;

/**
 * Exporter to create CSV
 *
 * @author Ron Rademaker
 */
class CSVExporter extends AbstractExporter
{
    /**
     * Export the data
     *
     * @param mixed $input - required unless already set using setInput
     * @param array $options - an array of OptionInterface of key value pair resolvable as an option
     */
    public function export(DataInterface $input = null, array $options = array())
    {
        $input = $input ?: $this->getInput();
        $options = $options ?: $this->getOptions();

        if (!$this->supports($input)) {
            throw new UnsupportedDataException(
                sprintf(
                    '%s does not support exporting the set %s data of depth %d',
                    get_class($this),
                    get_class($input),
                    $input->getDepth()
                )
            );
        }
        
        $headers = $this->getHeaders($input, $options);

        $writer = Writer::createFromFileObject(new SplTempFileObject());
        $writer->insertOne($headers);

        foreach ($input as $row) {
            $writer->insertOne($this->getRow($headers, $row));
        }

        $this->outputResult($writer->__toString(), $options);
    }

    /**
     * Verifies if this ExporterInterface is able to export $input
     *
     * @param mixed $input
     * @return boolean
     */
    public function supports(DataInterface $input)
    {
        return $input->getDepth() === 2;
    }

    /**
     * Gets the data as defined by $headers from $row
     *
     * @param array $headers
     * @param DataInterface $row
     * @return array
     */
    private function getRow(array $headers, DataInterface $row)
    {
        $data = array_fill_keys($headers, '');
        foreach ($row as $key => $value) {
            if (in_array($key, $headers)) {
                $data[$key] = $value;
            }
        }

        return $data;
    }

    /**
     * Gets an array with the headers for the CSV
     *
     * @param mixed $input
     * @param array $options
     * @return array
     */
    private function getHeaders(DataInterface $input, array $options)
    {
        foreach ($options as $option) {
            if ($option instanceof FieldOptionInterface) {
                return $option->getFields();
            }
        }

        $keys = [];
        foreach ($input as $row) {
            foreach ($row as $key => $value) {
                if (!in_array($key, $keys)) {
                    $keys[] = $key;
                }
            }
        }

        return $keys;
    }

}
