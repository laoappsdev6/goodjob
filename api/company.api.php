<?php

require_once "../controllers/company.controller.php";
require_once "../models/company.model.php";

try {
    $method = GetMethod();

    $json = json_decode(file_get_contents('php://input'), true);
    $control = new CompanyController();

    if ($method == "addCompany") {
        $model = new CompanyModel($json);
        $model->validateall();
        $control->addCompany($model);
    } else if ($method == "updateCompany") {
        Initialization();
        $model = new CompanyModel($json);
        $model->validateall();
        $control->updateCompany($model);
    } else if ($method == "deleteCompany") {
        Initialization();
        $model = new CompanyModel($json);
        $control->deleteCompany($model);
    } else if ($method == "upProveCompany") {
        Initialization();
        $model = new CompanyModel($json);
        $control->upProveCompany($model);
    } else if ($method == "setDisableAndEnableCompany") {
        Initialization();
        $model = new CompanyModel($json);
        $control->setDisableAndEnableCompany($model);
    } else if ($method == "changePassword") {
        Initialization();
        $model = new CompanyModel($json);
        $model->validateNewPassword();
        $control->changePassword($model);
    } else if ($method == "companyListPage") {
        Initialization();
        $model = new CompanyModel($json);
        $control->companyListPage($model);
    } else if ($method == "companyListAll") {
        Initialization();
        $control->companyListALL();
    } else if ($method == "getCompany") {
        Initialization();
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
