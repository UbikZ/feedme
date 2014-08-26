<?php

namespace Feedme\Models\Dals\Dal;

use Feedme\Models\Entities\EntityAbstract;

interface BaseInterface
{
    /**
     * @param $filter
     * @return mixed
     */
    public function parseQuery($filter);

    /**
     * @param $filter
     * @return mixed
     */
    public function parseFilterOptions($filter);

    /**
     * @param  EntityAbstract $entity
     * @param $request
     * @return mixed
     */
    public function parseRequest(&$entity, $request);
}
