<?php
include 'Account.php';

session_start();
$account = $_SESSION['accountObject'];
$thres = $_POST['Threshold'];

$accountO = unserialize(base64_decode($account));

$toString = $accountO->setThreshold($thres);
$toStore = base64_encode(serialize($toString));

mysql_connect('localhost','root','');

//select database
mysql_select_db('customer');

$sql="SELECT * FROM account" or die("Something wrong");

$records=mysql_query($sql);
while($rs = mysql_fetch_assoc($records)){
	$name = $rs['username'];
	if($rs['username'] == $accountO->getName()){
	//	echo "<br>here";
		mysql_query("UPDATE `account` SET serializedObject = '$toStore' WHERE 
					username = '$name'") or die(mysql_error());
		break;
	}
}

echo "Your threshold is now set to ".$toString->getThreshold();
echo "<br>We will inform when your account balance exceeds the threshold.<br>";