<?php


namespace App\Repositories;


interface UnitOfWorkInterface
{
    public function persist($entity);

    public function remove($entity);

    public function flush();

    public function transactional(callable $callback);

    /**
     * @return UsersRepository
     */
    public function getUsersRepository();

    /**
     * @return StreamTypesRepository
     */
    public function getStreamTypesRepository();

    /**
     * @return StreamsRepository
     */
    public function getStreamsRepository();

    /**
     * @return UserRolesRepository
     */
    public function getUserRolesRepository();
}