<?php
require_once "../controllers/position.controller.php";
require_once "../models/position.model.php";

try {
    Initialization();
    $m = GetMethod();

    $json = json_decode(file_get_contents('php://input'), true);
    $control = new PositionController();

    if ($method == "addPosition") {
        $model = new PositionModel($json);
        $model->validatePosition();
        $control->addPosition($model);
    } else if ($method == "updatePosition") {
        $model = new PositionModel($json);
        $model->validatePosition();
        $control->updatePosition($model);
    } else if ($method == "deletePosition") {
        $model = new PositionModel($json);
        $control->deletePosition($model);
    } else if ($method == "positionListPage") {
        $model = new PositionModel($json);
        $control->PositionListPage($model);
    } else if ($method == "positionListAll") {
        $control->PositionListALL();
    } else if ($method == "getPosition") {
        $model = new PositionModel($json);
        $control->getPosition($model);
    } else {
        PrintJSON("", "method not found!", 0);
        die();
    }
} catch (Exception $e) {
    $error = $e->getMessage();
    PrintJSON("", "$error", 0);
}
