<?php //factory pattern used for marketing rep to create services and packages
include 'Service.php';
include 'Package.php';
class spFactory{
	public static function createService($name, $type, $price, $duration){
		$s = new Service();
		$s->setName($name);
		$s->setType($type);
		$s->setPrice($price);
		$s->setDuration($duration);
		return $s;
	}

	public static function createPackage($name, $duration){
		$p = new Package();
		$p->setName($name);
		$p->setDuration($duration);
		return $p;
	}
}

?>