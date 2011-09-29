<?php
require_once('DepreciationSchedule.php');

class SumOfYearsDigits extends DepreciationSchedule {
	private function calculateSchedule() {
		$accumulatedDepreciation = 0;
		$depreciableValue = $this->startingValue - $this->salvageValue;
		
		$sumOfYearsDigits = 0;
		for ($i = 0; $i <= $this->yearsUsefulLife; $i++) $sumOfYearsDigits += $i;
		
		for ($i = 0; $i < $this->yearsUsefulLife; $i++) {
			$monthlyDepreciation = $depreciableValue*($this->yearsUsefulLife - $i) / ($sumOfYearsDigits * 12);
		
			for ($j = 0; $j < 12; $j++) {
				$accumulatedDepreciation += $monthlyDepreciation;
				
				if ($this->startMonth + $j < 12) {
					$this->schedule['DepreciationExpense'][$i][$this->startMonth + $j] = $monthlyDepreciation;
					$this->schedule['AccumulatedDepreciation'][$i][$this->startMonth + $j] = $accumulatedDepreciation;
				}
				else {
					$this->schedule['DepreciationExpense'][$i + 1][$this->startMonth + $j - 12] = $monthlyDepreciation;
					$this->schedule['AccumulatedDepreciation'][$i + 1][$this->startMonth + $j - 12] = $accumulatedDepreciation;
				}
			}
		}
	}
}
?>