

<style> /*specific to this page*/
.tasks /*table containing day's events*/
{
    border:0.5px solid black;
    margin-left:2.1px;
    margin-right:0px;
    margin-top:0px;
    margin-bottom:0px;
    width:100%;
    text-align:center;
}
.tasks td
{
    border:1px solid black;
    margin-left:8px;
    margin-right:0px;
    margin-top:0px;
    margin-bottom:0px;
    text-align:center;
    position:relative;
}
.tasks td img /*ensures that x's for removing events are visible only when mouse is hovering over event's table cell*/
{
    position:absolute;
    top:2px;
    right:2px;
    width:20px;
    height:auto;
    visibility:hidden;
}
.tasks td:hover img /*ensures that x's for removing events are visible only when mouse is hovering over event's table cell*/
{
    visibility:visible;
}
</style>

 
</head>

<body>
	<div id="topnav">
    <ul>
        <li><a href="account.php"><em>ACCOUNT</em></a></li> 
        <!--<li><a href="year.php?year=">YEAR</a></li>--> <!--Decided not to implement-->
				<!--redirects to month view associated with this day-->
        <li><?php echo'<a href="month.php?year='.$year.'&month='.$month.'&day='.$day.'&dayofwk='.$dayofwk.'">'?>MONTH</a></li>
				<!--redirects to week view associated with thsi day-->
        <li><?php echo'<a href="week.php?year='.$year.'&month='.$month.'&day='.$day.'&dayofwk='.$dayofwk.'">'?>WEEK</a></li>
        <li><em>DAY</em></li>
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
        <li><em>Filters</em></li>
       
        <form>
        <table>
	    	<!--The first two filters are default: allday (start and end not specified) and regularly occurring (multiple instances can be added into calendar all at once)-->
            <tr><td><input type="checkbox" name="filter" id="allday" value="allday" checked /></td><td><label for="allday">All Day</label></td></tr></br>
            <tr><td><input type="checkbox" name="filter" id="notonetime" value="notonetime" checked /></td><td><label for="notonetime">Regularly Ocurring</label></td></tr></br>
           <!--prints the rest of the filters along with checkboxes that are by default checked-->
            <?php 
                for($i=1, $end=count($filters[0])-2; $i<$end; $i++)
                {
                    if ($filters[0]["filter".$i]!=NULL)        
                    echo('<tr><td><input type="checkbox" name="filter" id="filter'.$i.'" value="filter'.$i.'" checked /></td><td><label for="filter'.$i.'">'.$filters[0]["filter".$i].'</label></td></tr>');
        
                }
            ?>
        </table>
        </form>   
     </ul>          
	</div>

	<!--day view content-->
	<div id="content">
		<!--title: what day is currently being viewed-->
		<div class="toptitle">
			<!--click on plus sign to add an event. plus sign only appears when mouse is over it. also, clicking on it will cause a div labeled #addeventbox to appear in the center of the screen and everything else will be more opaque--> 
			<a href="#addeventbox" class="addeventwindow"><img src="img/plus" id="plus" /></a>
			<!--click on left arrow to go to previous day. also hover effect-->			
			<form id="decrement" method="GET" action="day.php">
    		<input type="image" src="img/leftarrow.png" />
			</form>
			<!--print title using day of week, month, and day. calls helper function to conver to word form-->
    	<?php echo(numtowk($dayofwk).', '.numtomonth($month).' '.$day)?>
			<!--click on right arrow to go to next day. also hover effect-->			
			<form id="increment" method="GET" action="day.php">
    		<input type="image" src="img/rightarrow.png" />
		</form>
	</div>

<!--this is the div that contains the form for adding events. It is hidden until the plus sign is clicked-->
	<div id="addeventbox" class="addeventpopup">
		<!--clicking the x image hides the div again-->
    <a href="#" class="close"><img src="img/x.png" id="x"/></a>
        <form method="post" class="eventadd" action="addeventday.php">
            <b>ADD EVENT</b></br>
								<!--user inputs event name-->
            		Event <input name="event" placeholder="Event" type="text"/>
								<!--input notes for event-->
            		<p class="formfield">
            			Notes <textarea cols="40" rows="2" name="notes"></textarea>
            		</p>
								<!--start time with am/pm-->
            		Start <input name="starthour" type="text" maxlength=2 size=2 class="start" />:<input name="startmin" class="start" type="text" maxlength=2 size=2 />
            			<select name="startampm">
                		<option value="am">AM</option>
                		<option value="pm">PM</option>
            			</select>
								<!--end time with am/pm-->
            		End <input name="endhour" class="start" type="text" maxlength=2 size=2 />:<input name="endmin" class="start" type="text" maxlength=2 size=2 />
            			<select name="endampm">
                		<option value="am">AM</option>
                		<option value="pm">PM</option>
            			</select>
            			</br>
									<!--checkbox for all day events-->
            			<input type="checkbox"  id="alldayf" name="allday" value="1"/><label for="alldayf">All Day</label></br>
									<!--output checkboxes for filters-->            			
									Filters:</br>
            			<?php 
                		for($i=1, $end=count($filters[0])-2; $i<$end; $i++) /*-2 offset because filters array is really a row of the table, not just filters*/
                		{
                    	if ($filters[0]["filter".$i]!=NULL)        
                    	echo('<input type="checkbox" id="filter'.$i.'f" name="filter'.$i.'" value="1" /><label for="filter'.$i.'f">'.$filters[0]["filter".$i].'</label>');
                		}
            			?>
            			</br>
            			<input type="submit" value="Add Event" />
        	</form>
    </div>

<!--other content for day view page(like events) besides toptitle-->
<div id="container">    
    <?php
        $i=0;      
        $end=count($rows);
				/*we will iterate over $rows, which contains all the events on this day. The complication comes in handling overlapping events, which we will print on the same table row in their own cells (to be resized into the same size by a script) whereas nonoverlapping events get their own row. converttime function is used to convert start and end time into numeric form with am/pm because they are stored in the database as hour.min, where hour is the integer part of a number and min is stored as the decimal part of a number. In each table cell we are printing start and end times (if applicable), event name, notes associated with event, x-image to delete event when clicked (also has hover effect)*/ 
        while($i<$end)
        {
            echo('<table class="tasks"><tr>');
            if ($rows[$i]["allday"]==1) /*all day events get their own row, and they're guaranteed to be first because they have start==0*/
                echo('<td class="cell" id="'.$i.'">'.$rows[$i]["event"].'<img src="img/x.png" onclick="delete_event(this,'.$year.','.$month.','.$day.',\''.$rows[$i]["event"].'\','.$rows[$i]["start"].','.$rows[$i]["end"].')"/></br>Notes: '.' '.$rows[$i]["notes"].'</td>');
            else if ($rows[$i]["end"]==0.00)
                echo('<td class="cell" id="'.$i.'"><b>'.converttime($rows[$i]["start"]).'</b><br/>'.$rows[$i]["event"].'<img src="img/x.png" onclick="delete_event(this,'.$year.','.$month.','.$day.',\''.$rows[$i]["event"].'\','.$rows[$i]["start"].','.$rows[$i]["end"].')" /></br>Notes: '.' '.$rows[$i]["notes"].'</td>');
            else if ($i+1>=$end) /*we will check for overlapping events by looking to see if the next event overlaps with our current one, so we need to handle the case where there is no next event ie this is the last event in $rows*/
                echo('<td class="cell" id="'.$i.'"><b>'.converttime($rows[$i]["start"]).'-'.converttime($rows[$i]["end"]).'</b></br>'.$rows[$i]["event"].'<img src="img/x.png" onclick="delete_event(this,'.$year.','.$month.','.$day.',\''.$rows[$i]["event"].'\','.$rows[$i]["start"].','.$rows[$i]["end"].')" /></br>Notes: '.' '.$rows[$i]["notes"].'</td>');
            else 
            {
              	/*not the last event in $rows*/  
                echo('<td class="cell" id="'.$i.'"><b>'.converttime($rows[$i]["start"]).'-'.converttime($rows[$i]["end"]).'</b></br>'.$rows[$i]["event"].'<img src="img/x.png" onclick="delete_event(this,'.$year.','.$month.','.$day.',\''.$rows[$i]["event"].'\','.$rows[$i]["start"].','.$rows[$i]["end"].')"/></br>Notes: '.' '.$rows[$i]["notes"].'</td>');
                $last=$rows[$i]["end"];
								/*if there is an overlap, keep going until there is no overlap*/
                while (($rows[$i]["start"]===$rows[$i+1]["start"])||($last>$rows[$i+1]["start"]))
                {
                    $i++;                   
                    echo('<td class="cell" id="'.$i.'"><b>'.converttime($rows[$i]["start"]).'-'.converttime($rows[$i]["end"]).'</b></br>'.$rows[$i]["event"].'<img src="img/x.png" onclick="delete_event(this,'.$year.','.$month.','.$day.',\''.$rows[$i]["event"].'\','.$rows[$i]["start"].','.$rows[$i]["end"].')" /></br>Notes: '.' '.$rows[$i]["notes"].'</td>');
                    if ($i+1>=$end)
                        break; /*we've reached the end of $rows*/
                    if ($rows[$i]["end"]>$last) /*we need to keep track of the latest time to compare with following events to see if they overlap*/
                        $last=$rows[$i]["end"];
                }
                /*note that if there is no overlap, then only one table cell gets printed*/
            }       
            echo("</tr></table>");/*end the row and start another one*/
            $i++;
        }
    ?>

<script>
/*ensures that cells for times that overlap end up the same size. exists in scripts.js*/
 $(document).ready(function(){
  resizecells();
  });
</script>

<script>
/*when x-image is clicked, this is called. Makes ajax call and on success removes the deleted cells and calls resize again*/
function delete_event(elem, year, month, day, event, start, end)
{    
    $.ajax(
    {
        url:'deleteevent.php',
        type:'POST',
        data:
        {
            year:year,
            month:month,
            day:day,
            event:event,
            start:start,
            end:end
        },
        success: function(){
            $(elem).parent().remove();
            resizecells();
        }
    })
 
};
</script>   

<script>
/*handles filters. this script is called whenever any checkbox is checked or unchecked*/
$(document).ready(function(){
    $(":checkbox").change(function(){
    var rows=<?=json_encode($rows)?>;
		/*first assume that all of the events are excluded, then start adding in*/
    $('.cell').hide();
		/*iterate through checkboxes to add in events*/
    $(":checkbox").each(function(){
        if ($(this).attr("checked"))
        {
            var num=$(this).attr('id'); /*the variable num holds the name of the filter, like 'filter1' or 'filter2', which also happens to be the name of the filter in the database*/
            var end=rows.length;
            for (var i=0; i<end; i++)
            {
                if (rows[i]!=null)
                    if (rows[i][num]==1)/*ie if $rows[$i]['filter1']==1 for all the filters*/
                    {
                        $('#'+i).show();
                    }
             }
         }
        });
        resizecells();
    });
});
</script>

<script>
$(document).ready(function(){
	/*when user presses right arrow to go to next day, this appends information to make a call to day using tomorrow's info*/
    $("#increment").submit(function(){
        var info=<?= incrementday($year, $month, $day, $dayofwk) ?>; /*incrementday is a helper function that increments the day according to calendar standards*/
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

<script>
/*likewise for decrement. this appends information when the user presses the left arrow. decrementday is a helper function that decrements the day from the current day according to calendar standards*/
$(document).ready(function(){
    $("#decrement").submit(function(){
        var info=<?= decrementday($year, $month, $day, $dayofwk) ?>;
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

<script>
/*this script hides and unhides the add event div/box as well as fades the background in and out. modeled after something I found online*/
$(document).ready(function() {
	$('a.addeventwindow').click(function() {
		
    //getting the variable's value from a link 
		var loginBox = $(this).attr('href');

		//fade in the popup box
		$(loginBox).fadeIn(300);
		
		//alignment
		var popMargTop = ($(loginBox).height() + 24) / 2; 
		var popMargLeft = ($(loginBox).width() + 24) / 2; 
		
		$(loginBox).css({ 
			'margin-top' : -popMargTop,
			'margin-left' : -popMargLeft
		});
		
		// add the mask to the background
		$('body').append('<div id="mask"></div>');
		$('#mask').fadeIn(300);
		
		return false;
	});
	
	// when clicking on the x-image or the mask layer the popup closes
	$('a.close, #mask').live('click', function() { 
	  $('#mask , .addeventpopup').fadeOut(300 , function() {
		$('#mask').remove();  
	}); 
	return false;
	});
});
</script>

<!--this script ensures that once the user checkes 'all day' on the add events form, he/she can't enter a start and end time-->
<script>
$(document).ready(function(){
    $("#alldayf").change(function(){
        if ($(this).attr('checked'))
        {            
            $('input.start').each(function(){
                $(this).attr('readonly', 'readonly'); /*makes start and end boxes gray and read only*/
                $(this).css('background', 'gray');
            })
            $('input.end').each(function(){
                $(this).attr('readonly', 'readonly');
                $(this).css('background', 'gray');
            })
        }
        else
        {
            /*checkbox must have been unchecked, so undo changes*/
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

<!--checks for valid user input in add event-->
<script>
$(document).ready(function(){
    $(".eventadd").submit(function(){
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
				/*additional information required by add event that we will take care of for the user. this includes the current day's information*/
        $('<input>').attr({
            type: 'hidden',
            id: 'year',
            name:'year',
            value: <?= $year ?>  
        }).appendTo('.eventadd');
        $('<input>').attr({
            type: 'hidden',
            id: 'month',
            name:'month',
            value: <?= $month ?>   
        }).appendTo('.eventadd');
        $('<input>').attr({
            type: 'hidden',
            id: 'day',
            name:'day',
            value: <?= $day ?>
        }).appendTo('.eventadd');
        $('<input>').attr({
            type: 'hidden',
            id: 'dayofwk',
            name:'dayofwk',
            value: <?= $dayofwk ?> 
        }).appendTo('.eventadd');
    });
});
</script>

<!--information required by day.php that we will append when the left arrow is pressed-->
<script>
$(document).ready(function(){
    $("#decrement").submit(function(){
        var info=<?= decrementday($year, $month, $day, $dayofwk) ?>;
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
   </div>
    
    

