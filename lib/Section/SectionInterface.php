<?php

namespace Peri22x\Section;

/**
 * Interface of models of XML "section" Elements.
 */
interface SectionInterface
{
    /**
     * Format, suitable for DateTime::format, of timestamp attribute values.
     * @var string
     */
    const TIMESTAMP_FORMAT = 'Y-m-d';
    /**
     * Format, suitable for DateTime::format, of date and time attribute values.
     * @var string
     */
    const DATETIME_FORMAT = 'Y-m-d';
    /**
     * Name of XML "client" Elements.
     * @var string
     */
    const TYPE_CLIENT = 'client';
    /**
     * Name of XML "consult" Elements.
     * @var string
     */
    const TYPE_CONSULT = 'consult';
    /**
     * Name of XML "echo" Elements.
     * @var string
     */
    const TYPE_ECHO = 'echo';
    /**
     * Name of XML "intake" Elements.
     * @var string
     */
    const TYPE_INTAKE = 'intake';

    public function setId($id);

    public function setCreateStamp($createStamp);

    public function setUpdateStamp($updateStamp);

    public function setEffectStamp($effectStamp);

    public function addValue($conceptName, $value, $extraAttributes = []);

    /**
     * @return bool
     */
    public function hasId();

    /**
     * @return []
     */
    public function getAttributes();

    /**
     * @return \Peri22x\Value\Value[]
     */
    public function getValues();
}
