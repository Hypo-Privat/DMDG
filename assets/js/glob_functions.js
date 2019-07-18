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
 window.localStorage.setItem('table', 'TUCC0001');
 */

//alert ("table local Storage " + env + "." + table) ;
// Globale Variabele für Verarbeitung
var TableColumn = [];
var TableColumnName  = [];
var VersionColumn = [];
var IndexColumn = [];
var i = 0;

function TableRequest() {
//	alert('TableRequest');
	var f = document.TabReq;

	var func = document.getElementById("func").value;
	//var table = document.getElementById("table").value;
	var database = document.getElementById("database").value;
	//alert('func = ' + func + '   tablereq = ' + table + '   db = ' + database);
	
	window.localStorage.setItem('func', func);
	//window.localStorage.setItem('table', table);
	window.localStorage.setItem('database', database);
	
}

function getTableColumns(database, table, env, todo) {

	// alert("getTableColumns = "+ env + '.' + database + '.' + table);
	var i = 0;
	TableColumn = [];
	var func = 'getTableColumn';
	var PHPstring = ("function=" + func + "&environment=" + env + "&database="
			+ database + "&table=" + table);
	// alert(PHPstring);
	$
			.ajax({
				type : "get",
				url : "./php/TableDetail.php",
				data : (PHPstring),
				contentType : "application/json", // charset=utf-8", // Set
				dataType : 'json',
				jsonCallback : 'getJson',
				async : false,
				success : function(data) {
					$.each(	data.sort(),function(counter, daten) {
						if (todo === 'update') {
									// alert ("update")
					// TableColumnName important for
											// update in table-update.js
							TableColumnName[counter] = (daten.NAME);

							TableColumn[counter] = ('<tr> <td>'
													+ daten.NAME + '</td> <td>'
													+ daten.COLTYPE	+ '</td> <td>'
													+ daten.NULLS + ' </td> <td>'
													+ daten.LENGTH	+ '</td>'
													+ '<input type="hidden" id="func" value="updateTable">'
													+ '<input type="hidden" id="TBNAME" value="' + daten.TBNAME	+ '">'
													+ '<input type="hidden" id="NAME" value="'	+ daten.NAME + '">'
													+ '<input type="hidden" id="' + daten.COLNO	+ '" value="'	+ daten.COLNO + '">'
													
													+ '<td><input type="text" id="COL_DESCRIPTION'	+ daten.COLNO	+ '" maxlength="20" value="'	+ daten.COL_DESCRIPTION
													+ '" placeholder="' + daten.COL_DESCRIPTION + '"></td>'
													+ '<td><input type="text" id="COL_DEFAULT'	+ daten.COLNO	+ '" maxlength="20" value="'	+ daten.COL_DEFAULT
													+ '" placeholder="' + daten.COL_DEFAULT + '"></td>'
													+ '<td><select id="COL_CID' + daten.COLNO + '"><option selected value="'+ daten.COL_CID + '">'	+ daten.COL_CID
													+ '</option><option value="o">ohne</option><option value="y">yes</option><option value="n">no</option></select></td>'
													+ '<td> <textarea id="COL_INFO'	+ daten.COLNO + '"  value="'	+ daten.COL_INFO + '" cols="50" rows="2" maxlength="3000" >'
													+ daten.COL_INFO + '</textarea> </td></tr>'
												//	+ '<tr><td> '+ daten.REMARKS + '"></td></tr>'
													// get remaks

							);
							window.localStorage.setItem('maxColNr', daten.COLNO);
											// alert("table = " + daten.TBNAME +
											// " name = " + daten.NAME );
						} else {	// Busines Description Default CID
											// Information
								TableColumn[counter] = ('<tr> <td>' + daten.NAME + '</td> <td>' 
													+ daten.COLTYPE + '</td> <td>'
													+ daten.NULLS	+ ' </td> <td>'
													+ daten.LENGTH	+ '</td><td>'
													+ daten.COL_DESCRIPTION	+ '</td><td>'
													+ daten.COL_DEFAULT + '</td><td>'
													+ daten.COL_CID+ '</td><td>'
													+ daten.COL_INFO + '</td></tr>'
												//	+ '<tr><td colspan="8"> '+ daten.COL_INFO + '</td></tr>'
													);
								} //console.log(TableColumnName);
					});
				},
				error : function(data, req, status, err) {
					alert('Something went wrong !!! getTableColumn ' + data
							+ " req = " + req + " status = " + status
							+ " err = " + err);
					window.location.assign = "index.html";
				}
			});
}

function getTableVersion(database, table, env) {

	// alert("getTableVersion = "+ env + '.' + database + '.' + table);
	var i = 0;
	var func = 'getTableVersion';
	var PHPstring = ("function=" + func + "&environment=" + env + "&database="
			+ database + "&table=" + table);
	// alert(PHPstring);
	$.ajax({
		type : "get",
		url : "./php/TableDetail.php",
		data : (PHPstring),
		contentType : "application/json", // charset=utf-8", // Set
		dataType : 'json',
		jsonCallback : 'getJson',
		async : false,
		success : function(data) {
			$.each(data.sort(), function(counter, daten) {
				VersionColumn[counter] = ('<tr> <td>' + daten.VER_NR
						+ '</td> <td>' + daten.VER_CHANGE_DATE + ' </td> <td>'
						+ daten.VER_DESCRIPTION + '</td><td>'
						+ daten.VER_RESPONSIBLE + '</td><td>'
						+ daten.VER_CHANGE_NR + '</td></tr>');
				// alert("VER = " + daten.VER_NR);
			});
		},
		error : function(data, req, status, err) {
			alert('Something went wrong !!! getTableColumn ' + data + " req = "
					+ req + " status = " + status + " err = " + err);
			window.location.assign = "index.html";
		}
	});
}

function getTableIndex(database, table, env) {

	// alert("getTableIndex = "+ env + '.' + database + '.' + table);
	var i = 0;
	var func = 'getTableIndex';
	var PHPstring = ("function=" + func + "&environment=" + env + "&database="
			+ database + "&table=" + table);
	// alert(PHPstring);
	   // NAME, TBNAME ,COLNAMES , UNIQUERULE , CLUSTERFACTOR , STATS_TIME , LASTUSED
	    
	$.ajax({
		type : "get",
		url : "./php/TableDetail.php",
		data : (PHPstring),
		contentType : "application/json", // charset=utf-8", // Set
		dataType : 'json',
		jsonCallback : 'getJson',
		async : false,
		success : function(data) {
			$.each(data.sort(), function(counter, daten) {
				IndexColumn[counter] = ('<tr> <td>' + daten.NAME
						+ '</td> <td>' + daten.COLNAMES  + ' </td> <td>'
						+ daten.UNIQUERULE + '</td><td>'
						+ daten.STATS_TIME + '</td><td>'
						+ daten.CLUSTERFACTOR  + '</td></tr>');
				// alert("VER = " + daten.VER_NR);
			});
		},
		error : function(data, req, status, err) {
			alert('Something went wrong !!! getTableIndex ' + data + " req = "
					+ req + " status = " + status + " err = " + err);
			window.location.assign = "index.html";
		}
	});
}


function getTableVersion(database, table, env) {

	// alert("getTableVersion = "+ env + '.' + database + '.' + table);
	var i = 0;
	var func = 'getTableVersion';
	var PHPstring = ("function=" + func + "&environment=" + env + "&database="
			+ database + "&table=" + table);
	// alert(PHPstring);
	$.ajax({
		type : "get",
		url : "./php/TableDetail.php",
		data : (PHPstring),
		contentType : "application/json", // charset=utf-8", // Set
		dataType : 'json',
		jsonCallback : 'getJson',
		async : false,
		success : function(data) {
			$.each(data.sort(), function(counter, daten) {
				VersionColumn[counter] = ('<tr> <td>' + daten.VER_NR
						+ '</td> <td>' + daten.VER_CHANGE_DATE + ' </td> <td>'
						+ daten.VER_DESCRIPTION + '</td><td>'
						+ daten.VER_RESPONSIBLE + '</td><td>'
						+ daten.VER_CHANGE_NR + '</td></tr>');
				// alert("VER = " + daten.VER_NR);
			});
		},
		error : function(data, req, status, err) {
			alert('Something went wrong !!! getTableColumn ' + data + " req = "
					+ req + " status = " + status + " err = " + err);
			window.location.assign = "index.html";
		}
	});
}

var Sprache = [];
function getlanguage(lang) {
	//alert("getlanguage(lang) = "+ lang );
	$.ajax({
		type : "get",
		url : "./locale/" + lang + ".json",
		contentType : "application/json", // charset=utf-8", // Set
		dataType : 'json',
		jsonCallback : 'getJson',
		async : false,
		success : function(data) {
			$.each(data, function(counter, daten) {
				// alert("daten " + daten.values + " counter " + counter);
				Sprache = daten.values;
			});

		},
		error : function(data, req, status, err) {
			alert('Something went wrong !!! getlanguage ' + data + " req = "
					+ req + " status = " + status + " err = " + err);
			window.location.assign = "index.html";
		}
	});
	// alert( " in getlanguage Sprache " + Sprache.Yes);
	return Sprache;

}

//https://stackoverflow.com/questions/16858954/how-to-properly-use-jspdf-library
function demoFromHTML() {
    var pdf = new jsPDF('p', 'pt', 'letter');
    // source can be HTML-formatted string, or a reference
    // to an actual DOM element from which the text will be scraped.
    source = $('#content')[0];

    // we support special element handlers. Register them with jQuery-style 
    // ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
    // There is no support for any other type of selectors 
    // (class, of compound) at this time.
    specialElementHandlers = {
        // element with id of "bypass" - jQuery style selector
        '#bypassme': function (element, renderer) {
            // true = "handled elsewhere, bypass text extraction"
            return true
        }
    };
    margins = {
        top: 80,
        bottom: 60,
        left: 40,
        width: 522
    };
    // all coords and widths are in jsPDF instance's declared units
    // 'inches' in this case
    pdf.fromHTML(
        source, // HTML string or DOM elem ref.
        margins.left, // x coord
        margins.top, { // y coord
            'width': margins.width, // max width of content on PDF
            'elementHandlers': specialElementHandlers
        },

        function (dispose) {
            // dispose: object with X, Y of the last line add to the PDF 
            //          this allow the insertion of new lines after html
            pdf.save('Test.pdf');
        }, margins
    );
}

function popWIN(mylink, windowname) {
	if (!window.focus)
		return true;
	var href;
	if (typeof (mylink) == 'string')
		href = mylink;
	else
		href = mylink.href;
	switch (windowname) {
	case "image":
		window.open(href, windowname,
				'width=1000,height=800, top=200 , left=500,  ,scrollbars=yes');
		break;
	case "login":
		//alert("logon");
		window.open(href, windowname,
				'width=200,height=200, top=200 , left=500,  ,scrollbars=yes');
		break;
	case "Objekt":
		window.open(href, windowname,
				'width=1000,height=800, top=200 , left=500,  ,scrollbars=yes');
		break;
	default:
		window.open(href, windowname,
				'width=600,height=700, top=200 , left=200,  ,scrollbars=yes');
		break;
	}
	return false;
}