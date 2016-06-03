<?php
/**
 * Created by PhpStorm.
 * User: Milutin Djukanovic
 * E-mail: milutin.djukanovic@gmail.com
 * Date: 4/6/2016
 * Time: 0:12
 */

namespace AppBundle\Entity\AbstractModel;


use Doctrine\ORM\Mapping\Column;

class AbstractEntity implements EntityInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @Column(type="datetime", name="created_at")
     */
    protected $createdAt;

    /**
     * @Column(type="datetime", name="modified_at")
     */
    protected $modifiedAt;

    /**
     * @return String
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }
}