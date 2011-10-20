<?php
require_once('lib/Stats.php');
require_once('lib/RegressionModel/RegressionModel.php');
require_once('lib/RegressionModel/PowerRegression.php');

use \PHPStats\RegressionModel\PowerRegression as PowerRegression;

class PowerRegressionTest extends PHPUnit_Framework_TestCase {
	private $regressionModel;

	public function __construct() {
		$datax = array(17.6, 26, 31.9, 38.9, 45.8, 51.2, 58.1, 64.7, 66.7, 80.8, 82.9);
		$datay = array(159.9, 206.9, 236.8, 269.9, 300.6, 323.6, 351.7, 377.6, 384.1, 437.2, 444.7);

		$this->regressionModel = new PowerRegression($datax, $datay);
	}
	
	public function test_predict() {
		$this->assertEquals(305.7034150458, round($this->regressionModel->predict(47), 10));
	}
	
	public function test_getAlpha() {
		$this->assertEquals(24.12989312, round($this->regressionModel->getAlpha(), 8));
	}
	
	public function test_getBeta() {
		$this->assertEquals(0.65949782, round($this->regressionModel->getBeta(), 8));
	}
	
	public function test_getCorrelation() {
		$this->assertEquals(0.9999962538, round($this->regressionModel->getCorrelation(), 10));
	}
}
?>
