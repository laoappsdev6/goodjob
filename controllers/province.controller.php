<?php
require_once "../services/services.php";
require_once 'database.controller.php';
require_once 'databasePDO.controller.php';

class ProvinceController
{
    public function __construct()
    {
    }

    public function addProvince($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "insert into province (province) values ('$get->province')";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "Add province successfully", 1);
            } else {
                PrintJSON("", "Add province failed!", 0);
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function updateProvince($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "update province set province='$get->province' where id='$get->id'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "Update province successfully", 1);
            } else {
                PrintJSON("", "Update province failed!", 0);
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function deleteProvince($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "delete from province where id='$get->id'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "province id: {$get->id} delete successfully", 1);
            } else {
                PrintJSON("", "Delete province failed!", 0);
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }

    public function getProvince($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "select * from province where id='$get->id'";
            $data = $db->query($sql);

            PrintJSON($data, "Data list one of province", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function provinceListAll()
    {
        try {
            $db = new DatabaseController();
            $sql = "select * from province order by id desc";
            $data = $db->query($sql);
            PrintJSON($data, "Data list all of province", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function provinceListPage($get)
    {
        try {

            $db = new DatabaseController();

            $sqlCount = "select count(*) as num from province";
            $dataCount = $db->query($sqlCount);
            $numRow = $dataCount[0]['num'];

            if ($numRow > 0) {

                $offset = (($get->page - 1) * $get->limit);

                $sql = "select * from province ";

                if (isset($get->keyword) && !empty($get->keyword)) {
                    $sql .= " where
                        province like '%$get->keyword%' 
                          ";
                }

                $sqlPage = " order by id desc limit $get->limit offset $offset";

                $data = $db->query($sql . $sqlPage);
                $dataList = $data;
            } else {
                $dataList = [];
            }

            $dataRes = Pagination($numRow, $dataList, $get->limit, $get->page);

            PrintJSON($dataRes, "Data list page of province", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
}
