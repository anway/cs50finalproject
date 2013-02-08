<style>
#formstuff
{
    position:fixed;
    top:30%;
    left:40%;
    background-color:#FFFFFF;
    padding: 15px 15px 15px 15px;
}
body
{
    background-image:url("img/Calendar_Cartoon.jpg");
}
</style>
</head>
<body>
<div id="formstuff">
<form id='registerform' action="register.php" method="post">
        Username: <input id="username" name="username" placeholder="Username" type="text"/>
        </br>
        Password: <input id="password" name="password" placeholder="Password" type="password"/>
        </br>
        Confirmation: <input id="confirmation" name="confirmation" placeholder="Confirmation" type="password"/>
        </br>
        <button type="submit" class="btn">Register</button>
</form>
<div>
    or <a href="login.php">log in</a> 
</div>
<!--check that appropriate form fields filled out-->
<script>
$(document).ready(function(){
	$('#registerform').submit(function(){
		if($('#username').val()==='')
			alert('Please provide username.');
		if($('#password').val()==='')
			alert('Please provide password.');
		if($('#password').val()!==$('#confirmation').val())
			alert('Passwords do not match.');
		return false;	
	})
	else
	    return true;
})
</script>
