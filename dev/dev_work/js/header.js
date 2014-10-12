
/**
 * calls logout script
 * @method logout
 */
function logout(){
	try{
		$.ajax({
			url:"../logout.php"
		});
	}
	catch(e){
		log("header.js", e.lineNumber, e);
	}
}

var timeout	= 500;
var closetimer	= 0;
var ddmenuitem	= 0;

/**
 * open hidden layer
 * @method mopen
 * @param {int} id
 */
function mopen(id)
{
	try{
		// cancel close timer
		mcancelclosetime();

		// close old layer
		if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';

		// get new layer and show it
		ddmenuitem = document.getElementById(id);
		ddmenuitem.style.visibility = 'visible';
	}
	catch(e){
		log("header.js", e.lineNumber, e);
	}
}
/**
 * close showed layer
 * @method mclose
 */
function mclose()
{
	try{
		if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';
	}
	catch(e){
		log("header.js", e.lineNumber, e);
	}
}

/**
 * go close timer
 * @method mclosetime
 */
function mclosetime()
{
	try{
		closetimer = window.setTimeout(mclose, timeout);
	}
	catch(e){
		log("header.js", e.lineNumber, e);
	}
}

/**
 * cancel close timer
 * @method mcancelclosetime
 */
function mcancelclosetime()
{
	try{
		if(closetimer)
		{
			window.clearTimeout(closetimer);
			closetimer = null;
		}
	}
	catch(e){
		log("header.js", e.lineNumber, e);
	}
}

// close layer when click-out
document.onclick = mclose; 
