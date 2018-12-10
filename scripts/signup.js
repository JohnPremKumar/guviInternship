$(document).ready(function(){
	request = $.ajax({
		url : "database/database.php",
		type : "post",
		data : {submit : "load"}
	});
	request.done(function(response,textStatus,jqXHR){
		if(response == "You need to login first"){}
		else{
			alert("User already logged in");
			window.location = "profile.html";
		}
	});
	$("#supform").submit(function() {
		name = $("#name").val();
		email = $("#email").val();
		npass = $("#npass").val();
		cpass = $("#cpass").val();
		submit = $("#signup").val();
		if(npass != cpass){
			$("#passErr").text("*password mismatch");
		}
		else if(npass == cpass){
			request = $.ajax({
	        url: "database/database.php",
	        type: "post",
	        data: {
	  		name : name,
	  		email : email,
	  		npass : npass,
	  		submit : submit}
	    	});

		    request.done(function (response, textStatus, jqXHR){
		        if(response == "User already registered"){
		        	alert(response);
		        }
		        else if(response == "Signup successful"){
		        	alert(response);
		        	alert("Redirecting to login page");
		        	window.location = "guviIntern.html";
		        }
		        else{
		        	alert("unknown error");
		        }
		    });

		    request.fail(function (jqXHR, textStatus, errorThrown){
		        alert(
		            "The following error occurred: "+
		            textStatus, errorThrown
		        );
		    });
		}
	    return false;
	});
});