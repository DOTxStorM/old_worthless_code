<?php
include_once 'includes/open_connection.php';
// modified from original authors thanosb, ddonahue; May 11, 2008
// Filename of log to use when none is given to logError
define("DEFAULT_LOG", "/some/default/directory/logs/logError.log");

/**
*  Writes the values of certain variables along with a message in a log file
*  
*  Parameters:
*    $logfile:	   Path of logfile to write to (Optional) - Default is DEFAULT_LOG
*	 $filename:	   Name of the file containing the error
*	 $lineNumber:  Line number on which the error occurred
*	 $message:	   Message to be logged
*
*  Returns array:
*	 $result[status]: 	true or false depending on the success of the operations
*	 $result[message]:	the error message
*
*  Sample Usage:
*	 Write to default log
*		$result = logError("someFile.txt", 36, "An error occurred that prevented a message from being saved");
*
*	 Write to another log
*		define("UPLOAD_LOG", "/some/other/directory/log/upload.log");
* 		$result = logError("someFile.txt", 42, "User attempted to send file larger than 2 megabytes", UPLOAD_LOG);
*/

function logError(string $filename, int $lineNumber, $message, $logfile='') {
	// Determine log file
	if($logfile == '') {
		//making sure default is defined
		if(defined(DEFAULT_LOG) == true) {
			$logfile = DEFAULT_LOG;
		}

		//the constant is undefined and there's no input log file
		else {
			error_log('No log file defined.', 0);
			return array(status=> false, message=> 'No log file defined.');
		}
	}

	$date = $date("Y-m-d H:i:s");

	if($fd = @fopen($logfile, "a")) {
		$result = fputcsv($fd, array($date, $filename, $lineNumber, $message));
		fclose($fd);

		if($result > 0)
			return array(status=> true);
		else
			return array(status=> false, message=> 'Unable to write to '.$logfile.'!');
	}
	else {
		return array(status=> false, message=> 'Unable to open log ' .$logfile.'!');
	}
}

function checkQuery(string $query) {
	$conn = open_connection();
	if(!mysql_query($query, $conn)) {
		$msg = "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing <br>\n$query\n<br>";
		logError("SQL_error_log.txt", -1, $msg);
	}
}
?>

