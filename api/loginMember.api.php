<?php
require_once("../controllers/authorizeMember.controller.php");
require_once("../models/loginCompany.model.php");

try {

  $json = json_decode(file_get_contents('php://input'), true);

  $log = new LoginCompanyModel($json);
  $log->validatelogin();
  $controll = new LoginMemberController();
  $controll->checkLogin($log);
} catch (Exception $e) {
  print_r($e);
}
