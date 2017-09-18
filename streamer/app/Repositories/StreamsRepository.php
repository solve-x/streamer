<?php


namespace App\Repositories;


use App\Entities\Stream;

class StreamsRepository extends BaseRepository
{
    protected $entityClass = Stream::class;

    /**
     * @param $id
     * @return null|object|Stream
     */
    public function find($id)
    {
        return parent::find($id);
    }

    /**
     * @param array $criteria
     * @return null|object|Stream
     */
    public function findOneBy(array $criteria)
    {
        return parent::findOneBy($criteria);
    }
}