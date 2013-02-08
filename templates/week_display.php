<style>
/*contains content other than top title*/
#container2
{
    height:380px;
    width:920px;
    overflow:hidden;
    margin-top:5px;
}
/*hides y-overflow and displays scoll bar on hover*/
#container2:hover
{   
    overflow-y:auto;
}
/*table for the whole week: each day of the week and time column is a table cell*/
#week {
  table-layout: fixed;
  width:911px;
  height:375px;
  border-collapse:collapse;
  margin:3px 3px 3px 9px;
  padding:0 0 0 0;
  vertical-align:top;
}
/*time cell to the left of days of week in the table*/
#timetd{
    width: 4px;
    border:1px solid black;
    height:340px;
    margin:0 0 0 0;
    vertical-align:top;
}
/*cells that are days of the week*/
.daytd {
    width:15px;
    border:1px solid black;
    height:340px;
    margin:0 0 0 0;
    vertical-align:top;
}
.weekcell
{
    overflow:scroll;
}
/*innertime is a table inside the time column whose cells represent time increments; inner refers to the tables inside the days of the week columns that correspond to the time increments in innertime. this way we can graphically display events according to how much time they take*/
.innertime, .inner{

    height:100%;
    width:100%;
    border-collapse:collapse;
    
    border-left:none;
    border-right:none;
    table-layout:fixed;
    
} 
 
.innertime td, .inner td{
    border:1px solid black;
    width:100%;
    height:15px;
    border-collapse:collapse;
    margin:-1px -1px -1px -1px;
    border-left:none;
    border-right:none;
    text-align:center;
    background-color:#FFFFFF;
    font-family: Copperplate / Copperplate Gothic Light, sans-serif;
    font-size:10px;
    color:#000000;
    vertical-align:middle;
    
    
}
/*titlecell carries the heading ie name of the day of the week*/
.innertime .titlecell, .inner .titlecell
{
    width:4px;
    height:26px;
    text-align:center;
    background-color:#C0C0C0;
    
    font-family: Copperplate / Copperplate Gothic Light, sans-serif;
    font-size:20px;
    color:#FFFFFF;
    text-decoration:none;
    
    border:1px solid black;
    border-collapse:collapse;
    margin:-1px -1px -1px -1px;
    border-left:none;
    border-right:none;
    vertical-align:top;

}
/*each titlecell is also a link to day.php day view for that day*/
.inner .titlecell a
{
    font-family: Copperplate / Copperplate Gothic Light, sans-serif;
    font-size:20px;
    color:#FFFFFF;
    text-decoration:none;
}
/*scrollbar on hover effect for overflow. we need to use divs to control overflow; doesn't work with tds*/
.daytd td div{
    overflow:hidden;
}
.daytd td:hover div{
    overflow:auto;
}
/*format plus-image in title cell that user can click to add event to that day of the week*/
.titlecell img
{
    width:10px;
    height:auto;
    visibility:hidden;
}
/*visible on hover effect for plus-image to add event*/
.titlecell:hover img
{
    visibility:visible;
}
/*visible on hover effect for x-image to remove events on click*/
.daytd td form
{
    width:10px;
    height:auto;
    visibility:hidden;
    display:inline-block;
}
.daytd td:hover form
{
    visibility:visible;
}
.imagebutton
{
    width:10px;
    height:auto;
    display:inline;
}
</style>
</head>

<body>
<!--same top nav bar as day_display-->
 <div id="topnav">
    <ul>
        <li><a href="account.php"><em>ACCOUNT</em></a></li> 
        <!--<li><a href="year.php">YEAR</a></li>--><!--decided not to implement-->
        <li><a href="month.php?year=<?=$mon['year']?>&month=<?=$mon['month']?>&day=<?=$mon['day']?>&dayofwk=1">MONTH</a></li>
        <li><em>WEEK</em></li>
        <li>DAY</li>
        <li><a href="logout.php"><em>LOGOUT</a></em></li>
     </ul>    
 </div>

 <hr id="sep" />
  <!--same left nav bar as day_display-->  
	<div id="leftnav">
        <ul>
            <li>Add Event</li>
        </ul>
    </div>
  <!--right nav bar is a bit different. Instead of filtering dynamically, the filtering is a form with a submit button to reload the page. This is because events are added by spanning table cells whereas in day_view each event was assigned to a single table cell, so it is a lot harder to filter dynamically-->      
	<div id="rightnav">
    <ul>
        <li><em>Filters</em></li>       
        <form id="filter" method="post" action="filterweek.php">
        <table>
						<!--as in day_display, filters for all day events and regularly occuring-->
            <tr><td><input type="checkbox" name="allday" id="allday" value="allday" checked /></td><td><label for="allday">All Day</label></td></tr></br>
            <tr><td><input type="checkbox" name="notonetime" id="notonetime" value="notonetime" checked /></td><td><label for="notonetime">Regularly Ocurring</label></td></tr></br>
						<!--print out the user-determined filters-->
            <?php 
                for($i=1, $end=count($filters[0])-2; $i<$end; $i++)
                {
                    if ($filters[0]["filter".$i]!=NULL)        
                    echo('<tr><td><input type="checkbox" name="filter'.$i.'" id="filter'.$i.'" value="filter'.$i.'" checked /></td><td><label for="filter'.$i.'">'.$filters[0]["filter".$i].'</label></td></tr>');
        
                }
            ?>        
        </table>
        <input type="submit" value="Go" />
				<!--reset button undoes filters by reloading week_display with every event on it-->
        <input type="button" onClick="location.href='week.php?year=<?=$mon['year']?>&month=<?=$mon['month']?>&day=<?=$mon['day']?>&dayofwk=1'" value="Reset" />
        </form>   
        </ul>          
</div>

<div id="content">

<div class="toptitle"><!--the title is Monday (Month and Date) to Sunday (Month and Date)-->
		<!--as in day_display, decrement with image button on hover-->		
		<form id="decrement" method="GET" action="week.php">
    		<input type="image" src="img/leftarrow.png" />
		</form>
    <?php echo(numtomonth($mon['month']).' '.$mon['day'].'-'.numtomonth($sun['month']).' '.$sun['day'])?>
		<!--as in day_display, increment with image button on hover-->    
		<form id="increment" method="GET" action="week.php">
    	<input type="image" src="img/rightarrow.png" />
		</form>
</div>

<div id="container2">
<!--the table "week" contains 8 cells, 1 with time and the others containing days of the week. There are nested tables inside each of these cells too-->
<table id="week">
<!--first td: time column with all 24 hours-->
	<td id="timetd">
		<div>
			<table class="innertime"><!--a table inside the time cell to display time increments-->
			<tr><td class="titlecell"></td></tr><!--first cell--doesn't correspond to any time, just fills up space taken by title cells in day of week columns-->
<?php /*each cell is its own row and represents 15 minutes. A label in printed every hour, or every four cells*/
for ($i=0;$i<96;$i++)
    if ($i==0)
        echo('<tr id="rt"><td><div>12AM</div></td></tr>'); /*handle 12am case. also, this first cell is labeled 'rt' for reference later when we need to add cells above it*/
    else if ($i==48)
        echo('<tr><td><div>12PM</div></td></tr>');/*and 12pm case*/
    else if (($i%4==0)&&(($i/4)<12))
        echo('<tr><td><div>'.($i/4).'AM</div></td></tr>');/*am multiple of 4*/
    else if (($i%4==0)&&(($i/4)>12))
        echo('<tr><td><div>'.($i/4-12).'PM</div></td></tr>');/*pm multiple of 4*/
    else
        echo('<tr><td><div></div></td></tr>');/*not a multiple of 4*/
?>
</table>
</div>
</td>

<td class="daytd"><!--table cell for Monday-->
<table class="inner"><!--inner table with increments corresponding to those for time-->
<tr><td class="titlecell">
	<!--each title cell is also a link to the corresponding day view day-->		
	<a href="day.php?year=<?=$mon['year']?>&month=<?=$mon['month']?>&day=<?=$mon['day']?>&dayofwk=<?=$mon['dayofwk']?>">Mon</a> 
	<!--in addition, there is a plus image that appears on hover to add an event to this particular day-->
	<a id='1' class="addeventwindow" href="#addeventbox2" class="addeventwindow"><img src="img/plus2.png" id="plus2" /></a>
</td></tr>
<!--print all the increment cells and label each one with an id: (corresponding 15-min time increment).1 (1 for Monday)-->
<?php 
for ($i=0;$i<96;$i++)
        echo('<tr id="r'.$i.'1"><td id="'.$i.'1"><div></div></td></tr>');
?>
</table>
</td>

<!--same for Tuesday-->
<td class="daytd">
<table class="inner">
<tr><td class="titlecell"><a href="day.php?year=<?=$tue['year']?>&month=<?=$tue['month']?>&day=<?=$tue['day']?>&dayofwk=<?=$tue['dayofwk']?>">Tue</a> <a id='2' class="addeventwindow" href="#addeventbox2" class="addeventwindow"><img src="img/plus2.png" id="plus2" /></a></td></tr>
<?php 
for ($i=0;$i<96;$i++)
        echo('<tr id="r'.$i.'2"><td id="'.$i.'2"><div></div></td></tr>');
?>
</table>
</td>

<!--same for Wednesday-->
<td class="daytd">
<table class="inner">
<tr><td class="titlecell"><a href="day.php?year=<?=$wed['year']?>&month=<?=$wed['month']?>&day=<?=$wed['day']?>&dayofwk=<?=$wed['dayofwk']?>">Wed</a> <a id='3' class="addeventwindow" href="#addeventbox2" class="addeventwindow"><img src="img/plus2.png" id="plus2" /></a></td></tr>

<?php 
for ($i=0;$i<96;$i++)
        echo('<tr id="r'.$i.'3"><td id="'.$i.'3"><div></div></td></tr>');
?>
</table>
</td>

<!--Same for Thu-->
<td class="daytd">
<table class="inner">
<tr><td class="titlecell"><a href="day.php?year=<?=$thu['year']?>&month=<?=$thu['month']?>&day=<?=$thu['day']?>&dayofwk=<?=$thu['dayofwk']?>">Thu</a> <a id='4' class="addeventwindow" href="#addeventbox2" class="addeventwindow"><img src="img/plus2.png" id="plus2" /></a></td></tr>
<?php 
for ($i=0;$i<96;$i++)
        echo('<tr id="r'.$i.'4"><td id="'.$i.'4"><div></div></td></tr>');
?>
</table>
</td>

<!--same for Fri-->
<td class="daytd">
<table class="inner">
<tr><td class="titlecell"><a href="day.php?year=<?=$fri['year']?>&month=<?=$fri['month']?>&day=<?=$fri['day']?>&dayofwk=<?=$fri['dayofwk']?>">Fri</a> <a id='5' class="addeventwindow" href="#addeventbox2" class="addeventwindow"><img src="img/plus2.png" id="plus2" /></a></td></tr>

<?php 
for ($i=0;$i<96;$i++)
        echo('<tr id="r'.$i.'5"><td id="'.$i.'5"><div></div></td></tr>');
?>
</table>
</td>

<!--same for Sat-->
<td class="daytd">
<table class="inner">
<tr><td class="titlecell"><a href="day.php?year=<?=$sat['year']?>&month=<?=$sat['month']?>&day=<?=$sat['day']?>&dayofwk=<?=$sat['dayofwk']?>">Sat</a> <a id='6' class="addeventwindow" href="#addeventbox2" class="addeventwindow"><img src="img/plus2.png" id="plus2" /></a></td></tr>
<?php 
for ($i=0;$i<96;$i++)
        echo('<tr id="r'.$i.'6"><td id="'.$i.'6"><div></div></td></tr>');
?>
</table>
</td>

<!--same for Sun-->
<td class="daytd">
<table class="inner">
<tr><td class="titlecell"><a href="day.php?year=<?=$sun['year']?>&month=<?=$sun['month']?>&day=<?=$sun['day']?>&dayofwk=<?=$sun['dayofwk']?>">Sun</a> <a id='7' class="addeventwindow" href="#addeventbox2" class="addeventwindow?"><img src="img/plus2.png" id="plus2" /></a></td></tr>
<?php 
for ($i=0;$i<96;$i++)
        echo('<tr id="r'.$i.'7"><td id="'.$i.'7"><div></div></td></tr>');
?>
</table>
</td>
<!--and that's it for our mega table-->
</table>
</div>
    
<!--now to add stuff to that table-->
<?php
/*a helper function just to avoid retyping too much*/
function findcellhelper($st, $en, $dayofwk)
{
    $start=roundtime($st);/*rounds start time of event to nearest 15-minute increment by calling round*/
    $end=roundtime($en);/*does the same for end time*/
    /*rowspan=number of increments*/
    $rowspan=($end-$start)/0.25;
    if ($rowspan==0)
        $rowspan=1;
    $cellid=($start*4).$dayofwk;/*calculate cell id--we labeled all of them uniquely above with (15 min increment number).(day of week)*/  
    return array("start"=>$start, "end"=>$end, "rowspan"=>$rowspan, "cellid"=>$cellid); 
}
/*now we put each event in its corresponding cell and give it the appropriate rowspan according to how long it takes. Like in day_display we have to deal with cases of overlapping events by putting them in the same cell*/
function findcell($dayofwk, $rows)
{
    $length=count($rows);
    $i=0;
    while ($i<$length)
    {
        if (empty($rows[$i]))
        {
					/*this is a possibility because of the way we will be handling filters in week_display*/
        }
        else
        if ($rows[$i]["allday"]==1)/*all day, so we can't add it to any of the 15-minute increments. Instead, we create space by adding a new row to each day of the week, before any of the rows representing time increments. this is what the labels on the first cell directly below the title cell is for, so we have a reference point (rt, r01, r02...r07). In the time column we are going to write "All Day" in the cell that we add so that it won't be confused with a time increment. The others we will leave empty for now, then we will use a script to add our all day event into our desired, newly created space under the correct day of the week*/
        {
        $timeinfo=findcellhelper($rows[$i]['start'], $rows[$i]['end'], $dayofwk);
        echo("
        <script>
            var thiscell=$('#r0".$dayofwk."').prev().find('div');
            if (!(thiscell.is(':empty')))
            {
                $('<tr><td><div>All Day</div></td></tr>').insertBefore('#rt');
                $('<tr><td id=\'1\'><div></div></td></tr>').insertBefore('#r01');
                $('<tr><td id=\'2\'><div></div></td></tr>').insertBefore('#r02');
                $('<tr><td id=\'3\'><div></div></td></tr>').insertBefore('#r03');
                $('<tr><td id=\'4\'><div></div></td></tr>').insertBefore('#r04');
                $('<tr><td id=\'5\'><div></div></td></tr>').insertBefore('#r05');
                $('<tr><td id=\'6\'><div></div></td></tr>').insertBefore('#r06');
                $('<tr><td id=\'7\'><div></div></td></tr>').insertBefore('#r07');
                thiscell=$('#r0".$dayofwk."').prev().find('div');
            }
            thiscell.append('<span id=\'".$rows[$i]['start']."\' class=\'".$rows[$i]['end']."\'>".$rows[$i]['event']."</span> <form class=\'rm\' method=\'post\' action=\'deleteeventweek.php\'><input type=\'image\' src=\'img/x3.png\' class=\'imagebutton\' /></form>');
            thiscell.css('height','15px');
            ");
         echo("</script>");/*We also appended a span tag containing start and end time information. We will need this later on if we want to delete this event. The form is an image (again, an x that appears on hover) that posts to the delete event php page*/       
         }
       else
         if (($i+1)>=$length) /*like in day_display, we check for time overlap by comparing against the next event, so we want to handle the case where we are at the last event (ie there is no next event)*/
         {
            $timeinfo=findcellhelper($rows[$i]['start'], $rows[$i]['end'], $dayofwk);
						/*we will again get the necessary id and rowspan. The information we append includes start and end time, event name, span with start and end times (for use with deleting events), and clickable image for deleting event*/           
            echo("
                <script>
                    $('#".$timeinfo['cellid'].">div')
                        .append('<b>".converttime($rows[$i]['start']).'-'.converttime($rows[$i]['end'])."</b>:</br><span id=\'".$rows[$i]['start']."\' class=\'".$rows[$i]['end']."\'>".$rows[$i]['event']."</span> <form class=\'rm\' method=\'post\' action=\'deleteeventweek.php\'><input type=\'image\' src=\'img/x3.png\' class=\'imagebutton\' /></form>')
                    $('#".$timeinfo['cellid']."').attr('rowspan', '".$timeinfo['rowspan']."');
                    $('#".$timeinfo['cellid'].">div').css('height', '".(15*$timeinfo['rowspan'])."px');
                ");
					/*remove the unnecessary cells that we've covered in extending the rowspan of this cell*/
           for ($i=1;$i<$timeinfo['rowspan'];$i++)
            {
                echo("
                    $('#".(($timeinfo['start']*4+$i).$dayofwk)."').remove();
                    ");
            }
            echo("</script>"); 
         }
      else
      {
				/*not last event--check for overlap!*/
        $first=$i;
        $firsttime=$rows[$i]['start'];  
				/*while loops advances through overlapping events*/      
        while (($rows[$i]['start']===$rows[$i+1]['start'])||((!empty($rows[$i+1]['start']))&&($rows[$i]['end']>$rows[$i+1]['start'])))
        {
            $i++;
            if (($i+1)>=$length)
                break;            
        }
       	/*we need the first time and the last time of the last overlapped event to come up with the cell id we want (from first time) and the rowspan we need (from both)*/  
        $lasttime=$rows[$i]['end'];
        $timeinfo=findcellhelper($firsttime, $lasttime, $dayofwk);/*first add in the time range(frist->last)*/
            echo("
                <script>
                    $('#".$timeinfo['cellid'].">div')
                        .append('<b>".converttime($rows[$first]['start'])."-".converttime($rows[$i]['end'])."</b>:</br>');");
                    for ($j=$first;$j<=$i;$j++)/*now keep appending overlapping events in the same cell, each with its own span (with its own start and end for deleting purposes), its own event name, and  its own on-hover x-image for deleting purposes*/
                    {
                        if ($j<$i)
                            echo("$('#".$timeinfo['cellid'].">div').append('<span id=\'".$rows[$i]['start']."\' class=\'".$rows[$i]['end']."\'>".$rows[$j]['event']."</span> <form class=\'rm\' method=\'post\' action=\'deleteeventweek.php\'><input type=\'image\' src=\'img/x3.png\' class=\'imagebutton\'/></form></br>');");
                        else
                            echo("$('#".$timeinfo['cellid'].">div').append('<span id=\'".$rows[$i]['start']."\' class=\'".$rows[$i]['end']."\'>".$rows[$j]['event']."</span> <form class=\'rm\' method=\'post\' action=\'deleteeventweek.php\'><input type=\'image\' src=\'img/x3.png\' class=\'imagebutton\'/></form></br>');");
                    }
										/*now let it span!*/
                    echo("$('#".$timeinfo['cellid']."').attr('rowspan', '".$timeinfo['rowspan']."');
                    $('#".$timeinfo['cellid'].">div').css('height', '".(15*$timeinfo['rowspan'])."px');
                ");
					/*now delete the unnecessary rows covered by rowspan*/
           for ($j=1;$j<$timeinfo['rowspan'];$j++)
            {
                echo("
                    $('#".(($timeinfo['start']*4+$j).$dayofwk)."').remove();
                    ");
            }
            echo("</script>"); 
            
      }
     $i++;
    }
 }         
?>
<!--call the above function for each day of the week-->
<?php
    findcell(1, $monrows);
    findcell(2, $tuerows);
    findcell(3, $wedrows);
    findcell(4, $thurows);
    findcell(5, $frirows);
    findcell(6, $satrows);
    findcell(7, $sunrows);
?>

<!--handles filters(now it's a form) by appending additional necessary information not on the form because we will need to query the database again in the php page that handles the filters-->
<script>
$(document).ready(function(){
    $("#filter").submit(function(){
        
        $('<input>').attr({
            type: 'hidden',
            id: 'monyr',
            name:'monyr',
            value: <?=$mon['year']?>   
        }).appendTo('#filter');
        $('<input>').attr({
            type: 'hidden',
            id: 'monmon',
            name:'monmon',
            value: <?=$mon['month']?>   
        }).appendTo('#filter');
        $('<input>').attr({
            type: 'hidden',
            id: 'monday',
            name:'monday',
            value: <?=$mon['day']?>   
        }).appendTo('#filter');
      
      $('<input>').attr({
            type: 'hidden',
            id: 'tueyr',
            name:'tueyr',
            value: <?=$tue['year']?>   
        }).appendTo('#filter');
        $('<input>').attr({
            type: 'hidden',
            id: 'tuemon',
            name:'tuemon',
            value: <?=$tue['month']?>   
        }).appendTo('#filter');
        $('<input>').attr({
            type: 'hidden',
            id: 'tueday',
            name:'tueday',
            value: <?=$tue['day']?>   
        }).appendTo('#filter');
        
        $('<input>').attr({
            type: 'hidden',
            id: 'wedyr',
            name:'wedyr',
            value: <?=$wed['year']?>   
        }).appendTo('#filter');
        $('<input>').attr({
            type: 'hidden',
            id: 'wedmon',
            name:'wedmon',
            value: <?=$wed['month']?>   
        }).appendTo('#filter');
        $('<input>').attr({
            type: 'hidden',
            id: 'wedday',
            name:'wedday',
            value: <?=$wed['day']?>   
        }).appendTo('#filter');
        
        $('<input>').attr({
            type: 'hidden',
            id: 'satyr',
            name:'satyr',
            value: <?=$sat['year']?>   
        }).appendTo('#filter');
        $('<input>').attr({
            type: 'hidden',
            id: 'satmon',
            name:'satmon',
            value: <?=$sat['month']?>   
        }).appendTo('#filter');
        $('<input>').attr({
            type: 'hidden',
            id: 'satday',
            name:'satday',
            value: <?=$sat['day']?>   
        }).appendTo('#filter');
        
        $('<input>').attr({
            type: 'hidden',
            id: 'sunyr',
            name:'sunyr',
            value: <?=$sun['year']?>   
        }).appendTo('#filter');
        $('<input>').attr({
            type: 'hidden',
            id: 'sunmon',
            name:'sunmon',
            value: <?=$sun['month']?>   
        }).appendTo('#filter');
        $('<input>').attr({
            type: 'hidden',
            id: 'sunday',
            name:'sunday',
            value: <?=$sun['day']?>   
        }).appendTo('#filter');
        
        $('<input>').attr({
            type: 'hidden',
            id: 'thuyr',
            name:'thuyr',
            value: <?=$thu['year']?>   
        }).appendTo('#filter');
        $('<input>').attr({
            type: 'hidden',
            id: 'thumon',
            name:'thumon',
            value: <?=$thu['month']?>   
        }).appendTo('#filter');
        $('<input>').attr({
            type: 'hidden',
            id: 'thuday',
            name:'thuday',
            value: <?=$thu['day']?>   
        }).appendTo('#filter');
        
        $('<input>').attr({
            type: 'hidden',
            id: 'friyr',
            name:'friyr',
            value: <?=$fri['year']?>   
        }).appendTo('#filter');
        $('<input>').attr({
            type: 'hidden',
            id: 'frimon',
            name:'frimon',
            value: <?=$fri['month']?>   
        }).appendTo('#filter');
        $('<input>').attr({
            type: 'hidden',
            id: 'friday',
            name:'friday',
            value: <?=$fri['day']?>   
        }).appendTo('#filter');
    });
});
</script>
<!--append additional information for increment, which moves week view onto the next page. It does this by incrementing this week's Sunday-->
<script>
$(document).ready(function(){
    $("#increment").submit(function(){
        var info=<?= incrementday($sun['year'], $sun['month'], $sun['day'], $sun['dayofwk']) ?>;
        $('<input>').attr({
            type: 'hidden',
            id: 'year',
            name:'year',
            value: info.year   
        }).appendTo('#increment');
        $('<input>').attr({
            type: 'hidden',
            id: 'month',
            name:'month',
            value: info.month   
        }).appendTo('#increment');
        $('<input>').attr({
            type: 'hidden',
            id: 'day',
            name:'day',
            value: info.day   
        }).appendTo('#increment');
        $('<input>').attr({
            type: 'hidden',
            id: 'dayofwk',
            name:'dayofwk',
            value: info.dayofwk   
        }).appendTo('#increment');
    });
});
</script>
<!--similarly, decrement moves week view to the previous page by decrementing this week's monday-->
<script>
$(document).ready(function(){
    $("#decrement").submit(function(){
        var info=<?= decrementday($mon['year'], $mon['month'], $mon['day'], $mon['dayofwk']) ?>;
        $('<input>').attr({
            type: 'hidden',
            id: 'year',
            name:'year',
            value: info.year   
        }).appendTo('#decrement');
        $('<input>').attr({
            type: 'hidden',
            id: 'month',
            name:'month',
            value: info.month   
        }).appendTo('#decrement');
        $('<input>').attr({
            type: 'hidden',
            id: 'day',
            name:'day',
            value: info.day   
        }).appendTo('#decrement');
        $('<input>').attr({
            type: 'hidden',
            id: 'dayofwk',
            name:'dayofwk',
            value: info.dayofwk   
        }).appendTo('#decrement');
    });
});
</script>



<!--here is the addevent popup div. It is pretty the same as the one in day_display-->
<div id="addeventbox2" class="addeventpopup">
    <a href="#" class="close"><img src="img/x.png" id="x"/></a>
        <form method="post" class="eventadd" action="addeventweek.php">

            <b>ADD EVENT</b></br>
            Event <input name="event" placeholder="Event" type="text"/>
            
            <p class="formfield">
            Notes <textarea cols="40" rows="2" name="notes"></textarea>
            </p>
            Start <input name="starthour" type="text" maxlength=2 size=2 class="start" />:<input name="startmin" class="start" type="text" maxlength=2 size=2 />
            <select name="startampm">
                <option value="am">AM</option>
                <option value="pm">PM</option>
            </select>
            End <input name="endhour" class="start" type="text" maxlength=2 size=2 />:<input name="endmin" class="start" type="text" maxlength=2 size=2 />
            <select name="endampm">
                <option value="am">AM</option>
                <option value="pm">PM</option>
            </select>
            </br>
            <input type="checkbox"  id="alldayf" name="allday" value="1"/><label for="alldayf">All Day</label></br>
            Filters:</br>
            <?php 
                for($i=1, $end=count($filters[0])-2; $i<$end; $i++)
                {
                    if ($filters[0]["filter".$i]!=NULL)        
                    echo('<input type="checkbox" id="filter'.$i.'f" name="filter'.$i.'" value="1" /><label for="filter'.$i.'f">'.$filters[0]["filter".$i].'</label>');
        
                }
            ?>
            </br>
           
            <input type="submit" value="Add Event" />
        </form>
    </div>

<!--this appends additional information to the popup box, such as the yr/month/day in which the event is added. In this case it's more complex because this differs depending on which day of the week's increment button is clicked, so we have an id on each increment button saying that. A switch statement sends the appropriate info depending on which day of the week-->
<script>
$(document).ready(function() {
	$('a.addeventwindow').click(function() {
	    var id=$(this).attr('id');
	    var form=$('.eventadd');
	       
        switch(id)
	    {
	        case '1':
	        {
	            $('<input>').attr({
                    type: 'hidden',
                    id: 'year',
                    name:'year',
                    value: <?php echo("'".$mon['year']."'"); ?>  
                }).appendTo(form);
                $('<input>').attr({
                    type: 'hidden',
                    id: 'month',
                    name:'month',
                    value: <?php echo("'".$mon['month']."'"); ?>   
                }).appendTo(form);
                $('<input>').attr({
                    type: 'hidden',
                    id: 'day',
                    name:'day',
                    value: <?php echo("'".$mon['day']."'"); ?>
                }).appendTo(form);
                $('<input>').attr({
                    type: 'hidden',
                    id: 'dayofwk',
                    name:'dayofwk',
                    value: '1'
                }).appendTo(form);
	            break;
	            }
	        case '2':
	            {
	            $('<input>').attr({
                    type: 'hidden',
                    id: 'year',
                    name:'year',
                    value: <?php echo("'".$tue['year']."'"); ?>  
                }).appendTo(form);
                $('<input>').attr({
                    type: 'hidden',
                    id: 'month',
                    name:'month',
                    value: <?php echo("'".$tue['month']."'"); ?>    
                }).appendTo(form);
                $('<input>').attr({
                    type: 'hidden',
                    id: 'day',
                    name:'day',
                    value: <?php echo("'".$tue['day']."'"); ?> 
                }).appendTo(form);
                $('<input>').attr({
                    type: 'hidden',
                    id: 'dayofwk',
                    name:'dayofwk',
                    value: '2'
                }).appendTo(form);
	            break;
	            }
	        case '3':
	            {
	            $('<input>').attr({
                    type: 'hidden',
                    id: 'year',
                    name:'year',
                    value: <?php echo("'".$wed['year']."'"); ?>  
                }).appendTo(form);
                $('<input>').attr({
                    type: 'hidden',
                    id: 'month',
                    name:'month',
                    value: <?php echo("'".$wed['month']."'"); ?>  
                }).appendTo(form);
                $('<input>').attr({
                    type: 'hidden',
                    id: 'day',
                    name:'day',
                    value: <?php echo("'".$wed['day']."'"); ?>
                }).appendTo(form);
                $('<input>').attr({
                    type: 'hidden',
                    id: 'dayofwk',
                    name:'dayofwk',
                    value: '3'
                }).appendTo(form);
	            break;
	            }
	        case '4':{
	            $('<input>').attr({
                    type: 'hidden',
                    id: 'year',
                    name:'year',
                    value: <?php echo("'".$thu['year']."'"); ?>  
                }).appendTo(form);
                $('<input>').attr({
                    type: 'hidden',
                    id: 'month',
                    name:'month',
                    value: <?php echo("'".$thu['month']."'"); ?>  
                }).appendTo(form);
                $('<input>').attr({
                    type: 'hidden',
                    id: 'day',
                    name:'day',
                    value: <?php echo("'".$thu['day']."'"); ?> 
                }).appendTo(form);
                $('<input>').attr({
                    type: 'hidden',
                    id: 'dayofwk',
                    name:'dayofwk',
                    value: '4' 
                }).appendTo(form);
	            break;
	            }
	        case '5':
	            {
	            $('<input>').attr({
                    type: 'hidden',
                    id: 'year',
                    name:'year',
                    value: <?php echo("'".$fri['year']."'"); ?>  
                }).appendTo(form);
                $('<input>').attr({
                    type: 'hidden',
                    id: 'month',
                    name:'month',
                    value: <?php echo("'".$fri['month']."'"); ?>
                }).appendTo(form);
                $('<input>').attr({
                    type: 'hidden',
                    id: 'day',
                    name:'day',
                    value: <?php echo("'".$fri['day']."'"); ?>
                }).appendTo(form);
                $('<input>').attr({
                    type: 'hidden',
                    id: 'dayofwk',
                    name:'dayofwk',
                    value: '5'
                }).appendTo(form);
	            break;
	            } 
	        case '6':
	            {
	            $('<input>').attr({
                    type: 'hidden',
                    id: 'year',
                    name:'year',
                    value: <?php echo("'".$sat['year']."'"); ?>  
                }).appendTo(form);
                $('<input>').attr({
                    type: 'hidden',
                    id: 'month',
                    name:'month',
                    value: <?php echo("'".$sat['month']."'"); ?>  
                }).appendTo(form);
                $('<input>').attr({
                    type: 'hidden',
                    id: 'day',
                    name:'day',
                    value: <?php echo("'".$sat['day']."'"); ?>
                }).appendTo(form);
                $('<input>').attr({
                    type: 'hidden',
                    id: 'dayofwk',
                    name:'dayofwk',
                    value: '6'
                }).appendTo(form);
	            break;
	            }
	        case '7':
	            {
	            $('<input>').attr({
                    type: 'hidden',
                    id: 'year',
                    name:'year',
                    value: <?php echo("'".$sun['year']."'"); ?>  
                }).appendTo(form);
                $('<input>').attr({
                    type: 'hidden',
                    id: 'month',
                    name:'month',
                    value: <?php echo("'".$sun['month']."'"); ?>    
                }).appendTo(form);
                $('<input>').attr({
                    type: 'hidden',
                    id: 'day',
                    name:'day',
                    value: <?php echo("'".$sun['day']."'"); ?> 
                }).appendTo(form);
                $('<input>').attr({
                    type: 'hidden',
                    id: 'dayofwk',
                    name:'dayofwk',
                    value: '7'
                }).appendTo(form);
	            break;
	            }     
	   }
		
		/*the following to make the popup div fade in and out is same as in day_display*/

    		//Getting the variable's value from a link 
		var loginBox = $(this).attr('href');

		//Fade in the Popup
		$(loginBox).fadeIn(300);
		
		//Set the center alignment 
		var popMargTop = ($(loginBox).height() + 24) / 2; 
		var popMargLeft = ($(loginBox).width() + 24) / 2; 
		
		$(loginBox).css({ 
			'margin-top' : -popMargTop,
			'margin-left' : -popMargLeft
		});
		
		// Add the mask to body
		$('body').append('<div id="mask"></div>');
		$('#mask').fadeIn(300);
		
		return false;
	});
	
	// When clicking on the button close or the mask layer the popup closed
	$('a.close, #mask').live('click', function() { 
	  $('#mask , .addeventpopup').fadeOut(300 , function() {
		$('#mask').remove();  
	}); 
	return false;
	});
});
</script>

<!--this is similar to in day_display and just checks that the add event input is valid-->
<script>
$(document).ready(function(){
    $('.eventadd').submit(function(){
	if ($('event').val()==="")
	{
		alert('Please enter an event name.');
		return false;
	}
	if ((($('starthour').val()==="")) && (($('endhour').val()==="")) && (!($('alldayf').is(':checked'))))
	{
		alert('You must specify a time or choose all day.');
		return false;
	}
	if ((!($('alldayf').is(':checked')))&&($('endhour').val()<$('starthour').val()))
	{
		alert('Event must start before it ends.');
		return false;
	}
   })
})
</script>
<!--this is also similar to in day_display and prevents all day and some time range from being chosen at the same time-->
<script>
$(document).ready(function(){
    $("#alldayf").change(function(){
        if ($(this).attr('checked'))
        {
            
            $('input.start').each(function(){
                $(this).attr('readonly', 'readonly');
                $(this).css('background', 'gray');
            })
            $('input.end').each(function(){
                $(this).attr('readonly', 'readonly');
                $(this).css('background', 'gray');
            })
        }
        else
        {
            
            $('input.start').each(function(){
                $(this).removeAttr('readonly');
                $(this).css('background', 'white');
            })
            $('input.end').each(function(){
                $(this).removeAttr('readonly');
                $(this).css('background', 'white');
            })
        }
  })
})
</script>
<!--removes an event when corresponding x is pressed. Similar to in add event, we need to append additional information that depends on what day of the week it is. In addition, to deleted an event from the database we also need to know its start and end time, information that we earlier encoded in the id's and classes of tds so that we can pull them out here. This is really the only way we can handle it because we did not store overlapping events in separate cells, so we instead put each one in between span tags containing the info-->
<script>
$(document).ready(function(){
    $('.rm').submit(function(){
        var eventname=$(this).prev().text();
        var dayofweek=($(this).parent().parent().attr('id'))%10;
        var start=$(this).prev().attr('id');
        var end=$(this).prev().attr('class');
        var form=$(this);
        $('<input>').attr({
            type:'hidden',
            id:'event',
            name:'event',
            value:eventname
        }).appendTo(form);                
        $('<input>').attr({
            type:'hidden',
            id:'start',
            name:'start',
            value: start
        }).appendTo(form);
        $('<input>').attr({
            type:'hidden',
            id:'end',
            name:'end',
            value: end
        }).appendTo(form);
        
        switch(dayofweek)
	   {
	        case 1:
	        {
	            $('<input>').attr({
                    type: 'hidden',
                    id: 'year',
                    name:'year',
                    value: <?php echo("'".$mon['year']."'"); ?>  
                }).appendTo(form);
                $('<input>').attr({
                    type: 'hidden',
                    id: 'month',
                    name:'month',
                    value: <?php echo("'".$mon['month']."'"); ?>   
                }).appendTo(form);
                $('<input>').attr({
                    type: 'hidden',
                    id: 'day',
                    name:'day',
                    value: <?php echo("'".$mon['day']."'"); ?>
                }).appendTo(form);
                $('<input>').attr({
                    type: 'hidden',
                    id: 'dayofwk',
                    name:'dayofwk',
                    value: <?php echo("'".$mon['dayofwk']."'"); ?> 
                }).appendTo(form);
	            break;
	            }
	        case 2:
	            {
	            $('<input>').attr({
                    type: 'hidden',
                    id: 'year',
                    name:'year',
                    value: <?php echo("'".$tue['year']."'"); ?>  
                }).appendTo(form);
                $('<input>').attr({
                    type: 'hidden',
                    id: 'month',
                    name:'month',
                    value: <?php echo("'".$tue['month']."'"); ?>    
                }).appendTo(form);
                $('<input>').attr({
                    type: 'hidden',
                    id: 'day',
                    name:'day',
                    value: <?php echo("'".$tue['day']."'"); ?> 
                }).appendTo(form);
                $('<input>').attr({
                    type: 'hidden',
                    id: 'dayofwk',
                    name:'dayofwk',
                    value: <?php echo("'".$tue['dayofwk']."'"); ?> 
                }).appendTo(form);
	            break;
	            }
	        case 3:
	            {
	            $('<input>').attr({
                    type: 'hidden',
                    id: 'year',
                    name:'year',
                    value: <?php echo("'".$wed['year']."'"); ?>  
                }).appendTo(form);
                $('<input>').attr({
                    type: 'hidden',
                    id: 'month',
                    name:'month',
                    value: <?php echo("'".$wed['month']."'"); ?>  
                }).appendTo(form);
                $('<input>').attr({
                    type: 'hidden',
                    id: 'day',
                    name:'day',
                    value: <?php echo("'".$wed['day']."'"); ?>
                }).appendTo(form);
                $('<input>').attr({
                    type: 'hidden',
                    id: 'dayofwk',
                    name:'dayofwk',
                    value: <?php echo("'".$wed['dayofwk']."'"); ?>
                }).appendTo(form);
	            break;
	            }
	        case 4:{
	            $('<input>').attr({
                    type: 'hidden',
                    id: 'year',
                    name:'year',
                    value: <?php echo("'".$thu['year']."'"); ?>  
                }).appendTo(form);
                $('<input>').attr({
                    type: 'hidden',
                    id: 'month',
                    name:'month',
                    value: <?php echo("'".$thu['month']."'"); ?>  
                }).appendTo(form);
                $('<input>').attr({
                    type: 'hidden',
                    id: 'day',
                    name:'day',
                    value: <?php echo("'".$thu['day']."'"); ?> 
                }).appendTo(form);
                $('<input>').attr({
                    type: 'hidden',
                    id: 'dayofwk',
                    name:'dayofwk',
                    value: <?php echo("'".$thu['dayofwk']."'"); ?> 
                }).appendTo(form);
	            break;
	            }
	        case 5:
	            {
	            $('<input>').attr({
                    type: 'hidden',
                    id: 'year',
                    name:'year',
                    value: <?php echo("'".$fri['year']."'"); ?>  
                }).appendTo(form);
                $('<input>').attr({
                    type: 'hidden',
                    id: 'month',
                    name:'month',
                    value: <?php echo("'".$fri['month']."'"); ?>
                }).appendTo(form);
                $('<input>').attr({
                    type: 'hidden',
                    id: 'day',
                    name:'day',
                    value: <?php echo("'".$fri['day']."'"); ?>
                }).appendTo(form);
                $('<input>').attr({
                    type: 'hidden',
                    id: 'dayofwk',
                    name:'dayofwk',
                    value: <?php echo("'".$fri['dayofwk']."'"); ?>
                }).appendTo(form);
	            break;
	            } 
	        case 6:
	            {
	            $('<input>').attr({
                    type: 'hidden',
                    id: 'year',
                    name:'year',
                    value: <?php echo("'".$sat['year']."'"); ?>  
                }).appendTo(form);
                $('<input>').attr({
                    type: 'hidden',
                    id: 'month',
                    name:'month',
                    value: <?php echo("'".$sat['month']."'"); ?>  
                }).appendTo(form);
                $('<input>').attr({
                    type: 'hidden',
                    id: 'day',
                    name:'day',
                    value: <?php echo("'".$sat['day']."'"); ?>
                }).appendTo(form);
                $('<input>').attr({
                    type: 'hidden',
                    id: 'dayofwk',
                    name:'dayofwk',
                    value: <?php echo("'".$sat['dayofwk']."'"); ?>
                }).appendTo(form);
	            break;
	            }
	        case 7:
	            {
	            $('<input>').attr({
                    type: 'hidden',
                    id: 'year',
                    name:'year',
                    value: <?php echo("'".$sun['year']."'"); ?>  
                }).appendTo(form);
                $('<input>').attr({
                    type: 'hidden',
                    id: 'month',
                    name:'month',
                    value: <?php echo("'".$sun['month']."'"); ?>    
                }).appendTo(form);
                $('<input>').attr({
                    type: 'hidden',
                    id: 'day',
                    name:'day',
                    value: <?=$sun['day']?> 
                }).appendTo(form);
                $('<input>').attr({
                    type: 'hidden',
                    id: 'dayofwk',
                    name:'dayofwk',
                    value: <?=$sun['dayofwk']?> 
                }).appendTo(form);
	            break;
	            }     
	   }
	
    })
})
</script>
<!--this does clean-up work for the addevent popup box. We appended the hidden information whenever the popup box was called up, but we need to clean it up whenever the x-image is pressed to close the box-->
<script>
$(document).ready(function(){
    $('#x').click(function(){
        $('input:hidden').each(function(){
            $(this).remove();
        })
    })
})
</script>
