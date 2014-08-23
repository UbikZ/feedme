<?php

namespace Feedme\Models\Entities;

interface EntityInterface
{
    /**
     * @param bool $pbBase
     * @param array $options
     * @return mixed
     */
    public function getSerializable($pbBase = false, $options = array());
}
