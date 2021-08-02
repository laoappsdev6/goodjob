<?php

require_once "../controllers/validate.controller.php";
require_once "validate.model.php";

class PositionModel
{
    public ?int $id = 0;
    public string $position;

    public $page;
    public $limit;
    public $keyword;

    public function __construct($object, $isCheck = true)
    {
        if ($isCheck) {
            validateEmptyObject($object, "Data is empty!");
        }

        foreach ($object as $property => $value) {
            if (property_exists('PositionModel', $property)) {
                $this->$property = $value;
            }
        }
    }

    public function validatePosition()
    {
        validateEmpty($this->position, "Position name is empty!");
    }
}
