<?php

namespace Peri22x\Value;

use DOMDocument;

use Peri22x\XmlNodeError;
use Peri22x\XmlNodeInterface;

/**
 * Model of an XML "value" Element.
 */
class Value implements XmlNodeInterface
{
    protected $concept;
    protected $extraAttributes = [];
    protected $permittedAttributes = ['repeat'];
    protected $value;

    public function __construct($concept, $value, $extraAttributes = [])
    {
        $this->concept = $concept;
        $this->value = $value;
        $this->setExtraAttributes($extraAttributes);
    }

    public function getAttributes()
    {
        return array_merge(
            [
                'concept' => $this->concept,
                'value' => $this->value,
            ],
            $this->extraAttributes
        );
    }

    public function setExtraAttributes(array $extraAttributes)
    {
        foreach ($extraAttributes as $name => $value) {
            if (!in_array($name, $this->permittedAttributes)) {
                throw new XmlNodeError(
                    "The attribute named \"{$name}\" is not permitted."
                );
            }
            $this->extraAttributes[$name] = $value;
        }
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

    public function __toString()
    {
        return $this->value === null ? '' : (string) $this->value;
    }
}
