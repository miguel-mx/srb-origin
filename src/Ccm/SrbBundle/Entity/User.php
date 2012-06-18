<?php
// src/Acme/UserBundle/Entity/User.php

namespace Ccm\SrbBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

     /**
     * @ORM\OneToOne(targetEntity="Ccm\SrbBundle\Entity\Author", mappedBy="user")
     */
    private $author;

    

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set author
     *
     * @param Ccm\SrbBundle\Entity\Author $author
     */
    public function setAuthor(\Ccm\SrbBundle\Entity\Author $author)
    {
        $this->author = $author;
    }

    /**
     * Get author
     *
     * @return Ccm\SrbBundle\Entity\Author 
     */
    public function getAuthor()
    {
        return $this->author;
    }

 }