<?php

require_once "../controllers/validate.controller.php";
require_once "validate.model.php";

class MemberModel
{
    public ?int $id = 0;
    public string $memberName;
    public string $memberLastname;
    public string $memberAddress;
    public int $district_id;
    public int $province_id;
    public string $gender;
    public string $dob;
    public string $phonenumber;
    public string $email;
    public string $password;
    public string $status = "0";
    public string $image;
    public bool $isActive = true;

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
            if (property_exists('MemberModel', $property)) {
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
            case 'memberName':
                validateEmpty($this->memberName, "memberName is empty!");
                break;
            case 'memberLastname':
                validateEmpty($this->memberLastname, "memberLastname is empty!");
                break;
            case 'memberAddress':
                validateEmpty($this->memberAddress, "memberAddress is empty!");
                break;
            case 'district_id':
                validateEmpty($this->district_id, "district_id is empty!");
                break;
            case 'province_id':
                validateEmpty($this->province_id, "province_id is empty!");
                break;
            case 'phonenumber':
                validateEmpty($this->phonenumber, "phonenumber is empty!");
                $sql = "select * from member where phonenumber='$this->phonenumber' and id !='$this->id'";
                validateAlreadyExist($sql, "phonenumber {$this->phonenumber} already exists!");
                break;
            case 'password':
                validateEmpty($this->password, "password is empty!");
                break;
            case 'gender':
                validateEmpty($this->gender, "gender is empty!");
                break;
            case 'dob':
                validateEmpty($this->dob, "dob is empty!");
                break;
        }
    }

    public function validateNewPassword()
    {
        validateEmpty($this->newPassword, "New password is empty!");
    }
}
