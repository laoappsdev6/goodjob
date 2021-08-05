<?php

require_once "../controllers/apply.controller.php";
require_once "../models/apply.model.php";

try {
    Initialization();
    $method = GetMethod();

    $json = json_decode(file_get_contents('php://input'), true);
    $control = new ApplyController();

    if ($method == "addApply") {
        $model = new ApplyModel($json);
        $model->validateall();
        $control->addApply($model);
    } else if ($method == "updateApply") {
        $model = new ApplyModel($json);
        $model->validateall();
        $control->updateApply($model);
    } else if ($method == "deleteApply") {
        $model = new ApplyModel($json);
        $control->deleteApply($model);
    } else if ($method == "acceptApply") {
        $model = new ApplyModel($json);
        $control->acceptApply($model);
    } else if ($method == "applyListPage") {
        $model = new ApplyModel($json);
        $control->ApplyListPage($model);
    } else if ($method == "applyListAll") {
        $control->ApplyListALL();
    } else if ($method == "getApply") {
        $model = new ApplyModel($json);
        $control->getApply($model);
    } else if ($method == "applyListAllByMember") {
        $model = (object) $json;
        $control->applyListAllByMember($model);
    } else if ($method == "applyListAllByPostJob") {
        $model = (object) $json;
        $control->applyListAllByPostJob($model);
    } else if ($method == "applyListAllByCompany") {
        $model = (object) $json;
        $control->applyListAllByCompany($model);
    } else if ($method == "applyListAllByPostJobDetail") {
        $model = (object) $json;
        $control->applyListAllByPostJobDetail($model);
    } else {
        PrintJSON("", "method not found!", 0);
        die();
    }
} catch (Exception $e) {
    $error = $e->getMessage();
    PrintJSON("", "$error", 0);
}
