/* configuratio
 * here we will setup the configuration parms for the tool
 * Define all information what are needed to work with DMDG Tool
 */
const heute = new Date(); 
var monat = heute.getMonth(); //startet bei 0
var monat = monat + 1;
var datum = (heute.getFullYear() + '-' + (monat) + '-' +   heute.getDate() + ' ' +   heute.getHours() + 'h ' +  heute.getMinutes());

var colNr = 0;
var maxColNr = 0;
window.localStorage.setItem('colNr', colNr);
window.localStorage.setItem('maxColNr', colNr);

$('.WelcomeInfo').html(Sprache.welcome_config)


// einlesen der Requset Daten
var env = window.localStorage.getItem('env');
var database = window.localStorage.getItem('database');
var table = window.localStorage.getItem('table');
// table = table.toUpperCase(table); //transform to uppercase

// alert(table);
//<form id="printJS-form"  method="get" accept-charset="utf-8" onsubmit="SaveConfig(' + "'" + $todo + "'" + ')">'

$('.Config')
		.html( ' <form id="Config"  method="get" accept-charset="utf-8" onsubmit="SaveConfig(' + "'" + datum + "'" + ')">'
				+ '<input type="hidden" id="func" value="writeConf">'
						+ ' <table border="1"  width="100%"><colgroup>'
						+ ' <col style="background-color: gray" width="10%"> '
						+ ' <col style="background-color: lightgray" width="25%"> '
						+ ' <col style="background-color: gray" width="10%"> '
						+ ' <col style="background-color: lightgray" width="25%"> '
						+ ' <col style="background-color: gray" width="10%"> '
						+ ' <col style="background-color: lightgray" width="25%"> '
						+ '</CONFgroup><tbody>'

						+ '<tr><td>' + Sprache.configowner + '</td>'
						+ ' <td><input type="text" maxlength="30" id="CONF_OWNER'	+ colNr	+ '" value="" placeholder="owner"></td>'
						+ '<td>' + Sprache.configmail + '</td>'
						+ ' <td><input type="text" maxlength="30" id="CONF_MAIL'	+ colNr	+ '" value="" placeholder="owner@email.com"></td>'

						+ '<td>' + Sprache.configdep + '</td>'
						+ ' <td><input type="text" maxlength="20" id="CONF_DEP'	+ colNr	+ '" value="" placeholder="UCC"></td></tr>'

						+ '</tbody></table><br>'
//hier DBconfig input
						 
						+ '<table border="1" width="100%"><thead style="background-color: gray">'
						+ '<th>' + Sprache.configenv + '</th><th>' + Sprache.configdbtype + '</th><th>' + Sprache.confighost + '</th><th>' + Sprache.configport 
						+ '</th><th>' + Sprache.configdrtype + '</th><th>' + Sprache.configdriver + '</th><th>' + Sprache.configdb +'</th><th>' + Sprache.configuser + '</th><th>' + Sprache.configpw + '</th>'
						+ '</thead><tbody><tr>'
						+ '<input type="hidden" id="CONF_LINE'	+ colNr	+ '" maxlength="10" value="'	+ colNr	+ '" >'
						+ '<td><input type="text" id="CONF_ENV'	+ colNr	+ '" maxlength="10" value="" size="10" placeholder="TestEnv"></td>'
						+'<td><select id="CONF_DBTYPE'	+ colNr	+ '"><option selected value="db2zos">Db2 z/OS</option>'	 +'<option value="db2win">Db2 WIN</option>' +'<option value="db2ux">Db2 UNIX</option>'
						+'<option value="oraux">Oracle UNIX</option>'+'<option value="oraWIN">Oracle WIN</option>'+'</select></td>'
						+ '<td><input type="text" id="CONF_HOST'+ colNr	+ '" maxlength="128" value="" placeholder="127.0.0.1"></td>'
						+ '<td><input type="tel" id="CONF_PORT' + colNr	+ '" maxlength="6" size="6" value="" placeholder="50000"></td>'
						+'<td><select id="CONF_DRTYPE'	+ colNr	+ '"><option selected value="jdbc">jdbc</option>'
						+'<option value="odbc">odbc</option>'+'</select></td>'
						+ '<td><input type="text" id="CONF_DRVORT' + colNr	+ '" maxlength="128" value="" placeholder="../cli/lib/libdb2.so"></td>'
						
						+ '<td><input type="text" id="CONF_ENVDB' + colNr	+ '" maxlength="20" size="10"value="" placeholder="Sample"></td>'	
						+ '<td><input type="text" id="CONF_ENVUSER'	+ colNr	+ '" maxlength="20" value="" placeholder="User ID"></td>'
						+ '<td><input type="password" id="CONF_ENVPW'	+ colNr	+ '" maxlength="20" value="" placeholder="Password"></td>'	
						+ '</tr></tbody></table>'
						
						+ '<a style="color:red" id="addCONF" >New Entry</a>'
					   // + '<br>	<b><input type="submit"  value="Request Table" >'
						
						+ '<br><button onclick="javascript:demoFromHTML();">Save Config</button></b>'
						//+ '<br><input type="button" value="Print Div Contents" id="btnPrint" /></b>'
						//+ '<br><button type="button "onclick="printJS(' + "./input/'" + printjs.pdf + "'" + ')">Print PDF	</button>'
						+'</form></b>'
					);


//Ausgeben Change Version
//alert(vers );

$(document).ready(function() {$('#addCONF').click(
									function() {
										// alert("addCol");
										var colNr = window.localStorage.getItem('colNr');
										colNr++ ;
										$(this).before('<table border="1" width="100%"><thead style="background-color: gray">'
												+ '<th>' + Sprache.configenv + '</th><th>' + Sprache.configdbtype + '</th><th>' + Sprache.confighost + '</th><th>' + Sprache.configport 
												+ '</th><th>' + Sprache.configdrtype + '</th><th>' + Sprache.configdriver + '</th><th>' + Sprache.configdb +'</th><th>' + Sprache.configuser + '</th><th>' + Sprache.configpw + '</th>'
												+ '</thead><tbody><tr>'
												+ '<input type="hidden" id="CONF_LINE'	+ colNr	+ '" maxlength="10" value="'	+ colNr	+ '" >'
												+ '<td><input type="text" id="CONF_ENV'	+ colNr	+ '" maxlength="10" value="" size="10" placeholder="TestEnv"></td>'
												+'<td><select id="CONF_DBTYPE'	+ colNr	+ '"><option selected value="db2zos">Db2 z/OS</option>'	 +'<option value="db2win">Db2 WIN</option>' +'<option value="db2ux">Db2 UNIX</option>'
												+'<option value="oraux">Oracle UNIX</option>'+'<option value="oraWIN">Oracle WIN</option>'+'</select></td>'
												+ '<td><input type="text" id="CONF_HOST'+ colNr	+ '" maxlength="128" value="" placeholder="127.0.0.1"></td>'
												+ '<td><input type="tel" id="CONF_PORT' + colNr	+ '" maxlength="6" size="6" value="" placeholder="50000"></td>'
												+'<td><select id="CONF_DRTYPE'	+ colNr	+ '"><option selected value="jdbc">jdbc</option>'
												+'<option value="odbc">odbc</option>'+'</select></td>'
												+ '<td><input type="text" id="CONF_DRVORT' + colNr	+ '" maxlength="128" value="" placeholder="../cli/lib/libdb2.so"></td>'
												
												+ '<td><input type="text" id="CONF_ENVDB' + colNr	+ '" maxlength="20" size="10"value="" placeholder="Sample"></td>'	
												+ '<td><input type="text" id="CONF_ENVUSER'	+ colNr	+ '" maxlength="20" value="" placeholder="User ID"></td>'
												+ '<td><input type="password" id="CONF_ENVPW'	+ colNr	+ '" maxlength="20" value="" placeholder="Password"></td>'	
												+ '</tr></tbody></table>'
										);
										//alert("colNr - in Func " + colNr +  " -- " + this);
										window.localStorage.setItem('colNr', colNr);
										window.localStorage.setItem('maxColNr', colNr);
							});
				});
function SaveConfig(datum) {
//	//print();
	//alert('SaveConfig = ' + datum);
	 var f = document;				
	 var i = 0;
	 // all var for Table definition
		var CONF_OWNER = document.getElementById("CONF_OWNER0").value;	
		var CONF_MAIL = document.getElementById("CONF_MAIL0").value;	
		var CONF_DEP = document.getElementById("CONF_DEP0").value;
		
		var NewCONF =   ("function=writeConf"  + "&CONF_DATE"+i+"=" + datum + "&CONF_OWNER"+i+"="	+ CONF_OWNER 
				 + "&CONF_MAIL"+i+"="	+ CONF_MAIL  + "&CONF_DEP"+i+"="	+ CONF_DEP );
		//alert('NewCONF = ' + NewCONF);
		//write to file
		//WriteConfig(NewCONF);
		
		
		//all Var for CONFIGURATIO Environments
		var maxColNr = window.localStorage.getItem('maxColNr');

		//alert ("maxColNr= " + maxColNr);
		while (i <= maxColNr) {
			//alert (i + " - maxColNr= " + maxColNr);
			var CONF_LINE = 'CONF_LINE' + i;
			var CONF_ENV = 'CONF_ENV' + i;
			var CONF_DBTYPE= 'CONF_DBTYPE' + i;
			var CONF_HOST = 'CONF_HOST' + i;
			var CONF_PORT = 'CONF_PORT' + i;
			var CONF_DRTYPE= 'CONF_DRTYPE' + i;
			var CONF_DRVORT = 'CONF_DRVORT' + i;			
			var CONF_ENVDB = 'CONF_ENVDB' + i;
			var CONF_ENVUSER = 'CONF_ENVUSER' + i;
			var CONF_ENVPW = 'CONF_ENVPW' + i;
		
			
			var CONF_LINE = document.getElementById(CONF_LINE).value;
			var CONF_ENV = document.getElementById(CONF_ENV).value;
			var CONF_DBTYPE= document.getElementById(CONF_DBTYPE).value;
			var CONF_HOST = document.getElementById(CONF_HOST).value;
			var CONF_PORT = document.getElementById(CONF_PORT).value;
			var CONF_DRTYPE= document.getElementById(CONF_DRTYPE).value;
			var CONF_DRVORT = document.getElementById(CONF_DRVORT).value;		
			var CONF_ENVDB = document.getElementById(CONF_ENVDB).value;
			var CONF_ENVUSER = document.getElementById(CONF_ENVUSER).value;
			var CONF_ENVPW = document.getElementById(CONF_ENVPW).value;
			
			//alert ("CONF_LINE = " + CONF_LINE + "i = " + i);
	
			var NewCONF =   (NewCONF  + "&CONF_LINE"+i+"=" + CONF_LINE + "&CONF_DATE"+i+"=" + datum 
					+ "&CONF_ENV"+i+"=" + CONF_ENV 	+ "&CONF_DBTYPE"+i+"="	+ CONF_DBTYPE
					+ "&CONF_HOST"+i+"="	+ CONF_HOST  + "&CONF_PORT"+i+"="	+ CONF_PORT  
					+ "&CONF_DRTYPE"+i+"="	+ CONF_DRTYPE  + "&CONF_DRVORT"+i+"=" + CONF_DRVORT 
					+ "&CONF_ENVDB"+i+"="	+ CONF_ENVDB  + "&CONF_ENVUSER"+i+"="	+ CONF_ENVUSER  
					+ "&CONF_ENVPW"+i+"=" + CONF_ENVPW  );
			//alert('NewCONF ' + NewCONF );
			//write line
			
			i++;		
		} // while	
		WriteConfig(NewCONF);
}

function WriteConfig(line) {
	//alert("WriteConfig = " + line);
	$.ajax({
		type : "get",
		url : "./php/Config.php",
		data : line,
		contentType : "application/json", // charset=utf-8", // Set
		dataType : 'json',
		jsonCallback : 'getJson',
		async : false,
		success : function() {
				// alert("success : function() =" + allData);				
		},
		error : function() {
				alert("error: configuration.js to php/Config.php?" + line);				
		}
	});
	/*
	 * 

	
	// alert( "WriteConfig(line) = " + line);
	 if (window.File && window.FileReader && window.FileList && window.Blob) {
		 alert('Great success! All the File APIs are supported..');
		  // Great success! All the File APIs are supported.
		} else {
		  alert('The File APIs are not fully supported in this browser.');
		}
	
	var fh = fopen('../locale/config.txt', 3); // Open the file for writing

	if(fh!=-1)
	
	 // If the file has been successfully opened
	{
		alert("If the file has been successfully opened " + line);
	    var str = "Some text goes here..." + line;
	    fwrite(fh, str); // Write the string to a file
	    fclose(fh); // Close the file
	} else {
		alert(fh + "Error open File = " + fh);
		}
	
	*/

}