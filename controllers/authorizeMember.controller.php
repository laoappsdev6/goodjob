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
        $sql = "select * from member where phonenumber='$u->phonenumber' and password='$u->password' and isActive=1";
        $name = $db->query($sql);
        if ($name > 0) $row = $name[0];

        $sql1 = "select id,memberName,memberLastname,memberAddress,district_id,province_id,gender,dob,phonenumber,email from member
                where phonenumber='$u->phonenumber' and password='$u->password' and isActive=1";
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
                PrintJSON("", "ເບີໂທ ແລະ ລະຫັດຜ່ານບໍ່ຖືກຕ້ອງ!!!", 0);
            } elseif ($name > 0 && $pass == 0) {
                PrintJSON("", "ລະຫັດຜ່ານບໍ່ຖືກຕ້ອງ", 0);
            } elseif ($name == 0 && $pass > 0) {
                PrintJSON("", "ເບີໂທ ບໍ່ຖືກຕ້ອງ!!!", 0);
            } elseif ($name > 0 && $pass > 0) {
                PrintJSON("", "ທ່ານຍັງບໍ່ໄດ້ຖືກຍອມຮັບເຂົ້າໃຊ້ລະບົບ!!!", 0);
            }
        }
    }
}
