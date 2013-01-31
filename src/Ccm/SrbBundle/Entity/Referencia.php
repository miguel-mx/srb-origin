<?php
// src/Acme/DemoBundle/Entity/Document.php
namespace Ccm\SrbBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Referencia 
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

     /**
     * @ORM\Column(type="text", nullable=true)
     */
     private $author;

    /**
     * @var authors
     * @ORM\ManyToMany(targetEntity="Author", inversedBy="publications")
     */
     private $authors;

     /**
     * @ORM\Column(type="string", length=1500)
     * @Assert\NotBlank()
     */
    protected $title;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     * @Assert\NotBlank()
     */
    public $type;

     /**
     * @ORM\Column(type="string", length=4, nullable=true)
     * @Assert\MaxLength(4)(message="Debe ser un año válido")
     */
    protected $yearPreprint;

     /**
     * @ORM\Column(type="string", length=4, nullable=true)
     * @Assert\MaxLength(4)(message="Debe ser un año válido")
     *
     */
    protected $yearPub;

     /**
     * @ORM\Column(type="string", length=250, nullable=true)


     */
    protected $publication;

     /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    protected $journal;

     /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    protected $issue;

     /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    protected $volume;

     /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    protected $pages;

     /**
     * @ORM\Column(type="string", length=250, nullable=true)

     */
    protected $corporateAuthor;

     /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    protected $thesis;

     /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    protected $address;

     /**
     * @ORM\Column(type="string", length=1500, nullable=true)
     */
    protected $keywords;

     /**
     * @ORM\Column(type="string", length=2500, nullable=true)
     */
    protected $abst;

     /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    protected $publisher;

     /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    protected $placePub;

     /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    protected $editor;

     /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    protected $issn;

     /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    protected $isbn;

     /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    protected $medium;

     /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    protected $area;

     /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    protected $conference;

     /**
     * @ORM\Column(type="string", length=2500, nullable=true)
     */
    protected $notas;

     /**
     * @ORM\Column(type="boolean", length=2, nullable=true)
     */
    protected $revision;

     /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    protected $file;

     /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    protected $url;

     /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    protected $doi;

     /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    protected $arxiv;

     /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    protected $mathscinet;

     /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    protected $zmath;

     /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    protected $inspires;

     /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    protected $reportNumber;

     /**
     * @ORM\Column(type="string", length=1500, nullable=true)
     */
    protected $msc;

     /**
     * @ORM\Column(type="string", length=1500, nullable=true)
     */
    protected $mrNumber;

     /**
     * @ORM\Column(type="string", length=1500, nullable=true)
     */
    protected $bookTitle;


 /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created;

     /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $modified;

     /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="modifiedby")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *
     * @var User $user
     *
     */
    private $user;


        //--------------------------------------------------------------------------------
        // Definiciones de métodos para la relación Referencia - Author

       /**
        * Constructor de la clase, inicializa el arreglo de authors
        *
        *
        */
        public function __construct()
        {
            $this->authors = new \Doctrine\Common\Collections\ArrayCollection();
        }

       /**
        * Add Author
        *
        * @param Ccm\SrbBundle\Entity\Author $author
        */
        public function addAuthor(\Ccm\SrbBundle\Entity\Author $author)
        {
            $author->addPublication($this); // synchronously updating inverse side
            $this->authors[] = $author;
        }

       /**
        * Get authors
        *
        * @return Doctrine\Common\Collections\Collection
        */
        public function getAuthors()
        {
          return $this->authors;
        }


        public function __toString()
        {
          return $this->title;
        }

        //--------------------------------------------------------------------------------

        /**
         * @ORM\PrePersist
         */
        public function prePersist()
        {
            $this->setCreated(new \DateTime());
            //$this->setModified(new \DateTime());
        }


        /**
         * @ORM\PreUpdate
         */
        public function preUpdate()
        {
            $this->setModified(new \DateTime());

        }

        /**
         * Set created
         *
         * @param datetime $created
         */
        public function setCreated($created)
        {
            $this->created = $created;
        }

        /**
         * Set modified
         *
         * @param datetime $modified

         */
        public function setModified($modified)
        {
            $this->modified = $modified;

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
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set type 
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

     /**
     * Set yearPreprint 
     *
     * @param string $yearPreprint
     */
    public function setYearPreprint($yearPreprint)
    {
        $this->yearPreprint = $yearPreprint;
    }

    /**
     * Get yearPreprint
     *
     * @return string 
     */
    public function getYearPreprint()
    {
        return $this->yearPreprint;
    }

     /**
     * Set yearPub
     *
     * @param string $yearPub
     */
    public function setYearPub($yearPub)
    {
        $this->yearPub = $yearPub;
    }

    /**
     * Get yearPub
     *
     * @return string 
     */
    public function getYearPub()
    {
        return $this->yearPub;
    }

     /**
     * Set publication
     *
     * @param string $publication
     */
    public function setPublication($publication)
    {
        $this->publication = $publication;
    }

    /**
     * Get publication
     *
     * @return string 
     */
    public function getPublication()
    {
        return $this->publication;
    }

     /**
     * Set journal
     *
     * @param string $journal
     */
    public function setJournal($journal)
    {
        $this->journal = $journal;
    }

    /**
     * Get journal
     *
     * @return string 
     */
    public function getJournal()
    {
        return $this->journal;
    }
 
     /**
     * Set volume
     *
     * @param string $volume
     */
    public function setVolume($volume)
    {
        $this->volume = $volume;
    }

    /**
     * Get volume
     *
     * @return string 
     */
    public function getVolume()
    {
        return $this->volume;
    }

     /**
     * Set issue
     *
     * @param string $issue
     */
    public function setIssue($issue)
    {
        $this->issue = $issue;
    }

    /**
     * Get issue
     *
     * @return string 
     */
    public function getIssue()
    {
        return $this->issue;
    }

     /**
     * Set pages
     *
     * @param string $pages
     */
    public function setPages($pages)
    {
        $this->pages = $pages;
    }

    /**
     * Get pages
     *
     * @return string 
     */
    public function getPages()
    {
        return $this->pages;
    }

     /**
     * Set corporateAuthor
     *
     * @param string $corporateAuthor
     */
    public function setCorporateAuthor($corporateAuthor)
    {
        $this->corporateAuthor = $corporateAuthor;
    }

    /**
     * Get corporateAuthor
     *
     * @return string 
     */
    public function getCorporateAuthor()
    {
        return $this->corporateAuthor;
    }

     /**
     * Set thesis
     *
     * @param string $thesis
     */
    public function setThesis($thesis)
    {
        $this->thesis = $thesis;
    }

    /**
     * Get thesis
     *
     * @return string 
     */
    public function getThesis()
    {
        return $this->thesis;
    }

     /**
     * Set address
     *
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

     /**
     * Set keywords
     *
     * @param string $keywords
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }

    /**
     * Get keywords
     *
     * @return string 
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

     /**
     * Set abst
     *
     * @param string $abst
     */
    public function setAbst($abst)
    {
        $this->abst = $abst;
    }

    /**
     * Get abst
     *
     * @return string 
     */
    public function getAbst()
    {
        return $this->abst;
    }

     /**
     * Set publisher
     *
     * @param string $publisher
     */
    public function setPublisher($publisher)
    {
        $this->publisher = $publisher;
    }

    /**
     * Get publisher
     *
     * @return string 
     */
    public function getPublisher()
    {
        return $this->publisher;
    }

     /**
     * Set place
     *
     * @param string $place
     */
    public function setPlace($place)
    {
        $this->place = $place;
    }

    /**
     * Get place
     *
     * @return string 
     */
    public function getPlace()
    {
        return $this->place;
    }

     /**
     * Set editor
     *
     * @param string $editor
     */
    public function setEditor($editor)
    {
        $this->editor = $editor;
    }

    /**
     * Get editor
     *
     * @return string 
     */
    public function getEditor()
    {
        return $this->editor;
    }

     /**
     * Set issn
     *
     * @param string $issn
     */
    public function setIssn($issn)
    {
        $this->issn = $issn;
    }

    /**
     * Get issn
     *
     * @return string 
     */
    public function getIssn()
    {
        return $this->issn;
    }

     /**
     * Set isbn
     *
     * @param string $isbn
     */
    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;
    }

    /**
     * Get isbn
     *
     * @return string 
     */
    public function getIsbn()
    {
        return $this->isbn;
    }

    /**
     * Set medium
     *
     * @param string $medium
     */
    public function setMedium($medium)
    {
        $this->medium = $medium;
    }

    /**
     * Get medium
     *
     * @return string 
     */
    public function getMedium()
    {
        return $this->medium;
    }

     /**
     * Set area
     *
     * @param string $area
     */
    public function setArea($area)
    {
        $this->area = $area;
    }

    /**
     * Get area
     *
     * @return string 
     */
    public function getArea()
    {
        return $this->area;
    }

     /**
     * Set conference
     *
     * @param string $conference
     */
    public function setConference($conference)
    {
        $this->conference = $conference;
    }

    /**
     * Get conference
     *
     * @return string 
     */
    public function getConference()
    {
        return $this->conference;
    }

     /**
     * Set notes
     *
     * @param string $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }

    /**
     * Get notes
     *
     * @return string 
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set revision
     *
     * @param string $revision
     */
    public function setRevision($revision)
    {
        $this->revision = $revision;
    }

    /**
     * Get revision
     *
     * @return string 
     */
    public function getRevision()
    {
        return $this->revision;
    }

    /**
     * Set file
     *
     * @param string $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * Get file
     *
     * @return string 
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set url
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set doi
     *
     * @param string $doi
     */
    public function setDoi($doi)
    {
        $this->doi = $doi;
    }

    /**
     * Get doi
     *
     * @return string 
     */
    public function getDoi()
    {
        return $this->doi;
    }

     /**
     * Set arxiv
     *
     * @param string $arxiv
     */
    public function setArxiv($arxiv)
    {
        $this->arxiv = $arxiv;
    }

    /**
     * Get arxiv
     *
     * @return string 
     */
    public function getArxiv()
    {
        return $this->arxiv;
    }


     /**
     * Set mathscinet
     *
     * @param string $mathscinet
     */
    public function setMathscinet($mathscinet)
    {
        $this->mathscinet = $mathscinet;
    }

    /**
     * Get mathscinet
     *
     * @return string 
     */
    public function getMathscinet()
    {
        return $this->mathscinet;
    }

     /**
     * Set zmath
     *
     * @param string $zmath
     */
    public function setZmath($zmath)
    {
        $this->zmath = $zmath;
    }

    /**
     * Get zmath
     *
     * @return string
     */
    public function getZmath()
    {
        return $this->zmath;
    }

     /**
     * Set inspires
     *
     * @param string $inspires
     */
    public function setInspires($inspires)
    {
        $this->inspires = $inspires;
    }

    /**
     * Get inspires
     *
     * @return string 
     */
    public function getInspires()
    {
        return $this->inspires;
    }



    /**
     * Set author
     *
     * @param text $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * Get author
     *
     * @return text 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set placePub
     *
     * @param string $placePub
     */
    public function setPlacePub($placePub)
    {
        $this->placePub = $placePub;
    }

    /**
     * Get placePub
     *
     * @return string 
     */
    public function getPlacePub()
    {
        return $this->placePub;
    }

    /**
     * Set notas
     *
     * @param string $notas
     */
    public function setNotas($notas)
    {
        $this->notas = $notas;
    }

    /**
     * Get notas
     *
     * @return string 
     */
    public function getNotas()
    {
        return $this->notas;
    }

/*    /**
     * Set created
     *
     * @param 
     */
/*    public function setCreated()
    {
        $this->created = new \DateTime("now");
    }

*/    /**
     * Get created
     *
     * @return string
     */
    public function getCreated()
    {
        return $this->created;
    }

/*    /**
     * Set modified
     *
     * @param 
     */
/*    public function setModified()
    {
        $this->modified = new \DateTime("now");
    }

*/    /**
     * Get modified
     *
     * @return string 
     */
    public function getModified()
    {
        return $this->modified;
    }

     /**
     * @Assert\True(message = "Es necesario que exista un Autor o un Editor")
     */
    public function isEditorAuthor()

    {
     if (($this->editor != null)|| ($this->author != null)){
        return true;	}
        else
        return false;

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


    /**
     * Set reportNumber
     *
     * @param string $reportNumber
     */
    public function setReportNumber($reportNumber)
    {
        $this->reportNumber = $reportNumber;
    }

    /**
     * Get reportNumber
     *
     * @return string 
     */
    public function getReportNumber()
    {
        return $this->reportNumber;
    }

    /**
     * Set msc
     *
     * @param string $msc
     */
    public function setMsc($msc)
    {
        $this->msc = $msc;
    }

    /**
     * Get msc
     *
     * @return string 
     */
    public function getMsc()
    {
        return $this->msc;
    }

     /**
     * Set mrNumber
     *
     * @param string $mrNumber
     */
    public function setMrNumber($mrNumber)
    {
        $this->mrNumber = $mrNumber;
    }

    /**
     * Get mrNumber
     *
     * @return string 
     */
    public function getMrNumber()
    {
        return $this->mrNumber;
    }

   /**
     * Set bookTitle
     *
     * @param string $bookTitle
     */
    public function setBookTitle($bookTitle)
    {
        $this->bookTitle = $bookTitle;
    }

    /**
     * Get bookTitle
     *
     * @return string 
     */
    public function getBookTitle()
    {
        return $this->bookTitle;
    }


}
