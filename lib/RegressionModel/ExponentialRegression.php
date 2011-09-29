<?php
require_once('RegressionModel.php');

class ExponentialRegression extends RegressionModel {
	public function __construct($datax, $datay) {
		$logy = array();
		foreach ($datay as $y) $logy[] = log($y);

		$logbeta = Stats::covariance($datax, $logy)/Stats::variance($datax);
		$logalpha = Stats::average($logy) - $this->beta*Stats::average($datax);

		$this->beta = exp($logbeta)
		$this->alpha = exp($logalpha);
	}
	
	public function predict($x) {
		return $this->alpha * pow($this->beta, $x);
	}
}
?>