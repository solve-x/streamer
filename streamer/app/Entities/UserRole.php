<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * @ORM\Entity()
 * @ORM\Table(
 *     name="user_roles",
 *     uniqueConstraints={@UniqueConstraint(
 *          name="idx_unique_name_label",
 *          columns={"name", "label"}
 *      )}
 *     )
 */
class UserRole
{
    const SuperAdmin = 1;

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
     * @ORM\ManyToMany(targetEntity="User", mappedBy="userRoles")
     *
     * @var ArrayCollection|User[]
     */
    protected $users;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

}