<?php

namespace Peri22x\Attachment;

use DOMDocument;

use Peri22x\XmlNodeInterface;

/**
 * Model of an XML "attachment" Element.
 */
class Attachment implements AttachmentInterface, XmlNodeInterface
{
    private $filename;
    private $id;
    private $mimeType;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
    }

    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    public function getFilename()
    {
        return $this->filename;
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

        if (null !== $this->id) {
            $attr['id'] = $this->id;
        }
        if (null !== $this->mimeType) {
            $attr['mimeType'] = $this->mimeType;
        }
        if (null !== $this->filename) {
            $attr['filename'] = $this->filename;
        }

        return $attr;
    }

    /**
     * Return an XML "attachment" Element.
     *
     * @param \DOMDocument $doc
     * @return \DOMElement
     */
    public function toXmlNode(DOMDocument $doc)
    {
        $attachmentElem = $doc->createElement('attachment');
        foreach ($this->getAttributes() as $name => $value) {
            $attachmentElem->setAttribute($name, $value);
        }
        return $attachmentElem;
    }
}
