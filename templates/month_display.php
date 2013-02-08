<style>
.month /*table that holds the days of the month*/
{
    height:380px;
    width:930px;
    border:1px solid black;
    margin:0 0 0 0;
    padding:0 0 0 0;
    overflow:auto;
     height:380px;
    width:930px;
}
.month td /*fix the size of the day cells!*/
{
    border:1px solid black;
    border-collapse:collapse;
    margin:0 0 0 0;
    padding:0 0 0 0;
    min-width:120px;
    max-width:120px;
    min-height:100px;
    max-height:100px;
    overflow:hidden;
}
.cellcontent div{/*handle overflow*/
    overflow:hidden;
    min-height:100px;
    max-height:100px;
    min-width:98px;
    max-width:98px;
}
.cellcontent td{
    border:none;
    min-height:100px;
    max-height:100px;
    min-width:98px;
    max-width:98px;
    overflow:hidden;
}
.cellcontent:hover div{
    overflow-y:auto;
}
.innertable3{/*each day cell has an inner table inside it. One cell of the table contains the "number" of the day and the on-hover add event button, the other cell contains the events on that day*/
    border:none;
    min-width:120px;
    max-width:120px;
    min-height:100px;
    max-height:100px;
    overflow:hidden;

}
.innertable3 tr, .month tr{

    height:90px;
    overflow:hidden;
}
.innertable3 .daynumber{
    min-width:22px;
    max-width:22px;
    min-height:100px;
    max-height:100px;
    border:none;
    overflow:hidden;
    font-size:18px;
}
.innertable3 .cellcontent{
    border:none;

}    

#container3
{
    height:380px;
    width:930px;
    overflow:hidden;
    margin-top:5px;
}
#container3:hover
{   
    overflow-y:auto;
}
/*hovering stuff from here on for + images to add event and x's to delete events. Also hovering for overflow scroll bars*/
.daynumber img
{
    width:10px;
    height:auto;
    visibility:hidden;
}
.daynumber:hover img
{
    visibility:visible;
}

.cellcontent td form
{
    display:inline;
    visibility:hidden; 
}
.imagebutton2
{
    width:10px;
    height:auto;
    display:inline;
    visibility:hidden;
}
.cellcontent td:hover form, .cellcontent:hover .imagebutton2
{
    visibility:visible;
}/*each day number is also a link to day.php day view for that day*/
td a
{
    font-family: Copperplate / Copperplate Gothic Light, sans-serif;
    font-size:17px;
    color:#000000;
    text-decoration:none;
}
a
{
    text-decoration:none;
}
a img
{
    width:20px;
    height:auto;
    visibility:hidden;
}
a:hover img
{
    visibility:visible;
}
</style>
</head>

<body>
<!--call function to find the day of week of the first day of the month as well as what the last day of the month is-->
    <?php
        $dayofwkfirst=findfirstday($month, $day, $dayofwk);
        $last=findlastday($year, $month);
    ?>
<!--topnav-->
 <div id="topnav">
    <ul>
        <li><a href="account.php"><em>ACCOUNT</em></a></li> 
        <!--<li><a href="year.php">YEAR</a></li>-->
        <li><em>MONTH</em></li>
        <li>WEEK</li>
        <li>DAY</li>
        <li><a href="logout.php"><em>LOGOUT</a></em></li>
     </ul>    
 </div>

 <hr id="sep" />

<!--leftnav-->
    <div id="leftnav">
        <ul>
            <li>Add Event</li>
        </ul>
    </div>
<!--right nav with filters. Again the filters are like week_display rather than day_display in that there is a submit button for a form rather than dynamically filtering because overlapping events share the same table cell in this case, so we can't just hide them like that-->        
<div id="rightnav">
    <ul>
        <li><em>Filters</em></li>
       
        <form id="filter" method="post" action="filtermonth.php">
        <table>
            <tr><td><input type="checkbox" name="filter" id="allday" value="allday" checked /></td><td><label for="allday">All Day</label></td></tr></br>
            <tr><td><input type="checkbox" name="filter" id="notonetime" value="notonetime" checked /></td><td><label for="notonetime">Regularly Ocurring</label></td></tr></br>
            <?php 
                for($i=1, $end=count($filters[0])-2; $i<$end; $i++)
                {
                    if ($filters[0]["filter".$i]!=NULL)        
                    echo('<tr><td><input type="checkbox" name="filter" id="filter'.$i.'" value="filter'.$i.'" checked /></td><td><label for="filter'.$i.'">'.$filters[0]["filter".$i].'</label></td></tr>');
        
                }
            ?>
        </table>
        <input type="submit" value="Go" />
        <input type="button" onClick="location.href='month.php?year=<?=$year?>&month=<?=$month?>&day=1&dayofwk=<?=$dayofwkfirst?>'" value="Reset" />
        </form>     
        </ul>          
</div>

<div id="content">
<!--the title is the month and year-->
<div class="toptitle">
<!--we want the last day of the month before and the first day of the month following when the user presses the left and right arrows to advance or go back in month view-->
<?php
	$monthbefore=decrementday2($year, $month, 1, $dayofwkfirst);
	$monthafter=incrementday2($year, $month, $last, ($last%7+$dayofwkfirst-1)%7);
?>
<!--again, arrows that appear on hover and that can be clicked-->
<a href="month.php?year=<?=$monthbefore['year']?>&month=<?=$monthbefore['month']?>&day=1&dayofwk=<?=$monthbefore['dayofwk']?>">
    <img src="img/leftarrow.png" />
</a>
    <?php echo(numtomonth($month).' '.$year)?>
<a href="month.php?year=<?=$monthafter['year']?>&month=<?=$monthafter['month']?>&day=<?=$last?>&dayofwk=<?=$monthafter['dayofwk']?>">
    <img src="img/rightarrow.png" />
</a>

</div>

<!--again, the popup div for adding events. same as in day_display and week_display-->
<div id="addeventbox3" class="addeventpopup">
    <a href="#" class="close"><img src="img/x.png" id="x"/></a>
        <form method="post" class="eventadd" action="addeventmonth.php">
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
    
<div id="container3">
<!--table for the month-->
<table class='month'>
<?php
/*we need information like the number of days, number of rows we will need, and to keep track of what day it is to embed that information in each table cell so that we can access it again when we need to add/delete an event. Also like in week_display, we're printing the table first and then adding content with jquery*/
    $numdays=$last;
    $numrows=ceil(($numdays+$dayofwkfirst-1)/7);
    $daycount=1;
    for($row=1;$row<=$numrows, $daycount<=$numdays;$row++)
    {
        $col=1;
        echo('<tr>');
        if ($row==1)
        {
     	   /*in the first row, we need to consider the offset before we reach day #1*/
            while ($col<$dayofwkfirst)
            {
               echo('<td></td>');
               $col++;
             }
            /*now that we've gotten there, finish printing the rest of the first row*/
            while ($col<=7)
            {
		/*We embed information on what day it is as well as what day of the week. Also, when we print each number for what day it is, we also print the image for adding an event. Also, note that each number is a link to the corresponding day in day view*/
                echo('<td class="'.$col.'" id="'.$daycount.'"><table class="innertable3"><tr><td class="daynumber"><a href="day.php?year='.$year.'&month='.$month.'&day='.$daycount.'&dayofwk='.$col.'">'.$daycount.'</a></br><a id="'.$daycount.'" href="#addeventbox3" class="addeventwindow"><img src="img/plus2.png" id="plus2" /></a></td><td class="cellcontent"><div></div></td></tr></table></td>');
                $col++;
                $daycount++;
            }
           
         }
         else
            {
                while (($col<=7)&&($daycount<=$numdays))
                {
                    echo('<td class="'.$col.'" id="'.$daycount.'"><table class="innertable3"><tr><td class="daynumber"><a href="day.php?year='.$year.'&month='.$month.'&day='.$daycount.'&dayofwk='.$col.'">'.$daycount.'</a></br><a id="'.$daycount.'" href="#addeventbox3" class="addeventwindow"><img src="img/plus2.png" id="plus2" /></a></td><td class="cellcontent"><div></div></td></tr></table></td>');
                    $col++;
                    $daycount++;
                }
                while($col<=7)/*now we've passed the total number of days in the month, so just eat up the space remaining in the row*/
                {
                    echo('<td></td>');
                    $col++;
                  }
               
            }
         echo('</tr>');
         
    }
?>
</table>

<!--now to add in the events. We will find the day cell that has the date for the event and then append the event as well as the button for deleting it. This is much simpler than week_view; we don't need to explicitly check for overlap but rather just keep appending-->
<?php
    echo('<script>');
    foreach($rows as $event)
    {
	if ($event===NULL)
	{
	}
	else
        	echo("
        		$('#".$event['date']."').find('.cellcontent>div').append('<form class=\'rm2\' method=\'post\' action=\'deleteeventmonth.php\'><input type=\'image\' src=\'img/x3.png\' class=\'imagebutton2\' /></form><span>".$event['event']."</span></br>')
        		$('#".$event['date']."').find('.cellcontent>div').attr('id',".$event['start'].");
        		$('#".$event['date']."').find('.cellcontent>div').attr('class',".$event['end'].");           
        	");
    }
    echo('</script>');
?>
</div>
<!--script for appending information to addevent popup similar to day_view and week_view-->
<script>
$(document).ready(function() {
	$('a.addeventwindow').click(function() {
	    var id=$(this).attr('id');
	    var col=$(this).parent().parent().parent().parent().parent().attr('class');
	    //var col=$('td #'+id).attr('class');
	    var form=$('.eventadd');
	    $('<input>').attr({
            type: 'hidden',
            id: 'year',
            name:'year',
            value: <?=$year?>  
        }).appendTo(form);
        $('<input>').attr({
            type: 'hidden',
            id: 'month',
            name:'month',
            value: <?=$month?>   
        }).appendTo(form);
        $('<input>').attr({
            type: 'hidden',
            id: 'day',
            name:'day',
            value: id
        }).appendTo(form);
        $('<input>').attr({
            type: 'hidden',
            id: 'dayofwk',
            name:'dayofwk',
            value: col
        }).appendTo(form);
	            
		
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
<!--again, ensures that in the add event box, allday doesn't conflict with start->end-->
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
<!--again, checks for submission format in add event popup-->
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
<!--as in week_view, cleans up the mess left by hidden inputs that we append when the form is brought up but which would remain after the x-button is pressed if we didn't clean it up-->
<script>
$(document).ready(function(){
    $('#x').click(function(){
        $('input:hidden').each(function(){
            $(this).remove();
        })
    })
})
</script>
<!--to remove an event. Gets necessary information like start and end times from the td id's and classes's storing them.-->
<script>
$(document).ready(function(){
    $('.rm2').submit(function(){
        var eventname=$(this).next().text();
        var dayofweek=$(this).parent().parent().parent().parent().parent().parent().attr('class');
        var date=$(this).parent().parent().parent().parent().parent().parent().attr('id');
        var start=$(this).parent().attr('id');
        var end=$(this).parent().attr('class');
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
        $('<input>').attr({
            type:'hidden',
            id:'dayofwk',
            name:'dayofwk',
            value: dayofweek
        }).appendTo(form);
        
        $('<input>').attr({
            type:'hidden',
            id:'year',
            name:'year',
            value:<?=$year?>
         }).appendTo(form);
         $('<input>').attr({
            type:'hidden',
            id:'month',
            name:'month',
            value:<?=$month?>
         }).appendTo(form);
         $('<input>').attr({
            type:'hidden',
            id:'day',
            name:'day',
            value:date
          }).appendTo(form);
    })
})
</script>
<!--appends additional necessary information for filters-->
<script>
$(document).ready(function(){
    $("#filter").submit(function(){
        
        $('<input>').attr({
            type: 'hidden',
            id: 'yr',
            name:'yr',
            value: <?=$year?>   
        }).appendTo('#filter');
        $('<input>').attr({
            type: 'hidden',
            id: 'month',
            name:'month',
            value: <?=$month?>   
        }).appendTo('#filter');
        $('<input>').attr({
            type: 'hidden',
            id: 'day',
            name:'day',
            value: 1   
        }).appendTo('#filter');
        $('<input>').attr({
            type: 'hidden',
            id: 'dayofwk',
            name:'dayofwk',
            value: <?=$dayofwkfirst?>   
        }).appendTo('#filter');
        
    });
});
</script>
