<?php
namespace Godana\Form;

use Godana\Entity\Shop;
use Zend\Form\Fieldset;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;

class ShopFieldset extends Fieldset implements InputFilterProviderInterface, 
ServiceLocatorAwareInterface, ObjectManagerAwareInterface
{
	protected $serviceLocator;
	protected $objectManager;
	
	public function __construct()
	{
		parent::__construct('shop-form');
	}
	
	public function init()
	{
		$this->setHydrator(new DoctrineHydrator($this->objectManager, '\Godana\Entity\Shop'))->setObject(new Shop());
    	
    	$this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id'
        ));
        
        $this->add(
            array(
                'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                'name' => 'categories',
                'attributes' => array(
                    'multiple' => 'multiple',
            		'class' => 'category-select gdn_select'
                ),                
                'options' => array(
                    'object_manager' => $this->objectManager,
                    'target_class'   => 'Godana\Entity\Category',
                    'property'       => 'name',
                    'label'          => 'Categories',
                	'label_attributes' => array(
			            'class' => 'sr-only',
			        ),
                    'disable_inarray_validator' => true,
			        'find_method' => array(
			        	'name' => 'findBy',
			        	'params' => array(
			        		'criteria' => array('type' => 1),
			        	),			        	
			        ),            
                ),
            )
        ); 
        
        $this->add(array(
	    	'type'    => 'Zend\Form\Element\Collection',
	        'name'    => 'new-categories',
            'options' => array(
        		'template_placeholder' => '__placeholder__',
        		'should_create_template' => true,
				'allow_add' => true,        
            	'count' => 1,
                'target_element' => array(
        			'type' => 'Godana\Form\CategoryFieldset', 
        		),
			),
			'attributes' => array(
				'class' => 'my-fieldset',
			)			            
	    ));
        
        $this->add(array(
            'name' => 'name',
            'options' => array(
                'label' => 'Name',
        		'label_attributes' => array(
		            'class' => 'sr-only',
		        ),
            ),
            'attributes' => array(
            	'placeholder' => 'Name',
                'type' => 'text',
            	'class' => 'gdn_text',
            ),
        ));
        
        $this->add(array(
            'name' => 'description',
            'options' => array(
                'label' => 'Description',
        		'label_attributes' => array(
		            'class' => 'sr-only',
		        ),
            ),
            'attributes' => array(
            	'placeholder' => 'Description',
                'type' => 'textarea',
            	'class' => 'gdn_text',
            ),
        ));
        
        $this->add(
            array(
                'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                'name' => 'owner',
                'attributes' => array(
            		'class' => 'owner-select gdn_select'
                ),                
                'options' => array(
                    'object_manager' => $this->objectManager,
                    'target_class'   => '\SamUser\Entity\User',
                    'property'       => 'firstname',
                    'label'          => 'Owner',
                	'label_attributes' => array(
			            'class' => 'sr-only',
			        ),               
                ),
            )
        ); 
        
//        $this->add(
//            array(
//                'type' => 'text',
//                'name' => 'idCity',
//                'attributes' => array(
//            		'class' => 'form-control',
//            		'id' => 'id_city',
//                ),                
//                'options' => array(
//                    'label'          => 'City',
//                	'label_attributes' => array(
//			            'class' => 'sr-only',
//			        ),    
//                ),
//            )
//        );
//        
//        $this->add(array(
//            'type' => 'Zend\Form\Element\Hidden',
//            'name' => 'cities',
//        	'attributes' => array(
//        		'id' => 'city'
//        	)
//        ));

        $this->add(array(
	    	'type'    => 'Zend\Form\Element\Collection',
	        'name'    => 'cities',
            'options' => array(
        		'template_placeholder' => '__placeholder__',
        		'should_create_template' => false,
				'allow_add' => false,        
            	'count' => 1,
                'target_element' => array(
        			'type' => 'Godana\Form\CityFieldset', 
        		),
			),
			'attributes' => array(
				'class' => 'my-fieldset',
			)			            
	    ));
        
        $this->add(array(
	    	'type'    => 'Zend\Form\Element\Collection',
	        'name'    => 'contacts',
            'options' => array(
        		'template_placeholder' => '__placeholder__',
        		'should_create_template' => true,
				'allow_add' => true,        
            	'count' => 1,
                'target_element' => array(
        			'type' => 'Godana\Form\ContactFieldset', 
        		),
			),
			'attributes' => array(
				'class' => 'my-fieldset',
			)			            
	    ));
	    
	    $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'deleted'
        ));
	}
	
	public function getInputFilterSpecification() 
	{
		return array(
			'id' => array(
                'required' => false
            ),
            'categories' => array(
            	'required' => false
            ),
            'cities' => array(
            	'required' => false
            ),            
            'name' => array(
            	'required' => true,
            	'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),                
            ),
            'description' => array(
                'required' => false
            ),
            'deleted' => array(
                'required' => false
            ),
    	);
	}
	
	public function setServiceLocator(ServiceLocatorInterface $sl)
    {
        $this->serviceLocator = $sl;
    }

    public function getServiceLocator()
    {
        return $this->serviceLocator;
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
