<?php
session_start();
mysql_connect('localhost','root','');
    //select database
mysql_select_db('service');
$sql="SELECT * FROM packageinfo" or die("Something wrong");
$records=mysql_query($sql);  
$ps = $_GET['ps'];
$po = unserialize(base64_encode($ps));

echo "Deleting Service From Package ".$po->getName()."<br><br>";

$services = $po->getServices();
foreach($services as $element){
	
}
while($account=mysql_fetch_assoc($records)){
	$currName = $account['packageName'];
	if($currName == $pn){
		$service = $account['services'];

		if(strlen($service)!=0){
        	$serviceArray = explode(";", $service);
        	echo "Choose a service to delete: <br>";    

        	foreach ($serviceArray as $element) {
            	echo "<a href='../marketingRepDeleteFromPackage2.php?element=$element&package=$pn'>$element</a><br>";
        	}
    	}           
    	else{
        	echo "The Package selected is currently empty. Please customize first!<br>";
    	}
	}		
}
?>