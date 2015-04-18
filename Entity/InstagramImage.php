<?php
namespace Stems\SocialBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Mapping as ORM;


/** 
 * @ORM\Entity
 * @ORM\Table(name="stm_social_instagram_image")
 */
class InstagramImage
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** 
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $moderated = null;

    /** 
     * @ORM\Column(type="datetime")
     */
    protected $added;

    /** 
     * @ORM\Column(type="boolean")
     */
    protected $deleted = false;

    /** 
     * @ORM\Column(type="string")
     */
    protected $caption;

    /** 
     * @ORM\Column(type="string")
     */
    protected $url;

    /** 
     * @ORM\Column(type="array", nullable=true)
     */
    protected $tags = array();

    /** 
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $profile;

    /** 
     * @ORM\Column(type="string")
     */
    protected $image;

    /** 
     * @ORM\Column(type="string")
     */
    protected $thumbnail;

    /**
     * @ORM\ManyToOne(targetEntity="InstagramFeed", inversedBy="images")
     * @ORM\JoinColumn(name="feed_id", referencedColumnName="id")
     */
    protected $feed;

    public function __construct($post=null, $feed=null) 
    {
        $this->added = new \DateTime();

        if ($post) {
            $this->url = $post->link;
            $this->image = $post->images->standard_resolution->url;
            $this->thumbnail = $post->images->thumbnail->url;

	        // Remove emojis from captions
            $this->caption =  preg_replace('/[\x{10000}-\x{10FFFF}]/u', '', $post->caption->text);

            $this->tags = $post->tags;
        }

        $feed and $this->feed = $feed;
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
     * Set caption
     *
     * @param string $caption
     * @return InstagramImage
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;
    
        return $this;
    }

    /**
     * Get caption
     *
     * @return string 
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return InstagramImage
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
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
     * Set tags
     *
     * @param array $tags
     * @return InstagramImage
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    
        return $this;
    }

    /**
     * Get tags
     *
     * @return array 
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set profile
     *
     * @param \profile $profile
     * @return InstagramImage
     */
    public function setProfile(\profile $profile)
    {
        $this->profile = $profile;
    
        return $this;
    }

    /**
     * Get profile
     *
     * @return \profile 
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return InstagramImage
     */
    public function setImage($image)
    {
        $this->image = $image;
    
        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set thumbnail
     *
     * @param string $thumbnail
     * @return InstagramImage
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
    
        return $this;
    }

    /**
     * Get thumbnail
     *
     * @return string 
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * Set feed
     *
     * @param \Stems\SocialBundle\Entity\InstagramFeed $feed
     * @return InstagramImage
     */
    public function setFeed(\Stems\SocialBundle\Entity\InstagramFeed $feed = null)
    {
        $this->feed = $feed;
    
        return $this;
    }

    /**
     * Get feed
     *
     * @return \Stems\SocialBundle\Entity\InstagramFeed 
     */
    public function getFeed()
    {
        return $this->feed;
    }

    /**
     * Set moderated
     *
     * @param DateTime $moderated
     * @return InstagramImage
     */
    public function setModerated($moderated)
    {
        $this->moderated = $moderated;
    
        return $this;
    }

    /**
     * Get moderated
     *
     * @return DateTime 
     */
    public function getModerated()
    {
        return $this->moderated;
    }

    /**
     * Set added
     *
     * @param DateTime $added
     * @return InstagramImage
     */
    public function setAdded($added)
    {
        $this->added = $added;
    
        return $this;
    }

    /**
     * Get added
     *
     * @return DateTime 
     */
    public function getAdded()
    {
        return $this->added;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     * @return InstagramImage
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
}