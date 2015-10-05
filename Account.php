<?php 
interface Observer{ //observer pattern
	public function update($subject);
}

abstract class Account{
	private $name;
    private $subscribedS = array();
    private $subscribedP = array();
    private $balance = 0;
    private $threshold = 0;

    public function setName($name){
    	$this->name = $name;
    }

    public function setEmail($email){
    	$this->email = $email;
    }

    public function getName(){
    	return $this->name;
    }
    public function getEmail(){
       	return $this->email;
    }

    public function getBalance(){
    	return $this->balance;
    }

    public function getThreshold(){
    	return $this->threshold;
    }

    public function getS(){
    	return $this->subscribedS;
    }

    public function updateS($s, $action){
    	if($action == 0){
    		array_push($this->subscribedS, $s);
    		$this->updateBalance($s->getPrice());
    	}
    	else{
    		$i = 0;
    		//$unserialize = unserialize(base64_decode($s));
    		foreach ($this->subscribedS as $key) {
    			//$keyO = unserialize(base64_decode($key));
    			if($key->getName() == $s->getName()){
    				unset($this->subscribedS[$i]);
    				$this->updateBalance(-$key->getPrice());
    				$this->updateBalance(150);
    				return 0;
    			}
    			$i++;
    			# code...
    		}
    		echo "Service ".$s->getName()." is not currently
    		     subshcribed. <br>You cannot unsubcribe such a service<br>";
    		return -1;
    	}

    }

    public function getP(){
    	return $this->subscribedP;
    }

    public function updateP($p, $action){
    	if($action == 0){
    		array_push($this->subscribedP, $p);
    		$this->updateBalance($p->getPrice());
    	}
    	else{
    		$i = 0;
    		foreach($this->subscribedP as $key){
    			if($key->getName() == $p->getName()){
    				unset($this->subscribedP[$i]);
    				$this->updateBalance(-$key->getPrice());
    				$this->updateBalance(150);
    				return 0;
    			}
    			$i++;
    		}
    		echo "Package ".$p->getName()." is not currently
    		     subshcribed. <br>You cannot unsubcribe such a package<br>";
    		return -1;
    	}

    }

    public function setThreshold($threshold){
    	if ($this->threshold < 0){
    		echo "Invalid threshold amount. Please input a positive number!<br>";
    		return;
    	}
    	$this->threshold = $threshold;
    	return $this;
    }

	public function viewBalance(){
		return $this->balance;
	}

	public function updateBalance($change){
		$this->balance += $change;
	}

	public function checkBalance(){
		return $this->balance > $this->threshold;
	}

	public function sendEmail(){
		echo "yeeeeeeeeeeeeeee";
		echo $this->email;
		$email_subject = "Telecom Account Balance Exceeded";

		$body = "Dear Customer ". $this->name.": Your account thredhold has
		        been exceeded. Please review your account balance. Thank you for
		        using Telecom service!<br><br>Sincerely,<br>Telecom Company";
		mail($this->email,$email_subject, $body,'From: admin@telecom.com');
	}
}

class RetailCustomer extends Account implements Observer{
	private $accountType = "RETAIL";


	public function get_type(){
		return $this->accountType;
	}

	public function update($subject){
		$i = 0;
		foreach($this->subscribedS as $element){
			if($element->getName() == $subject->getName()){
				unset($this->subscribedS[$i]);
				array_push($this->subscribedS, $subject);
				break;
			}
			$i++;
		}

	}


}


class CommercialCustomer extends Account implements Observer{
	private $accountType = "COMMERCIAL";

	public function update($subject){
		$i = 0;
		foreach($this->subscribedS as $element){
			if($element->getName() == $subject->getName()){
				unset($this->subscribedS[$i]);
				array_push($this->subscribedS, $subject);
				break;
			}
			$i++;
		}

	}

	public function get_type(){
		return $this->accountType;
	}
}


?>