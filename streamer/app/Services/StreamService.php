<?php

namespace App\Services;

use App\Entities\Stream;
use App\Entities\StreamType;
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

    public function createUpdateStream(
        $streamId,
        string $name,
        string $streamKey,
        int $typeId,
        int $createdById,
        bool $isLive
    ): int
    {
        $selectedType = $this
            ->entityManager
            ->getStreamTypesRepository()
            ->find($typeId);

        if (null === $streamId) {

            $user = $this
                ->entityManager
                ->getUsersRepository()
                ->find($createdById);

            return $this->createNewStream(
                $name,
                $streamKey,
                $selectedType,
                $user,
                $isLive
            );
        }

        return $this->updateStream(
            $streamId,
            $name,
            $streamKey,
            $selectedType,
            $isLive
        );
    }

    private function createNewStream(
        string $name,
        string $streamKey,
        StreamType $type,
        User $createdBy,
        bool $isLive
    ): int
    {
        $stream = new Stream(
            null,
            $name,
            $streamKey,
            $type,
            $createdBy,
            Carbon::now(),
            $isLive
        );

        $this->entityManager->transactional(function () use ($stream) {

            $this->entityManager->persist($stream);

            $this->entityManager->flush();
        });

        return $stream->getId();
    }

    private function updateStream(
        int $id,
        string $name,
        string $streamKey,
        StreamType $type,
        bool $isLive
    ): int
    {
        $entity = $this->getStreamById($id);

        $entity->setName($name);
        $entity->setStreamKey($streamKey);
        $entity->setType($type);
        $entity->setIsLive($isLive);

        $this->entityManager->transactional(function () use ($entity) {

            $this->entityManager->persist($entity);

            $this->entityManager->flush();
        });

        return $entity->getId();
    }

    public function deleteStream(int $id): bool
    {
        $entity = $this->getStreamById($id);

        $this->entityManager->transactional(function () use ($entity) {

            $this->entityManager->remove($entity);

            $this->entityManager->flush();
        });

        return true;
    }

    public function existsByFragmentName(string $fragmentName): bool
    {
        $streamKey = $this->getKeyFromFragmentName($fragmentName);

        return null !== $this->getStreamByKey($streamKey);
    }

    public function userHasAccess(User $user): bool
    {
        return $user !== null;
    }

    public function getStreamByKey(string $streamKey)
    {
        return $this
            ->entityManager
            ->getStreamsRepository()
            ->findOneBy([
                'streamKey' => $streamKey
            ]);
    }

    public function getStreamById(int $streamId)
    {
        return $this
            ->entityManager
            ->getStreamsRepository()
            ->find($streamId);
    }

    public function getKeyFromFragmentName($fragmentName): string
    {
        $streamKey = pathinfo($fragmentName)['filename'];

        $partSeparatorIndex = strpos($streamKey, '-');

        if ($partSeparatorIndex) {
            $streamKey = substr($streamKey, 0, $partSeparatorIndex);
        }

        return $streamKey;
    }
}