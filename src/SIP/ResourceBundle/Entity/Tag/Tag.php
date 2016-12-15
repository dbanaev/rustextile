<?php
/*
 * (c) Suhinin Ilja <iljasuhinin@gmail.com>
 */
namespace SIP\ResourceBundle\Entity\Tag;

use \FPN\TagBundle\Entity\Tag as BaseTag;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * SIP\ResourceBundle\Entity\Tag\Tag
 *
 * @ORM\Table(name="sip_tag_tag")
 * @ORM\Entity(repositoryClass="SIP\TagBundle\Repository\TagRepository")
 */
class Tag extends BaseTag
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Gedmo\Slug(fields={"name"})
     */
    protected $slug;

    /**
     * @ORM\OneToMany(targetEntity="Tagging", mappedBy="tag", fetch="EAGER", orphanRemoval=true)
     **/
    protected $tagging;

    /**
     * @ORM\Column(type="string", name="meta_title", nullable=true)
     */
    protected $metaTitle;

    /**
     * @ORM\Column(type="text", name="meta_description", nullable=true)
     */
    protected $metaDescription;

    /**
     * @ORM\Column(type="string", name="meta_keywords", nullable=true)
     */
    protected $metaKeywords;

    /**
     * @param $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    public function __toString()
    {
        return (string)$this->getName();
    }

    /**
     * Set metaTitle
     *
     * @param string $metaTitle
     * @return Tag
     */
    public function setMetaTitle($metaTitle)
    {
        $this->metaTitle = $metaTitle;

        return $this;
    }

    /**
     * Get metaTitle
     *
     * @return string 
     */
    public function getMetaTitle()
    {
        return $this->metaTitle;
    }

    /**
     * Set metaDescription
     *
     * @param string $metaDescription
     * @return Tag
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    /**
     * Get metaDescription
     *
     * @return string 
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * Set metaKeywords
     *
     * @param string $metaKeywords
     * @return Tag
     */
    public function setMetaKeywords($metaKeywords)
    {
        $this->metaKeywords = $metaKeywords;

        return $this;
    }

    /**
     * Get metaKeywords
     *
     * @return string 
     */
    public function getMetaKeywords()
    {
        return $this->metaKeywords;
    }

    /**
     * Add tagging
     *
     * @param \SIP\ResourceBundle\Entity\Tag\Tagging $tagging
     * @return Tag
     */
    public function addTagging(\SIP\ResourceBundle\Entity\Tag\Tagging $tagging)
    {
        $this->tagging[] = $tagging;

        return $this;
    }

    /**
     * Remove tagging
     *
     * @param \SIP\ResourceBundle\Entity\Tag\Tagging $tagging
     */
    public function removeTagging(\SIP\ResourceBundle\Entity\Tag\Tagging $tagging)
    {
        $this->tagging->removeElement($tagging);
    }

    /**
     * Get tagging
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTagging()
    {
        return $this->tagging;
    }
}
