<!DOCTYPE html>
<html>
<head>
<title> Public Employee Search </title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript"></script>
</head>
<body>

<h4> Welcome to the Public Employee Search page. I hope your stay is short and sweet!</h4>

<form action="/w1231339/index.php/find/findemp" method="GET">
First Name: <input type="text" name='firstname' id="firstname" /> <br />
Last name: <input type="text" name='lastname' id="lastname"/> <br />
Department: <input type="text" name='dept' id="dept" /> <br />
Job Title: <input type="text" name='jobtitle' id="jobtitle"/> <br />
<input type="submit" value="Search" id="findsubmit" />
</form>

<div id="result"></div>

<script>
/*	$('#findsubmit').click(function() {
	
		var data = {
			firstname: $('#firstname').val(),
			lastname: $('#lastname').val(),
			dept: $('#dept').val(),
			jobtitle: $('#jobtitle').val()
		}
		
        $.get("/w1231339CI/index.php/auth/findemp",data,function(data) {
 
            $('#result').html('First name: ' + data.firstname + ' Last name: ' + data.lastname 
								+ ' Department ' + data.dept + ' Job Title ' + data.jobtitle);
        },"json");
        return false;
});*/
</script>

<a href="/w1231339/index.php/find/login">Login to an account</a>
</body>
</html>