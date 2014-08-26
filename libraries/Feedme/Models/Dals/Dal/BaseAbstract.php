<?php

namespace Feedme\Models\Dals\Dal;

use Feedme\Models\Entities\EntityAbstract;
use Feedme\Models\Messages\Filters\Base as BaseFilter;
use Feedme\Models\Messages\Requests\Base as BaseRequest;

abstract class BaseAbstract implements BaseInterface
{

    /**
     * @param  BaseFilter $filter
     * @return mixed
     */
    public function parseQuery($filter)
    {
        $whereClause = array();

        if (!is_null($identity = $filter->identity)) {
            $whereClause[] = 'id=\'' . intval($identity) . '\'';
        }
        if (!is_null($active = $filter->active)) {
            $whereClause[] = 'active=\'' . intval($active) . '\'';
        }

        return $whereClause;
    }

    /**
     * @param  BaseFilter  $filter
     * @return array|mixed
     */
    public function parseFilterOptions($filter)
    {
        $options = array();
        //$_directionsAllowed = array('DESC', 'ASC');
        if (!is_null($limit = $filter->limit)) {
            $options['limit'] = intval($limit);
        }
        /*if (!is_null($order = $filter->order) &&
            !is_null($direction = $filter->direction) &&
            in_array($direction, $_directionsAllowed)) {
            $options['order'] = $order . " " . $direction;
        }*/

        return $options;
    }

    /**
     * @param  EntityAbstract $entity
     * @param  BaseRequest    $request
     * @return mixed|void
     */
    public function parseRequest(&$entity, $request)
    {
        if (!is_null($request->identity)) {
            $entity->setId(intval($request->identity));
        }
        if (!is_null($request->active)) {
            $entity->setActive($request->active);
        }
    }

    /**
     * @param $filter
     * @return array
     */
    final public function parseFilter($filter)
    {
        return array_merge(
            array(implode(' AND ', $this->parseQuery($filter))),
            $this->parseFilterOptions($filter)
        );
    }
}
