<?php
require_once('DepreciationSchedule.php');

class Macrs extends DepreciationSchedule {
	private $macrsTables = array(
		3 => array(0.3333, 0.4445, 0.1481, 0.0741),
		5 => array(0.2, 0.32, 0.192, 0.1152, 0.1152, 0.0576),
		7 => array(0.1429, 0.2449, 0.1749, 0.1249, 0.0893, 0.0892, 0.0893, 0.0446),
		10 => array(0.1, 0.18, 0.144, 0.1152, 0.0922, 0.0737, 0.0655, 0.0655, 0.0656, 0.0655, 0.0328),
		15 => array(0.05, 0.095, 0.0855, 0.077, 0.0693, 0.0623, 0.059, 0.059, 0.0591, 0.059, 0.0591, 0.059, 0.0591, 0.059, 0.0591, 0.0295),
		20 => array(0.0375, 0.07219, 0.06677, 0.06177, 0.05713, 0.05285, 0.04888, 0.04522, 0.04462, 0.04461, 0.04462, 0.04461, 0.04462, 0.04461, 0.04462, 0.04461, 0.04462, 0.04461, 0.04462, 0.04461, 0.02231)
	);

	protected function calculateSchedule() {
		if (!in_array($this->yearsUsefulLife, array_keys($this->macrsTables)) throw new Exception('Invalid MACRS period: '.$this->yearsUsefulLife.' Valid values:'.implode(', ', array_keys($this->macrsTables))); //Invalid year, throw exception
		
		$accumulatedDepreciation = 0;
		$depreciableValue = $this->startingValue - $this->salvageValue;
		$depreciationTable = $macrsTables[$this->yearsUsefulLife];
		
		for ($i = 0; $i <= $this->yearsUsefulLife; $i++) { //Go $yearsUsefulLife + 1 times, because of MACRS's half-year convention
			$monthlyDepreciation = ($depreciableValue * $depreciationTable[$i])/12;
			
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
