<?php
require_once('tests/CustomPHPUnit.php');
require_once('lib/ProbabilityDistribution/Discrete/Poisson.php');

class PoissonTest extends CustomPHPUnit {
	private $testObject;

	public function __construct() {
		$this->testObject = new Poisson(5);
	}

	public function test_rvs() {
		//$this->assertEquals(, $this->testObject->rvs());
	}

	public function test_pmf() {
		$this->assertEquals(0.17547, round($this->testObject->pmf(5), 5));
	}

	public function test_cdf() {
		$this->assertEquals(0.61596, round($this->testObject->cdf(5), 5));
	}

	public function test_sf() {
		$this->assertEquals(0.38404, round($this->testObject->sf(5), 5));
	}

	public function test_ppf() {
		$this->assertEquals(5, $this->testObject->ppf(0.5));
	}

	public function test_isf() {
		$this->assertEquals(5, $this->testObject->isf(0.5));
	}

	public function test_stats() {
		$summaryStats = $this->testObject->stats('mvsk');

		$this->assertEquals(5, $summaryStats['mean']);
		$this->assertEquals(5, $summaryStats['variance']);
		$this->assertEquals(0.44721, round($summaryStats['skew'], 5));
		$this->assertEquals(0.2, $summaryStats['kurtosis']);
	}
}
?>
