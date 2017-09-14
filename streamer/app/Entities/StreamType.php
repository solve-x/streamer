<?php

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * @ORM\Entity()
 * @ORM\Table(
 *     name="stream_types",
 *     uniqueConstraints={@UniqueConstraint(
 *          name="idx_unique_name_label",
 *          columns={"name", "label"}
 *      )}
 *     )
 */
class StreamType
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
     * @ORM\OneToMany(targetEntity="Stream", mappedBy="type")
     * @var ArrayCollection|Stream[]
     */
    protected $streams;

    /**
     * StreamType constructor.
     * @param int $id
     * @param string $name
     * @param string $label
     * @param Stream[]|ArrayCollection $streams
     */
    public function __construct($id, $name, $label, $streams)
    {
        $this->id = $id;
        $this->name = $name;
        $this->label = $label;
        $this->streams = $streams;
    }
}