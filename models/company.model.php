<?php

require_once "../controllers/validate.controller.php";
require_once "validate.model.php";

class CompanyModel
{
    public ?int $id = 0;
    public string $companyName;
    public string $address;
    public int $district_id;
    public int $province_id;
    public string $companyPhonenumber;
    public string $companyEmail;
    public string $companyContactInfo;
    public string $coordinatorPhonenumber;
    public string $password;
    public string $image;
    public string $status = 'register';
    public bool $isActive = true;
    public float $lat;
    public float $lng;
    public float $alt;

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
            if (property_exists('CompanyModel', $property)) {
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
            case 'companyName':
                validateEmpty($this->companyName, "companyName is empty!");
                $sql = "select * from company where companyName='$this->companyName' and id !='$this->id'";
                validateAlreadyExist($sql, "companyName {$this->companyName} already exists!");
                break;
            case 'address':
                validateEmpty($this->address, "address is empty!");
                break;
            case 'district_id':
                validateEmpty($this->district_id, "district_id is empty!");
                break;
            case 'province_id':
                validateEmpty($this->province_id, "province_id is empty!");
                break;
            case 'companyPhonenumber':
                validateEmpty($this->companyPhonenumber, "companyPhonenumber is empty!");
                $sql = "select * from company where companyPhonenumber='$this->companyPhonenumber' and id !='$this->id'";
                validateAlreadyExist($sql, "companyPhonenumber {$this->companyPhonenumber} already exists!");
                break;
            case 'companyContactInfo':
                validateEmpty($this->companyContactInfo, "companyContactInfo is empty!");
                break;
            case 'coordinatorPhonenumber':
                validateEmpty($this->coordinatorPhonenumber, "coordinatorPhonenumber is empty!");
                break;
            case 'password':
                validateEmpty($this->password, "password is empty!");
                break;
        }
    }

    public function validateNewPassword()
    {
        validateEmpty($this->newPassword, "New password is empty!");
    }
}
