<?php
require_once('tests/CustomPHPUnit.php');
require_once('lib/ProbabilityDistribution/Discrete/Hypergeometric.php');

class HypergeometricTest extends CustomPHPUnit {
	private $testObject;

	public function __construct() {
		$this->testObject = new Hypergeometric(10, 5, 5);
	}

	public function test_rvs() {
		//$this->assertEquals(, $this->testObject->rvs());
	}

	public function test_pmf() {
		$this->assertEquals(0.39683, round($this->testObject->pmf(2), 5));
	}

	public function test_cdf() {
		$this->assertEquals(0.5, $this->testObject->cdf(2));
	}

	public function test_sf() {
		$this->assertEquals(0.5, $this->testObject->sf(2));
	}

	public function test_ppf() {
		$this->assertEquals(2, $this->testObject->ppf(0.5));
	}

	public function test_isf() {
		$this->assertEquals(2, $this->testObject->isf(0.5));
	}

	public function test_stats() {
		$summaryStats = $this->testObject->stats('mvsk');

		$this->assertEquals(2.5, $summaryStats['mean']);
		$this->assertEquals(0.69444, round($summaryStats['variance'], 5));
		$this->assertEquals(0, round($summaryStats['skew'], 5));
		$this->assertEquals(-0.68571, $summaryStats['kurtosis']);
	}
}
?>
