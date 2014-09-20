<?php

namespace Feedme\Models\Services\Service;

use Feedme\Logger\Factory;
use Feedme\Models\Dals\Dal;
use Feedme\Models\Messages\DalMessage;
use Feedme\Models\Messages\Filters\FeedItem\Select;
use Feedme\Models\Messages\Requests\FeedItem\Insert;
use Feedme\Models\Messages\ServiceMessage;
use Feedme\Models\Services\Exceptions\ServiceException;
use Phalcon\Mvc\Model\Resultset\Simple;

class FeedItem extends ServiceAbstract
{
    /**
     * @param  Select         $query
     * @return ServiceMessage
     */
    public function find(Select $query)
    {
        $message = new ServiceMessage();

        try {
            /** @var Simple $feedItems */
            if (false === ($feedItems = Dal::getRepository('FeedItem')->find($query))) {
                throw new ServiceException('Fail to select feed items.');
            }
            $message->setMessage(($feedItems->count() > 1) ? $feedItems : $feedItems->getFirst());
            $message->setSuccess(true);
        } catch (ServiceException $e) {
            $message->setError($e->getMessage());
            Factory::getLogger('feeditem')->error($e->getMessage());
        } catch (\Exception $e) {
            $message->setError('An error occured while selecting feed items.');
            Factory::getLogger('feeditem')->error($e->getMessage());
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
            $query->idHashed = $request->idHashed;
            /** @var Simple $feedItems */
            $feedItems = Dal::getRepository('FeedItem')->find($query);

            // If we have no result => insert
            if ($feedItems->count() == 0) {
                $dalMessage = Dal::getRepository('FeedItem')->insert($request);
            } else {
                $dalMessage->setSuccess(true);
            }

            /** @var DalMessage $dalMessage */
            if (false === $dalMessage->getSuccess()) {
                throw new ServiceException($dalMessage);
            }

            $message->setSuccess(true);
            $message->setMessage($dalMessage->getSuccess());
        } catch (ServiceException $e) {
            $message->setError($dalMessage->getErrorMessages());
            Factory::getLogger('feeditem')->error($e->getMessage());
        } catch (\Exception $e) {
            $message->setError("An error occured while inserting feeditem.");
            Factory::getLogger('feeditem')->error($e->getMessage());
        }

        return $message;
    }
}
