<?php

namespace Feedme\Models\Services\Service;

use Feedme\Logger\Factory;
use Feedme\Models\Dals\Dal;
use Feedme\Models\Messages\DalMessage;
use Feedme\Models\Messages\Filters\UserFeed\Select;
use Feedme\Models\Messages\Requests\UserFeed\Insert;
use Feedme\Models\Messages\ServiceMessage;
use Feedme\Models\Services\Exceptions\ServiceException;
use Phalcon\Mvc\Model\Resultset\Simple;

class UserFeed
{
    /**
     * @param  Select         $query
     * @return ServiceMessage
     */
    public function find(Select $query)
    {
        $message = new ServiceMessage();

        try {
            /** @var Simple $userFeeds */
            if (false === ($userFeeds = Dal::getRepository('UserFeed')->find($query))) {
                throw new ServiceException('Fail to select infos feeds.');
            }
            $message->setMessage(($userFeeds->count() > 1) ? $userFeeds : $userFeeds->getFirst());
            $message->setSuccess(true);
        } catch (ServiceException $e) {
            $message->setError($e->getMessage());
            Factory::getLogger('userfeed')->error($e->getMessage());
        } catch (\Exception $e) {
            $message->setError('An error occured while selecting feeds info');
            Factory::getLogger('userfeed')->error($e->getMessage());
        }

        return $message;
    }

    /**
     * @param  Insert         $request
     * @return ServiceMessage
     */
    public function insert(Insert $request)
    {
        $message = new ServiceMessage();
        $dalMessage = new DalMessage();

        try {
            $query = new Select();
            $query->idFeed = $request->idFeed;
            $query->idUser = $request->idUser;
            /** @var Simple $userFeeds */
            $userFeeds = Dal::getRepository('UserFeed')->find($query);
            // If we have no result => insert
            /** @var UserFeed $userFeed */
            if ($userFeeds->count() == 0) {
                $dalMessage = Dal::getRepository('UserFeed')->insert($request);
            } elseif ($userFeeds->count() == 1) { // Selse => update
                $dalMessage = Dal::getRepository('UserFeed')->update($userFeeds->getFirst(), $request);
            } else {
                throw new ServiceException('There are too many userFeeds');
            }
            /** @var DalMessage $dalMessage */
            if (false === $dalMessage->getSuccess()) {
                throw new ServiceException($dalMessage);
            }

            $message->setSuccess(true);
            $message->setMessage($dalMessage->getSuccess());
        } catch (ServiceException $e) {
            $message->setError($dalMessage->getErrorMessages());
            Factory::getLogger('userfeed')->error($e->getMessage());
        } catch (\Exception $e) {
            $message->setError("An error occured while inserting/updating userfeed.");
            Factory::getLogger('userfeed')->error($e->getMessage());
        }

        return $message;
    }
}
