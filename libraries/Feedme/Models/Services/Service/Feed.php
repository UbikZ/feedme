<?php

namespace Feedme\Models\Services\Service;

use Feedme\Logger\Factory;
use Feedme\Models\Dals\Dal;
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
            if (false === ($result = Dal::getRepository('Feed')->insert($request))) {
                throw new ServiceException('Fail to insert feed.');
            }
            $message->setSuccess(true);
            $message->setMessage($result);
        } catch (ServiceException $e) {
            $message->setError($e->getMessage());
            Factory::getLogger('feed')->error($e->getMessage());
        } catch (\Exception $e) {
            $message->setError('An error occured while inserting feed');
            Factory::getLogger('feed')->error($e->getMessage());
        }

        return $message;
    }
}
