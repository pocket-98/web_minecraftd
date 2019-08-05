<?php
include("utils.php");
$pass = post_get("pass");
echo(auth($pass));
?>
