<?php
require_once('tests/CustomPHPUnit.php');
require_once('lib/RegressionModel/ExponentialRegression.php');

class ExponentialRegressionTest extends CustomPHPUnit {
	private $regressionModel;

	public function __construct() {
		$datax = array();
		$datay = array();

		//$this->regressionModel = new ExponentialRegression($datax, $datay);
	}
	
	public function test_predict() {
		
	}
	
	public function test_getAlpha() {
		
	}
	
	public function test_getBeta() {
		
	}
	
	public function test_getCorrelation() {
		
	}
}
?>
