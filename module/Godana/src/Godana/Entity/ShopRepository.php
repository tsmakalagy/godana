<?php
namespace Godana\Entity;

use Doctrine\ORM\EntityRepository;

class ShopRepository extends EntityRepository
{
	public function findShopByOwnerId($ownerId = null)
	{
		$sql = 'SELECT s FROM Godana\Entity\Shop s WHERE s.owner = ?1 AND s.deleted = 0';
		$query = $this->_em->createQuery($sql);
		$query->setParameter(1, $ownerId);
		return $query->getResult();		
	}
	
	public function findAll()
	{
		return $this->findBy(array('deleted' => 0));
	}
	
}