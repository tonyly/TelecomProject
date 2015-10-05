<?php
include 'Package.php';
session_start();

$price = $_POST['packagePrice'];
if ($price < 0){
	echo "Price invalid. <a href='../adminUpdatePackagePrice.html'>Please Enter a positive number.</a>";
}
else{
	$package = $_SESSION['package'];
	mysql_connect('localhost','root','');
	mysql_select_db('service');
	$sql="SELECT * FROM packageinfo" or die("Something wrong");
	$records=mysql_query($sql);  

	while($packageName=mysql_fetch_assoc($records)){
		if ($packageName['packageName'] == $package->getName()){
			echo "here";
			$pn = $package->getName();
			$toString = $package->setPrice($price);
			$toStore = base64_encode(serialize($toString));

			mysql_query("UPDATE `packageinfo` SET packageObject = '$toStore' WHERE packageName = '$pn'") or die(mysql_error());
			echo $package->getName()." is now ".$price." dollars per month!<br>";
			break;
		}
	}
	echo "<a href='../adminViewPackages.php?code=1'>View Updated Package Info</a>";
}
?>