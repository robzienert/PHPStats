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
 
require_once('DiscreteDistribution.php');

/**
 * Poisson class
 * 
 * Represents the Poisson distribution, a distribution that represents the
 * number of independent, exponentially-distributed events that occur in a
 * fixed interval.  
 * For more information, see: http://en.wikipedia.org/wiki/Poisson_distribution
 */
class Poisson extends DiscreteDistribution {
	private $lambda;

	function __construct($lambda) {
		$this->lambda = $lambda;
	}

	//These are wrapper functions that call the static implementations with what we saved.
	
	/**
		Returns a random float between $minimum and $minimum plus $maximum
		
		@return float The random variate.
	*/
	public function rvs() {
		return self::rvs($this->lambda);
	}
	
	/**
		Returns the probability distribution function
		
		@param float $x The test value
		@return float The probability
	*/
	public function pmf($x) {
		return self::pmf($x, $this->lambda);
	}
	
	/**
		Returns the cumulative distribution function, the probability of getting the test value or something below it
		
		@param float $x The test value
		@return float The probability
	*/
	public function cdf($x) {
		return self::cdf($x, $this->lambda);
	}
	
	/**
		Returns the survival function, the probability of getting the test value or something above it
		
		@param float $x The test value
		@return float The probability
	*/
	public function sf($x) {
		return self::sf($x, $this->lambda);
	}
	
	/**
		Returns the percent-point function, the inverse of the cdf
		
		@param float $x The test value
		@return float The value that gives a cdf of $x
	*/
	public function ppf($x) {
		return self::ppf($x, $this->lambda);
	}
	
	/**
		Returns the inverse survival function, the inverse of the sf
		
		@param float $x The test value
		@return float The value that gives an sf of $x
	*/
	public function isf($x) {
		return self::isf($x, $this->lambda);
	}
	
	/**
		Returns the moments of the distribution
		
		@param string $moments Which moments to compute. m for mean, v for variance, s for skew, k for kurtosis.  Default 'mv'
		@return type array A dictionary containing the first four moments of the distribution
	*/
	public function stats($moments = 'mv') {
		return self::stats($moments, $this->lambda);
	}

	//These represent the calculation engine of the class.
	
	/**
		Returns a random variate between $minimum and $minimum plus $maximum
		
		@param float $lambda The rate of events.
		@return float The random variate.
	*/
	static function rvs($lambda = 1) {
		//Knuth's algorithm.  TODO: Replace with more efficient algorithm
		$l = exp(-$lamda);
		$k = 0;
		$p = 1;

		do {
			$k++;
			$u = self::randFloat();
			$p *= $u;
		} while ($p > $l);

		return $k - 1;
	}
	
	/**
		Returns the probability mass function
		
		@param float $x The test value
		@param float $lambda The rate of events
		@return float The probability
	*/
	static function pmf($x, $lambda = 1) {
		return exp(-$lamda)*pow($lamda, $x)/self::factorial($x);
	}
	
	/**
		Returns the cumulative distribution function, the probability of getting the test value or something below it
		
		@param float $x The test value
		@param float $lambda The rate of events
		@return float The probability
	*/
	static function cdf($x, $lambda = 1) {
		$sum = 0.0;
		for ($count = 0; $count <= $x; $count++) {
			$sum += self::pmf($lambda, $count);
		}
		return $sum;
	}
	
	/**
		Returns the survival function, the probability of getting the test value or something above it
		
		@param float $x The test value
		@param float $lambda The rate of events
		@return float The probability
	*/
	static function sf($x, $lambda = 1) {
		return 1.0 - self::cdf($x, $lambda);
	}
	
	/**
		Returns the percent-point function, the inverse of the cdf
		
		@param float $x The test value
		@param float $lambda The rate of events
		@return float The value that gives a cdf of $x
	*/
	static function ppf($x, $lambda = 1) {
		return 0; //TODO: Poisson PPF
	}
	
	/**
		Returns the inverse survival function, the inverse of the sf
		
		@param float $x The test value
		@param float $lambda The rate of events
		@return float The value that gives an sf of $x
	*/
	static function isf($x, $lambda = 1) {
		return self::ppf(1.0 - $x, $lambda);
	}
	
	/**
		Returns the moments of the distribution
		
		@param string $moments Which moments to compute. m for mean, v for variance, s for skew, k for kurtosis.  Default 'mv'
		@param float $lambda The rate of events
		@return type array A dictionary containing the first four moments of the distribution
	*/
	static function stats($moments = 'mv', $lambda = 1) {
		$moments = array();
		
		if (strpos($moments, 'm') !== FALSE) $moments['mean'] = $lambda;
		if (strpos($moments, 'v') !== FALSE) $moments['variance'] = $lambda;
		if (strpos($moments, 's') !== FALSE) $moments['skew'] = pow($lambda, -0.5);
		if (strpos($moments, 'k') !== FALSE) $moments['kurtosis'] = 1.0/$lambda;
		
		return $moments;
	}
}
?>