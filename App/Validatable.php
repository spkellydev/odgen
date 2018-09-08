<?php

namespace App;

class Validatable
{
    public function checkStringAsName($string)
    {
        if (!preg_match("/^[a-zA-Z'-]+$/", $string)) {
            return false;
        } else {
            return true;
        }
    }
    /**
     * check to make sure the integer is valid and within an acceptable range
     */
    public function checkIntRange($int, $min, $max)
    {
        if (is_string($int) && !ctype_digit($int)) {
            return false; // contains non digit characters
        }
        if (!is_int((int) $int)) {
            return false; // other non-integer value or exceeds PHP_MAX_INT
        }
        return ($int >= $min && $int <= $max);
    }

    /**
     * check to make sure email is valid input
     * RFC 822
     */
    public function checkEmail($email)
    {
        if (!is_string($email)) {
            return false;
        }

        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * check that boolean value is acceptable
     */
    public function checkBoolean($bool)
    {
        return filter_var($bool, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Regex to check that zipcode is valid
     * xxxxx format accepted
     * xxxxx-xxxx format accepted
     * Option to add 4 digit trailing
     */
    public function checkValidZipCode($zipCode)
    {
        if (!is_string($zipCode)) {
            return false;
        }

        return (preg_match('/^[0-9]{5}(-[0-9]{4})?$/', $zipCode)) ? true : false;
    }

}
