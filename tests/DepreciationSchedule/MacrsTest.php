<?php
require_once('tests/CustomPHPUnit.php');
require_once('lib/DepreciationSchedule/Macrs.php');

class MacrsTest extends CustomPHPUnit {
	private $schedule;

	public function __construct() {
		$this->schedule = new Macrs(10, 1000, 4, 200);
	}

	public function test_getDepreciationExpense() {
		$this->assertEquals(53.33, round($this->schedule->getDepreciationExpense(0), 2));
		$this->assertEquals(79.89, round($this->schedule->getDepreciationExpense(4), 2));
		$this->assertEquals(52.45, round($this->schedule->getDepreciationExpense(8), 2));
		$this->assertEquals(8.75, round($this->schedule->getDepreciationExpense(11), 2));
	}

	public function test_getAccumulatedDepreciation() {
		$this->assertEquals(53.33, round($this->schedule->getAccumulatedDepreciation(0), 2));
		$this->assertEquals(480.53, round($this->schedule->getAccumulatedDepreciation(4), 2));
		$this->assertEquals(703.87, round($this->schedule->getAccumulatedDepreciation(8), 2));
		$this->assertEquals(800, round($this->schedule->getAccumulatedDepreciation(11), 2));
	}
}
?>
