<?php
function status() {
	$strip_color = 'sed "s/\x1B\[\([0-9]\{1,2\}\(;[0-9]\{1,2\}\)\?\)\?[mGK]//g"';
	$output = shell_exec("minecraftd status | $strip_color");
	$tag = "h4";
	return "<$tag>" . str_replace("\n", "</$tag><$tag>", $output) . "</$tag>";
}

function tail_log($n) {
	$log = "/srv/minecraft/logs/latest.log";
	$output = shell_exec("tail -n $n $log");
	$tag = "p";
	return "<$tag>" . str_replace("\n", "</$tag><$tag>", $output) . "</$tag>";
}

function start() {
	shell_exec("minecraftd start");
}

function stop() {
	shell_exec("minecraftd stop");
}

function get_log_lines() {
	$lines = 15;
	if (isset($_GET["tail"])) {
		$tail = htmlspecialchars($_GET["tail"]);
		if (is_numeric($tail)) {
			$lines = intval($tail);
		}
	}
	return $lines;
}
?>
