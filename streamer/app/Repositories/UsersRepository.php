<?php

namespace App\Repositories;

use App\Enumerations\StreamRole;
use App\Enumerations\UserRole;
use DB;

class UsersRepository extends BaseRepository
{
    protected $tableName = 'users';

    /**
     * @param number $userId
     * @param UserRole $role
     * @return bool
     */
    public function isInUserRole(number $userId, UserRole $role)
    {
        return DB::table('users_user_roles')
            ->where('User_Id', '=', $userId)
            ->where('Role_Id', '=', $role)
            ->first() !== null;
    }

    /**
     * @param number $userId
     * @param StreamRole|UserRole $role
     * @return bool
     */
    public function isInStreamRole(number $userId, StreamRole $role)
    {
        return DB::table('streams_stream_roles')
            ->where('User_Id', '=', $userId)
            ->where('Role_Id', '=', $role)
            ->first() !== null;
    }
}
