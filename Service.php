<?php

interface Subject{
	public function notify();
	public function attach($observer);
	public function detach($observer);
}


class Service implements Subject{
	private $name;
	private $type;
	private $price;
	private $duration;
	private $rule;
	private $observers = array();
	public $ref = 0;

	public function _construct($name, $type, $price, $duration){
        echo "hererererere";

		$this->name = $name;
		$this->type = $type;
		$this->price = $price;
		$this->duration = '$duration';
		echo "Service".$this->name."<br>";
	}

	public function setName($name){
		$this->name = $name;
	}

	public function setType($type){
		$this->type = $type;
	}
	

	public function getName(){
		return $this->name;
	}

	public function getPrice(){
		return $this->price;
	}

	public function get_type(){
		return $this->type;
	}

	public function getDuration(){
		return $this->duration;
	}

	public function setDuration($d){
		$this->duration = $d;
	}

	public function setPrice($p){
		$this->price = $p;
	}

	public function setRule($rule){
		$this->rule = $rule;
	}

	public function getRule(){
		return $this->rule;
	}

	public function attach($observer){
		array_push($this->observers, $observer);
	}

	public function detach($observer){
		$i = 0;
		foreach($this->observers as $element){
			if($element->getName() == $observer->getName()){
				unset($this->observers[$i]);
				break;
			}
			$i++;
		}
	}

	public function notify(){
		foreach($this->observers as $element){
			$element->sendEmail();
		}
	}
}