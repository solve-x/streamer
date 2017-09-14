<?php


namespace App\Repositories;


interface UnitOfWorkInterface
{
    public function persist(object $entity);

    public function remove(object $entity);

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
}