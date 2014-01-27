<?php
namespace Godana\Entity;

use Doctrine\ORM\Mapping as ORM;

/** 
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="gdn_comment")
 * 
 */
class Comment
{
	/**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
   /**
     * @var text
     * @ORM\Column(type="text")
     */
    protected $detail;
    
    /**
     * 
     * @ORM\ManyToOne(targetEntity="\SamUser\Entity\User")
     * @var \SamUser\Entity\User
     */
    protected $user; 
    
    /**
     * @var datetime
     * @ORM\Column(type="datetime", nullable=true)
     * 
     */
    protected $created;
    
    /**
     * @var integer
     * @ORM\Column(type="integer", name="is_deleted")
     */
    protected $deleted;
    
    /**
     * @ORM\ManyToOne(targetEntity="Feed", inversedBy="comments")
     * @ORM\JoinColumn(name="feed_id", referencedColumnName="id")
     * @var Feed
     */
    protected $feed;
    
	/**
     * @ORM\PrePersist
     */
    public function timestamp()
    {
        if(is_null($this->created)) {
            $this->setCreated(new \DateTime());
        }
        return $this;
    }
    
	/**
     * Get id
     * @return int
     */    
    public function getId()
    {
    	return $this->id;
    }
    
	 /**
     * Set id
     * @param int
     * @return void
     */
    public function setId($id)
    {
    	$this->id = (int) $id;
    }    
    
    public function getDetail()
    {
    	return $this->detail;
    }
    
    public function setDetail($detail)
    {
    	$this->detail = $detail;
    }
    
	public function getUser()
    {
    	return $this->user;
    }
    
    public function setUser($user)
    {
    	$this->user = $user;
    }
    
	public function getCreated()
    {
    	return $this->created;
    }
    
    public function setCreated($created)
    {
    	$this->created = $created;
    }
    
	public function getDeleted()
    {
    	return $this->deleted;
    }
    
    public function setDeleted($deleted)
    {
    	$this->deleted = $deleted;
    }
    
	public function getFeed()
    {
    	return $this->feed;
    }
    
    public function setFeed($feed)
    {
    	$this->feed = $feed;
    }
    
}