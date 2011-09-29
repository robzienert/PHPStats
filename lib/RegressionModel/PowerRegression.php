<?php
require_once('RegressionModel.php');

class PowerRegression extends RegressionModel {
	public function __construct($datax, $datay) {
		$logx = array();
		foreach ($datax as $x) $logx[] = log($x);
		$logy = array();
		foreach ($datay as $y) $logy[] = log($y);

		$this->beta = Stats::covariance($logx, $logy)/Stats::variance($logx);

		$logalpha = Stats::average($logy) - $this->beta*Stats::average($logx);
		$this->alpha = exp($logalpha);
	}
	
	public function predict($x) {
		return $this->alpha * pow($x, $this->beta);
	}
}
?>