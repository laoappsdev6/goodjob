<?php
require_once "../services/services.php";
require_once 'database.controller.php';
require_once 'databasePDO.controller.php';

class ReportController
{
    public function __construct()
    {
    }
    public function reportMember($data)
    {
        try {
            $db = new DatabaseController();
            $sql = "select m.*,p.province,d.district from member as m
                    INNER JOIN province as p ON m.province_id = p.id  
                    INNER JOIN district as d ON m.district_id = d.id
                    where m.created_at between '$data->startDate' and '$data->endDate' 
                    order by m.id desc";
            $data = $db->query($sql);
            PrintJSON($data, "Data list all of member", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
    public function reportApplyAll($data)
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
                    where a.applyDate between '$data->startDate' and '$data->endDate' order by a.id desc";
            $data = $db->query($sql);
            PrintJSON($data, "Data list all of apply", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }

    public function reportApplyByCompany($data)
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
                    where (a.applyDate between '$data->startDate' and '$data->endDate') and pj.company_id='$data->company_id' order by a.id desc";

            $data = $db->query($sql);
            PrintJSON($data, "Data list all of apply", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }

    public function reportApplyAcceptAll($data)
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
                    where (a.applyDate between '$data->startDate' and '$data->endDate') and a.status='acepted'  order by a.id desc";
            $data = $db->query($sql);
            PrintJSON($data, "Data list all of apply", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }

    public function reportApplyAcceptByCompany($data)
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
                    where (a.applyDate between '$data->startDate' and '$data->endDate')
                     and a.status='acepted' and pj.company_id='$data->company_id' order by a.id desc";
            $data = $db->query($sql);
            PrintJSON($data, "Data list all of apply by company", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }

    public function reportPostJobAll($data)
    {
        try {
            $db = new DatabaseController();

            $sqlSearch = "select d.*,j.*,c.companyName,c.address,p.position,s.salaryRate,dg.degree,m.major from post_job_detail as d 
            INNER JOIN post_job as j ON d.postJob_id = j.id 
            INNER JOIN company as c ON j.company_id = c.id 
            INNER JOIN position as p ON d.posistion_id = p.id 
            INNER JOIN salary_rate as s ON d.salary_id = s.id 
            INNER JOIN degree as dg ON d.degree_id = dg.id 
            INNER JOIN major as m ON d.major_id = m.id where d.date between '$data->startDate' and '$data->endDate' order by d.id desc ";

            $dataSearch = $db->query($sqlSearch);

            PrintJSON($dataSearch, "Data report of PostJob", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }

    public function reportPostJobByCompany($data)
    {
        try {
            $db = new DatabaseController();

            $sqlSearch = "select d.*,j.*,c.companyName,c.address,p.position,s.salaryRate,dg.degree,m.major from post_job_detail as d 
            INNER JOIN post_job as j ON d.postJob_id = j.id 
            INNER JOIN company as c ON j.company_id = c.id 
            INNER JOIN position as p ON d.posistion_id = p.id 
            INNER JOIN salary_rate as s ON d.salary_id = s.id 
            INNER JOIN degree as dg ON d.degree_id = dg.id 
            INNER JOIN major as m ON d.major_id = m.id where (d.date between '$data->startDate' and '$data->endDate') and j.company_id='$data->company_id' order by d.id desc ";

            $dataSearch = $db->query($sqlSearch);

            PrintJSON($dataSearch, "Data report by company of PostJob", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
}
