<?php
namespace Godana\View\Helper;

use Doctrine\Common\Persistence\ObjectManager;
use ZfcUser\Entity\UserInterface as User;

use Zend\View\Helper\AbstractHelper;
use Zend\Authentication\AuthenticationService;

class UserPicture extends AbstractHelper
{
    /**
     * @var AuthenticationService
     */
    protected $authService;
    
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * __invoke
     *
     * @access public
     * @return array
     */
    public function __invoke($dimension, User $user = null)
    {    	
    	if (null === $user) {
            if ($this->getAuthService()->hasIdentity()) {
                $user = $this->getAuthService()->getIdentity();
                if (!$user instanceof User) {
                    throw new \ZfcUser\Exception\DomainException(
                        '$user is not an instance of User', 500
                    );
                }
            }
        }
        
    	$file = $user->getFile();
        if (isset($file)) {
        	return $file->getImageUrlByDimension($dimension);
        } else {
        	$file = $this->getObjectManager()->getRepository('Godana\Entity\File')->getDefaultImageFile();
        	if (isset($file)) {
        		return $file->getImageUrlByDimension($dimension);
        	}
        }
        return false;
    }

    /**
     * Get authService.
     *
     * @return AuthenticationService
     */
    public function getAuthService()
    {
        return $this->authService;
    }

    /**
     * Set authService.
     *
     * @param AuthenticationService $authService
     * @return \ZfcUser\View\Helper\ZfcUserIdentity
     */
    public function setAuthService(AuthenticationService $authService)
    {
        $this->authService = $authService;
        return $this;
    }
    
    
	public function getObjectManager()
    {
    	return $this->objectManager;
    }
    
    public function setObjectManager(ObjectManager $objectManager)
    {
    	$this->objectManager = $objectManager;
    }
}