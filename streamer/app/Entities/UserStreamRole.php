<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(
 *     name="user_stream_roles"
 * )
 */
class UserStreamRole
{
    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="User", inversedBy="userStreams")
     * @see User
     * @var integer
     */
    protected $user;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="StreamRole", inversedBy="userStreams")
     * @see StreamRole
     * @var integer
     */
    protected $role;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="Stream", inversedBy="streams")
     * @see Stream
     * @var integer
     */
    protected $stream;
}