<?php
   /*deletes event from month view*/

    // configuration
    require("../includes/config.php"); 
    
    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    { 
  
    query("DELETE FROM ".$_SESSION["tblname"]." WHERE yr=? AND mth=? AND date=? AND event=? AND start=? AND end=?", $_POST["year"], $_POST["month"], $_POST["day"], $_POST["event"], $_POST["start"],$_POST["end"]); 
    // now we need to reload month view
    $filters=query("SELECT * FROM users WHERE id = ?", $_SESSION["id"]);
    $monthevents=query("SELECT * FROM ". $_SESSION["tblname"]." WHERE yr = ? AND mth = ? ORDER BY date ASC", $_POST["year"], $_POST["month"]);    
    
    // render month view
    render("month_display.php", ["title"=>"Month View:".$_POST["month"], "year"=>$_POST["year"], "month"=>$_POST["month"], "day"=>$_POST["day"], "dayofwk"=>$_POST["dayofwk"], "filters"=>$filters, "rows"=>$monthevents]);
}
?>
