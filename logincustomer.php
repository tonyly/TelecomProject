<?php
session_start();

  $inputuser = $_POST["user"];
  $inputpass = $_POST["pass"];

  $database = "customer";
  $user = "root";
  $password = "";

  $connect = mysql_connect("localhost",$user,$password);
  @mysql_select_db($database) or ("Database not found");

  $query = "SELECT * FROM `account` WHERE `username` = '$inputuser'";
  $querypass = "SELECT * FROM `account` WHERE `password` = '$inputpass'";

  $result = mysql_query($query);
  //$resultpass = mysql_query($querypass);

  $row = mysql_fetch_array($result);
  //$rowpass = mysql_fetch_array($resultpass);

  $serveruser = $row["username"];
  $serverpass = $row["password"];
  $serveraccount = $row["serializedObject"];

  //$serverwireless = $row["serverwireless"];

  if($serveruser&&$serverpass){
    if(!$result){
      die("Username or password is invalid");
    }
    mysql_close();
  }


if(!empty($inputuser) &&!empty($inputpass)&&$inputuser == $serveruser && $inputpass == $serverpass){
  
  $_SESSION['user'] = $inputuser;
  $_SESSION['pass'] = $serverpass;
  $_SESSION['accountObject'] = $serveraccount;

  $code = 0;
  echo "Welcome " .$_SESSION['user']. "!";
  echo "<li><a href='../logout.php'>Logout</a></li>";
  echo "<li><a href='../myservices.php'>My Services/Packages</a></li>";
  echo "<li><a href='../viewservices.php?name=$serveruser&accountS=$serveraccount
                     &code=$code'>View Services/Packages</a></li>";
  echo "<li><a href='../viewAccountBalance.php?accountS=$serveraccount'>View Account Balance</a></li>";
  echo "<li><a href='../setThreshold.html'>Set Threshold</a></li>";

}
else{
  //header('Location: comingsoon.html');
  echo "Invalid login";
}

?>