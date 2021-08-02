<?php

require_once "../controllers/validate.controller.php";
require_once "validate.model.php";

class SalaryRateModel
{
    public ?int $id = 0;
    public string $salaryRate;

    public $page;
    public $limit;
    public $keyword;

    public function __construct($object, $isCheck = true)
    {
        if ($isCheck) {
            validateEmptyObject($object, "Data is empty!");
        }

        foreach ($object as $property => $value) {
            if (property_exists('SalaryRateModel', $property)) {
                $this->$property = $value;
            }
        }
    }

    public function validateSalaryRateName()
    {
        validateEmpty($this->salaryRateName, "Salary Rate name is empty!");
    }
}
