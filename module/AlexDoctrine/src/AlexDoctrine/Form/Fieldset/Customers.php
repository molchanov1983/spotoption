<?php

namespace AlexDoctrine\Form\Fieldset;

use Zend\Form\Fieldset;


class Customers extends Fieldset
{

    public function __construct()
    {
       parent::__construct('customers');


        $this->add(array(
            'name' => 'add',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Add new customer',
                'class' => '',
            ),
        ));
        $this->add(array(
            'name' => 'update',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Update',
                'class' => 'display_none alex_update',
            ),
        ));

    }

}
