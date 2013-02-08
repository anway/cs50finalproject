<?php

    /*handles add event call from day view popup*/

    // configuration
    require("../includes/config.php"); 
    
    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        
      
    /*we need to determine what filters apply to the event we're adding and then add them. we will do this by concatenating a string that we will then put into our query*/
    $filters=query("SELECT * FROM users WHERE id = ?", $_SESSION["id"]); 
    $numfilters=count($filters[0])-2; //because the "filters" actually contains a whole row of the table, so we need the offset
    $filterstring="";
    for ($i=1; $i<$numfilters; $i++)
    {
        
      
        if (!empty($_POST['filter'.$i]))
        {
            
            $filterstring=$filterstring.'1';/*this box was checked--value will be one*/
            
        }
        else
        {
            $filterstring=$filterstring.'0';/*not checked--value will be zero*/
            
        }
        if ($i<$numfilters-1)
        {
            $filterstring=$filterstring.', ';/*add any necessary commas in between*/
            
        }
        
    }
    if (!empty($_POST['allday']))
    {
        $start=0;
        $end=0;
        $allday=1; /*all day event*/
    }
    else
    {
	/*convert times to a form we can store in our database ie 0.000 to 24.000 where decimals are the minutes (.00 to .60)*/
        $start=$_POST['starthour']+$_POST['startmin']/100.0;
        if (($_POST['startampm']=='pm')&&($_POST['starthour']<12))
        {
            $start=$start+12;
        }
        $end=$_POST['endhour']+$_POST['endmin']/100.0;
        if (($_POST['endampm']=='pm')&&($_POST['endhour']<12))
        {
            $end=$end+12;
        }
        if(($_POST['startampm']=='am')&&($_POST['starthour']==12))
        {
            $start=0;
        }
        $allday=0;
    }
  
    query("INSERT INTO ".$_SESSION["tblname"]." VALUES (?, ?, ?, ?, ?, ?, ?, 0, ?,".$filterstring.")", $_POST["event"], $_POST["year"], $_POST["month"], $_POST["day"], $start, $end, $allday, $_POST["notes"]);
    /*we're going to reload day view from here*/
    $dayevents=query("SELECT * FROM ". $_SESSION["tblname"]." WHERE yr = ? AND mth = ? AND date = ? ORDER BY start ASC", $_POST["year"], $_POST["month"], $_POST["day"]); 
     // render day view
    render("day_display.php", ["title"=>"Day View:".$_POST["month"]."-".$_POST["day"]."-".$_POST["year"], "rows"=>$dayevents, "filters"=>$filters, "year"=>$_POST["year"], "month"=>$_POST["month"], "day"=>$_POST["day"], "dayofwk"=>$_POST["dayofwk"]]);
    }
?> 
