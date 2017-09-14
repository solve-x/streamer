<?php

namespace App\Repositories;

use App\Entities\User;

class UsersRepository extends BaseRepository
{
    protected $entityClass = User::class;
}
