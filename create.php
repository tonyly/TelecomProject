<?php 
include 'Account.php';
$userreg=$_POST['user'];
$emailreg=$_POST['email'];
$passreg=$_POST['pass'];
$confirmreg=$_POST['confirm'];
$addressreg=$_POST['address'];
$cityreg=$_POST['city'];
$accountoptionreg=$_POST['accountoption'];

$taken="false";
$database="customer";
$username="root";
$password="";
if($confirmreg!==$passreg){
  die("Password missmatch");
}
if($userreg&&$passreg){
	//connect to database
	$con=mysql_connect('localhost',$username,$password) or die("Unable to login to database");
	@mysql_select_db($database,$con) or die("Unable to connect");


	$query = "SELECT * FROM `account` WHERE `username` = '$userreg'";
	$result = mysql_query($query);
    $row = mysql_fetch_array($result);
    $serveruser = $row["username"];

    if($serveruser==$userreg){
	  echo "This username is already taken";
	  mysql_close($con);
    }
    else{
    	$customer;
    	if($accountoptionreg == "Retail"){
    		$customer = new RetailCustomer();
    		$customer->setName($userreg);
    		$customer->setEmail($emailreg);
    	}
    	else{
    		$customer = new CommercialCustomer();
    		$customer->setName($userreg);
    		$customer->setEmail($emailreg);
    	}

    	$serialized = base64_encode(serialize($customer));
	  	mysql_query("INSERT INTO `account` VALUES ('','$userreg','$passreg', '$serialized',
	  		         '$addressreg','$cityreg')")or die("strange error");
	  	echo "Account Created";

	  	mysql_close($con);

	  	//header("location: index.html");
	}
}
else{
	echo "You need to have a username, password, address, city,  and password";
}

?>