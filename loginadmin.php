<?php
session_start();
$inputuser = $_POST["user"];
$inputpass = $_POST["pass"];

$database = "admin";
$user = "root";
$password = "";
$connect = mysql_connect("localhost",$user,$password);
@mysql_select_db($database) or ("Database not found");

$query = "SELECT * FROM `account` WHERE `username` = '$inputuser'";
$querypass = "SELECT * FROM `account` WHERE `password` = '$inputpass'";

$result = mysql_query($query);
$resultpass = mysql_query($querypass);

$row = mysql_fetch_array($result);
$rowpass = mysql_fetch_array($resultpass);

$serveruser = $row["username"];
$serverpass = $row["password"];
$servertype = $row["accountType"];
$i = 0;
if($servertype == "Customer Service Representative"){
	$i = 0;
}
else if($servertype == "Marketing Representative"){
	$i = 1;
}

if($serveruser&&$serverpass){
  if(!$result){
    die("Username or password is invalid");
  }
  mysql_close();
}

if(!empty($inputuser) &&!empty($inputpass)&&$inputuser == $serveruser && $inputpass == $serverpass){
  $_SESSION['user'] = $inputuser;
  $_SESSION['pass'] = $serverpass;
  echo "Welcome " .$_SESSION['user']. "!";
  echo "<li><a href='../logout.php'>Logout</a></li>";
  if($i == 1){
  	echo "<li><a href='../marketingRepAdd.html'>Add Service</a></li>";
  	echo "<li><a href='../adminViewServices.php?code=$i'>Delete Service</a></li>";
    echo "<li><a href='adminViewServices.php?code=1'>View Services</a></li>";
    echo "<li><a href='adminViewPackages.php?code=1'>View Packages</a></li>";
    echo "<li><a href='adminViewServices.php?code=1'>Add services to existing package</a></li>";
    echo "<li><a href='adminViewPackages.php?code=1'>Delete services from Existing Package</a></li>";
    echo "<li><a href='../marketingRepCreatePackage.html'>Create a new package</a></li>";
    echo "<li><a href='../signup.html'>Sign up Commerical Customer</a></li>";
  }
  else if ($i == 0){
  	echo "<li><a href='adminViewServices.php?code=0'>View Services</a></li>";
  	echo "<li><a href='adminViewPackages.php?code=-1'>View Packages</a></li>";
  }
  echo "<li><a href='../displayaccounts.php'>View Accounts</a></li>";
}
else{
  header('Location: comingsoon.html');
}
?>