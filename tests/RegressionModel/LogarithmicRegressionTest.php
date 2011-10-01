<?php
require_once('tests/CustomPHPUnit.php');
require_once('lib/RegressionModel/LogarithmicRegression.php');

class LogarithmicRegressionTest extends CustomPHPUnit {
	private $regressionModel;

	public function __construct() {
		$datax = array();
		$datay = array();

		//$this->regressionModel = new LogarithmicRegression($datax, $datay);
	}
	
	public function test_predict() {
		//$this->assertEquals(139.329214591, round($this->regressionModel->predict(50), 10));
	}
	
	public function test_getAlpha() {
		//$this->assertEquals(91.0043962074, round($this->regressionModel->getAlpha(), 10));
	}
	
	public function test_getBeta() {
		//$this->assertEquals(0.9664963677, round($this->regressionModel->getBeta(), 10));
	}
	
	public function test_getCorrelation() {
		//$this->assertEquals(0.9341638423, round($this->regressionModel->getCorrelation(), 10));
	}
}
?>
