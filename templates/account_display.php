<body>
	<div id="topnav">
    <ul>
        <li><a href="account.php"><em>ACCOUNT</em></a></li> 
        <!--<li><a href="year.php?year=">YEAR</a></li>--> <!--Decided not to implement-->
        <li>MONTH</li>
        <li>WEEK</li>
        <li><a href="index.php">DAY</a></li>
        <li><a href="logout.php"><em>LOGOUT</a></em></li>
     </ul>    
 </div>

 <hr id="sep" />
 <!--left nav-->
 <div id="leftnav">
        <ul>
            <li>Add Event</li>
        </ul>
 </div>
	<!--right nav-->        
	<div id="rightnav">
    <ul>
          
     </ul>          
	</div>
<div id="content">
<div align="center">
<!--print user's name-->
<em>User</em>: <?=$username?></br> 
<!--let user set filters-->
<em>Set Filters</em>:
<form id='loginform' action="accountupdate.php" method="post">
<!--print out each filter as option on form-->
<?php 
	for($i=0; $i<10;$i++)
	   echo('Filter '.($i+1).'<input name="filter'.($i+1).'" id="filter'.($i+1).'" type="text" /></br>');
?>
<button type="submit" class="btn">Submit</button>
</form>
<!--set default values for each filter as current, existing filter-->
<?php echo('
<script>
$(document).one("ready", function(){
    ');
          for($i=0; $i<10; $i++)
		  if ($filters[0]['filter'.($i+1)]!=NULL)
			echo('$("#filter'.($i+1).'").val("'.$filters[0]['filter'.($i+1)].'");');
    echo('
})
</script>
');
?>
</div>
