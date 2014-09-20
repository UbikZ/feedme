<?php

namespace Feedme\Models\Services\Service;

use Feedme\Logger\Factory;
use Feedme\Models\Dals\Dal;
use Feedme\Models\Messages\DalMessage;
use Feedme\Models\Messages\ServiceMessage;
use Feedme\Models\Messages\Filters\User\Select;
use Feedme\Models\Messages\Requests\User\Update;
use Feedme\Models\Services\Exceptions\ServiceException;

class User
{
    /**
     * @param  Update         $request
     * @return ServiceMessage
     */
    public function update(Update $request)
    {
        $message = new ServiceMessage();
        $dalMessage = null;

        try {
            if (is_null($request->identity)) {
                throw new \Exception('Invalid parameter given.');
            }
            $query = new Select();
            $query->identity = $request->identity;
            /** @var \Phalcon\Mvc\Model\Resultset\Simple $users */
            if (false === ($users = Dal::getRepository('User')->find($query))) {
                throw new \Exception('Can\'t load user `' . $query->identity . '`.');
            }

            /** @var DalMessage $dalMessage */
            $dalMessage = Dal::getRepository('User')->update($users->getFirst(), $request);
            if (false === $dalMessage->getSuccess()) {
                throw new ServiceException($dalMessage);
            }

            $message->setSuccess(true);
            $message->setMessage($dalMessage->getSuccess());
        } catch (ServiceException $e) {
            $message->setError($dalMessage->getErrorMessages());
            Factory::getLogger('user')->error($e->getMessage());
        } catch (\Exception $e) {
            $message->setError("An error occured while updating account.");
            Factory::getLogger('user')->error($e->getMessage());
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
            $users = Dal::getRepository('User')->find($query);

            /** @var \Phalcon\Mvc\Model\Resultset\Simple $users */
            if (false === $users) {
                throw new ServiceException('Authentication failed.');
            }
            /** @var \Phalcon\Mvc\Model\Resultset\Simple $users */
            if (0 == $users->count()) {
                throw new ServiceException('Invalid email/password.');
            }

            $message->setMessage(($users->count() > 1) ? $users : $users->getFirst());
            $message->setSuccess(true);
        } catch (ServiceException $e) {
            $message->setError($e->getMessage());
            Factory::getLogger('user')->error($e->getMessage());
        } catch (\Exception $e) {
            $message->setError("An error occured while selecting account.");
            Factory::getLogger('user')->error($e->getMessage());
        }

        return $message;
    }
}
