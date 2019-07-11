//menue dokumentieren	

if (localStorage.getItem("language") === null) {
	// Set Browser language
	var language = window.navigator.userLanguage || window.navigator.language;
	// alert("in get ip = " + language); //works IE/SAFARI/CHROME/FF
	window.localStorage.setItem('language', language);
	var language = window.localStorage.getItem('language');
	// wird gebraucht falls de_DE als sprache zürück gegeben wird
	var language = language.substr(0, 2);
	getlanguage(language);
}else {
	var language = window.localStorage.getItem('language');
	// wird gebraucht falls de_DE als sprache zürück gegeben wird
	var language = language.substr(0, 2); 
	getlanguage(language);
}



// ausgabe kopf UCC
  $('#Head_uss').html('<table width="100%"><tr align="center">'
		  +'<td><img src="../assets/js/images/UBS_Logo.png" height="42" width="80"></td>' 
		  +'<td><h2>UCC  UBS Card Center</h2></td>' +'<td><img src="../assets/js/images/visa.jpg" height="50" width="60"></img></td>' 
		  +'</tr></table><hr>' 
		  );
 
	$('#Head').html('<table ><tr align="right">'
			+'<td><img src="../assets/js/images/frog.jpeg" height="60" width="100"></td>'
			+'<td><h2>'+ Sprache.titel + '</h2></td>'
			+'<td><img src="../assets/js/images/einstein.jpeg" height="70" width="100"></img></td>'
			+'</tr></table><hr>'
			);
		
	
	// ausgabe Willkommen
	
	$('#Welcome').html(Sprache.welcome_list); 
	
	// login wenn ok siehe update und configuration
	if (localStorage.getItem("login") === 'ok') {
		var update = '<li><a href="tableupdate.html" class="signout">'+ Sprache.update + '</a></li>' ;
		var config = '<li><a href="configuration.html">'+ Sprache.config + '</a></li>';
	}else { var update = '' ; var config = '';}

	
	$('#Menue').html('<ul class="menu" >'			
			+'<li><a href="'+ Sprache.Sprache + '.index.html">Home</a>'	
	+'<li><a href="#">'+ Sprache.table + '</a>'
	+'<ul>'
		+'<li><a href="tablelist.html" class="documents">'+ Sprache.list+ '</a></li>'
		+'<li><a href="tabledetail.html" class="messages">'+ Sprache.info + '</a></li>'
		// +'<li><a href="tableupdate.html" class="signout">'+ Sprache.update +
		// '</a></li>'
		+ update 
		+'<li><a href="tablenew.html" class="blank" >'+ Sprache.new + '</a></li>'
	+'</ul></li>'
	
	+'<li><a href="viewlist.html">'+ Sprache.view + '</a>'	
	+'<li><a href="triggerlist.html">'+ Sprache.trigger + '</a></li>'
// +'<li><a href="indexes.html">'+ Sprache.indexes + '</a></li>'
// +'<li><a href="packagelist.html">'+ Sprache.pack + '</a></li>'
	+ config
	+'<li><a href="#" onclick="getLang('+ Sprache.Sprache + ')">'+ Sprache.Sprache + '</a>'
	+'<ul>'
	+'<li><a href="#" onclick="getLang(' + "'de" + "'" + ')">'+ Sprache.de + '</a></li>'
	+'<li><a href="#" onclick="getLang(' + "'en" + "'" + ')">'+ Sprache.en + '</a></li>'
	+'<li><a href="#" onclick="getLang(' + "'es" + "'" + ')">'+ Sprache.es + '</a></li>'
	+'<li><a href="#" onclick="getLang(' + "'fr" + "'" + ')">'+ Sprache.fr + '</a></li>'
	+'<li><a href="#" onclick="getLang(' + "'it" + "'" + ')">'+ Sprache.it + '</a></li>'	
	+'</ul></li>'
	+ '<li><form id="login"  method="get" accept-charset="utf-8" onsubmit="login()">' 
	+'<input type="text" id="pw" size="8" value="" maxlength="10">'	
	+ '<input type="submit"  value="'+  Sprache.configpw +'" ></form></li>'
	+'</ul><hr>'
	+ Sprache.configcomment  
	);


	$('#InfoHead').html(  Sprache.InfoHead );

	$('#TabList').html(  Sprache.TabListeInfo
	+ '<td ><img src="/input/docpic/tabliste.png" width="800" onclick="return popWIN(src=' + "'" + '/input/docpic/tabliste.png' + "'" + ' , ' + "'" + 'image' + "'" + ')"></td>'
	+ Sprache.TabListeText
	);
	

	$('#TabDetail').html(  Sprache.TabDetailInfo
	+ '<td ><img src="/input/docpic/tabdetail.png" width="800" onclick="return popWIN(src=' + "'" + '/input/docpic/tabdetail.png' + "'" + ' , ' + "'" + 'image' + "'" + ')"></td>'
	+ Sprache.TabDetailText
	);
	
	$('#TabUpdate').html(  Sprache.TabUpdateInfo
			+ '<td ><img src="/input/docpic/tabupdate.png" width="800" onclick="return popWIN(src=' + "'" + '/input/docpic/tabupdate.png' + "'" + ' , ' + "'" + 'image' + "'" + ')"></td>'
			+ Sprache.TabUpdateText
			);
	
	$('#View').html(  Sprache.ViewInfo
			+ '<td ><img src="/input/docpic/viewlist.png" width="800" onclick="return popWIN(src=' + "'" + '/input/docpic/viewlist.png' + "'" + ' , ' + "'" + 'image' + "'" + ')"></td>'
			+ Sprache.ViewText
			);
	
	$('#Trigger').html(  Sprache.TriggerInfo
			+ '<td ><img src="/input/docpic/trigger.png" width="800" onclick="return popWIN(src=' + "'" + '/input/docpic/trigger.png' + "'" + ' , ' + "'" + 'image' + "'" + ')"></td>'
			+ Sprache.TriggerText
			);
	
	// ausgabe footer
	$('#Foot').html('<p class="copyright">© Untitled. All rights reserved. Design: Gert Dorn 2019</p>'
	);
	
	function login() {		 
		var x = document;		
		var login = document.getElementById("pw").value;
		// alert (" hier in login " + login);
		if (login === 'admin'){
			window.localStorage.setItem('login', 'ok');
		} else {
			window.localStorage.setItem('login', 'no');
			alert ("Wrong login contact your administrator ");
		};
		
	}
	
	
	function getLang(lang) {
		// alert (" hier in getLang " + lang);
		window.localStorage.setItem('language', lang);
	}
	
	
	