<?php
require_once "../services/services.php";
require_once 'database.controller.php';
require_once 'databasePDO.controller.php';

class SalaryRateController
{
    public function __construct()
    {
    }

    public function addSalaryRate($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "insert into salary_rate (salaryRate) values ('$get->salaryRate')";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "Add Salary rate successfully", 1);
            } else {
                PrintJSON("", "Add Salary rate failed!", 0);
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function updateSalaryRate($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "update salary_rate set salaryRate='$get->salaryRate' where id='$get->id'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "Update Salary rate successfully", 1);
            } else {
                PrintJSON("", "Update Salary rate failed!", 0);
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function deleteSalaryRate($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "delete from salary_rate where id='$get->id'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "Salary rate id: {$get->id} delete successfully", 1);
            } else {
                PrintJSON("", "Delete Salary rate failed!", 0);
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }

    public function getSalaryRate($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "select * from salary_rate where id='$get->id'";
            $data = $db->query($sql);

            PrintJSON($data, "Data list one of SalaryRate", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function SalaryRateListAll()
    {
        try {
            $db = new DatabaseController();
            $sql = "select * from salary_rate order by id desc";
            $data = $db->query($sql);
            PrintJSON($data, "Data list all of Salary rate", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function SalaryRateListPage($get)
    {
        try {

            $db = new DatabaseController();

            $sqlCount = "select count(*) as num from salary_rate";
            $dataCount = $db->query($sqlCount);
            $numRow = $dataCount[0]['num'];

            if ($numRow > 0) {

                $offset = (($get->page - 1) * $get->limit);

                $sql = "select * from salary_rate ";

                if (isset($get->keyword) && !empty($get->keyword)) {
                    $sql .= " where
                        SalaryRate like '%$get->keyword%' 
                          ";
                }

                $sqlPage = " order by id desc limit $get->limit offset $offset";

                $data = $db->query($sql . $sqlPage);
                $dataList = $data;
            } else {
                $dataList = [];
            }

            $dataRes = Pagination($numRow, $dataList, $get->limit, $get->page);

            PrintJSON($dataRes, "Data list page of SalaryRate", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
}
