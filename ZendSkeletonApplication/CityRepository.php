<?php
namespace Godana\Entity;

use Doctrine\ORM\EntityRepository;

class CityRepository extends EntityRepository
{
//	public function getCitiesByCountryCode($countryCode)
//	{
//		$countryCode = strtolower($countryCode);	
//        return $this->_em->getRepository('Godana\Entity\City')->findByCountryCode($countryCode);
//	}
	
//	public function getCountryCitiesStartingBy($cityName, $countryCode)
//	{
//		$countryCode = strtolower($countryCode);
//		$cityName = $cityName . '%';
//		return $this->_em->createQuery('SELECT c FROM Godana\Entity\City c WHERE c.cityAccented LIKE ? '
//			 . $cityName . ' AND c.countryCode = ? ' . $countryCode)
//                         ->getResult();     
//	}
}