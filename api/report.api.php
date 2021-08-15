<?php

require_once "../controllers/report.controller.php";

try {
    Initialization();
    $method = GetMethod();

    $json = json_decode(file_get_contents('php://input'), true);
    $control = new ReportController();
    $data = (object) $json;

    if ($method == "reportMember") {
        $control->reportMember($data);
    } else if ($method == "reportApplyAll") {
        $control->reportApplyAll($data);
    } else if ($method == "reportApplyByCompany") {
        $control->reportApplyByCompany($data);
    } else if ($method == "reportApplyAcceptAll") {
        $control->reportApplyAcceptAll($data);
    } else if ($method == "reportApplyAcceptByCompany") {
        $control->reportApplyAcceptByCompany($data);
    } else if ($method == "reportPostJobAll") {
        $control->reportPostJobAll($data);
    } else if ($method == "reportPostJobByCompany") {
        $control->reportPostJobByCompany($data);
    } else {
        PrintJSON("", "method not found!", 0);
        die();
    }
} catch (Exception $e) {
    $error = $e->getMessage();
    PrintJSON("", "$error", 0);
}
