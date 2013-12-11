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

class CustomersAndCallsController extends AbstractActionController
{
    protected $emService;


 /**
     *  the main method which allow to see form and calls list under the form
     * @return view object with form and calls
     *
     */
    public function indexAction()
    {

        $calls = $this->emService->getEntityManager()->getRepository('AlexDoctrine\Entity\Calls')->findAll();

        //prepare array for pushing filtering data
        $result = [];
        foreach($calls as $call) {
            // make array from entity object
                $hydrator = new ReflectionHydrator();
				$callArray  = $hydrator->extract($call);

                $customerObj = $call->getCustomers();
                $callArray['customerid'] = $customerObj->getId();
                $callArray['firstName'] = $customerObj->getFirstName();
                $callArray['lastName'] = $customerObj->getLastName();
                $callArray['phone'] = $customerObj->getPhone();
                $callArray['address'] = $customerObj->getAddress();
                $callArray['status'] = $customerObj->getStatus();
               // $customerArray  = $hydrator->extract($customerObj);
                unset($callArray['customers']);

                $result[] = $callArray;

        }
//  echo "<pre>";
//  print_r($result);
//  echo "</pre>";
//  die;
		return new ViewModel(array(
            'callsAndCustomersJson' => json_encode($result)
            )
        );

    }




    public function setEMService($service)
    {
		$this->emService = $service;
    }

}
