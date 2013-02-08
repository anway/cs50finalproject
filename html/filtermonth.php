<?php
   // filter events from month view

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
    /*query for all events in the month*/
    $monthrows=query("SELECT * FROM ". $_SESSION["tblname"]." WHERE yr = ? AND mth = ? ORDER BY date ASC", $_POST["yr"], $_POST["month"]);
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
                $rows[$i]=NULL; /*if we didn't break then it must not have any*/   
        }
        return $rows;
    }
     $monthrows=checkforfilters($monthrows, $existfilters);
     // render month view
     $filters=query("SELECT * FROM users WHERE id = ?", $_SESSION["id"]); 
    render("month_display.php", ["title"=>"Month View:".$_POST["month"], "year"=>$_POST["yr"], "month"=>$_POST["month"], "day"=>$_POST["day"], "dayofwk"=>$_POST["dayofwk"], "filters"=>$filters, "rows"=>$monthrows]);

?>
