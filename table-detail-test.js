/*Hier wird nach aufruf (click) einer Tabelle 
 * aus der Tabellenliste die Info zur jeweiligen Tabelle
 * aus dem jeweiligem System abgerufen
 * Prozess:
 * Auswahl Tabelle und env aus tableiste.html
 * übergabe WERTE
 * Bilde Datenbank SQL request
 * Bereite result zu HTML auf
 * Ausgabe der Daten auf tabnledetail.html
 */
/*verwendung von local storage macht das ganze einfacher
 window.localStorage.setItem('env', 'DEVE');
 window.localStorage.setItem('database', 'DESS00');
 window.localStorage.setItem('table', 'Tdmdg0001');
 */



//alert ("table local Storage " + env + "." + table) ;

// Globale Variabele für Verarbeitung
/*var TableColumn = [];
var VersionColumn = [];
*/
//$('.Welcome').html('<h4>Table Information for : ' + env + "." + table + '</h4>');
/*
$('.TableInfo').html('<h3>If you see there are wrong information or description for this tableinfo <br>please send a mail ' 
	+ ' <a href="mailto:support@dmdg.io?subject=Table correction (' + env + '.' + table + ')" target="_top"> E-Mail</a></h3>' 

	+ '<div ><b>Search a special table  you like to see '
	+ '<form id="TabReq"  method="get" accept-charset="utf-8" onsubmit="TableRequest()">' 
	+ '<input type="hidden" id="func" value="TabReq">' + '<input type="text" id="table"   minlength="2" maxlength="30" size="10">' 
	+ '	<b><input type="submit"  name="mail" value="Send" ></b></form></b></div>'
);
*/


$('.TableInfo').html(Sprache.detail_info)


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
table = table.toUpperCase(table);   // transform to uppercase
/*
 * '<b> Result for Tablerequest DB.TS.TB (' + daten.CREATOR + '.' +
 * daten.TBSPACE + '.' + daten.NAME + ')</b><br><br><br>'
 */

// alert(table);
$(document).ready(function() {

	/**
	 * ***************TableDocu =
	 * [];***************************************************
	 */
	TableDocu = [];
	TableDetail = [];
	var todo = 'i';
	var func = 'getTableDetail';
	var PHPstring = ("function=" + func + "&environment=" + env + "&database=" + database + "&table=" + table + "&todo=" + todo);
	// alert(PHPstring);
	$.ajax({
		type: "get",
		url: "./php/TableDetail.php",
		data: (PHPstring),
		contentType: "application/json", // charset=utf-8", // Set
		dataType: 'json',
		jsonCallback: 'getJson',
		async: false,
		success: 			
			 function readTextFile(file, callback) {
			    var rawFile = new XMLHttpRequest();
			    rawFile.overrideMimeType("application/json");
			    rawFile.open("GET", file, true);
			    rawFile.onreadystatechange = function() {
			        if (rawFile.readyState === 4 && rawFile.status == "200") {
			            callback(rawFile.responseText);
			        }
			    }
			    rawFile.send(null);
			}
	});
	
			// usage:
			readTextFile("../locale/info_array.json", function(text){
			    var data = JSON.parse(text);
			    console.log(data);
			});
	
	
	// $('.TableDetail').html( detail); //.Table Detail
				
	/** **************************************************************** */
	
	// Ausgeben Indexes
			getTableIndex(database, table, env);
			var index = "";
			for (var i = 0, len = IndexColumn.length; i < len; i++) {
				// alert(IndexColumn[i]);
				var erg = IndexColumn[i];
 				// alert("var erg" + erg);
				index += erg;
			}
			// alert(index );
	
			// NAME, TBNAME ,COLNAMES , UNIQUERULE , CLUSTERFACTOR , STATS_TIME
			// , LASTUSED

			$('.TableIndex').html( '<table border="1" width="100%"><colgroup>' 
					+ '<col style="background-color: lightgray" width="20%"> ' 
					+ '<col  width="50%"> ' + ' <col  width="10%"> ' + ' <col width="20%"> ' 
					+ '<col  width="10%"> ' 
					+ '</colgroup><thead style="background-color: gray"><th>'+ Sprache.iindex
					+ '</th><th>'+ Sprache.icolname + '</th>' 
					+'<th>'+ Sprache.iuniqerule  + '</th><th>'+ Sprache.istats_time + '</th><th>'+ Sprache.icluster +'</th></thead>' 
					+ '<tbody>' + index + '</tbody></table>'
			);
			
			
			
	// Ausgeben Change Version
			getTableVersion(database, table, env);
			var vers = "";
			for (var i = 0, len = VersionColumn.length; i < len; i++) {
				// alert(VersionColumn[i]);
				var erg = VersionColumn[i];
				vers += erg;
			}
	// alert(vers );
			$('.TableVer').html('<table border="1" width="100%"><colgroup>' 
					+ ' <col style="background-color: lightgray" width="10%"> ' 
					+ ' <col  width="10%"> ' + ' <col  width="70%"> ' + ' <col width="10%"> ' 
					+ ' <col  width="10%"> ' 
					+ '</colgroup><thead style="background-color: gray"><th>'+ Sprache.version 
					+ '</th><th>'+ Sprache.changedate + '</th>' 
					+'<th>'+ Sprache.changedescr + '</th><th>'+ Sprache.responsible + '</th><th>'+ Sprache.changenumber + '</th></thead>' 
					+ '<tbody>' + vers + '</tbody></table>'
			);

	// Ausgeben Column Beschreibung
			getTableColumns(database, table, env);
			
	// alert("before -- " + cols );
			var cols = "";
		
			for (var i = 0, len = TableColumn.length; i < len; i++) {
				// alert(TableColumn[i]);
				var erg = TableColumn[i];
				cols += erg;
			}
			// alert("after -- " + cols );
			$('.TableCol').html('<table border="1" width="100%"><colgroup>' 
				+ ' <col style="background-color: lightgray" width="10%"> ' 
				+ ' <col  width="5%"> ' + ' <col  width="5%"> ' 
				+ ' <col width="5%"> ' + ' <col width="20%"> ' 
				+ ' <col width="5%"> ' + ' <col width="5%"> ' 
				+ ' <col style="background-color: white" width="50%"> ' 
				+ '</colgroup><thead style="background-color: gray">' 
				+ '<th>'+ Sprache.colname + '</th><th>'+ Sprache.coltyp + '</th><th>'+ Sprache.null + '</th><th>'+ Sprache.length + '</th><th>'+ Sprache.fielddescr + '</th><th>'+ Sprache.default + '</th><th>CID</th><th>'+ Sprache.buinfo+ '</th>' 
				+ '</thead><tbody>' + cols + '</tbody></table>'
			);
	},
	error: function(data, req, status, err) {
		alert('Something went wrong !!! getTableDetail ' + data + " req = " + req + " status = " + status + " err = " + err);
		window.location.assign = "index.html";
	}

});



