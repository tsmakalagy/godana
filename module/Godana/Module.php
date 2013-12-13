<?php
namespace Godana;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;

class Module
{	
	public function getConfig()
	{
		return include __DIR__ . '/config/module.config.php';
	}
	
	public function getAutoloaderConfig()
	{
		return array( 
           	'Zend\Loader\StandardAutoloader' => array( 
               	'namespaces' => array( 
                   	__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__ 
               	) 
           	)
       	);
	}
	
	public function getControllerPluginConfig()
    {
        return array(
            'factories' => array(
                'slug' => function ($sm) {                    
                    $slugPlugin = new Controller\Plugin\Slug;
                    return $slugPlugin;
                },
            ),
        );
    }
	
	public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'currentUserRole' => function ($sm) {
                    $locator = $sm->getServiceLocator();
                    $viewHelper = new View\Helper\CurrentUserRole;
                    $viewHelper->setAuthService($locator->get('zfcuser_auth_service'));
                    return $viewHelper;
                },
            ),
        );

    }
    
    public function getServiceConfig()
    {
    	return array(
    		'factories' => array(
    			'godana_post_form' => function($sm) {                    
                    $om = $sm->get('Doctrine\ORM\EntityManager');
                    $form = new Form\Post('post');
                    $categories = $om->getRepository('Godana\Entity\Category')->findAll();
                    $value_options = array('1' => 'blabla');
                    foreach ($categories AS $category) {
                    	$id = $category->getId();
                    	$ident = $category->getIdent();
                    	$value_options[$id] = $ident;
                    }
                    $selectCategory = $form->get('categories');
                    $selectCategory->setValueOptions($value_options);
                    $selectCategory->setAttribute('class', 'chzn-select');
                    $selectCategory->setAttribute('data-placeholder', 'Choose a category...');
                    return $form;
                },
                'post_form' => function($sm) {
                	$om = $sm->get('Doctrine\ORM\EntityManager');
                	$forms = $sm->get('FormElementManager');
                	$form = $forms->get('Godana\Form\PostForm');
                	$postFieldset = $forms->get('PostFieldset');
                	
			        $postFieldset->setUseAsBaseFieldset(true);
                    $form->add($postFieldset);
                	return $form;
                },
                'bid_form' => function($sm) {
                	$om = $sm->get('Doctrine\ORM\EntityManager');
                	$forms = $sm->get('FormElementManager');
                	$form = $forms->get('Godana\Form\BidForm');
                	$bidFieldset = $forms->get('BidFieldset');
                	
			        $bidFieldset->setUseAsBaseFieldset(true);
                    $form->add($bidFieldset);
                	return $form;
                },
                'file_form' => function($sm) {
                	$forms = $sm->get('FormElementManager');
                	$form = $forms->get('Godana\Form\UploadForm');
                	$form->setAttribute('name', 'fileupload');
                	return $form;
                },
                'upload_handler' => function($sm) {
                	$om = $sm->get('Doctrine\ORM\EntityManager');
                	$authService = $sm->get('zfcuser_auth_service');
                	$options = array(
						'delete_type' => 'POST',
                		'user_dirs' => true,
					);
                	$uploadHandler = new \JqueryFileUpload\Handler\CustomUploadHandler($om, $authService, $options);
                	return $uploadHandler;
                },
                'shop_form' => function($sm) {
                	$om = $sm->get('Doctrine\ORM\EntityManager');
                	$forms = $sm->get('FormElementManager');
                	$form = $forms->get('Godana\Form\ShopForm');
                	
                	$shopFieldset = $forms->get('ShopFieldset');
                	$shopFieldset->remove('cities');
                	$shopFieldset->add(
			            array(
			                'type' => 'text',
			                'name' => 'idCity',
			                'attributes' => array(
			            		'class' => 'form-control',
			            		'id' => 'id_city',
			                ),                
			                'options' => array(
			                    'label'          => 'City',
			                	'label_attributes' => array(
						            'class' => 'col-sm-3 control-label',
						        ),    
			                ),
			            )
			        );
			        
			        $shopFieldset->add(array(
			            'type' => 'Zend\Form\Element\Hidden',
			            'name' => 'cities',
			        	'attributes' => array(
			        		'id' => 'city'
			        	)
			        ));
			        $shopFieldset->setUseAsBaseFieldset(true);
                    $form->add($shopFieldset);
                	return $form;
                },
                'shop_edit_form' => function($sm) {
                	$om = $sm->get('Doctrine\ORM\EntityManager');
                	$forms = $sm->get('FormElementManager');
                	$form = $forms->get('Godana\Form\ShopEditForm');
//                	$shopFieldset = $forms->get('ShopFieldset');
//                	$shopFieldset->remove('idCity');
//                	$shopFieldset->remove('cities');
//			        $shopFieldset->setUseAsBaseFieldset(true);
//                    $form->add($shopFieldset);
                	return $form;
                },
                'product_type_form' => function($sm) {
                	$om = $sm->get('Doctrine\ORM\EntityManager');
                	$forms = $sm->get('FormElementManager');
                	$form = $forms->get('Godana\Form\ProductTypeForm');
                	$productTypeFieldset = $forms->get('ProductTypeFieldset');
                	
			        $productTypeFieldset->setUseAsBaseFieldset(true);
                    $form->add($productTypeFieldset);
                	return $form;
                },
                'product_form' => function($sm) {
                	$om = $sm->get('Doctrine\ORM\EntityManager');
                	$forms = $sm->get('FormElementManager');
                	$form = $forms->get('Godana\Form\ProductForm');
                	$productFieldset = $forms->get('ProductFieldset');
			        $productFieldset->setUseAsBaseFieldset(true);			        
                    $form->add($productFieldset);
                	return $form;
                },
    		),
    	);
    }
	
	public function init(\Zend\ModuleManager\ModuleManager $moduleManager) 
   	{
   		$sharedEvents = $moduleManager
   			->getEventManager()->getSharedManager();
   		$sharedEvents->attach(
   			'Godana\Controller\IndexController',
   			'dispatch',
   				function($e) {
   					$controller = $e->getTarget();
   					$controller->layout('layout/layout');
   				},
   			100
   		);
   	}
   	
   	public function onBootstrap($e)
   	{
   		$app = $e->getParam('application');
   		$app->getEventManager()->attach('dispatch', array($this, 'setTranslator'));
   		
   	}
   	
   	public function setTranslator($e)
   	{
   		$app = $e->getParam('application');
   		
   		$translator = $app->getServiceManager()->get('translator');
   		$matches = $e->getRouteMatch();
   		$lang = $matches->getParam('lang', 'mg');
   		$language = 'en_US';
   		if ($lang == 'en') {
   			$language = 'en_US';	
   		} else if ($lang == 'fr') {
   			$language = 'fr_FR';
   		} else if ($lang == 'mg') {
   			$language = 'mg_MG';
   		}
   		$translator->setLocale($language);
   	}
   	
	public function getFormElementConfig()
	{
	    return array(
	    	'invokables' => array(
                'ContactFieldset' => 'Godana\Form\ContactFieldset',
	    		'PostFieldset' => 'Godana\Form\PostFieldset',
	    		'BidFieldset' => 'Godana\Form\BidFieldset',
	    		'ShopFieldset' => 'Godana\Form\ShopFieldset',
	    		'ProductTypeFieldset' => 'Godana\Form\ProductTypeFieldset',
	    		'ProductFieldset' => 'Godana\Form\ProductFieldset',
            ),
	        'initializers' => array(
	            'ObjectManagerInitializer' => function ($element, $formElements) {
	                if ($element instanceof ObjectManagerAwareInterface) {
	                    $services      = $formElements->getServiceLocator();
	                    $entityManager = $services->get('Doctrine\ORM\EntityManager');
	
	                    $element->setObjectManager($entityManager);
	                }
	            },
	        ),
	    );
	}
}