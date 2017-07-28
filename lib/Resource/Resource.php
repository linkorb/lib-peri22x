<?php

namespace Peri22x\Resource;

use DOMDocument;

use Peri22x\Attachment\AttachmentInterface;
use Peri22x\Section\SectionInterface;
use Peri22x\XmlNodeInterface;

/**
 * Model of an XML "resource" Element.
 */
class Resource implements XmlNodeInterface
{
    /**
     * @var \Peri22x\Attachment\AttachmentInterface[]
     */
    private $attachments = [];
    /**
     * @var \Peri22x\Section\SectionInterface[]
     */
    private $sections = [];
    private $sectionsByType = [];
    private $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * The Type of the Resource, e.g. "hub/dossier".
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return \Peri22x\Attachment\AttachmentInterface[]
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * @param \Peri22x\Attachment\AttachmentInterface $attachment
     */
    public function addAttachment(AttachmentInterface $attachment)
    {
        $this->attachments[] = $attachment;
        if (!$attachment->hasId()) {
            $attachment->setId(sizeof($this->attachments));
        }
    }

    /**
     * @param array $attachments
     */
    public function setAttachments(array $attachments)
    {
        $this->attachments = $attachments;
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
        $this->sections[] = $section;
        if (!$section->hasId()) {
            $section->setId(sizeof($this->sections));
        }
        $this->recordSectionByType($section, $section->getType());
    }

    /**
     * Determine whether the Resource has a Section of the given type name.
     *
     * @param string $type
     * @return bool
     */
    public function hasSection($type)
    {
        return array_key_exists($type, $this->sectionsByType);
    }

    /**
     * Get a Section of the given type name.
     *
     * This implementation returns only the first Section of the given type.
     *
     * @param string $type
     * @return null|\Peri22x\Section\SectionInterface
     */
    public function getSection($type)
    {
        if (!array_key_exists($type, $this->sectionsByType)) {
            return null;
        }
        return $this->sectionsByType[$type][0];
    }

    public function getAttributes()
    {
        return ['type' => $this->type];
    }

    /**
     * Return an XML "resource" Element, replete with children "sections" and
     * "attachments" elements and their descendant elements.
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
        $attachmentsElem = $doc->createElement('attachments');
        foreach ($this->getAttachments() as $a) {
            $attachmentsElem->appendChild($a->toXmlNode($doc));
        }
        $resourceElem->appendChild($attachmentsElem);
        return $resourceElem;
    }

    private function recordSectionByType(SectionInterface $section, $type)
    {
        if (!isset($this->sectionsByType[$type])) {
            $this->sectionsByType[$type] = [];
        }
        $this->sectionsByType[$type][] = $section;
    }
}
