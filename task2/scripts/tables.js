$(document).ready(function(){
    request = $.ajax({
        url : "database/database.php",
        type : "post"
    });
    request.done(function(response,textStatus,jqXHR){
        alert(response);
        json = JSON.parse(response);
        $('#userTable').DataTable({
            data: json,
            columns: [
                { title: "Name" },
                { title: "Register No."},
                { title: "Email" },
                { title: "Contact No." },
                { title: "Age" },
                { title: "Department" },
                { title: "College" },
            ]
        });
    });
    request.fail(function(jqXHR,textStatus,errorThrown){
        alert("The following error occured:" + textStatus,errorThrown);
    });
});