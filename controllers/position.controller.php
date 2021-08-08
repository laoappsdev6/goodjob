<?php
require_once "../services/services.php";
require_once 'database.controller.php';
require_once 'databasePDO.controller.php';

class PositionController
{
    public function __construct()
    {
    }

    public function addPosition($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "insert into position (position) values ('$get->position')";
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
    public function updatePosition($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "update position set position='$get->position' where id='$get->id'";
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
    public function deletePosition($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "delete from position where id='$get->id'";
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

    public function getPosition($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "select * from position where id='$get->id'";
            $data = $db->query($sql);

            PrintJSON($data, "Data list one of position", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function positionListAll()
    {
        try {
            $db = new DatabaseController();
            $sql = "select * from position order by id desc";
            $data = $db->query($sql);
            PrintJSON($data, "Data list all of position", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function positionListPage($get)
    {
        try {

            $db = new DatabaseController();

            $sqlCount = "select count(*) as num from position";
            $dataCount = $db->query($sqlCount);
            $numRow = $dataCount[0]['num'];

            if ($numRow > 0) {

                $offset = (($get->page - 1) * $get->limit);

                $sql = "select * from position ";

                if (isset($get->keyword) && !empty($get->keyword)) {
                    $sql .= " where
                        position like '%$get->keyword%' 
                          ";
                }

                $sqlPage = " order by id desc limit $get->limit offset $offset";

                $data = $db->query($sql . $sqlPage);
                $dataList = $data;
            } else {
                $dataList = [];
            }

            $dataRes = Pagination($numRow, $dataList, $get->limit, $get->page);

            PrintJSON($dataRes, "Data list page of position", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
}
