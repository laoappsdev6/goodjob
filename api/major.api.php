<?php
require_once "../controllers/major.controller.php";
require_once "../models/major.model.php";

try {
    Initialization();
    $method = GetMethod();

    $json = json_decode(file_get_contents('php://input'), true);
    $control = new MajorController();

    if ($method == "addMajor") {
        $model = new MajorModel($json);
        $model->validateMajor();
        $control->addMajor($model);
    } else if ($method == "updateMajor") {
        $model = new MajorModel($json);
        $model->validateMajor();
        $control->updateMajor($model);
    } else if ($method == "deleteMajor") {
        $model = new MajorModel($json);
        $control->deleteMajor($model);
    } else if ($method == "majorListPage") {
        $model = new MajorModel($json);
        $control->MajorListPage($model);
    } else if ($method == "majorListAll") {
        $control->MajorListALL();
    } else if ($method == "getMajor") {
        $model = new MajorModel($json);
        $control->getMajor($model);
    } else {
        PrintJSON("", "method not found!", 0);
        die();
    }
} catch (Exception $e) {
    $error = $e->getMessage();
    PrintJSON("", "$error", 0);
}
