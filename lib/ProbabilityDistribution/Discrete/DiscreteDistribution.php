<?php
require_once('..'.DIRECTORY_SEPARATOR.'ProbabilityDistribution.php');

abstract class DiscreteDistribution extends ProbabilityDistribution {
	//Internal Utility Functions
	protected static function BernoulliTrial($p = 0.5) {
		$standardVariate = ((float)mt_rand())/mt_getrandmax();
		return ($standardVariate <= $p)?1:0;
	}

	//Additional Wrapper Functions
	abstract public function pmf();

	//Additional Calculation Functions
	abstract static function pmf();
}
?>