<?php
include 'Service.php';
include 'Package.php';
session_start();
    $code = $_GET['code'];
    mysql_connect('localhost','root','');
    //select database
    mysql_select_db('service');

    $sql="SELECT * FROM serviceinfo" or die("Something wrong");
    $records=mysql_query($sql);         
?>

<html>
<head>
  	<title>Services</title>
</head>

<body>
  	<table width="600" border="1" cellpadding="1" cellspacing="1">
  	<tr>
    	<th>Available Services</th>
    	<th>Reference Number</th>
    	<th>Service Type</th>
    	<th>Price</th>
        <th>Duration</th>
  	</tr>
        <?php
    		while($account=mysql_fetch_assoc($records)){
                $ss = $account['serviceObject'];
                $so = unserialize(base64_decode($ss));
    			$sn = $account['serviceName'];
    			echo "<tr>";
    			echo "<td>".$account['serviceName']."</td>";
    			echo "<td>".$account['serviceID']."</td>";
    			echo "<td>".$so->get_type()."</td>";
    			echo "<td>$".$so->getPrice()."</month/td>";
                echo "<td>".$so->getDuration()."<months/td>";
                if($code == 1){
                    echo "<td><a href='../marketingRepDelete.php?serviceToDelete=$sn'>Delete the service</a></td>";
                    echo "<td><a href='adminViewPackages.php?code=0&serviceToAdd=$ss'>Add to existing package</a></td>";
                    echo "<td><a href='../adminViewPackages.php?code=1'>View existing package</a></td>";
                }
    			echo "</tr>";
    		}

    	?>
    </table>
    <?php
        if($code == 1){
            echo "<a href='../marketingRepAdd.html'>Add Services</a>";
        }
    ?>   
</body>
</html>

