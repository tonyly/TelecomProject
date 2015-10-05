<?php
	include 'spFactory.php';

	$serviceToAdd=$_POST['serviceName'];
    $serviceoption=$_POST['serviceoption'];
    $servicePrice=$_POST['price'];
    $serviceDuration=$_POST['duration'];

    $taken="false";
    $database="service";
    $username="root";
    $password="";

    if($serviceToAdd&&$servicePrice&&$serviceoption){ 
    //connect to database
        $con=mysql_connect('localhost',$username,$password) or die("Unable to login to database");
        @mysql_select_db($database,$con) or die("Unable to connect");


        $query = "SELECT * FROM `serviceInfo` WHERE `serviceName` = '$serviceToAdd'";
        $result = mysql_query($query);
        $row = mysql_fetch_array($result);
        $tmpservice = $row["serviceName"];

        if($tmpservice==$serviceToAdd){
            echo "This service is already in the database<br>";
            echo "Please pick a different service name!<br>";
            mysql_close($con);
        }
        else{
        	$newService = spFactory::createService($serviceToAdd, $serviceoption,
        	                         $servicePrice, $serviceDuration);
        	echo $newService->get_type();
        	$serialized = base64_encode(serialize($newService));
            mysql_query("INSERT INTO `serviceinfo` VALUES ('$serviceToAdd', ' ', 
                        '$serialized')") or die("Strange error");

            echo "Service ".$serviceToAdd." is added to database<br>";

            mysql_close($con);
 
        }
    }
    else{
        echo "You need to have a serviceName, serviceType, price to register";
    }  
    
	echo "<a href='../adminViewServices.php?code=1'>View Available Services</a>";
?>

