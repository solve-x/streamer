<?php

namespace App\Services;

use App\Entities\Stream;
use App\Entities\User;
use App\Repositories\UnitOfWorkInterface;
use Carbon\Carbon;

class StreamService extends BaseService
{
    /**
     * @var UnitOfWorkInterface
     */
    private $entityManager;

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
     * @return string|null
     */
    public function getHLSFragmentPath(string $fragmentName)
    {
        $fragmentsDirectory = env('HLS_DIR');

        $fragmentPath = "$fragmentsDirectory/$fragmentName";

        if (!file_exists($fragmentPath)) {
            return null;
        }

        return $fragmentPath;
    }

    public function getAllStreams()
    {
        return $this->entityManager->getStreamsRepository()->findAll();
    }

    public function getAllStreamTypes()
    {
        return $this->entityManager->getStreamTypesRepository()->findAll();
    }

    public function createNewStream(
        string $name,
        string $streamKey,
        int $typeId,
        int $createdById
    ): int
    {
        $selectedType = $this
            ->entityManager
            ->getStreamTypesRepository()
            ->find($typeId);

        $user = $this
            ->entityManager
            ->getUsersRepository()
            ->find($createdById);

        $stream = new Stream(
            null,
            $name,
            $streamKey,
            $selectedType,
            $user,
            Carbon::now(),
            null
        );

        $this->entityManager->transactional(function () use ($stream) {

            $this->entityManager->persist($stream);

            $this->entityManager->flush();
        });

        return $stream->getId();
    }

    public function existsByFragmentName(string $fragmentName): bool
    {
        $fragmentName = pathinfo($fragmentName)['filename'];

        $stream = $this->entityManager->getStreamsRepository()->findOneBy([
            'streamKey' => $fragmentName
        ]);

        return null !== $stream;
    }

    public function userHasAccess(User $user): bool
    {
        return $user !== null;
    }
}