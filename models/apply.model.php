<?php

require_once "../controllers/validate.controller.php";
require_once "validate.model.php";

class ApplyModel
{
    public ?int $id = 0;
    public int $member_id;
    public int $degree_id;
    public int $major_id;
    public int $postJobDetail_id;
    public string $applyDate;
    public string $status = 'apply';
    public string $applyDescription;

    public string $acceptDate;
    public string $acceptDescription;
    public string $interviewDate;

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
            if (property_exists('ApplyModel', $property)) {
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
            case 'member_id':
                validateEmpty($this->member_id, "member_id is empty!");
                break;
            case 'degree_id':
                validateEmpty($this->degree_id, "degree_id is empty!");
                break;
            case 'major_id':
                validateEmpty($this->major_id, "Username is empty!");
                break;
            case 'postJobDetail_id':
                validateEmpty($this->postJobDetail_id, "postJobDetail_id is empty!");
                break;
        }
    }
}
