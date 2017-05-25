<?php

namespace Peri22x\Attachment;

/**
 * Interface of models of XML "attachment" Elements.
 */
interface AttachmentInterface
{
    public function setId($id);

    public function setMimeType($mimeType);

    /**
     * @return bool
     */
    public function hasId();

    /**
     * @return []
     */
    public function getAttributes();
}
