<?php
include 'Package.php';
include 'Service.php';
session_start();
    $code = $_GET['code'];
    if($code == 0){
        $serviceToAdd = $_GET['serviceToAdd'];
    }
    mysql_connect('localhost','root','');
    //select database
    mysql_select_db('service');
    $sql="SELECT * FROM packageinfo" or die("Something wrong");
    $records=mysql_query($sql);         
?>

<html>
<head>
    <title>Packages</title>
</head>

<body>
    <table width="600" border="1" cellpadding="1" cellspacing="1">
    <tr>
        <th>Available Packages</th>
        <th>Reference Number</th>
        <th>Services</th>
        <th>Price</th>
        <th>Duration</th>
    </tr>
        <?php
            $serviceString='';
            while($account=mysql_fetch_assoc($records)){
                $pn = $account['packageName'];
                $ps = $account['packageObject'];
    
                $po = unserialize(base64_decode($ps));
                $service = $po->getServices();
                $serviceArray = array();
                foreach($service as $element){
                    array_push($serviceArray, $element->getName());
                }
                $serviceString = implode(";", $serviceArray);
                echo "<tr>";
                echo "<td>".$account['packageName']."</td>";
                echo "<td>".$account['packageNumber']."</td>";
                echo "<td>".$serviceString."</td>";
                echo "<td>$".$po->getPrice()."</month/td>";
                echo "<td>".$po->getDuration()."<months/td>";
                if($code == 0)
                    echo "<td><a href='../marketingRepAddToPackage.php?service=$serviceToAdd&ps=$ps&pn=$pn'>Add to this existing package</a></td>";
                if($code == 1){
                    echo "<td><a href='../marketingRepDeleteFromPackage.php?ps=$ps'>Delete service from this package</a></td>";
                }
                echo "</tr>";
            }

        ?>

    </table>
</body>
</html>

<?php
if($code != 0 && $code != -1)
    echo "<a href='../adminViewServices.php?code=1'>Modify Existing Package</a><br>";


?>