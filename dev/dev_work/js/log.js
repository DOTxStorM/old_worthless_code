/**
* Author: John Murrill
* Date: 4/20/2014
* last updated: 5/1/2014
* 
* 
* used to log errors
* @class log
*/

//testing variable
var log_is_testing = false;

/**function takes a file name, line number of an error, and the error as an input and sending them to the database
 *by ajax command. has a toggle-able alert for testing purposes.
 *@method log
 *@param {string} file
 *@param {int} line number
 *@param {string} error
 */
function log(file, line_number, error){	
	jQuery.post( "includes/logger.php", {file_Name: file, line_Number: line_number, exception: error} );
	if(log_is_testing){
		//alert(file + '\n\n' + line_number + '\n\n' + error);
	}
}

/*for any call of this function, put:
* log([File_Name], e.lineNumber, e);
*/