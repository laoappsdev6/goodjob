<?php

require_once "../controllers/dashboard.controller.php";

try {
    Initialization();
    $method = GetMethod();

    $json = json_decode(file_get_contents('php://input'), true);
    $control = new DashboardController();
    $data = (object) $json;

    if ($method == "countOfAdmin") {
        $control->dashboardAdminCount();
    } else if ($method == "countOfCompany") {
        $control->dashboardCompanyCount($data);
    } else {
        PrintJSON("", "method not found!", 0);
        die();
    }
} catch (Exception $e) {
    $error = $e->getMessage();
    PrintJSON("", "$error", 0);
}
