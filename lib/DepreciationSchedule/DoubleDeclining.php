<?php
/**
 * PHP Statistics Library
 *
 * Copyright (C) 2011-2012 Michael Cordingley <mcordingley@gmail.com>
 * 
 * This library is free software; you can redistribute it and/or modify
 * it under the terms of the GNU Library General Public License as published
 * by the Free Software Foundation; either version 3 of the License, or 
 * (at your option) any later version.
 * 
 * This library is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Library General Public
 * License for more details.
 * 
 * You should have received a copy of the GNU Library General Public License
 * along with this library; if not, write to the Free Software Foundation, 
 * Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA
 * 
 * LGPL Version 3
 *
 * @package PHPStats
 */

namespace PHPStats;

/**
 * DoubleDeclining class
 * 
 * Implements the double-declining balance method of depreciation.
 */
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
