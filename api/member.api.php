<?php

require_once "../controllers/member.controller.php";
require_once "../models/member.model.php";

try {

    Initialization();
    $method = GetMethod();

    $json = json_decode(file_get_contents('php://input'), true);
    $control = new MemberController();

    if ($method == "addMember") {
        $model = new MemberModel($json);
        $model->validateall();
        $control->addMember($model);
    } else if ($method == "updateMember") {
        $model = new MemberModel($json);
        $model->validateall();
        $control->updateMember($model);
    } else if ($method == "deleteMember") {
        $model = new MemberModel($json);
        $control->deleteMember($model);
    } else if ($method == "setDisableAndEnableMember") {
        $model = new MemberModel($json);
        $control->setDisableAndEnableMember($model);
    } else if ($method == "changePassword") {
        $model = new MemberModel($json);
        $model->validateNewPassword();
        $control->changePassword($model);
    } else if ($method == "memberListPage") {
        $model = new MemberModel($json);
        $control->MemberListPage($model);
    } else if ($method == "memberListAll") {
        $control->MemberListALL();
    } else if ($method == "getMember") {
        $model = new MemberModel($json);
        $control->getMember($model);
    } else {
        PrintJSON("", "method not found!", 0);
        die();
    }
} catch (Exception $e) {
    $error = $e->getMessage();
    PrintJSON("", "$error", 0);
}
