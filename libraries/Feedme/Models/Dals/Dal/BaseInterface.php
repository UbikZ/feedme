<?php

namespace Feedme\Models\Dals\Dal;

use Feedme\Models\Entities\EntityAbstract;

interface BaseInterface
{
    /**
     * @param $filter
     * @return mixed
     */
    public function _parseQuery($filter);

    /**
     * @param $filter
     * @return mixed
     */
    public function _parseFilterOptions($filter);

    /**
     * @param  EntityAbstract $entity
     * @param $request
     * @return mixed
     */
    public function _parseRequest(&$entity, $request);
}
