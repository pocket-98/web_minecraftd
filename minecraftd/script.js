var delay = 5000;
var numLines = 15;
var updateThread;

$(document).ready(function() {
	$("#status-response").html("<div class='loader'></div>");
	statusAndLog(numLines);

	updateThread = setInterval(function() {
		statusAndLog(numLines);
	}, delay);
	console.log("started update thread");

    $("#passwd").keyup(function(event) {
        if (event.keyCode == 13) { // enter key pressed
            auth();
        }
    });
});

$(window).on("unload", function() {
	clearInterval(updateThread);
	console.log("stopped update thread");
});

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

function passwd() {
    return $("#passwd").val();
}

function auth() {
	$.get("auth.php", {"pass":passwd()}, function(response) {
		$("#status-response").html(response);
        if (response.indexOf("invalid") < 0) {
            console.log("checked password: authenticated");
        } else {
            console.log("checked password: not authenticated");
        }
    });
}

function start() {
	$("#status-response").html("<div class='loader'></div>");
	$("#log-response").html("");
	$.get("start.php", {"pass":passwd()}, function(response) {
		$("#log-response").html(response);
		status(numLines);
		console.log("started server");
		setTimeout(function() {
			statusAndLog(numLines);
		}, 1000);

		clearInterval(updateThread);
		updateThread = setInterval(function() {
			statusAndLog(numLines);
		}, delay);
		console.log("started update thread");
	});
}

function stop() {
	$("#status-response").html("<div class='loader'></div>");
	$.get("stop.php", {"pass":passwd()}, function(response) {
		$("#log-response").html(response);
		setTimeout(function() {
			statusAndLog(numLines);
		}, 1000);
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
