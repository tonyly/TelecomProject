<?php
include 'Account.php';
include 'Service.php';
include 'Package.php';
//make connection
session_start();
mysql_connect('localhost','root','');

//select database
mysql_select_db('customer');

$sql="SELECT * FROM account";

$records=mysql_query($sql);
?>

<html>
<head>
  <title>Customer Accounts</title>
</head>

<body>

  <table width="600" border="1" cellpadding="1" cellspacing="1">
  <tr>
  
  <th>Account ID</th>
  <th>Username</th>
  <th>Email</th>
  <th>Address</th>
  <th>City</th>
  <th>Account Type</th>
  <th>Service Subscribed</th>
  <th>Package Subscribed</th>
  <th>Account Balance</th>
  <th>Account Threshold</th>

  </tr>

  <?php
  echo "Welcome Admin " .$_SESSION['user']. "!";
  $code = 1;
  while($account=mysql_fetch_assoc($records)){
  	$accountObject = $account['serializedObject'];
  	$customer = unserialize(base64_decode($account['serializedObject']));
  	echo "<tr>";
    echo "<td>".$account['customer_ID']."</td>";
    $accountname = $account['username'];
    echo "<td><a href='../viewservices.php?accountS=$accountObject
          &name=$accountname&code=$code'>add to ".$account['username']."'s account</a></td>";
    echo "<td>".$customer->getEmail()."</td>";
    echo "<td>".$account['address']."</td>";
    echo "<td>".$account['city']."</td>";
    echo "<td>".$customer->get_type()."</td>";
    $service = $customer->getS();
    $ss = "";
    $toArray = array();
    foreach($service as $element){
    	array_push($toArray, $element->getName());
    }
    $ss = implode(';', $toArray);
    $package = $customer->getP();
    $ps = "";
    $toArray2 = array();
    foreach($package as $element){
    	array_push($toArray2, $element->getName());

    }
    $ps = implode(';', $toArray2);
    echo "<td>".$ss."</td>";
    echo "<td>".$ps."</td>";
    echo "<td>".$customer->getBalance()."$/month</td>";
    echo "<td>".$customer->getThreshold()."$</td>";
  	echo "</tr>";
  }//end while
  ?>

  </table> 
  
</body>
</html>