<?php

namespace AlexDoctrine\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
//my own
use AlexDoctrine\Form\AlexDoctrineForm;
use AlexDoctrine\Entity\Calls;

use Zend\Stdlib\Hydrator\Reflection as ReflectionHydrator;

use DoctrineModule\Validator\NoObjectExists as NoObjectExistsValidator;
// for the form
use Zend\Form\Element;
use Zend\Json\Json;

class CallsController extends AbstractActionController
{

    protected $emService;


 /**
     *  the main method which allow to see form and calls list under the form
     * @return view object with form and calls
     *
     */
    public function indexAction()
    {
        $formManager = $this->serviceLocator->get('FormElementManager');
        $form = $formManager->get('callsform');

        $calls = $this->emService->getEntityManager()->getRepository('AlexDoctrine\Entity\Calls')->findAll();
        //prepare array for pushing filtering data
        $result = [];
        foreach($calls as $call) {
            // make array from entity object
                $hydrator = new ReflectionHydrator();
				$callArray  = $hydrator->extract($call);
                $customerFirstName = $callArray['customers']->getFirstName();
                // delete all data customer from array
                unset($callArray['customers']);
                $callArray['customerFirstName'] = $customerFirstName;
                // push array to finaly array
                $result[] = $callArray;

        }

		return new ViewModel(array(
            'allCallsJson' => json_encode($result),
            'form' => $form)
        );

    }
    /**
     *  ajax request to add new call to db
     * @return json string
     */
    public function addAction()
    {
        // first check if it is ajax
        if (!$this->getRequest()->isXmlHttpRequest()) {
                return array();
        }

        $formManager = $this->serviceLocator->get('FormElementManager');
        $form = $formManager->get('callsform');


        $call = new Calls();
        $entityManager = $this->emService->getEntityManager();

		$form->bind($call);

		$request = $this->getRequest();
        $response = $this->getResponse();

        if ($request->isPost()) {
			 $form->setData($request->getPost());

			 if ($form->isValid()) {
                 // insert into db
				$entityManager->persist($call);
                $entityManager->flush();


                // make array from entity
				$hydrator = new ReflectionHydrator();
				$callsArray  = $hydrator->extract($call);
                $customerFirstName = $callsArray['customers']->getFirstName();
                unset($callsArray['customers']);
                $callsArray['customerFirstName'] = $customerFirstName;

               // unset($callsArray['calls']);
                // response json
                $response->setContent(Json::encode(array('response' => $callsArray,'error'=>'')));
            } else {
             // if we have server not valid data
                $response->setContent(Json::encode(array('response' => '','error'=>$form->getMessages())));
            }
            return $response;
		}
    }
    /**
     *  ajax request to update  existing  call into db
     * @return json string
     */
    public function editAction()
    {

           // first check if it is ajax
        if (!$this->getRequest()->isXmlHttpRequest()) {
                return array();
        }

        $response = $this->getResponse();

        $id = (int) $this->getEvent()->getRouteMatch()->getParam('id');
        if ( ! $id )
        {
            $response->setContent(Json::encode(array('response' => '','error'=>'not valid id')));
        }

        $entityManager = $this->emService->getEntityManager();
        //get call using id
        $call= $entityManager->find('AlexDoctrine\Entity\Calls', $id);
        if ( ! $call ) {
            $response->setContent(Json::encode(array('response' => '','error'=>'coudnot find call with id = '.$id)));
            return $response;
        }

         //get form
        $formManager = $this->serviceLocator->get('FormElementManager');
        $form = $formManager->get('callsForm');
        $form->setBindOnValidate(false);
        $form->bind($call);

        $request = $this->getRequest();
        if ($request->isPost())
        {
            $form->setData($request->getPost());
            if ( $form->isValid() )
            {
                $form->bindValues();
                $entityManager->flush();

                 // make array from entity
				$hydrator = new ReflectionHydrator();
				$callArray  = $hydrator->extract($call);
                $callArray['customerFirstName'] = $callArray['customers']->getFirstName();
                unset($callArray['customers']);  
                $response->setContent(Json::encode(array('response' => $callArray,'error'=>'')));
            }
            else
            {
                // if we have server not valid data
                $response->setContent(Json::encode(array('response' => '','error'=>$form->getMessages())));
            }
            return $response;
        }
    }
   /**
     *  ajax request to delete   call from db
     * @return json string
     */
    public function deleteAction()
    {
        if (!$this->getRequest()->isXmlHttpRequest()) {
                return array();
        }

        $response = $this->getResponse();

        $id = (int) $this->getEvent()->getRouteMatch()->getParam('id');

        if ( ! $id )
        {
                $response->setContent(Json::encode(array('response' => '','error'=>'empty id value')));
                return $response;
        }

        $request = $this->getRequest();

        $entityManager = $this->emService->getEntityManager();
        $call= $entityManager->find('AlexDoctrine\Entity\Calls', $id);

        if ( $call )
        {
            $entityManager->remove($call);
            $entityManager->flush();

            $response->setContent(Json::encode(array('response' => true,'error'=>'')));
           }
        else
        {
            $response->setContent(Json::encode(array('response' => '','error'=>'not found call')));
        }
        return $response;

    }



    public function setEMService($service)
    {
		$this->emService = $service;
    }


}
