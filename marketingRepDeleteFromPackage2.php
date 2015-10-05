<?php
session_start();
mysql_connect('localhost','root','');
    //select database
mysql_select_db('service');
$sql="SELECT * FROM packageinfo" or die("Something wrong");
$records=mysql_query($sql);  
$service = $_GET['element'];
$package = $_GET['pn'];

while($rs=mysql_fetch_assoc($records)){
	if($rs['packageName'] == $package){
		$serviceArray = explode(';',$account['services']);
    	$index = 0;
		foreach ($serviceArray as $key) {
			if($key == $service){
				unset($serviceArray[$index]);
				break;
		}
		$index++;
	}

	$new = implode(';', $serviceArray);

	mysql_query("UPDATE `packageinfo` SET services = '$new' WHERE packageName = '$package'") or die(mysql_error());
		break;
	}
}

echo "<a href='../adminUpdatePackagePrice.html'>Updtae Package Price</a><br>";

echo "<a href='../adminViewPackages.php?code=1'>View Package Info</a>";

?>