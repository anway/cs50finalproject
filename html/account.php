<?php

    // configuration
    require("../includes/config.php"); 
    // account settings involves adjusting filters
    $filters=query("SELECT * FROM users WHERE id = ?", $_SESSION["id"]);
    // we will also need the username
    $username=$filters[0]['username'];

     render("account_display.php", ["title" => "Account", "filters"=>$filters, "username"=>$username]);
?>
