<?php

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * EntityInfos
 *
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 */
class EntityInfos
{
    /**
     * @var datetime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $created_at;

    /**
     * @var datetime
     *
     * @ORM\Column(name="modified_at", type="datetime")
     */
    private $modified_at;

    /**
     * @var int
     *
     * @ORM\Column(name="modifier_user_id", type="integer", length=255, nullable=true)
     */
    private $modifier_user_id;

    public function setModifierUserId($id)
    {
        $this->modifier_user_id = $id;

        return $this;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist() {
        $this->created_at = new \DateTime('now');
        $this->modified_at = $this->created_at;
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate() {
        $this->modified_at = new \DateTime('now');
    }
}
