<?php

namespace Peri22x\Value;

use DOMDocument;

/**
 * Model of an XML "value" Element with CDATA.
 */
class CdataValue extends Value
{
    protected $data;

    public function __construct($concept, $data, $extraAttributes = [])
    {
        parent::__construct($concept, '', $extraAttributes);
        $this->data = $data;
    }

    /**
     * Return an XML "value" Element with CDATA content instead of a "value"
     * Attribute.
     *
     * @param \DOMDocument $doc
     * @return \DOMElement
     */
    public function toXmlNode(DOMDocument $doc)
    {
        $valueElem = $doc->createElement('value');
        $attr = array_diff_key($this->getAttributes(), ['value' => true]);
        foreach ($attr as $name => $value) {
            $valueElem->setAttribute($name, $value);
        }
        $valueElem->appendChild($doc->createCDATASection($this->data));
        return $valueElem;
    }

    public function __toString()
    {
        return $this->data === null ? '' : (string) $this->data;
    }
}
