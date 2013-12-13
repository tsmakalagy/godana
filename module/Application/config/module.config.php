<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'segment',
                'options' => array(
                    'route'    => '/[:lang[/]]',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                    'constraints' => array(
                    	'lang' => '(en|de|fr|mg)?',
                    ),                    
                ),                                             
            ),
            
            'zfcuser' => array(
            	'type' => 'Segment',
                'options' => array(
                	'route' => '/[:lang/]user',
                   	'defaults' => array(
                    	'controller' => 'zfcuser',
                    	'action' => 'index',
            			'lang' => 'mg',
                	),
                	'constraints' => array(
                    	'lang' => '(en|de|fr|mg)?',
                    ),  
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'login' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/login',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action'     => 'login',
                            ),
                        ),
                    ),
                    'authenticate' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/authenticate',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action'     => 'authenticate',
                            ),
                        ),
                    ),
                    'logout' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/logout',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action'     => 'logout',
                            ),
                        ),
                    ),
                    'register' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/register',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action'     => 'register',
                            ),
                        ),
                    ),
                    'changepassword' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/change-password',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action'     => 'changepassword',
                            ),
                        ),                        
                    ),
                    'changeemail' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/change-email',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action' => 'changeemail',
                            ),
                        ),                        
                    ),
                    'profile' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/profile',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action' => 'profile',
                            ),
                        ),                        
                    ),
            	),
            ),
            
            'bid' => array(
            	'type' => 'Segment',
            	'options' => array(
            		'route' => '/[:lang/]bid[[/type/:type[/category/:categoryIdent]]/page/:page]',
            		'defaults' => array(
            			'controller' => 'bid',
            			'action' => 'index',
            			'lang' => 'mg',
            			'page' => 1,
            		),
            		'constraints' => array(
            			'lang' => '(en|de|fr|mg)?',
            			'page' => '[0-9]*',
            			'type' => '(offer|demand)?',
            			'categoryIdent' => '[a-z][a-zA-Z0-9_-]*',
            		),
            	),
            ),
            
            'add-bid' => array(
            	'type' => 'literal',
            	'options' => array(
                	'route' => '/bid/add',
                    'defaults' => array(
                    	'controller' => 'bid',
                        'action'     => 'add',
                  	),
              	),
            ),
            'upload-bid' => array(
            	'type' => 'literal',
            	'options' => array(
                	'route' => '/bid/upload',
                    'defaults' => array(
                    	'controller' => 'bid',
                        'action'     => 'upload',
                  	),
              	),
            ),
           	'edit-bid' => array(
            	'type' => 'literal',
            	'options' => array(
                	'route' => '/bid/edit',
                    'defaults' => array(
                    	'controller' => 'bid',
                        'action'     => 'edit',
                  	),
              	),
            ),
            'ajax-bid' => array(
            	'type' => 'literal',
            	'options' => array(
                	'route' => '/bid/ajax',
                    'defaults' => array(
                    	'controller' => 'bid',
                        'action'     => 'ajax',
                  	),
              	),
            ),
            'city-bid' => array(
            	'type' => 'literal',
            	'options' => array(
                	'route' => '/bid/city',
                    'defaults' => array(
                    	'controller' => 'bid',
                        'action'     => 'city',
                  	),
              	),
            ),
            
//            'bid' => array(
//            	'type' => 'Segment',
//            	'options' => array(
//            		'route' => '/[:lang/]bid[/page/:page]',
//            		'defaults' => array(
//            			'controller' => 'bid',
//            			'action' => 'index',
//            			'lang' => 'mg',
//            			'page' => 1,
//            		),
//            		'constraints' => array(
//            			'lang' => '(en|de|fr|mg)?',
//            			'page' => '[0-9]*',
//            		),
//            	),
//            	'may_terminate' => true,
//                'child_routes' => array(
//                    'add' => array(
//                        'type' => 'literal',
//                        'options' => array(
//                            'route' => '/add',
//                            'defaults' => array(
//                                'controller' => 'bid',
//                                'action'     => 'add',
//                            ),
//                        ),
//                    ),
//                    'upload' => array(
//                        'type' => 'literal',
//                        'options' => array(
//                            'route' => '/upload',
//                            'defaults' => array(
//                                'controller' => 'bid',
//                                'action'     => 'upload',
//                            ),
//                        ),
//                    ),
//                    'media' => array(
//                        'type' => 'literal',
//                        'options' => array(
//                            'route' => '/media',
//                            'defaults' => array(
//                                'controller' => 'bid',
//                                'action'     => 'media',
//                            ),
//                        ),
//                    ),
//                    'ajax' => array(
//                        'type' => 'literal',
//                        'options' => array(
//                            'route' => '/ajax',
//                            'defaults' => array(
//                                'controller' => 'bid',
//                                'action'     => 'ajax',
//                            ),
//                        ),
//                    ),
//                    'city' => array(
//                        'type' => 'literal',
//                        'options' => array(
//                            'route' => '/city',
//                            'defaults' => array(
//                                'controller' => 'bid',
//                                'action'     => 'city',
//                            ),
//                        ),
//                    ),
//                    'edit' => array(
//                        'type' => 'literal',
//                        'options' => array(
//                            'route' => '/edit',
//                            'defaults' => array(
//                                'controller' => 'bid',
//                                'action'     => 'edit',
//                            ),
//                        ),
//                    ),
//                ),            	
//            ),
            'detail-bid' => array(
            	'type' => 'Segment',
            	'options' => array(
            		'route' => '/[:lang/]bid/:type/:postIdent',
            		'defaults' => array(
            			'controller' => 'bid',
            			'action' => 'detail',
            			'lang' => 'mg',
            			'type' => 'offer',
            		),
            		'constraints' => array(
            			'lang' => '(en|de|fr|mg)?',
            			'type' => '(offer|demand)?',
            			'postIdent' => '[a-z][a-zA-Z0-9_-]*',
            		),
            	),
            ),
            'type-bid' => array(
            	'type' => 'Segment',
            	'options' => array(
            		'route' => '/[:lang/]bid/type/:type',
            		'defaults' => array(
            			'controller' => 'bid',
            			'action' => 'index',
            			'lang' => 'mg',
            			'type' => 'offer',
            		),
            		'constraints' => array(
            			'lang' => '(en|de|fr|mg)?',
            			'type' => '(offer|demand)?',
            		),
            	),
            ),
            'category-bid' => array(
            	'type' => 'Segment',
            	'options' => array(
            		'route' => '/[:lang/]bid/:type/category/:categoryIdent',
            		'defaults' => array(
            			'controller' => 'bid',
            			'action' => 'index',
            			'lang' => 'mg',
            			'type' => 'offer',
            		),
            		'constraints' => array(
            			'lang' => '(en|de|fr|mg)?',
            			'type' => '(offer|demand)?',
            			'categoryIdent' => '[a-z][a-zA-Z0-9_-]*',
            		),
            	),
            ),
            'shop' => array(
            	'type' => 'Segment',
            	'options' => array(
            		'route' => '/[:lang/]shop[/category/:categoryIdent]',
            		'defaults' => array(
            			'controller' => 'shop',
            			'action' => 'list',
            			'lang' => 'mg',
            		),
            		'constraints' => array(
            			'lang' => '(en|de|fr|mg)?',
            			'categoryIdent' => '[a-z][a-zA-Z0-9_-]*'
            		),
            	),
            ),
            'detail-shop' => array(
            	'type' => 'Segment',
            	'options' => array(
            		'route' => '/[:lang/]shop/:shopIdent',
            		'defaults' => array(
            			'controller' => 'shop',
            			'action' => 'detail',
            			'lang' => 'mg',
            		),
            		'constraints' => array(
            			'lang' => '(en|de|fr|mg)?',
            			'shopIdent' => '[a-z][a-zA-Z0-9_-]*'
            		),
            	),
            ),
            'admin' => array(
            	'type' => 'Segment',
            	'options' => array(
                	'route' => '/[:lang/]admin',
                    'defaults' => array(
                    	'controller' => 'admin',
                        'action'     => 'index',
                    	'lang' => 'mg',
            		),
            		'constraints' => array(
            			'lang' => '(en|de|fr|mg)?',
            		),
            	),
            	'may_terminate' => true,
                'child_routes' => array(
                    'shop_admin' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/shop',
                            'defaults' => array(
                                'controller' => 'shop',
                                'action'     => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                		'child_routes' => array(
                        	'shop_add' => array(
		                        'type' => 'literal',
		                        'options' => array(
		                            'route' => '/add',
		                            'defaults' => array(
		                                'controller' => 'shop',
		                                'action'     => 'add',
		                            ),
		                        ),
		                    ),
		                    'shop_edit' => array(
		                        'type' => 'segment',
		                        'options' => array(
		                            'route' => '/edit/:id',
		                            'defaults' => array(
		                                'controller' => 'shop',
		                                'action'     => 'edit',
		                            ),
		                            'constraints' => array(
		                            	'id' => '[0-9]*',
		                            ),
		                        ),
		                    ),
		                    'shop_delete' => array(
		                        'type' => 'segment',
		                        'options' => array(
		                            'route' => '/delete/:id',
		                            'defaults' => array(
		                                'controller' => 'shop',
		                                'action'     => 'delete',
		                            ),
		                            'constraints' => array(
		                            	'id' => '[0-9]*',
		                            ),
		                        ),
		                    ),
		                    'city' => array(
		                        'type' => 'literal',
		                        'options' => array(
		                            'route' => '/city',
		                            'defaults' => array(
		                                'controller' => 'shop',
		                                'action'     => 'city',
		                            ),
		                        ),
		                    ),
		                    'product_type_add' => array(
		                        'type' => 'literal',
		                        'options' => array(
		                            'route' => '/type',
		                            'defaults' => array(
		                                'controller' => 'shop',
		                                'action'     => 'producttype',
		                            ),
		                        ),
		                    ),
		            	),
                    ),
                    'product' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/product',
                            'defaults' => array(
                                'controller' => 'product',
                                'action'     => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                		'child_routes' => array(
                        	'type_add' => array(
		                        'type' => 'literal',
		                        'options' => array(
		                            'route' => '/type',
		                            'defaults' => array(
		                                'controller' => 'product',
		                                'action'     => 'type',
		                            ),
		                        ),
		                    ),
		                    'add' => array(
		                        'type' => 'literal',
		                        'options' => array(
		                            'route' => '/add',
		                            'defaults' => array(
		                                'controller' => 'product',
		                                'action'     => 'add',
		                            ),
		                        ),
		                    ),
		                    'list_attribute' => array(
		                        'type' => 'literal',
		                        'options' => array(
		                            'route' => '/list-attribute',
		                            'defaults' => array(
		                                'controller' => 'product',
		                                'action'     => 'listAttribute',
		                            ),
		                        ),
		                    ),
		                    'ajax' => array(
		                        'type' => 'literal',
		                        'options' => array(
		                            'route' => '/ajax',
		                            'defaults' => array(
		                                'controller' => 'product',
		                                'action'     => 'ajax',
		                            ),
		                        ),
		                    ),
		        		),
		        	),
		        	'user' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/user',
                            'defaults' => array(
                                'controller' => 'myuser',
                                'action'     => 'list',
                            ),
                        ),
                	),
                    
            	),
            ),
            
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/application',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController'
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/my-layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
    /*'doctrine' => array(
		'driver' => array(
			'application_entities' => array(
		    	'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
		      	'cache' => 'array',
		      	'paths' => array(__DIR__ . '/../src/Application/Entity')
	    	),		
		    'orm_default' => array(
		      	'drivers' => array(
		        	'Application\Entity' => 'application_entities'
		      	)
			)
		)
	),*/
);