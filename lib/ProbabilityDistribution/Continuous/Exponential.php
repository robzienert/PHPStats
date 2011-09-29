<?php
require_once('ContinuousDistribution.php');

class Exponential extends ContinuousDistribution {
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
		return self::rvs($this->lambda);
	}
	
	/**
		Returns the probability distribution function
		
		@param float $x The test value
		@return float The probability
	*/
	public function pdf($x) {
		return self::pdf($x, $this->lambda);
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
		Returns a random float between $minimum and $minimum plus $maximum
		
		@param float $lambda Scale parameter
		@return float The random variate.
	*/
	static function rvs($lambda = 1) {
		return -log(self::randFloat())/$lambda;
	}
	
	/**
		Returns the probability distribution function
		
		@param float $x The test value
		@param float $lambda Scale parameter
		@return float The probability
	*/
	static function pdf($x, $lambda = 1) {
		return $lambda*exp(-$lambda*$x);
	}
	
	/**
		Returns the cumulative distribution function, the probability of getting the test value or something below it
		
		@param float $x The test value
		@param float $lambda Scale parameter
		@return float The probability
	*/
	static function cdf($x, $lambda = 1) {
		return 1.0 - exp(-$lambda*$x);
	}
	
	/**
		Returns the survival function, the probability of getting the test value or something above it
		
		@param float $x The test value
		@param float $lambda Scale parameter
		@return float The probability
	*/
	static function sf($x, $lambda = 1) {
		return 1.0 - self::cdf($x, $k, $theta);
	}
	
	/**
		Returns the percent-point function, the inverse of the cdf
		
		@param float $x The test value
		@param float $lambda Scale parameter
		@return float The value that gives a cdf of $x
	*/
	static function ppf($x, $lambda = 1) {
		return 0; //TODO: Exponential PPF
	}
	
	/**
		Returns the inverse survival function, the inverse of the sf
		
		@param float $x The test value
		@param float $lambda Scale parameter
		@return float The value that gives an sf of $x
	*/
	static function isf($x, $lambda = 1) {
		return self::ppf(1.0 - $x, $lambda);
	}
	
	/**
		Returns the moments of the distribution
		
		@param string $moments Which moments to compute. m for mean, v for variance, s for skew, k for kurtosis.  Default 'mv'
		@param float $lambda Scale parameter
		@return type array A dictionary containing the first four moments of the distribution
	*/
	static function stats($moments = 'mv', $lambda = 1) {
		$moments = array();
		
		if (strpos($moments, 'm') !== FALSE) $moments['mean'] = 1.0/$lambda;
		if (strpos($moments, 'v') !== FALSE) $moments['variance'] = pow($lambda, -2);
		if (strpos($moments, 's') !== FALSE) $moments['skew'] = 2;
		if (strpos($moments, 'k') !== FALSE) $moments['kurtosis'] = 6;
		
		return $moments;
	}
}
?>