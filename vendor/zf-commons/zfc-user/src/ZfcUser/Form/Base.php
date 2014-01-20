<?php

namespace ZfcUser\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use ZfcBase\Form\ProvidesEventsForm;

class Base extends ProvidesEventsForm
{
    public function __construct()
    {
        parent::__construct();

        $this->add(array(
            'name' => 'username',
            'options' => array(
                'label' => 'Username',
        		'label_attributes' => array(
		            'class' => 'col-sm-4 control-label',
		        ),
            ),
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
            ),
        ));
        
        $this->add(array(
            'name' => 'firstname',
            'options' => array(
                'label' => 'First name',
        		'label_attributes' => array(
		            'class' => 'col-sm-4 control-label',
		        ),
            ),
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
            ),
        ));
        
        $this->add(array(
            'name' => 'lastname',
            'options' => array(
                'label' => 'Last name',
        		'label_attributes' => array(
		            'class' => 'col-sm-4 control-label',
		        ),
            ),
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
            ),
        ));
        
        $this->add(array(
            'name' => 'dateofbirth',
            'options' => array(
                'label' => 'Date of birth',
        		'label_attributes' => array(
		            'class' => 'col-sm-4 control-label',
		        ),
            ),
            'attributes' => array(
                'type' => 'text',
                'class' => 'datepicker form-control',
            ),
        ));		       
    
        $this->add(array(
            'name' => 'sex',
        	'type' => '\Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Sex',
        		'label_attributes' => array(
		            'class' => 'col-sm-4 control-label',
		        ),
		        'value_options' => array(
	            	'0' => 'M',
	           	 	'1' => 'F',
			   	),			   	
            ),   
            'attributes' => array(
            	'class' => 'chosen-select form-control',
            ),        
              
        ));

        $this->add(array(
            'name' => 'email',
            'options' => array(
                'label' => 'Email',
        		'label_attributes' => array(
		            'class' => 'col-sm-4 control-label',
		        ),
            ),
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
            ),
        ));

        $this->add(array(
            'name' => 'display_name',
            'options' => array(
                'label' => 'Display Name',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));
        
//        $this->add(array(
//            'name' => 'oldpass',
//            'options' => array(
//                'label' => 'Current password',
//        		'label_attributes' => array(
//		            'class' => 'col-sm-4 control-label',
//		        ),
//            ),
//            'attributes' => array(
//                'type' => 'password',
//                'class' => 'form-control',
//            ),
//        ));

        $this->add(array(
            'name' => 'password',
            'options' => array(
                'label' => 'Password',
        		'label_attributes' => array(
		            'class' => 'col-sm-4 control-label',
		        ),
            ),
            'attributes' => array(
                'type' => 'password',
                'class' => 'form-control',
            ),
        ));

        $this->add(array(
            'name' => 'passwordVerify',
            'options' => array(
                'label' => 'Password Verify',
        		'label_attributes' => array(
		            'class' => 'col-sm-4 control-label',
		        ),
            ),
            'attributes' => array(
                'type' => 'password',
                'class' => 'form-control',
            ),
        ));

        if ($this->getRegistrationOptions()->getUseRegistrationFormCaptcha()) {
            $this->add(array(
                'name' => 'captcha',
                'type' => 'Zend\Form\Element\Captcha',
                'options' => array(
                    'label' => 'Please type the following text',
                    'captcha' => $this->getRegistrationOptions()->getFormCaptchaOptions(),
                ),
            ));
        }

        $submitElement = new Element\Button('submit');
        $submitElement
            ->setLabel('Submit')
            ->setAttributes(array(
                'type'  => 'submit',
                'class' => 'btn btn-primary',
            ));

        $this->add($submitElement, array(
            'priority' => -100,
        ));

        $this->add(array(
            'name' => 'userId',
            'type' => 'Zend\Form\Element\Hidden',
            'attributes' => array(
                'type' => 'hidden'
            ),
        ));

        // @TODO: Fix this... getValidator() is a protected method.
        //$csrf = new Element\Csrf('csrf');
        //$csrf->getValidator()->setTimeout($this->getRegistrationOptions()->getUserFormTimeout());
        //$this->add($csrf);
    }

	public function highlightErrorElements()
    {
    	//var_dump($this->getElements());
        foreach($this->getElements() as $element) {
            if($element->getMessages()) {
                $element->setAttribute('class', 'error');
            }
        }
    }
}
