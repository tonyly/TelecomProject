<?php
class Properties{
	public $account;

	public function setAccount($a){
		$this->account = $a;
	}

	public function getMember(){
		return $this->account;
	}
	public function getType(){
		return $this->account->get_type();
	}

	public function checkThres(){
		return $this->account->getBalance() > 
		       $this->account->getThreshold();
	}

}