<?php


namespace App\Services;


use App\Repositories\UnitOfWorkInterface;

class UserService extends BaseService
{
    /**
     * @var UnitOfWorkInterface
     */
    private $entityManager = null;

    /**
     * UserService constructor.
     * @param UnitOfWorkInterface $entityManager
     */
    public function __construct(UnitOfWorkInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getAllUsers()
    {
        return $this
            ->entityManager
            ->getUsersRepository()
            ->findAll();
    }
}