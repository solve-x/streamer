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
    private $database = null;

    /**
     * StreamService constructor.
     * @param UnitOfWorkInterface $database
     */
    public function __construct(UnitOfWorkInterface $database)
    {
        $this->database = $database;
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
        $this->database->transactional(function () use ($user) {

            $type = $this
                ->database
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

            $this->database->persist($stream);
            $user->getStreams()->add($stream);

            $this->database->flush();
        });

        return "";
    }
}