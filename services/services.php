<?php
require_once "common.inc.php";
error_reporting(E_ALL ^ E_NOTICE);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept,Token,M,Authorization");

function PrintJSON($data, $message, $status)
{

    $f = '{"data":%s,"message":"%s","status":"%s"}';
    if ($data) {
        if (is_array($data)) {
            printf($f, json_encode($data), $message, $status);
        } else {
            printf($f, $data, $message, $status);
        }
    } else {
        printf($f, "[]", $message, $status);
    }
}

function Pagination($numRow, $data, $limit,  $page)
{
    $allPage = ceil($numRow / $limit);

    return array("Data" => $data, "Page" => $page, "Pagetotal" => $allPage, "Datatotal" => $numRow);
}

function Initialization()
{
    $token = isset(getallheaders()['Token']) ? getallheaders()['Token'] : "";

    if (!empty($token) || $token != "") {
        $check = checkToken($token);
        if ($check > -1) {
            $id = $check;
            $_SESSION["userid"] = $id;
            // $_SESSION["userid"] = 1;
            $_SESSION['pass'] = authorizeToken($token);
        } else {
            PrintJSON("", "You have no authorize", 0);
            die();
        }
    } else {
        PrintJSON("", "You have no token", 0);
        die();
    }
}

function GetMethod()
{
    return isset(getallheaders()['Method']) ? getallheaders()['Method'] : "";
}

function base64_to_jpeg($base64_string, $output_file)
{
    $ifp = fopen($output_file, "wb");
    fwrite($ifp, base64_decode($base64_string));
    fclose($ifp);
    return ($output_file);
}

function dateTime()
{
    date_default_timezone_set("Asia/Vientiane");
    return date("Y-m-d H:i:s");
}

function formatDate($date)
{
    $date = new DateTime($date);
    return $date->format('Y-m-d H:i:s');
}
