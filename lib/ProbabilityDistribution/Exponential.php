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
namespace PHPStats\ProbabilityDistribution;

class Exponential extends ProbabilityDistribution {
	private $lambda;
	
	function __construct($lambda = 1.0) {
		$this->lambda = $lambda;
	}

	//These are wrapper functions that call the static implementations with what we saved.
	
	/**
		Returns a random float
		
		@return float The random variate.
	*/
	public function rvs() {
		return self::getRvs($this->lambda);
	}
	
	/**
		Returns the probability distribution function
		
		@param float $x The test value
		@return float The probability
	*/
	public function pdf($x) {
		return self::getPdf($x, $this->lambda);
	}
	
	/**
		Returns the cumulative distribution function, the probability of getting the test value or something below it
		
		@param float $x The test value
		@return float The probability
	*/
	public function cdf($x) {
		return self::getCdf($x, $this->lambda);
	}
	
	/**
		Returns the survival function, the probability of getting the test value or something above it
		
		@param float $x The test value
		@return float The probability
	*/
	public function sf($x) {
		return self::getSf($x, $this->lambda);
	}
	
	/**
		Returns the percent-point function, the inverse of the cdf
		
		@param float $x The test value
		@return float The value that gives a cdf of $x
	*/
	public function ppf($x) {
		return self::getPpf($x, $this->lambda);
	}
	
	/**
		Returns the inverse survival function, the inverse of the sf
		
		@param float $x The test value
		@return float The value that gives an sf of $x
	*/
	public function isf($x) {
		return self::getIsf($x, $this->lambda);
	}
	
	/**
		Returns the moments of the distribution
		
		@param string $moments Which moments to compute. m for mean, v for variance, s for skew, k for kurtosis.  Default 'mv'
		@return type array A dictionary containing the first four moments of the distribution
	*/
	public function stats($moments = 'mv') {
		return self::getStats($moments, $this->lambda);
	}
	
	//These represent the calculation engine of the class.
	
	/**
		Returns a random float between $minimum and $minimum plus $maximum
		
		@param float $lambda Scale parameter
		@return float The random variate.
	*/
	static function getRvs($lambda = 1) {
		return -log(self::randFloat())/$lambda;
	}
	
	/**
		Returns the probability distribution function
		
		@param float $x The test value
		@param float $lambda Scale parameter
		@return float The probability
	*/
	static function getPdf($x, $lambda = 1) {
		return $lambda*exp(-$lambda*$x);
	}
	
	/**
		Returns the cumulative distribution function, the probability of getting the test value or something below it
		
		@param float $x The test value
		@param float $lambda Scale parameter
		@return float The probability
	*/
	static function getCdf($x, $lambda = 1) {
		return 1.0 - exp(-$lambda*$x);
	}
	
	/**
		Returns the survival function, the probability of getting the test value or something above it
		
		@param float $x The test value
		@param float $lambda Scale parameter
		@return float The probability
	*/
	static function getSf($x, $lambda = 1) {
		return 1.0 - self::getCdf($x, $k, $theta);
	}
	
	/**
		Returns the percent-point function, the inverse of the cdf
		
		@param float $x The test value
		@param float $lambda Scale parameter
		@return float The value that gives a cdf of $x
	*/
	static function getPpf($x, $lambda = 1) {
		return 0; //TODO: Exponential PPF
	}
	
	/**
		Returns the inverse survival function, the inverse of the sf
		
		@param float $x The test value
		@param float $lambda Scale parameter
		@return float The value that gives an sf of $x
	*/
	static function getIsf($x, $lambda = 1) {
		return self::getPpf(1.0 - $x, $lambda);
	}
	
	/**
		Returns the moments of the distribution
		
		@param string $moments Which moments to compute. m for mean, v for variance, s for skew, k for kurtosis.  Default 'mv'
		@param float $lambda Scale parameter
		@return type array A dictionary containing the first four moments of the distribution
	*/
	static function getStats($moments = 'mv', $lambda = 1) {
		$return = array();
		
		if (strpos($moments, 'm') !== FALSE) $return['mean'] = 1.0/$lambda;
		if (strpos($moments, 'v') !== FALSE) $return['variance'] = pow($lambda, -2);
		if (strpos($moments, 's') !== FALSE) $return['skew'] = 2;
		if (strpos($moments, 'k') !== FALSE) $return['kurtosis'] = 6;
		
		return $return;
	}
}
?>
