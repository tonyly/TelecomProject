<?php
include 'Service.php';
include 'Package.php';
include 'Account.php';

session_start();
mysql_connect('localhost','root','');
$accountName = $_GET['name'];
$accountS = $_GET['accountS'];

//$try = unserialize(base64_decode($accountS));

echo $accountName;
//select database
mysql_select_db('service');

$sql="SELECT * FROM serviceinfo" or die("Something wrong");
$code = $_GET['code'];
$records=mysql_query($sql);
?>
<html>
<head>
  <title>Services</title>
</head>

<body>
  <table width="600" border="1" cellpadding="1" cellspacing="1">
  <tr>
    <th>Available Services</th>
    <th>Service Type</th>
    <th>Price($/month)</th>
    <th>Duration(months)</th>
    <th>Subscribe</th>
    <th>Unsubscribe</th>
  </tr>
        <?php
    	while($account=mysql_fetch_assoc($records)){
    		$currS = $account['serviceObject'];
    		$curr = unserialize(base64_decode($currS));

    		echo "<tr>";
    		echo "<td>".$account['serviceName']."</td>";
    		echo "<td>".$curr->get_type()."</td>";
    		echo "<td>$".$curr->getPrice()."$/month</td>";
    		echo "<td>".$curr->getDuration()."  months</td>";
    		echo "<td><a href='../Facade.php?type=0&customer=$accountS&o=$currS&action=0'>Subscribe</a></td>";
            echo "<td><a href='../Facade.php?type=0&customer=$accountS&o=$currS&action=1'>UnSubscribe</a></td>";
    	   

    	 //   subscribeService($account['serviceName']);
    	  
    	//	echo "<td>Unsubscribe</td>";
          //  unsubscribedService($account['serviceName']);
    		echo "</tr>";
    	}
    

    	
    	  
    	?>
    </table>
    <br><br><br>
    	<table width="600" border="1" cellpadding="1" cellspacing="1">
 		<tr>
    	<th>Available Package</th>
    	<th>Reference Number</th>
    	<th>Services</th>
    	<th>Price</th>
    	<th>Duration</th>
    	<th>Subscribe</th>
    	<th>Unsubscribe</th>
  		</tr>
        <?php
        	mysql_connect('localhost','root','');
        	mysql_select_db('service');
        	$sql="SELECT * FROM packageinfo" or die("Something wrong");
        	$records = mysql_query($sql);
    		while($account=mysql_fetch_assoc($records)){
    			$pn = $account['packageName'];
    			$ps = $account['packageObject'];
    			$po = unserialize(base64_decode($ps));
    			$services = $po->getServices();
    			$serviceArray = array();
    			foreach($services as $element){
    				array_push($serviceArray, $element->getName());

    			}
    			$ss = implode(";", $serviceArray);
    			echo "<tr>";
    			echo "<td>".$account['packageName']."</td>";
    			echo "<td>".$account['packageNumber']."</td>";
    			echo "<td>$".$ss."</td>";
    			echo "<td>$".$po->getPrice()."/month</td>";
    			echo "<td>".$po->getDuration()."  months</td>";
    			echo "<td><a href='../Facade.php?type=1&customer=$accountS&o=$ps&action=0'>Subscribe</a></td>";
            	echo "<td><a href='../Facade.php?type=1&customer=$accountS&o=$ps&action=1'>UnSubscribe</a></td>";
    	   

    	 //   subscribeService($account['serviceName']);
    	  
    	//	echo "<td>Unsubscribe</td>";
          //  unsubscribedService($account['serviceName']);
    			echo "</tr>";
    		}
    

    	
    	
    	?>
    	</table>
    	<?php
    	if($code == 0)
    		echo "<br><a href='../viewAccountBalance.php'>View Account Balance</a>";  
    	?>
    </body>
</html>