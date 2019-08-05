<?php
include("utils.php");
$bad_auth = auth("69");
$auth = auth(post_get("pass"));
if (strcmp($bad_auth, $auth) != 0) {
    stop();
}
echo($auth);
?>
