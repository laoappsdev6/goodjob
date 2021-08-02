<?php
require_once "../controllers/salaryRate.controller.php";
require_once "../models/salaryRate.model.php";

try {
    Initialization();
    $method = GetMethod();

    $json = json_decode(file_get_contents('php://input'), true);
    $control = new SalaryRateController();

    if ($method == "addSalaryRate") {
        $model = new SalaryRateModel($json);
        $model->validateSalaryRateName();
        $control->addSalaryRate($model);
    } else if ($method == "updateSalaryRate") {
        $model = new SalaryRateModel($json);
        $model->validateSalaryRateName();
        $control->updateSalaryRate($model);
    } else if ($method == "deleteSalaryRate") {
        $model = new SalaryRateModel($json);
        $control->deleteSalaryRate($model);
    } else if ($method == "salaryRateListPage") {
        $model = new SalaryRateModel($json);
        $control->SalaryRateListPage($model);
    } else if ($method == "salaryRateListAll") {
        $control->SalaryRateListALL();
    } else if ($method == "getSalaryRate") {
        $model = new SalaryRateModel($json);
        $control->getSalaryRate($model);
    } else {
        PrintJSON("", "method not found!", 0);
        die();
    }
} catch (Exception $e) {
    $error = $e->getMessage();
    PrintJSON("", "$error", 0);
}
