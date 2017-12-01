<?php

namespace Peri22x\Meta\Generator\SectionType;

class SectionTypeGenerator
{
    private $namespace;
    private $type;
    private $values = [];

    public function __construct($namespace, $type)
    {
        $this->namespace = $namespace;
        $this->type = $type;
    }

    public function addValue($concept)
    {
        $this->values[] = $concept;
    }

    public function getValues()
    {
        $s = array_map(
            function ($x) {
                return "        '{$x}'";
            },
            $this->values
        );
        return "[\n" . implode(",\n", $s) . ",\n    ]";
    }

    public function getClass()
    {
        $className = $this->getClassName();
        return "{$this->namespace}\\{$className}";
    }

    public function getClassName()
    {
        $type = ucfirst($this->type);
        return "{$type}Section";
    }

    public function getInheritedClass()
    {
        return "{$this->namespace}\\AbstractSection";
    }

    public function getConceptPropertyName()
    {
        return 'permittedConcepts';
    }

}
