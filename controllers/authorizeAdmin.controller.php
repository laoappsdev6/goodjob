<?php

require_once "../services/services.php";
require_once "../services/common.inc.php";
require_once 'database.controller.php';
require_once 'databasePDO.controller.php';

class LoginController
{

    public function __construct()
    {
    }

    public function checkLogin($u)
    {
        $db = new DatabaseController();
        $sql = "select * from admin where username='$u->username' and password='$u->password'";
        $name = $db->query($sql);
        if ($name > 0) $row = $name[0];

        $sql1 = "select id,name,lastname,username,address,phonenumber,email from admin
                where username='$u->username' and password='$u->password'";
        $list = $db->query($sql1);
        if ($name > 0) {
            echo json_encode(array(
                'status' => "1",
                'Token' => registerToken($row),
                'data' => $list[0],
            ));
        } else {

            $sql = "select * from admin where username='$u->username'";
            $name = $db->query($sql);

            $sql1 = "select * from admin where password='$u->password'";
            $pass = $db->query($sql1);

            if ($name == 0 && $pass == 0) {
                PrintJSON("", "Wrong username and password!!!", 0);
            } else if ($name > 0 && $pass == 0) {
                PrintJSON("", "Wrong password!!!", 0);
            } else if ($name == 0 && $pass > 0) {
                PrintJSON("", "Wrong username!!!", 0);
            } else if ($name > 0 && $pass > 0) {
                PrintJSON("", "You have no authorize!!!", 0);
            }
        }
    }
}
