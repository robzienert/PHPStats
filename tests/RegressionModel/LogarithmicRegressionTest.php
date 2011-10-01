<?php
require_once('tests/CustomPHPUnit.php');
require_once('lib/RegressionModel/LogarithmicRegression.php');

class LogarithmicRegressionTest extends CustomPHPUnit {
	private $regressionModel;

	public function __construct() {
		$datax = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11);
		$datay = array(6, 9.5, 13, 15, 16.5, 17.5, 18.5, 19, 19.5, 19.7, 19.8);

		$this->regressionModel = new LogarithmicRegression($datax, $datay);
	}
	
	public function test_predict() {
		$this->assertEquals(24.39781322, round($this->regressionModel->predict(20), 8));
	}
	
	public function test_getAlpha() {
		$this->assertEquals(6.09934114, round($this->regressionModel->getAlpha(), 8));
	}
	
	public function test_getBeta() {
		$this->assertEquals(6.108180041, round($this->regressionModel->getBeta(), 9));
	}
	
	public function test_getCorrelation() {
		$this->assertEquals(0.9931293099, round($this->regressionModel->getCorrelation(), 10));
	}
}
?>
