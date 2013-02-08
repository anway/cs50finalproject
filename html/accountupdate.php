<?php

    // configuration
    require("../includes/config.php"); 

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // update the filters
	query("UPDATE users SET filter1=?, filter2=?, filter3=?, filter4=?, filter5=?, filter6=?, filter7=?, filter8=?, filter9=?, filter10=? WHERE id=?", $_POST['filter1'], $_POST['filter2'], $_POST['filter3'], $_POST['filter4'], $_POST['filter5'], $_POST['filter6'], $_POST['filter7'], $_POST['filter8'], $_POST['filter9'], $_POST['filter10'], $_SESSION['id']);
        
	// redirect to index
            redirect("/");
    }
