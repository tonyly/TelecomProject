 <?php
 include 'spFactory.php';

	$package=$_POST['packageName'];
    $duration=$_POST['packageDuration'];
    if ($duration == 0){
    	$duration = 1;
    }

    $taken="false";
    $database="service";
    $username="root";
    $password="";

    if($package){ 
    //connect to database
        $con=mysql_connect('localhost',$username,$password) or die("Unable to login to database");
        @mysql_select_db($database,$con) or die("Unable to connect");


        $query = "SELECT * FROM `packageinfo` WHERE `packageName` = '$package'";
        $result = mysql_query($query);
        $row = mysql_fetch_array($result);
        $tmpservice = $row["packageName"];

        if($tmpservice==$package){
            echo "This package name is already being used.<br>";
            echo "Please pick a different package name!<br>";
            mysql_close($con);
        }
        else{
        	$newPackage = spFactory::createPackage($package, $duration);
        	$newPackage->setName($package);
        	$newPackage->setDuration($duration);
        	$serialized = base64_encode(serialize($newPackage));

            mysql_query("INSERT INTO `packageinfo` VALUES ('$package', '', '$serialized')") 
                       or die("Strange error");

            echo "Package ".$package." is added to database<br>";
            echo "Please further customize your package by adding services<br>";

            mysql_close($con);
 
        }
    }
    else{
        echo "You need to have a serviceName, serviceType, price to register";
    }  
    
	echo "<a href='../adminViewServices.php?code=1'>View Available Services</a><br>";
	echo "<a href='../adminViewPackages.php?code=2'>View Available packages</a>";
?>