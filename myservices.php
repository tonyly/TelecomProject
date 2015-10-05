<?php
include 'Account.php';
include 'Service.php';
include 'Package.php';


session_start();
mysql_connect('localhost','root','');

//select database
mysql_select_db('customer');

$sql="SELECT * FROM account" or die("Something wrong");

$records=mysql_query($sql);
while($rs = mysql_fetch_assoc($records)){
    if($rs['username']==$_SESSION['user']){
    	$currS = $rs['serializedObject'];
		$curr = unserialize(base64_decode($currS));
		$ss = $curr->getS();
		$sp = $curr->getP();
        $string = '';
        $serviceArray = array();
		foreach($ss as $element){
			$tmp = $element->getName();
			array_push($serviceArray, $tmp);
		}

		$string = implode(";", $serviceArray);
        echo $string;
        if(strlen($string) == 0)
            echo "No service subscribed!<br>";
        else
            echo " are currently subscribed services<br>";
        $string2 = '';
        $packageArray = array();
        foreach($sp as $element){
        	array_push($packageArray, $element->getName());
        }
        $string2 = implode(";", $packageArray);
        echo "<br><br>".$string2;

        if(strlen($string2) == 0)
        	echo "No package subscribed!<br>";
        else
        	echo " are currently subscribed packages<br>";
    }
}
$user = $_SESSION['user'];
echo "<a href='../viewservices.php?name=$user&code=0'>BACK</a>";
