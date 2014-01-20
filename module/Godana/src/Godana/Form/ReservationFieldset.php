<?php
namespace Godana\Form;

use Godana\Entity\Reservation;

use Zend\Form\Fieldset;
use Doctrine\Common\Persistence\ObjectManager as ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;

class ReservationFieldset extends Fieldset implements InputFilterProviderInterface, ServiceLocatorAwareInterface, ObjectManagerAwareInterface
{
	
	protected $serviceLocator;
	protected $objectManager;
	
	public function __construct()
	{
		parent::__construct('reservation-form');
	}
	
	public function init()
    {
        $this->setHydrator(new DoctrineHydrator($this->objectManager, '\Godana\Entity\Reservation'))
             ->setObject(new Reservation());
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id'
        ));
        
        $this->add(
        	array(
                'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                'name' => 'zone',
                'attributes' => array(
            		'class' => 'form-control zone-select',
                ),                
                'options' => array(
                    'object_manager' => $this->objectManager,
                    'target_class'   => 'Godana\Entity\Zone',
                    'property'       => 'name',
                    'label'          => 'Zone',
                	'label_attributes' => array(
			            'class' => 'col-sm-3 control-label',
			        ),
                    'disable_inarray_validator' => true               
                ),
        	)
        );

        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'line',
        	'attributes' => array(
        		'class' => 'line-select form-control'
        	),
        	'options' => array(
                'label' => 'Line',
        		'label_attributes' => array(
		            'class' => 'col-sm-3 control-label',
		        ),
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'reservationBoard',
        	'attributes' => array(
        		'class' => 'departure-select form-control'
        	),
        	'options' => array(
                'label' => 'Departure time',
        		'label_attributes' => array(
		            'class' => 'col-sm-3 control-label',
		        ),
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'cooperative',
        	'attributes' => array(
        		'class' => 'cooperative-select form-control'
        	),
        	'options' => array(
                'label' => 'Cooperative',
        		'label_attributes' => array(
		            'class' => 'col-sm-3 control-label',
		        ),
            ),
        ));
        
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'car',
        	'attributes' => array(
        		'class' => 'car-select form-control'
        	),
        	'options' => array(
                'label' => 'Car',
        		'label_attributes' => array(
		            'class' => 'col-sm-3 control-label',
		        ),
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'fare',
        	'attributes' => array(
        		'class' => 'form-control fare-input',
        		'disabled' => 'disabled'
        	),
        	'options' => array(
                'label' => 'Fare',
        		'label_attributes' => array(
		            'class' => 'col-sm-3 control-label',
		        ),
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'seat',
        	'attributes' => array(
        		'class' => 'seat-select form-control'
        	),
        	'options' => array(
                'label' => 'Seat',
        		'label_attributes' => array(
		            'class' => 'col-sm-3 control-label',
		        ),
            ),
        ));
        
	    $this->add(array(
        	'type' => 'Godana\Form\PassengerFieldset',
        	'name' => 'passenger',
        ));
        
        $this->add(array(
            'name' => 'status',
        	'type' => '\Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Status',
        		'label_attributes' => array(
		            'class' => 'col-sm-3 control-label',
		        ),
		        'value_options' => array(
	            	'0' => 'Advance',
	           	 	'1' => 'Paid',
		        	'2' => 'PA',
			   	),			   	
            ),   
            'attributes' => array(
            	'class' => 'chosen-select form-control',
            ),        
              
        ));
        
        $this->add(array(
            'name'    => 'payment',
            'options' => array(
                'label' => 'Payment',
        		'label_attributes' => array(
		            'class' => 'col-sm-3 control-label',
		        ),
            ),
            'attributes' => array(
                'type' => 'text',
            	'class' => 'form-control',
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'created',
        ));
        
        
    }
	
	public function getInputFilterSpecification()
    {
        return array(
        	'id' => array(
                'required' => false
            ),
            'seat' => array(
                'required' => true,
            ),
            
            'payment' => array(
                'required' => true,
            	'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ), 
                'validators' => array(
                    new \Zend\Validator\Digits(),
                ),               
            ),
            'created' => array(
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