<?php

abstract class DepreciationSchedule {
	protected $startingValue;
	protected $salvageValue;
	protected $yearsUsefulLife;
	protected $startMonth;
	protected $schedule = array(
		'DepreciationExpense' => array(), //$this->schedule['DepreciationExpense'][0][10] is November of the first year
		'AccumulatedDepreciation' => array(), //$this->schedule['AccumulatedDepreciation'][2][4] is May of the third year
	);

	public function __construct($yearsUsefulLife, $startingValue, $startMonth = 0, $salvageValue = 0) {
		$this->yearsUsefulLife = $yearsUsefulLife;
		$this->startingValue = $startingValue;
		$this->startMonth = $startMonth;
		$this->salvageValue = $salvageValue;
		
		$this->calculateSchedule();
	}
	
	abstract private function calculateSchedule();
	
	public function getDepreciationExpense($year, $month = FALSE) {
		if (is_numeric($month)) return $this->schedule['DepreciationExpense'][floor($year)][floor($month)];
		else {
			$expense = 0.0;
			foreach ($this->schedule['DepreciationExpense'][$year] as $v) {
				$expense += $v;
			}
			return $expense;
		}
	}
	
	public function getAccumulatedDepreciation($year, $month = FALSE) {
		if (is_numeric($month)) return $this->schedule['AccumulatedDepreciation'][floor($year)][floor($month)];
		else return $this->schedule['AccumulatedDepreciation'][$year][11];
	}
}
?>