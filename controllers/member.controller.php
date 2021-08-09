<?php
require_once "../services/services.php";
require_once 'database.controller.php';
require_once 'databasePDO.controller.php';

class MemberController
{
    public function __construct()
    {
    }

    public function addMember($get)
    {
        try {
            $nowDate = datetime();
            if (isset($get->image) && !empty($get->image)) {
                $type = explode('/', explode(';', $get->image)[0])[1];
                $p = preg_replace('#^data:image/\w+;base64,#i', '', $get->image);
                $name_image = "member-$get->memberName-address-$get->memberAddress-dob-$get->dob.$type";
                $name = imagePath . $name_image;
                base64_to_jpeg($p, $name);
            } else {
                $name_image = "";
            }

            $db = new DatabaseController();
            $sql = "insert into member (memberName,memberLastname,memberAddress,district_id,province_id,gender,dob,phonenumber,email,password,image,status,isActive,created_at)
                 values ('$get->memberName','$get->memberLastname','$get->memberAddress','$get->district_id','$get->province_id','$get->gender','$get->dob','$get->phonenumber',
                 '$get->email','$get->password','$name_image','$get->status','$get->isActive','$nowDate')";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "ບັນທຶກຂໍ້ມູນສຳເລັດ", 1);
            } else {
                PrintJSON("", "ບໍ່ສາມາດບັນທຶກຂໍ້ມູນໄດ້!", 0);
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function updateMember($get)
    {
        try {

            if (isset($get->image) && !empty($get->image)) {
                $type = explode('/', explode(';', $get->image)[0])[1];
                $p = preg_replace('#^data:image/\w+;base64,#i', '', $get->image);
                $name_image = "member-$get->memberName-address-$get->memberAddress-dob-$get->dob.$type";
                $name = imagePath . $name_image;
                base64_to_jpeg($p, $name);
            } else {
                $name_image = "";
            }

            $db = new DatabaseController();
            $sql = "update member set memberName='$get->memberName',memberLastname='$get->memberLastname',memberAddress='$get->memberAddress',district_id='$get->district_id',province_id='$get->province_id',gender='$get->gender',
                    dob='$get->dob',phonenumber='$get->phonenumber', email='$get->email',password='$get->password', image='$name_image' where id='$get->id'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "ແກ້ໄຂຂໍ້ມູນສຳເລັດ", 1);
            } else {
                PrintJSON("", "ບໍ່ສາມາດແກ້ໄຂຂໍ້ມູນໄດ້!", 0);
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function deleteMember($u)
    {
        try {
            $db = new DatabaseController();
            $sql = "delete from member where id='$u->id'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "ລົບຂໍ້ມູນສຳເລັດ", 1);
            } else {
                PrintJSON("", "ບໍ່ສາມາດລົບຂໍ້ມູນໄດ້", 0);
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function setDisableAndEnableMember($u)
    {
        try {
            $db = new DatabaseController();
            $sql = "update member set isActive='$u->isActive' where id='$u->id'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "member id: {$u->id} set active successfully", 1);
            } else {
                PrintJSON("", "set active member failed!", 0);
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
            $sql = "update member set password='$u->newPassword' where id='$u->id'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "Change password successfully", 1);
            } else {
                PrintJSON("", "Change password failed!", 0);
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function getMember($u)
    {
        try {
            $db = new DatabaseController();
            $sql = "select m.*,p.province,d.district from member as m
                    INNER JOIN province as p ON m.province_id = p.id  
                    INNER JOIN district as d ON m.district_id = d.id where m.id='$u->id'";
            $data = $db->query($sql);

            PrintJSON($data, "Data list one of member", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function memberListAll()
    {
        try {
            $db = new DatabaseController();
            $sql = "select m.*,p.province,d.district from member as m
                    INNER JOIN province as p ON m.province_id = p.id  
                    INNER JOIN district as d ON m.district_id = d.id order by m.id desc";
            $data = $db->query($sql);
            PrintJSON($data, "Data list all of member", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function memberListPage($get)
    {
        try {

            $db = new DatabaseController();

            $sqlCount = "select count(*) as num  from member as m
                        INNER JOIN province as p ON m.province_id = p.id  
                        INNER JOIN district as d ON m.district_id = d.id";
            $dataCount = $db->query($sqlCount);
            $numRow = $dataCount[0]['num'];

            if ($numRow > 0) {

                $offset = (($get->page - 1) * $get->limit);

                $sql = "select m.*,p.province,d.district from member as m
                        INNER JOIN province as p ON m.province_id = p.id  
                        INNER JOIN district as d ON m.district_id = d.id ";

                if (isset($get->keyword) && !empty($get->keyword)) {
                    $sql .= " where
                        memberName like '%$get->keyword%' or
                        memberLastname like '%$get->keyword%'
                          ";
                }

                $sqlPage = " order by id desc limit $get->limit offset $offset";

                $data = $db->query($sql . $sqlPage);
                $dataList = $data;
            } else {
                $dataList = [];
            }

            $dataRes = Pagination($numRow, $dataList, $get->limit, $get->page);

            PrintJSON($dataRes, "Data list page of member", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
}
