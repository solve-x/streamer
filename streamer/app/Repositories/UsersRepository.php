<?php

namespace App\Repositories;

use App\Entities\User;

class UsersRepository extends BaseRepository
{
    protected $entityClass = User::class;

    /**
     * @param $id
     * @return null|object|User
     */
    public function find($id)
    {
        return parent::find($id);
    }
}
