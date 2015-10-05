<?php 
session_start();
mysql_connect('localhost','root','');
$serviceN = $_GET['sn'];
$accountname = $_GET['name'];
unsubscribedService($serviceN, $accountname);

function unsubscribedService($serviceN, $accountname)
    	  {
    	  	$user = $accountname;
            //echo $serviceN."<br>";
    	  	mysql_select_db('customer');
    	  	$sql="SELECT * FROM account";

            $q = mysql_query($sql);
            $unsubs = 0;
            while($rs = mysql_fetch_assoc($q)){
            	if($rs['username']==$user){
            		$serviceArray = explode(";", $rs['subscribedS']);
            		//print_r($serviceArray);
            	    //echo $serviceArray[0]."<br>";
                    $i = 0;
            	    foreach ($serviceArray as $element) {
            	    	if($element == $serviceN){
            	    		//echo "remove<br>";
            	    		unset($serviceArray[$i]);
            	    		//print_r($serviceArray);
            	    		$unsubs = 1;
            	    		break;
            	    	}
            	    	$i++;
            	    }
            	    if($unsubs== 1){
            	     
            	      $new=implode(";", $serviceArray);
            	      //echo $new."<br>";
            	      mysql_query("UPDATE `account` SET subscribedS = '$new' WHERE username = '$user'") or die(mysql_error()); 	  
            	      echo $serviceN;
            	      echo " is unsubscribed!<br>";
            	   }
            	   else{
            	   	  echo $serviceN;
            	   	  echo " you are not subscribing the service so it cannot be unsubscribed<br>";
            	   }

            	   echo "<a href='../myservices.php?'>My Service</a>";
            	   break;
            	}
               	
            }
        }

?>