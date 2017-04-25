<?php

namespace Peri22x\Resource;

class ResourceFactory
{
    /**
     * Create a Reource of the specified type.
     *
     * @param string $type
     * @return \Peri22x\Resource\Resource
     */
    public function create($type)
    {
        return new Resource($type);
    }
}
