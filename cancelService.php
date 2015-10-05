<?php 
session_start();
mysql_connect('localhost','root','');
$serviceN = $_GET['sn'];
$accountname = $_GET['name'];
$action = $_GET['action'];
$code = $_GET['code'];  //customer or customer service rep
if($action == 0)  //service
    unsubscribedService($serviceN, $accountname, $code);
else if ($action == 1) //package
    unsubscribedPackage($serviceN, $accountname, $code);

if($code == 0){
    echo "<a href='../myservices.php?'>My Service</a>";
    echo "<br><a href='../viewAccountBalance.php'>View Account Balance</a>";
}
else
  echo "<a href='../displayaccounts.php'>Admin display accounts</a>";

function unsubscribedService($serviceN, $accountname, $code)
{
	$user = $accountname;
    
   	mysql_select_db('customer');
   	$sql="SELECT * FROM account";

    $q = mysql_query($sql);
    $unsubs = 0;
    $newBalance = 0;
    while($rs = mysql_fetch_assoc($q)){
        if($rs['username']==$user){
        	$newBalance = $rs['accountBalance'];
            $serviceArray = explode(";", $rs['subscribedS']);
            
            $i = 0;
            foreach ($serviceArray as $element) {
            	if($element == $serviceN){
            	    unset($serviceArray[$i]);
            	    $unsubs = 1;
            	    break;
            	}
            	$i++;
            }
            if($unsubs== 1){
            	
            	$new=implode(";", $serviceArray);
            	mysql_query("UPDATE `account` SET subscribedS = '$new' WHERE username = '$user'") or die(mysql_error()); 	  
            	echo $serviceN;
            	echo " is unsubscribed!<br>";
            	$unsubs = 2;
           	}
           	else{
            	echo $serviceN;
            	echo " you did not subscribe ".$serviceN." so it cannot be unsubscribed<br>";
            }
 			
        }
        if($unsubs == 2){
            mysql_select_db('service');
            $sql2="SELECT * FROM serviceinfo";
            $q2 = mysql_query($sql2);
            while($result=mysql_fetch_assoc($q2)){
                if($result['serviceName'] == $serviceN){
                    $newBalance= $newBalance - $result['servicePrice'] + 5;
                    break;
                }

            }
            mysql_select_db('customer');
            mysql_query("SELECT * FROM account");
            mysql_query("UPDATE account SET accountBalance = '$newBalance' WHERE username = '$user'") or die(mysql_error());
            break;
        }
               	
    }
}

function unsubscribedPackage($package, $accountname, $code)
{
	$user = $accountname;
    //echo $serviceN."<br>";
   	mysql_select_db('customer');
   	$sql="SELECT * FROM account";

    $q = mysql_query($sql);
    $unsubs = 0;
    $newBalance = 0;
    while($rs = mysql_fetch_assoc($q)){
        if($rs['username']==$user){
        	$newBalance = $rs['accountBalance'];
            $packageArray = explode(";", $rs['subscribedP']);
            //print_r($serviceArray);
            //echo $serviceArray[0]."<br>";
            $i = 0;
            foreach ($packageArray as $element) {
            	if($element == $package){
            	    //echo "remove<br>";
            	    unset($packageArray[$i]);
            	    //print_r($serviceArray);
            	    $unsubs = 1;
            	    break;
            	}
            	$i++;
            }
            if($unsubs== 1){
            	     
            	$new=implode(";", $packageArray);
            	//echo $new."<br>";
            	mysql_query("UPDATE `account` SET subscribedP = '$new' WHERE username = '$user'") or die(mysql_error()); 	  
            	echo $package;
            	echo " is unsubscribed!<br>";
            	$unsubs = 2;
           	}
           	else{
            	echo " you did not subscribe ".$package." so it cannot be unsubscribed<br>";
            }
 			
            	   
        }
        if($unsubs == 2){
            mysql_select_db('service');
            $sql2="SELECT * FROM packageinfo";
            $q2 = mysql_query($sql2);
            while($result=mysql_fetch_assoc($q2)){
                if($result['packageName'] == $package){
                    $newBalance= $newBalance - $result['packagePrice']+20;
                    break;
                }

            }
            mysql_select_db('customer');
            mysql_query("SELECT * FROM account");
            mysql_query("UPDATE account SET accountBalance = '$newBalance' WHERE username = '$user'") or die(mysql_error());
            break;
        }
               	
    }
}
?>