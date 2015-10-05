<?php
	$serviceToAdd=$_POST['serviceName '];
    $serviceoption=$_POST['serviceoption'];
    $servicePrice=$_POST['price'];

    $taken="false";
    $database="service";
    $username="root";
    $password="";

    if($serviceToAdd&&$servicePrice&&$serviceoption){ 
    //connect to database
        $con=mysql_connect('localhost',$username,$password) or die("Unable to login to database");
        @mysql_select_db($database,$con) or die("Unable to connect");


        $query = "SELECT * FROM `serviceInfo` WHERE `username` = '$serviceToAdd'";
        $result = mysql_query($query);
        $row = mysql_fetch_array($result);
        $tmpservice = $row["username"];

        if($tmpservice==$serviceToAdd){
            echo "This service is already in the database";
            mysql_close($con);
        }
        else{
            mysql_query("INSERT INTO `serviceinfo` VALUES ('$serviceToAdd', 'serviceoption','', 
                        'servicePrice')") or die("Strange error");

            echo "Service Created";

            mysql_close($con);
 
            header("location: index.html");
        }
    }
    else{
        echo "You need to have a serviceName, serviceType, price to register";
    }           
        
?>