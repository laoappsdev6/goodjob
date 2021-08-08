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
                validateEmpty($this->memberName, "ກະລຸນາປ້ອນ ຊື່ຜູ້ໃຊ້!");
                break;
            case 'memberLastname':
                validateEmpty($this->memberLastname, "ກະລຸນາປ້ອນ ນາສະກຸນ!");
                break;
            case 'memberAddress':
                validateEmpty($this->memberAddress, "ກະລຸນາປ້ອນ ທີ່ຢູ່!");
                break;
            case 'district_id':
                validateEmpty($this->district_id, "district_id is empty!");
                break;
            case 'province_id':
                validateEmpty($this->province_id, "province_id is empty!");
                break;
            case 'phonenumber':
                validateEmpty($this->phonenumber, "ກະລຸນາປ້ອນ ເບີໂທ!");
                $sql = "select * from member where phonenumber='$this->phonenumber' and id !='$this->id'";
                validateAlreadyExist($sql, "ເບີໂທ {$this->phonenumber} ນີ້ ມີຢູ່ແລ້ວ!");
                break;
            case 'password':
                validateEmpty($this->password, "ກະລຸນາ ປ້ອນລະຫັດຜ່ານ!");
                break;
            case 'gender':
                validateEmpty($this->gender, "ກະລຸນາ ເລືອກເພດ!");
                break;
            case 'dob':
                validateEmpty($this->dob, "ກະລຸນາ ເລືອກວັນເດືອນປີເກີດ!");
                break;
        }
    }

    public function validateNewPassword()
    {
        validateEmpty($this->newPassword, "ກະລຸນາປ້ອນ ລະຫັດຜ່ານໃໝ່!");
    }
}
