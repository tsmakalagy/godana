<?php
namespace Godana\Controller;

use SamUser\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class MyUserController extends AbstractActionController
{
	/**
     * @var ObjectManager
     */
    protected $objectManager;
    
	public function listAction()
	{
		$this->layout('layout/admin-layout');
 		$this->layout()->user_active = 'active';
		$om = $this->getObjectManager();
		$users = $om->getRepository('SamUser\Entity\User')->findAll();
		return array(
			'users' => $users
		);
	}
	
	public function getObjectManager()
    {
    	return $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    }
    
    public function setObjectManager($objectManager)
    {
    	$this->objectManager = $objectManager;
    }
}