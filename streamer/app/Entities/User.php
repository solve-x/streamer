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

    /**
     * @ORM\Column(name="lockout", type="boolean")
     * @var bool
     */
    protected $lockout;

    public function __construct()
    {
        $this->streams = new ArrayCollection();
        $this->userRoles = new ArrayCollection();
        $this->userStreamRoles = new ArrayCollection();
    }

    public function isInRole(int $roleId): bool
    {
        if (null === $this->userRoles) {
            return false;
        }

        foreach ($this->userRoles as $storedRole) {
            if ($storedRole->getId() === $roleId) {
                return true;
            }
        }

        return false;
    }

    public function addToRole(UserRole $role)
    {
        if ($this->userRoles->contains($role)) {
            return false;
        }

        $this->userRoles->add($role);
        return true;
    }

    public function clearRoles()
    {
        $this->userRoles->clear();
    }

    public static function empty()
    {
        return new User();
    }

    /**
     * @return string
     */
    public function getName()
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

    public function isSuperAdmin(): bool
    {
        return $this->isInRole(UserRole::SuperAdmin);
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isLockout(): bool
    {
        return $this->lockout;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @param Carbon $createdAt
     */
    public function setCreatedAt(Carbon $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @param Carbon $updatedAt
     */
    public function setUpdatedAt(Carbon $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @param bool $lockout
     */
    public function setLockout(bool $lockout)
    {
        $this->lockout = $lockout;
    }
}