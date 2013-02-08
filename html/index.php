<?php

    // configuration
    require("../includes/config.php"); 
    
    // also store/refresh today's date in session for use in calculations if necessary
    $_SESSION["year"]=date("Y");
    $_SESSION["month"]=date("n"); 
    $_SESSION["dayofwk"]=date("N");
    $_SESSION["day"]=date("j");
    $_SESSION["isleap"]=date("L");
    $_SESSION["numfilters"]=10;

    
    // extract today's events (default)
    $_SESSION["tblname"]="tbl".$_SESSION["id"];
    $today=query("SELECT * FROM ". $_SESSION["tblname"]." WHERE yr = ? AND mth = ? AND date = ? ORDER BY start ASC", $_SESSION["year"], $_SESSION["month"], $_SESSION["day"]);
    $filters=query("SELECT * FROM users WHERE id = ?", $_SESSION["id"]); 

    // render day view with today's events
    render("day_display.php", ["title"=>"Day View: Today", "rows"=>$today, "filters"=>$filters, "year"=>$_SESSION["year"], "month"=>$_SESSION["month"], "day"=>$_SESSION["day"], "dayofwk"=>$_SESSION["dayofwk"]]);
?>
