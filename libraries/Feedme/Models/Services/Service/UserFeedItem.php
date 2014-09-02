<?php

namespace Feedme\Models\Services\Service;

use Feedme\Logger\Factory;
use Feedme\Models\Dals\Dal;
use Feedme\Models\Messages\DalMessage;
use Feedme\Models\Messages\Filters\UserFeedItem\Select;
use Feedme\Models\Messages\Requests\UserFeedItem\Update;
use Feedme\Models\Messages\ServiceMessage;
use Feedme\Models\Services\Exceptions\ServiceException;

class UserFeedItem
{
    /**
     * @param  Update         $request
     * @return ServiceMessage
     */
    public function update(Update $request)
    {
        $message = new ServiceMessage();

        try {
            if (is_null($request->idUser) || is_null($request->idFeedItem)) {
                throw new \Exception('Invalid parameter given.');
            }
            $query = new Select();
            $query->idUser = $request->idUser;
            $query->idFeedItem = $request->idFeedItem;
            /** @var \Phalcon\Mvc\Model\Resultset\Simple $users */
            if (false === ($userFeedItems = Dal::getRepository('UserFeedItem')->find($query))) {
                throw new \Exception('Can\'t load userFeedItem');
            }

            /** @var DalMessage $daMessage */
            $daMessage = Dal::getRepository('UserFeedItem')->update($userFeedItems->getFirst(), $request);
            if (false === $daMessage->getSuccess()) {
                throw new ServiceException($daMessage);
            }

            $message->setSuccess(true);
            $message->setMessage($daMessage->getSuccess());
        } catch (ServiceException $e) {
            $message->setError($daMessage->getErrorMessages());
            Factory::getLogger('user')->error($e->getMessage());
        } catch (\Exception $e) {
            $message->setError("An error occured while updating userfeeditem.");
            Factory::getLogger('user')->error($e->getMessage());
        }

        return $message;
    }
}
