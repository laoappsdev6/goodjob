<?php
require_once "../services/services.php";
require_once 'database.controller.php';
require_once 'databasePDO.controller.php';

class DashBoardController
{
    public function __construct()
    {
    }

    public function dashboardAdminCount()
    {
        try {
            $db = new DatabaseController();
            $sqlCompany = "select count(*) as num from company where status = 'upproved'";
            $dataCompany = $db->query($sqlCompany);
            $numCompany = $dataCompany[0]['num'];

            $sqlMember = "select count(*) as num from member ";
            $dataMember = $db->query($sqlMember);
            $numMember = $dataMember[0]['num'];

            $sqlPostJob = "select count(*) as num from post_job";
            $dataPostJob = $db->query($sqlPostJob);
            $numPostJob = $dataPostJob[0]['num'];

            $sqlApply = "select count(*) as num from apply";
            $dataApply = $db->query($sqlApply);
            $numApply = $dataApply[0]['num'];

            $obj = array("company" => $numCompany, "member" => $numMember, "post" => $numPostJob, "apply" => $numApply);
            PrintJSON($obj, "Data count for dashboard admin", 1);
        } catch (Exception $e) {
            $error = $e->getMessage();
            PrintJSON("", "$error", 0);
        }
    }
}
