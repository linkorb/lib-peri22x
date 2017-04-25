<?php

namespace Peri22x\Section;

use Peri22x\Value\ValueFactory;

class SectionFactory
{
    private $valueFactory;

    /**
     * @param \Peri22x\Value\ValueFactory $valueFactory
     */
    public function __construct(ValueFactory $valueFactory)
    {
        $this->valueFactory = $valueFactory;
    }

    /**
     * Create a Section of the specified type.
     *
     * @param string $type
     * @return \Peri22x\Section\SectionInterface;
     */
    public function create($type)
    {
        $class = $this->typeToClass($type);
        return new $class($this->valueFactory, $type);
    }

    private function typeToClass($type)
    {
        $t = ucfirst($type);
        $class = "\\Peri22x\\Section\\{$t}Section";
        if (!class_exists($class)) {
            throw new SectionError(
                "Unknown Section type \"{$type}\"."
            );
        }
        return $class;
    }
}
