<?php

require_once "../controllers/validate.controller.php";
require_once "validate.model.php";

class DegreeModel
{
    public ?int $id = 0;
    public string $degree;

    public $page;
    public $limit;
    public $keyword;

    public function __construct($object, $isCheck = true)
    {
        if ($isCheck) {
            validateEmptyObject($object, "Data is empty!");
        }

        foreach ($object as $property => $value) {
            if (property_exists('DegreeModel', $property)) {
                $this->$property = $value;
            }
        }
    }

    public function validateDegree()
    {
        validateEmpty($this->degree, "degree name is empty!");
    }
}
