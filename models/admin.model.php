<?php

require_once "../controllers/validate.controller.php";
require_once "validate.model.php";

class AdminModel
{
    public ?int $id = 0;
    public string $name;
    public string $lastname;
    public string $username;
    public string $password;
    public string $address;
    public string $phonenumber;
    public string $email;

    public string $newPassword;

    public $page;
    public $limit;
    public $keyword;

    public function __construct($object, $isCheck = true)
    {
        if ($isCheck) {
            validateEmptyObject($object, "Data is empty!");
        }

        foreach ($object as $property => $value) {
            if (property_exists('AdminModel', $property)) {
                $this->$property = $value;
            }
        }
    }

    public function validateAll()
    {
        foreach ($this as $property => $value) {
            $this->validate($property);
        }
    }

    public function validate($p)
    {
        switch ($p) {
            case 'name':
                validateEmpty($this->name, "ກະລຸນາປ້ອນ ຊື່ຜູ້ໃຊ້!");
                break;
            case 'lastname':
                validateEmpty($this->lastname, "ກະລຸນາປ້ອນ ນາມສະກຸນຜູ້ໃຊ້!");
                break;
            case 'username':
                validateEmpty($this->username, "ກະລຸນາປ້ອນຊື່ຜູ້ໃຊ້!");
                $sql = "select * from admin where username='$this->username' and id !='$this->id'";
                validateAlreadyExist($sql, "ຊື່ຜູ້ໃຊ້ {$this->username} ນີ້ ມີແລ້ວ!");
                break;
            case 'password':
                validateEmpty($this->password, "ກະລະນາປ້ອນ ລະຫັດຜ່ານ!");
                break;
            case 'address':
                validateEmpty($this->address, "ກະລະນາປ້ອນສ ທີ່ຢູ່!");
                break;
            case 'phonenumber':
                validateEmpty($this->phonenumber, "ກະລະນາປ້ອນ ເບີໂທ!");
                break;
        }
    }

    public function validateNewPassword()
    {
        validateEmpty($this->newPassword, "ກະລະນາປ້ອນ ລະຫັດຜ່ານໃໝ່!");
    }
}
