<?php
class MY_Form_validation extends CI_Form_validation {

    function __construct($config = array()) {
        parent::__construct($config);
    }

    function check_name($name) {
        if(preg_match("/[0-9]/", $name))
            return false;

        if(preg_match("/[!#$%^&*()?+=\/]/", $name))
            return false;

        return true;
    }

    function check_password($password) {
        if(preg_match("/[a-z]/", $password)) {
            if (preg_match("/[A-Z]/", $password)) {
                if (preg_match("/[0-9]/", $password)) {
                    if (preg_match("/[!@#$%^&*()?+=\/]/", $password)) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    function check_nickname($nickname) {
        return ctype_lower($nickname);
    }
}