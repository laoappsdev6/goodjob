<?php
require_once "validate.model.php";

class LoginCompanyModel
{
    public $phonenumber;
    public $password;
    public $token;
    public function __construct($object)
    {
        validateEmptyObject($object, "Data is empty!");

        foreach ($object as $property => $value) {
            if (property_exists('LoginCompanyModel', $property)) {
                $this->$property = $value;
            }
        }
    }

    function validatelogin()
    {
        if ($this->phonenumber == "" && $this->password == "") {
            PrintJSON("", "phonenumber and password is empty", 0);
            die();
        } else if ($this->phonenumber == "") {
            PrintJSON("", "phonenumber is empty ", 0);
            die();
        } elseif ($this->password == "") {
            PrintJSON("", "password is empty ", 0);
            die();
        }
    }
}
