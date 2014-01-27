<?php
namespace Godana\Entity;

use Doctrine\ORM\EntityRepository;

class FeedRepository extends EntityRepository
{
	public function getAllFeeds()
	{
		$sql = 'SELECT f FROM Godana\Entity\Feed f LEFT JOIN f.post p 
		WHERE p.deleted = 0 ORDER BY p.published DESC';
		$query = $this->_em->createQuery($sql);		
		return $query->getResult();		
	}
	
}