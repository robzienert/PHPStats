<?php
require_once('tests/CustomPHPUnit.php');
require_once('lib/DepreciationSchedule/DoubleDeclining.php');

class DoubleDecliningTest extends CustomPHPUnit {
	private $schedule;

	public function __construct() {
		$this->schedule = new DoubleDeclining(10, 1000, 4, 200);
	}

	public function test_getDepreciationExpense() {
		$this->assertEquals(133.33, round($this->schedule->getDepreciationExpense(0), 2));
		$this->assertEquals(88.75, round($this->schedule->getDepreciationExpense(4), 2));
		$this->assertEquals(0, round($this->schedule->getDepreciationExpense(8), 2));
		$this->assertEquals(0, round($this->schedule->getDepreciationExpense(10), 2));
	}

	public function test_getAccumulatedDepreciation() {
		$this->assertEquals(133.33, round($this->schedule->getAccumulatedDepreciation(0), 2));
		$this->assertEquals(645.01, round($this->schedule->getAccumulatedDepreciation(4), 2));
		$this->assertEquals(800, round($this->schedule->getAccumulatedDepreciation(8), 2));
		$this->assertEquals(800, round($this->schedule->getAccumulatedDepreciation(10), 2));
	}
}
?>
