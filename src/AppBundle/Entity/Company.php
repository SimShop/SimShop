<?php
/**
 * Created by PhpStorm.
 * User: Milutin Djukanovic
 * E-mail: milutin.djukanovic@gmail.com
 * Date: 7/6/2016
 * Time: 0:59
 */

namespace AppBundle\Entity;

use AppBundle\Model\AbstractModel\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="company")
 */
class Company extends AbstractEntity
{

}