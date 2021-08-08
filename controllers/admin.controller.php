<?php
require_once "../services/services.php";
require_once 'database.controller.php';
require_once 'databasePDO.controller.php';

class AdminController
{
    public function __construct()
    {
    }

    public function addAdmin($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "insert into admin (name,lastname,username,password,address,phonenumber,email)
                 values ('$get->name', '$get->lastname', '$get->username','$get->password','$get->address','$get->phonenumber','$get->email')";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "ບັນທຶກຂໍ້ມູນ ແອັດມິນ ສຳເລັດ", 1);
            } else {
                PrintJSON("", "ບໍ່ສາມາດບັນທຶກຂໍ້ມູນໄດ້!", 0);
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function updateAdmin($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "update admin set name='$get->name',lastname='$get->lastname', username='$get->username',password='$get->password',address='$get->address',phonenumber='$get->phonenumber',email='$get->phonenumber' where id='$get->id'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "ແກ້ໄຂຂໍ້ມູນສຳເລັດ", 1);
            } else {
                PrintJSON("", "ບໍ່ສາມາດແກ້ໄຂໄດ້!", 0);
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function deleteadmin($u)
    {
        try {
            $db = new DatabaseController();
            $sql = "delete from admin where id='$u->id'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "ລົບຂໍ້ມູນສຳເລັດ", 1);
            } else {
                PrintJSON("", "ບໍ່ສາມາດລົບຂໍ້ມູນໄດ້!", 0);
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function changePassword($u)
    {
        try {
            $db = new DatabaseController();
            $sql = "update admin set password='$u->newPassword' where id='$u->id'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "ປ່ຽນລະຫັດຜ່ານສຳເລັດ", 1);
            } else {
                PrintJSON("", "ບໍ່ສາມາດປ່ຽນລະຫັດຜ່ານໄດ້!", 0);
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function getadmin($u)
    {
        try {
            $db = new DatabaseController();
            $sql = "select * from admin where id='$u->id'";
            $data = $db->query($sql);

            PrintJSON($data, "Data list one of admin", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function adminListAll()
    {
        try {
            $db = new DatabaseController();
            $sql = "select * from admin order by id desc";
            $data = $db->query($sql);
            PrintJSON($data, "Data list all of admin", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function adminListPage($get)
    {
        try {

            $db = new DatabaseController();

            $sqlCount = "select count(*) as num from admin";
            $dataCount = $db->query($sqlCount);
            $numRow = $dataCount[0]['num'];

            if ($numRow > 0) {

                $offset = (($get->page - 1) * $get->limit);

                $sql = "select * from admin ";

                if (isset($get->keyword) && !empty($get->keyword)) {
                    $sql .= " where
                        name like '%$get->keyword%' or
                        lastname like '%$get->keyword%'
                          ";
                }

                $sqlPage = " order by id desc limit $get->limit offset $offset";

                $data = $db->query($sql . $sqlPage);
                $dataList = $data;
            } else {
                $dataList = [];
            }

            $dataRes = Pagination($numRow, $dataList, $get->limit, $get->page);

            PrintJSON($dataRes, "Data list page of admin", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
}
