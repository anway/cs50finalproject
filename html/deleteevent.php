<?php
    /*deletes event from day view*/
    // configuration
    require("../includes/config.php"); 
    query("DELETE FROM ".$_SESSION["tblname"]." WHERE yr=? AND mth=? AND date=? AND event=? AND start=? AND end=?", $_POST["year"], $_POST["month"], $_POST["day"], $_POST["event"], $_POST["start"],$_POST["end"]); 
    
?>    
    
