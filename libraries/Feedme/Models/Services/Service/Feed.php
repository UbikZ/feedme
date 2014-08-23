<?php

namespace Feedme\Models\Services\Service;

use Feedme\Logger\Factory;
use Feedme\Models\Dals\Dal;
use Feedme\Models\Messages\DalMessage;
use Feedme\Models\Messages\Filters\Feed\Select;
use Feedme\Models\Messages\Requests\Feed\Insert;
use Feedme\Models\Messages\ServiceMessage;
use Feedme\Models\Services\Exceptions\ServiceException;

class Feed
{
    /**
     * @param  Insert         $request
     * @return ServiceMessage
     */
    public function insert(Insert $request)
    {
        $message = new ServiceMessage();
        $dalMessage = new DalMessage();

        try {
            /** @var DalMessage $dalMessage */
            $dalMessage = Dal::getRepository('Feed')->insert($request);
            if (false === $dalMessage->getSuccess()) {
                throw new ServiceException($dalMessage);
            }
            $message->setSuccess(true);
            $message->setMessage($dalMessage->getSuccess());
        } catch (ServiceException $e) {
            $message->setErrors($dalMessage->getErrorMessages());
            Factory::getLogger('feed')->error($e->getMessage());
        } catch (\Exception $e) {
            $message->setError('An error occured while inserting feed');
            Factory::getLogger('feed')->error($e->getMessage());
        }

        return $message;
    }

    /**
     * @param  Select         $query
     * @return ServiceMessage
     */
    public function find(Select $query)
    {
        $message = new ServiceMessage();

        try {
            /** @var \Phalcon\Mvc\Model\Resultset\Simple $feeds */
            if (false === ($feeds = Dal::getRepository('Feed')->find($query))) {
                throw new ServiceException('Fail to get feeds.');
            }

            $message->setMessage($feeds);
            $message->setSuccess(true);
        } catch (ServiceException $e) {
            $message->setError($e->getMessage());
            Factory::getLogger('feed')->error($e->getMessage());
        } catch (\Exception $e) {
            $message->setError("An error occured while selecting feeds.");
            Factory::getLogger('feed')->error($e->getMessage());
        }

        return $message;
    }
}
