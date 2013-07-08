<?php

// module/Contact/config/module.config.php:
return array(
			'controllers' => array(
			'invokables' => array(
				'Contact\Controller\Contact' => 'Contact\Controller\ContactController',
				),
			),
			// The following section is new and should be added to your file
			'router' => array(
					'routes' => array(
						'contact' => array(
							'type' => 'segment',
							'options' => array(
								'route' => '/contact[/:action]',
								'constraints' => array(
									'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
								),
								'defaults' => array(
								'controller' => 'Contact\Controller\Contact',
								'action' => 'index',
								),
							),
						),
					),
			),
			'view_manager' => array(
			'template_path_stack' => array(
				'contact' => __DIR__ . '/../view',
				),
			),
);