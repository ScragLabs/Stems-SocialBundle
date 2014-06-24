<?php
namespace Stems\SocialBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Mapping as ORM;


/** 
 * @ORM\Entity
 * @ORM\Table(name="stm_social_instagram_feed")
 */
class InstagramFeed
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** 
     * @ORM\Column(type="string")
     */
    protected $name;

    /** 
     * @ORM\Column(type="string")
     */
    protected $slug;

    /** 
     * @ORM\Column(type="string", nullable=true)
     */
    protected $tag;

    /** 
     * @ORM\Column(type="boolean")
     */
    protected $moderated = true;

    /** 
     * @ORM\Column(type="boolean")
     */
    protected $deleted = false;

    /** 
     * @ORM\Column(type="string", nullable=true)
     */
    protected $profile;

    /** 
     * @ORM\Column(type="datetime")
     */
    protected $updated;

    /**
     * @ORM\OneToMany(targetEntity="InstagramImage", mappedBy="feed")
     * @ORM\OrderBy({"added" = "DESC"})
     */
    protected $images; 

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
     * Constructor
     */
    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set name
     *
     * @param string $name
     * @return InstagramFeed
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

    /**
     * Set slug
     *
     * @param string $slug
     * @return InstagramFeed
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
     * Set tag
     *
     * @param string $tag
     * @return InstagramFeed
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
    
        return $this;
    }

    /**
     * Get tag
     *
     * @return string 
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set moderated
     *
     * @param boolean $moderated
     * @return InstagramFeed
     */
    public function setModerated($moderated)
    {
        $this->moderated = $moderated;
    
        return $this;
    }

    /**
     * Get moderated
     *
     * @return boolean 
     */
    public function getModerated()
    {
        return $this->moderated;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     * @return InstagramFeed
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    
        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean 
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set profile
     *
     * @param string $profile
     * @return InstagramFeed
     */
    public function setProfile($profile)
    {
        $this->profile = $profile;
    
        return $this;
    }

    /**
     * Get profile
     *
     * @return string 
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * Add images
     *
     * @param \Stems\SocialBundle\Entity\InstagramImage $images
     * @return InstagramFeed
     */
    public function addImage(\Stems\SocialBundle\Entity\InstagramImage $images)
    {
        $this->images[] = $images;
    
        return $this;
    }

    /**
     * Remove images
     *
     * @param \Stems\SocialBundle\Entity\InstagramImage $images
     */
    public function removeImage(\Stems\SocialBundle\Entity\InstagramImage $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set updated
     *
     * @param DateTime $updated
     * @return InstagramFeed
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    
        return $this;
    }

    /**
     * Get updated
     *
     * @return DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }
}