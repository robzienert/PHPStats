<?php
require_once('RegressionModel.php');

class LinearRegression extends RegressionModel {
	public function __construct($datax, $datay) {
		$this->beta = Stats::covariance($datax, $datay)/Stats::variance($datax);
		$this->alpha = Stats::average($datay) - $this->beta*Stats::average($datax);

		$this->r = Stats::correlation($datax, $datay);
	}
	
	public function predict($x) {
		return $this->alpha + $this->beta*$x;
	}
}
?>
