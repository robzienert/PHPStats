<?php
require_once('tests/CustomPHPUnit.php');
require_once('lib/DepreciationSchedule/SumOfYearsDigits.php');

class SumOfYearsDigitsTest extends CustomPHPUnit {
	private $schedule;

	public function __construct() {
		$this->schedule = new SumOfYearsDigits(10, 1000, 4, 200);
	}

	public function test_getDepreciationExpense() {
		$this->assertEquals(96.97, round($this->schedule->getDepreciationExpense(0), 2));
		$this->assertEquals(92.12, round($this->schedule->getDepreciationExpense(4), 2));
		$this->assertEquals(33.94, round($this->schedule->getDepreciationExpense(8), 2));
		$this->assertEquals(4.85, round($this->schedule->getDepreciationExpense(10), 2));
	}

	public function test_getAccumulatedDepreciation() {
		$this->assertEquals(96.97, round($this->schedule->getAccumulatedDepreciation(0), 2));
		$this->assertEquals(552.73, round($this->schedule->getAccumulatedDepreciation(4), 2));
		$this->assertEquals(775.76, round($this->schedule->getAccumulatedDepreciation(8), 2));
		$this->assertEquals(800, round($this->schedule->getAccumulatedDepreciation(10), 2));
	}
}
?>
