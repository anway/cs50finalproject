<?php

    // configuration
    require("../includes/config.php"); 
    
    // extract month's events
    $monthevents=query("SELECT * FROM ". $_SESSION["tblname"]." WHERE yr = ? AND mth = ? ORDER BY date ASC", $_GET["year"], $_GET["month"]);
    
    $filters=query("SELECT * FROM users WHERE id = ?", $_SESSION["id"]); 
    
    
    // render month view
    render("month_display.php", ["title"=>"Month View:".$_GET["month"], "year"=>$_GET["year"], "month"=>$_GET["month"], "day"=>$_GET["day"], "dayofwk"=>$_GET["dayofwk"], "filters"=>$filters, "rows"=>$monthevents]);
?>
