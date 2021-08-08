<?php
require_once "../services/services.php";
require_once 'database.controller.php';
require_once 'databasePDO.controller.php';

class CompanyController
{
    public function __construct()
    {
    }

    public function addCompany($get)
    {
        try {
            $nowDate = datetime();

            if (isset($get->image) && !empty($get->image)) {
                $type = explode('/', explode(';', $get->image)[0])[1];
                $p = preg_replace('#^data:image/\w+;base64,#i', '', $get->image);
                $name_image = "company-$get->companyName-address-$get->address.$type";
                $name = MY_PATH . $name_image;
                base64_to_jpeg($p, $name);
            } else {
                $name_image = "";
            }

            $db = new DatabaseController();
            $sql = "insert into company (companyName,address,district_id,province_id,companyPhonenumber,companyEmail,companyContactInfo,coordinatorPhonenumber,password,image,status,isActive,created_at)
                 values ('$get->companyName','$get->address','$get->district_id','$get->province_id','$get->companyPhonenumber','$get->companyEmail','$get->companyContactInfo',
                 '$get->coordinatorPhonenumber','$get->password','$name_image','$get->status','$get->isActive','$nowDate')";
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
    public function updateCompany($get)
    {
        try {

            if (isset($get->image) && !empty($get->image)) {
                $type = explode('/', explode(';', $get->image)[0])[1];
                $p = preg_replace('#^data:image/\w+;base64,#i', '', $get->image);
                $name_image = "company-$get->companyName-address-$get->address.$type";
                $name = MY_PATH . $name_image;
                base64_to_jpeg($p, $name);
            } else {
                $name_image = "";
            }

            $db = new DatabaseController();
            $sql = "update company set companyName='$get->companyName',district_id='$get->district_id',province_id='$get->province_id',companyPhonenumber='$get->companyPhonenumber',
                    companyEmail='$get->companyEmail', companyContactInfo='$get->companyContactInfo',coordinatorPhonenumber='$get->coordinatorPhonenumber',password='$get->password', 
                    image='$name_image' where id='$get->id'";
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
    public function deleteCompany($u)
    {
        try {
            $db = new DatabaseController();
            $sql = "delete from company where id='$u->id'";
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
    public function upProveCompany($u)
    {
        try {
            $userId = $_SESSION['userid'];
            $db = new DatabaseController();
            $sql = "update company set status='upproved',upproveBy='$userId' where id='$u->id'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "company id: {$u->id} upprove successfully", 1);
            } else {
                PrintJSON("", "upprove company failed!", 0);
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function setDisableAndEnableCompany($u)
    {
        $active = isset($u->isActive) && !empty($u->isActive) ? $u->isActive : '0';
        try {
            $db = new DatabaseController();
            $sql = "update company set isActive='$active' where id='$u->id'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "company id: {$u->id} set active successfully", 1);
            } else {
                PrintJSON("", "set active company failed!", 0);
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
            $sql = "update company set password='$u->newPassword' where id='$u->id'";
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
    public function getCompany($u)
    {
        try {
            $db = new DatabaseController();
            $sql = "select c.*,p.province,d.district from company as c 
                    INNER JOIN province as p ON c.province_id = p.id 
                    INNER JOIN district as d ON c.district_id = d.id where c.id='$u->id'";
            $data = $db->query($sql);

            PrintJSON($data, "Data list one of company", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function companyListAll()
    {
        try {
            $db = new DatabaseController();
            $sql = "select c.*,p.province,d.district from company as c 
                    INNER JOIN province as p ON c.province_id = p.id 
                    INNER JOIN district as d ON c.district_id = d.id order by c.id desc";
            $data = $db->query($sql);
            PrintJSON($data, "Data list all of company", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function companyListPage($get)
    {
        try {

            $db = new DatabaseController();

            $sqlCount = "select count(*) as num  from company as c 
                    INNER JOIN province as p ON c.province_id = p.id 
                    INNER JOIN district as d ON c.district_id = d.id";
            $dataCount = $db->query($sqlCount);
            $numRow = $dataCount[0]['num'];

            if ($numRow > 0) {

                $offset = (($get->page - 1) * $get->limit);

                $sql = "select c.*,p.province,d.district from company as c 
                        INNER JOIN province as p ON c.province_id = p.id 
                        INNER JOIN district as d ON c.district_id = d.id ";

                if (isset($get->keyword) && !empty($get->keyword)) {
                    $sql .= " where
                        companyName like '%$get->keyword%' or
                        address like '%$get->keyword%'
                          ";
                }

                $sqlPage = " order by id desc limit $get->limit offset $offset";

                $data = $db->query($sql . $sqlPage);
                $dataList = $data;
            } else {
                $dataList = [];
            }

            $dataRes = Pagination($numRow, $dataList, $get->limit, $get->page);

            PrintJSON($dataRes, "Data list page of company", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
}
