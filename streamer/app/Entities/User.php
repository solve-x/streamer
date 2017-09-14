<?php


namespace App\Entities;

use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
 * @ORM\Entity(repositoryClass="App\Repositories\UsersRepository")
 * @ORM\Table(name="users", uniqueConstraints={@UniqueConstraint(
 *     name="idx_unique_email",
 *     columns={"email"}
 *     )})
 */
class User implements
    Authenticatable,
    AuthorizableContract,
    CanResetPasswordContract
{
    use \LaravelDoctrine\ORM\Auth\Authenticatable;
    use Authorizable, CanResetPassword;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
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
    protected $email;

    /**
     * @ORM\Column(type="datetime")
     * @var Carbon
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @var Carbon
     */
    protected $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="Stream", mappedBy="createdBy")
     * @var ArrayCollection|Stream[]
     */
    protected $streams;

    /**
     * @ORM\ManyToMany(targetEntity="UserRole", inversedBy="users")
     * @ORM\JoinTable(
     *     name="users_user_roles",
     *     joinColumns={
              @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
              @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     *     }
     * )
     * @var ArrayCollection|UserRole[]
     */
    protected $userRoles;

    /**
     * @ORM\OneToMany(targetEntity="UserStreamRole", mappedBy="user")
     * @var ArrayCollection|UserStreamRole[]
     */
    protected $userStreamRoles;

    public function __construct()
    {
        $this->streams = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Stream[]|ArrayCollection
     */
    public function getStreams()
    {
        return $this->streams;
    }

}