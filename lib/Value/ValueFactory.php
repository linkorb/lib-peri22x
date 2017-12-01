<?php

namespace Peri22x\Value;

class ValueFactory
{
    /**
     * Create a Value for the supplied concept and with the supplied value.
     * @param string $conceptName
     * @param string $value
     * @return \Peri22x\Value\Value
     */
    public function create($conceptName, $value, $extraAttributes = [])
    {
        return new Value($conceptName, $value, $extraAttributes);
    }

    /**
     * Create a CDATA Value for the supplied concept and with the supplied value.
     * @param string $conceptName
     * @param string $value
     * @return \Peri22x\Value\CdataValue
     */
    public function createAsCdata($conceptName, $value, $extraAttributes = [])
    {
        return new CdataValue($conceptName, $value, $extraAttributes);
    }
}
