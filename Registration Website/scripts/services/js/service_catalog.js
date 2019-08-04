function serviceCatalog()
{
	window.location = 'scripts/services/php/service_catalog.php';
}

function getServices()
{
	try
	{
		var message = null;
		$.ajax
		({
			url:   "../php/cimi_get_services.php",
			type:  "GET",
			async: false, 
			success: function(ans)
			{
				message = ans;
			}
		});
		return message;
	}
	catch (e){return 0;}
}

function goBack()
{
	window.location = '../../../index.php';
}

function launchService(service)
{
	try
	{	
		var service = service.id;
		var message = null;
		$.ajax
		({
			data: {service : service},
			url:   "../php/cimi_launch_service.php",
			type:  "POST",
			async: false, 
			success: function(ans)
			{
				message = ans;
			}
		});
		if (message == 200){
			alert("Service started correctly");
			window.location = 'service_catalog.php';
		} else{
			alert("Service was unable to start correctly");
		}
	}
	catch (e){return 0;}
}

function deleteService(service)
{
	try
	{	
		var service = service.id;
		var message = null;
		$.ajax
		({
			data: {service : service},
			url:   "../php/cimi_delete_service.php",
			type:  "POST",
			async: false, 
			success: function(ans)
			{
				message = ans;
			}
		});
		if (message == 200){
			window.location = 'service_catalog.php';
		} else{
			alert("Error deleting the service");
		}
	}
	catch (e){return 0;}
}

window.onload=function(){

	var servicesJson = getServices();
	var services = JSON.parse(servicesJson);
	var catalog = document.getElementById('catalog');
	var r=0;
	var width = $(window).width();
	var comlumns = 4;
	var columnSize = "l3"
	if(width<1080){
		comlumns = 2;
		columnSize = "m6"
	}
	if(width<600){
		comlumns = 1;
		columnSize = "s12"
	}
	var rows = Math.floor(services.length/comlumns);
	var remainder = services.length % comlumns;
	var counter = 0;

	while(r<rows){

		var c=0;
		createRow(catalog, r);
		
		while(c<comlumns){
			var service = services[counter];
			var id = r+""+c;
			createColumn(catalog, id, r, service, columnSize);
			c++;
			counter++;
		}
		r++;
	}

	if(remainder>0){
		var c=0;
		createRow(catalog, r);
		while(c<remainder){
			var service = services[counter];
			var id = r+""+c;
			createColumn(catalog, id, r, service, columnSize);
			c++;
			counter++;
		}
	}

	var ele = document.createElement("button");
	ele.setAttribute("class","button button-back");
	ele.setAttribute("onClick","goBack()");
	ele.innerHTML="Back";
	catalog.appendChild(ele);
};

function createRow(catalog, id){

	var ele = document.createElement("div");
	ele.setAttribute("id","row"+id);
	ele.setAttribute("class","w3-row w3-container");
	catalog.appendChild(ele);
}

function createColumn(catalog, id, r, service, columnSize){

	var ele = document.createElement("div");
	ele.setAttribute("id","col"+id);
	ele.setAttribute("class","w3-col w3-center "+ columnSize);
	document.getElementById("row"+r).appendChild(ele);

	var ele = document.createElement("div");
	ele.setAttribute("id","container"+id);
	ele.setAttribute("class","w3-container");
	ele.setAttribute("style","width:100%");
	document.getElementById("col"+id).appendChild(ele);

	var ele = document.createElement("div");
	ele.setAttribute("id","card"+id);
	ele.setAttribute("class","w3-card-4 w3-white");
	document.getElementById("container"+id).appendChild(ele);

	var ele = document.createElement("header");
	ele.setAttribute("id","header"+id);
	ele.setAttribute("class","w3-container w3-container-header w3-blue");
	document.getElementById("card"+id).appendChild(ele);

	var ele = document.createElement("h2");
	ele.setAttribute("id","title"+id);
	ele.innerHTML=service['name'];
	document.getElementById("header"+id).appendChild(ele);

	var ele = document.createElement("div");
	ele.setAttribute("id","content"+id);
	ele.setAttribute("class","w3-container w3-center");
	document.getElementById("card"+id).appendChild(ele);

	var ele = document.createElement("div");
	ele.setAttribute("id","content-container"+id);
	ele.setAttribute("class","w3-container w3-container-fixed w3-center w3-padding-16");
	document.getElementById("content"+id).appendChild(ele);

	var ele = document.createElement("p");
	ele.setAttribute("id","p"+id);
	ele.innerHTML=service['description'];
	document.getElementById("content-container"+id).appendChild(ele);

	var ele = document.createElement("div");
	ele.setAttribute("id","section"+id);
	ele.setAttribute("class","w3-section");
	document.getElementById("content"+id).appendChild(ele);

    var ele = document.createElement("h6");
	ele.setAttribute("id","h6"+id);
	ele.innerHTML=service['exec_type'];
	document.getElementById("section"+id).appendChild(ele);

	var ele = document.createElement("button");
	ele.setAttribute("id","button_launch"+id);
	ele.setAttribute("class","button button-launch");
	ele.onclick = function() {  launchService(service);  }
	ele.innerHTML="Launch";
	document.getElementById("section"+id).appendChild(ele);

	var ele = document.createElement("button");
	ele.setAttribute("id","button_delete"+id);
	ele.setAttribute("class","button button-delete");
	ele.onclick = function() {  deleteService(service);  }
	ele.innerHTML="Delete";
	document.getElementById("section"+id).appendChild(ele);
}

