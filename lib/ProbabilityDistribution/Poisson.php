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

/**
 * Poisson class
 * 
 * Represents the Poisson distribution, a distribution that represents the
 * number of independent, exponentially-distributed events that occur in a
 * fixed interval.  
 * For more information, see: http://en.wikipedia.org/wiki/Poisson_distribution
 */
class Poisson extends ProbabilityDistribution {
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
		return self::getRvs($this->lambda);
	}
	
	/**
		Returns the probability distribution function
		
		@param float $x The test value
		@return float The probability
	*/
	public function pmf($x) {
		return self::getPmf($x, $this->lambda);
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
		Returns a random variate between $minimum and $minimum plus $maximum
		
		@param float $lambda The rate of events.
		@return float The random variate.
	*/
	static function getRvs($lambda = 1) {
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
	static function getPmf($x, $lambda = 1) {
		return exp(-$lambda)*pow($lambda, $x)/\PHPStats\Stats::factorial($x);
	}
	
	/**
		Returns the cumulative distribution function, the probability of getting the test value or something below it
		
		@param float $x The test value
		@param float $lambda The rate of events
		@return float The probability
	*/
	static function getCdf($x, $lambda = 1) {
		$sum = 0.0;
		for ($count = 0; $count <= $x; $count++) {
			$sum += self::getPmf($count, $lambda);
		}
		return $sum;
	}
	
	/**
		Returns the survival function, the probability of getting the test value or something above it
		
		@param float $x The test value
		@param float $lambda The rate of events
		@return float The probability
	*/
	static function getSf($x, $lambda = 1) {
		return 1.0 - self::getCdf($x, $lambda);
	}
	
	/**
		Returns the percent-point function, the inverse of the cdf
		
		@param float $x The test value
		@param float $lambda The rate of events
		@return float The value that gives a cdf of $x
	*/
	static function getPpf($x, $lambda = 1) {
		return 0; //TODO: Poisson PPF
	}
	
	/**
		Returns the inverse survival function, the inverse of the sf
		
		@param float $x The test value
		@param float $lambda The rate of events
		@return float The value that gives an sf of $x
	*/
	static function getIsf($x, $lambda = 1) {
		return self::getPpf(1.0 - $x, $lambda);
	}
	
	/**
		Returns the moments of the distribution
		
		@param string $moments Which moments to compute. m for mean, v for variance, s for skew, k for kurtosis.  Default 'mv'
		@param float $lambda The rate of events
		@return type array A dictionary containing the first four moments of the distribution
	*/
	static function getStats($moments = 'mv', $lambda = 1) {
		$return = array();
		
		if (strpos($moments, 'm') !== FALSE) $return['mean'] = $lambda;
		if (strpos($moments, 'v') !== FALSE) $return['variance'] = $lambda;
		if (strpos($moments, 's') !== FALSE) $return['skew'] = pow($lambda, -0.5);
		if (strpos($moments, 'k') !== FALSE) $return['kurtosis'] = 1.0/$lambda;
		
		return $return;
	}
}
?>
