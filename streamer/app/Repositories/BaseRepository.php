<?php

namespace App\Repositories;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMInvalidArgumentException;

/**
 * This class serves as a repository of entities (see repository pattern)
 * with generic as well as business-specific methods for retrieving entities.
 *
 * This class is designed for inheritance and users should subclass it to
 * write their own repositories with business-specific methods.
 */
class BaseRepository
{
    /**
     * @var EntityRepository
     */
    private $entityRepository = null;

    /**
     * Entity class of this repository. If a repository class does
     * not configure this value, entity will be auto-discovered.
     *
     * @var null|string
     */
    protected $entityClass;

    /**
     * Repository constructor.
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        if ($this->entityClass === null) {
            // App\Repositories\EmailMessageRepository
            // =>
            // App\Entities\EmailMessage

            $repositoryClass = static::class;
            $this->entityClass = 'App\Entities' . substr($repositoryClass, 16, -10);
        }

        $this->entityRepository = new EntityRepository(
            $em,
            $em->getClassMetadata($this->entityClass)
        );
    }

    /**
     * @inheritdoc
     */
    protected function find($id)
    {
        return $this->entityRepository->find($id);
    }
}
