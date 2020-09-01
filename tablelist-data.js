/*Hier wird nach entsprechen der Ausgewählten Datenbank 
 * eine Tabellenliste dieser erzeugt.
 
 */
/*verwendung von local storage macht das ganze einfacher
 window.localStorage.setItem('env', 'DEVE');
 window.localStorage.setItem('database', 'DESS00');
 window.localStorage.setItem('table', 'Tdmdg0001');
 */

/*
$('#TabReq').html('<b>Please select which Database Tables you like to see<b> <br>'
+ '<div ><form id="TabReq"  method="get" accept-charset="utf-8" onsubmit="TableRequest()">' 
+ ' <input type="hidden" id="func" value="TabReq">' 
+ '	<b >Database</b><select id="database"><option selected value="DDESS00">ESS</option>' 
+ '<option value="DDdmdg00">dmdg</option><option value="DB2INST1">DB2INST1</option><option value="SYSIBM">SYSIBM</option></select>' 
+ '	<b><input type="submit" value="Send" ></b></form></div>'
);
*/

$('#TabReq').html(Sprache.welcome_list)
/*
function TableRequest() {
	//alert('TableRequest');
	var f = document.TabReq;

	var func = document.getElementById("func").value;
//	var table = document.getElementById("table").value;
	var database = document.getElementById("database").value;
	
	window.localStorage.setItem('func', func);
//	window.localStorage.setItem('table', table);
	window.localStorage.setItem('database', database);
	//alert('func = ' + func + '   tablereq = ' + table + '   db = ' + database);
}
*/
var deve = [];
var test = [];
var qual = [];
var prod = [];
var derg = '<td>derg</td>';
var terg = '<td>terg</td>';
var qerg = '<td>qerg</td>';
var perg = '<td>perg</td>';

//einlesen der Requset Daten
//var env = window.localStorage.getItem('env');
var database = window.localStorage.getItem('database');
var table = window.localStorage.getItem('table');

/* end read input files */
//database = 'DB2INST1';
var env = 'deve';
getEnv(database, env);
var env = 'test';
getEnv(database, env);
var env = 'qual';
getEnv(database, env);
var env = 'prod';
getEnv(database, env);


$('.TableListHead').html('<tr><td>'+ Sprache.table + '</td>'
		+'<td>'+ Sprache.lastupd + '</td>'
		+'<td>'+ Sprache.remarks + '</td>'
		+'<td>DEVE</td>' 
		+'<td>TEST</td>'
		+'<td>VPRD</td>'
		+'<td>PROD</td>'
		+'<td>'+ Sprache.owner + '</td>'
		+'<td>'+ Sprache.reloadtyp + '</td>'
		+'<td>'+ Sprache.buinfo + '</td></tr>'
		);

ArrayResult();
function ArrayResult() {
	//alert(" ArrayResult");

	deve.forEach(function(vald) {
		//console.log(val);
		//alert ("val Name "+ val.NAME)
		//database = 'DD' + database +'00';
		derg = '<td><button onclick="calltest(' + "'" + database + "','" + env + "','" + vald.NAME  + "'" + ')">' + vald.NAME + '</button> </td>';
		dergy = '<td><button onclick="calltest(' + "'" + database + "','" + env + "','" + vald.NAME  + "'" + ')">YES</button> </td>';
		
		test.forEach(function(valt) {
		// alert ("valt Name "+ valt.NAME)
			terg = "tNO";
			if	((valt.NAME).indexOf(deve))		{
				
				terg = '<td><button onclick="calltest(' + "'" + database + "','" + env + "','" + valt.NAME  + "'" + ')">YES</button> </td>';
				
			} //ende if
		});
		
		qual.forEach(function(valq) {
		
			//alert ("valq Name "+ valq.NAME)
			qerg = "qNO";
			if	((valq.NAME).indexOf(deve))		{	
				//database = 'DQ' + database +'00';
				qerg = '<td><button onclick="calltest(' + "'" + database + "','" + env + "','" + valq.NAME  + "'" + ')">YES</button> </td>';
				
			} //ende if
		});
		
		prod.forEach(function(valp) {
				perg = "pNO";
				if	((valp.NAME).indexOf(deve))		{
				//	database = 'P' + database ;
					perg = '<td><button onclick="calltest(' + "'" + database + "','" + env + "','" + valp.NAME  + "'" + ')">YES</button> </td>';
				} //ende if
		});
			
	
		
		document.querySelector("#list").innerHTML += '<tr><td>' 
			+ '<button onclick="calltest(' + "'" + database + "','" + vald.ENVIRONMENT + "','" + vald.NAME + "'" + ')">' + vald.NAME + '</button>' + '</td><td>' 
			+ vald.LASTUSED + '</td><td>' + vald.REMARKS + '</td>' + dergy + terg + qerg + perg + '<td>' + vald.OWNER + '</td><td>' + vald.TREL_TYPE + '</td><td>' 
			+ vald.TDESCRIPTION + '</td></tr>';

	}); //ende deve
}  //ende function

function getEnv(database,  env) {

	//alert("getEnv = "+ env + '.' + database );
	var i = 0;
	//TableColumn = [];
	var func = 'getEnvList';
	var PHPstring = ("function=" + func  + "&database=" + database + "&environment=" + env);
	//alert(PHPstring);
	$.ajax({
		type: "get",
		url: "./php/TableList.php",
		data: (PHPstring),
		contentType: "application/json", // charset=utf-8", // Set
		dataType: 'json',
		jsonCallback: 'getJson',
		async: false,
		 success: function(data) {
			//alert(env  + "--env- ");
			if (env === 'deve') {
				var arr = new Array();
				arr = (data)
			//	alert(env + "--env- " + arr[1].ENVIRONMENT);
			//	console.log(data[1].ENVIRONMENT);
				deve = arr;
				//alert(env  + "--deve- " + deve)
			}
			if (env === 'test') {
			//	alert(env  + "--env- ");
				//console.log(data);
				test = data;
				//alert(env  + "--test- " + deve)
			} 
			if (env === 'qual') {
			//	alert(env  + "--env- ");
				//console.log(data);
				qual = data;
				//alert(env  + "--test- " + deve)
			} 
			if (env === 'prod') {
			//	alert(env  + "--env- ");
			//	console.log(data);
				prod = data;
			//alert(env  + "--test- " + deve)
			}
			
			/*console.log(deve);
			 console.log(test);
			 console.log(qual);
			 console.log(prod);
			 */

		},
		error: function(data, req, status, err) {
			alert('Something went wrong !!! getTableColumn ' + data + " req = " + req + " status = " + status + " err = " + err);
			window.location.assign = "index.html";
		}
	});
}
/*

 */
function calltest(database, env, table) {
	//alert ('hier');
	//alert('DB = ' + database + 'env = ' + env + '   table = ' + tab);
	window.localStorage.setItem('env', env);
	window.localStorage.setItem('database', database);
	window.localStorage.setItem('table', table);

	window.location.href = "tabledetail.html";
}
