<?php
require_once "../controllers/province.controller.php";
require_once "../models/province.model.php";

try {
    Initialization();
    $m = GetMethod();

    $json = json_decode(file_get_contents('php://input'), true);
    $control = new ProvinceController();

    if ($method == "addProvince") {
        $model = new ProvinceModel($json);
        $model->validateProvince();
        $control->addProvince($model);
    } else if ($method == "updateProvince") {
        $model = new ProvinceModel($json);
        $model->validateProvince();
        $control->updateProvince($model);
    } else if ($method == "deleteProvince") {
        $model = new ProvinceModel($json);
        $control->deleteProvince($model);
    } else if ($method == "provinceListPage") {
        $model = new ProvinceModel($json);
        $control->ProvinceListPage($model);
    } else if ($method == "provinceListAll") {
        $control->ProvinceListALL();
    } else if ($method == "getProvince") {
        $model = new ProvinceModel($json);
        $control->getProvince($model);
    } else {
        PrintJSON("", "method not found!", 0);
        die();
    }
} catch (Exception $e) {
    $error = $e->getMessage();
    PrintJSON("", "$error", 0);
}
