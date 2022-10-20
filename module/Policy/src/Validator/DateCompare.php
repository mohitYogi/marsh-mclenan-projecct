<?php

namespace Policy\Validator;

use Zend\Validator\AbstractValidator;

class DateCompare extends AbstractValidator
{
    // constants.
    const AFTER_DATE = 'after'; 
    const BEFORE_DATE  = 'before';  

    // Available validator options.
    protected $options = [
        'before' => self::BEFORE_DATE,
        'after' => self::AFTER_DATE,
    ];

    // Validation failure message IDs.
    const NOT_SCALAR  = 'notScalar';
    const BEFORE_DATE_EMPTY  = 'beforeDateEmpty';
    const AFTER_DATE_EMPTY = 'afterDateEmpty';
    const AFTER_DATE_FAIL = 'afterDateFail';
    const BEFORE_DATE_FAIL = 'beforeDateFail';

    // Validation failure messages.
    protected $messageTemplates = [
        self::NOT_SCALAR  => "The date must be a scalar value",
        self::BEFORE_DATE_EMPTY => "The before date must be non-empty",
        self::AFTER_DATE_EMPTY => "The after date must be non-empty",
        self::AFTER_DATE_FAIL => "The date is not after compared date",
        self::BEFORE_DATE_FAIL => "The date is not before compared date",
    ];

    // Constructor.
    public function __construct($options = null)
    {
        // Set filter options (if provided).
        if (is_array($options)) {

            if (isset($options['before'])) {
                $this->setBefore($options['before']);
            }
            if (isset($options['after'])) {
                $this->setAfter($options['after']);
            }
        }

        // Call the parent class constructor.
        parent::__construct($options);
    }

    // Sets before compare date.
    public function setBefore($date)
    {
        $this->options['before'] = $date;
    }

    // Sets after compare date.
    public function setAfter($date)
    {
        $this->options['after'] = $date;
    }

    // Validates a date
    public function isValid($value)
    {
        return false;
        if (!is_scalar($value)) {
            $this->error(self::NOT_SCALAR);
            return false;
        }

        // Convert the value to string.
        $value = (string) $value;

        $date = strtotime($value);
        if (isset($this->options['before'])) {
            $date_before = strtotime($this->options['before']);
        }
        if (isset($this->options['after'])) {
            $date_after = strtotime($this->options['after']);
        }

        $format = $this->options['format'];

        $isValid = false;
        if (isset($this->options['before']) && empty($this->options['before'])) {
            $this->error(self::BEFORE_DATE_EMPTY);
        }
        if (isset($this->options['after']) && empty($this->options['after'])) {
            $this->error(self::AFTER_DATE_EMPTY);
        }

        if (isset($date_after) && $date_after > $date) {
            $this->error(self::AFTER_DATE_FAIL);
            $isValid = true;
        }
        if (isset($date_before) && $date_before < $date) {
            $this->error(self::BEFORE_DATE_FAIL);
            $isValid = true;
        }

        // Return validation result.
        return $isValid;
    }
}
