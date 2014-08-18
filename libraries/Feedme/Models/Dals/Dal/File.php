<?php

namespace Feedme\Models\Dals\Dal;

use Feedme\Models\Messages\Filters\File\Select;
use Feedme\Models\Entities\File as EntityFile;

class File
{
    public function find(Select $query)
    {
        return new EntityFile($query->path);
    }
}
