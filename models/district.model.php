<?php

require_once "../controllers/validate.controller.php";
require_once "validate.model.php";

class DistrictModel
{
    public ?int $id = 0;
    public ?int $province_id;
    public string $district;

    public $page;
    public $limit;
    public $keyword;

    public function __construct($object, $isCheck = true)
    {
        if ($isCheck) {
            validateEmptyObject($object, "Data is empty!");
        }

        foreach ($object as $property => $value) {
            if (property_exists('DistrictModel', $property)) {
                $this->$property = $value;
            }
        }
    }

    public function validateDistrict()
    {
        validateEmpty($this->District, "District name is empty!");
    }
}
