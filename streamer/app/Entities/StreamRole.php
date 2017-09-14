<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * @ORM\Entity()
 * @ORM\Table(
 *     name="stream_roles",
 *     uniqueConstraints={@UniqueConstraint(
 *          name="idx_unique_name_label",
 *          columns={"name", "label"}
 *      )}
 *     )
 */
class StreamRole
{
    /**
     * @ORM\Id()
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
    protected $label;

    /**
     * @ORM\OneToMany(targetEntity="UserStreamRole", mappedBy="role")
     * @var ArrayCollection|UserStreamRole[]
     */
    protected $userStreamRoles;
}