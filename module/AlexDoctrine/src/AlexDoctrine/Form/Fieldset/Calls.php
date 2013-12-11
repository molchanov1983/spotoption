<?php

namespace AlexDoctrine\Form\Fieldset;

use Zend\Form\Fieldset;


class Calls extends Fieldset
{

    public function __construct()
    {

       parent::__construct('calls');

        $this->add(array(
            'name' => 'add',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Add new call',
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