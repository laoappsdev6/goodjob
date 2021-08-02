<?php
require_once "../controllers/degree.controller.php";
require_once "../models/degree.model.php";

try {
    Initialization();
    $m = GetMethod();

    $json = json_decode(file_get_contents('php://input'), true);
    $control = new DegreeController();

    if ($method == "addDegree") {
        $model = new DegreeModel($json);
        $model->validateDegree();
        $control->addDegree($model);
    } else if ($method == "updateDegree") {
        $model = new DegreeModel($json);
        $model->validateDegree();
        $control->updateDegree($model);
    } else if ($method == "deleteDegree") {
        $model = new DegreeModel($json);
        $control->deleteDegree($model);
    } else if ($method == "degreeListPage") {
        $model = new DegreeModel($json);
        $control->DegreeListPage($model);
    } else if ($method == "degreeListAll") {
        $control->DegreeListALL();
    } else if ($method == "getDegree") {
        $model = new DegreeModel($json);
        $control->getDegree($model);
    } else {
        PrintJSON("", "method not found!", 0);
        die();
    }
} catch (Exception $e) {
    $error = $e->getMessage();
    PrintJSON("", "$error", 0);
}
