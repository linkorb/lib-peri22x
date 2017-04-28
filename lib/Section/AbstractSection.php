<?php

namespace Peri22x\Section;

use DOMDocument;

use Peri22x\Value\ValueFactory;
use Peri22x\XmlNodeInterface;

/**
 * Abstract model of an XML "section" Element.
 *
 * Implementations should override the $permittedConcepts property with a list
 * of concepts permitted to be values within that Section.
 */
abstract class AbstractSection implements SectionInterface, XmlNodeInterface
{
    private $type;
    private $id;
    private $createStamp;
    private $updateStamp;
    private $effectStamp;

    protected $permittedConcepts = [];
    protected $values = [];
    protected $valueFactory;

    public function __construct(ValueFactory $valueFactory, $type)
    {
        $this->valueFactory = $valueFactory;
        $this->type = $type;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setCreateStamp($createStamp)
    {
        $this->createStamp = $createStamp;
    }

    public function setUpdateStamp($updateStamp)
    {
        $this->updateStamp = $updateStamp;
    }

    public function setEffectStamp($effectStamp)
    {
        $this->effectStamp = $effectStamp;
    }

    public function hasId()
    {
        return $this->id !== null;
    }

    /**
     * @return []
     */
    public function getAttributes()
    {
        $attr = [];
        $attr['type'] = $this->type;

        if (null !== $this->id) {
            $attr['id'] = $this->id;
        }
        if (null !== $this->createStamp) {
            $attr['createStamp'] = $this->createStamp;
        }
        if (null !== $this->updateStamp) {
            $attr['updateStamp'] = $this->updateStamp;
        }
        if (null !== $this->effectStamp) {
            $attr['effectStamp'] = $this->effectStamp;
        }

        return $attr;
    }

    public function addValue($conceptName, $value, $extraAttributes = [])
    {
        if (!in_array($conceptName, $this->permittedConcepts)) {
            throw new SectionError(
                "The concept \"{$conceptName}\" is not permitted for Section \"{$this->type}\"."
            );
        }
        $this->values[] = $this->valueFactory->create($conceptName, $value, $extraAttributes);
    }

    /**
     * @return \Peri22x\Value\Value[]
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * Return an XML "section" Element, replete with a child "resource" element
     * and descendant elements.
     *
     * @param \DOMDocument $doc
     * @return \DOMElement
     */
    public function toXmlNode(DOMDocument $doc)
    {
        $sectionElem = $doc->createElement('section');
        foreach ($this->getAttributes() as $name => $value) {
            $sectionElem->setAttribute($name, $value);
        }
        foreach ($this->getValues() as $v) {
            $sectionElem->appendChild($v->toXmlNode($doc));
        }
        return $sectionElem;
    }
}
