<?php
//Rule object pattern
class RuleObject{
	private $assessor;
	private $action;
	private $result;

	public function _construct($assessor, $action){
		$this->assessor = $assessor;
		$this->action = $action;
		$this->result = new Result();
	}

	public function setAssessor($a){
		$this->assessor = $a;
	}

	public function setAction($a){
		$this->action = $a;
	}

	public function checkRule($prop){
		if($assessor->evaluate($prop)){
			$action->execute($prop);

		}
	}

}