<?php

namespace App\Services;


use App\Entities\Stream;
use App\Entities\StreamType;
use App\Entities\User;
use App\Repositories\UnitOfWorkInterface;
use Carbon\Carbon;
use Doctrine\ORM\EntityManager;

class StreamService extends BaseService
{
    /**
     * @var UnitOfWorkInterface
     */
    private $entityManager = null;

    /**
     * StreamService constructor.
     * @param UnitOfWorkInterface $entityManager
     */
    public function __construct(UnitOfWorkInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $fragmentName
     * @param User $user
     * @return string
     */
    public function getHLSFragmentPath(
        string $fragmentName,
        User $user): string
    {
        $this->entityManager->transactional(function () use ($user) {

            $type = $this
                ->entityManager
                ->getStreamTypesRepository()
                ->find(1);

            $stream = new Stream(
                null,
                'test',
                'asd',
                $type,
                $user,
                Carbon::now(),
                null
            );

            $this->entityManager->persist($stream);
            $user->getStreams()->add($stream);

            $this->entityManager->flush();
        });

        return "";
    }
}