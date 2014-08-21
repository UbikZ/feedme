<?php

namespace Feedme\Models\Dals\Dal;

use Feedme\Models\Messages\DalMessage;
use Feedme\Models\Messages\Requests\Feed\Insert;
use Feedme\Models\Entities\Feed as EntityFeed;

class Feed
{
    /**
     * @param  Insert     $request
     * @return DalMessage
     */
    public function insert(Insert $request)
    {
        $feed = new EntityFeed();
        $feed->setIdCreator($request->idCreator);
        $feed->setDescription($request->description);
        $feed->setPublic($request->public);
        $feed->setType($request->type);
        $feed->setLabel($request->label);
        $feed->setUrl($request->url);
        $feed->setValidate(1); // set validation to "waiting"
        $feed->setAdddate((new \DateTime())->format('Y-m-d H:i:s'));

        $return = new DalMessage();
        $return->setSuccess($feed->save());
        $return->setErrorMessages($feed->getMessages());

        return $return;
    }
}
