<?php


namespace App\Repositories;

use App\Entities\Stream;
use App\Entities\StreamType;
use App\Entities\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class DoctrineUnitOfWork implements UnitOfWorkInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager = null;

    /**
     * DoctrineUnitOfWork constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function persist($entity)
    {
        $this->entityManager->persist($entity);
    }

    public function remove($entity)
    {
        $this->entityManager->remove($entity);
    }

    public function flush()
    {
        $this->entityManager->flush();
    }

    public function transactional(callable $callback)
    {
        $this->entityManager->transactional($callback);
    }

    /**
     * @return UsersRepository|EntityRepository
     */
    public function getUsersRepository()
    {
        return $this->entityManager->getRepository(User::class);
    }

    /**
     * @return StreamTypesRepository|EntityRepository
     */
    public function getStreamTypesRepository()
    {
        return $this->entityManager->getRepository(StreamType::class);
    }

    /**
     * @return StreamsRepository|StreamsRepository
     */
    public function getStreamsRepository()
    {
        return $this->entityManager->getRepository(Stream::class);
    }
}