/*Hier wird nach aufruf (click) einer Tabelle 
  aus der Tabellenliste die Info zur jeweiligen Tabelle
  aus dem jeweiligem System abgerufen
  Prozess:
  Auswahl Tabelle und env aus tableiste.html
  übergabe WERTE
  Bilde Datenbank SQL request
  Bereite result zu HTML auf
  Ausgabe der Daten auf tabnledetail.html
verwendung von local storage macht das ganze einfacher
 window.localStorage.setItem('env', 'DEVE');
 window.localStorage.setItem('database', 'DESS00');
 window.localStorage.setItem('table', 'Tdmdg0001');
 */




$('.TableInfo').html(Sprache.detail_info) ;

function TableRequest(call) {
	// alert('TableRequest' + call);
	var f = document.call;

	var func = document.getElementById("func").value;
	var table = document.getElementById("table").value;
	// alert('func = ' + func + ' tablereq = ' + table);
	window.localStorage.setItem('func', func);
	window.localStorage.setItem('table', table);
}

// einlesen der Requset Daten v
var env = window.localStorage.getItem('env');
var database = window.localStorage.getItem('database');
var table = window.localStorage.getItem('table');
table = table.toUpperCase(table); // transform to uppercase

// alert(table); 
$(document).ready(function() {
				
				var todo = 'i';
				getTableInfo(database, table, env, todo);
				var todo = 's';
				getTableSystem(database, table, env, todo);

					 
					//enlesen Daten documentation
				$.getJSON( "../locale/info_array.json", function( daten ) {
					//TableInfo = Info;
					var timestamp = daten.TTIMESTAMP;
					// alert("daten.TTIMESTAMP - " + daten.TTIMESTAMP );
					var date = new Date(timestamp * 1000);
					var iso = date.toISOString();
					
					
				        //einlesen daten aus Systemtabellen je							// evnvironment
					$.getJSON( "../locale/row_array.json", function( System ) {
						//alert("System.CREATOR - " + System.CREATOR );
				
			
			
					$('.TableDetail')
							.html(
									'<b>'
											+ Sprache.resulttabreq + ' ('	+ System.CREATOR 	+ '.' 	+ System.TBSPACE + '.' + System.NAME + ')</b><br><br>'
											+ ' <table border="1"  width="100%"><colgroup>'
											+ ' <col style="background-color: gray" width="10%"> '
											+ ' <col style="background-color: lightgray" width="25%"> '
											+ ' <col style="background-color: gray" width="10%"> '
											+ ' <col style="background-color: lightgray" width="25%"> '
											+ ' <col style="background-color: gray" width="10%"> '
											+ ' <col style="background-color: lightgray" width="25%"> '
											+ '</colgroup><tbody>'

											+ '<tr><td>' + Sprache.owner+ '</td> <td>' + daten.TOWNER
						
							  + '</td>' + '<td>'+ Sprache.dba + '</td> <td>Gert Dorn</td>' + '<td>'+  Sprache.department + '</td> <td>' +
							  daten.TDOMAIN + '</td></tr>' + '<tr> <td>'+  System.db + '</td> <td>' + System.CREATOR + '</td><td>'+
							  Sprache.ts + '</td> <td>' + daten.TBSPACE + '</td>' + '<td>'+
							  Sprache.entity + '</td> <td>' + System.NAME + '</td></tr>' + '<tr><td>'+
							  Sprache.date + '</td> <td>' + System.CTIME + '</td>' + '<td>'+
							  Sprache.lastupd + '</td> <td>' +   System.ALTER_TIME + '</td>' + '<td>'+
							  Sprache.tabtyp + '</td> <td>' + daten.TTYPE + '</td></tr>' + '<tr><td>'+
							  Sprache.runstats + '</td> <td>' +  System.STATISTICS_PROFILE + '</td>' + '<td>'+
							  Sprache.laststats + '</td> <td>' +   System.STATS_TIME + '</td>' + '<td>'+
							  Sprache.records + '</td> <td>' + System.COLCOUNT + '</td></tr>' + '<tr><td>'+
							  Sprache.housekeeping + '</td> <td>' +   daten.THOUSEKEEPING + '</td><td>'+
							  Sprache.houserules + '</td> <td>' +   daten.THOUSE_RULES + '</td>' + '<td>'+
							  Sprache.reloadtyp + '</td> <td>' +   daten.TREL_TYPE + '</td></tr>' + '<tr><td>'+
							  Sprache.cid + '</td> <td>' + daten.TCID + '</td><td>'+ 
							  Sprache.anonymrules+ '</td> <td>' +   daten.TCID_RULES + '</td>' + '<td>'+
							  Sprache.reloadrules + '</td> <td>' +  daten.TREL_RULES + '</td></tr>' + '<tr><td>'+
							  Sprache.dmdg + '</td> <td>' + daten.TUSE_dmdg + '</td>' + '<td>'+
							  Sprache.ods + '</td> <td>' + daten.TUSE_ODS + '</td>' + '<td>'+
							  Sprache.dep + '</td> <td>' + daten.TUSE_DEP_MANAGER + '</td></tr>' + '<tr><td>'+
							  Sprache.cwf + '</td> <td>' + daten.TUSE_CWF + '</td>' + '<td>' +
							  Sprache.iwf + '</td> <td>' + daten.TUSE_IWF + '</td>' + '<td>'+
							  Sprache.ocw + '</td> <td>' + daten.TUSE_OWF + '</td></tr>' + '<tr><td>'+
							  Sprache.remarks + '</td> <td>' + daten.REMARKS + '</td>' + '<td>'+
							  Sprache.budesc + '</td> <td>' +  daten.TENTITY_DESCRIPTION + '</td>' + '<td>'+
							  Sprache.date + '</td> <td>' + iso + '</td></tr>'
							  
							  + '<tr><td>Table Description</td> <td>' +   daten.TENTITY_DESCRIPTION + '</td>' 
							  + '<td>Busines   Description </td> <td>' +   daten.TENTITY_DESCRIPTION + '</td>' 
							  + '<td>Date</td>  <td>' + daten.TTIMESTAMP + '</td></tr>' + '</tbody></table>'
							 
											
							);   // TableDetail
					 
					}); //close row_array.json
				}); //close info_array.json
			
				
					//Ausgeben Indexes
				getTableIndex(database, table, env);
					var index = "";
					for (var i = 0, len = IndexColumn.length; i < len; i++) {
						//alert(VersionColumn[i]);
					var erg = IndexColumn[i];
		 				//alert("var erg" + erg);
					index += erg;
					}
					//alert(index );
		
					// NAME, TBNAME ,COLNAMES , UNIQUERULE , CLUSTERFACTOR
						// , STATS_TIME , LASTUSED
					$('.TableIndex').html( '<table border="1" width="100%"><colgroup>' 
							+ '<col style="background-color: lightgray" width="20%"> ' 
							+ '<col  width="50%"> ' + ' <col  width="10%"> ' + ' <col width="20%"> ' 
							+ '<col  width="10%"> ' 
							+ '</colgroup><thead style="background-color: gray"><th>'+ Sprache.iindex
							+ '</th><th>'+ Sprache.icolname + '</th>' 
							+'<th>'+ Sprache.iuniqerule  + '</th><th>'+ Sprache.istats_time + '</th><th>'+ Sprache.icluster +'</th></thead>' 
							+ '<tbody>' + index + '</tbody></table>'
					);
					
					
					
					//Ausgeben Change Version
				getTableVersion(database, table, env);
					var vers = "";
					for (var i = 0, len = VersionColumn.length; i < len; i++) {
						//alert(VersionColumn[i]);
					var erg = VersionColumn[i];
						vers += erg;
					}
					//alert(vers );
					$('.TableVer').html('<table border="1" width="100%"><colgroup>' 
							+ ' <col style="background-color: lightgray" width="10%"> ' 
							+ ' <col  width="10%"> ' + ' <col  width="70%"> ' + ' <col width="10%"> ' 
							+ ' <col  width="10%"> ' 
							+ '</colgroup><thead style="background-color: gray"><th>'+ Sprache.version 
							+ '</th><th>'+ Sprache.changedate + '</th>' 
							+'<th>'+ Sprache.changedescr + '</th><th>'+ Sprache.responsible + '</th><th>'+ Sprache.changenumber + '</th></thead>' 
							+ '<tbody>' + vers + '</tbody></table>'
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
					
			
});

