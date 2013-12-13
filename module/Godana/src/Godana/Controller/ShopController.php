<?php
namespace Godana\Controller;

use Zend\Form\Form;
use Godana\Entity\Shop;
use Godana\Entity\Bid;
use Godana\Entity\Category;
use Godana\Form\ShopForm;
use Doctrine\Common\Persistence\ObjectManager;
 
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;

class ShopController extends AbstractActionController
{
	/**
     * @var Form
     */
    protected $shopForm;
    
    /**
     * @var Form
     */
    protected $shopEditForm;
    
    /** 
     * @var Form
     */
    protected $productTypeForm;
    
    
    /**
     * @var ObjectManager
     */
    protected $objectManager;
    
    
	public function indexAction()
	{
		$this->layout('layout/admin-layout');
 		$this->layout()->shop_active = 'active';
 		$om = $this->getObjectManager();
 		$shops = $om->getRepository('Godana\Entity\Shop')->findAll();
 		
 		return array("shops" => $shops);
 	}
 	
 	public function listAction()
 	{
 		$om = $this->getObjectManager();
 		$categoryIdent = $this->params()->fromRoute('categoryIdent', null);
 		$shops = null;
 		if ($categoryIdent == null) {
 			$shops = $om->getRepository('Godana\Entity\Shop')->findAll();	
 		} else {
 			$category = $om->getRepository('Godana\Entity\Category')->findOneBy(array('ident' => $categoryIdent));
 			$shops = $category->getShops();
 		}
 		
 		
 		return array("shops" => $shops);
 	}
 	
 	public function detailAction()
 	{
 		$om = $this->getObjectManager();
 		$shopIdent = $this->params()->fromRoute('shopIdent', null);
 		if ($shopIdent == null) {
 			return;
 		} else {
 			$shop = $om->getRepository('Godana\Entity\Shop')->findOneByIdent($shopIdent);
 		}
 		return array("shop" => $shop);
 	}
 	
 	public function addAction()
 	{
 		$this->layout('layout/admin-layout');
 		$this->layout()->shop_active = 'active';
 		$om = $this->getObjectManager(); 		
	    $lang = $this->params()->fromRoute('lang', 'mg');
	    $form = $this->getShopForm();
	    // Create a new, empty entity and bind it to the form
	    $shop = new Shop();
	    $form->bind($shop);
		
	    if ($this->request->isPost()) {
	        $form->setData($this->request->getPost());			
	        if ($form->isValid()) {
	        	$shop->setIdent($this->slug()->seoUrl($shop->getName()));
	        	$shopForm = $this->request->getPost()->get('shop-form');
	        	if (array_key_exists('new-categories', $shopForm)) {
		        	$newCategories = $shopForm['new-categories'];
		        	if (isset($newCategories) && count($newCategories) > 0) {		        		
			        	foreach ($newCategories as $category) {
			        		$name = $category['name'];
			        		$ident = $this->slug()->seoUrl($name);
			        		$type = 1;
			        		$newCategory = new Category();
			        		$newCategory->setName($name);
			        		$newCategory->setIdent($ident);
			        		$newCategory->setType($type);
			        		$om->persist($newCategory);
		        			$om->flush();
			        		$shop->addCategory($newCategory);
			        	}	
		        	}	
	        	}
	        	
	        	
	        	$om->persist($shop);
	            $om->flush();
	            return $this->redirect()->toRoute('admin/shop_admin');
	        }
	        
	    }
		
	    return array(
	    	'shopForm' => $form,
	    	'lang' => $lang,
	    ); 
 	}
 	
 	public function editAction()
 	{
 		$this->layout('layout/admin-layout');
 		$this->layout()->shop_active = 'active';
 		$om = $this->getObjectManager(); 		
	    $lang = $this->params()->fromRoute('lang', 'mg');
	    $shopId = $this->params()->fromRoute('id', null);
	    if ($shopId == null) {
	    	return;
	    }
	    $shop = $om->getRepository('Godana\Entity\Shop')->find($shopId);
	    $form = $this->getShopEditForm();
	    
	    $form->bind($shop);
 		if ($this->request->isPost()) {
	        $form->setData($this->request->getPost());	
	        if ($form->isValid()) {
	        	
	        	$shopForm = $this->request->getPost()->get('shop-form');
	        	
	        	if (array_key_exists('new-categories', $shopForm)) {
		        	$newCategories = $shopForm['new-categories'];
		        	if (isset($newCategories) && count($newCategories) > 0) {
			        	foreach ($newCategories as $category) {
			        		$name = $category['name'];
			        		$ident = $this->slug()->seoUrl($name);
			        		$type = 1;
			        		$newCategory = new Category();
			        		$newCategory->setName($name);
			        		$newCategory->setIdent($ident);
			        		$newCategory->setType($type);
			        		$shop->addCategory($newCategory);
			        	}	
		        	}	
	        	}
	        	
	        	$shop->setIdent($this->slug()->seoUrl($shop->getName()));	        	
	        	$om->persist($shop);
	            $om->flush();
	            return $this->redirect()->toRoute('admin/shop_admin');
	        }
	        
	    }
	    return array(
	    	'shopForm' => $form,
	    	'lang' => $lang,
	    	'shopId' => $shopId
	    ); 
 	}
 	
 	public function deleteAction()
 	{
 		$this->layout('layout/admin-layout');
 		$this->layout()->shop_active = 'active';
 		$om = $this->getObjectManager(); 		
	    $lang = $this->params()->fromRoute('lang', 'mg');
	    $shopId = $this->params()->fromRoute('id', null);
	    if ($shopId == null) {
	    	return;
	    }
	    $shop = $om->getRepository('Godana\Entity\Shop')->find($shopId);
	    $shop->setDeleted(1);
	    $om->persist($shop);
	    $om->flush();
	    return $this->redirect()->toRoute('admin/shop_admin');
 	}
 	
	public function cityAction()
 	{
 		$om = $this->getObjectManager();
 		$tag = $this->params()->fromQuery('q', null);
 		$page_limit = $this->params()->fromQuery('page_limit', 10);
 		$page = $this->params()->fromQuery('page', 1);
 		$query = $om->getRepository('Godana\Entity\City')->getCitiesQB($tag);
 		
		$adapter = new DoctrineAdapter(new ORMPaginator($query));
   		
		$paginator = new Paginator($adapter);
   		$paginator->setDefaultItemCountPerPage($page_limit);
		$paginator->setCurrentPageNumber($page);
        $result = array();
 		$result['total'] = count($paginator);
 		$result['results'] = array();
		foreach($paginator AS $item) {
			$res = array(
				'id' => $item->getId(),
				'text' => $item->getCityAccented()
			);
			array_push($result['results'], $res);
		}
 		return new \Zend\View\Model\JsonModel($result);
 	}
 	
	public function getShopForm()
    {
        if (!$this->shopForm) {
            $this->setShopForm($this->getServiceLocator()->get('shop_form'));
        }
        return $this->shopForm;
    }

    public function setShopForm(Form $shopForm)
    {
        $this->shopForm = $shopForm;
    }    
    
    public function getShopEditForm()
    {
        if (!$this->shopEditForm) {
            $this->setShopEditForm($this->getServiceLocator()->get('shop_edit_form'));
        }
        return $this->shopEditForm;
    }

    public function setShopEditForm(Form $shopEditForm)
    {
        $this->shopEditForm = $shopEditForm;
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