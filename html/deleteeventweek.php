<?php
   //delete event from week view

    // configuration
    require("../includes/config.php"); 
    
    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {

    query("DELETE FROM ".$_SESSION["tblname"]." WHERE yr=? AND mth=? AND date=? AND event=? AND start=? AND end=?", $_POST["year"], $_POST["month"], $_POST["day"], $_POST["event"], $_POST["start"],$_POST["end"]); 
    
    // now we need to reload week view
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
