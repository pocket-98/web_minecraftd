<?php
include("utils.php");
$lines = get_log_lines();
echo(tail_log($lines));
?>
