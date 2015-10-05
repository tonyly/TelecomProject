<?php 
include 'Account.php';
include 'Service.php';
include 'Package.php';
include 'RuleObject.php';
include 'Assessor.php';
include 'Action.php';
include 'Properties.php';
include 'Mediator.php';

session_start();
$type = $_GET['type']; //type = 0 for service
                       //type = 1 for package
$o = $_GET['o'];
$customerS = $_GET['customer'];
$action = $_GET['action'];  //action = 0 to add
                            //action = 1 to delete

$customer = unserialize(base64_decode($customerS));
//echo $customer->getName();
$s_p = unserialize(base64_decode($o));

$facade = new Facade();
$facade->customer = $customer;
$facade->setType($type);
$facade->s_p = $s_p;

if($action == 0){
	$facade->add($facade->customer, $facade->s_p);
}
else{
	$facade->cancel($facade->customer, $facade->s_p);
}

//if($customer->checkBalance()){
//	echo "here";
//	$customer->sendEmail();
//}

$rule = $facade->s_p->getRule();
$assessor = new Assessor();
$action = new balanceExceedsThresholdAction();
$prop = new Properties();
$prop->setAccount($facade->customer);
if($assessor->evaluate($prop)){
	$action->execute($prop);
}

$name = $customer->getName();
$s = $customer->getS();

$updated = base64_encode(serialize($customer));
mysql_connect('localhost','root','');

//select database
mysql_select_db('customer');

$sql="SELECT * FROM account" or die("Something wrong");

$records=mysql_query($sql);
while($rs = mysql_fetch_assoc($records)){
	$name = $rs['username'];
	if($rs['username'] == $customer->getName()){
	//	echo "<br>here";
		mysql_query("UPDATE `account` SET serializedObject = '$updated' WHERE 
					username = '$name'") or die(mysql_error());
	}
}
//FACADE PATTERN
class Facade{
	public $customer;
	public $s_p;
	private $type;  //$type = 0 if subscribe/unsubscribe a service
	                //$type = 1 if subscribe/unsubscribe a package


	public function _construct(){
		$this->customer = $s;
		$this->s_p = $sp;
		$this->type = $type;
	}

	public function setType($type){
		$this->type = $type;
	}

	public function add($customer, $s_p){
		if(Mediator::s_p($s_p) == 0){
			$tmp = $customer->getS();
			foreach($tmp as $element){
				if($element->getName() == $s_p->getName()){
					echo "Service ".$element->getName()." is already subscribed.";
					echo "<br>You cannot subscribe the same service twice<br>";
					return;
				}
			}
			$customer->updateS($s_p, 0);
			echo "Service ".$s_p->getName()." is now subscribed. <br>You will be charged ";
			echo $s_p->getPrice()." $ for ".$s_p->getDuration()." months.<br>Thank you for using";
			echo " Telecom service! <br>";
			
		}
		else{
			$tmp = $customer->getP();
			foreach($tmp as $element){
				if($element->getName() == $s_p->getName()){
					echo "Package ".$element->getName()." is already subscribed.";
					echo "<br>You cannot subscribe the same package twice<br>";
					return;
				}
			}
			$customer->updateP($s_p, 0);
			echo "Package ".$s_p->getName()." is not subscribed. <br>You will be charged ";
			echo $s_p->getPrice()." $ for ".$s_p->getDuration()." months.<br>Thank you for using";
			echo " Telecom service! <br>";

		}
	}

	public function cancel($customer, $s_p){
		if(Mediator::s_p($s_p) == 0){
			$serial = base64_encode(serialize($s_p));
			if($customer->updateS($s_p, 1) == 0){
				echo "Service ".$s_p->getName()." is now unsubribed.<br>";
        		echo "You will be charged $150 for cancelling the service.<br>";
        	}
        }
        else{
        	$customer->updateP($s_p, 1);
			echo "Package ".$s_p->getName()." is now unsubribed.<br>";
        	echo "You will be charged $150 for cancelling the package.<br>";
        	
        	
        }
	}


}