<?php
/*
 * (c) Suhinin Ilja <iljasuhinin@gmail.com>
 */
namespace SIP\ResourceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DoctrineExtensions\Taggable\Taggable;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="sip_news")
 */
class News implements Taggable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="SIP\ResourceBundle\Entity\NewsRubric")
     * @ORM\JoinColumn(name="rubric_id", referencedColumnName="id")
     * @ORM\OrderBy({"position" = "ASC"})
     */
    protected $rubric;

    /**
     * @ORM\Column(type="boolean", name="publish", nullable=true)
     */
    protected $publish = true;

    /**
     * @ORM\Column(type="boolean", name="on_main", nullable=true)
     */
    protected $onMain;

    /**
     * @Gedmo\Slug(fields={"h1"})
     * @ORM\Column(type="string", name="slug")
     */
    protected $slug;

    /**
     * @ORM\ManyToOne(targetEntity="SIP\ResourceBundle\Entity\Media\Media",cascade={"persist"})
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id")
     */
    protected $image;

    /**
     * @ORM\Column(type="string", name="h1")
     */
    protected $h1;

    /**
     * @ORM\Column(type="text", name="brief")
     */
    protected $brief;

    /**
     * @ORM\Column(type="text", name="full")
     */
    protected $full;

    /**
     * @ORM\Column(type="string", name="foto_from", nullable=true)
     */
    protected $fotoFrom;

    /**
     * @ORM\Column(type="string", name="title", nullable=true)
     */
    protected $title;

    /**
     * @ORM\Column(type="text", name="description", nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(type="string", name="keywords", nullable=true)
     */
    protected $keywords;

    /**
     * @ORM\Column(type="datetime", name="date_add", nullable=true)
     */
    protected $dateAdd;

    protected $tags;

    /**
     * @ORM\Column(type="string", name="flickr_galley_id", nullable=true)
     */
    protected $flickrGalleyId;

    public function __construct()
    {
        $this->dateAdd = new \DateTime();
    }



    /**
     * @param $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set publish
     *
     * @param $publish
     * @return News
     */
    public function setPublish($publish)
    {
        $this->publish = $publish;
        return $this;
    }

    /**
     * Get publish
     *
     * @return integer
     */
    public function getPublish() {
        return $this->publish;
    }

    /**
     * Set onMain
     *
     * @param boolean $onMain
     * @return News
     */
    public function setOnMain($onMain)
    {
        $this->onMain = $onMain;

        return $this;
    }

    /**
     * Get onMain
     *
     * @return boolean
     */
    public function getOnMain()
    {
        return $this->onMain;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return News
     */
    public function setSlug($slug)
    {
        $this->engLink = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set image
     *
     * @param \SIP\ResourceBundle\Entity\Media\Media $image
     * @return News
     */
    public function setImage(\SIP\ResourceBundle\Entity\Media\Media $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \SIP\ResourceBundle\Entity\Media\Media
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set h1
     *
     * @param string $h1
     * @return News
     */
    public function setH1($h1)
    {
        $this->h1 = $h1;

        return $this;
    }

    /**
     * Get h1
     *
     * @return string
     */
    public function getH1()
    {
        return $this->h1;
    }

    /**
     * Set brief
     *
     * @param string $brief
     * @return News
     */
    public function setBrief($brief)
    {
        $this->brief = $brief;

        return $this;
    }

    /**
     * Get brief
     *
     * @return string
     */
    public function getBrief()
    {
        return $this->brief;
    }

    /**
     * Set full
     *
     * @param string $full
     * @return News
     */
    public function setFull($full)
    {
        $this->full = $full;

        return $this;
    }

    /**
     * Get full
     *
     * @return string
     */
    public function getFull()
    {
        return $this->full;
    }

    /**
     * Set fotoFrom
     *
     * @param string $fotoFrom
     * @return News
     */
    public function setFotoFrom($fotoFrom)
    {
        $this->fotoFrom = $fotoFrom;

        return $this;
    }

    /**
     * Get fotoFrom
     *
     * @return string
     */
    public function getFotoFrom()
    {
        return $this->fotoFrom;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return News
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
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
     * Set description
     *
     * @param string $description
     * @return News
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set keywords
     *
     * @param string $keywords
     * @return News
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;

        return $this;
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
     * Set dateAdd
     *
     * @param \DateTime $dateAdd
     * @return News
     */
    public function setDateAdd($dateAdd)
    {
        $this->dateAdd = $dateAdd;

        return $this;
    }

    /**
     * Get dateAdd
     *
     * @return \DateTime
     */
    public function getDateAdd()
    {
        return $this->dateAdd;
    }

    public function getTags()
    {
        $this->tags = $this->tags ?: new ArrayCollection();

        return $this->tags;
    }

    public function getTaggableType()
    {
        return get_class($this);
    }

    public function getTaggableId()
    {
        return $this->getId();
    }

    public function setShowImage($image) {}

    public function getShowImage()
    {
        return $this->image;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->getH1();
    }

    /**
     * @return mixed
     */
    public function getRubric()
    {
        return $this->rubric;
    }

    /**
     * @param mixed $rubric
     */
    public function setRubric($rubric)
    {
        $this->rubric = $rubric;
    }

    /**
     * Set flickrGalleyId
     *
     * @param string $flickrGalleyId
     * @return News
     */
    public function setFlickrGalleyId($flickrGalleyId)
    {
        $this->flickrGalleyId = $flickrGalleyId;

        return $this;
    }

    /**
     * Get flickrGalleyId
     *
     * @return string 
     */
    public function getFlickrGalleyId()
    {
        return $this->flickrGalleyId;
    }
}
