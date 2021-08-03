<?php

require_once "../controllers/admin.controller.php";
require_once "../models/admin.model.php";

try {
    Initialization();
    $method = GetMethod();

    $json = json_decode(file_get_contents('php://input'), true);
    $control = new AdminController();

    if ($method == "addAdmin") {
        $model = new AdminModel($json);
        $model->validateall();
        $control->addAdmin($model);
    } else if ($method == "updateAdmin") {
        $model = new AdminModel($json);
        $model->validateall();
        $control->updateAdmin($model);
    } else if ($method == "deleteAdmin") {
        $model = new AdminModel($json);
        $control->deleteAdmin($model);
    } else if ($method == "changePassword") {
        $model = new AdminModel($json);
        $model->validateNewPassword();
        $control->changePassword($model);
    } else if ($method == "adminListPage") {
        $model = new AdminModel($json);
        $control->AdminListPage($model);
    } else if ($method == "adminListAll") {
        $control->AdminListALL();
    } else if ($method == "getAdmin") {
        $model = new AdminModel($json);
        $control->getAdmin($model);
    } else {
        PrintJSON("", "method not found!", 0);
        die();
    }
} catch (Exception $e) {
    $error = $e->getMessage();
    PrintJSON("", "$error", 0);
}
