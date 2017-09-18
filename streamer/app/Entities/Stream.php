<?php

namespace App\Entities;

use Carbon\Carbon;
use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * @ORM\Entity()
 * @ORM\Table(name="streams", uniqueConstraints={@UniqueConstraint(
 *     name="idx_unique_stream_key",
 *     columns={"stream_key"}
 *     )}
 *     )
 */
class Stream
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $streamKey;

    /**
     * @ORM\ManyToOne(targetEntity="StreamType", inversedBy="streams")
     * @see StreamType
     * @var integer|StreamType
     */
    protected $type;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="streams")
     * @see User
     * @var integer|User
     */
    protected $createdBy;

    /**
     * @ORM\Column(type="datetime")
     * @var Carbon
     */
    protected $created;

    /**
     * @ORM\OneToMany(targetEntity="UserStreamRole", mappedBy="stream")
     * @var ArrayCollection|UserStreamRole[]
     */
    protected $userStreamRoles;

    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    protected $isLive;

    /**
     * Stream constructor.
     * @param int $id
     * @param string $name
     * @param string $streamKey
     * @param int|StreamType $type
     * @param int|User $createdBy
     * @param Carbon $created
     * @param $isLive
     * @param UserStreamRole[]|ArrayCollection $userStreamRoles
     */
    public function __construct(
        $id,
        $name,
        $streamKey,
        $type,
        $createdBy,
        Carbon $created,
        $isLive = false,
        $userStreamRoles = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->streamKey = $streamKey;
        $this->type = $type;
        $this->createdBy = $createdBy;
        $this->created = $created;
        $this->userStreamRoles = $userStreamRoles;
        $this->isLive = $isLive;
    }

    public static function empty()
    {
        return new Stream(
            null,
            '',
            '',
            null,
            null,
            Carbon::now()
        );
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param string $streamKey
     */
    public function setStreamKey(string $streamKey)
    {
        $this->streamKey = $streamKey;
    }

    /**
     * @param StreamType|int $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @param User|int $createdBy
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @param Carbon $created
     */
    public function setCreated(Carbon $created)
    {
        $this->created = $created;
    }

    /**
     * @param UserStreamRole[]|ArrayCollection $userStreamRoles
     */
    public function setUserStreamRoles($userStreamRoles)
    {
        $this->userStreamRoles = $userStreamRoles;
    }

    /**
     * @param bool $isLive
     */
    public function setIsLive(bool $isLive)
    {
        $this->isLive = $isLive;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getStreamKey(): string
    {
        return $this->streamKey;
    }

    /**
     * @return StreamType|int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return User|int
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @return Carbon
     */
    public function getCreated(): Carbon
    {
        return $this->created;
    }

    /**
     * @return UserStreamRole[]|ArrayCollection
     */
    public function getUserStreamRoles()
    {
        return $this->userStreamRoles;
    }

    /**
     * @return bool
     */
    public function isLive(): bool
    {
        return $this->isLive;
    }
}