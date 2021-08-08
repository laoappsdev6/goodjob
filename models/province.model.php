<?php

require_once "../controllers/validate.controller.php";
require_once "validate.model.php";

class ProvinceModel
{
    public ?int $id = 0;
    public string $province;

    public $page;
    public $limit;
    public $keyword;

    public function __construct($object, $isCheck = true)
    {
        if ($isCheck) {
            validateEmptyObject($object, "Data is empty!");
        }

        foreach ($object as $property => $value) {
            if (property_exists('ProvinceModel', $property)) {
                $this->$property = $value;
            }
        }
    }

    public function validateProvince()
    {
        validateEmpty($this->province, "ກະລຸນາປ້ອນ ຊື່ແຂວງ!");
    }
}
