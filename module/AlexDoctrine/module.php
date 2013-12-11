<?php

namespace AlexDoctrine;

use AlexDoctrine\Model\AlexDoctrineTable;
use AlexDoctrine\Form\Fieldset;
use AlexDoctrine\Form\Fieldset\Calls;
// Doctrine Annotations
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder as DoctrineAnnotationBuilder;
use DoctrineModule\Validator\ObjectExists;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;

//FOR HTTP AUTH
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\EventManager\EventInterface;
use Zend\Mvc\MvcEvent;
use Zend\Http\Request as HttpRequest;
use Zend\Http\Response as HttpResponse;

use Zend\Debug\Debug;


class Module implements ConfigProviderInterface, BootstrapListenerInterface
{

    protected $denyAccesslist = array('');
     //fot HTTP AUTH
    public function onBootstrap(EventInterface $event)
    {
        /* @var $application \Zend\Mvc\ApplicationInterface */
        $application    = $event->getTarget();
        $serviceManager = $application->getServiceManager();

        $denyAccesslist = $this->denyAccesslist;

        // delaying instantiation of everything to the latest possible moment
        $application
            ->getEventManager()
            ->attach(MvcEvent::EVENT_DISPATCH,
                    function (MvcEvent $event) use ($denyAccesslist,  $serviceManager) {
                      // $match = $event->getRouteMatch();


                        $request  = $event->getRequest();
                        $response = $event->getResponse();



                        if ( ! ( $request instanceof HttpRequest && $response instanceof HttpResponse) )
                        {
                            return; // we're not in HTTP context - CLI application?
                        }

                        /* @var $authAdapter \Zend\Authentication\Adapter\Http */
                        $authAdapter = $serviceManager->get('AlexDoctrine\AuthenticationAdapter');

                        $authAdapter->setRequest($request);
                        $authAdapter->setResponse($response);
//                echo "<pre>";
//                print_r($request->getHeaders());
//                echo "</pre>";
//                die;
//                        echo "<pre>";
//                        print_r(get_class_methods($request));
//                        echo "</pre>";
//                        die;
//                        echo "<pre>";
//                        print_r($authAdapter);
//                        echo "</pre>";
//                   echo "<pre>";
//                   print_r($response);
//                   echo "</pre>";
//                   die;
//if ($request->getHeader('WWW-Authorization'))
//{
//    Debug::dump($authAdapter->authenticate());
//    exit;
//}


                        $result = $authAdapter->authenticate();



                        if ($result->isValid()) {

                            return; // everything OK
                        } else {

                        }

                        $response->setContent('Access denied  HAHAHA');
                        $response->setStatusCode(HttpResponse::STATUS_CODE_401);

                        $event->setResult($response); // short-circuit to application end

                        return false; // stop event propagation
                }

        );
    }


	//этот метод вызывается modulemanagerom автоматически
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getFormElementConfig()
    {
        return array(
            'factories' => array(
                'customersForm' => function($sm) {
                    $entityManager = $sm->getServiceLocator()->get('emService')->getEntityManager();
                    $builder = new DoctrineAnnotationBuilder($entityManager);
                    $form = $builder->createForm( 'AlexDoctrine\Entity\Customers' );

                    // add fieldset to the main form
                    $fieldset   = $sm->get('AlexDoctrine\Form\Fieldset\Customers');
                    $form->add( $fieldset );

                    $form->setHydrator(new DoctrineHydrator($entityManager,'AlexDoctrine\Entity\Customers', false));
                    return $form;
                },
                'callsForm' => function($sm) {
                    $entityManager = $sm->getServiceLocator()->get('emService')->getEntityManager();
                    $builder = new DoctrineAnnotationBuilder($entityManager);   //DoctrineORMModule\Form\Annotation\AnnotationBuilder
                    $form = $builder->createForm( 'AlexDoctrine\Entity\Calls' );

                    // add new validation i cannot do it in entity because i cannot set  object_repository
                    $firstNameInput = $form->getInputFilter()->get('customers');
                    $noObjectExistsValidator = new ObjectExists(array(
                        'object_repository' => $entityManager->getRepository('AlexDoctrine\Entity\Customers'),
                        'fields'            => 'id'
                    ));
                    $firstNameInput->getValidatorChain()->attach($noObjectExistsValidator);
                    //end added validation

                    $customersOptions = $form->get('customers')->getOptions();
                    $customersOptions['object_manager']   = $entityManager;
                    $form->get('customers')->setOptions($customersOptions);

                    // add fieldset to the main form
                    $fieldset   = $sm->get('AlexDoctrine\Form\Fieldset\Calls');
                    $form->add( $fieldset );

                    $form->setHydrator(new DoctrineHydrator($entityManager,'AlexDoctrine\Entity\Calls', false));
                    return $form;
                },

            ),

        );
    }




}