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
                        'controller' => 'index',
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
            	'type' => 'Segment',
            	'options' => array(
                	'route' => '/[:lang/]bid/add',
                    'defaults' => array(
                    	'controller' => 'bid',
                        'action'     => 'add',
                  	),
                  	'constraints' => array(
            			'lang' => '(en|de|fr|mg)?',
            		),
              	),
            ),
            'upload-bid' => array(
            	'type' => 'Segment',
            	'options' => array(
                	'route' => '/[:lang/]bid/upload',
                    'defaults' => array(
                    	'controller' => 'bid',
                        'action'     => 'upload',
                  	),
                  	'constraints' => array(
            			'lang' => '(en|de|fr|mg)?',
            		),
              	),
            ),
           	'edit-bid' => array(
            	'type' => 'Segment',
            	'options' => array(
                	'route' => '/[:lang/]bid/edit',
                    'defaults' => array(
                    	'controller' => 'bid',
                        'action'     => 'edit',
                  	),
                  	'constraints' => array(
            			'lang' => '(en|de|fr|mg)?',
            		),
              	),
            ),
            'ajax-bid' => array(
            	'type' => 'Literal',
            	'options' => array(
                	'route' => '/bid/upload/ajax',
                    'defaults' => array(
                    	'controller' => 'bid',
                        'action'     => 'uploadAjax',
                  	),
              	),
            ),
            'city-bid' => array(
            	'type' => 'Segment',
            	'options' => array(
                	'route' => '/[:lang/]bid/city',
                    'defaults' => array(
                    	'controller' => 'bid',
                        'action'     => 'city',
                  	),
                  	'constraints' => array(
            			'lang' => '(en|de|fr|mg)?',
            		),
              	),
            ),            
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
            		'route' => '/[:lang/]shop[/category/:categoryIdent][/page/:page]',
            		'defaults' => array(
            			'controller' => 'shop',
            			'action' => 'list',
            			'lang' => 'mg',
            			'page' => 1
            		),
            		'constraints' => array(
            			'lang' => '(en|de|fr|mg)?',
            			'page' => '[0-9]*',
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
            'detail-product' => array(
            	'type' => 'Segment',
            	'options' => array(
            		'route' => '/[:lang/]shop/:shopIdent/product/:productId',
            		'defaults' => array(
            			'controller' => 'product',
            			'action' => 'detail'
            		),
            		'constraints' => array(
            			'lang' => '(en|de|fr|mg)?',
            			'shopIdent' => '[a-z][a-zA-Z0-9_-]*',
            			'productId' => '[0-9]*'
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
                        'may_terminate' => true,
                		'child_routes' => array(
                        	'role_change' => array(
		                        'type' => 'Segment',
		                        'options' => array(
		                            'route' => '/role/change/:userId',
		                            'defaults' => array(
		                                'controller' => 'myuser',
		                                'action'     => 'changeRole',
		                            ),
		                            'constraints' => array(
				            			'userId' => '[0-9]*'
				            		),
		                        ),
		                    ),
		                    'edit' => array(
		                        'type' => 'Segment',
		                        'options' => array(
		                            'route' => '/edit/:userId',
		                            'defaults' => array(
		                                'controller' => 'myuser',
		                                'action'     => 'editUser',
		                            ),
		                            'constraints' => array(
				            			'userId' => '[0-9]*'
				            		),
		                        ),
		                    ),
		                    'add' => array(
		                        'type' => 'Segment',
		                        'options' => array(
		                            'route' => '/add',
		                            'defaults' => array(
		                                'controller' => 'myuser',
		                                'action'     => 'addUser',
		                            ),
		                        ),
		                    ),
		            	),
                	),
                	'search_init' => array(
	                	'type' => 'literal',
                        'options' => array(
                            'route' => '/search/init',
                            'defaults' => array(
                                'controller' => 'search',
                                'action'     => 'init',
                            ),
                        ),
	            	),
	            	'cooperative' => array(
	            		'type' => 'literal',
	            		'options' => array(
                            'route' => '/cooperative',
                            'defaults' => array(
                                'controller' => 'cooperative',
                                'action'     => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                		'child_routes' => array(
                        	'edit' => array(
		                        'type' => 'Segment',
		                        'options' => array(
		                            'route' => '/edit/:cooperativeId',
		                            'defaults' => array(
		                                'controller' => 'cooperative',
		                                'action'     => 'editCooperative',
		                            ),
		                            'constraints' => array(
		                            	'cooperativeId' => '[0-9]*',
		                            ),
		                        ),
		                    ),
                        	'zone_create' => array(
		                        'type' => 'literal',
		                        'options' => array(
		                            'route' => '/zone/create',
		                            'defaults' => array(
		                                'controller' => 'cooperative',
		                                'action'     => 'createZone',
		                            ),
		                        ),
		                    ),
		                    'line_create' => array(
		                        'type' => 'literal',
		                        'options' => array(
		                            'route' => '/line/create',
		                            'defaults' => array(
		                                'controller' => 'cooperative',
		                                'action'     => 'createLine',
		                            ),
		                        ),
		                    ),
		                    'line_add' => array(
		                        'type' => 'literal',
		                        'options' => array(
		                            'route' => '/line/add',
		                            'defaults' => array(
		                                'controller' => 'cooperative',
		                                'action'     => 'addLine',
		                            ),
		                        ),
		                    ),
		                    'create' => array(
		                        'type' => 'literal',
		                        'options' => array(
		                            'route' => '/create',
		                            'defaults' => array(
		                                'controller' => 'cooperative',
		                                'action'     => 'createCooperative',
		                            ),
		                        ),
		                    ),
		                    'listLine' => array(
		                        'type' => 'literal',
		                        'options' => array(
		                            'route' => '/listLine',
		                            'defaults' => array(
		                                'controller' => 'cooperative',
		                                'action'     => 'listLine',
		                            ),
		                        ),
		                    ),
		                    'car_make_add' => array(
		                        'type' => 'literal',
		                        'options' => array(
		                            'route' => '/car/make/add',
		                            'defaults' => array(
		                                'controller' => 'cooperative',
		                                'action'     => 'addCarMake',
		                            ),
		                        ),
		                    ),
		                    'car_model_add' => array(
		                        'type' => 'literal',
		                        'options' => array(
		                            'route' => '/car/model/add',
		                            'defaults' => array(
		                                'controller' => 'cooperative',
		                                'action'     => 'addCarModel',
		                            ),
		                        ),
		                    ),
		                    'car_driver_add' => array(
		                        'type' => 'literal',
		                        'options' => array(
		                            'route' => '/car/driver/add',
		                            'defaults' => array(
		                                'controller' => 'cooperative',
		                                'action'     => 'addCarDriver',
		                            ),
		                        ),
		                    ),
		                    'car_add' => array(
		                        'type' => 'literal',
		                        'options' => array(
		                            'route' => '/car/add',
		                            'defaults' => array(
		                                'controller' => 'cooperative',
		                                'action'     => 'addCar',
		                            ),
		                        ),
		                    ),
		                    'line_car_add' => array(
		                        'type' => 'literal',
		                        'options' => array(
		                            'route' => '/car/line/add',
		                            'defaults' => array(
		                                'controller' => 'cooperative',
		                                'action'     => 'addCarLine',
		                            ),
		                        ),
		                    ),
		                    'line_car_ajax' => array(
		                        'type' => 'literal',
		                        'options' => array(
		                            'route' => '/car/line/ajax',
		                            'defaults' => array(
		                                'controller' => 'cooperative',
		                                'action'     => 'ajaxCarLine',
		                            ),
		                        ),
		                    ),
		                    'reservation_board_create' => array(
		                        'type' => 'literal',
		                        'options' => array(
		                            'route' => '/car/reservation/add',
		                            'defaults' => array(
		                                'controller' => 'cooperative',
		                                'action'     => 'createReservationBoard',
		                            ),
		                        ),
		                    ),
		                    'reservation_car_ajax' => array(
		                        'type' => 'literal',
		                        'options' => array(
		                            'route' => '/car/reservation/ajax',
		                            'defaults' => array(
		                                'controller' => 'cooperative',
		                                'action'     => 'ajaxCarReservation',
		                            ),
		                        ),
		                    ),
		                    'reservation_create' => array(
		                        'type' => 'literal',
		                        'options' => array(
		                            'route' => '/reservation/add',
		                            'defaults' => array(
		                                'controller' => 'cooperative',
		                                'action'     => 'createReservation',
		                            ),
		                        ),
		                    ),
		                    'reservation_ajax' => array(
		                        'type' => 'literal',
		                        'options' => array(
		                            'route' => '/reservation/ajax',
		                            'defaults' => array(
		                                'controller' => 'cooperative',
		                                'action'     => 'ajaxReservation',
		                            ),
		                        ),
		                    ),
		                    'reservation_car_list' => array(
		                        'type' => 'literal',
		                        'options' => array(
		                            'route' => '/car/reservation',
		                            'defaults' => array(
		                                'controller' => 'cooperative',
		                                'action'     => 'listReservationBoard',
		                            ),
		                        ),
		                    ),
		                    'reservation_car_detail' => array(
		                        'type' => 'Segment',
		                        'options' => array(
		                            'route' => '/reservation/:reservationBoardId',
		                            'defaults' => array(
		                                'controller' => 'cooperative',
		                                'action'     => 'detailReservationBoard',
		                            ),
		                            'constraints' => array(
		                            	'reservationBoardId' => '[0-9]*',
		                            ),
		                        ),
		                    ),
		                    'show_reservation_form' => array(
		                        'type' => 'literal',
		                        'options' => array(
		                            'route' => '/reservation/show/form',
		                            'defaults' => array(
		                                'controller' => 'cooperative',
		                                'action'     => 'showReservationForm',
		                            ),
		                        ),
		                    ),
		                    'validate_post_ajax' => array(
		                        'type' => 'literal',
		                        'options' => array(
		                            'route' => '/reservation/validate/post/ajax',
		                            'defaults' => array(
		                                'controller' => 'cooperative',
		                                'action'     => 'validatePostAjax',
		                            ),
		                        ),
		                    ),
		            	),
	            	),
                    
            	),
            ),
            'search' => array(
            	'type' => 'Segment',
            	'options' => array(
                	'route' => '/[:lang/]search',
                    'defaults' => array(
                    	'controller' => 'search',
                        'action'     => 'index',
                  	),
                  	'constraints' => array(
                  		'lang' => '(en|de|fr|mg)?',
                  	),
              	),
            ),
            'tools' => array(
            	'type' => 'Segment',
            	'options' => array(
                	'route' => '/[:lang/]tools',
                    'defaults' => array(
                    	'controller' => 'tools',
                        'action'     => 'index',
            			'lang' => 'mg'
                  	),
                  	'constraints' => array(
                  		'lang' => '(en|de|fr|mg)?',
                  	),
              	),
              	'may_terminate' => true,
                'child_routes' => array(
                    'transportation_reservation' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/transportation/reservation',
                            'defaults' => array(
                                'controller' => 'cooperative',
                                'action'     => 'userReservation',
                            ),                            
                        ),
                        'may_terminate' => true,
		                'child_routes' => array(
		                    'detail' => array(
		                        'type' => 'Segment',
		                        'options' => array(
		                            'route' => '/detail/:reservationBoardId',
		                            'defaults' => array(
		                                'controller' => 'cooperative',
		                                'action'     => 'detailUserReservation',
		                            ),
		                            'constraints' => array(
		                            	'reservationBoardId' => '[0-9]*',
		                            ),
		                        ),
		            		),
		            	),
            		),
            		'feed' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/feed',
                            'defaults' => array(
                                'controller' => 'feed',
                                'action'     => 'index',
                            ),                            
                        ),
                        'may_terminate' => true,
		                'child_routes' => array(
		                    'add' => array(
		                        'type' => 'literal',
		                        'options' => array(
		                            'route' => '/add',
		                            'defaults' => array(
		                                'controller' => 'feed',
		                                'action'     => 'add',
		                            ),
		                        ),
		            		),
		            		'add_ajax' => array(
		                        'type' => 'literal',
		                        'options' => array(
		                            'route' => '/add/ajax',
		                            'defaults' => array(
		                                'controller' => 'feed',
		                                'action'     => 'addAjax',
		                            ),
		                        ),
		            		),
		            		'ajax_tag' => array(
		                        'type' => 'literal',
		                        'options' => array(
		                            'route' => '/ajax/tag',
		                            'defaults' => array(
		                                'controller' => 'feed',
		                                'action'     => 'ajaxTag',
		                            ),
		                        ),
		            		),
		            		'load_ajax' => array(
		                        'type' => 'literal',
		                        'options' => array(
		                            'route' => '/load/ajax',
		                            'defaults' => array(
		                                'controller' => 'feed',
		                                'action'     => 'loadAjax',
		                            ),
		                        ),
		            		),
		            	),
                	),
            	),            	
            ),
            'crop' => array(
            	'type' => 'Literal',
            	'options' => array(
                	'route' => '/crop',
                    'defaults' => array(
                    	'controller' => 'crop',
                        'action'     => 'index',
                  	),
              	),
            ),
            'user-upload' => array(
            	'type' => 'Literal',
            	'options' => array(
                	'route' => '/user/upload/ajax',
                    'defaults' => array(
                    	'controller' => 'zfcuser',
                        'action'     => 'uploadAjax',
                  	),
              	),
            ),
            'feed-upload' => array(
            	'type' => 'Literal',
            	'options' => array(
                	'route' => '/feed/upload/ajax',
                    'defaults' => array(
                    	'controller' => 'feed',
                        'action'     => 'uploadAjax',
                  	),
              	),
            ),
            'feed-comment' => array(
            	'type' => 'Segment',
            	'options' => array(
                	'route' => '/[:lang/]feed/comment/ajax',
                    'defaults' => array(
                    	'controller' => 'feed',
                        'action'     => 'commentAjax',
                  	),
                  	'constraints' => array(
                  		'lang' => '(en|de|fr|mg)?',
                  	),
              	),
            ),
            'remove-comment' => array(
            	'type' => 'Literal',
            	'options' => array(
                	'route' => '/feed/remove/comment/ajax',
                    'defaults' => array(
                    	'controller' => 'feed',
                        'action'     => 'removeCommentAjax',
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
//            'layout/layout'           => __DIR__ . '/../view/layout/my-layout.phtml',
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
);