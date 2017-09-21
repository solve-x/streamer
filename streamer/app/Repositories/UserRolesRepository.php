<?php


namespace App\Repositories;


use App\Entities\UserRole;

class UserRolesRepository extends BaseRepository
{
    protected $entityClass = UserRole::class;

    /**
     * @param $id
     * @return null|object|UserRole
     */
    public function find($id)
    {
        return parent::find($id);
    }
}