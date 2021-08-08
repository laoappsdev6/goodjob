<?php
require_once "../services/services.php";
require_once 'database.controller.php';
require_once 'databasePDO.controller.php';

class PostJobController
{
    public function __construct()
    {
    }
    public function addPostJob(object $get, array $d)
    {
        try {
            $db = new PDODBController();

            $dateNow = datetime();
            $db->beginTran();
            $number = rand();

            if (isset($get->fileForm) && !empty($get->fileForm)) {
                $type = explode('/', explode(';', $get->fileForm)[0])[1];
                $p = preg_replace('#^data:application/\w+;base64,#i', '', $get->fileForm);
                $nameFile = "company-id-$get->company_id-number-$number.$type";
                $name = MY_PATH . $nameFile;
                base64_to_jpeg($p, $name);
            } else {
                $nameFile = "";
            }

            $sql = "insert into post_job (company_id,fileForm,description) values ('$get->company_id','$nameFile','$get->description')";

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
            PrintJSON("", "ບັນທຶກຂໍ້ມູນສຳເລັດ", 1);
        } catch (Exception $e) {
            // $db->rollback();
            PrintJSON("", "ບໍ່ສາມາດບັນທຶກຂໍ້ມູນໄດ້!", 0);
        }
    }
    public function updatePostJob($get, $d)
    {
        try {
            $db = new PDODBController();

            $dateNow = datetime();
            $db->beginTran();
            $number = rand();

            if (isset($get->fileForm) && !empty($get->fileForm)) {
                $type = explode('/', explode(';', $get->fileForm)[0])[1];
                $p = preg_replace('#^data:application/\w+;base64,#i', '', $get->fileForm);
                $nameFile = "company-id-$get->company_id-number-$number.$type";
                $name = MY_PATH . $nameFile;
                base64_to_jpeg($p, $name);
            } else {
                $nameFile = "";
            }

            $sql = "update post_job set fileForm='$nameFile',description='$get->description' where id = '$get->postJob_id'";

            $db->query($sql);

            $sql = "delete from post_job_detail where postJob_id='$get->postJob_id' ";
            $db->query($sql);

            $subsql = "insert into post_job_detail (postJob_id,jobName,description,posistion_id,salary_id,degree_id,major_id,date) values";
            for ($i = 0; $i < sizeof($d); $i++) {
                $jobName = $d[$i]['jobName'];
                $description = $d[$i]['description'];
                $posistion_id = $d[$i]['posistion_id'];
                $salary_id = $d[$i]['salary_id'];
                $degree_id = $d[$i]['degree_id'];
                $major_id = $d[$i]['major_id'];

                if ($i == sizeof($d) - 1) {
                    $subsql .= "($get->postJob_id,'$jobName','$description','$posistion_id','$salary_id','$degree_id','$major_id','$dateNow')";
                } else {
                    $subsql .= "($get->postJob_id,'$jobName','$description','$posistion_id','$salary_id','$degree_id','$major_id','$dateNow'),";
                }
            }
            // echo $subsql;
            $db->query($subsql);

            $db->commit();
            PrintJSON("", "ແກ້ໄຂຂໍ້ມູນສຳເລັດ", 1);
        } catch (Exception $e) {
            // $db->rollback();
            PrintJSON("", "ບໍ່ສາມາດແກ້ໄຂຂໍ້ມູນໄດ້!", 0);
        }
    }
    public function deletePostJob($get)
    {
        try {
            $db = new PDODBController();
            $db->beginTran();

            $sql = "delete from post_job where id='$get->postJob_id'";

            $db->query($sql);

            $sql = "delete from post_job_detail where postJob_id='$get->postJob_id' ";
            $db->query($sql);

            $db->commit();
            PrintJSON("", "ລົບຂໍ້ມູນສຳເລັດ", 1);
        } catch (Exception $e) {
            // $db->rollback();
            PrintJSON("", "ບໍ່ສາມາດລົບຂໍ້ມູນໄດ້!", 0);
        }
    }

    public function getPostJob($get)
    {
        try {
            $db = new DatabaseController();
            $sqlJob = "select p.*,c.companyName,c.address from post_job as p INNER JOIN company as c ON p.company_id = c.id where p.id ='$get->postJob_id' ";
            $dataJob = $db->query($sqlJob);

            $sqlDetail = "select d.*,p.position,s.salaryRate,dg.degree,m.major from post_job_detail as d
                        INNER JOIN position as p ON d.posistion_id = p.id 
                        INNER JOIN salary_rate as s ON d.salary_id = s.id 
                        INNER JOIN degree as dg ON d.degree_id = dg.id 
                        INNER JOIN major as m ON d.major_id = m.id
                        where postJob_id = '$get->postJob_id'";
            $dataDetail = $db->query($sqlDetail);

            $dataRes = array("Job" => $dataJob, "jobDetail" => $dataDetail);

            PrintJSON($dataRes, "Data list one of PostJob", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function PostJobListAll()
    {
        try {
            $db = new DatabaseController();
            $sql = "select p.*,c.companyName,c.address,c.image,c.companyPhonenumber from post_job as p INNER JOIN company as c ON p.company_id = c.id order by p.id desc";
            $data = $db->query($sql);
            if ($data) {
                for ($i = 0; $i < count($data); $i++) {
                    $jobId  = $data[$i]['id'];
                    $sqlDetail = "select d.*,p.position,s.salaryRate,dg.degree,m.major from post_job_detail as d
                    INNER JOIN position as p ON d.posistion_id = p.id 
                    INNER JOIN salary_rate as s ON d.salary_id = s.id 
                    INNER JOIN degree as dg ON d.degree_id = dg.id 
                    INNER JOIN major as m ON d.major_id = m.id 
                    where postJob_id = '$jobId'";
                    $dataDetail = $db->query($sqlDetail);

                    if ($dataDetail) {
                        $data[$i]['jobDetail'] = $dataDetail;
                    } else {
                        $data[$i]['jobDetail'] = [];
                    }
                }
            }

            PrintJSON($data, "Data list all of PostJob", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function PostJobListPage($get)
    {
        try {

            $db = new DatabaseController();

            $sqlCount = "select count(*) as num from post_job as p INNER JOIN company as c ON p.company_id = c.id";
            $dataCount = $db->query($sqlCount);
            $numRow = $dataCount[0]['num'];

            if ($numRow > 0) {

                $offset = (($get->page - 1) * $get->limit);

                $sql = "select p.*,c.companyName,c.address from post_job as p INNER JOIN company as c ON p.company_id = c.id ";

                if (isset($get->keyword) && !empty($get->keyword)) {
                    $sql .= " where
                        c.companyName like '%$get->keyword%' or
                        c.address like '%$get->keyword%'
                          ";
                }

                $sqlPage = " order by p.id desc limit $get->limit offset $offset";

                $data = $db->query($sql . $sqlPage);
                if ($data) {
                    for ($i = 0; $i < count($data); $i++) {
                        $jobId  = $data[$i]['id'];
                        $sqlDetail = "select d.*,p.position,s.salaryRate,dg.degree,m.major from post_job_detail as d
                        INNER JOIN position as p ON d.posistion_id = p.id 
                        INNER JOIN salary_rate as s ON d.salary_id = s.id 
                        INNER JOIN degree as dg ON d.degree_id = dg.id 
                        INNER JOIN major as m ON d.major_id = m.id 
                        where postJob_id = '$jobId'";
                        $dataDetail = $db->query($sqlDetail);

                        if ($dataDetail) {
                            $data[$i]['jobDetail'] = $dataDetail;
                        } else {
                            $data[$i]['jobDetail'] = [];
                        }
                    }
                }
                $dataList = $data;
            } else {
                $dataList = [];
            }
            $dataRes = Pagination($numRow, $dataList, $get->limit, $get->page);

            PrintJSON($dataRes, "Data list page of PostJob", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }

    public function searchJob($get)
    {
        try {
            $db = new DatabaseController();

            $sqlSearch = "select d.*,j.*,c.companyName,c.address,p.position,s.salaryRate,dg.degree,m.major from post_job_detail as d 
            INNER JOIN post_job as j ON d.postJob_id = j.id 
            INNER JOIN company as c ON j.company_id = c.id 
            INNER JOIN position as p ON d.posistion_id = p.id 
            INNER JOIN salary_rate as s ON d.salary_id = s.id 
            INNER JOIN degree as dg ON d.degree_id = dg.id 
            INNER JOIN major as m ON d.major_id = m.id where $get->key like '%$get->value%' order by d.id desc ";

            $dataSearch = $db->query($sqlSearch);

            PrintJSON($dataSearch, "Data list search of PostJob", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }

    public function postJobListByCompany($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "select p.*,c.companyName,c.address from post_job as p INNER JOIN company as c ON p.company_id = c.id where p.company_id='$get->company_id' order by p.id desc";
            $data = $db->query($sql);
            if ($data) {
                for ($i = 0; $i < count($data); $i++) {
                    $jobId  = $data[$i]['id'];
                    $sqlDetail = "select d.*,p.position,s.salaryRate,dg.degree,m.major from post_job_detail as d
                    INNER JOIN position as p ON d.posistion_id = p.id 
                    INNER JOIN salary_rate as s ON d.salary_id = s.id 
                    INNER JOIN degree as dg ON d.degree_id = dg.id 
                    INNER JOIN major as m ON d.major_id = m.id 
                    where postJob_id = '$jobId'";
                    $dataDetail = $db->query($sqlDetail);

                    if ($dataDetail) {
                        $data[$i]['jobDetail'] = $dataDetail;
                    } else {
                        $data[$i]['jobDetail'] = [];
                    }
                }
            }

            PrintJSON($data, "Data list by company of PostJob", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }

    public function postJobListPageByCompany($get)
    {
        try {

            $db = new DatabaseController();

            $sqlCount = "select count(*) as num  from post_job as p INNER JOIN company as c ON p.company_id = c.id where p.company_id='$get->company_id'";
            $dataCount = $db->query($sqlCount);
            $numRow = $dataCount[0]['num'];

            if ($numRow > 0) {

                $offset = (($get->page - 1) * $get->limit);

                $sql = "select p.*,c.companyName,c.address from post_job as p INNER JOIN company as c ON p.company_id = c.id where p.company_id='$get->company_id' ";

                if (isset($get->keyword) && !empty($get->keyword)) {
                    $sql .= " where
                        c.companyName like '%$get->keyword%' or
                        c.address like '%$get->keyword%'
                          ";
                }

                $sqlPage = " order by p.id desc limit $get->limit offset $offset";

                $data = $db->query($sql . $sqlPage);
                if ($data) {
                    for ($i = 0; $i < count($data); $i++) {
                        $jobId  = $data[$i]['id'];
                        $sqlDetail = "select d.*,p.position,s.salaryRate,dg.degree,m.major from post_job_detail as d
                        INNER JOIN position as p ON d.posistion_id = p.id 
                        INNER JOIN salary_rate as s ON d.salary_id = s.id 
                        INNER JOIN degree as dg ON d.degree_id = dg.id 
                        INNER JOIN major as m ON d.major_id = m.id 
                        where postJob_id = '$jobId'";
                        $dataDetail = $db->query($sqlDetail);

                        if ($dataDetail) {
                            $data[$i]['jobDetail'] = $dataDetail;
                        } else {
                            $data[$i]['jobDetail'] = [];
                        }
                    }
                }
                $dataList = $data;
            } else {
                $dataList = [];
            }
            $dataRes = Pagination($numRow, $dataList, $get->limit, $get->page);

            PrintJSON($dataRes, "Data list page of PostJob", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
}
