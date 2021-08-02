<?php

require_once "../controllers/admin.controller.php";
require_once "../models/admin.model.php";

try {
    Initialization();
    $method = GetMethod();

    $json = json_decode(file_get_contents('php://input'), true);
    $control = new AdminController();

    if ($m == "addAdmin") {
        $model = new AdminModel($json);
        $model->validateall();
        $control->addAdmin($model);
    } else if ($m == "updateAdmin") {
        $model = new AdminModel($json);
        $model->validateall();
        $control->updateAdmin($model);
    } else if ($m == "deleteAdmin") {
        $model = new AdminModel($json);
        $control->deleteAdmin($model);
    } else if ($m == "changePassword") {
        $model = new AdminModel($json);
        $model->validateNewPassword();
        $control->changePassword($model);
    } else if ($m == "adminListPage") {
        $model = new AdminModel($json);
        $control->AdminListPage($model);
    } else if ($m == "adminListAll") {
        $control->AdminListALL();
    } else if ($m == "getAdmin") {
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
