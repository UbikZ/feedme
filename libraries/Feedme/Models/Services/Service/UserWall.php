<?php

namespace Feedme\Models\Services\Service;

use Feedme\Logger\Factory;
use Feedme\Models\Dals\Dal;
use Feedme\Models\Messages\Filters\UserWall\Select;
use Feedme\Models\Messages\ServiceMessage;
use Feedme\Models\Services\Exceptions\ServiceException;

class UserWall extends ServiceAbstract
{
    /**
     * @param  Select         $query
     * @return ServiceMessage
     */
    public function count(Select $query)
    {
        $message = new ServiceMessage();

        try {
            if (false === ($count = Dal::getRepository('UserWall')->count($query))) {
                throw new ServiceException('Fail to count account posts.');
            }
            $message->setMessage($count);
            $message->setSuccess(true);
        } catch (ServiceException $e) {
            $message->setError($e->getMessage());
            Factory::getLogger('userwall')->error($e->getMessage());
        } catch (\Exception $e) {
            $message->setError('An error occured while selecting account messages');
            Factory::getLogger('userwall')->error($e->getMessage());
        }

        return $message;
    }
}
