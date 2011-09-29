<?php
require_once('..'.DIRECTORY_SEPARATOR.'Stats.php');

abstract class ProbabilityDistribution {
	//Internal Utility Functions
	protected static function randFloat() {
		return ((float)mt_rand())/mt_getrandmax(); //A number between 0 and 1.
	}
	
	//These are wrapper functions that call the static implementations with what we saved.
	abstract public function rvs();
	abstract public function cdf();
	abstract public function sf();
	abstract public function ppf();
	abstract public function isf();
	abstract public function stats();
	
	//These represent the calculation engine of the class.
	abstract public static function rvs();
	abstract public static function cdf();
	abstract public static function sf();
	abstract public static function ppf();
	abstract public static function isf();
	abstract public static function stats();
}
?>