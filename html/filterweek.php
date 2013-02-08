<?php
    
    // filter events from week view

    // configuration
    require("../includes/config.php");
    /*build up an array of filters that have been checked by the user in the form*/
    $existfilters=array();
    $j=0;
    if (!empty($_POST['allday']))
    {
            $existfilters[$j]='allday';
            $j++;
    } 
    if (!empty($_POST['notonetime']))
    {
            $existfilters[$j]='notonetime';
            $j++;
    }   
    for ($i=1;$i<=$_SESSION["numfilters"];$i++)
    {
        if (!empty($_POST['filter'.$i]))
        {
            $existfilters[$j]='filter'.$i;
            $j++;
        }    
    }

    /*query for all events in the week*/
    $mon=array("year"=>$_POST['monyr'], "month"=>$_POST['monmon'], "day"=>$_POST['monday'], "dayofwk"=>1);
    $tue=array("year"=>$_POST['tueyr'], "month"=>$_POST['tuemon'], "day"=>$_POST['tueday'], "dayofwk"=>2);
    $wed=array("year"=>$_POST['wedyr'], "month"=>$_POST['wedmon'], "day"=>$_POST['wedday'], "dayofwk"=>3);
    $thu=array("year"=>$_POST['thuyr'], "month"=>$_POST['thumon'], "day"=>$_POST['thuday'], "dayofwk"=>4);
    $fri=array("year"=>$_POST['friyr'], "month"=>$_POST['frimon'], "day"=>$_POST['friday'], "dayofwk"=>5);
    $sat=array("year"=>$_POST['satyr'], "month"=>$_POST['satmon'], "day"=>$_POST['satday'], "dayofwk"=>6);
    $sun=array("year"=>$_POST['sunyr'], "month"=>$_POST['sunmon'], "day"=>$_POST['sunday'], "dayofwk"=>7);
    $filters=query("SELECT * FROM users WHERE id = ?", $_SESSION["id"]);
    $monrows=query("SELECT * FROM ". $_SESSION["tblname"]." WHERE yr = ? AND mth = ? AND date = ? ORDER BY start ASC", $mon["year"], $mon["month"], $mon["day"]);
    $tuerows=query("SELECT * FROM ". $_SESSION["tblname"]." WHERE yr = ? AND mth = ? AND date = ? ORDER BY start ASC", $tue["year"], $tue["month"], $tue["day"]);
    $wedrows=query("SELECT * FROM ". $_SESSION["tblname"]." WHERE yr = ? AND mth = ? AND date = ? ORDER BY start ASC", $wed["year"], $wed["month"], $wed["day"]);
    $thurows=query("SELECT * FROM ". $_SESSION["tblname"]." WHERE yr = ? AND mth = ? AND date = ? ORDER BY start ASC", $thu["year"], $thu["month"], $thu["day"]);
    $frirows=query("SELECT * FROM ". $_SESSION["tblname"]." WHERE yr = ? AND mth = ? AND date = ? ORDER BY start ASC", $fri["year"], $fri["month"], $fri["day"]);
    $satrows=query("SELECT * FROM ". $_SESSION["tblname"]." WHERE yr = ? AND mth = ? AND date = ? ORDER BY start ASC", $sat["year"], $sat["month"], $sat["day"]);
    $sunrows=query("SELECT * FROM ". $_SESSION["tblname"]." WHERE yr = ? AND mth = ? AND date = ? ORDER BY start ASC", $sun["year"], $sun["month"], $sun["day"]);
    /*now go through the list and set everything that does not have one of the filters to NULL*/
    function checkforfilters($rows, $existfilters)
    {
        $end=count($rows);
        $numfilters=count($existfilters);
        for ($i=0; $i<$end; $i++)
        {
            for ($j=0; $j<$numfilters;$j++)
            {
                if ($rows[$i][$existfilters[$j]]==1)
                {                   
                    break; /*break out of loop as soon as it has one of the filters*/
                }
            }
            if ($j>=$numfilters)
                $rows[$i]=NULL;  /*if we didn't break then it must not have any*/     
        }
        return $rows;
    }
    

    $monrows=checkforfilters($monrows, $existfilters); 
    $tuerows=checkforfilters($tuerows, $existfilters);
    $wedrows=checkforfilters($wedrows, $existfilters);
    $thurows=checkforfilters($thurows, $existfilters);
    $frirows=checkforfilters($frirows, $existfilters);
    $satrows=checkforfilters($satrows, $existfilters);
    $sunrows=checkforfilters($sunrows, $existfilters);

    // render week view
    render("week_display.php", ["title"=>"Week View: ".$mon["month"]."/".$mon["day"]."-".$sun["month"]."/".$sun["day"], "filters"=>$filters, "mon"=>$mon, "monrows"=>$monrows, "tue"=>$tue, "tuerows"=>$tuerows, "wed"=>$wed, "wedrows"=>$wedrows, "thu"=>$thu, "thurows"=>$thurows, "fri"=>$fri, "frirows"=>$frirows, "sat"=>$sat, "satrows"=>$satrows, "sun"=>$sun, "sunrows"=>$sunrows]);
?>
