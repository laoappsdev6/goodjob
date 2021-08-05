<?php

require_once "../controllers/postJob.controller.php";
require_once "../models/postJob.model.php";

try {
    Initialization();
    $method = GetMethod();

    $json = json_decode(file_get_contents('php://input'), true);
    $control = new PostJobController();


    if ($method == "addPostJob") {
        $job = (object) $json['job'];
        $jobDetail = $json['jobDetail'];
        $control->addPostJob($job, $jobDetail);
    } else if ($method == "updatePostJob") {
        $job = (object) $json['job'];
        $jobDetail = $json['jobDetail'];
        $control->updatePostJob($job, $jobDetail);
    } else if ($method == "deletePostJob") {
        $obj = (object) $json;
        $control->deletePostJob($obj);
    } else if ($method == "postJobListPage") {
        $obj = (object) $json;
        $control->PostJobListPage($obj);
    } else if ($method == "postJobListAll") {
        $control->PostJobListALL();
    } else if ($method == "getPostJob") {
        $obj = (object) $json;
        $control->getPostJob($obj);
    } else if ($method == "searchJob") {
        $obj = (object) $json;
        $control->searchJob($obj);
    } else if ($method == "postJobListAllByCompany") {
        $obj = (object) $json;
        $control->postJobListByCompany($obj);
    } else if ($method == "postJobListPageByCompany") {
        $obj = (object) $json;
        $control->postJobListPageByCompany($obj);
    } else {
        PrintJSON("", "method not found!", 0);
        die();
    }
} catch (Exception $e) {
    $error = $e->getMessage();
    PrintJSON("", "$error", 0);
}
