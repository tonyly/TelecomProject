<?php
class Assessor{
	public function evaluate($prop){
		if($prop->getType() == "RETAIL" && $prop->checkThres()){
			return true;
		}
		else{
			return false;
		}
	}
}