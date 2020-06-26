<?php
// see if var is defined in get or post vars
function post_get($var) {
    if (isset($_GET[$var]) && strlen($_GET[$var]) > 0) {
        return $_GET[$var];
    } else if (isset($_POST[$var]) && strlen($_POST[$var]) > 0) {
        return $_POST[$var];
    } else {
        return null;
    }
}

// get message to show for given password
function auth($pass) {
    // table of passwords and message if authenticated
    $auth_table = array();
    $auth_file = fopen("passwd", "r");
    while (! feof($auth_file)) {
        $line = fgets($auth_file);
        $line_parts = explode("::", $line);
        if (count($line_parts) == 2) {
            $auth_table += array(trim($line_parts[0]) => trim($line_parts[1]));
        }
    }
    fclose($auth_file);

    // check if authenticated
    $append_log = date("Y/m/d-H:i:s");
    $pass5 = md5($pass);
    if (array_key_exists($pass5, $auth_table)) {
        $auth = $auth_table[$pass5];
        $append_log .= " auth='$auth'";
    } else {
        $auth = "error: invalid password";
        $append_log .= " invalid pass='$pass'";
    }

    // add attempt to log unless passwd attempt was "69"
    if (strcmp($pass, "69") != 0) {
        $ip = "0.0.0.0";

        if (isset($_SERVER['HTTP_CLIENT_IP'])
            && $_SERVER['HTTP_CLIENT_IP'] != ''
        ) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])
            && $_SERVER['HTTP_X_FORWARDED_FOR'] != ''
        ) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])
            && $_SERVER['REMOTE_ADDR'] != ''
        ) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        if (($CommaPos = strpos($ip, ',')) > 0) {
            $ip = substr($ip, 0, ($CommaPos - 1));
        }

        $append_log .= " ip='$ip'\n";
        file_put_contents("/srv/minecraft/auth_log.txt", $append_log, FILE_APPEND);
    }
    return "<h4>$auth</h4>";
}

// get status of server (num process, ram usage)
function status() {
    // php is a crap language, use bash for string processing
	$no_color = 'sed "s/\x1B\[\([0-9]\{1,2\}\(;[0-9]\{1,2\}\)\?\)\?[mGK]//g"';
	$output = shell_exec("minecraftd status | $no_color");
	$tag = "h4";
	return "<$tag>" . str_replace("\n", "</$tag><$tag>", $output) . "</$tag>";
}

// get last n lines in log
function tail_log($n) {
	$log = "/srv/minecraft/logs/latest.log";
	$output = shell_exec("tail -n $n $log");
	$tag = "p";
	return "<$tag>" . str_replace("\n", "</$tag><$tag>", $output) . "</$tag>";
}

// start minecraft server
function start() {
	shell_exec("minecraftd start");
}

// stop minecraft server
function stop() {
	shell_exec("minecraftd stop");
}

// choose how many lines to show in log (default 15)
function get_log_lines() {
	$lines = 15;
    $tail = htmlspecialchars(post_get("tail"));
    if (is_numeric($tail)) {
        $lines = intval($tail);
    }
	return $lines;
}
auth("9319");
?>
