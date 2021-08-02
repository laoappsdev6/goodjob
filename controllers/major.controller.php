<?php
require_once "../services/services.php";
require_once 'database.controller.php';
require_once 'databasePDO.controller.php';

class MajorController
{
    public function __construct()
    {
    }

    public function addMajor($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "insert into major (major) values ('$get->major')";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "Add major successfully", 1);
            } else {
                PrintJSON("", "Add major failed!", 0);
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function updateMajor($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "update major set major='$get->major' where id='$get->id'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "Update major successfully", 1);
            } else {
                PrintJSON("", "Update major failed!", 0);
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function deleteMajor($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "delete from major where id='$get->id'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "major id: {$get->id} delete successfully", 1);
            } else {
                PrintJSON("", "Delete major failed!", 0);
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }

    public function getMajor($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "select * from major where id='$get->id'";
            $data = $db->query($sql);

            PrintJSON($data, "Data list one of major", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function majorListAll()
    {
        try {
            $db = new DatabaseController();
            $sql = "select * from major order by id desc";
            $data = $db->query($sql);
            PrintJSON($data, "Data list all of major", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function majorListPage($get)
    {
        try {

            $db = new DatabaseController();

            $sqlCount = "select count(*) as num from major";
            $dataCount = $db->query($sqlCount);
            $numRow = $dataCount[0]['num'];

            if ($numRow > 0) {

                $offset = (($get->page - 1) * $get->limit);

                $sql = "select * from major ";

                if (isset($get->keyword) && !empty($get->keyword)) {
                    $sql .= " where
                        major like '%$get->keyword%' 
                          ";
                }

                $sqlPage = " order by id desc limit $get->limit offset $offset";

                $data = $db->query($sql . $sqlPage);
                $dataList = $data;
            } else {
                $dataList = [];
            }

            $dataRes = Pagination($numRow, $dataList, $get->limit, $get->page);

            PrintJSON($dataRes, "Data list page of major", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
}
