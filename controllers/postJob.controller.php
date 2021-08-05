<?php
require_once "../services/services.php";
require_once 'database.controller.php';
require_once 'databasePDO.controller.php';

class ApplyController
{
    public function __construct()
    {
    }
    public function addApply($get, $d)
    {
        try {

            $db = new PDODBController();

            $dateNow = datetime();
            $db->beginTran();

            $sql = "insert into post_job (company_id,fileForm,description) values ('$get->company_id','$get->fileForm','$get->description')";

            $db->query($sql);
            $ID = $db->lastID();
            $subsql = "insert into post_job_detail (postJob_id,jobName,description,posistion_id,salary_id,degree_id,major_id,date) values";
            for ($i = 0; $i < sizeof($d); $i++) {
                $jobName = $d[$i]['jobName'];
                $description = $d[$i]['description'];
                $posistion_id = $d[$i]['posistion_id'];
                $salary_id = $d[$i]['salary_id'];
                $degree_id = $d[$i]['degree_id'];
                $major_id = $d[$i]['major_id'];

                if ($i == sizeof($d) - 1) {
                    $subsql .= "($ID,'$jobName','$description','$posistion_id','$salary_id','$degree_id','$major_id','$dateNow')";
                } else {
                    $subsql .= "($ID,'$jobName','$description','$posistion_id','$salary_id','$degree_id','$major_id','$dateNow'),";
                }
            }
            // echo $subsql;
            $db->query($subsql);

            $db->commit();
            PrintJSON("", "Add apply successfully", 1);
        } catch (Exception $e) {
            // $db->rollback();
            PrintJSON("", "Add apply failed!", 0);
        }
    }
    public function updateApply($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "update apply set degree_id='$get->degree_id',major_id='$get->major_id',postJobDetail_id='$get->postJobDetail_id',applyDescription='$get->applyDescription' where id='$get->id'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "Update apply successfully", 1);
            } else {
                PrintJSON("", "Update apply failed!", 0);
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function deleteApply($u)
    {
        try {
            $db = new DatabaseController();
            $sql = "delete from apply where id='$u->id'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "apply id: {$u->id} delete successfully", 1);
            } else {
                PrintJSON("", "Delete apply failed!", 0);
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function acceptApply($get)
    {
        try {
            $userId = $_SESSION['userid'];
            $db = new DatabaseController();
            $sql = "update apply set status='acepted',acceptBy='$userId',acceptDate='$get->acceptDate'  where id='$get->id'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "accept apply successfully", 1);
            } else {
                PrintJSON("", "accept apply failed!", 0);
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function getApply($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "select a.*,m.memberName,m.memberLast,m.gender,d.degree,j.major,
                    jd.jobName,jd.description as jobDescription,c.companyName,c.address
                    from apply as a 
                    INNER JOIN member as m ON a.member_id = m.id
                    INNER JOIN degree as d ON a.degree_id = d.id
                    INNER JOIN major as j ON a.major_id = j.id  
                    INNER JOIN post_job_detail as ON jd = a.postJobDetail_id = jd.id
                    INNER JOIN post_job as pj ON jd.postJob_id = pj.id
                    INNER JOIN company as c ON pj.company_id = c.id
                    where a.id='$get->id'";
            $data = $db->query($sql);

            PrintJSON($data, "Data list one of apply", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function applyListAll()
    {
        try {
            $db = new DatabaseController();
            $sql = "select * from apply order by id desc";
            $data = $db->query($sql);
            PrintJSON($data, "Data list all of apply", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function applyListPage($get)
    {
        try {

            $db = new DatabaseController();

            $sqlCount = "select count(*) as num from apply";
            $dataCount = $db->query($sqlCount);
            $numRow = $dataCount[0]['num'];

            if ($numRow > 0) {

                $offset = (($get->page - 1) * $get->limit);

                $sql = "select * from apply ";

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

            PrintJSON($dataRes, "Data list page of apply", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
}
