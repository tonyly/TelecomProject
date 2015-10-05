<?php
include 'Account.php';

session_start();
$account = $_GET['accountS'];

$customer = unserialize(base64_decode($account));

echo "You need to pay ".$customer->viewBalance()." dollars for next payment!";
echo "<br>Thank you for using Telecom services.<br>";

?>