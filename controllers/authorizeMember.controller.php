<?php

require_once "../services/services.php";
require_once "../services/common.inc.php";
require_once 'database.controller.php';
require_once 'databasePDO.controller.php';

class LoginMemberController
{

    public function __construct()
    {
    }

    public function checkLogin($u)
    {
        $db = new DatabaseController();
        $sql = "select * from member where phonenumber='$u->phonenumber' and password='$u->password'";
        $name = $db->query($sql);
        if ($name > 0) $row = $name[0];

        $sql1 = "select id,memberName,memberLastname,memberAddress,district_id,province_id,gender,dob,phonenumber,email from member
                where phonenumber='$u->phonenumber' and password='$u->password'";
        $list = $db->query($sql1);
        if ($name > 0) {
            echo json_encode(array(
                'status' => "1",
                'Token' => registerToken($row),
                'data' => $list[0],
            ));
        } else {

            $sql = "select * from member where phonenumber='$u->phonenumber'";
            $name = $db->query($sql);

            $sql1 = "select * from member where password='$u->password'";
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
