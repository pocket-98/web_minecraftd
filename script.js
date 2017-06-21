var delay = 5000;
var numLines = 15;

var updateThread;

$(document).ready(function() {
	loading();
	statusAndLog(numLines);

	updateThread = setInterval(function() {
		statusAndLog(numLines);
	}, delay);
	console.log("started update thread");
});

$(window).on("unload", function() {
	clearInterval(updateThread);
	console.log("stopped update thread");
});

function loading() {
	$("#status-response").html("<div class='loader'></div>");
}

function status() {
	$.get("status.php", function(response) {
		$("#status-response").html(response);
		console.log("updated status");
	});
}

function log(numLines) {
	$.get("log.php", {"tail":numLines}, function(response) {
		$("#log-response").html(response);
		console.log("updated log");
	});
}

function start() {
	loading();
	$("#log-response").html("");
	$.get("start.php", function(response) {
		$("#log-response").html("");
		status(numLines);
		console.log("started server");

		clearInterval(updateThread);
		updateThread = setInterval(function() {
			statusAndLog(numLines);
		}, delay);
		console.log("started update thread");
	});
}

function stop() {
	loading();
	$.get("stop.php", function(response) {
		statusAndLog(numLines);
		console.log("stopped server");
		clearInterval(updateThread);
		console.log("stopped update thread");
	});
}

function statusAndLog(numLines) {
	$.get("status_and_log.php", {"tail":numLines}, function(response) {
		$("#status-response").html(response.status);
		$("#log-response").html(response.log);
		console.log("updated status and log");
	});
}
