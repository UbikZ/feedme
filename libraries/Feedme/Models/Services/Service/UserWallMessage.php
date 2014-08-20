<?php

namespace Feedme\Models\Services\Service;

use Feedme\Logger\Factory;
use Feedme\Models\Dals\Dal;
use Feedme\Models\Messages\DalMessage;
use Feedme\Models\Messages\Filters\UserWallMessage\Select;
use Feedme\Models\Messages\Requests\UserWallMessage\Insert;
use Feedme\Models\Messages\ServiceMessage;
use Feedme\Models\Services\Exceptions\ServiceException;

class UserWallMessage
{
    /**
     * @param  Select         $query
     * @return ServiceMessage
     */
    public function count(Select $query)
    {
        $message = new ServiceMessage();

        try {

            if (false === ($result = Dal::getRepository('UserWallMessage')->count($query))) {
                throw new ServiceException('Fail to count posts.');
            }
            $message->setMessage($result);
            $message->setSuccess(true);
        } catch (ServiceException $e) {
            $message->setError($e->getMessage());
            Factory::getLogger('userwallmessage')->error($e->getMessage());
        } catch (\Exception $e) {
            $message->setError('An error occured while counting messages');
            Factory::getLogger('userwallmessage')->error($e->getMessage());
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

        try {
            /** @var DalMessage $dalMessage */
            $dalMessage = Dal::getRepository('UserWallMessage')->insert($request);
            if (false === $dalMessage->getSuccess()) {
                throw new ServiceException($dalMessage);
            }
            $message->setSuccess(true);
            $message->setMessage($dalMessage->getSuccess());
        } catch (ServiceException $e) {
            $message->setError($dalMessage->getErrorMessages());
            Factory::getLogger('userwallmessage')->error($e->getMessage());
        } catch (\Exception $e) {
            $message->setError('An error occured while inserting messages');
            Factory::getLogger('userwallmessage')->error($e->getMessage());
        }

        return $message;
    }

    /**
     * @param  Select         $query
     * @return ServiceMessage
     */
    public function delete(Select $query)
    {
        $message = new ServiceMessage();

        try {
            if (!is_numeric($query->id)) {
                throw new  ServiceException('Wrong parameter given');
            }
            if (false === ($result = Dal::getRepository('UserWallMessage')->delete($query))) {
                throw new ServiceException('Fail to delete this post.');
            }
            $message->setMessage($result);
            $message->setSuccess(true);
        } catch (ServiceException $e) {
            $message->setError($e->getMessage());
            Factory::getLogger('userwallmessage')->error($e->getMessage());
        } catch (\Exception $e) {
            $message->setError('An error occured while deleting messages');
            Factory::getLogger('userwallmessage')->error($e->getMessage());
        }

        return $message;
    }
}
