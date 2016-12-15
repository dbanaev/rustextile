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
 * @ORM\Table(name="sip_manufacturer")
 */
class Manufacturer
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="SIP\ResourceBundle\Entity\User\User",cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\Column(type="boolean", name="publish", nullable=true)
     */
    protected $publish = true;

    /**
     * @ORM\ManyToOne(targetEntity="SIP\ResourceBundle\Entity\City",cascade={"persist"})
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     */
    protected $city;

    /**
     * @ORM\ManyToOne(targetEntity="SIP\ResourceBundle\Entity\Region",cascade={"persist"})
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id")
     */
    protected $region;

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
     * @ORM\Column(type="text", name="brief", nullable=true)
     */
    protected $brief;

    /**
     * @ORM\Column(type="text", name="full")
     */
    protected $full;

    /**
     * @ORM\Column(type="string", name="address", nullable=true)
     */
    protected $address;

    /**
     * @ORM\Column(type="string", name="coords", nullable=true)
     */
    protected $coords;

    /**
     * @ORM\Column(type="string", name="person", nullable=true)
     */
    protected $person;

    /**
     * @ORM\Column(type="string", name="phone", nullable=true)
     */
    protected $phone;

    /**
     * @ORM\Column(type="string", name="fax", nullable=true)
     */
    protected $fax;

    /**
     * @ORM\Column(type="string", name="email", nullable=true)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", name="site", nullable=true)
     */
    protected $site;

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
     * @ORM\Column(type="datetime", name="date_add")
     */
    protected $dateAdd;

    /**
     * @ORM\ManyToOne(targetEntity="SIP\ResourceBundle\Entity\ManufacturerRubric")
     * @ORM\JoinColumn(name="rubric_id", referencedColumnName="id")
     * @ORM\OrderBy({"position" = "ASC"})
     */
    protected $rubric;

    protected $showImage;

    protected $galleryMultiple;

    /**
     * @ORM\OneToMany(targetEntity="SIP\ResourceBundle\Entity\Media\ManufacturerHasMedia", mappedBy="manufacturer",cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
     */
    protected $gallery;

    public function __construct()
    {
        $this->dateAdd = new \DateTime();
        $this->gallery = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set user
     *
     * @param \SIP\ResourceBundle\Entity\User\User $user
     * @return Manufacturer
     */
    public function setUser(\SIP\ResourceBundle\Entity\User\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \SIP\ResourceBundle\Entity\User\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set publish
     *
     * @param $publish
     * @return Brand
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
     * Set region
     *
     * @param \SIP\ResourceBundle\Entity\Region $region
     * @return Manufacturer
     */
    public function setRegion(\SIP\ResourceBundle\Entity\Region $region = null)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return \SIP\ResourceBundle\Entity\Region
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set city
     *
     * @param \SIP\ResourceBundle\Entity\City $city
     * @return Manufacturer
     */
    public function setCity(\SIP\ResourceBundle\Entity\City $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \SIP\ResourceBundle\Entity\City
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Manufacturer
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

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
     * @return Manufacturer
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
     * @return Manufacturer
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
     * @return Manufacturer
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
     * @return Manufacturer
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
     * Set address
     *
     * @param string $address
     * @return Manufacturer
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
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
     * Set coords
     *
     * @param string $coords
     * @return Manufacturer
     */
    public function setCoords($coords)
    {
        $this->coords = $coords;

        return $this;
    }

    /**
     * Get coords
     *
     * @return string
     */
    public function getCoords()
    {
        return $this->coords;
    }

    /**
     * Set person
     *
     * @param string $person
     * @return Manufacturer
     */
    public function setPerson($person)
    {
        $this->person = $person;

        return $this;
    }

    /**
     * Get person
     *
     * @return string
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Manufacturer
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set fax
     *
     * @param string $fax
     * @return Manufacturer
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Manufacturer
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set site
     *
     * @param string $site
     * @return Manufacturer
     */
    public function setSite($site)
    {
        $this->site = $site;

        return $this;
    }

    /**
     * Get site
     *
     * @return string
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Manufacturer
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
     * @return Manufacturer
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
     * @return Manufacturer
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
     * @return Manufacturer
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

    public function setShowImage($image) {}

    public function getShowImage()
    {
        return $this->image;
    }

    /**
     * Add gallery
     *
     * @param \SIP\ResourceBundle\Entity\Media\ManufacturerHasMedia $gallery
     * @return Designer
     */
    public function addGallery(\SIP\ResourceBundle\Entity\Media\ManufacturerHasMedia $gallery)
    {
        $this->gallery[] = $gallery;

        return $this;
    }

    /**
     * Remove gallery
     *
     * @param \SIP\ResourceBundle\Entity\Media\ManufacturerHasMedia $gallery
     */
    public function removeGallery(\SIP\ResourceBundle\Entity\Media\ManufacturerHasMedia $gallery)
    {
        $this->gallery->removeElement($gallery);
    }

    /**
     * Get gallery
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * @return mixed
     */
    public function getGalleryMultiple()
    {
        return $this->galleryMultiple;
    }

    /**
     * @param $galleryMultiple
     */
    public function setGalleryMultiple($galleryMultiple)
    {
        $this->galleryMultiple = $galleryMultiple;
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

    public function __toString()
    {
        return (string)$this->getH1();
    }
}
