<?php

namespace Peri22x;

use DOMDocument;

/**
 * An Interface of models of XML Elements.
 */
interface XmlNodeInterface
{
    /**
     * Return an XML Element.
     *
     * @param \DOMDocument $doc
     * @return \DOMElement
     */
    public function toXmlNode(DOMDocument $doc);
}
