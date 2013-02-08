<style>
img
{
    width:1300px;
    height:450px;
    text-align:center;
}
#loginstuff
{
    float:right;
    margin:0 10px 20px 0;
}
</style>
</head>
<body>
<div id="loginstuff">
<form id="loginform" action="login.php" method="post">
	<input name="username" id="username" placeholder="Username" type="text"/>
        <input name="password" id="password" placeholder="Password" type="password"/>
        <button type="submit" class="btn">Submit</button>
</form>
    or <a href="register.php">register</a> for an account
</br>
</div>
<img src="img/Calendar_Cartoon.jpg"/>
</div>
<!--check that appropriate form fields filled out-->
<script>
$(document).ready(function(){
	$('#loginform').submit(function(){
		if($('#username').val()==='')
			alert('Please provide username.');
		if($('#password').val()==='')
			alert('Please provide password.');
	return false;	
	})
	else
	return true;
})
</script>
