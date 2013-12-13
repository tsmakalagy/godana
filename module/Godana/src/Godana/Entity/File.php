<?php
namespace Godana\Entity;

use Doctrine\ORM\Mapping as ORM;

/** 
 *
 * @ORM\Entity
 * @ORM\Table(name="gdn_file")
 * 
 */
class File
{
	/**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer", name="id_file")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * 
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    protected $type;
    
    /**
     * 
     * @ORM\Column(type="text")
     * @var text
     */
    protected $url;
    
    /**
     * 
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    protected $name;
    
    /**
     * 
     * @ORM\Column(type="integer")
     * @var integer
     */
    protected $size;
    
    /**
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    protected $title;
    
    /**
     * 
     * @ORM\Column(type="text", nullable=true)
     * @var text
     */
    protected $description;
    
    public function getId()
    {
    	return $this->id;
    }
    
    public function setId($id)
    {
    	$this->id = $id;
    }
    
    public function getType()
    {
    	return $this->type;
    }
    
    public function setType($type)
    {
    	$this->type = $type;
    }
    
    public function getUrl()
    {
    	return $this->url;
    }
    
    public function setUrl($url)
    {
    	$this->url = $url;
    }
    
    public function getName()
    {
    	return $this->name;
    }
    
    public function setName($name)
    {
    	$this->name = $name;
    }
    
    public function getSize()
    {
    	return $this->size;
    }
    
    public function setSize($size)
    {
    	$this->size = $size;
    }   
        
	public function getTitle()
    {
    	return $this->title;
    }
    
    public function setTitle($title)
    {
    	$this->title = $title;
    }
    
	public function getDescription()
    {
    	return $this->description;
    }
    
    public function setDescription($description)
    {
    	$this->description = $description;
    }
    
    public function getThumbnailUrl()
    {
    	$url = $this->url;
    	$imgUrl = substr($url, 0, strrpos($url, '/'));
    	return $imgUrl . '/thumbnail/' . $this->name;
    }
}