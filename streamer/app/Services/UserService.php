<?php


namespace App\Services;

use App\Entities\User;
use App\Repositories\UnitOfWorkInterface;
use Carbon\Carbon;
use Hash;

class UserService extends BaseService
{
    /**
     * @var UnitOfWorkInterface
     */
    private $entityManager;

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

    public function getAllUserRoles()
    {
        return $this
            ->entityManager
            ->getUserRolesRepository()
            ->findAll();
    }

    public function getUserById($id)
    {
        return $this
            ->entityManager
            ->getUsersRepository()
            ->find($id);
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $email
     * @param string $password
     * @param array $roleIds
     * @return int
     * @throws \RuntimeException
     */
    public function createUpdateUser(
        $id,
        $name,
        $email,
        $password,
        $roleIds
    ): int {
        $roleEntities = [];
        foreach ($roleIds as $role) {
            $roleEntities[] = $this
                ->entityManager
                ->getUserRolesRepository()
                ->find($role);
        }

        $entity = null;

        if (null === $id) {
            $entity = $this->getNewUser(
                $name,
                $email,
                $password,
                $roleEntities
            );
        } else {
            $entity = $this->getUpdatedUser(
                $id,
                $name,
                $roleEntities
            );
        }

        $this->entityManager->transactional(function () use ($entity) {

            $this->entityManager->persist($entity);

            $this->entityManager->flush();

        });

        return $entity->getId();
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @param array $roles
     * @return User
     * @throws \RuntimeException
     */
    private function getNewUser(
        string $name,
        string $email,
        string $password,
        $roles
    ): User {
        $entity = new User();

        $entity->setName($name);
        $entity->setEmail($email);
        $entity->setPassword(Hash::make($password));
        $entity->setCreatedAt(Carbon::now());
        $entity->setUpdatedAt(Carbon::now());
        $entity->setLockout(false);

        foreach ($roles as $role) {
            $entity->addToRole($role);
        }

        return $entity;
    }

    /**
     * @param $id
     * @param string $name
     * @param array $roles
     * @return User
     */
    private function getUpdatedUser(
        $id,
        string $name,
        $roles
    ): User {
        $entity = $this
            ->entityManager
            ->getUsersRepository()
            ->find($id);

        $entity->setName($name);
        $entity->setUpdatedAt(Carbon::now());

        $entity->clearRoles();
        foreach ($roles as $role) {
            $entity->addToRole($role);
        }

        return $entity;
    }
}