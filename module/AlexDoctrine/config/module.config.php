<?php
namespace AlexDoctrine;

use AlexDoctrine\Controller\CustomersController;
use AlexDoctrine\Controller\CallsController;
use AlexDoctrine\Controller\CustomersAndCallsController;

return array(
    'controllers' => array(
        'factories' => array(
            'AlexDoctrine\Controller\Customers' => function($serviceLocator)
            {
                $ctr = new CustomersController();
                $ctr->setEMService(
                    $serviceLocator->getServiceLocator()->get('emservice')
                );
                return $ctr;
            },
            'AlexDoctrine\Controller\Calls' => function($serviceLocator)
            {
                $ctr = new CallsController();
                $ctr->setEMService(
                    $serviceLocator->getServiceLocator()->get('emservice')
                );
                return $ctr;
            },
            'AlexDoctrine\Controller\CustomersAndCalls' => function($serviceLocator)
            {
                $ctr = new CustomersAndCallsController();
                $ctr->setEMService(
                    $serviceLocator->getServiceLocator()->get('emservice')
                );
                return $ctr;
            }
        )
    ),

    'router' => array(
        'routes' => array(
            'AlexDoctrine-1' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/customers[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'AlexDoctrine\Controller\Customers',
                        'action'     => 'index',
                    ),
                ),

            ),
            'AlexDoctrine-2' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/calls[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'AlexDoctrine\Controller\Calls',
                        'action'     => 'index',
                    ),
                ),
            ),
            'AlexDoctrine-3' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/all[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'AlexDoctrine\Controller\CustomersAndCalls',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'alexdoctrine' => __DIR__ . '/../view',
        ),
    ),
        // Doctrine config
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        )
    ),
    'service_manager' => array(
        'factories' => array(
            'emservice' => function ($sl) {
                $entityManager = $sl->get('Doctrine\ORM\EntityManager');
                $myService = new Service\EMService();
                $myService->setEntityManager($entityManager);
                return $myService;
            },
            'AlexDoctrine\AuthenticationAdapter'
                    => 'AlexDoctrine\Service\AuthenticationAdapterFactory',
        ),
    ),
    'alex_doctrine_http_auth' => array(
        'auth_adapter' => array(
            'config' => array(
                'accept_schemes' => 'basic digest', //   - this is for coding user and password
                'realm'          => 'alexdoctrine',
                'digest_domains' => '/AlexDoctrine-1 /AlexDoctrine-2 /AlexDoctrine-3',
                'nonce_timeout'  => 3600,
            ),
            'basic_passwd_file'  => __DIR__ . '\passwords/basic_password.txt',
            'digest_passwd_file'  => __DIR__ . '\passwords/digest_password.txt',
        ),
    )

);

