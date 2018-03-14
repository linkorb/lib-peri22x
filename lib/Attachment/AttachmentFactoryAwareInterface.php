<?php

namespace Peri22x\Attachment;

interface AttachmentFactoryAwareInterface
{
    /**
     * @param \Peri22x\Attachment\AttachmentFactory $attachmentFactory
     */
    public function setAttachmentFactory(AttachmentFactory $attachmentFactory);
}
