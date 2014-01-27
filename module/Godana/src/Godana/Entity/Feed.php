<?php
namespace Godana\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as Collection;

/** 
 *
 * @ORM\Entity(repositoryClass="Godana\Entity\FeedRepository")
 * @ORM\Table(name="gdn_feed")
 * 
 */
class Feed 
{
	/**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var \Godana\Entity\Post
     * @ORM\OneToOne(targetEntity="Post")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id_post")
     */
    protected $post;
    
    
    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="feed")
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $comments;
    
	public function __construct()
    {
    	$this->comments = new Collection();
    }
       
    public function getId()
    {
    	return $this->id;
    }
    
    public function setId($id)
    {
    	$this->id = (int) $id;
    }
    
	/**
     * Get Post
     * @return Post
     * 
     */
    public function getPost()
    {
    	return $this->post;
    }
    
    /**
     * Set Post 
     * @param Post
     * @return void
     * 
     */
    public function setPost(Post $post)
    {
    	$this->post = $post;
    }
    
	public function getComments()
    {
    	return $this->comments;
    }
    
    public function addComment($comment)
    {
    	$this->comments[] = $comment;
    }
    
	public function addComments(Collection $comments)
    {
        foreach ($comments as $comment) {
            $this->comments->add($comment);
        }
    }

    public function removeComments(Collection $comments)
    {
        foreach ($comments as $comment) {
            $this->comments->removeElement($comment);
        }
    }
}