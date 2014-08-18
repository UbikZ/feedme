<?php

namespace Feedme\Models\Services\Service;

use Feedme\Logger\Factory;
use Feedme\Models\Dals\Dal;
use Feedme\Models\Messages\Filters\File\Select;
use Feedme\Models\Messages\ServiceMessage;
use Feedme\Models\Services\Exceptions\ServiceException;

class File
{
    public function find(Select $query)
    {
        $message = new ServiceMessage();

        try {
            $message->setMessage(Dal::getRepository('File')->find($query));
            $message->setSuccess(true);
        } catch (ServiceException $e) {
            $message->setError($e->getMessage());
            Factory::getLogger('file')->error($e->getMessage());
        } catch (\Exception $e) {
            $message->setError("An error occured while accessing file.");
            Factory::getLogger('file')->error($e->getMessage());
        }

        return $message;
    }
}
