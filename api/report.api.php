<?php

require_once "../controllers/report.controller.php";

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
    } else {
        PrintJSON("", "method not found!", 0);
        die();
    }
} catch (Exception $e) {
    $error = $e->getMessage();
    PrintJSON("", "$error", 0);
}
