<?php

    /***********************************************************************
     * functions.php
     *
     * Computer Science 50
     * Problem Set 7
     *
     * Helper functions.
     **********************************************************************/

    require_once("constants.php");





    /**
     * Logs out current user, if any.  Based on Example #1 at
     * http://us.php.net/manual/en/function.session-destroy.php.
     */
    function logout()
    {
        // unset any session variables
        $_SESSION = array();

        // expire cookie
        if (!empty($_COOKIE[session_name()]))
        {
            setcookie(session_name(), "", time() - 42000);
        }

        // destroy session
        session_destroy();
    }

   

    /**
     * Executes SQL statement, possibly with parameters, returning
     * an array of all rows in result set or false on (non-fatal) error.
     */
    function query(/* $sql [, ... ] */)
    {
        // SQL statement
        $sql = func_get_arg(0);

        // parameters, if any
        $parameters = array_slice(func_get_args(), 1);

        // try to connect to database
        static $handle;
        if (!isset($handle))
        {
            try
            {
                // connect to database
                $handle = new PDO("mysql:dbname=" . DATABASE . ";host=" . SERVER, USERNAME, PASSWORD);

                // ensure that PDO::prepare returns false when passed invalid SQL
                $handle->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
            }
            catch (Exception $e)
            {
                // trigger (big, orange) error
                trigger_error($e->getMessage(), E_USER_ERROR);
                exit;
            }
        }

        // prepare SQL statement
        $statement = $handle->prepare($sql);
        if ($statement === false)
        {
            // trigger (big, orange) error
            trigger_error($handle->errorInfo()[2], E_USER_ERROR);
            exit;
        }

        // execute SQL statement
        $results = $statement->execute($parameters);

        // return result set's rows, if any
        if ($results !== false)
        {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        else
        {
            return false;
        }
    }

    /**
     * Redirects user to destination, which can be
     * a URL or a relative path on the local host.
     *
     * Because this function outputs an HTTP header, it
     * must be called before caller outputs any HTML.
     */
    function redirect($destination)
    {
        // handle URL
        if (preg_match("/^https?:\/\//", $destination))
        {
            header("Location: " . $destination);
        }

        // handle absolute path
        else if (preg_match("/^\//", $destination))
        {
            $protocol = (isset($_SERVER["HTTPS"])) ? "https" : "http";
            $host = $_SERVER["HTTP_HOST"];
            header("Location: $protocol://$host$destination");
        }

        // handle relative path
        else
        {
            // adapted from http://www.php.net/header
            $protocol = (isset($_SERVER["HTTPS"])) ? "https" : "http";
            $host = $_SERVER["HTTP_HOST"];
            $path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
            header("Location: $protocol://$host$path/$destination");
        }

        // exit immediately since we're redirecting anyway
        exit;
    }

    /**
     * Renders template, passing in values.
     */
    function render($template, $values = [])
    {
        // if template exists, render it
        if (file_exists("../templates/$template"))
        {
            // extract variables into local scope
            extract($values);

            // render header
            require("../templates/header.php");

            // render template
            require("../templates/$template");

            // render footer
            require("../templates/footer.php");
        }

        // else err
        else
        {
            trigger_error("Invalid template: $template", E_USER_ERROR);
        }
    }
    /** Returns month in word form given number form**/
    function numtomonth($num)
    {
        switch($num)
        {
            case 1:
                return "Jan";
                break;
            case 2:
                return "Feb";
                break;
            case 3:
                return "Mar";
                break;
            case 4:
                return "Apr";
                break;
            case 5:
                return "May";
                break;
            case 6:
                return "Jun";
                break;
            case 7:
                return "Jul";
                break;
            case 8:
                return "Aug";
                break;
            case 9:
                return "Sep";
                break;
            case 10:
                return "Oct";
                break;
            case 11:
                return "Nov";
                break;
            case 12:
                return "Dec";
                break;
         }
    }
    /**Returns day of week in word form given number form**/
    function numtowk($num)
    {
        switch($num)
        {
            case 1:
                return "Mon";
                break;
            case 2:
                return "Tue";
                break;
            case 3:
                return "Wed";
                break;
            case 4:
                return "Thu";
                break;
            case 5:
                return "Fri";
                break;
            case 6:
                return "Sat";
                break;
            case 7:
                return "Sun";
                break;
         }
        }
    /**converts time from numeric form stored in database (0.000 to 24.000 with minutes as decimals .00 to .60) to string**/
    function converttime($time)
    {
        $hour=floor($time);
        
        $min=round(($time-$hour)*100, 2);
        $string="";
 
        if ($hour>12)
            $string=$string.($hour-12).':';
        else
        if ($hour==0)
            $string=$string.'12'.':';
        else
            $string=$string.$hour.':';
            
       if ($min>10)
            $string=$string.$min;
        else
            $string=$string.'0'.$min;
       if ($hour==24)
        $string=$string.'am';
       else     
       if ($hour>=12)
            $string=$string.'pm';   
        else
            $string=$string.'am';
        return $string;
        //return (($hour>12 ? $hour-12 : $hour).':'.($min>10 ? $min : "0".$min).(($hour>=12)&&($hour!=24) ? "pm" : "am"));
    }
    /**checks for leap year**/
    function isleap($num)
    {
        if ((($num%2==0)&&($num%100!=0))||($num%400==0))
            return true;
        return false;
    }
    /**increments day by one in keeping with calendar and packages as json**/
    function incrementday($year, $month, $day, $dayofwk)
    {
        $dayofwk=($dayofwk+1)%7;
        if ($dayofwk==0)
            $dayofwk=7;
        $day++;
        if ($day>28)
        switch($month)
        {
            case 1: case 3: case 5: case 7: case 8: case 10:
                if ($day>31)
                {
                    $day=1;
                    $month++;
                    break;
                }
            case 2:
                if (isleap($year))
                {
                    if ($day>29)
                    {
                        $day=1;
                        $month++;
                        break;
                     }
                }
                else
                {
                    if ($day>28)
                    {
                        $day=1;
                        $month++;
                        break;
                    }
                 }
           case 4: case 6: case 9: case 11:
                if ($day>31)
                {
                    $day=1;
                    $month++;
                    break;
                }
           case 12:
                if ($day>31)
                {
                    $day=1;
                    $month=1;
                    $year++;
                    break;
                }
        }
        $package=array("year"=>$year, "month"=>$month, "day"=>$day, "dayofwk"=>$dayofwk);
        echo json_encode($package);
    }
    /**increments day by one in keeping with calendar and returns associative array**/
    function incrementday2($year, $month, $day, $dayofwk)
    {
        $dayofwk=($dayofwk+1)%7;
        if ($dayofwk==0)
            $dayofwk=7;
        $day++;
        if ($day>28)
        switch($month)
        {
            case 1: case 3: case 5: case 7: case 8: case 10:
                if ($day>31)
                {
                    $day=1;
                    $month++;
                    break;
                }
            case 2:
                if (isleap($year))
                {
                    if ($day>29)
                    {
                        $day=1;
                        $month++;
                        break;
                     }
                }
                else
                {
                    if ($day>28)
                    {
                        $day=1;
                        $month++;
                        break;
                    }
                 }
           case 4: case 6: case 9: case 11:
                if ($day>31)
                {
                    $day=1;
                    $month++;
                    break;
                }
           case 12:
                if ($day>31)
                {
                    $day=1;
                    $month=1;
                    $year++;
                    break;
                }
        }
        return array("year"=>$year, "month"=>$month, "day"=>$day, "dayofwk"=>$dayofwk);
    }
    /**decrements day by one in keeping with calendar and packages as json**/
    function decrementday($year, $month, $day, $dayofwk)
    {
        $dayofwk=($dayofwk+7-1)%7;
        if ($dayofwk==0)
            $dayofwk=7;
        $day--;
        if ($day<1)
        switch($month)
        {
            case 5: case 7: case 10: case 12:
                //if ($day<0)
                {
                    $day=30;
                    $month--;
                    break;
                }
            case 3:
                if (isleap($year))
                {
                        $day=29;
                        $month--;
                        break;
                }
                else
                {
                        $day=28;
                        $month--;
                        break;
                 }
           case 2: case 4: case 6: case 8: case 9: case 11:
                {
                    $day=31;
                    $month--;
                    break;
                }
           case 1:
                {
                    $day=31;
                    $month=12;
                    $year--;
                    break;
                }
        }
        $package=array("year"=>$year, "month"=>$month, "day"=>$day, "dayofwk"=>$dayofwk);
        echo json_encode($package);
    }
    /**decrements day by one in keeping with calendar and returns associative array**/
    function decrementday2($year, $month, $day, $dayofwk)
    {
        $dayofwk=($dayofwk+7-1)%7;
        if ($dayofwk==0)
            $dayofwk=7;
        $day--;
        if ($day<1)
        switch($month)
        {
            case 5: case 7: case 10: case 12:
                {
                    $day=30;
                    $month--;
                    break;
                }
            case 3:
                if (isleap($year))
                {
                        $day=29;
                        $month--;
                        break;
                }
                else
                {
                        $day=28;
                        $month--;
                        break;
                 }
           case 2: case 4: case 6: case 8: case 9: case 11:
                {
                    $day=31;
                    $month--;
                    break;
                }
           case 1:
                {
                    $day=31;
                    $month=12;
                    $year--;
                    break;
                }
        }
        return array("year"=>$year, "month"=>$month, "day"=>$day, "dayofwk"=>$dayofwk);
    }
    /**returns time as fraction of hour--for use in week display, where there are 15-minute(.25 of an hour) increments**/
    function roundtime($time)
    {
        $hour=floor($time);
        $min=round(($time-$hour)*100, 2);
        if (($min>0)&&($min<=7))
            $min=0;
        else
        if (($min>7)&&($min<=22))
            $min=25;
        else
        if (($min>22)&&($min<=37))
            $min=50;
        else
        if (($min>37)&&($min<=52))
            $min=75;
        else
        if (($min>52)&&($min<60))
        {
            $min=0;
            $hour++;
        }
        return ($hour+($min/100));
    }
    /** finds day of week of first day of month given reference info **/
    function findfirstday($month, $day, $dayofwk)
    {
        while ($day>1)
        {
            $day=$day-1;
            $dayofwk=($dayofwk+7-1)%7;
        }
        return ($dayofwk);
    }
    /** find last day of month given reference info**/
    function findlastday($year, $month)
    {
        switch($month)
        {
            case 4: case 6: case 9: case 11:
                {
                    return 30;                
                }
            case 2:
                if (isleap($year))
                {                 
                        return 29;              
                }
                else
                {
                 	return 28;               
                 }
           case 1: case 3: case 5: case 7: case 8: case 10: case 12:
             
                {
                    return 31;
                }
      
        }
    }
?>
