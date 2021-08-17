<?php
require_once "../services/services.php";
require_once 'database.controller.php';
require_once 'databasePDO.controller.php';

class ApplyController
{
    public function __construct()
    {
    }

    public function addApply($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "insert into apply (member_id,degree_id,major_id,postJobDetail_id,applyDate,applyDescription,status)
                 values ('$get->member_id', '$get->degree_id','$get->major_id','$get->postJobDetail_id','$get->applyDate',
                 '$get->applyDescription','$get->status')";
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
    public function updateApply($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "update apply set degree_id='$get->degree_id',major_id='$get->major_id',
                    postJobDetail_id='$get->postJobDetail_id',applyDescription='$get->applyDescription' where id='$get->id'";
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
    public function deleteApply($u)
    {
        try {
            $db = new DatabaseController();
            $sql = "delete from apply where id='$u->id'";
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
    public function acceptApply($get)
    {
        try {
            $userId = $_SESSION['userid'];
            $db = new DatabaseController();
            $sql = "update apply set status='acepted',acceptBy='$userId',acceptDate='$get->acceptDate',
                    interviewDate='$get->interviewDate',acceptDescription='$get->acceptDescription'  where id='$get->id'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "ຍອມຮັບສຳເລັດ", 1);
            } else {
                PrintJSON("", "ບໍ່ສາມາດຍອມຮັບໄດ້!", 0);
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
            $sql = "select a.*,m.memberName,m.memberLastname,m.gender,m.phonenumber as memberPhonenumber,m.memberAddress,d.degree,j.major,
                    jd.jobName,jd.description as jobDescription,c.companyName,c.address as companyAddress
                    from apply as a 
                    INNER JOIN member as m ON a.member_id = m.id
                    INNER JOIN degree as d ON a.degree_id = d.id
                    INNER JOIN major as j ON a.major_id = j.id  
                    INNER JOIN post_job_detail as jd ON a.postJobDetail_id = jd.id
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
            $sql = "select a.*,m.memberName,m.memberLastname,m.gender,m.phonenumber as memberPhonenumber,m.memberAddress,d.degree,j.major,
                    jd.jobName,jd.description as jobDescription,c.companyName,c.address as companyAddress
                    from apply as a 
                    INNER JOIN member as m ON a.member_id = m.id
                    INNER JOIN degree as d ON a.degree_id = d.id
                    INNER JOIN major as j ON a.major_id = j.id  
                    INNER JOIN post_job_detail as jd ON a.postJobDetail_id = jd.id
                    INNER JOIN post_job as pj ON jd.postJob_id = pj.id
                    INNER JOIN company as c ON pj.company_id = c.id order by a.id desc";
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

            $sqlCount = "select count(*) as num from apply as a 
                        INNER JOIN member as m ON a.member_id = m.id
                        INNER JOIN degree as d ON a.degree_id = d.id
                        INNER JOIN major as j ON a.major_id = j.id  
                        INNER JOIN post_job_detail as jd ON a.postJobDetail_id = jd.id
                        INNER JOIN post_job as pj ON jd.postJob_id = pj.id
                        INNER JOIN company as c ON pj.company_id = c.id";
            $dataCount = $db->query($sqlCount);
            $numRow = $dataCount[0]['num'];

            if ($numRow > 0) {

                $offset = (($get->page - 1) * $get->limit);

                $sql = "select a.*,m.memberName,m.memberLastname,m.gender,m.phonenumber as memberPhonenumber,m.memberAddress,d.degree,j.major,
                jd.jobName,jd.description as jobDescription,c.companyName,c.address as companyAddress
                from apply as a 
                INNER JOIN member as m ON a.member_id = m.id
                INNER JOIN degree as d ON a.degree_id = d.id
                INNER JOIN major as j ON a.major_id = j.id  
                INNER JOIN post_job_detail as jd ON a.postJobDetail_id = jd.id
                INNER JOIN post_job as pj ON jd.postJob_id = pj.id
                INNER JOIN company as c ON pj.company_id = c.id ";

                if (isset($get->keyword) && !empty($get->keyword)) {
                    $sql .= " where
                        m.memberName like '%$get->keyword%' or
                        m.memberLastname like '%$get->keyword%'
                          ";
                }

                $sqlPage = " order by a.id desc limit $get->limit offset $offset";

                echo $sql . $sqlPage;
                die();
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

    public function applyListAllByMember($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "select a.*,m.memberName,m.memberLastname,m.gender,m.phonenumber as memberPhonenumber,m.memberAddress,d.degree,j.major,
                    jd.jobName,jd.description as jobDescription,c.companyName,c.address as companyAddress,c.image as companyImage
                    from apply as a 
                    INNER JOIN member as m ON a.member_id = m.id
                    INNER JOIN degree as d ON a.degree_id = d.id
                    INNER JOIN major as j ON a.major_id = j.id  
                    INNER JOIN post_job_detail as jd ON a.postJobDetail_id = jd.id
                    INNER JOIN post_job as pj ON jd.postJob_id = pj.id
                    INNER JOIN company as c ON pj.company_id = c.id where a.member_id ='$get->member_id' order by a.id desc";
            $data = $db->query($sql);
            PrintJSON($data, "Data list all of apply", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }

    public function applyListAllByPostJob($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "select a.*,m.memberName,m.memberLastname,m.gender,m.phonenumber as memberPhonenumber,m.memberAddress,d.degree,j.major,
                    jd.jobName,jd.description as jobDescription,c.companyName,c.address as companyAddress
                    from apply as a 
                    INNER JOIN member as m ON a.member_id = m.id
                    INNER JOIN degree as d ON a.degree_id = d.id
                    INNER JOIN major as j ON a.major_id = j.id  
                    INNER JOIN post_job_detail as jd ON a.postJobDetail_id = jd.id
                    INNER JOIN post_job as pj ON jd.postJob_id = pj.id
                    INNER JOIN company as c ON pj.company_id = c.id where jd.postJob_id ='$get->postJob_id' order by a.id desc";
            $data = $db->query($sql);
            PrintJSON($data, "Data list all of apply", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function applyListAllByCompany($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "select a.*,m.memberName,m.memberLastname,m.gender,m.phonenumber as memberPhonenumber,m.memberAddress,d.degree,j.major,
                    jd.jobName,jd.description as jobDescription,c.companyName,c.address as companyAddress
                    from apply as a 
                    INNER JOIN member as m ON a.member_id = m.id
                    INNER JOIN degree as d ON a.degree_id = d.id
                    INNER JOIN major as j ON a.major_id = j.id  
                    INNER JOIN post_job_detail as jd ON a.postJobDetail_id = jd.id
                    INNER JOIN post_job as pj ON jd.postJob_id = pj.id
                    INNER JOIN company as c ON pj.company_id = c.id where pj.company_id = '$get->company_id' order by a.id desc";
            $data = $db->query($sql);
            PrintJSON($data, "Data list all of apply", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function applyListAllByPostJobDetail($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "select a.*,m.memberName,m.memberLastname,m.gender,m.phonenumber as memberPhonenumber,m.memberAddress,d.degree,j.major,
                    jd.jobName,jd.description as jobDescription,c.companyName,c.address as companyAddress
                    from apply as a 
                    INNER JOIN member as m ON a.member_id = m.id
                    INNER JOIN degree as d ON a.degree_id = d.id
                    INNER JOIN major as j ON a.major_id = j.id  
                    INNER JOIN post_job_detail as jd ON a.postJobDetail_id = jd.id
                    INNER JOIN post_job as pj ON jd.postJob_id = pj.id
                    INNER JOIN company as c ON pj.company_id = c.id where a.postJobDetail_id = '$get->postJobDetail_id' order by a.id desc";
            $data = $db->query($sql);
            PrintJSON($data, "Data list all of apply", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }

    public function applyListAllByPostJobDetailAndStatus($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "select a.*,m.memberName,m.memberLastname,m.gender,m.phonenumber as memberPhonenumber,m.memberAddress,d.degree,j.major,
                    jd.jobName,jd.description as jobDescription,c.companyName,c.address as companyAddress
                    from apply as a 
                    INNER JOIN member as m ON a.member_id = m.id
                    INNER JOIN degree as d ON a.degree_id = d.id
                    INNER JOIN major as j ON a.major_id = j.id  
                    INNER JOIN post_job_detail as jd ON a.postJobDetail_id = jd.id
                    INNER JOIN post_job as pj ON jd.postJob_id = pj.id
                    INNER JOIN company as c ON pj.company_id = c.id where a.postJobDetail_id = '$get->postJobDetail_id' and a.status='$get->status' order by a.id desc";
            $data = $db->query($sql);
            PrintJSON($data, "Data list all of apply", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }

    public function applyListAllByCompanyAndStatus($get)
    {

        try {

            $db = new DatabaseController();

            $sqlCount = "select count(*) as num from apply as a 
                        INNER JOIN member as m ON a.member_id = m.id
                        INNER JOIN degree as d ON a.degree_id = d.id
                        INNER JOIN major as j ON a.major_id = j.id  
                        INNER JOIN post_job_detail as jd ON a.postJobDetail_id = jd.id
                        INNER JOIN post_job as pj ON jd.postJob_id = pj.id
                        INNER JOIN company as c ON pj.company_id = c.id where pj.company_id = '$get->company_id'";
            if (isset($get->status) && !empty($get->status)) {
                $sqlCount .= " and a.status='$get->status' ";
            }
            $dataCount = $db->query($sqlCount);
            $numRow = $dataCount[0]['num'];

            if ($numRow > 0) {

                $offset = (($get->page - 1) * $get->limit);

                $sql = "select a.*,m.memberName,m.memberLastname,m.gender,m.phonenumber as memberPhonenumber,m.memberAddress,d.degree,j.major,
                        jd.jobName,jd.description as jobDescription,c.companyName,c.address as companyAddress
                        from apply as a 
                        INNER JOIN member as m ON a.member_id = m.id
                        INNER JOIN degree as d ON a.degree_id = d.id
                        INNER JOIN major as j ON a.major_id = j.id  
                        INNER JOIN post_job_detail as jd ON a.postJobDetail_id = jd.id
                        INNER JOIN post_job as pj ON jd.postJob_id = pj.id
                        INNER JOIN company as c ON pj.company_id = c.id where pj.company_id = '$get->company_id' ";

                if (isset($get->status) && !empty($get->status)) {
                    $sql .= " and a.status='$get->status' ";
                }


                if (isset($get->keyword) && !empty($get->keyword)) {
                    $sql .= " and (
                            jd.jobName like '%$get->keyword%' or
                            m.memberName like '%$get->keyword%' )
                          ";
                }

                $sqlPage = " order by a.id desc limit $get->limit offset $offset";
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
