<?php

namespace Stems\SocialBundle\Service;

class Sharer
{
	// the social media platform we're sharing to
	protected $platform;

	protected $title = '';

	protected $text = '';

	protected $url;

	protected $image;

	protected $profile;

	protected $tags = array();

	public function __construct($platform=null) 
	{
		$this->platform = $platform;
	}

	public function getPlatform()
	{
		return $this->platform;
	}

	public function setPlatform($platform)
	{
		 $this->platform = $platform;

		 return $this;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function setTitle($title)
	{
		 $this->title = $title;

		 return $this;
	}

	public function getText()
	{
		return $this->text;
	}

	public function setText($text)
	{
		 $this->text = $text;

		 return $this;
	}

	public function getUrl()
	{
		return $this->url;
	}

	public function setUrl($url)
	{
		 $this->url = $url;

		 return $this;
	}
	
	public function getImage()
	{
		return $this->image;
	}

	public function setImage($image)
	{
		 $this->image = $image;

		 return $this;
	}

	public function getProfile()
	{
		return $this->profile;
	}

	public function setProfile($profile)
	{
		 $this->profile = $profile;

		 return $this;
	}

	public function getTags()
	{
		return $this->tags;
	}

	public function setTags($tags)
	{
		 $this->tags = $tags;

		 return $this;
	}
}