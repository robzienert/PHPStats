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
namespace PHPStats\RegressionModel;

/**
 * LinearRegression class
 * 
 * Performs a linear regression.  That is, for an equation of the form
 * y = a + b*x it will find the variables a and b, as well as the correlation
 * between x and y.
 */
class LinearRegression extends RegressionModel {
	/**
	 * __construct Function
	 * 
	 * Constructor function for this regression model.  Takes two arrays
	 * of data that are parallel arrays of independent and dependent
	 * observations.
	 * 
	 * @param array $datax The series of independent variables
	 * @param array $datay The series of dependent variables
	 * @return LinearRegression An object representing the regression model
	 */
	public function __construct(array $datax, array $datay) {
		$this->beta = \PHPStats\Stats::covariance($datax, $datay)/\PHPStats\Stats::variance($datax);
		$this->alpha = \PHPStats\Stats::average($datay) - $this->beta*\PHPStats\Stats::average($datax);

		$this->r = \PHPStats\Stats::correlation($datax, $datay);
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
		return $this->alpha + $this->beta*$x;
	}
}
?>
