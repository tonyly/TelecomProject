<?php
include 'Package.php';
include 'Service.php';
session_start();
$serviceS = $_GET['service'];
$packageS = $_GET['ps'];
$pn = $_GET['pn'];

$service = unserialize(base64_decode($serviceS));
$package = unserialize(base64_decode($packageS));

$_SESSION['package'] = $package;

$toString = $package->updateServices($service);
$toStore = base64_encode(serialize($toString));

mysql_connect('localhost','root','');
mysql_select_db('service');
$sql="SELECT * FROM packageinfo" or die("Something wrong");
$records=mysql_query($sql);  

while($packageName=mysql_fetch_assoc($records)){
	if($packageName['packageName'] == $pn){
		mysql_query("UPDATE `packageinfo` SET packageObject = '$toStore' 
			        WHERE packageName = '$pn'") or die(mysql_error());
		break;
	}
}

echo "<br><a href='../adminUpdatePackagePrice.html'>Update Package Price</a><br>";
echo "<a href='../adminViewPackages.php?code=2'>View package info</a><br>";      	   
echo "<a href='../adminViewServices.php?code=1'>Return to View Services</a>";

/*serviceAddToPackage($service, $package);

function serviceAddToPackage($service, $package){
	echo $package;
	mysql_connect('localhost','root','');
	mysql_select_db('service');
	$sql="SELECT * FROM packageinfo";
    $q = mysql_query($sql);
    $subs = 0;
    while($rs = mysql_fetch_assoc($q)){
        if($rs['packageName']==$package){
            if(strlen($rs['services']) != 0){
            	$serviceArray = explode(";", $rs['services']);
                    
            	      //echo $serviceArray[0];
            	foreach ($serviceArray as $element) {
            	    if($element == $service){
            	    	echo $service." is already offered in package ".$package."!<br>";
            	    	$subs = 1;
                        break;
            	    }
            	}

            	if($subs == 0){
            	    array_push($serviceArray, $service);
            	    $new=implode(";", $serviceArray);
            	    mysql_query("UPDATE `packageinfo` SET services = '$new' WHERE packageName = '$package'") or die(mysql_error()); 	  
                    echo $service;
                    echo " is now added to package ".$package."<br>";
            	}
            }
            else {
                $new = $service;
                mysql_query("UPDATE `packageinfo` SET services = '$new' WHERE packageName = '$package'") or die(mysql_error());       
                echo $service;
                echo " is now added to package ".$package."<br>";
            } 
        }
    //    if($code == 0)

      //  else    
        //    echo "<a href='../displayaccounts.php'>Admin display accounts</a>";
    } 
    echo "<a href='../adminUpdatePackagePrice.html'>Update Package Price</a><br>";
    echo "<a href='../adminViewPackages.php?code=2'>View package info</a>";      	   
}*/
?>