<?php

     /*handles add event call from week view popup*/

    // configuration
    require("../includes/config.php"); 
    
    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        /*we need to determine what filters apply to the event we're adding and then add them. we will do this by concatenating a string that we will then put into our query*/
   
    $filters=query("SELECT * FROM users WHERE id = ?", $_SESSION["id"]); 
    $numfilters=count($filters[0])-2;
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
  
    /*get all the info we need to reload week view*/
    query("INSERT INTO ".$_SESSION["tblname"]." VALUES (?, ?, ?, ?, ?, ?, ?, 0, ?,".$filterstring.")", $_POST["event"], $_POST["year"], $_POST["month"], $_POST["day"], $start, $end, $allday, $_POST['notes']);
    
    switch($_POST['dayofwk'])
    {
        case 1:
        {
            $mon=array("year"=>$_POST['year'], "month"=>$_POST['month'], "day"=>$_POST['day'], "dayofwk"=>$_POST['dayofwk']);
            $tue=incrementday2($year, $month, $day, $dayofwk);
            $wed=incrementday2($tue['year'], $tue['month'], $tue['day'], $tue['dayofwk']);
            $thu=incrementday2($wed['year'], $wed['month'], $wed['day'], $wed['dayofwk']);
            $fri=incrementday2($thu['year'], $thu['month'], $thu['day'], $thu['dayofwk']);
            $sat=incrementday2($fri['year'], $fri['month'], $fri['day'], $fri['dayofwk']);
            $sun=incrementday2($sat['year'], $sat['month'], $sat['day'], $sat['dayofwk']);
            break;
        }
        case 2:
        {
            
            $tue=array("year"=>$_POST['year'], "month"=>$_POSt['month'], "day"=>$_POST['day'], "dayofwk"=>$_POST['dayofwk']);
            $mon=decrementday2($tue['year'], $tue['month'], $tue['day'], $tue['dayofwk']);
            $wed=incrementday2($tue['year'], $tue['month'], $tue['day'], $tue['dayofwk']);
            $thu=incrementday2($wed['year'], $wed['month'], $wed['day'], $wed['dayofwk']);
            $fri=incrementday2($thu['year'], $thu['month'], $thu['day'], $thu['dayofwk']);
            $sat=incrementday2($fri['year'], $fri['month'], $fri['day'], $fri['dayofwk']);
            $sun=incrementday2($sat['year'], $sat['month'], $sat['day'], $sat['dayofwk']);
            break;
        }
        case 3:
        {
            $wed=array("year"=>$_POST['year'], "month"=>$_POST['month'], "day"=>$_POST['day'], "dayofwk"=>$_POST['dayofwk']);
            $tue=decrementday2($wed['year'], $wed['month'], $wed['day'], $wed['dayofwk']);
            $mon=decrementday2($tue['year'], $tue['month'], $tue['day'], $tue['dayofwk']);
            $thu=incrementday2($wed['year'], $wed['month'], $wed['day'], $wed['dayofwk']);
            $fri=incrementday2($thu['year'], $thu['month'], $thu['day'], $thu['dayofwk']);
            $sat=incrementday2($fri['year'], $fri['month'], $fri['day'], $fri['dayofwk']);
            $sun=incrementday2($sat['year'], $sat['month'], $sat['day'], $sat['dayofwk']);
            break;
        }
        case 4:
        {
            $thu=array("year"=>$_POST['year'], "month"=>$_POST['month'], "day"=>$_POST['day'], "dayofwk"=>$_POST['dayofwk']);
            $wed=decrementday2($thu['year'], $thu['month'], $thu['day'], $thu['dayofwk']);
            $tue=decrementday2($wed['year'], $wed['month'], $wed['day'], $wed['dayofwk']);
            $mon=decrementday2($tue['year'], $tue['month'], $tue['day'], $tue['dayofwk']);
            
            $fri=incrementday2($thu['year'], $thu['month'], $thu['day'], $thu['dayofwk']);
            $sat=incrementday2($fri['year'], $fri['month'], $fri['day'], $fri['dayofwk']);
            $sun=incrementday2($sat['year'], $sat['month'], $sat['day'], $sat['dayofwk']); 
            break;   
        }
        case 5:
        {
            $fri=array("year"=>$_POST['year'], "month"=>$_POST['month'], "day"=>$_POST['day'], "dayofwk"=>$_POST['dayofwk']);
            $thu=decrementday2($fri['year'], $fri['month'], $fri['day'], $fri['dayofwk']);
            $wed=decrementday2($thu['year'], $thu['month'], $thu['day'], $thu['dayofwk']);
            $tue=decrementday2($wed['year'], $wed['month'], $wed['day'], $wed['dayofwk']);
            $mon=decrementday2($tue['year'], $tue['month'], $tue['day'], $tue['dayofwk']);
            $sat=incrementday2($fri['year'], $fri['month'], $fri['day'], $fri['dayofwk']);
            $sun=incrementday2($sat['year'], $sat['month'], $sat['day'], $sat['dayofwk']); 
            break;
        }
        case 6:
        {
            $sat=array("year"=>$_POST['year'], "month"=>$_POST['month'], "day"=>$_POST['day'], "dayofwk"=>$_POST['dayofwk']);
           $fri=decrementday2($sat['year'], $sat['month'], $sat['day'], $sat['dayofwk']);
            $thu=decrementday2($fri['year'], $fri['month'], $fri['day'], $fri['dayofwk']);
            $wed=decrementday2($thu['year'], $thu['month'], $thu['day'], $thu['dayofwk']);
            $tue=decrementday2($wed['year'], $wed['month'], $wed['day'], $wed['dayofwk']);
            $mon=decrementday2($tue['year'], $tue['month'], $tue['day'], $tue['dayofwk']);
        
            $sun=incrementday2($sat['year'], $sat['month'], $sat['day'], $sat['dayofwk']);  
            break;
        }
        case 7:
        {
            $sun=array("year"=>$_POST['year'], "month"=>$_POST['month'], "day"=>$_POST['day'], "dayofwk"=>$_POST['dayofwk']);
            $sat=decrementday2($sun['year'], $sun['month'], $sun['day'], $sun['dayofwk']);
           $fri=decrementday2($sat['year'], $sat['month'], $sat['day'], $sat['dayofwk']);
            $thu=decrementday2($fri['year'], $fri['month'], $fri['day'], $fri['dayofwk']);
            $wed=decrementday2($thu['year'], $thu['month'], $thu['day'], $thu['dayofwk']);
            $tue=decrementday2($wed['year'], $wed['month'], $wed['day'], $wed['dayofwk']);
            $mon=decrementday2($tue['year'], $tue['month'], $tue['day'], $tue['dayofwk']);
            break;
        }
    } 
   
    $filters=query("SELECT * FROM users WHERE id = ?", $_SESSION["id"]);
    $monrows=query("SELECT * FROM ". $_SESSION["tblname"]." WHERE yr = ? AND mth = ? AND date = ? ORDER BY start ASC", $mon["year"], $mon["month"], $mon["day"]);
    $tuerows=query("SELECT * FROM ". $_SESSION["tblname"]." WHERE yr = ? AND mth = ? AND date = ? ORDER BY start ASC", $tue["year"], $tue["month"], $tue["day"]);
    $wedrows=query("SELECT * FROM ". $_SESSION["tblname"]." WHERE yr = ? AND mth = ? AND date = ? ORDER BY start ASC", $wed["year"], $wed["month"], $wed["day"]);
    $thurows=query("SELECT * FROM ". $_SESSION["tblname"]." WHERE yr = ? AND mth = ? AND date = ? ORDER BY start ASC", $thu["year"], $thu["month"], $thu["day"]);
    $frirows=query("SELECT * FROM ". $_SESSION["tblname"]." WHERE yr = ? AND mth = ? AND date = ? ORDER BY start ASC", $fri["year"], $fri["month"], $fri["day"]);
    $satrows=query("SELECT * FROM ". $_SESSION["tblname"]." WHERE yr = ? AND mth = ? AND date = ? ORDER BY start ASC", $sat["year"], $sat["month"], $sat["day"]);
    $sunrows=query("SELECT * FROM ". $_SESSION["tblname"]." WHERE yr = ? AND mth = ? AND date = ? ORDER BY start ASC", $sun["year"], $sun["month"], $sun["day"]);
    // render week view
    render("week_display.php", ["title"=>"Week View: ".$mon["month"]."/".$mon["day"]."-".$sun["month"]."/".$sun["day"], "filters"=>$filters, "mon"=>$mon, "monrows"=>$monrows, "tue"=>$tue, "tuerows"=>$tuerows, "wed"=>$wed, "wedrows"=>$wedrows, "thu"=>$thu, "thurows"=>$thurows, "fri"=>$fri, "frirows"=>$frirows, "sat"=>$sat, "satrows"=>$satrows, "sun"=>$sun, "sunrows"=>$sunrows]);
    }
?>
