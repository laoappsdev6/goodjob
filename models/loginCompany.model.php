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
            PrintJSON("", "ກະລຸນາປ້ອນ ເບີໂທ ແລະ ລະຫັດຜ່ານ", 0);
            die();
        } else if ($this->phonenumber == "") {
            PrintJSON("", "ກະລຸນາປ້ອນ ເບີໂທ ", 0);
            die();
        } elseif ($this->password == "") {
            PrintJSON("", "ກະລຸນາປ້ອນ ລະຫັດຜ່ານ ", 0);
            die();
        }
    }
}
