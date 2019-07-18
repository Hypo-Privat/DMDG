/*Hier wird nach aufruf (click) tableNew
 * das Formular zum korrigieren der Dokumentinfos des letzten Tables angezeigt
 * Nach absenden des Formulars werden die Daten
 * in TDOCTAB, TDOCCOL und TDOCVER gespeichert
 * Ebensi werden in Zukunft dir Comment on Felder für
 * SYSTables uns SYSCOLUMNS gespeichert
 * Rücksprung auf tablelist.html
 */
/*verwendung von local storage macht das ganze einfacher
 window.localStorage.setItem('env', 'DEVE');
 window.localStorage.setItem('database', 'DDESS00');
 window.localStorage.setItem('table', 'TUCC0001');
 */

//einlesen der Requset Daten
/*
 var env = window.localStorage.getItem('env');
 var database = window.localStorage.getItem('database');
 var table = window.localStorage.getItem('table');
 table = table.toUpperCase(table); //transform to uppercase
 */
//Globale Variabele für Verarbeitung
/*
var TableColumn = [];
var TableColumnName = [];
var VersionColumn = [];
var newVersion = '';
*/
var i = 0;
var colNr = 0;
var maxColNr = 0;
window.localStorage.setItem('colNr', colNr);
window.localStorage.setItem('maxColNr', colNr);

const heute = new Date(); 
var monat = heute.getMonth(); //startet bei 0
var monat = monat + 1;
var datum= (heute.getFullYear() + '-' + (monat) + '-' +   heute.getDate() + ' ' +   heute.getHours() + 'h ' +  heute.getMinutes());
var timestamp = Math.floor(Date.now() / 1000);

$('.NewInfo').html(Sprache.new_info)

function TableRequest(call) {
	// alert('TableRequest' + call);

	var f = document.call;

	var func = document.getElementById("func").value;
	var table = document.getElementById("table").value;
	// alert('func = ' + func + ' tablereq = ' + table);
	window.localStorage.setItem('func', func);
	window.localStorage.setItem('table', table);
}

// einlesen der Requset Daten
var env = window.localStorage.getItem('env');
var database = window.localStorage.getItem('database');
var table = window.localStorage.getItem('table');
// table = table.toUpperCase(table); //transform to uppercase

// alert(table);
//<form id="printJS-form"  method="get" accept-charset="utf-8" onsubmit="TableRequest(' + "'" + $todo + "'" + ')">'
$todo = 'NewTable'
$('.NewTable')
		.html( ' <form id="NewTable"  method="get" accept-charset="utf-8" onsubmit="TableRequest(' + "'" + $todo + "'" + ')">'
				+ '<input type="hidden" id="func" value="saveTable">'
						+ ' <table border="1"  width="100%"><colgroup>'
						+ ' <col style="background-color: gray" width="10%"> '
						+ ' <col style="background-color: lightgray" width="25%"> '
						+ ' <col style="background-color: gray" width="10%"> '
						+ ' <col style="background-color: lightgray" width="25%"> '
						+ ' <col style="background-color: gray" width="10%"> '
						+ ' <col style="background-color: lightgray" width="25%"> '
						+ '</colgroup><tbody>'

						+ '<tr><td>' + Sprache.owner + '</td>'
						+ ' <td><input type="text" maxlength="30" id="TOWNER" value="" placeholder="owner"></td>'
						+ '<td>' + Sprache.responsible + '</td>'
						+ ' <td><input type="text" maxlength="30" id="DBA" value="" placeholder="DBA"></td>'

						+ '<td>' + Sprache.department + '</td>'
						+ ' <td><input type="text" maxlength="20" id="TDOMAIN" value="" placeholder="DOMAIN"></td></tr>'

						+ '<tr> <td>' + Sprache.db + '</td>'
						+ ' <td><input type="text" id="DATABASE" maxlength="20" value="" placeholder="database"></td>'
						+ '<td>' + Sprache.ts + '</td>'
						+ ' <td><input type="text" id="TBSPACE" maxlength="20" value="" placeholder="TBSPACE"></td>'
						+ '</td><td>' + Sprache.entity + '</td>'
						+ '  <td><input type="text" id="NAME" maxlength="20" value="Tabelle" placeholder="Tabelle"></td></tr>'
						/* */

						+ '<tr><td>' + Sprache.housekeeping + '</td>'
						+ '<td><select id="THOUSEKEEPING"><option selected value="y">yes</option><option value="y">yes</option><option value="n">no</option></select></td>'
						+ '<td>' + Sprache.houserules + '</td>'
						+ ' <td> <input type="text" id="THOUSE_RULES" maxlength="20"  value="" placeholder=""> </td>'
						+ '<td>' + Sprache.reloadtyp + '</td>'
						+ '<td><input type="text" id="TREL_TYPE" maxlength="30" value="" placeholder="TREL_TYPE"></td></tr>'

						+ '<tr><td>' + Sprache.cid + '</td>'
						+ '<td><select id="TCID"><option selected value="y">yes</option><option value="y">yes</option><option value="n">no</option></select></td>'

						+ '<td>' + Sprache.cidrules + '</td> <td>'
						+ ' <input type="text" id="TCID_RULES" maxlength="20" value="" placeholder="TCID_RULES"></td>'

						+ '<td>' + Sprache.reloadrules + '</td> <td>'
						+ '<input type="text" id="TREL_RULES" maxlength="20" value="" placeholder="TREL_RULES"></td></tr>'

						+ '<tr><td>' + Sprache.ucc + '</td> <td>'
						+ '<select id="TUSE_UCC"><option selected value="n">no</option><option value="o">ohne</option><option value="y">yes</option><option value="n">no</option></select></td>'
						+ '<td>' + Sprache.ods+ '</td> <td>'
						+ '<select id="TUSE_ODS"><option selected value="o">ohne</option><option value="o">ohne</option><option value="y">yes</option><option value="n">no</option></select></td>'
						+ '<td>' + Sprache.dep + '</td> <td>'
						+ '<select id="TUSE_DEP_MANAGER"><option selected value="o">ohne</option><option value="o">ohne</option><option value="y">yes</option><option value="n">no</option></select></td></tr>'

						+ '<tr><td>' + Sprache.cwf + '</td> <td>'
						+ '<select id="TUSE_CWF"><option selected value="o">ohne</option><option value="o">ohne</option><option value="y">yes</option><option value="n">no</option></select></td>'
						+ '<td>' + Sprache.iwf + '</td> <td>'
						+ '<select id="TUSE_IWF"><option selected value="o">ohne</option><option value="o">ohne</option><option value="y">yes</option><option value="n">no</option></select></td>'
						+ '<td>Use in OC Workflow</td> <td>'
						+ '<select id="TUSE_OWF"><option selected value="o">ohne</option><option value="o">ohne</option><option value="y">yes</option><option value="n">no</option></select></td></tr>'

						+ '<tr><td>' + Sprache.remarks + '</td> <td>' // option wäre
						// Remarks zu
						// holen
						+ '<input type="text" id="TDESCRIPTION" maxlength="50" value="" placeholder="TDESCRIPTION"></td>'

						+ '<td>' + Sprache.buinfo + '</td> <td>'
						+ ' <textarea id="TENTITY_DESCRIPTION"  value="" cols="35" rows="2" maxlength="6000" >TENTITY_DESCRIPTION</textarea> </td>'
						+ '<td>' + Sprache.today + '</td> <td>'+ datum +'</td></tr>'
						+ '</tbody></table><br>'

		//hier version input
						
						+ '<table border="1" ><colgroup>'
						+ '<col style="background-color: lightgray" width="10%"> '
						+ '<col  width="10%"> '
						+ ' <col  width="70%"> '
						+ ' <col width="10%"> '
						+ '<col  width="10%"> '
						+ '</colgroup><thead style="background-color: gray"><th>' + Sprache.version + '</th><th>' + Sprache.changedate + '</th>'
						+ '<th>' + Sprache.changedescr + '</th><th>' + Sprache.responsible + '</th><th>' + Sprache.changenumber + '</th></thead>'
						+ '<tbody><tr>'
						+ '<input type="hidden" id="VER_TBNAME" value="' + table + '">'
						+ '<td><input type="text" id="VER_NR" maxlength="10" value=" " placeholder="VER_NR"></td>'
						+ '<td><input type="date" id="VER_CHANGE_DATE"  value="2019-01-01" placeholder="2019-01-01"></td>'
						+ '<td><input type="text" id="VER_DESCRIPTION" maxlength="50" value="" placeholder="VER_DESCRIPTION"></td>'
						+ '<td><input type="text" id="VER_RESPONSIBLE" maxlength="30" value="" placeholder="VER_RESPONSIBLE "></td>'
						+ '<td><input type="text" id="VER_CHANGE_NR" maxlength="10" value="" placeholder="VER_CHANGE_NR"></td>'
						+ '</tr></tbody></table><br>'

//hier column input
						
						+ '<table border="1" ><colgroup>'
						+ ' <col width="5%"> '
						+ ' <col  width="5%"> '
						+ ' <col  width="5%"> '
						+ ' <col  width="5%"> '
						+ ' <col width="5%"> '
						+ ' <col width="5%"> '
						+ ' <col width="5%"> '
						+ ' <col width="5%"> '
						+ '</colgroup><thead style="background-color: gray">'
						+ '<th>' + Sprache.colname + '</th><th>' + Sprache.coltyp + '</th><th>' + Sprache.length + '</th><th>' + Sprache.key 
						+ '</th><th>' + Sprache.index +'</th><th>' + Sprache.null + '</th><th>' + Sprache.default + '</th><th>' + Sprache.cid + '</th>'
						+ '</thead><tbody><tr>'
						+ '<td><input type="text" id="COL_NAME'	+ colNr	+ '" maxlength="20" value="" placeholder="Column Name"></td>'
						+'<td><select id="COL_TYPE'	+ colNr	+ '"><option selected value="char">Char</option>'
						+'<option value="BigInt">BigInt</option>'
						+'<option value="BigSerial">BigSerial</option>'
						+'<option value="Binary">Binary</option>'
						+'<option value="Blob">Blob</option>'
						+'<option value="Byte">Byte</option>'
						+'<option value="Char">Char</option>'
						+'<option value="Clob">Clob</option>'
						+'<option value="Date">Date</option>'
						+'<option value="DateTime">DateTime</option>'
						+'<option value="DbClob">DbClob</option>'
						+'<option value="Decimal">Decimal</option>'
						+'<option value="DecimalFloat">DecimalFloat</option>'
						+'<option value="Double">Double</option>'
						+'<option value="Float">Float</option>'
						+'<option value="Graphic">Graphic</option>'
						+'<option value="Integer">Integer</option>'
						+'<option value="Int8">Int8</option>'
						+'<option value="LongVarBinary">LongVarBinary</option>'
						+'<option value="LongVarGraphic">LongVarGraphic</option>'
						+'<option value="Money">Money</option>'
						+'<option value="Numeric">Numeric</option>'
						+'<option value="Real">Real</option>'
						+'<option value="Real370">Real370</option>'
						+'<option value="RowId">RowId</option>'
						+'<option value="Serial">Serial</option>'
						+'<option value="Serial8">Serial8</option>'
						+'<option value="SmallInt">SmallInt</option>'
						+'<option value="Text">Text</option>'
						+'<option value="Time">Time</option>'
						+'<option value="Timestamp">Timestamp</option>'
						+'<option value="VarBinary">VarBinary</option>'
						+'<option value="VarChar">VarChar</option>'
						+'<option value="VarGraphic">VarGraphic</option>'
						+'<option value="Xml">Xml</option>'
						+'</select></td>'

						+ '<td><input type="text" id="COL_LENGTH'	+ colNr	+ '" maxlength="10" value="32.6" placeholder="32.6"></td>'
						+ '<td><select id="COL_KEY' + colNr	+  '"><option selected value="no">no</option><option value="pk">pk</option><option value="fk">fk</option></select></td>'
						+ '<td><select id="COL_INDEX' + colNr	+  '"><option selected value="n">no</option><option value="y">yes</option><</select></td>'
						
						+ '<td><select id="COL_NULLS' + colNr + '"><option selected value="n">no</option><option value="y">yes</option><option value="n">no</option></select></td>'
						+ '<td><input type="text" id="COL_DEFAULT'	+ colNr	+ '" maxlength="20" value="" placeholder="Current Timestamp"></td>'
						+ '<td><select id="COL_CID' + colNr + '"><option selected value="n">no</option><option value="y">yes</option><option value="n">no</option></select></td>'
					
						+ '</tr><tr><thead style="background-color: gray">'
						+ '<th colspan = "4">' + Sprache.fielddescr + '</th><th colspan="4">' + Sprache.buinfo + '</th></thead></tr>'
						
						+ '<tr style="background-color: white"><td colspan = "4"><input type="text" id="COL_DESCRIPTION'+ colNr	+ '" size="60" maxlength="200" value="" placeholder="COL_DESCRIPTION"></td>'
						+ '<td colspan = "4"> <textarea id="COL_INFO'	+ colNr + '"  value="" cols="70" rows="2" maxlength="3000" >COL_INFO </textarea> </td>'																
						+ '</tr></tbody></table>'
						
						+ '<a style="color:red" id="addCol" >New Column</a>'
					   // + '<br>	<b><input type="submit"  value="Request Table" >'
						+ '<br><button onclick="javascript:demoFromHTML();">Save PDF</button></b>'
						//+ '<br><input type="button" value="Print Div Contents" id="btnPrint" /></b>'
						//+ '<br><button type="button "onclick="printJS(' + "./input/'" + printjs.pdf + "'" + ')">Print PDF	</button>'
						+'</form></b>'
					);

// Ausgeben Change Version
// alert(vers );

$(document).ready(function() {$('#addCol').click(
									function() {
										// alert("addCol");
										var colNr = window.localStorage.getItem('colNr');
										var table = window.localStorage.getItem('table');
										colNr++ ;
										$(this).before('<input type="hidden" id="func" value="NewColumn">'
												+ '<table border="1" width="100%">'
												+ ' <colgroup><col  width="5%"> '
												+ ' <col  width="5%"> '
												+ ' <col  width="5%"> '
												+ ' <col  width="5%"> '
												+ ' <col width="5%"> '
												+ ' <col width="5%"> '
												+ ' <col width="5%"> '
												+ ' <col width="5%"> </colgroup>'
												+ '<tbody><tr>'
												+ '<td><input type="text" id="COL_NAME'	+ colNr	+ '" maxlength="20" value="" placeholder="Column Name"></td>'
												+'<td><select id="COL_TYPE'	+ colNr	+ '"><option selected value="char">Char</option>'
												+'<option value="BigInt">BigInt</option>'
												+'<option value="BigSerial">BigSerial</option>'
												+'<option value="Binary">Binary</option>'
												+'<option value="Blob">Blob</option>'
												+'<option value="Byte">Byte</option>'
												+'<option value="Char">Char</option>'
												+'<option value="Clob">Clob</option>'
												+'<option value="Date">Date</option>'
												+'<option value="DateTime">DateTime</option>'
												+'<option value="DbClob">DbClob</option>'
												+'<option value="Decimal">Decimal</option>'
												+'<option value="DecimalFloat">DecimalFloat</option>'
												+'<option value="Double">Double</option>'
												+'<option value="Float">Float</option>'
												+'<option value="Graphic">Graphic</option>'
												+'<option value="Integer">Integer</option>'
												+'<option value="Int8">Int8</option>'
												+'<option value="LongVarBinary">LongVarBinary</option>'
												+'<option value="LongVarGraphic">LongVarGraphic</option>'
												+'<option value="Money">Money</option>'
												+'<option value="Numeric">Numeric</option>'
												+'<option value="Real">Real</option>'
												+'<option value="Real370">Real370</option>'
												+'<option value="RowId">RowId</option>'
												+'<option value="Serial">Serial</option>'
												+'<option value="Serial8">Serial8</option>'
												+'<option value="SmallInt">SmallInt</option>'
												+'<option value="Text">Text</option>'
												+'<option value="Time">Time</option>'
												+'<option value="Timestamp">Timestamp</option>'
												+'<option value="VarBinary">VarBinary</option>'
												+'<option value="VarChar">VarChar</option>'
												+'<option value="VarGraphic">VarGraphic</option>'
												+'<option value="Xml">Xml</option>'
												+'</select></td>'
											
												+ '<td><input type="text" id="COL_LENGTH'	+ colNr	+ '" maxlength="4" value="32.6" placeholder="32.6"></td>'
												+ '<td><select id="COL_KEY' + colNr	+  '"><option selected value="no">no</option><option value="pk">pk</option><option value="fk">fk</option></select></td>'
												+ '<td><select id="COL_INDEX' + colNr +  '"><option selected value="n">no</option><option value="y">yes</option><</select></td>'
												+ '<td><select id="COL_NULLS' + colNr + '"><option selected value="n">no</option><option value="y">yes</option><option value="n">no</option></select></td>'
												+ '<td><input type="text" id="COL_DEFAULT'	+ colNr	+ '" maxlength="20" value="Current Timestamp" placeholder="Current Timestamp"></td>'
												+ '<td><select id="COL_CID' + colNr + '"><option selected value="n">no</option><option value="y">yes</option><option value="n">no</option></select></td>'
												+'</tr><tr>'
												+ '<tr style="background-color: white"><td colspan = "4"><input type="text" id="COL_DESCRIPTION'+ colNr	+ '" size="60" maxlength="200" value="" placeholder="COL_DESCRIPTION"></td>'
												+ '<td colspan = "4"> <textarea id="COL_INFO'	+ colNr + '"  value="" cols="70" rows="2" maxlength="3000" >COL_INFO </textarea> </td>'																
												+ '</tr></tbody></table>'
										);
										//alert("colNr - in Func " + colNr +  " -- " + this);
										window.localStorage.setItem('colNr', colNr);
										window.localStorage.setItem('maxColNr', colNr);
							});
				});

function TableRequest(todo) {
	print();
	// alert('TableRequest = ' + todo);
	 var f = document;				
	
	 // all var for Table definition
	 	var TIMESTAMP = timestamp;
		var NAME = document.getElementById("NAME").value;
	
		var TOWNER = document.getElementById("TOWNER").value;
		var DBA = document.getElementById("DBA").value;
		var TDOMAIN = document.getElementById("TDOMAIN").value;
		var DATABASE = document.getElementById("DATABASE").value;
		var TBSPACE = document.getElementById("TBSPACE").value;
	
		var THOUSEKEEPING = document.getElementById("THOUSEKEEPING").value;
		var THOUSE_RULES = document.getElementById("THOUSE_RULES").value;
		var TREL_TYPE = document.getElementById("TREL_TYPE").value;
		var TREL_RULES = document.getElementById("TREL_RULES").value;
		var TCID = document.getElementById("TCID").value;
		var TCID_RULES = document.getElementById("TCID_RULES").value;
		var TUSE_UCC = document.getElementById("TUSE_UCC").value;
		var TUSE_ODS = document.getElementById("TUSE_ODS").value;
		var TUSE_DEP_MANAGER = document.getElementById("TUSE_DEP_MANAGER").value;
		var TUSE_CWF = document.getElementById("TUSE_CWF").value;
		var TUSE_IWF = document.getElementById("TUSE_IWF").value;
		var TUSE_OWF = document.getElementById("TUSE_OWF").value;
		var TDESCRIPTION = document.getElementById("TDESCRIPTION").value;
		var TENTITY_DESCRIPTION = document.getElementById("TENTITY_DESCRIPTION").value;

	
		var NewTable = ("&NAME=" + NAME + "&TOWNER=" + TOWNER + "&DBA=" + DBA
				+ "&TDOMAIN=" + TDOMAIN  + "&DATABASE=" + DATABASE + "&TBSPACE=" + TBSPACE
				+ "&THOUSEKEEPING=" + THOUSEKEEPING + "&THOUSE_RULES=" + THOUSE_RULES
				+ "&TREL_TYPE=" + TREL_TYPE + "&TREL_RULES=" + TREL_RULES
				+ "&TCID=" + TCID + "&TCID_RULES=" + TCID_RULES
				+ "&TUSE_UCC=" + TUSE_UCC + "&TUSE_ODS=" + TUSE_ODS
				+ "&TUSE_DEP_MANAGER=" + TUSE_DEP_MANAGER + "&TUSE_CWF="
				+ TUSE_CWF + "&TUSE_IWF=" + TUSE_IWF + "&TUSE_OWF=" + TUSE_OWF
				+ "&TDESCRIPTION=" + TDESCRIPTION + "&TENTITY_DESCRIPTION=" + TENTITY_DESCRIPTION + "&TIMESTAMP=" + TIMESTAMP);

		//alert ("NewTable = " + NewTable );
	
		//all Var for Version
		var VER_TBNAME = document.getElementById("VER_TBNAME").value;
		var VER_CHANGE_DATE = document.getElementById("VER_CHANGE_DATE").value;
		var VER_CHANGE_NR = document.getElementById("VER_CHANGE_NR").value;
		var VER_NR = document.getElementById("VER_NR").value;
		var VER_DESCRIPTION = document.getElementById("VER_DESCRIPTION").value;
		var VER_RESPONSIBLE = document.getElementById("VER_RESPONSIBLE").value;

		var NewVersion = ("&VER_TBNAME=" + VER_TBNAME + "&VER_CHANGE_DATE="
				+ VER_CHANGE_DATE + "&VER_CHANGE_NR=" + VER_CHANGE_NR
				+ "&VER_NR=" + VER_NR + "&VER_DESCRIPTION=" + VER_DESCRIPTION
				+ "&VER_RESPONSIBLE=" + VER_RESPONSIBLE);
		//alert ("NewVersion = " + NewVersion );
		
		//all Var for Columns
		var maxColNr = window.localStorage.getItem('maxColNr');
		//alert ("maxColNr= " + maxColNr);
		while (i <= maxColNr) {
			var COL_NAME = 'COL_NAME' + i;
			var COL_TYPE = 'COL_TYPE' + i;
			var COL_LENGTH = 'COL_LENGTH' + i;
			var COL_KEY = 'COL_KEY' + i;
			var COL_NULLS = 'COL_NULLS' + i;
			var COL_INDEX = 'COL_INDEX' + i;			
			var COL_DEFAULT = 'COL_DEFAULT' + i;
			var COL_CID = 'COL_CID' + i;
			var COL_INFO = 'COL_INFO' + i;
			var COL_DESCRIPTION = 'COL_DESCRIPTION' + i;
			//alert ("ColumnName  = " + COL_NAME + "i = " + i);
			
			var COL_TBNAME = document.getElementById("NAME").value;
			var COL_NAME = document.getElementById(COL_NAME).value;
			var COL_TYPE = document.getElementById(COL_TYPE).value;
			var COL_LENGTH = document.getElementById(COL_LENGTH).value;
			var COL_KEY = document.getElementById(COL_KEY).value;
			var COL_NULLS = document.getElementById(COL_NULLS).value;
			var COL_INDEX = document.getElementById(COL_INDEX).value;		
			var COL_DEFAULT = document.getElementById(COL_DEFAULT).value;
			var COL_CID = document.getElementById(COL_CID).value;
			var COL_INFO = document.getElementById(COL_INFO).value;
			var COL_DESCRIPTION = document.getElementById(COL_DESCRIPTION).value;
			//alert ("COL_NAME contend = " + COL_NAME + " i = " + i );
	
			var NewCol =   (NewCol + "&COL_NAME"+i+"=" + COL_NAME + "&COL_TYPE"+i+"="	+ COL_TYPE 
					 + "&COL_LENGTH"+i+"="	+ COL_LENGTH  + "&COL_LENGTH"+i+"="	+ COL_LENGTH  
					 + "&COL_KEY"+i+"="	+ COL_KEY  + "&COL_NULLS="+i+"="+ COL_NULLS 
					 + "&COL_INDEX"+i+"="	+ COL_INDEX  + "&COL_DEFAULT"+i+"="	+ COL_DEFAULT  
					+ "&COL_CID"+i+"=" + COL_CID + "&COL_INFO"+i+"=" + COL_INFO
					+ "&COL_DESCRIPTION"+i+"=" + COL_DESCRIPTION + "&COL_NO"+i+"=" + i + "&TIMESTAMP=" + TIMESTAMP );
			//alert('NewCol ' + NewCol );
			i++;		
		} // while
		
		
		var allData = ("function=saveTable&env=deve"  + NewTable + NewVersion + NewCol);
		// alert ("allData = " + allData);
		newTable(allData); 	// write to database
}

function newTable(allData) {
	//alert("NewTable = " + allData);
	$.ajax({
		type : "get",
		url : "./php/TableNew.php",
		data : allData,
		contentType : "application/json", // charset=utf-8", // Set
		dataType : 'json',
		jsonCallback : 'getJson',
		async : false,
		success : function() {
				// alert("success : function() =" + allData);
				// window.location.assign = "UserProfil.html";
		},
		error : function() {
				//alert("error: tableNew.js to php/TableNew.php?" + allData);
				// window.location.assign = "index.html#cta";
		}
	});

}
