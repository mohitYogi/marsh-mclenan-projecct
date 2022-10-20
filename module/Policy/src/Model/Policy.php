<?php

namespace Policy\Model;

use DomainException;
use Policy\Validator\DateCompare;
use Zend\Filter\DateSelect;
use Zend\Filter\Digits;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToFloat;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\Between;
use Zend\Validator\Date;
use Zend\Validator\Digits as ValidatorDigits;
use Zend\Validator\GreaterThan;
use Zend\Validator\StringLength;

class Policy implements InputFilterAwareInterface
{
    protected $id;
    protected $first_name;
    protected $last_name;
    protected $policy_number;
    protected $start_date;
    protected $end_date;
    protected $premium;
    
    private $inputFilter;

    public function exchangeArray($data)
    {
        $this->id     = (!empty($data['id'])) ? $data['id'] : null;
        $this->first_name = (!empty($data['first_name'])) ? $data['first_name'] : null;
        $this->last_name  = (!empty($data['last_name'])) ? $data['last_name'] : null;
        $this->policy_number  = (!empty($data['policy_number'])) ? $data['policy_number'] : null;
        $this->start_date  = (!empty($data['start_date'])) ? date('Y-m-d',strtotime($data['start_date'])) : null;
        $this->end_date  = (!empty($data['end_date'])) ? date('Y-m-d', strtotime($data['end_date'])) : null;
        $this->premium  = (!empty($data['premium'])) ? $data['premium'] : null;
    }
    
    public function getArrayCopy()
    {
        return [
                'id' => $this->id,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'policy_number' => $this->policy_number,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'premium' => $this->premium,
        ];  

    }
     public function getId()
    {
       return $this->id;
    }

    public function getName()
    {
        return $this->first_name . " " . $this->last_name;
    }

    public function getFirstName()
    {
        return $this->first_name ;
    }

    public function getLastName()
    {
        return $this->last_name;
    }

    public function getPolicyNumber()
    {
        return $this->policy_number;
    }

    public function getStartDate()
    {
        return $this->start_date;
    }

    public function getEndDate()
    {
        return $this->end_date;
    }

    public function getPremium()
    {
        return $this->premium;
    }
    /* Add the following methods: */

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new DomainException(sprintf(
            '%s does not allow injection of an alternate input filter',
            __CLASS__
        ));
    }

    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name' => 'id',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'last_name',
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 200
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'last_name',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 200
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'start_date',
            'required' => true,
            'filters' => [
                ['name' => DateSelect::class],
            ],
            'validators' => [
                [
                    'name' => Date::class,
                    'options' => [
                        'format' => 'Y-m-d',
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'end_date',
            'required' => true,
            'filters' => [
                ['name' => DateSelect::class],
            ],
            'validators' => [
                [
                    'name' => Date::class,
                    'options' => [
                        'format' => 'Y-m-d',
                    ],
                ],
                // [
                //     'name' => DateCompare::class,
                //     'options' => [
                //         'encoding' => 'UTF-8',
                //         'after' => $this->getStartDate()
                //     ],
                // ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'policy_number',
            'required' => true,
            'filters' => [
                ['name' => Digits::class],
            ],
            'validators' => [
                [
                    'name' => ValidatorDigits::class,
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'premium',
            'required' => false,
            'filters' => [
                ['name' => ToFloat::class],
            ],
            'validators' => [
                [
                    'name' => Between::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 0.0,
                        'max' => 9999.99
                    ],
                ],
            ],
        ]);

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
    
}
