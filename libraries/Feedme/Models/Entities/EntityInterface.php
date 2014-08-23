<?php

namespace Feedme\Models\Entities;

interface EntityInterface
{
    /**
     * @param  bool  $pbBase
     * @return mixed
     */
    public function getSerializable($pbBase = false);
}
