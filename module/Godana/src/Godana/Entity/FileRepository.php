<?php
namespace Godana\Entity;

use Doctrine\ORM\EntityRepository;

class FileRepository extends EntityRepository
{
	public function getImageUrlByDimension($fileId, $dimension)
    {
    	$sql = 'SELECT f, i FROM Godana\Entity\File f JOIN f.images i 
    		WHERE f.id = ?1 AND i.dimension = ?2';
    	$query = $this->_em->createQuery($sql);
		$query->setParameter(1, $fileId);
		$query->setParameter(2, $dimension);
		$file = $query->getSingleResult();
		$images = $file->getImages();
		$url = $file->getUrl();
		$image = $images[0];
		$imageName = $image->getName();
		$imgUrl = substr($url, 0, strrpos($url, '/'));
    	return $imgUrl . '/cropped/' . $imageName;
    }
    
	public function getDefaultImageFile()
	{
		$sql = 'SELECT f FROM Godana\Entity\File f WHERE f.url LIKE \'%/users/default/%\'';
		$query = $this->_em->createQuery($sql);
		return $query->getSingleResult();
	}
}