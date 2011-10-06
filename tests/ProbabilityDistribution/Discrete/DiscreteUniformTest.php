<?php
require_once('tests/CustomPHPUnit.php');
require_once('lib/ProbabilityDistribution/Discrete/DiscreteUniform.php');

class DiscreteUniformTest extends CustomPHPUnit {
	private $testObject;

	public function __construct() {
		$this->testObject = new DiscreteUniform(1, 10);
	}

	public function test_rvs() {
		//$this->assertEquals(, $this->testObject->rvs);
	}

	public function test_pmf() {
		$this->assertEquals(, $this->testObject->pmf);
	}

	public function test_cdf() {
		$this->assertEquals(, $this->testObject->cdf);
	}

	public function test_sf() {
		$this->assertEquals(, $this->testObject->sf);
	}

	public function test_ppf() {
		$this->assertEquals(, $this->testObject->ppf);
	}

	public function test_isf() {
		$this->assertEquals(, $this->testObject->isf);
	}

	public function test_stats() {
		$summaryStats = $this->testObject->stats('mvsk');

		$this->assertEquals(, $summaryStats['mean']);
		$this->assertEquals(, $summaryStats['variance']);
		$this->assertEquals(, $summaryStats['skew']);
		$this->assertEquals(, $summaryStats['kurtosis']);
	}
}
?>
