<?php
require_once('tests/CustomPHPUnit.php');
require_once('lib/DepreciationSchedule/StraightLine.php');

class StraightLineTest extends CustomPHPUnit {
	private $schedule;

	public function __construct() {
		$this->schedule = new StraightLine(10, 1000, 4, 200);
	}

	public function test_getDepreciationExpense() {
		$this->assertEquals(53.33, round($this->schedule->getDepreciationExpense(0), 2));
		$this->assertEquals(80, round($this->schedule->getDepreciationExpense(4), 2));
		$this->assertEquals(80, round($this->schedule->getDepreciationExpense(8), 2));
		$this->assertEquals(26.67, round($this->schedule->getDepreciationExpense(10), 2));
	}

	public function test_getAccumulatedDepreciation() {
		$this->assertEquals(53.33, round($this->schedule->getAccumulatedDepreciation(0), 2));
		$this->assertEquals(373.33, round($this->schedule->getAccumulatedDepreciation(4), 2));
		$this->assertEquals(693.33, round($this->schedule->getAccumulatedDepreciation(8), 2));
		$this->assertEquals(800, round($this->schedule->getAccumulatedDepreciation(10), 2));
	}
}
?>
