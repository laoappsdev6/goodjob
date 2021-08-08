<?php
require_once "validate.model.php";

class LoginAdminModel
{
    public $username;
    public $password;
    public $token;
    public function __construct($object)
    {
        validateEmptyObject($object, "Data is empty!");

        foreach ($object as $property => $value) {
            if (property_exists('LoginAdminModel', $property)) {
                $this->$property = $value;
            }
        }
    }

    function validatelogin()
    {
        if ($this->username == "" && $this->password == "") {
            PrintJSON("", "ກະລຸນາປ້ອນ ຊື່ ແລະ ລະຫັດຜ່ານ", 0);
            die();
        } else if ($this->username == "") {
            PrintJSON("", "ກະລຸນາປ້ອນ ຊື່ຜູ້ໃຊ້ ", 0);
            die();
        } elseif ($this->password == "") {
            PrintJSON("", "ກະລຸນາປ້ອນ ລະຫັດຜ່ານ ", 0);
            die();
        }
    }
}
