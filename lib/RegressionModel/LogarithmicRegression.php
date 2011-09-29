<?php
require_once('RegressionModel.php');

class LogarithmicRegression extends RegressionModel {
	public function __construct($datax, $datay) {
		$logx = array();
		foreach ($datax as $x) $logx[] = log($x);

		$this->beta = Stats::covariance($logx, $datay)/Stats::variance($logx);
		$this->alpha = Stats::average($datay) - $this->beta*Stats::average($logx);
	}
	
	public function predict($x) {
		return $this->alpha + $this->beta*log($x);
	}
}
?>