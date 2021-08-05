<?php
require_once "../services/services.php";
require_once 'database.controller.php';
require_once 'databasePDO.controller.php';

class ApplyController
{
    public function __construct()
    {
    }

    public function applyListAllByPostJobDetail($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "select a.*,m.memberName,m.memberLastname,m.gender,d.degree,j.major,
                    jd.jobName,jd.description as jobDescription,c.companyName,c.address
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
}
