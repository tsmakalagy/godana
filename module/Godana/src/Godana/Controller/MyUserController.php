<?php
namespace Godana\Controller;

use SamUser\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;

use Zend\Stdlib\ResponseInterface as Response;
use Zend\Form\Form;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZfcUser\Service\User as UserService;

class MyUserController extends AbstractActionController
{
	const ROUTE_EDIT_ROLE = 'admin/user/role_change';
	const ROUTE_LIST_USER = 'admin/user';
	const ROUTE_EDIT_USER = 'admin/user/edit';
	const ROUTE_ADD_USER = 'admin/user/add';
	
	/**
     * @var UserService
     */
    protected $userService;
	
	/**
	 * @var Form
	 * 
	 */
	protected $roleForm;
	
	/**
	 * 
	 * @var Form
	 */
	protected $userEditForm;
	
	/**
	 * 
	 * @var Form
	 */
	protected $userAddForm;
	
	/**
     * @var ObjectManager
     */
    protected $objectManager;
    
	public function listAction()
	{
		$this->layout('layout/sb-admin-layout');
 		$this->layout()->user_active = 'active';
 		$lang = $this->params()->fromRoute('lang', 'mg');
		$om = $this->getObjectManager();
		$users = $om->getRepository('SamUser\Entity\User')->findAll();
		return array(
			'users' => $users,
			'lang' => $lang,
		);
	}
	
	public function editUserAction()
	{
		$this->layout('layout/sb-admin-layout');
 		$this->layout()->user_active = 'active';
		$om = $this->getObjectManager();
		$lang = $this->params()->fromRoute('lang', 'mg');
		$userId = $this->params()->fromRoute('userId', null);
		
		$form = $this->getUserEditForm();
		
		
		if ($userId != null) {
			$user = $om->getRepository('SamUser\Entity\User')->find($userId);
			$form->bind($user);
			$dob = $user->getDateofbirth();
			if (isset($dob)) {
				$form->get('user-form')->get('dateofbirth')->setValue($dob->format('m/d/Y'));	
			}		
			
			$url = $this->url()->fromRoute(static::ROUTE_EDIT_USER, array('lang' => $lang, 'userId' => $userId));
		    $prg = $this->prg($url, true);
	        if ($prg instanceof Response) {        	
	            return $prg;
	        } elseif ($prg === false) {
	            return array(
			    	'userEditForm' => $form,
	            	'lang' => $lang,
	            	'user' => $user,
			    );
	        }
	        $post = $prg;
	        $form->setData($post);
			if ($form->isValid()) {
	     		$om->persist($user);
	            $om->flush();
				return $this->redirect()->toUrl($this->url()->fromRoute(static::ROUTE_LIST_USER, array('lang' => $lang)));
	        }
		}
		return array(
	    	'userEditForm' => $form,
            'lang' => $lang,
            'user' => $user,
	    );
	}
	
	public function addUserAction()
	{
		$this->layout('layout/sb-admin-layout');
 		$this->layout()->user_active = 'active';
		$om = $this->getObjectManager();
		$lang = $this->params()->fromRoute('lang', 'mg');
		
		$form = $this->getUserAddForm();			
		$service = $this->getUserService();
		
		$url = $this->url()->fromRoute(static::ROUTE_ADD_USER, array('lang' => $lang));
	    $prg = $this->prg($url, true);
        if ($prg instanceof Response) {        	
            return $prg;
        } elseif ($prg === false) {
            return array(
		    	'addUserForm' => $form,
            	'lang' => $lang,
		    );
        }
        $post = $prg;
        $user = $service->register($post);
        if (!$user) { 
        	return array(
		    	'addUserForm' => $form,
	            'lang' => $lang,
		    );
        }
		
	    return $this->redirect()->toUrl($this->url()->fromRoute(static::ROUTE_LIST_USER, array('lang' => $lang)));
	}
	
	public function changeRoleAction()
	{
		$this->layout('layout/sb-admin-layout');
 		$this->layout()->user_active = 'active';
		$om = $this->getObjectManager();
		$lang = $this->params()->fromRoute('lang', 'mg');
		$userId = $this->params()->fromRoute('userId', null);
		
		$form = $this->getRoleForm();
		
		
		if ($userId != null) {
			$user = $om->getRepository('SamUser\Entity\User')->find($userId);
			$form->bind($user);
			$url = $this->url()->fromRoute(static::ROUTE_EDIT_ROLE, array('lang' => $lang, 'userId' => $userId));
		    $prg = $this->prg($url, true);
	
	        if ($prg instanceof Response) {        	
	            return $prg;
	        } elseif ($prg === false) {
	            return array(
			    	'userRoleForm' => $form,
	            	'lang' => $lang,
	            	'user' => $user,
			    );
	        }
	        $post = $prg; 	    
	        $form->setData($post);
			if ($form->isValid()) {
	     		$om->persist($user);
	            $om->flush();
				return $this->redirect()->toUrl($this->url()->fromRoute(static::ROUTE_LIST_USER, array('lang' => $lang)));
	        }
		}	
		return array(
	    	'userRoleForm' => $form,
			'lang' => $lang,
			'user' => $user,
	    );	
	}
	
	public function getRoleForm()
	{
		if (!$this->roleForm) {
            $this->setRoleForm($this->getServiceLocator()->get('user_role_form'));
        }
		return $this->roleForm;
	}
	
	public function setRoleForm(Form $roleForm)
	{
		$this->roleForm = $roleForm;
	}
	
	public function getUserEditForm()
	{
		if (!$this->userEditForm) {
            $this->setUserEditForm($this->getServiceLocator()->get('user_edit_form'));
        }
		return $this->userEditForm;
	}
	
	public function setUserEditForm(Form $userEditForm)
	{
		$this->userEditForm = $userEditForm;
	}
	
	public function getUserAddForm()
	{
		if (!$this->userAddForm) {
            $this->setUserAddForm($this->getServiceLocator()->get('user_add_form'));
        }
		return $this->userAddForm;
	}
	
	public function setUserAddForm(Form $userAddForm)
	{
		$this->userAddForm = $userAddForm;
	}
	
	public function getObjectManager()
    {
    	return $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    }
    
    public function setObjectManager($objectManager)
    {
    	$this->objectManager = $objectManager;
    }
    
	public function getUserService()
    {
        if (!$this->userService) {
            $this->userService = $this->getServiceLocator()->get('zfcuser_user_service');
        }
        return $this->userService;
    }

    public function setUserService(UserService $userService)
    {
        $this->userService = $userService;
        return $this;
    }
}