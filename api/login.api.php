<?php
require_once("../controllers/authorize.controller.php");
require_once("../models/loginAdmin.model.php");

try {

  $json = json_decode(file_get_contents('php://input'), true);

  $log = new LoginAdminModel($json);
  $log->validatelogin();
  $controll = new LoginController();
  $controll->checkLogin($log);
} catch (Exception $e) {
  print_r($e);
}
