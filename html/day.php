<?php

    // configuration
    require("../includes/config.php"); 
    
    // extract day's events plus the filters
    $dayevents=query("SELECT * FROM ". $_SESSION["tblname"]." WHERE yr = ? AND mth = ? AND date = ? ORDER BY start ASC", $_GET["year"], $_GET["month"], $_GET["day"]);
    $filters=query("SELECT * FROM users WHERE id = ?", $_SESSION["id"]); 

    // render day view
    render("day_display.php", ["title"=>"Day View:".$_GET["month"]."-".$_GET["day"]."-".$_GET["year"], "rows"=>$dayevents, "filters"=>$filters, "year"=>$_GET["year"], "month"=>$_GET["month"], "day"=>$_GET["day"], "dayofwk"=>$_GET["dayofwk"]]);
?>
