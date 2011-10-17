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
require_once('Gamma.php');

class Beta extends ContinuousDistribution {
	private $alpha;
	private $beta;
	
	function __construct($alpha = 1, $beta = 1) {
		$this->alpha = $alpha;
		$this->beta = $beta;
	}
	
	//These are wrapper functions that call the static implementations with what we saved.
	
	/**
		Returns a random float between $alpha and $alpha plus $beta
		
		@return float The random variate.
	*/
	public function rvs() {
		return self::getRvs($this->alpha, $this->beta);
	}
	
	/**
		Returns the probability distribution function
		
		@param float $x The test value
		@return float The probability
	*/
	public function pdf($x) {
		return self::getPdf($x, $this->alpha, $this->beta);
	}
	
	/**
		Returns the cumulative distribution function, the probability of getting the test value or something below it
		
		@param float $x The test value
		@return float The probability
	*/
	public function cdf($x) {
		return self::getCdf($x, $this->alpha, $this->beta);
	}
	
	/**
		Returns the survival function, the probability of getting the test value or something above it
		
		@param float $x The test value
		@return float The probability
	*/
	public function sf($x) {
		return self::getSf($x, $this->alpha, $this->beta);
	}
	
	/**
		Returns the percent-point function, the inverse of the cdf
		
		@param float $x The test value
		@return float The value that gives a cdf of $x
	*/
	public function ppf($x) {
		return 0; //TODO: Beta ppf
	}
	
	/**
		Returns the inverse survival function, the inverse of the sf
		
		@param float $x The test value
		@return float The value that gives an sf of $x
	*/
	public function isf($x) {
		return self::getIsf($x, $this->alpha, $this->beta);
	}
	
	/**
		Returns the moments of the distribution
		
		@param string $moments Which moments to compute. m for mean, v for variance, s for skew, k for kurtosis.  Default 'mv'
		@return type array A dictionary containing the first four moments of the distribution
	*/
	public function stats($moments = 'mv') {
		return self::getStats($moments, $this->alpha, $this->beta);
	}
	
	//These represent the calculation engine of the class.
	
	/**
		Returns a random float between $alpha and $alpha plus $beta
		
		@param float $alpha The minimum parameter. Default 0.0
		@param float $beta The maximum parameter. Default 1.0
		@return float The random variate.
	*/
	static function getRvs($alpha = 1, $beta = 1) {
		$x = Gamma::getRvs($alpha, 1);
		$y = Gamma::getRvs($beta, 1);
		return $x/($x + $y);
	}
	
	/**
		Returns the probability distribution function
		
		@param float $x The test value
		@param float $alpha The minimum parameter. Default 0.0
		@param float $beta The maximum parameter. Default 1.0
		@return float The probability
	*/
	static function getPdf($x, $alpha = 1, $beta = 1) {
		if ($x >= 0 && $x <= 1) return pow($x, $alpha - 1)*pow(1 - $x, $beta - 1)/Stats::beta($alpha, $beta);
		else return 0.0;
	}
	
	/**
		Returns the cumulative distribution function, the probability of getting the test value or something below it
		
		@param float $x The test value
		@param float $alpha The minimum parameter. Default 0.0
		@param float $beta The maximum parameter. Default 1.0
		@return float The probability
	*/
	static function getCdf($x, $alpha = 1, $beta = 1) {
		return Stats::regularizedIncompleteBeta($alpha, $beta, $x);
	}
	
	/**
		Returns the survival function, the probability of getting the test value or something above it
		
		@param float $x The test value
		@param float $alpha The minimum parameter. Default 0.0
		@param float $beta The maximum parameter. Default 1.0
		@return float The probability
	*/
	static function getSf($x, $alpha = 1, $beta = 1) {
		return 1.0 - self::getCdf($x, $alpha, $beta);
	}
	
	/**
		Returns the percent-point function, the inverse of the cdf
		
		@param float $x The test value
		@param float $alpha The minimum parameter. Default 0.0
		@param float $beta The maximum parameter. Default 1.0
		@return float The value that gives a cdf of $x
	*/
	static function getPpf($x, $alpha = 1, $beta = 1) {
		return 0; //TODO: Beta ppf
	}
	
	/**
		Returns the inverse survival function, the inverse of the sf
		
		@param float $x The test value
		@param float $alpha The minimum parameter. Default 0.0
		@param float $beta The maximum parameter. Default 1.0
		@return float The value that gives an sf of $x
	*/
	static function getIsf($x, $alpha = 1, $beta = 1) {
		return self::getPpf(1.0 - $x, $alpha, $beta);
	}
	
	/**
		Returns the moments of the distribution
		
		@param string $moments Which moments to compute. m for mean, v for variance, s for skew, k for kurtosis.  Default 'mv'
		@param float $alpha The minimum parameter. Default 0.0
		@param float $beta The maximum parameter. Default 1.0
		@return type array A dictionary containing the first four moments of the distribution
	*/
	static function getStats($moments = 'mv', $alpha = 1, $beta = 1) {
		$return = array();
		
		if (strpos($moments, 'm') !== FALSE) $return['mean'] = $alpha/($beta + $alpha);
		if (strpos($moments, 'v') !== FALSE) $return['variance'] = ($alpha*$beta)/(pow($alpha + $beta, 2)*($alpha + $beta + 1));
		if (strpos($moments, 's') !== FALSE) $return['skew'] = (2*($beta - $alpha)*sqrt($alpha + $beta + 1))/(($alpha + $beta + 2)*sqrt($alpha * $beta));
		if (strpos($moments, 'k') !== FALSE) $return['kurtosis'] = (6*(pow($alpha - $beta, 2)*($alpha + $beta + 1) - $alpha*$beta*($alpha + $beta + 2)))/($alpha*$beta*($alpha + $beta + 2)*($alpha + $beta + 3));
		
		return $return;
	}
}
?>
