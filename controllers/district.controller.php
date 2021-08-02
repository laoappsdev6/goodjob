<?php
require_once "../services/services.php";
require_once 'database.controller.php';
require_once 'databasePDO.controller.php';

class DistrictController
{
    public function __construct()
    {
    }

    public function addDistrict($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "insert into district (province_id,district) values ('$get->province_id','$get->district')";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "Add district successfully", 1);
            } else {
                PrintJSON("", "Add district failed!", 0);
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function updateDistrict($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "update district set province_id = '$get->province_id', district='$get->district' where id='$get->id'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "Update district successfully", 1);
            } else {
                PrintJSON("", "Update district failed!", 0);
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function deletedistrict($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "delete from district where id='$get->id'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "district id: {$get->id} delete successfully", 1);
            } else {
                PrintJSON("", "Delete district failed!", 0);
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }

    public function getDistrict($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "select d.id as district_id,district,d.province_id,p.province 
                    from district as d INNER JOIN province as p ON d.province_id = p.id where d.id='$get->id'";
            $data = $db->query($sql);

            PrintJSON($data, "Data list one of district", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function getdistrictByProvince($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "select d.id as district_id,district,d.province_id,p.province 
                    from district as d INNER JOIN province as p ON d.province_id = p.id where d.province_id='$get->province_id'";
            $data = $db->query($sql);

            PrintJSON($data, "Data list one of district", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function districtListAll()
    {
        try {
            $db = new DatabaseController();
            $sql = "select d.id as district_id,district,d.province_id,p.province 
                    from district as d INNER JOIN province as p ON d.province_id = p.id order by d.id desc";
            $data = $db->query($sql);
            PrintJSON($data, "Data list all of district", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function districtListPage($get)
    {
        try {

            $db = new DatabaseController();

            $sqlCount = "select count(*) as num
                        from district as d INNER JOIN province as p ON d.province_id = p.id";
            $dataCount = $db->query($sqlCount);
            $numRow = $dataCount[0]['num'];

            if ($numRow > 0) {

                $offset = (($get->page - 1) * $get->limit);

                $sql = "select d.id as district_id,district,d.province_id,p.province 
                        from district as d INNER JOIN province as p ON d.province_id = p.id";

                if (isset($get->keyword) && !empty($get->keyword)) {
                    $sql .= " where
                        district like '%$get->keyword%' 
                          ";
                }

                $sqlPage = " order by d.id desc limit $get->limit offset $offset";

                $data = $db->query($sql . $sqlPage);
                $dataList = $data;
            } else {
                $dataList = [];
            }

            $dataRes = Pagination($numRow, $dataList, $get->limit, $get->page);

            PrintJSON($dataRes, "Data list page of district", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
}
