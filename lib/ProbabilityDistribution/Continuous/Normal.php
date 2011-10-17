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
require_once('ContinuousDistribution.php');

class Normal extends ContinuousDistribution {
	private $mu;
	private $variance;
	
	function __construct($mu = 0.0, $variance = 1.0) {
		$this->mu = $mu;
		$this->variance = $variance;
	}
	
	//These are wrapper functions that call the static implementations with what we saved.
	
	/**
		Returns a random float between $mu and $mu plus $variance
		
		@return float The random variate.
	*/
	public function rvs() {
		return self::getRvs($this->mu, $this->variance);
	}
	
	/**
		Returns the probability distribution function
		
		@param float $x The test value
		@return float The probability
	*/
	public function pdf($x) {
		return self::getPdf($x, $this->mu, $this->variance);
	}
	
	/**
		Returns the cumulative distribution function, the probability of getting the test value or something below it
		
		@param float $x The test value
		@return float The probability
	*/
	public function cdf($x) {
		return self::getCdf($x, $this->mu, $this->variance);
	}
	
	/**
		Returns the survival function, the probability of getting the test value or something above it
		
		@param float $x The test value
		@return float The probability
	*/
	public function sf($x) {
		return self::getSf($x, $this->mu, $this->variance);
	}
	
	/**
		Returns the percent-point function, the inverse of the cdf
		
		@param float $x The test value
		@return float The value that gives a cdf of $x
	*/
	public function ppf($x) {
		return self::getPpf($x, $this->mu, $this->variance);
	}
	
	/**
		Returns the inverse survival function, the inverse of the sf
		
		@param float $x The test value
		@return float The value that gives an sf of $x
	*/
	public function isf($x) {
		return self::getIsf($x, $this->mu, $this->variance);
	}
	
	/**
		Returns the moments of the distribution
		
		@param string $moments Which moments to compute. m for mean, v for variance, s for skew, k for kurtosis.  Default 'mv'
		@return type array A dictionary containing the first four moments of the distribution
	*/
	public function stats($moments = 'mv') {
		return self::getStats($moments, $this->mu, $this->variance);
	}
	
	//These represent the calculation engine of the class.
	
	/**
		Returns a normally-distributed random float
		
		@param float $mu The location parameter. Default 0.0
		@param float $variance The scale parameter. Default 1.0
		@return float The random variate.
	*/
	static function getRvs($mu = 0.0, $variance = 1.0) {
		$u = self::randFloat();
		$v = self::randFloat();
		return sqrt(-2*log($u))*cos(2*M_PI*$v);
	}
	
	/**
		Returns the probability distribution function
		
		@param float $x The test value
		@param float $mu The location parameter. Default 0.0
		@param float $variance The scale parameter. Default 1.0
		@return float The probability
	*/
	static function getPdf($x, $mu = 0.0, $variance = 1.0) {
		return exp(-pow($x - $mu, 2)/(2*$variance))/sqrt(2*M_PI*$variance);
	}
	
	/**
		Returns the cumulative distribution function, the probability of getting the test value or something below it
		
		@param float $x The test value
		@param float $mu The location parameter. Default 0.0
		@param float $variance The scale parameter. Default 1.0
		@return float The probability
	*/
	static function getCdf($x, $mu = 0.0, $variance = 1.0) {
		return (1 + Stats::erf(($x - $mu)/sqrt(2*$variance)))/2;
	}
	
	/**
		Returns the survival function, the probability of getting the test value or something above it
		
		@param float $x The test value
		@param float $mu The location parameter. Default 0.0
		@param float $variance The scale parameter. Default 1.0
		@return float The probability
	*/
	static function getSf($x, $mu = 0.0, $variance = 1.0) {
		return 1.0 - self::getCdf($x, $mu, $variance);
	}
	
	/**
		Returns the percent-point function, the inverse of the cdf
		
		@param float $x The test value
		@param float $mu The location parameter. Default 0.0
		@param float $variance The scale parameter. Default 1.0
		@return float The value that gives a cdf of $x
	*/
	static function getPpf($x, $mu = 0.0, $variance = 1.0) {
		return 0; //TODO: Normal ppf
	}
	
	/**
		Returns the inverse survival function, the inverse of the sf
		
		@param float $x The test value
		@param float $mu The location parameter. Default 0.0
		@param float $variance The scale parameter. Default 1.0
		@return float The value that gives an sf of $x
	*/
	static function getIsf($x, $mu = 0.0, $variance = 1.0) {
		return self::getPpf(1.0 - $x, $mu, $variance);
	}
	
	/**
		Returns the moments of the distribution
		
		@param string $moments Which moments to compute. m for mean, v for variance, s for skew, k for kurtosis.  Default 'mv'
		@param float $mu The location parameter. Default 0.0
		@param float $variance The scale parameter. Default 1.0
		@return type array A dictionary containing the first four moments of the distribution
	*/
	static function getStats($moments = 'mv', $mu = 0.0, $variance = 1.0) {
		$return = array();
		
		if (strpos($moments, 'm') !== FALSE) $return['mean'] = $mu;
		if (strpos($moments, 'v') !== FALSE) $return['variance'] = $variance;
		if (strpos($moments, 's') !== FALSE) $return['skew'] = 0;
		if (strpos($moments, 'k') !== FALSE) $return['kurtosis'] = 0;
		
		return $return;
	}
}
?>
