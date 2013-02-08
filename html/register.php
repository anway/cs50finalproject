<?php

    // configuration
    require("../includes/config.php");

    //query 	
    
    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"]=="POST")
    {
        
        // query database for user and check for return false
        if (query("INSERT INTO users (username, hash) VALUES(?, ?)", $_POST["username"], crypt($_POST["password"]))===false)
        {
            echo('<script>alert("Registration unsuccessful. Perhaps this username already exists.");</script>');
            // else render form
            render("register_form.php", ["title"=>"Register"]);
        }
        else
        // registration successful
        {
            // remember that user's now logged in by storing user's ID in session
            $rows=query("SELECT LAST_INSERT_ID() AS id");
            $_SESSION["id"]=$rows[0]["id"];

            // create new events table for new user
            /*
            $db_handle=mysql_connect(SERVER, USERNAME, PASSWORD);
            $db_found=mysql_select_db(DATABASE, $db_handle);
            if ($db_found)
            {
                $SQL="CREATE TABLE".'tbl'.$_SESSION["id"]."(event VARCHAR(40) NOT NULL, notes varchar(256), yr INT NOT NULL, mth INT NOT NULL, date INT NOT NULL, start DECIMAL(5,3) DEFAULT '0.000' NOT NULL, end DECIMAL (5,3) DEFAULT '0.000' NOT NULL, allday INT NOT NULL DEFAULT 0, notonetime INT NOT NULL DEFAULT 0, filter1 INT NOT NULL DEFAULT 0, filter2 INT NOT NULL DEFAULT 0, filter3 INT NOT NULL DEFAULT 0, filter4 INT NOT NULL DEFAULT 0, filter5 INT NOT NULL DEFAULT 0, filter6 INT NOT NULL DEFAULT 0, filter7 INT NOT NULL DEFAULT 0, filter8 INT NOT NULL DEFAULT 0, filter9 INT NOT NULL DEFAULT 0, filter10 INT NOT NULL DEFAULT 0, PRIMARY KEY (event, yr, mth, date, start, end, allday))";
                mysql_query($SQL);
                mysql_close($db_handle);
            }
            else
            {
                print("Database not found");
                mysql_close($db_handle);
            }
            */
            query("CREATE TABLE ".'tbl'.$_SESSION["id"]." (event VARCHAR(40) NOT NULL, yr INT NOT NULL, mth INT NOT NULL, date INT NOT NULL, start DECIMAL(5,3) DEFAULT '0.000' NOT NULL, end DECIMAL (5,3) DEFAULT '0.000' NOT NULL, allday INT NOT NULL DEFAULT 0, notonetime INT NOT NULL DEFAULT 0, notes varchar(256), filter1 INT NOT NULL DEFAULT 0, filter2 INT NOT NULL DEFAULT 0, filter3 INT NOT NULL DEFAULT 0, filter4 INT NOT NULL DEFAULT 0, filter5 INT NOT NULL DEFAULT 0, filter6 INT NOT NULL DEFAULT 0, filter7 INT NOT NULL DEFAULT 0, filter8 INT NOT NULL DEFAULT 0, filter9 INT NOT NULL DEFAULT 0, filter10 INT NOT NULL DEFAULT 0, PRIMARY KEY (event, yr, mth, date, start, end, allday))");
            
            
            
            
            //".'tbl'.$_SESSION["id"]."
            
            // redirect to index
            redirect("/");
        }
    }
    else
    {
        // else render form
        render("register_form.php", ["title"=>"Register"]);
    }

?>
