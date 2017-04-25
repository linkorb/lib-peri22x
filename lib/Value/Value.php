<?php

namespace Peri22x\Value;

use DOMDocument;

use Peri22x\XmlNodeInterface;

/**
 * Model of an XML "value" Element.
 */
class Value implements XmlNodeInterface
{
    private $concept;
    private $value;

    public function __construct($concept, $value)
    {
        $this->concept = $concept;
        $this->value = $value;
    }

    public function getAttributes()
    {
        return [
            'concept' => $this->concept,
            'value' => $this->value,
        ];
    }

    /**
     * Return an XML "value" Element.
     *
     * @param \DOMDocument $doc
     * @return \DOMElement
     */
    public function toXmlNode(DOMDocument $doc)
    {
        $valueElem = $doc->createElement('value');
        foreach ($this->getAttributes() as $name => $value) {
            $valueElem->setAttribute($name, $value);
        }
        return $valueElem;
    }
}
