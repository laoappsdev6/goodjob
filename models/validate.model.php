<?php

function validateEmptyObject($data, string $message)
{
    if (!$data) {
        PrintJSON("", $message, 0);
        die();
    }
}
function validateEmpty(string|null $data, string $message)
{
    if (empty($data)) {
        PrintJSON("", $message, 0);
        die();
    }
}
function validateStringLenght(string $data, int $number, string $message)
{
    if (strlen($data) < $number) {
        PrintJSON("", $message, 0);
        die();
    }
}
function validateIsNumber(string $data, string $message)
{
    if (!is_numeric($data)) {
        PrintJSON("", $message, 0);
        die();
    }
}
function validateData(string $data, string $message)
{
    $date = DateTime::createFromFormat('Y-m-d', $data);
    if (!$date) {
        PrintJSON("", $message, 0);
        die();
    }
}
function validateTime(string $data, string $message)
{
    $time = DateTime::createFromFormat('h:i:s', $data);
    if (!$time) {
        PrintJSON("", $message, 0);
        die();
    }
}
function validateDataTime(string $data, string $message)
{
    $dateTime = DateTime::createFromFormat('Y-m-d h:i:s', $data);
    if (!$dateTime) {
        PrintJSON("", $message, 0);
        die();
    }
}

function validateNotEqual(int $start, int $end, string $message)
{
    if ($start == $end) {
        PrintJSON("", $message, 0);
        die();
    }
}
