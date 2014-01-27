<?php
namespace Godana\Controller;

use Zend\Form\Form;
use Godana\Entity\ProductType;
use Godana\Entity\Product;
use Godana\Entity\Attribute;
use Godana\Entity\ProductAttribute;
use Doctrine\Common\Persistence\ObjectManager;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ProductController extends AbstractActionController
{
	/** 
     * @var Form
     */
    protected $productTypeForm;
    
    /**
     * 
     * @var Form
     */
    protected $productForm;
    
    /**
     * @var Form
     */
    protected $fileForm;
    
    /**
     * @var ObjectManager
     */
    protected $objectManager;
	
	public function typeAction()
 	{
 		$this->layout('layout/admin-layout');
 		$this->layout()->product_active = 'active';
 		$om = $this->getObjectManager(); 		
	    $lang = $this->params()->fromRoute('lang', 'mg');
	    $form = $this->getProductTypeForm();
	
	    // Create a new, empty entity and bind it to the form
	    $productType = new ProductType();
	    $form->bind($productType);
	    
	    if ($this->request->isPost()) {
	        $form->setData($this->request->getPost());			
	        if ($form->isValid()) {
	        	$productTypeForm = $this->request->getPost()->get('product-type-form');
	        	if (array_key_exists('new-attributes', $productTypeForm)) {
		        	$newAttributes = $productTypeForm['new-attributes'];
		        	if (isset($newAttributes) && count($newAttributes) > 0) {
			        	foreach ($newAttributes as $attribute) {
			        		$name = $attribute['name'];
			        		$newAttribute = new Attribute();
			        		$newAttribute->setName($name);
			        		$productType->addAttribute($newAttribute);
			        	}	
		        	}	
	        	}
	        	$om->persist($productType);
	            $om->flush();
	        }
		}
		
		return array(
	    	'productTypeForm' => $form,
	    	'lang' => $lang,
	    );
 	}
 	
 	public function addAction()
 	{
 		$this->layout('layout/admin-layout');
 		$this->layout()->product_active = 'active';
 		$om = $this->getObjectManager(); 		
	    $lang = $this->params()->fromRoute('lang', 'mg');
	    $form = $this->getProductForm();
	    $fileform = $this->getFileForm();
		
	    // Create a new, empty entity and bind it to the form
	    $product = new Product();
	    $form->bind($product);
	    
	    // Proxy for shop-fieldset
	    $ownerId = $this->zfcUserAuthentication()->getIdentity()->getId();
	    $shopProxy = $form->get('product-form')->get('shop')->getProxy();
		$shopProxy->setIsMethod(true)
        	->setFindMethod(array(
                'name'   => 'findShopByOwnerId',
                'params' => array('ownerId' => $ownerId),
           ));
	    
	    if ($this->request->isPost()) {
	        $form->setData($this->request->getPost());	
	        $listFileId = array();		
	        if ($form->isValid()) {
	       		$listFileId = $this->request->getPost()->get('file-id');
	            if (count($listFileId) > 0) {
	            	foreach ($listFileId as $fileId) {
	            		$file = $om->find('Godana\Entity\File', (int)$fileId);
	            		if ($file instanceof \Godana\Entity\File) {
	            			$product->addFile($file);
	            			$om->persist($product);
	            		}	            		
	            	}
	            	$om->flush();
	            } else {
	            	$om->persist($product);
	            	$om->flush();
	            }
	        	$attributesGroup = $this->request->getPost()->get('attributes');
	        	foreach ($attributesGroup as $attributesElement) {
	        		$id = $attributesElement['id'];
	        		$value = $attributesElement['value'];
	        		$attribute = $om->getRepository('Godana\Entity\Attribute')->find($id);
	        		if (isset($value) && strlen($value) > 0) {
	        			$productAttr = new ProductAttribute($product, $attribute, $value);
	        			$om->persist($productAttr);
	        		}
	        	}
	        	$om->flush();
	        }
	    }
	    return array(
	    	'productForm' => $form,
	    	'fileForm' => $fileform,
	    	'lang' => $lang,
	    );
 	}
 	
	public function detailAction()
 	{
 		$om = $this->getObjectManager();
 		$productId = $this->params()->fromRoute('productId', null);
 		$shopIdent = $this->params()->fromRoute('shopIdent', null);
 		if ($shopIdent == null) {
 			return;
 		} else {
 			$shop = $om->getRepository('Godana\Entity\Shop')->findOneByIdent($shopIdent);
 		} 		
 		$lang = $this->params()->fromRoute('lang', 'mg');
 		if ($productId == null) {
 			return $this->redirect()->toRoute('detail-shop', array('lang' => $lang, 'shopIdent' => $shopIdent));
 		} 			
		$product = $om->getRepository('Godana\Entity\Product')->findById($productId);	
//		if ($product instanceof Godana\Entity\Product) {
			return new ViewModel(
	 			array(
	 				'shop' => $shop,
	 				'product' => $product,
	 				'lang' => $lang,
	 			)
	 		);
//		}		
 	}
 	
	public function ajaxAction()
 	{ 	
 		$om = $this->getObjectManager();	
        //$uploadhandler = $this->getServiceLocator()->get('bid_upload_handler');
        $options = array(
			'delete_type' => 'POST',
                'user_dirs' => true,
		);
        $uploadhandler = new \JqueryFileUpload\Handler\ProductUploadHandler($om, 1, $options);        
        return $this->getResponse();
        
 	}
 	
 	public function listAttributeAction()
 	{
 		$om = $this->getObjectManager();
 		$productTypeId = $this->params()->fromQuery('productType', null);
 		if ($productTypeId != null) {
 			$productType = $om->getRepository('Godana\Entity\ProductType')->find($productTypeId);
 			$attributes = $productType->getAttributes();
 			if (isset($attributes) && count($attributes) > 0) {
 				$result = array();
 				$result['unit'] = ucfirst($productType->getUnit());
 				$result['attribute'] = array();
 				foreach ($attributes as $attribute) {
 					$id = $attribute->getId();
 					$name = ucfirst($attribute->getName());
 					$res = array('id' => $id, 'name' => $name);
 					array_push($result['attribute'], $res);
 				}	
 				return new \Zend\View\Model\JsonModel($result);
 			}
 			
 		}
 		return null;
 	}
 	
	public function getProductTypeForm()
    {
        if (!$this->productTypeForm) {
            $this->setProductTypeForm($this->getServiceLocator()->get('product_type_form'));
        }
        return $this->productTypeForm;
    }

    public function setProductTypeForm(Form $productTypeForm)
    {
        $this->productTypeForm = $productTypeForm;
    }
    
	public function getProductForm()
    {
        if (!$this->productForm) {
            $this->setProductForm($this->getServiceLocator()->get('product_form'));
        }
        return $this->productForm;
    }

    public function setProductForm(Form $productForm)
    {
        $this->productForm = $productForm;
    }
    
	public function getFileForm()
    {
        if (!$this->fileForm) {
            $this->setFileForm($this->getServiceLocator()->get('file_form'));
        }
        return $this->fileForm;
    }

    public function setFileForm(Form $fileForm)
    {
        $this->fileForm = $fileForm;
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