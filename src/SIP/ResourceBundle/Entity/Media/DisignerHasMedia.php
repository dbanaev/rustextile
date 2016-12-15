<?php
/*
 * (c) Suhinin Ilja <iljasuhinin@gmail.com>
 */
namespace SIP\ResourceBundle\Entity\Media;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="sip_designer_has_media")
 * @ORM\HasLifecycleCallbacks
 */
class DisignerHasMedia
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="SIP\ResourceBundle\Entity\Designer", inversedBy="gallery")
     * @ORM\JoinColumn(name="designer_id", referencedColumnName="id")
     */
    protected $designer;

    /**
     * @ORM\ManyToOne(targetEntity="\SIP\ResourceBundle\Entity\Media\Media", cascade={"persist"})
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $image;

    protected $showImage;

    /**
     * @ORM\Column(type="integer")
     */
    protected $position;

    public function __construct()
    {
        $this->position = 0;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getId();
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
     * @param $position
     * @return $this
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param \SIP\ResourceBundle\Entity\Designer $designer
     * @return $this
     */
    public function setDesigner(\SIP\ResourceBundle\Entity\Designer $designer = null)
    {
        $this->designer = $designer;

        return $this;
    }

    /**
     * Get product
     *
     * @return \SIP\ResourceBundle\Entity\Designer
     */
    public function getDesigner()
    {
        return $this->designer;
    }


    /**
     * Set image
     *
     * @param \SIP\ResourceBundle\Entity\Media\Media $image
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

    public function setShowImage($image) {}

    public function getShowImage()
    {
        return $this->image;
    }

    /**
     * @ORM\PostUpdate()
     */
    public function PostUpdate(\Doctrine\ORM\Event\LifecycleEventArgs $event)
    {
        if ($this->getDesigner() === null) {
            $event->getEntityManager()->remove($this);
        }
    }
}
