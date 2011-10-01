<?php
require_once('tests/CustomPHPUnit.php');
require_once('lib/RegressionModel/PowerRegression.php');

class PowerRegressionTest extends CustomPHPUnit {
	private $regressionModel;

	public function __construct() {
		$datax = array();
		$datay = array();

		//$this->regressionModel = new PowerRegression($datax, $datay);
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
