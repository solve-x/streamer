<?php

namespace App\Repositories;

use App\Entities\StreamType;

class StreamTypesRepository extends BaseRepository
{
    protected $entityClass = StreamType::class;

    /**
     * @param $id
     * @return null|StreamType
     */
    public function find($id)
    {
        return parent::find($id);
    }
}