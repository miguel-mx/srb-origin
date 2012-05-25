<?php

namespace Ccm\SrbBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ccm\SrbBundle\Entity\Author
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ccm\SrbBundle\Entity\AuthorRepository")
 */
class Author
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=120)
     */
    private $name;

    /**
     * @var text $alias
     *
     * @ORM\Column(name="alias", type="text")
     */
    private $alias;

   /**
    * @var array $publications
    *
    * @ORM\ManyToMany(targetEntity="Ccm\SrbBundle\Entity\Referencia", mappedBy="authors")
    *
    * The mappedBy attribute designates the field in the entity that is the owner of the relationship.
    */
    private $publications;

    /**
    *
    * @ORM\OneToOne(targetEntity="Ccm\SrbBundle\Entity\User", inversedBy="author")
    */
    private $user;

    public function __construct()
    {
      $this->publications = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set alias
     *
     * @param text $alias
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
    }

    /**
     * Get alias
     *
     * @return text 
     */
    public function getAlias()
    {
        return $this->alias;
    }

   /**
    * Add publication
    *
    * @param Ccm\TestBundle\Entity\Referencia $refs
    */
    public function addPublication(\Ccm\TestBundle\Entity\Referencia $refs)
    {
        $this->publications[] = $refs;
    }

    /**
    * Get publications
    *
    * @return Doctrine\Common\Collections\Collection
    */
    public function getPublications()
    {
      return $this->publications;
    }


    public function __toString()
    {
      return $this->name;
    }

    /**
     * Add publications
     *
     * @param Ccm\SrbBundle\Entity\Referencia $publications
     */
    public function addReferencia(\Ccm\SrbBundle\Entity\Referencia $publications)
    {
        $this->publications[] = $publications;
    }

    /**
     * Set user
     *
     * @param Ccm\SrbBundle\Entity\User $user
     */
    public function setUser(\Ccm\SrbBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return Ccm\SrbBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}