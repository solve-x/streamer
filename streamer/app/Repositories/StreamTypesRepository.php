<?php

namespace App\Repositories;

use App\Entities\StreamType;

class StreamTypesRepository extends BaseRepository
{
    protected $entityClass = StreamType::class;

    /**
     * @param $id
     * @return null|object|StreamType
     */
    public function find($id)
    {
        return parent::find($id);
    }
}