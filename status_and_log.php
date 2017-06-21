<?php
include("utils.php");
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

$lines = get_log_lines();
$s = status();
$l = tail_log($lines);

$json = json_encode(array("status" => $s, "log" => $l));
echo($json);
?>
