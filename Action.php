<?php //Strategy pattern 
	interface Action{
		public function execute($prop);
	}

	class balanceExceedsThresholdAction implements Action{
		
		public function execute($prop){
			$prop->getMember()->sendEmail();
		}
	}