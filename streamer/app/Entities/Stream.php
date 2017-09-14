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
     * Stream constructor.
     * @param int $id
     * @param string $name
     * @param string $streamKey
     * @param int|StreamType $type
     * @param int|User $createdBy
     * @param Carbon $created
     * @param UserStreamRole[]|ArrayCollection $userStreamRoles
     */
    public function __construct($id, $name, $streamKey, $type, $createdBy, Carbon $created, $userStreamRoles)
    {
        $this->id = $id;
        $this->name = $name;
        $this->streamKey = $streamKey;
        $this->type = $type;
        $this->createdBy = $createdBy;
        $this->created = $created;
        $this->userStreamRoles = $userStreamRoles;
    }
}