<?php 
session_start(); // adding a comment
mysql_connect('localhost','root','');
$serviceN = $_GET['sn'];
$accountname = $_GET['name'];
$code = $_GET['code'];
$action = $_GET['action'];

if($action == 0)
    subscribeService($serviceN, $accountname, $code);
else if($action == 1)
    subscribePackage($serviceN, $accountname, $code);

if($code == 0){
    echo "<a href='../myservices.php'>My Service/Package</a>";
    echo "<br><a href='../viewAccountBalance.php'>View Account Balance</a>";
}
else    
    echo "<a href='../displayaccounts.php'>Admin display accounts</a>";
        

function subscribeService($serviceN, $accountname, $code)
{
    echo "Subscribe Service<br><br>";
    $user = $accountname;
    mysql_select_db('customer');
    $sql="SELECT * FROM account";
    $q = mysql_query($sql);
    $subs = 0;
    $newBalance = 0;
    while($rs = mysql_fetch_assoc($q)){
        if($rs['username']==$user){
            $newBalance = $rs['accountBalance'];
            if(strlen($rs['subscribedS']) != 0){
            	$serviceArray = explode(";", $rs['subscribedS']);
                    
            	      //echo $serviceArray[0];
            	foreach ($serviceArray as $element) {
            	    if($element == $serviceN){
            	    	echo $serviceN." is already subscribed!<br>";
            	    	$subs = 1;
                        break;
            	    }
            	}

            	if($subs == 0){
            	    array_push($serviceArray, $serviceN);
            	    $new=implode(";", $serviceArray);
            	    mysql_query("UPDATE `account` SET subscribedS = '$new' WHERE username = '$user'") or die(mysql_error()); 	  
                    echo $serviceN;
                    echo " is now subscribed<br>";
                    $subs = 2;
            	}
            }
            else {
                $new = $serviceN;
                mysql_query("UPDATE `account` SET subscribedS = '$new' WHERE username = '$user'") or die(mysql_error());       
                echo $serviceN;
                echo " is now subscribed<br>";
                $subs = 2;
            } 

        }
        if($subs == 2){
            mysql_select_db('service');
            $sql2="SELECT * FROM serviceinfo";
            $q2 = mysql_query($sql2);
            while($result=mysql_fetch_assoc($q2)){
                if($result['serviceName'] == $serviceN){
                    $newBalance+=$result['servicePrice'];
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

 
function subscribePackage($package, $accountname, $code)
{
    echo "Subscribe Package<br><br>";
    $user = $accountname;
    mysql_select_db('customer');
    $sql="SELECT * FROM account";
    $q = mysql_query($sql);
    $newBalance = 0;
    $subs = 0;
    while($rs = mysql_fetch_assoc($q)){
        if($rs['username']==$user){
            $newBalance = $rs['accountBalance'];
            if(strlen($rs['subscribedP']) != 0){
                $packageArray = explode(";", $rs['subscribedP']);
                    
                      //echo $serviceArray[0];
                foreach ($packageArray as $element) {
                    if($element == $package){
                        echo $package." is already subscribed!<br>";
                        $subs = 1;
                        break;
                    }
                }

                if($subs == 0){
                    array_push($packageArray, $package);
                    $new=implode(";", $packageArray);
                    mysql_query("UPDATE `account` SET subscribedP = '$new' WHERE username = '$user'") or die(mysql_error());      
                    echo $package;
                    echo " is now subscribed<br>";
                    $subs = 2;
                }
            }
            else {
                $new = $package;
                mysql_query("UPDATE `account` SET subscribedP = '$new' WHERE username = '$user'") or die(mysql_error());       
                echo $package;
                echo " is now subscribed<br>";
                $subs = 2;
            } 
        }
        if($subs == 2){
            mysql_select_db('service');
            $sql2="SELECT * FROM packageinfo";
            $q2 = mysql_query($sql2);
            while($result=mysql_fetch_assoc($q2)){
                if($result['packageName'] == $package){
                    $newBalance+=$result['packagePrice'];
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
