<?php
require_once('tests/CustomPHPUnit.php');
require_once('lib/Stats.php');

class StatsTest extends CustomPHPUnit {
	private $datax;
	private $datay;
	private $dataz;

	function __construct() {
		$this->datax = array(1, 2, 3, 4, 5);
		$this->datay = array(10, 11, 12, 13, 14);
		$this->dataz = array(28.8, 27.1, 42.4, 53.5, 90);
	}

	public function test_sum() {
		$this->assertEquals(15, Stats::sum($this->datax));
		$this->assertEquals(60, Stats::sum($this->datay));
		$this->assertEquals(241.8, Stats::sum($this->dataz));
	}

	public function test_product() {
		$this->assertEquals(120, Stats::product($this->datax));
		$this->assertEquals(240240, Stats::product($this->datay));
		$this->assertEquals(159339674.88, Stats::product($this->dataz));
	}

	public function test_average() {
		$this->assertEquals(3, Stats::average($this->datax));
		$this->assertEquals(12, Stats::average($this->datay));
		$this->assertEquals(48.36, Stats::average($this->dataz));
	}

	public function test_gaverage() {
		$this->assertEquals(2.60517, round(Stats::gaverage($this->datax), 5));
		$this->assertEquals(11.91596, round(Stats::gaverage($this->datay), 5));
		$this->assertEquals(43.69832, round(Stats::gaverage($this->dataz), 5));
	}

	public function test_sumsquared() {
		$this->assertEquals(55, Stats::sumsquared($this->datax));
		$this->assertEquals(730, Stats::sumsquared($this->datay));
		$this->assertEquals(14323.86, Stats::sumsquared($this->dataz));
	}

	public function test_sumXY() {
		$this->assertEquals(190, Stats::sumXY($this->datax, $this->datay));
		$this->assertEquals(3050.4, Stats::sumXY($this->dataz, $this->datay));
	}

	public function test_sse() {
		//$this->assertEquals(190, Stats::sse($this->datax));
		//$this->assertEquals(190, Stats::sse($this->datay));
		//$this->assertEquals(190, Stats::sse($this->dataz));
	}

	public function test_mse() {
		//$this->assertEquals(190, Stats::mse($this->datax));
		//$this->assertEquals(190, Stats::mse($this->datay));
		//$this->assertEquals(190, Stats::mse($this->dataz));
	}

	public function test_covariance() {
		$this->assertEquals(2, Stats::covariance($this->datax, $this->datay));
		$this->assertEquals(29.76, round(Stats::covariance($this->dataz, $this->datay), 2));
	}

	public function test_variance() {
		$this->assertEquals(2, Stats::variance($this->datax));
		$this->assertEquals(2, Stats::variance($this->datay));
		$this->assertEquals(526.0824, round(Stats::variance($this->dataz), 4));
	}

	public function test_stddev() {
		$this->assertEquals(1.41421, round(Stats::stddev($this->datax), 5));
		$this->assertEquals(1.41421, round(Stats::stddev($this->datay), 5));
		$this->assertEquals(22.93649, round(Stats::stddev($this->dataz), 5));
	}

	public function test_sampleStddev() {
		$this->assertEquals(1.58114, round(Stats::sampleStddev($this->datax), 5));
		$this->assertEquals(1.58114, round(Stats::sampleStddev($this->datay), 5));
		$this->assertEquals(25.64377, round(Stats::sampleStddev($this->dataz), 5));
	}

	public function test_correlation() {
		$this->assertEquals(1.0, round(Stats::correlation($this->datax, $this->datay), 5));
		$this->assertEquals(0.91747, round(Stats::correlation($this->dataz, $this->datay), 5));
	}

	public function test_factorial() {
		$this->assertEquals(1, Stats::factorial(0));
		$this->assertEquals(1, Stats::factorial(1));
		$this->assertEquals(2, Stats::factorial(2));
		$this->assertEquals(120, Stats::factorial(5));
		$this->assertEquals(3628800, Stats::factorial(10));
	}

	public function test_erf() {
		$this->assertEquals(0, round(Stats::erf(0), 7));
		$this->assertEquals(0.5205, round(Stats::erf(0.5), 7));
		$this->assertEquals(0.8427007, round(Stats::erf(1), 7));
		$this->assertEquals(0.9661053, round(Stats::erf(1.5), 7));
		$this->assertEquals(0.9953221, round(Stats::erf(2), 7));
		$this->assertEquals(0.9999993, round(Stats::erf(3.5), 7));
	}

	public function test_gamma() {
		$this->assertEquals(1, round(Stats::gamma(1), 3));
		$this->assertEquals(1, round(Stats::gamma(2), 3));
		$this->assertEquals(1.3293326, round(Stats::gamma(2.5), 7));
		$this->assertEquals(2, round(Stats::gamma(3), 5));
		$this->assertEquals(6, round(Stats::gamma(4), 5));
		$this->assertEquals(24, round(Stats::gamma(5), 5));
		$this->assertEquals(120, round(Stats::gamma(6), 4));
	}

	public function test_lowerGamma() {

	}
	
	public function test_upperGamma() {

	}

	public function test_beta() {
		$this->assertEquals(1, round(Stats::beta(1, 1), 2));
		$this->assertEquals(0.5, round(Stats::beta(1, 2), 2));
		$this->assertEquals(0.5, round(Stats::beta(2, 1), 2));
		$this->assertEquals(0.0015873, round(Stats::beta(5, 5), 7));
		$this->assertEquals(0.0002525, round(Stats::beta(5, 8), 7));
	}

	public function test_regularizedIncompleteBeta() {

	}

	public function test_permutations() {
		$this->assertEquals(1, Stats::permutations(1, 1));
		$this->assertEquals(2, Stats::permutations(2, 1));
		$this->assertEquals(12, Stats::permutations(4, 2));
		$this->assertEquals(120, Stats::permutations(5, 5));
		$this->assertEquals(6720, Stats::permutations(8, 5));
	}

	public function test_combinations() {
		$this->assertEquals(1, Stats::combinations(1, 1));
		$this->assertEquals(2, Stats::combinations(2, 1));
		$this->assertEquals(6, Stats::combinations(4, 2));
		$this->assertEquals(1, Stats::combinations(5, 5));
		$this->assertEquals(56, Stats::combinations(8, 5));
	}
}
?>
