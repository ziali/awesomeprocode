<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Admin Interface </title>
<style>
.tabs {
	margin: 0;
	padding: 0;	
	zoom : 1;
}
.tabs li {
	float: left;
	list-style: none;
	padding: 0;
	margin: 0;
}
.tabs a {
	display: block;
	text-decoration: none;
	padding: 3px 5px;
	background-color: rgb(339,538,695);
	margin-right: 10px;
	border: 1px solid rgb(153,153,153);
	margin-bottom: -1px;
}
.tabs .active {
	border-bottom: 1px solid white;
	background-color: white;
	color: rgb(51,72,115);
	position: relative;
	text-decoration: none;
}

.panelContainer {
	clear: both;
	margin-bottom: 25px;	
	border: 1px solid rgb(153,153,153);	
	background-color: white;
	padding: 10px;
}
</style>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
<script src="../../js/jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css" />

<script>
$(document).ready(function() {
	$('.tabs a').click(function() {
		var $this=$(this);
		$('.panel').hide();
		$('.tabs a.active').removeClass('active');
		$this.addClass('active').blur();
		var panel = $this.attr('href');
		$(panel).fadeIn(250);
		return false;
	});//end click
	$('.tabs li:first a').click();
}); // end ready
</script>

<script>
$(function() {
        $( "#fromdateupdate" ).datepicker({ dateFormat: "yy-mm-dd" , changeMonth : true, changeYear : true, yearRange : "1940:2013"});
		$( "#todateupdate" ).datepicker({ dateFormat: "yy-mm-dd" , changeMonth : true, changeYear : true, yearRange : "1940:2013"});
		$( "#dob" ).datepicker({ dateFormat: "yy-mm-dd", changeMonth : true, changeYear : true, yearRange : "1940:2013"});
		$("#hiredate").datepicker({ dateFormat: "yy-mm-dd" , changeMonth : true, changeYear : true, yearRange : "1940:2013"});
		$("#hiredate").datepicker("setDate", new Date());
		$( "#salaryfrom_add" ).datepicker({ dateFormat: "yy-mm-dd" , changeMonth : true, changeYear : true, yearRange : "1940:2013"});
		$("#salaryfrom_add").datepicker("setDate", new Date());
		$( "#salaryto_add" ).datepicker({ dateFormat: "yy-mm-dd" , changeMonth : true, changeYear : true, yearRange : "1940:2013"});
		$( "#dateofbirth" ).datepicker({ dateFormat: "yy-mm-dd" , changeMonth : true, changeYear : true, yearRange : "1940:2013"});
    });
    </script>
	
</head>
<body>
	<div class="main">
		<div class="tabbedPanels">
			<ul class="tabs">
				<li><a href="#panel1" tabindex="1">Search</a></li>
				<li><a href="#panel2" tabindex="2">Update</a></li>
				<li><a href="#panel3" tabindex="3">Add New</a></li>
				<li><a href="#panel4" tabindex="4">Delete</a></li>
			</ul>
		<div class="panelContainer">
	
	<div id="panel1" class="panel">
	
		<form action="/w1231339/index.php/find/findemp_admin" method="GET"> <br />
			First name: <input type="text" name="FIRSTNAME"/>		<br />
			Last name: <input type="text" name="LASTNAME" />  		<br />
			Department: <input type="text" name="DEPT" /> 			<br />
			Job Title: <input type="text" name="JOBTITLE" /> 			<br />
			<input type="submit" value="Search" />
		</form>
		
	</div>
	
	<div id="panel2" class="panel">
	
		<form action="/w1231339/index.php/find/update" method="GET">  <br />
			New Salary: <input type="text" name="salaryupdate" /> 				<br />
			First name: <input type="text" name="firstnameupdate"/>		<br />
			Last name: <input type="text" name="lastnameupdate" />  		<br />
			Department: <select name="deptupdate">
						<option value="d009">Customer Service</option>
						<option value="d005">Development</option>
						<option value="d002">Finance</option>
						<option value="d003">Human Resources</option>
						<option value="d001">Marketing</option>
						<option value="d004">Production</option>
						<option value="d006">Quality Management</option>
						<option value="d008">Research</option>
						<option value="d007">Sales</option>
						</select>	<br />
			Job Title: <input type="text" name="jobtitleupdate" /> 			<br />
			Salary start date: <input type="text" id="fromdateupdate" name="fromdateupdate" /> 			<br />
			Salary end date: <input type="text" id="todateupdate" name="todateupdate" /> 				<br />
			<input type="submit" value="Update" />
		</form>
		Please note: results are returned in the most recently added order for the searched employees salary.
		<?php echo $updates; ?>
	</div>
	
	<div id="panel3" class="panel">
	
		<form action="/w1231339/index.php/find/addemp" method="GET">  <br />
			First Name: <input type="text" name="firstnameadd" /> 			<br />
			Last Name: <input type="text" name="lastnameadd" /> 			<br />
			Gender: <input type="radio" name="gender" value="M" />Male
					<input type="radio" name="gender" value="F" />Female <br />
			D.O.B.  <input type="text" id="dob" name="dateofbirth_add" />   <br />
			Job Title: <input type="text" name="jobtitleadd" /> 			<br />
			Department: <select name="deptadd">
						<option value="d009">Customer Service</option>
						<option value="d005">Development</option>
						<option value="d002">Finance</option>
						<option value="d003">Human Resources</option>
						<option value="d001">Marketing</option>
						<option value="d004">Production</option>
						<option value="d006">Quality Management</option>
						<option value="d008">Research</option>
						<option value="d007">Sales</option>
						</select>	<br />
			Hire Date: <input type="text" id="hiredate" name="hiredate" />  <br />
			Salary: <input type="text" name="salaryadd" /> From: <input type="text" id="salaryfrom_add" name="salaryfrom_add" /> To: <input type="text" id="salaryto_add" name="salaryto_add" /> <br />
			<input type="submit" value="Add" />
		</form>
		<?php echo $success; ?>
	</div>
	
	<div id="panel4" class="panel">
	
		<form action="/w1231339/index.php/find/delete" method="GET"> 	<br />
			First Name: <input type="text" name="firstnamedelete" /> 			<br />
			Last Name: <input type="text" name="lastnamedelete" /> 			<br />
			Department: <select name="departmentdelete">
						<option value="d009">Customer Service</option>
						<option value="d005">Development</option>
						<option value="d002">Finance</option>
						<option value="d003">Human Resources</option>
						<option value="d001">Marketing</option>
						<option value="d004">Production</option>
						<option value="d006">Quality Management</option>
						<option value="d008">Research</option>
						<option value="d007">Sales</option>
						</select>	<br />
			Job Title: <input type="text" name="jobtitledelete" />	<br />
			D.O.B. <input type="text" id="dateofbirth" name="dateofbirth_delete" /> <br />
			Gender: <input type="radio" name="genderdelete" value="M" />Male
					<input type="radio" name="genderdelete" value="F" />Female <br />
			<input type="submit" value="Delete" />
		</form>
		<?php echo $deletes; ?>
	</div>
	
		</div>
		</div>
	</div>
<a href="/w1231339/index.php/find/logout">Logout</a>
</body>
</html>