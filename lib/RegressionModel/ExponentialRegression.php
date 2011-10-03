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
 * @package PHPStat
 */

require_once('RegressionModel.php');

/**
 * ExponentialRegression class
 * 
 * Performs an exponential regression.  That is, for an equation of the form
 * y = a*b^x it will find the variables a and b, as well as the correlation
 * between x and y.  Invalid for y less than or equal to 0.
 */

class ExponentialRegression extends RegressionModel {
	/**
	 * __construct Function
	 * 
	 * Constructor function for this regression model.  Takes two arrays
	 * of data that are parallel arrays of independent and dependent
	 * observations.
	 * 
	 * @param array $datax The series of independent variables
	 * @param array $datay The series of dependent variables
	 * @return ExponentialRegression An object representing the regression model
	 */
	public function __construct(array $datax, array $datay) {
		$logy = array();
		foreach ($datay as $y) $logy[] = log($y);

		$this->r = Stats::correlation($datax, $logy);

		$logbeta = Stats::covariance($datax, $logy)/Stats::variance($datax);
		$logalpha = Stats::average($logy) - $logbeta*Stats::average($datax);

		$this->beta = exp($logbeta);
		$this->alpha = exp($logalpha);
	}
	
	/**
	 * predict Function
	 * 
	 * Predicts a value of y given a value of x.
	 * 
	 * @param $x float The independent variable
	 * @return $y float The predicted dependent variable
	 */
	public function predict($x) {
		return $this->alpha * pow($this->beta, $x);
	}
}
?>
