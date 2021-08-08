<?php

require_once "../controllers/validate.controller.php";
require_once "validate.model.php";

class MajorModel
{
    public ?int $id = 0;
    public string $major;

    public $page;
    public $limit;
    public $keyword;

    public function __construct($object, $isCheck = true)
    {
        if ($isCheck) {
            validateEmptyObject($object, "Data is empty!");
        }

        foreach ($object as $property => $value) {
            if (property_exists('MajorModel', $property)) {
                $this->$property = $value;
            }
        }
    }

    public function validateMajor()
    {
        validateEmpty($this->major, "ກະລຸນາປ້ອນ ສາຂາ!");
    }
}
