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
	$("#logform").submit(function(){
		email = $("#email").val();
		pass = $("#pass").val();
		submit = $("#login").val();
		request = $.ajax({
			url : "database/database.php",
			type : "post",
			data : {
				email : email,
				pass : pass,
				submit : submit
			}
		});

		request.done(function(response,textStatus,jqXHR){
			if(response == "Not registered yet?"){
				alert(response);
				alert("Redirecting to registration page");
				window.location = "signup.html";
			}
			else if(response == "Login successful"){
				alert(response);
				window.location = "profile.html";
			}
			else if(response == "Invalid email or password"){
				alert(response);
			}
			else{
				alert("Unknown Error");
			}
		});

		request.fail(function(jqXHR,textStatus,errorThrown){
			alert(
				"The following error occured:"+
				textStatus,errorThrown
			);
		});
		return false;
	});
});