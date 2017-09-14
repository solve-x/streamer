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
     * @var integer
     */
    protected $type;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="streams")
     * @see User
     * @var integer
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
}