<?php

namespace Feedme\Models\Services\Service;

use Feedme\Logger\Factory;
use Feedme\Models\Dals\Dal;
use Feedme\Models\Messages\DalMessage;
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
}
