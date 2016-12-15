<?php
/*
 * (c) Suhinin Ilja <iljasuhinin@gmail.com>
 */
namespace SIP\ResourceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="sip_main_spot")
 */
class MainSpot
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", name="title_1", nullable=true)
     */
    protected $title1;

    /**
     * @ORM\Column(type="string", name="link_item_1", nullable=true)
     */
    protected $linkItem1;

    /**
     * @ORM\Column(type="string", name="link_list_1", nullable=true)
     */
    protected $linkList1;

    /**
     * @ORM\ManyToOne(targetEntity="SIP\ResourceBundle\Entity\Media\Media",cascade={"persist"})
     * @ORM\JoinColumn(name="image_id_1", referencedColumnName="id")
     */
    protected $image1;

    protected $showImage1;

    /**
     * @ORM\Column(type="string", name="title_2", nullable=true)
     */
    protected $title2;

    /**
     * @ORM\Column(type="string", name="link_item_2", nullable=true)
     */
    protected $linkItem2;

    /**
     * @ORM\Column(type="string", name="link_list_2", nullable=true)
     */
    protected $linkList2;

    /**
     * @ORM\ManyToOne(targetEntity="SIP\ResourceBundle\Entity\Media\Media",cascade={"persist"})
     * @ORM\JoinColumn(name="image_id_2", referencedColumnName="id")
     */
    protected $image2;

    protected $showImage2;

    /**
     * @ORM\Column(type="string", name="title_3", nullable=true)
     */
    protected $title3;

    /**
     * @ORM\Column(type="string", name="link_item_3", nullable=true)
     */
    protected $linkItem3;

    /**
     * @ORM\Column(type="string", name="link_list_3", nullable=true)
     */
    protected $linkList3;

    /**
     * @ORM\ManyToOne(targetEntity="SIP\ResourceBundle\Entity\Media\Media",cascade={"persist"})
     * @ORM\JoinColumn(name="image_id_3", referencedColumnName="id")
     */
    protected $image3;

    protected $showImage3;

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
     * Set title1
     *
     * @param string $title1
     * @return MainSpot
     */
    public function setTitle1($title1)
    {
        $this->title1 = $title1;

        return $this;
    }

    /**
     * Get title1
     *
     * @return string 
     */
    public function getTitle1()
    {
        return $this->title1;
    }

    /**
     * Set linkItem1
     *
     * @param string $linkItem1
     * @return MainSpot
     */
    public function setLinkItem1($linkItem1)
    {
        $this->linkItem1 = $linkItem1;

        return $this;
    }

    /**
     * Get linkItem1
     *
     * @return string 
     */
    public function getLinkItem1()
    {
        return $this->linkItem1;
    }

    /**
     * Set linkList1
     *
     * @param string $linkList1
     * @return MainSpot
     */
    public function setLinkList1($linkList1)
    {
        $this->linkList1 = $linkList1;

        return $this;
    }

    /**
     * Get linkList1
     *
     * @return string 
     */
    public function getLinkList1()
    {
        return $this->linkList1;
    }

    /**
     * Set title2
     *
     * @param string $title2
     * @return MainSpot
     */
    public function setTitle2($title2)
    {
        $this->title2 = $title2;

        return $this;
    }

    /**
     * Get title2
     *
     * @return string 
     */
    public function getTitle2()
    {
        return $this->title2;
    }

    /**
     * Set linkItem2
     *
     * @param string $linkItem2
     * @return MainSpot
     */
    public function setLinkItem2($linkItem2)
    {
        $this->linkItem2 = $linkItem2;

        return $this;
    }

    /**
     * Get linkItem2
     *
     * @return string 
     */
    public function getLinkItem2()
    {
        return $this->linkItem2;
    }

    /**
     * Set linkList2
     *
     * @param string $linkList2
     * @return MainSpot
     */
    public function setLinkList2($linkList2)
    {
        $this->linkList2 = $linkList2;

        return $this;
    }

    /**
     * Get linkList2
     *
     * @return string 
     */
    public function getLinkList2()
    {
        return $this->linkList2;
    }

    /**
     * Set title3
     *
     * @param string $title3
     * @return MainSpot
     */
    public function setTitle3($title3)
    {
        $this->title3 = $title3;

        return $this;
    }

    /**
     * Get title3
     *
     * @return string 
     */
    public function getTitle3()
    {
        return $this->title3;
    }

    /**
     * Set linkItem3
     *
     * @param string $linkItem3
     * @return MainSpot
     */
    public function setLinkItem3($linkItem3)
    {
        $this->linkItem3 = $linkItem3;

        return $this;
    }

    /**
     * Get linkItem3
     *
     * @return string 
     */
    public function getLinkItem3()
    {
        return $this->linkItem3;
    }

    /**
     * Set linkList3
     *
     * @param string $linkList3
     * @return MainSpot
     */
    public function setLinkList3($linkList3)
    {
        $this->linkList3 = $linkList3;

        return $this;
    }

    /**
     * Get linkList3
     *
     * @return string 
     */
    public function getLinkList3()
    {
        return $this->linkList3;
    }

    /**
     * Set image1
     *
     * @param \SIP\ResourceBundle\Entity\Media\Media $image1
     * @return MainSpot
     */
    public function setImage1(\SIP\ResourceBundle\Entity\Media\Media $image1 = null)
    {
        $this->image1 = $image1;

        return $this;
    }

    /**
     * Get image1
     *
     * @return \SIP\ResourceBundle\Entity\Media\Media 
     */
    public function getImage1()
    {
        return $this->image1;
    }

    /**
     * Set image2
     *
     * @param \SIP\ResourceBundle\Entity\Media\Media $image2
     * @return MainSpot
     */
    public function setImage2(\SIP\ResourceBundle\Entity\Media\Media $image2 = null)
    {
        $this->image2 = $image2;

        return $this;
    }

    /**
     * Get image2
     *
     * @return \SIP\ResourceBundle\Entity\Media\Media 
     */
    public function getImage2()
    {
        return $this->image2;
    }

    /**
     * Set image3
     *
     * @param \SIP\ResourceBundle\Entity\Media\Media $image3
     * @return MainSpot
     */
    public function setImage3(\SIP\ResourceBundle\Entity\Media\Media $image3 = null)
    {
        $this->image3 = $image3;

        return $this;
    }

    /**
     * Get image3
     *
     * @return \SIP\ResourceBundle\Entity\Media\Media 
     */
    public function getImage3()
    {
        return $this->image3;
    }

    public function setShowImage1($image) {}

    public function getShowImage1()
    {
        return $this->image1;
    }

    public function setShowImage2($image) {}

    public function getShowImage2()
    {
        return $this->image2;
    }

    public function setShowImage3($image) {}

    public function getShowImage3()
    {
        return $this->image3;
    }

    public function __toString()
    {
        return 'Mainspot';
    }
}
