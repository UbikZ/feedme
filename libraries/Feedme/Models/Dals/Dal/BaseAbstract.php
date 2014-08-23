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
    public function _parseQuery($filter)
    {
        $whereClause = array();

        if (!is_null($id = $filter->id)) {
            $whereClause[] = 'id=\'' . intval($id) . '\'';
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
    public function _parseFilterOptions($filter)
    {
        $options = array();
        $_directionsAllowed = array('DESC', 'ASC');
        if (!is_null($limit = $filter->limit)) {
            $options['limit'] = intval($limit);
        }
        if (!is_null($order = $filter->order) &&
            !is_null($direction = $filter->direction) &&
            in_array($direction, $_directionsAllowed)) {
            $options['order'] = $order . " " . $direction;
        }

        return $options;
    }

    /**
     * @param  EntityAbstract $entity
     * @param  BaseRequest    $request
     * @return mixed|void
     */
    public function _parseRequest(&$entity, $request)
    {
        if (!is_null($request->id)) {
            $entity->setId(intval($request->id));
        }
        if (!is_null($request->active)) {
            $entity->setActive($request->active);
        }
    }

    /**
     * @param $filter
     * @return array
     */
    final public function _parseFilter($filter)
    {
        return array_merge(
            array(implode(' AND ', $this->_parseQuery($filter))),
            $this->_parseFilterOptions($filter)
        );
    }
}
