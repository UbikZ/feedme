<?php

namespace Feedme\Models\Services\Service;

use Feedme\Logger\Factory;
use Feedme\Models\Dals\Dal;
use Feedme\Models\Messages\Filters\UserPicture\Select;
use Feedme\Models\Messages\ServiceMessage;
use Feedme\Models\Services\Exceptions\ServiceException;

class UserPicture
{
    /**
     * @param  Select         $query
     * @return ServiceMessage
     */
    public function find(Select $query)
    {
        $message = new ServiceMessage();

        try {
            if (false === ($userPictures = Dal::getRepository('UserPicture')->find($query))) {
                throw new ServiceException('Can\'t load picture user images.');
            }

            $message->setMessage($userPictures);
            $message->setSuccess(true);
        } catch (ServiceException $e) {
            $message->setError($e->getMessage());
            Factory::getLogger('user-picture')->error($e->getMessage());
        } catch (\Exception $e) {
            $message->setError("An error occured while selecting picture user images.");
            Factory::getLogger('user-picture')->error($e->getMessage());
        }

        return $message;
    }
}
