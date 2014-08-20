<?php

namespace Feedme\Models\Services\Service;

use Feedme\Logger\Factory;
use Feedme\Models\Dals\Dal;
use Feedme\Models\Messages\Filters\FeedType\Select;
use Feedme\Models\Messages\ServiceMessage;
use Feedme\Models\Services\Exceptions\ServiceException;

class FeedType
{
    /**
     * @param  Select         $query
     * @return ServiceMessage
     */
    public function find(Select $query)
    {
        $message = new ServiceMessage();

        try {
            /** @var \Phalcon\Mvc\Model\Resultset\Simple $feedsType */
            if (false === ($feedsType = Dal::getRepository('FeedType')->find($query))) {
                throw new ServiceException('FeedType fail.');
            }

            $message->setMessage(($feedsType->count() > 1) ? $feedsType : $feedsType->getFirst());
            $message->setSuccess(true);
        } catch (ServiceException $e) {
            $message->setError($e->getMessage());
            Factory::getLogger('feedtype')->error($e->getMessage());
        } catch (\Exception $e) {
            $message->setError("An error occured while selecting type feeds.");
            Factory::getLogger('feedtype')->error($e->getMessage());
        }

        return $message;
    }
}
