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
                validateEmpty($this->companyName, "ກະລະນາປ້ອນ ຊື່ບໍລິສັດ!");
                $sql = "select * from company where companyName='$this->companyName' and id !='$this->id'";
                validateAlreadyExist($sql, "ຊື່ບໍລິສັດ {$this->companyName} ນີ້ ມີຢູ່ແລ້ວ!");
                break;
            case 'address':
                validateEmpty($this->address, "ກະລະນາປ້ອນ ທີ່ຢູ່້!");
                break;
            case 'district_id':
                validateEmpty($this->district_id, "district_id is empty!");
                break;
            case 'province_id':
                validateEmpty($this->province_id, "province_id is empty!");
                break;
            case 'companyPhonenumber':
                validateEmpty($this->companyPhonenumber, "ກະລະນາປ້ອນ ເບິໂທລະສັບ!");
                $sql = "select * from company where companyPhonenumber='$this->companyPhonenumber' and id !='$this->id'";
                validateAlreadyExist($sql, "ເບີໂທ {$this->companyPhonenumber} ນີ້ ມີແລ້ວ!");
                break;
            case 'companyContactInfo':
                validateEmpty($this->companyContactInfo, "ກະລະນາປ້ອນ ຂໍ້ມູນຕິດຕໍ່!");
                break;
            case 'coordinatorPhonenumber':
                validateEmpty($this->coordinatorPhonenumber, "ກະລະນາປ້ອນ ເບີໂທ!");
                break;
            case 'password':
                validateEmpty($this->password, "ກະລະນາປ້ອນ ລະຫັດຜ່ານ!");
                break;
        }
    }

    public function validateNewPassword()
    {
        validateEmpty($this->newPassword, "ກະລຸນາປ້ອນ ລະຫັດຜ່ານໃໝ່!");
    }
}
