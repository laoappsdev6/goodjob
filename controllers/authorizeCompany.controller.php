<?php

require_once "../services/services.php";
require_once "../services/common.inc.php";
require_once 'database.controller.php';
require_once 'databasePDO.controller.php';

class LoginCompanyController
{
    public function __construct()
    {
    }
    public function checkLogin($u)
    {
        $db = new DatabaseController();
        $sql = "select * from company where companyPhonenumber='$u->phonenumber' and password='$u->password' and isActive=1 and status='upproved'";
        $name = $db->query($sql);
        if ($name > 0) $row = $name[0];

        $sql1 = "select id,companyName,address,district_id,province_id,companyPhonenumber,companyEmail from company
                where companyPhonenumber='$u->phonenumber' and password='$u->password' and isActive=1 and status='upproved'";
        $list = $db->query($sql1);
        if ($name > 0) {
            echo json_encode(array(
                'status' => "1",
                'Token' => registerToken($row),
                'data' => $list[0],
            ));
        } else {

            $sql = "select * from company where companyPhonenumber='$u->phonenumber'";
            $name = $db->query($sql);

            $sql1 = "select * from company where password='$u->password'";
            $pass = $db->query($sql1);

            if ($name == 0 && $pass == 0) {
                PrintJSON("", "Wrong phonenumber and password!!!", 0);
            } else if ($name > 0 && $pass == 0) {
                PrintJSON("", "Wrong password!!!", 0);
            } else if ($name == 0 && $pass > 0) {
                PrintJSON("", "Wrong phonenumber!!!", 0);
            } else if ($name > 0 && $pass > 0) {
                PrintJSON("", "You have no authorize!!!", 0);
            }
        }
    }
}
