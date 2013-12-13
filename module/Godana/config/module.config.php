<?php
namespace Godana;
return array(
	'doctrine' => array(
        'driver' => array(            
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity',
            ),

            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver',
                ),
            ),
        ),
    ),    
	
	'controllers' => array(
		'invokables' => array(
			'Godana\Controller\Index'
				=> 'Godana\Controller\IndexController',
			'bid' => __NAMESPACE__ . '\Controller\BidController',
			'admin' => __NAMESPACE__ . '\Controller\AdminController',
			'shop' => __NAMESPACE__ . '\Controller\ShopController',
			'product' => __NAMESPACE__ . '\Controller\ProductController',
			'myuser' => __NAMESPACE__ . '\Controller\MyUserController',
		),
	),
	'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'godana/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'godana/index/index' => __DIR__ . '/../view/godana/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'translator' => array(
        'locale' => 'fr_FR',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    
);