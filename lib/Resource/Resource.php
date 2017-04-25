<?php

namespace Peri22x\Resource;

use DOMDocument;

use Peri22x\Section\SectionInterface;
use Peri22x\XmlNodeInterface;

/**
 * Model of an XML "resource" Element.
 */
class Resource implements XmlNodeInterface
{
    /**
     * @var \Peri22x\Section\SectionInterface[]
     */
    private $sections = [];
    private $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * @return \Peri22x\Section\SectionInterface[]
     */
    public function getSections()
    {
        return $this->sections;
    }

    /**
     * @param \Peri22x\Section\SectionInterface $section
     */
    public function addSection(SectionInterface $section)
    {
        $nextId = 1 + sizeof($this->sections);
        if (! $section->hasId()) {
            $section->setId($nextId);
        }
        $this->sections[] = $section;
    }

    /**
     * @param array $sections
     */
    public function setSections(array $sections)
    {
        $this->sections = $sections;
    }

    public function getAttributes()
    {
        return ['type' => $this->type];
    }

    /**
     * Return an XML "resource" Element, replete with a child "sections" element
     * and descendant elements.
     *
     * @param \DOMDocument $doc
     * @return \DOMElement
     */
    public function toXmlNode(DOMDocument $doc)
    {
        $resourceElem = $doc->createElement('resource');
        foreach ($this->getAttributes() as $name => $value) {
            $resourceElem->setAttribute($name, $value);
        }
        $sectionsElem = $doc->createElement('sections');
        foreach ($this->getSections() as $s) {
            $sectionsElem->appendChild($s->toXmlNode($doc));
        }
        $resourceElem->appendChild($sectionsElem);
        return $resourceElem;
    }
}
