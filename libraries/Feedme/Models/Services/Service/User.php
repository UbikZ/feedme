<?php

namespace Feedme\Models\Services\Service;

use Feedme\Logger\Factory;
use Feedme\Models\Dals\Dal;
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

        try {
            if (is_null($request->id)) {
                throw new \Exception('Invalid parameter given.');
            }
            $query = new Select();
            $query->id = $request->id;
            /** @var \Phalcon\Mvc\Model\Resultset\Simple $users */
            if (false === ($users = Dal::getRepository('User')->find($query))) {
                throw new \Exception('Can\'t load user `' . $query->id . '`.');
            }
            if (false === ($result = Dal::getRepository('User')->update($users->getFirst(), $request))) {
                throw new ServiceException('You can\'t update the account for now.');
            }

            $message->setMessage($result);
            $message->setSuccess(true);
        } catch (ServiceException $e) {
            $message->setError($e->getMessage());
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
            /** @var \Phalcon\Mvc\Model\Resultset\Simple $users */
            if (false === ($users = Dal::getRepository('User')->find($query))) {
                throw new ServiceException('Authentication failed.');
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
