<?php

// module/StickyNotes/config/module.config.php:
return array(
    'controllers' => array(
        'invokables' => array(
            'Omagua\Controller\Index' => 'Omagua\Controller\IndexController',
        ),
    ),
    'controller_plugins' => array(
        'invokables' => array(
            'Load' => 'Omagua\Plugin\Load',
        )
    ),
    'router' => array(
        'routes' => array(
            'stickynotes' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/omagua[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Omagua\Controller\Index',
                        'action' => 'home',
                    ),
                ),
            ),
            'origen' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/origen',
                    'defaults' => array(
                        'controller' => 'Omagua\Controller\Index',
                        'action' => 'origen',
                    ),
                )
            ),
            'origen' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/origen',
                    'defaults' => array(
                        'controller' => 'Omagua\Controller\Index',
                        'action' => 'origen',
                    ),
                )
            ),
            'productos' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/productos',
                    'defaults' => array(
                        'controller' => 'Omagua\Controller\Index',
                        'action' => 'productos',
                    ),
                )
            ),
            'beneficios' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/beneficios',
                    'defaults' => array(
                        'controller' => 'Omagua\Controller\Index',
                        'action' => 'beneficios',
                    ),
                )
            ),
            'contactos' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/contactenos',
                    'defaults' => array(
                        'controller' => 'Omagua\Controller\Index',
                        'action' => 'contactenos',
                    ),
                )
            ),
            'post' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/post[/:namepost][/:name]', 
                    'defaults' => array(
                        'controller' => 'Omagua\Controller\Index',
                        'action' => 'post',
                    ),
                )
            ),
            'producto' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/producto[/:namepost][/:name]', 
                    'defaults' => array(
                        'controller' => 'Omagua\Controller\Index',
                        'action' => 'producto',
                    ),
                )
            ),
        ),
    ),   
    'view_manager' => array(
        'template_path_stack' => array(
            'omagua' => __DIR__ . '/../view',
        ),
    ),
);
