<?php
/**
 * Created by PhpStorm.
 * User: Milutin Djukanovic
 * E-mail: milutin.djukanovic@gmail.com
 * Date: 3/7/2016
 * Time: 18:33
 */

namespace SymshopBundle\Entity;

use FOS\UserBundle\Model\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="sym_user_group")
 */
class UserGroup extends BaseGroup
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
}