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
    public string $newRole;

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
                validateEmpty($this->name, "name is empty!");
                break;
            case 'lastname':
                validateEmpty($this->lastname, "lastname is empty!");
                break;
            case 'username':
                validateEmpty($this->username, "Username is empty!");
                $sql = "select * from admin where username='$this->username' and id !='$this->id'";
                validateAlreadyExist($sql, "Username {$this->username} already exists!");
                break;
            case 'password':
                validateEmpty($this->password, "Password is empty!");
                break;
            case 'address':
                validateEmpty($this->address, "address is empty!");
                break;
            case 'phonenumber':
                validateEmpty($this->phonenumber, "phonenumber is empty!");
                break;
        }
    }

    public function validateNewPassword()
    {
        validateEmpty($this->newPassword, "New password is empty!");
    }
}
