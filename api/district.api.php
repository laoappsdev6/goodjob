<?php
require_once "../controllers/district.controller.php";
require_once "../models/district.model.php";

try {
    Initialization();
    $method = GetMethod();

    $json = json_decode(file_get_contents('php://input'), true);
    $control = new DistrictController();

    if ($method == "addDistrict") {
        $model = new DistrictModel($json);
        $model->validateDistrict();
        $control->addDistrict($model);
    } else if ($method == "updateDistrict") {
        $model = new DistrictModel($json);
        $model->validateDistrict();
        $control->updateDistrict($model);
    } else if ($method == "deleteDistrict") {
        $model = new DistrictModel($json);
        $control->deleteDistrict($model);
    } else if ($method == "districtListPage") {
        $model = new DistrictModel($json);
        $control->DistrictListPage($model);
    } else if ($method == "districtListAll") {
        $control->DistrictListALL();
    } else if ($method == "getDistrict") {
        $model = new DistrictModel($json);
        $control->getDistrict($model);
    } else if ($method == "getDistrictByProvince") {
        $model = new DistrictModel($json);
        $control->getdistrictByProvince($model);
    } else {
        PrintJSON("", "method not found!", 0);
        die();
    }
} catch (Exception $e) {
    $error = $e->getMessage();
    PrintJSON("", "$error", 0);
}
