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
    public function create($conceptName, $value)
    {
        return new Value($conceptName, $value);
    }
}
