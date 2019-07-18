/*Hier wird nach aufruf (click) tableupdate
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
var env = window.localStorage.getItem('env');
var database = window.localStorage.getItem('database');
var table = window.localStorage.getItem('table');
table = table.toUpperCase(table); //transform to uppercase

//Globale Variabele für Verarbeitung
var TableColumn = [];
var VersionColumn = [];


$('.UpdateInfo').html('<h3>Please Update carefully the information from the Table<br> ' 
	+ 'You can only update the documentation.  <br>For additional fields or tablechanges please send a mail to ' 
	+ ' <a href="mailto:BSF-COS@cardcenter.ch?subject=Table correction (' + env + '.' + table + ')" target="_top">UCC DBA</a></h3>' 

	+ '<div ><b>Search a table where you like to update documentation '
	+ '<form id="TabReq"  method="get" accept-charset="utf-8" onsubmit="TableRequest(TabReq)">' 
	+ '<input type="hidden" id="func" value="TabReq">' 
	+ '<input type="text" id="table"   minlength="2" maxlength="30" size="10">' 
	+ '	<b><input type="submit"  name="mail" value="Send" ></b></form></b></div>'
);


function TableRequest(call) {
	alert('TableRequest' + call);
	
	var f = document.call;

	var func = document.getElementById("func").value;
	var table = document.getElementById("table").value;	
	//alert('func = ' + func + '   tablereq = ' + table);
	window.localStorage.setItem('func', func);
	window.localStorage.setItem('table', table);
}

//einlesen der Requset Daten
var env = window.localStorage.getItem('env');
var database = window.localStorage.getItem('database');
var table = window.localStorage.getItem('table');
table = table.toUpperCase(table);   //transform to uppercase


//alert(table);
$(document).ready(function() {
	
	var func = 'getTableDetail';
	var PHPstring = ("function=" + func + "&environment=" + env + "&database=" + database + "&table=" + table);
	//alert(PHPstring);
	$.ajax({
		type: "get",
		url: "./php/TableDetail.php",
		data: (PHPstring),
		contentype: "application/json", // charset=utf-8", // Set
		dataType: 'json',
		jsonCallback: 'getJson',
		async: false,
		success: function(data) {
			$.each(data,
				function(counter, daten) {
					$todo = 'updateTable'
					$('.UpdateDetail').html('<b> Result for Tablerequest DB.TS.TB (' 
						+ daten.CREATOR + '.' + daten.TBSPACE + '.' + daten.NAME + ')</b><br><br>' 
						+ '<form id="updateTable"  method="get" accept-charset="utf-8" onsubmit="TableUpdate('+ "'" + $todo + "'" + ')">' 
						+ '<input type="hidden" id="func" value="updateTable">' 
						+ '<input type="hidden" id="NAME" value="' + daten.NAME + '">' 
						
						+ ' <table border="1"  widtht="100%"><colgroup>' + ' <col style="background-color: gray" width="10%"> '
						+ ' <col style="background-color: lightgray" widtht="25%"> ' + ' <col style="background-color: gray" width="10%"> '
						+ ' <col style="background-color: lightgray" width="25%"> ' + ' <col style="background-color: gray" width="10%"> ' 
						+ ' <col style="background-color: lightgray" width="25%"> ' + '</colgroup><tbody>' 

						+ '<tr><td>Owner</td> <td><input type="text" id="TOWNER" value="' + daten.TOWNER + '" placeholder="' + daten.TOWNER + '"></td>' 
						+ '<td>DB Admin</td> <td>Gert Dorn</td>' 
						+ '<td>Department</td> <td><input type="text" id="TDOMAIN" value="' + daten.TDOMAIN + '" placeholder="' + daten.TDOMAIN + '"></td></tr>' 
						
						/*
							+ '	<b >Database</b><select id="database"><option selected value="o">ohne</option>' 
							+ '<option value="y">yes</option><option value="n">no</option></select>' 
						 */
						
						//no update possible
						+ '<tr> <td>Database</td> <td>' + daten.CREATOR + '</td><td>Tablespace</td> <td>' + daten.TBSPACE + '</td>' + '<td>Entity Name</td> <td>' + daten.NAME + '</td></tr>' 
						+ '<tr><td>Create Date</td> <td>' + daten.CTIME + '</td>' + '<td>Last Updated</td> <td>' + daten.ALTER_TIME + '</td>' 
						+ '<td>Table Typ</td>'
						+ '<td><input type="text" id="TTYPE" value="' + daten.TTYPE + '" placeholder="' + daten.TTYPE+ '"></td></tr>' 
						+ '<tr><td>Russtats Info</td> <td>' + daten.STATISTICS_PROFILE + '</td>' + '<td>Last Statistics</td> <td>' + daten.STATS_TIME + '</td>' + '<td>Records Actual</td> <td>' + daten.COLCOUNT + '</td></tr>' 
						
						+ '<tr><td>Housekeeping</td><td>'
						+'<select id="THOUSEKEEPING"><option selected value="' + daten.THOUSEKEEPING +'">' + daten.THOUSEKEEPING 
						+'</option><option value="o">ohne</option><option value="y">yes</option><option value="n">no</option></select></td>'
						+ '<td>Housekeeping Rules</td> <td>' 
						+' <textarea id="THOUSE_RULES"  value="' + daten.THOUSE_RULES + '" cols="35" rows="2">' + daten.THOUSE_RULES + '</textarea> </td>'
						
						
						+ '<td>Reload Type</td> ' 
						+ '<td><input type="text" id="TREL_TYPE" value="' + daten.TREL_TYPE + '" placeholder="' + daten.TREL_TYPE + '"></td></tr>' 
						
						+ '<tr><td>Contain CID</td> <td>'
						+'<select id="TCID"><option selected value="' + daten.TCID + '">' + daten.TCID 
						+'</option><option value="o">ohne</option><option value="y">yes</option><option value="n">no</option></select></td>'
						
						+ '<td>Anonymisation Rules</td> <td>' 
						+' <textarea id="TCID_RULES" name="TCID_RULES" value="' + daten.TCID_RULES + '" cols="35" rows="2">' + daten.TCID_RULES + '</textarea> </td>'
						
						+ '<td>Reload Rules</td> <td>' 
						+' <textarea id="TREL_RULES" name="TREL_RULES" value="' + daten.TREL_RULES + '" cols="35" rows="2">' + daten.TREL_RULES + '</textarea> </td></tr>'
						
					
						+ '<tr><td>Use in UCC</td> <td>'
						+'<select id="TUSE_UCC"><option selected value="' + daten.TUSE_UCC +'">' + daten.TUSE_UCC 
						+'</option><option value="o">ohne</option><option value="y">yes</option><option value="n">no</option></select></td>'
						+ '<td>Use in ODS</td> <td>' 
						+'<select id="TUSE_ODS"><option selected value="' + daten.TUSE_ODS +'">' + daten.TUSE_ODS 
						+'</option><option value="o">ohne</option><option value="y">yes</option><option value="n">no</option></select></td>'
						+ '<td>Use Department</td> <td>'
						+'<select id="TUSE_DEP_MANAGER"><option selected value="' + daten.TUSE_DEP_MANAGER +'">' + daten.TUSE_DEP_MANAGER 
						+'</option><option value="o">ohne</option><option value="y">yes</option><option value="n">no</option></select></td></tr>'
					
						+ '<tr><td>Use in Core Work Flow</td> <td>' 
						+'<select id="TUSE_CWF"><option selected value="' + daten.TUSE_CWF +'">' + daten.TUSE_CWF 
						+'</option><option value="o">ohne</option><option value="y">yes</option><option value="n">no</option></select></td>'
						+ '<td>Use in Incasso Core Work Flow</td> <td>' 
						+'<select id="TUSE_IWF"><option selected value="' + daten.TUSE_IWF +'">' + daten.TUSE_IWF 
						+'</option><option value="o">ohne</option><option value="y">yes</option><option value="n">no</option></select></td>'
						+ '<td>Use in OC Workflow</td> <td>' 
						+'<select id="TUSE_OWF"><option selected value="' + daten.TUSE_OWF +'">' + daten.TUSE_OWF 
						+'</option><option value="o">ohne</option><option value="y">yes</option><option value="n">no</option></select></td></tr>'
					
						+ '<tr><td>Table Description</td> <td>'
						+' <textarea id="TDESCRIPTION" name="DESCRIPTION" value="' + daten.TDESCRIPTION + '" cols="35" rows="2">' + daten.TDESCRIPTION + '</textarea> </td>'
						
					
						+ '<td>Busines Description </td> <td>'
						+' <textarea id="TENTITY_DESCRIPTION" name="TENTITY_DESCRIPTION" value="' + daten.TENTITY_DESCRIPTION + '" cols="35" rows="2">' + daten.TENTITY_DESCRIPTION + '</textarea> </td>'
						+ '<td>Update Date</td> <td>' + daten.TTIMESTAMP + '</td></tr>' 
						
						+ '</tbody></table>'
						+ '<br>	<b><input type="submit"  value="Update Table Documentation" ></form></b>'
					);
					
				});

			//Ausgeben Change Version
			getTableVersion(database, table, env);
			var vers = "";
			for (var i = 0, len = VersionColumn.length; i < len; i++) {
				//alert(VersionColumn[i]);
				var erg = VersionColumn[i];
				vers += erg;
			}
			//alert(vers );
			$todo = 'updateVersion'
			$('.UpdateVer').html('<form id="updateVersion"  method="get" accept-charset="utf-8" onsubmit="TableUpdate(' + "'" + $todo + "'" + ')">' 
					+ '<input type="hidden" id="func" value="updateVersion">' 
					
					+'<table border="1" "><colgroup>' 
					+ ' <col style="background-color: lightgray" width="10%"> ' 
					+ ' <col  widtht="10%"> ' + ' <col  width="70%"> ' + ' <col width="10%"> ' 
					+ ' <col  width="10%"> ' 
					+ '</colgroup><thead style="background-color: gray"><th>Version</th><th>Change Date</th>' 
					+'<th>Change Description</th><th>Responsible</th><th>Changenumber</th></thead>' 
					+ '<tbody>' + vers + '</tbody></table>'
					+ '<br>	<b><input type="submit"  value="Update Change Version" ></form></b>'
			);

			//Ausgeben Column Beschreibung			
			getTableColumns(database, table, env);
			
			//alert("before -- " + cols );
			var cols = "";
		
			for (var i = 0, len = TableColumn.length; i < len; i++) {
				//alert(TableColumn[i]);
				var erg = TableColumn[i];
				cols += erg;
			}
			//alert("after -- " + cols );
			$todo = 'updateColumn'
			$('.UpdateCol').html('<form id="updateColumn"  method="get" accept-charset="utf-8" onsubmit="TableUpdate(' + "'" + $todo + "'" + ')">' 
			+ '<input type="hidden" id="func" value="updateColumn">' 
			
			+ '<table border="1" "><colgroup>' 
				+ ' <col style="background-color: lightgray" width="10%"> ' 
				+ ' <col  widtht="5%"> ' + ' <col  width="5%"> ' 
				+ ' <col width="5%"> ' + ' <col width="20%"> ' 
				+ ' <col width="5%"> ' + ' <col width="5%"> ' 
				+ ' <col style="background-color: white" width="50%"> ' 
				+ '</colgroup><thead style="background-color: gray">' 
				+ '<th>Name</th><th>Type</th><th>NULL</th><th>Length</th><th>Busines Description</th><th>Default</th><th>CID</th><th>Information</th>' 
				+ '</thead><tbody>' + cols + '</tbody></table>'
				+ '<br>	<b><input type="submit"  value="Update Column Documentation" ></form></b>'
			);
		},
		error: function(data, req, status, err) {
			alert('Something went wrong !!! getTableDetail ' + data + " req = " + req + " status = " + status + " err = " + err);
			window.location.assign = "index.html";
		}
	});
});

function getTableColumns(database, table, env) {

	//alert("getTableColumns = "+ env + '.' + database + '.' + table);
	var i = 0;
	TableColumn = [] ;
	var func = 'getTableColumn';
	var PHPstring = ("function=" + func + "&environment=" + env + "&database=" + database + "&table=" + table);
	//alert(PHPstring);
	$.ajax({
		type: "get",
		url: "./php/TableDetail.php",
		data: (PHPstring),
		contentype: "application/json", // charset=utf-8", // Set
		dataType: 'json',
		jsonCallback: 'getJson',
		async: false,
		success: function(data) {
			$.each(data,
				function(counter, daten) {
					TableColumn[counter] = ('<tr> <td>' + daten.NAME + '</td> <td>' + daten.COLTYPE + '</td> <td>' 
							+ daten.NULLS + ' </td> <td>' + daten.LENGTH + '</td><td>' 
							+ daten.COL_DESCRIPTION + '</td><td>' + daten.COL_DEFAULT + '</td><td>' 
							+ daten.COL_CID + '</td><td>' + daten.COL_INFO + '</td></tr>'
					);
					//alert("Col = " + daten.NAME);
					
				});
		},
		error: function(data, req, status, err) {
			alert('Something went wrong !!! getTableColumn ' + data + " req = " + req + " status = " + status + " err = " + err);
			window.location.assign = "index.html";
		}
	});
}

function getTableVersion(database, table, env) {

	//alert("getTableVersion = "+ env + '.' + database + '.' + table);
	var i = 0;
	var func = 'getTableVersion';
	var PHPstring = ("function=" + func + "&environment=" + env + "&database=" + database + "&table=" + table);
	//alert(PHPstring);
	$.ajax({
		type: "get",
		url: "./php/TableDetail.php",
		data: (PHPstring),
		contentype: "application/json", // charset=utf-8", // Set
		dataType: 'json',
		jsonCallback: 'getJson',
		async: false,
		success: function(data) {
			$.each(data,
				function(counter, daten) {
					VersionColumn[counter] = ('<tr> <td>' + daten.VER_NR + '</td> <td>' + daten.VER_CHANGE_DATE + ' </td> <td>' + daten.VER_DESCRIPTION + '</td><td>' + daten.VER_RESPONSIBLE + '</td><td>' + daten.VER_CHANGE_NR + '</td></tr>'
					);
					//alert("VER = " + daten.VER_NR);
				});
		},
		error: function(data, req, status, err) {
			alert('Something went wrong !!! getTableColumn ' + data + " req = " + req + " status = " + status + " err = " + err);
			window.location.assign = "index.html";
		}
	});
}
	
	function TableUpdate(todo) {
		//alert('TableUpdate todo = ' + todo);
		var x = document.todo;				
		
		if (todo === 'updateTable') {
			//alert(' in updateTable ' );
			var NAME = document.getElementById("NAME").value;
			var TOWNER = document.getElementById("TOWNER").value;
			var TDOMAIN = document.getElementById("TDOMAIN").value;
			var TTYPE = document.getElementById("TTYPE").value;
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
			
			var func = 'insDocTab';
			var insert = ("function=" + func + "&environment=" + env + "&database=" + database + "&NAME=" + NAME
					+ "&TOWNER=" + TOWNER
					+ "&TDOMAIN=" + TDOMAIN
					+ "&TTYPE=" + TTYPE
					+ "&THOUSEKEEPING=" + THOUSEKEEPING
					+ "&THOUSE_RULES=" + THOUSE_RULES
					+ "&TREL_TYPE=" + TREL_TYPE
					+ "&TREL_RULES=" + TREL_RULES
					
					+ "&TCID=" + TCID
					+ "&TCID_RULES=" + TCID_RULES
					
				
					+ "&TUSE_UCC=" + TUSE_UCC
					+ "&TUSE_ODS=" + TUSE_ODS
					+ "&TUSE_DEP_MANAGER=" + TUSE_DEP_MANAGER
					+ "&TUSE_CWF=" + TUSE_CWF
					+ "&TUSE_IWF=" + TUSE_IWF
					+ "&TUSE_OWF=" + TUSE_OWF
					+ "&TDESCRIPTION=" + TDESCRIPTION
					+ "&TENTITY_DESCRIPTION=" + TENTITY_DESCRIPTION
				);
			
			//alert(' in updateTable ' + insert );
			//write to database
			insertTable(insert);
		}
		if (todo === 'updateVersion') {
			alert(' in updateVersion'  );
		}
		if (todo === 'updateColumn') {
			alert(' in updateColumn'  );
		}
	}
	
function insertTable(insert) {
		//alter("insertTable = "  + insert);
		$.ajax({
			type : "get",
			url : "./php/TableInsert.php",
			data : insert ,
			contentType : "application/json", // charset=utf-8", // Set
			dataType : 'json',
			jsonCallback : 'getJson',
		    async : false,
		    success : function() {
				alert("success : function() =" + insert);
				//window.location.assign = "UserProfil.html";
				
			},
			error : function() {
				alert("error: tableupdate.js to php/TableInsert.php" + insert);
				//window.location.assign = "index.html#cta";
				
			}
		});
 
	}

