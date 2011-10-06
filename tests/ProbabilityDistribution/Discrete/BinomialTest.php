<?php
require_once('tests/CustomPHPUnit.php');
require_once('lib/ProbabilityDistribution/Discrete/Binomial.php');

class BinomialTest extends CustomPHPUnit {
	private $testObject;

	public function __construct() {
		$this->testObject = new Binomial(0.5, 5);
	}

	public function test_rvs() {
		//$this->assertEquals(, $this->testObject->rvs);
	}

	public function test_pmf() {
		$this->assertEquals(0.3125, $this->testObject->pmf(2));
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
		$this->assertEquals(1.25, $summaryStats['variance']);
		$this->assertEquals(0, $summaryStats['skew']);
		$this->assertEquals(-0.4, $summaryStats['kurtosis']);
	}
}
?>
