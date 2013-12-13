<?php
namespace Godana\Form;

use Zend\Form\Form as Form;
use ZfcBase\Form\ProvidesEventsForm;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Doctrine\Common\Persistence\ObjectManager;

class Base extends ProvidesEventsForm
{	
	public function __construct($name = null)
	{
		parent::__construct();
		
		$this->add(array(
            'name' => 'categories',
        	'type' => '\Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Category',
        		'label_attributes' => array(
		            'class' => 'control-label',
		        ),
		        'value_options' => array(
	            	'0' => 'M',
	           	 	'1' => 'F',
		        	'2' => 'K',
		        	'3' => 'Z',
		        	'4' => 'U',
		        	'5'	=> 'T',
			   	),			   	
            ),
            'attributes' => array(
            	'multiple' => 'multiple'
            )         
              
        ));
        
		$this->add(array(
            'name' => 'title',
            'options' => array(
                'label' => 'Title',
        		'label_attributes' => array(
		            'class' => 'control-label',
		        ),
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));
        
        $this->add(array(
            'name' => 'content',
            'options' => array(
                'label' => 'Content',
        		'label_attributes' => array(
		            'class' => 'control-label',
		        ),
            ),
            'attributes' => array(
                'type' => 'textarea'
            ),
        ));
        
        $this->add(array(
            'name' => 'price',
            'options' => array(
                'label' => 'Price',
        		'label_attributes' => array(
		            'class' => 'control-label',
		        ),
            ),
            'attributes' => array(
                'type' => 'number'
            ),
        ));
        
        $this->add(array(
            'name' => 'mobile-phone',
            'options' => array(
                'label' => 'Mobile Phone',
        		'label_attributes' => array(
		            'class' => 'control-label',
		        ),
            ),
            'attributes' => array(
                'type' => 'tel',
            	'pattern' => '^03[2-4][-. ]?[0-9]{2}[-. ]?[0-9]{3}[-. ]?[0-9]{2}$'
            ),
        ));
        
        $this->add(array(
            'name' => 'email',
            'options' => array(
                'label' => 'Email',
        		'label_attributes' => array(
		            'class' => 'control-label',
		        ),
            ),
            'attributes' => array(
                'type' => 'email',
            	'autocomplete' => 'off'
            ),
        ));
        
        $submitElement = new \Zend\Form\Element\Button('submit');
        $submitElement
            ->setLabel('Submit')
            ->setAttributes(array(
                'type'  => 'submit'
            ));

        $this->add($submitElement, array(
            'priority' => -100,
       ));
	}	
	
}