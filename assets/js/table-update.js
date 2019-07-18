/*Hier wird nach aufruf (click) tableupdate
 * das Formular zum korrigieren der Dokumentinfos des letzten Tables angezeigt
 * Nach absenden des Formulars werden die Daten
 * in TDOCTAB, TDOCCOL und TDOCVER gespeichert
 * Ebenso werden in Zukunft die Comment on Felder für
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
var TableColumnName = [];
var VersionColumn = [];
var newVersion = '';
var i = 0;
var timestamp = Math.floor(Date.now() / 1000);
//alert (timestamp) ;


$('.UpdateInfo').html(Sprache.update_info)


function TableRequest(call) {
	//alert('TableRequest' + call);
	
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
					//alert (daten.TTIMESTAMP);
								
					var timestamp = daten.TTIMESTAMP;
					var date = new Date(timestamp*1000);
					var iso = date.toISOString();
					//alert(iso);
					
					$('.UpdateDetail').html('<b> ' + Sprache.resulttabreq 
						+ ' (' + daten.CREATOR + '.' + daten.TBSPACE + '.' + daten.NAME + ')</b><br><br>' 
						+ '<form id="updateTable"  method="get" accept-charset="utf-8" onsubmit="TableUpdate('+ "'" + $todo + "'" + ')">' 
						+ '<input type="hidden" id="func" value="updateTable">' 
						+ '<input type="hidden" id="NAME" value="' + daten.NAME + '">' 
						
						+ ' <table border="1"  width="100%"><colgroup>' + ' <col style="background-color: gray" width="10%"> '
						+ ' <col style="background-color: lightgray" width="25%"> ' + ' <col style="background-color: gray" width="10%"> '
						+ ' <col style="background-color: lightgray" width="25%"> ' + ' <col style="background-color: gray" width="10%"> ' 
						+ ' <col style="background-color: lightgray" width="25%"> ' + '</colgroup><tbody>' 

						+ '<tr><td>'+ Sprache.owner + '</td> <td><input type="text" maxlength="30" id="TOWNER" value="' + daten.TOWNER + '" placeholder="' + daten.TOWNER + '"></td>' 
						+ '<td>'+ Sprache.dba + '</td> <td>Gert Dorn</td>' 
						+ '<td>'+ Sprache.department + '</td> <td><input type="text" maxlength="20" id="TDOMAIN" value="' + daten.TDOMAIN + '" placeholder="' + daten.TDOMAIN + '"></td></tr>' 
						
						/*
							+ '	<b >Database</b><select id="database"><option selected value="o">ohne</option>' 
							+ '<option value="y">yes</option><option value="n">no</option></select>' 
						 */
						
						//no update possible
						+ '<tr> <td>'+ Sprache.db + '</td> <td>' + daten.CREATOR + '</td><td>'+ Sprache.ts + '</td> <td>' + daten.TBSPACE + '</td>' 
						+ '<td>'+ Sprache.entity + '</td> <td>' + daten.NAME + '</td></tr>' 
						+ '<tr><td>'+ Sprache.date + '</td> <td>' + daten.CTIME + '</td>' + '<td>'+ Sprache.lastupd +'</td> <td>' + daten.ALTER_TIME + '</td>' 
						+ '<td>' + Sprache.tabtyp + '</td> <td><input type="text" id="TTYPE" maxlength="20" value="' + daten.TTYPE + '" placeholder="' + daten.TTYPE + '"></td></tr>' 
						+ '<tr><td>'+ Sprache.runstats + '</td> <td>' + daten.STATISTICS_PROFILE + '</td>' + '<td>'+ Sprache.laststats + '</td> <td>' + daten.STATS_TIME + '</td>' 
						+ '<td>'+ Sprache.records + '</td> <td>' + daten.COLCOUNT + '</td></tr>' 
						
						+ '<tr><td>'+ Sprache.housekeeping + '</td><td>'
						+'<select id="THOUSEKEEPING"><option selected value="' + daten.THOUSEKEEPING +'">' + daten.THOUSEKEEPING 
						+'</option><option value="o">ohne</option><option value="y">yes</option><option value="n">no</option></select></td>'
						+ '<td>'+ Sprache.houserules + '</td> <td> <input type="text" id="THOUSE_RULES" maxlength="20"  value="' + daten.THOUSE_RULES + '" placeholder="' + daten.THOUSE_RULES + '"> </td>'
						
						
						+ '<td>'+ Sprache.reloadtyp + '</td> ' 
						+ '<td><input type="text" id="TREL_TYPE" maxlength="30" value="' + daten.TREL_TYPE + '" placeholder="' + daten.TREL_TYPE + '"></td></tr>' 
						
						+ '<tr><td>'+ Sprache.cid + '</td> <td>'
						+'<select id="TCID"><option selected value="' + daten.TCID + '">' + daten.TCID 
						+'</option><option value="o">ohne</option><option value="y">yes</option><option value="n">no</option></select></td>'
						
						+ '<td>'+ Sprache.anonymrules+ '</td> <td>' 
						+' <input type="text" id="TCID_RULES" maxlength="20" value="' + daten.TCID_RULES +  '" placeholder="' + daten.TCID_RULES + '"></td>'
						
						+ '<td>'+ Sprache.reloadrules + '</td> <td>' 
						+ '<input type="text" id="TREL_RULES" maxlength="20" value="' + daten.TREL_RULES +  '" placeholder="' + daten.TREL_RULES + '"></td></tr>'
						
					
						+ '<tr><td>'+ Sprache.ucc + '</td> <td>'
						+'<select id="TUSE_UCC"><option selected value="' + daten.TUSE_UCC +'">' + daten.TUSE_UCC 
						+'</option><option value="o">ohne</option><option value="y">yes</option><option value="n">no</option></select></td>'
						+ '<td>'+ Sprache.ods + '</td> <td>' 
						+'<select id="TUSE_ODS"><option selected value="' + daten.TUSE_ODS +'">' + daten.TUSE_ODS 
						+'</option><option value="o">ohne</option><option value="y">yes</option><option value="n">no</option></select></td>'
						+ '<td>'+ Sprache.dep + '</td> <td>'
						+'<select id="TUSE_DEP_MANAGER"><option selected value="' + daten.TUSE_DEP_MANAGER +'">' + daten.TUSE_DEP_MANAGER 
						+'</option><option value="o">ohne</option><option value="y">yes</option><option value="n">no</option></select></td></tr>'
					
						+ '<tr><td>'+ Sprache.cwf + '</td> <td>' 
						+'<select id="TUSE_CWF"><option selected value="' + daten.TUSE_CWF +'">' + daten.TUSE_CWF 
						+'</option><option value="o">ohne</option><option value="y">yes</option><option value="n">no</option></select></td>'
						+ '<td>'+ Sprache.iwf + '</td> <td>' 
						+'<select id="TUSE_IWF"><option selected value="' + daten.TUSE_IWF +'">' + daten.TUSE_IWF 
						+'</option><option value="o">ohne</option><option value="y">yes</option><option value="n">no</option></select></td>'
						+ '<td>'+ Sprache.ocw + '</td> <td>' 
						+'<select id="TUSE_OWF"><option selected value="' + daten.TUSE_OWF +'">' + daten.TUSE_OWF 
						+'</option><option value="o">ohne</option><option value="y">yes</option><option value="n">no</option></select></td></tr>'
					
						+ '<tr><td>'+ Sprache.remarks + '</td> <td>'  //option wäre Remarks zu holen
						+ '<input type="text" id="TDESCRIPTION" maxlength="50" value="' + daten.TDESCRIPTION + '" placeholder="' + daten.TDESCRIPTION + '"></td>' 
						
					
						+ '<td>'+ Sprache.budesc + '</td> <td>'
						+' <textarea id="TENTITY_DESCRIPTION"  value="' + daten.TENTITY_DESCRIPTION + '" cols="35" rows="2" maxlength="6000" >' + daten.TENTITY_DESCRIPTION + '</textarea> </td>'
						+ '<td>'+ Sprache.date + '</td> <td>' + iso + '</td></tr>' 
						
						+ '</tbody></table>'
						+ '<br>	<b><input type="submit"  value="Update Table Documentation" ></form></b>'
					);
					
				});
/*
			//Ausgeben Indexes
			getTableIndex(database, table, env);
			var vers = "";
			for (var i = 0, len = IndexColumn.length; i < len; i++) {
				//alert(VersionColumn[i]);
				var erg = VersionColumn[i];
 				//alert("var erg" + erg);
				index += erg;
			}
			//alert(vers );
			$todo = 'updateIndex'
	 // NAME, TBNAME ,COLNAMES , UNIQUERULE , CLUSTERFACTOR , STATS_TIME , LASTUSED

			$('.UpdateIndex').html('<form id="updateIndex"  method="get" accept-charset="utf-8" onsubmit="TableIndex(' + "'" + $todo + "'" + ')">' 
					+ '<input type="hidden" id="func" value="updateIndex">' 
					
					+ '<table border="1" width="100%"><colgroup>' 
					+ '<col style="background-color: lightgray" width="10%"> ' 
					+ '<col  width="10%"> ' + ' <col  width="70%"> ' + ' <col width="10%"> ' 
					+ '<col  width="10%"> ' 
					+ '</colgroup><thead style="background-color: gray"><th>Name</th><th>Columns</th>' 
					+ '<th>Uniqe</th><th>Cluster</th><th>Statisics</th></thead>' 
					+ '<tbody>' + index  +'</tbody></table>'
					+ '<a style="color:red" id="addVer" >add row</a>'
					+ '<br>	<b><input type="submit"  value="Update Change Version" ></form></b>'
			);
			*/
			
			//Ausgeben Change Version
			getTableVersion(database, table, env);
			var vers = "";
			for (var i = 0, len = VersionColumn.length; i < len; i++) {
				//alert(VersionColumn[i]);
				var erg = VersionColumn[i];
 				//alert("var erg" + erg);
				vers += erg;
			}
			//alert(vers );
			$todo = 'updateVersion'
			$('.UpdateVer').html('<form id="updateVersion"  method="get" accept-charset="utf-8" onsubmit="TableUpdate(' + "'" + $todo + "'" + ')">' 
					+ '<input type="hidden" id="func" value="updateVersion">' 
					
					+ '<table border="1" width="100%"><colgroup>' 
					+ '<col style="background-color: lightgray" width="10%"> ' 
					+ '<col  width="10%"> ' + ' <col  width="70%"> ' + ' <col width="10%"> ' 
					+ '<col  width="10%"> ' 
					+ '</colgroup><thead style="background-color: gray"><th>'+ Sprache.version 
					+ '</th><th>'+ Sprache.changedate + '</th>' 
					+'<th>'+ Sprache.changedescr + '</th><th>'+ Sprache.responsible + '</th><th>'+ Sprache.changenumber + '</th></thead>' 
					+ '<tbody>' + vers  +'</tbody></table>'
					+ '<a style="color:red" id="addVer" >add row</a>'
					+ '<br>	<b><input type="submit"  value="Update Change Version" ></form></b>'
			);

			
			
			//Ausgeben Column Beschreibung	
			var todo = 'update';
			getTableColumns(database, table, env , todo);			
		//alert("before -- " + cols );
			var cols = "";		
			for (var i = 0, len = TableColumn.length; i < len; i++) {
			//	alert(TableColumn[i]);
				var erg = TableColumn[i];
			
				cols += erg;
			}
			//alert("after -- " + cols );
			$todo = 'updateColumn'
			$('.UpdateCol').html('<form id="updateColumn"  method="get" accept-charset="utf-8" onsubmit="TableUpdate(' + "'" + $todo + "'" + ')">' 
			+ '<input type="hidden" id="func" value="updateColumn">' 
					
			+ '<table border="1" width="100%"><colgroup>' 
				+ ' <col style="background-color: lightgray" width="10%"> ' 
				+ ' <col  width="5%"> ' + ' <col  width="5%"> ' 
				+ ' <col width="5%"> ' + ' <col width="20%"> ' 
				+ ' <col width="5%"> ' + ' <col width="5%"> ' 
				+ ' <col style="background-color: white" width="50%"> ' 
				+ '</colgroup><thead style="background-color: gray">' 
				+ '<th>'+ Sprache.colname + '</th><th>'+ Sprache.coltyp + '</th><th>'+ Sprache.null + '</th><th>'+ Sprache.length + '</th><th>'+ Sprache.fielddescr + '</th><th>'+ Sprache.default + '</th><th>CID</th><th>'+ Sprache.buinfo+ '</th>' 
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

$(document).ready(function(){
	$('#addVer').click(function() {	
	//alert("addVer");
	var colNr = window.localStorage.getItem('colNr');	
	var table = window.localStorage.getItem('table');	
	colNr++;
	$(this).before('<table border="0" width="100%"><colgroup>' 
			+ '<col style="background-color: lightgray" width="10%"> ' 
			+ '<col  width="10%"> ' + ' <col  width="70%"> ' + ' <col width="10%"> ' 
			+ '<col  width="10%"> ' 
			+ '</colgroup><thead style="background-color: gray"><th>'+ Sprache.version 
			+ '</th><th>'+ Sprache.changedate + '</th>' 
			+'<th>'+ Sprache.changedescr + '</th><th>'+ Sprache.responsible + '</th><th>'+ Sprache.changenumber + '</th></thead>' 
			+ '<tbody><tr>'
			+ '<input type="hidden" id="colNr" value="' + colNr + '">' 
			+ '<input type="hidden" id="VER_TBNAME" value="' + table + '">' 
			+ '<td><input type="text" id="VER_NR" maxlength="10" value=" " placeholder="VER_NR"></td>' 			
			+ '<td><input type="date" id="VER_CHANGE_DATE"  value="" placeholder="VER_CHANGE_DATE"></td>' 
			+ '<td><input type="text" id="VER_DESCRIPTION" maxlength="50" value="" placeholder="VER_DESCRIPTION"></td>' 	
			+ '<td><input type="text" id="VER_RESPONSIBLE" maxlength="30" value="" placeholder="VER_RESPONSIBLE "></td>' 
			+ '<td><input type="text" id="VER_CHANGE_NR" maxlength="10" value="" placeholder="VER_CHANGE_NR"></td>' 
			+ '</tr></tbody></table>'
			);
	//alert("colNr - in Func  " + colNr + '  ' + this);
	window.localStorage.setItem('colNr', colNr);
	});
});

function TableUpdate(todo) {
	//	alert('TableUpdate todo = ' + todo);
		var x = document.todo;				
		
		if (todo === 'updateTable') {
			//alert(' in updateTable ' );
			var TIMESTAMP = timestamp;
			var NAME = table;
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
			//var TDESCRIPTION = document.getElementById("TDESCRIPTION").value;
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
					+ "&TIMESTAMP=" + TIMESTAMP
				);
			
			//alert(' in updateTable ' + insert );
			//write to database
			insertTable(insert);
		}
		if (todo === 'updateVersion') {
			//alert(' in updateVersion'  );
			var TIMESTAMP = timestamp;
			var VER_TBNAME = table;
			var VER_CHANGE_DATE = document.getElementById("VER_CHANGE_DATE").value;
			var VER_CHANGE_NR = document.getElementById("VER_CHANGE_NR").value;
			var VER_NR = document.getElementById("VER_NR").value;
			var VER_DESCRIPTION = document.getElementById("VER_DESCRIPTION").value;
			var VER_RESPONSIBLE = document.getElementById("VER_RESPONSIBLE").value;
			var func = 'insDocVer';
			var insert = ("function=" + func + "&environment=" + env + "&database=" + database + "&VER_TBNAME=" + VER_TBNAME
					+ "&VER_CHANGE_DATE=" + VER_CHANGE_DATE
					+ "&VER_CHANGE_NR=" + VER_CHANGE_NR
					+ "&VER_NR=" + VER_NR
					+ "&VER_DESCRIPTION=" + VER_DESCRIPTION
					+ "&VER_RESPONSIBLE=" + VER_RESPONSIBLE	
					+ "&TIMESTAMP=" + TIMESTAMP
				);
			
			//alert(' in updateTable ' + insert );
			//write to database
			insertTable(insert);
		}
		
		if (todo === 'updateColumn') {
			//alert('in updateColumn'  );
			//TBNAME und Name kommt von SYSIBM.SYSCOLUMNS
			
			var maxcolnr = window.localStorage.getItem('maxColNr');
		
			for (var i = 0 , len = TableColumnName.length; i < len;  i++) {
			//	alert(timestamp);
			var COL_DESCRIPTION ='COL_DESCRIPTION' + i ;
			var COL_DEFAULT ='COL_DEFAULT' + i ;
			var COL_CID ='COL_CID' + i ;
			var COL_INFO ='COL_INFO' + i ;
			
			//alert ("TableColumnName = "  + TableColumnName[i] + "  COL_DESCRIPTION  = "  + COL_DESCRIPTION );
			var TIMESTAMP = timestamp;
			var COL_TBNAME = table;
			var COL_NAME = TableColumnName[i];
			var COL_DESCRIPTION = document.getElementById(COL_DESCRIPTION).value;
			var COL_DEFAULT = document.getElementById(COL_DEFAULT).value;
			var COL_CID = document.getElementById(COL_CID).value;
			var COL_INFO = document.getElementById(COL_INFO).value;
			var COLNO = document.getElementById(i).value;
			//alert ("TableColumnName = "  + TableColumnName[i] + "  COL_DESCRIPTION  = "  + COL_DESCRIPTION );
			
			//alert( "maxcolNr = " + maxcolnr + " colno = " + COLNO);
			var func = 'insDocCol';
			var insert = ("function=" + func + "&environment=" + env + "&database=" + database 
					+ "&COL_TBNAME=" + COL_TBNAME
					+ "&COL_NAME=" + COL_NAME
					+ "&COL_DESCRIPTION=" + COL_DESCRIPTION
					+ "&COL_DEFAULT=" + COL_DEFAULT
					+ "&COL_CID=" + COL_CID
					+ "&COL_INFO=" + COL_INFO
					+ "&COLNO=" + COLNO
					+ "&TIMESTAMP=" + TIMESTAMP
			);

			//alert(' in updateTable ' + insert );
			
			//write to database
			insertTable(insert);
			
		} //for (var i = 0 , len = TableColumnName.length
		}
}
	
function insertTable(insert) {
		//alert("insertTable = "  + insert);
		$.ajax({
			type : "get",
			url : "./php/TableInsert.php",
			data : insert ,
			contentType : "application/json", // charset=utf-8", // Set
			dataType : 'json',
			jsonCallback : 'getJson',
		    async : false,
		    success : function() {
				//alert("success : function() =" + insert);
				//window.location.assign = "UserProfil.html";
				
			},
			error : function() {
				alert("error: tableupdate.js to php/TableInsert.php" + insert);
				//window.location.assign = "index.html#cta";
				
			}
		});
 
	}

