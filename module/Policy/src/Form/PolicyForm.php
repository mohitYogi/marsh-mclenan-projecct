<?php
namespace Policy\Form;

use Zend\Form\Element\Date;
use Zend\Form\Form;

class PolicyForm extends Form
{

    public function __construct()
    {
        parent::__construct('policy');

        $this->setAttribute('method', 'POST');

        $this->add([
            'name' => 'id',
            'type' => 'hidden'
        ]);

        $this->add([
            'name' => 'first_name',
            'type' => 'text',
            'options' => [
                'label' => 'First name'
            ]
        ]);

        $this->add([
            'name' => 'last_name',
            'type' => 'text',
            'options' => [
                'label' => 'Last name',
                'required' => true,
            ]
        ]);

        $this->add([
            'name' => 'start_date',
            'type' => 'text',
            'options' => [
                'label' => 'Start Date',
                'required' => true,
                'format' => 'Y-m-d',
            ]
        ]);

        $this->add([
            'name' => 'end_date',
            'type' => 'text',
            'options' => [
                'label' => 'End Date',
                'required' => true,
                'format' => 'Y-m-d',
            ]
        ]);

        $this->add([
            'name' => 'policy_number',
            'type' => 'number',
            'options' => [
                'label' => 'Policy Number',
                'required' => true,
            ]
        ]);

        $this->add([
            'name' => 'premium',
            'type' => 'text',
            'options' => [
                'label' => 'Premium',
            ]
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
               'value' => 'Save',
               'id'    => 'buttonSave'
            ]
        ]);

    }

}
