<?php

require_once "../controllers/validate.controller.php";
require_once "validate.model.php";

class PostJobModel
{
    public ?int $id = 0;
    public string $PostJob;

    public $page;
    public $limit;
    public $keyword;

    public function __construct($object, $isCheck = true)
    {
        if ($isCheck) {
            validateEmptyObject($object, "Data is empty!");
        }

        foreach ($object as $property => $value) {
            if (property_exists('PostJobModel', $property)) {
                $this->$property = $value;
            }
        }
    }

    public function validatePostJob()
    {
        validateEmpty($this->PostJob, "PostJob name is empty!");
    }
}
