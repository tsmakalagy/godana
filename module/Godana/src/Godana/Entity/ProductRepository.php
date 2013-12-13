<?php
namespace Godana\Entity;

use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{
	
	public function findAll()
	{
		return $this->findBy(array('deleted' => 0));
	}
	
}