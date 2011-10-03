<?php
require_once('DepreciationSchedule.php');

class DoubleDeclining extends DepreciationSchedule {
	protected function calculateSchedule() {
		$accumulatedDepreciation = 0;
		
		for ($i = 0; $i < $this->yearsUsefulLife; $i++) {
		
			$annualDepreciation = (2/$this->yearsUsefulLife)*($this->startingValue - $accumulatedDepreciation);
			$monthlyDepreciation = $annualDepreciation / 12;
		
			for ($j = 0; $j < 12; $j++) {
				if ($accumulatedDepreciation + $monthlyDepreciation > $this->startingValue - $this->salvageValue) $monthlyDepreciation = $this->startingValue - $this->salvageValue - $accumulatedDepreciation; //Cap our depreciation to ensure the salvage value
				
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
