$(document).ready(function(){
	request = $.ajax({
		url : "database/database.php",
		type : "post",
		data : {submit : "load"}
	});
	request.done(function(response,textStatus,jqXHR){
		if(response == "You need to login first"){
			alert(response);
			alert("Redirecting to login page");
			window.location = "guviIntern.html"
		}
		else{
			$.getJSON("database/"+response+".json",function(data){
				if(data.name){
					$("#name").val(data.name);
				}
				if(data.email){
					$("#email").val(data.email);
				}
				if(data.degree){
					$("#degree").val(data.degree);
				}
				if(data.department){
					$("#department").val(data.department);
				}
				if(data.age){
					$("#age").val(data.age);
				}
				if(data.college){
					$("#college").val(data.college);
				}
				if(data.contact){
					$("#contact").val(data.contact);
				}
				if(data.gender){
					$("input:radio[id="+data.gender+"]").prop("checked",true);
				}
			});
		}
	});
	request.fail(function (jqXHR, textStatus, errorThrown){
	   	alert(
	   		"The following error occurred: "+
	        textStatus, errorThrown
	    );
	});
	$("#profileform").submit(function(){
		name = $("#name").val();
		email = $("#email").val();
		degree = $("#degree").val();
		department = $("#department").val();
		age = $("#age").val();
		college = $("#college").val();
		contact = $("#contact").val();
		gender = $("input[name=gender]:checked","#profileform").val();
		submit = $("#update").val();
		request = $.ajax({
			url : "database/database.php",
			type : "post",
			data : {
				name : name,
				email : email,
				degree : degree,
				department : department,
				age : age,
				college : college,
				contact : contact,
				gender : gender,
				submit : submit

			}
		});
		request.done(function(response,textStatus,jqXHR){
			if(response == "Data updation successful"){
				alert(response);
			}
			else{
				alert(response);
			}
		});
		request.fail(function(jqXHR,textStatus,errorThrown){
			alert(
		            "The following error occurred: "+
		            textStatus, errorThrown
		        );
		});
		return false;
	});
	$("#logout").on("click",function(){
		request = $.ajax({
			url : "database/database.php",
			type : "post",
			data : {submit : $("#logout").val()}
		});
		request.done(function(response,textStatus,jqXHR){
			if(response == "logout successful"){
				alert(response);
				window.location = "guviIntern.html"
			}
		});
		request.fail(function(jqXHR,textStatus,errorThrown){
			alert(
		            "The following error occurred: "+
		            textStatus, errorThrown
		        );
		});
	});
});