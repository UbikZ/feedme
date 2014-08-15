<?php

namespace Feedme\Models\Dals\Dal;

use Feedme\Models\Entities\UserWall as EntityUserWall;
use Feedme\Models\Entities\UserWallMessage as EntityUserWallMessage;
use Feedme\Models\Messages\Requests\UserWallMessage\Insert;

class UserWallMessage
{
    public function insert(Insert $request)
    {
        // Insert in UserWallMessage
        $userWallMessage = new EntityUserWallMessage();
        $userWallMessage->setMessage($request->message);
        $userWallMessage->setAdddate((new \DateTime())->format('Y-m-d H:i:s'));
        $userWallMessage->setIdMessageSrc($request->idMessageSrc);
        $userWallMessage->setIdUserSrc($request->idUserSrc);
        $resultWallMessage = $userWallMessage->save();

        // Insert in UserWall
        $resultWall = true;
        if (is_null($request->idMessageSrc) && $resultWallMessage) {
            $userWall = new EntityUserWall();
            $userWall->setActive(true);
            $userWall->setIdUser($request->idUserDest);
            $userWall->setIdMessage($userWallMessage->getId());
            $resultWall = $userWall->save();
        }

        return $resultWall && $resultWallMessage;
    }
}
