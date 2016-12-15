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
 * @ORM\Table(name="sip_region")
 */
class Region
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Gedmo\SortablePosition
     * @ORM\Column(type="integer", name="sort_number")
     */
    protected $sortNumber;

    /**
     * @ORM\Column(type="string", name="name")
     */
    protected $name;


    public function __construct() {}

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
     * Set sortNumber
     *
     * @param $sortNumber
     * @return Region
     */
    public function setSortNumber($sortNumber)
    {
        $this->sortNumber = $sortNumber;
        return $this;
    }

    /**
     * Get sortNumber
     *
     * @return integer
     */
    public function getSortNumber() {
        return $this->sortNumber;
    }

    /**
     * Set sortNumber
     *
     * @param $sortNumber
     * @return City
     */
    public function setPosition($sortNumber)
    {
        $this->sortNumber = $sortNumber;
        return $this;
    }

    /**
     * Get sortNumber
     *
     * @return integer
     */
    public function getPosition() {
        return $this->sortNumber;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Region
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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

    public function __toString()
    {
        return (string)$this->getName();
    }
}
