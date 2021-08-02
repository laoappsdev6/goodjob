<?php

function validateAlreadyExist(string $sql, string $message)
{
    $db = new DatabaseController();
    $name = $db->query($sql);
    if ($name > 0) {
        PrintJSON("", $message, 0);
        die();
    }
}
function validateNotAvailable(string $sql, string $message)
{
    $db = new DatabaseController();
    $name = $db->query($sql);
    if ($name == 0) {
        PrintJSON("", $message, 0);
        die();
    }
}
function validateUuid(string $sql)
{
    $db = new DatabaseController();
    $name = $db->query($sql);
    return $name;
}
