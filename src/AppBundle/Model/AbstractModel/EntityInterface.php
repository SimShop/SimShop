<?php
/**
 * Created by PhpStorm.
 * User: Milutin Djukanovic
 * E-mail: milutin.djukanovic@gmail.com
 * Date: 4/6/2016
 * Time: 0:14
 */

namespace AppBundle\Model\AbstractModel;


interface EntityInterface
{
    /**
     * @return String
     */
    public function getId();

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @return \DateTime
     */
    public function getModifiedAt();
}