<?php
return array(
    'doctrine' => array(
        'driver' => array(
            'zfcuser_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
				//'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => __DIR__ . '/xml/zfcuser'
                //'paths' => __DIR__ . '/../../../../module/Godana/src/Godana/Entity'
            ),

            'orm_default' => array(
                'drivers' => array(
                    'ZfcUser\Entity'  => 'zfcuser_entity'
                )
            )
        )
    ),
);
