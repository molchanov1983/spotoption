<?php

namespace AlexDoctrine\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
//my own
use AlexDoctrine\Form\AlexDoctrineForm;
use AlexDoctrine\Entity\Customers;

use Zend\Stdlib\Hydrator\Reflection as ReflectionHydrator;

// for the form
use Zend\Form\Element;
use Zend\Json\Json;


class CustomersController extends AbstractActionController
{

    protected $emService;

    /**
     *  the main method which allow to see form and customer list under the form
     * @return view object with form and customers
     *
     */
    public function indexAction()
    {
        $formManager = $this->serviceLocator->get('FormElementManager');
        $form = $formManager->get('customersForm');

        $cutomersArr = $this->emService->getEntityManager()->getRepository('AlexDoctrine\Entity\Customers')->findAllToArray();

		return new ViewModel(array(
             'allCustomersJson' => json_encode($cutomersArr),
            'form' => $form)
        );

    }
    /**
     *  ajax request to add new customer to db
     * @return json string
     */
    public function addAction()
    {
        // first check if it is ajax
        if (!$this->getRequest()->isXmlHttpRequest()) {
                return array();
        }

        $formManager = $this->serviceLocator->get('FormElementManager');
        $form = $formManager->get('customersForm');

        $customer = new Customers();
        $entityManager = $this->emService->getEntityManager();

		$form->bind($customer);

		$request = $this->getRequest();
        $response = $this->getResponse();

        if ($request->isPost()) {
			 $form->setData($request->getPost());

			 if ($form->isValid()) {
                 // insert into db
				$entityManager->persist($customer);
				$entityManager->flush();
                // make array from entity
				$hydrator = new ReflectionHydrator();
				$customerArray  = $hydrator->extract($customer);
                unset($customerArray['calls']);
                // response json
                $response->setContent(Json::encode(array('response' => $customerArray,'error'=>'')));
            } else {
             // if we have server not valid data
                $response->setContent(Json::encode(array('response' => '','error'=>$form->getMessages())));
            }
            return $response;
		}
    }
    /**
     *  ajax request to update  existing  customer into db
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
        //get customer using id
        $customer = $entityManager->find('AlexDoctrine\Entity\Customers', $id);
        if ( ! $customer ) {
            $response->setContent(Json::encode(array('response' => '','error'=>'coudnot find customer with id = '.$id)));
            return $response;
        }

         //get form
        $formManager = $this->serviceLocator->get('FormElementManager');
        $form = $formManager->get('customersForm');
        $form->setBindOnValidate(false);
        $form->bind($customer);

        $request = $this->getRequest();
        if ($request->isPost())
        {
            $form->setData($request->getPost());

            if ( $form->isValid()  )
            {
                $form->bindValues();
                $entityManager->flush();

                 // make array from entity
				$hydrator = new ReflectionHydrator();
				$customerArray  = $hydrator->extract($customer);
                unset($customerArray['calls']);
                $response->setContent(Json::encode(array('response' => $customerArray,'error'=>'')));
            }
            else
            {                    // if we have server not valid data
                $response->setContent(Json::encode(array('response' => '','error'=>$form->getMessages())));
            }
            return $response;
        }
    }
   /**
     *  ajax request to delete   customer from db
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
        $customer = $entityManager->find('AlexDoctrine\Entity\Customers', $id);

        if ( $customer )
        {
            $entityManager->remove($customer);
            $entityManager->flush();
            $response->setContent(Json::encode(array('response' => true,'error'=>'')));
           }
        else
        {
            $response->setContent(Json::encode(array('response' => '','error'=>'not found customer')));
        }
        return $response;

    }


    /**
     * set entity manager to val of this class
     * @param type $service
     */
    public function setEMService($service)
    {
		$this->emService = $service;
    }





}
