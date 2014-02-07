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
            'name' => 'email',
            'options' => array(
                'label' => 'Email',
        		'label_attributes' => array(
		            'class' => 'sr-only',
		        ),
            ),
            'attributes' => array(
                'type' => 'text',
                'class' => 'gdn_text',
            	'placeholder' => 'Email'
            ),
        ));
        
        $this->add(array(
            'name' => 'username',
            'options' => array(
                'label' => 'Username',
        		'label_attributes' => array(
		            'class' => 'sr-only',
		        ),
            ),
            'attributes' => array(
                'type' => 'text',
                'class' => 'gdn_text',
            	'placeholder' => 'Username'
            ),
        ));
        
        $this->add(array(
            'name' => 'firstname',
            'options' => array(
                'label' => 'First name',
        		'label_attributes' => array(
		            'class' => 'sr-only',
		        ),
            ),
            'attributes' => array(
                'type' => 'text',
                'class' => 'gdn_text',
            	'placeholder' => 'First name'
            ),
        ));
        
        $this->add(array(
            'name' => 'lastname',
            'options' => array(
                'label' => 'Last name',
        		'label_attributes' => array(
		            'class' => 'sr-only',
		        ),
            ),
            'attributes' => array(
                'type' => 'text',
                'class' => 'gdn_text',
            	'placeholder' => 'Last name'
            ),
        ));
        
        $this->add(array(
            'name' => 'dateofbirth',
            'options' => array(
                'label' => 'Date of birth',
        		'label_attributes' => array(
		            'class' => 'sr-only',
		        ),
            ),
            'attributes' => array(
                'type' => 'text',
                'class' => 'datepicker gdn_text',
            	'placeholder' => 'Date of birth'
            ),
        ));		       
    
        $this->add(array(
            'name' => 'sex',
        	'type' => '\Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Sex',
        		'label_attributes' => array(
		            'class' => 'sr-only',
		        ),
		        'empty_option' => 'Sex',
		        'value_options' => array(
	            	'0' => 'M',
	           	 	'1' => 'F',
			   	),			   	
            ),   
            'attributes' => array(
            	'class' => 'sex-select gdn_select',
            ),        
              
        ));        

        $this->add(array(
            'name' => 'display_name',
            'options' => array(
                'label' => 'Display Name',
        		'class' => 'sr-only',
            ),
            'attributes' => array(
                'type' => 'text',
            	'class' => 'gdn_text',
            	'placeholder' => 'Display Name'
            ),
        ));
        
//        $this->add(array(
//            'name' => 'oldpass',
//            'options' => array(
//                'label' => 'Current password',
//        		'label_attributes' => array(
//		            'class' => 'sr-only',
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
		            'class' => 'sr-only',
		        ),
            ),
            'attributes' => array(
                'type' => 'password',
                'class' => 'gdn_text',
            	'placeholder' => 'Password'
            ),
        ));

        $this->add(array(
            'name' => 'passwordVerify',
            'options' => array(
                'label' => 'Password Verify',
        		'label_attributes' => array(
		            'class' => 'sr-only',
		        ),
            ),
            'attributes' => array(
                'type' => 'password',
                'class' => 'gdn_text',
            	'placeholder' => 'Password Verify'
            ),
        ));

        if ($this->getRegistrationOptions()->getUseRegistrationFormCaptcha()) {
            $this->add(array(
                'name' => 'captcha',
                'type' => 'Zend\Form\Element\Captcha',
                'options' => array(
                    'label' => 'Please type the following text',
            		'label_attributes' => array(
			            'class' => 'sr-only',
			        ),
                    'captcha' => $this->getRegistrationOptions()->getFormCaptchaOptions(),
            		'separator' => 'blabla'
                ),
                'attributes' => array(
	                'class' => 'gdn_text gdn_captcha_text',
	            	'placeholder' => 'Please type the above text'
	            ),
            ));
        }

        $submitElement = new Element\Button('submit');
        $submitElement
            ->setLabel('Submit')
            ->setAttributes(array(
                'type'  => 'submit',
                'class' => 'btn btn-default',
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
}
