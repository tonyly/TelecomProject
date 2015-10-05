<?php
class Package{
	private $name;
	private $price = 0;
	private $servicesContained = array();
	private $duration;
	private $rule;
	public $ref = 1;

	public function setName($name){
		$this->name = $name;
	}

	public function setDuration($d){
		$this->duration = $d;
	}

	public function getName(){
		return $this->name;
	}

	public function getPrice(){
		return $this->price;
	}

	public function setPrice($price){
		$this->price = $price;
		return $this;
	}

	public function getDuration(){
		return $this->duration;
	}

	public function getServices(){
		return $this->servicesContained;
	}

	public function updateServices($s){
		foreach($this->servicesContained as $element){
			if(strcmp($s->getName(), $element->getName()) == 0){
				echo "Service ".$s->getName()." is already offered in package".$this->getName();
				return;
			}
		}
		array_push($this->servicesContained, $s);
		return $this;
	}
	

	public function setRule($rule){
		$this->rule = $rule;
	}

	public function getRule(){
		return $this->rule;
	}
}