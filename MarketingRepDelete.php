<?php
session_start();
$service = $_GET['serviceToDelete'];
mysql_connect('localhost','root','');
//select database
mysql_select_db('service');

mysql_query("DELETE FROM serviceinfo WHERE serviceName = '$service'");
header("location: adminViewServices.php?code=1");

?>