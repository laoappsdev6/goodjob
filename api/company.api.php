<?php

require_once "../controllers/company.controller.php";
require_once "../models/company.model.php";

try {
    // Initialization();
    $method = GetMethod();

    $json = json_decode(file_get_contents('php://input'), true);
    $control = new CompanyController();

    if ($method == "addCompany") {
        $model = new CompanyModel($json);
        $model->validateall();
        $control->addCompany($model);
    } else if ($method == "updateCompany") {
        $model = new CompanyModel($json);
        $model->validateall();
        $control->updateCompany($model);
    } else if ($method == "deleteCompany") {
        $model = new CompanyModel($json);
        $control->deleteCompany($model);
    } else if ($method == "upProveCompany") {
        $model = new CompanyModel($json);
        $control->upProveCompany($model);
    } else if ($method == "setDisableAndEnableCompany") {
        $model = new CompanyModel($json);
        $control->setDisableAndEnableCompany($model);
    } else if ($method == "changePassword") {
        $model = new CompanyModel($json);
        $model->validateNewPassword();
        $control->changePassword($model);
    } else if ($method == "companyListPage") {
        $model = new CompanyModel($json);
        $control->CompanyListPage($model);
    } else if ($method == "companyListAll") {
        $control->CompanyListALL();
    } else if ($method == "getCompany") {
        $model = new CompanyModel($json);
        $control->getCompany($model);
    } else {
        PrintJSON("", "method not found!", 0);
        die();
    }
} catch (Exception $e) {
    $error = $e->getMessage();
    PrintJSON("", "$error", 0);
}
