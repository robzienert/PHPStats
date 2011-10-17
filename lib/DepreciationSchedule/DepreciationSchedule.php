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
 * DepreciationSchedule class
 * 
 * Parent class to the depreciation schedule classes.  Enforces a common interface
 * across the classes.  Also provides what should be the only public functions
 * exposed by an instance of any depreciation schedule class.
 */
abstract class DepreciationSchedule {
	protected $startingValue;
	protected $salvageValue;
	protected $yearsUsefulLife;
	protected $startMonth;
	protected $schedule = array(
		'DepreciationExpense' => array(), //$this->schedule['DepreciationExpense'][0][10] is November of the first year
		'AccumulatedDepreciation' => array(), //$this->schedule['AccumulatedDepreciation'][2][4] is May of the third year
	);

	/**
	 * __construct Function
	 * 
	 * Common constructor function for the depreciation schedule models.
	 * 
	 * @param int $yearsUsefulLife How many years the depreciable assets will last
	 * @param float $startingValue The book value of the asset at acquisition
	 * @param int $startMonth Zero-based index of the month in which the asset was acquired.  0-11
	 * @param float $salvageValue The book value of the asset at the end of its useful life
	 * @return DepreciationSchedule An object representing the depreciation schedule
	 */
	public function __construct($yearsUsefulLife, $startingValue, $startMonth = 0, $salvageValue = 0) {
		$this->yearsUsefulLife = $yearsUsefulLife;
		$this->startingValue = $startingValue;
		$this->startMonth = $startMonth;
		$this->salvageValue = $salvageValue;
		
		$this->calculateSchedule();
	}
	
	abstract protected function calculateSchedule();

	/**
	 * getDepreciationExpense Function
	 * 
	 * Getter function that returns the depreciation expense for the 
	 * specified period.
	 * 
	 * @param int $year Which year in the depreciation schedule to fetch
	 * @param int $month Which month in the schedule to fetch.  If not provided, fetch the sum of the whole year
	 * @return float The depreciation expense for the selected period
	 */
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

	/**
	 * getAccumulatedDepreciation Function
	 * 
	 * Getter function that returns the accumulated depreciation as of
	 * the specified period.
	 * 
	 * @param int $year Which year in the depreciation schedule to fetch
	 * @param int $month Which month in the schedule to fetch.  If not provided, fetch amount at year end.
	 * @return float The accumulated depreciation as of the selected period
	 */
	public function getAccumulatedDepreciation($year, $month = FALSE) {
		if (is_numeric($month)) return $this->schedule['AccumulatedDepreciation'][floor($year)][floor($month)];
		else return end($this->schedule['AccumulatedDepreciation'][$year]);
	}
}
?>
