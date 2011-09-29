<?php
require_once('DepreciationSchedule.php');

class Macrs extends DepreciationSchedule {
	private $macrsTables = array(
		3 => array(.3333, .4445, .1481, .0741),
		5 => array(.2, .32, .192, .1152, .1152, .0576),
		7 => array(.1429, .2449, .1749, .1249, .0893, .0892, .0893, .0446),
		10 => array(.1, .18, .144, .1152, .0922, .0737, .0655, .0655, .0656, .0655, .0328),
		15 => array(.05, .095, .0855, .077, .0693, .0623, .059, .059, .0591, .059, .0591, .059, .0591, .059, .0591, .0295),
		20 => array(.0375, .07219, .06677, .06177, .05713, .05285, .04888, .04522, .04462, .04461, .04462, .04461, .04462, .04461, .04462, .04461, .04462, .04461, .04462, .04461, .02231)
	);

	private function calculateSchedule() {
		if (!in_array($this->yearsUsefulLife, array_keys($this->macrsTables)) echo ''; //Invalid year, throw exception
		
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