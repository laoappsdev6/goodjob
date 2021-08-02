<?php
require_once "../services/services.php";
require_once 'database.controller.php';
require_once 'databasePDO.controller.php';

class DegreeController
{
    public function __construct()
    {
    }

    public function addDegree($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "insert into degree (degree) values ('$get->degree')";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "Add degree successfully", 1);
            } else {
                PrintJSON("", "Add degree failed!", 0);
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function updateDegree($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "update degree set degree='$get->degree' where id='$get->id'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "Update degree successfully", 1);
            } else {
                PrintJSON("", "Update degree failed!", 0);
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function deleteDegree($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "delete from degree where id='$get->id'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "degree id: {$get->id} delete successfully", 1);
            } else {
                PrintJSON("", "Delete degree failed!", 0);
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }

    public function getDegree($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "select * from degree where id='$get->id'";
            $data = $db->query($sql);

            PrintJSON($data, "Data list one of degree", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function degreeListAll()
    {
        try {
            $db = new DatabaseController();
            $sql = "select * from degree order by id desc";
            $data = $db->query($sql);
            PrintJSON($data, "Data list all of degree", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function degreeListPage($get)
    {
        try {

            $db = new DatabaseController();

            $sqlCount = "select count(*) as num from degree";
            $dataCount = $db->query($sqlCount);
            $numRow = $dataCount[0]['num'];

            if ($numRow > 0) {

                $offset = (($get->page - 1) * $get->limit);

                $sql = "select * from degree ";

                if (isset($get->keyword) && !empty($get->keyword)) {
                    $sql .= " where
                        degree like '%$get->keyword%' 
                          ";
                }

                $sqlPage = " order by id desc limit $get->limit offset $offset";

                $data = $db->query($sql . $sqlPage);
                $dataList = $data;
            } else {
                $dataList = [];
            }

            $dataRes = Pagination($numRow, $dataList, $get->limit, $get->page);

            PrintJSON($dataRes, "Data list page of degree", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
}
