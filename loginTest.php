<?php
require_once 'spFactory.php';
//require_once 'cancelService.php';
class loginTest extends PHPUnit_Framework_TestCase
{

	public function testcreateService(){
		
		//connect to database
		$database = "customer";
 	    $user = "root";
        $password = "";
        $inputuser = "jessie";
        $connect = mysql_connect("localhost",$user,$password);
        @mysql_select_db($database) or ("Database not found");
        $query = "SELECT * FROM `account` WHERE `username` = '$inputuser'";
        $result = mysql_query($query);
        $row = mysql_fetch_array($result);

        //subscribe method
        $serviceToAdd = "stuff";
        $serviceoption = "Wireless";
        $servicePrice = 100;
        $serviceDuration = 100;
        $newService = spFactory::createService($serviceToAdd, $serviceoption,
        	                         $servicePrice, $serviceDuration);
        $newString = base64_encode(serialize($newService));
        $connect = mysql_connect("localhost",$user,$password);
        $database = "service";
        @mysql_select_db($database) or ("Database not found");
        mysql_query("INSERT INTO `serviceinfo` VALUES ('$serviceToAdd', ' ', 
                        $newString)");
        //refresh to database
        $database = "service";
        $connect = mysql_connect("localhost",$user,$password);
        @mysql_select_db($database) or ("Database not found");
        $query = "SELECT * FROM `serviceinfo` WHERE 'serviceName' = 'serviceTest'";
        $result = mysql_query($query);
        $row = mysql_fetch_array($result);

        $this->assertEquals("serviceTest",$row["serviceName"]);
		
	}

	public function testfailConnectToDataBase(){
		$inputuser = "fawefjesk";
		$user = "root";
        $password = "";
		$connect = mysql_connect("localhost",$user,$password);
        @mysql_select_db($database) or ("Database not found");
        $query = "SELECT * FROM `account` WHERE `username` = '$inputuser'";
        $result = mysql_query($query);
        $this->assertFalse($result);
        //$row = mysql_fetch_array($result);
		
	}
	
	public function testunsubscribedService(){
		
		//connect to database
		$database = "customer";
 	    $user = "root";
        $password = "";
        $inputuser = "jessie";
        $connect = mysql_connect("localhost",$user,$password);
        @mysql_select_db($database) or ("Database not found");
        $query = "SELECT * FROM `account` WHERE `username` = '$inputuser'";
        $result = mysql_query($query);
        $row = mysql_fetch_array($result);

        //subscribe method
        unsubscribedService("Internet", $inputuser, "57");
        unsubscribedService("TestService", $inputuser, "57");
        //refresh to database
        $connect = mysql_connect("localhost",$user,$password);
        @mysql_select_db($database) or ("Database not found");
        $query = "SELECT * FROM `account` WHERE `username` = '$inputuser'";
        $result = mysql_query($query);
        $row = mysql_fetch_array($result);

        $this->assertEquals("",$row["subscribedS"]);
		
	}

	public function testsubscribePackage(){
		
		//connect to database
		$database = "customer";
 	    $user = "root";
        $password = "";
        $inputuser = "jessie";
        $connect = mysql_connect("localhost",$user,$password);
        @mysql_select_db($database) or ("Database not found");
        $query = "SELECT * FROM `account` WHERE `username` = '$inputuser'";
        $result = mysql_query($query);
        $row = mysql_fetch_array($result);

        //subscribe method
        subscribePackage("Package1", $inputuser, "57");

        //refresh to database
        $connect = mysql_connect("localhost",$user,$password);
        @mysql_select_db($database) or ("Database not found");
        $query = "SELECT * FROM `account` WHERE `username` = '$inputuser'";
        $result = mysql_query($query);
        $row = mysql_fetch_array($result);

        $this->assertEquals("Package1",$row["subscribedP"]);
		
	}
	
	
	public function testunsubscribedPackage(){
		
		//connect to database
		$database = "customer";
 	    $user = "root";
        $password = "";
        $inputuser = "jessie";
        $connect = mysql_connect("localhost",$user,$password);
        @mysql_select_db($database) or ("Database not found");
        $query = "SELECT * FROM `account` WHERE `username` = '$inputuser'";
        $result = mysql_query($query);
        $row = mysql_fetch_array($result);

        //subscribe method
        unsubscribedPackage("Package1", $inputuser, "57");

        //refresh to database
        $connect = mysql_connect("localhost",$user,$password);
        @mysql_select_db($database) or ("Database not found");
        $query = "SELECT * FROM `account` WHERE `username` = '$inputuser'";
        $result = mysql_query($query);
        $row = mysql_fetch_array($result);

        $this->assertEquals("",$row["subscribedP"]);
		
	}
	

	public function testcheckBalance(){
		//connect to database
		$database = "customer";
 	    $user = "root";
        $password = "";
        $inputuser = "jessie";
        $connect = mysql_connect("localhost",$user,$password);
        @mysql_select_db($database) or ("Database not found");
        $query = "SELECT * FROM `account` WHERE `username` = '$inputuser'";
        $result = mysql_query($query);
        $row = mysql_fetch_array($result);

        //subscribe method
        //checkBalance("TestService", $inputuser, "57");

        //refresh to database
        $connect = mysql_connect("localhost",$user,$password);
        @mysql_select_db($database) or ("Database not found");
        $query = "SELECT * FROM `account` WHERE `username` = '$inputuser'";
        $result = mysql_query($query);
        $row = mysql_fetch_array($result);

        $this->assertEquals("1",$row["balance"]);
	}
}

?>
