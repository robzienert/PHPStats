<?php
require_once('ContinuousDistribution.php');

class Pareto extends ContinuousDistribution {
	private $minimum;
	private $alpha;
	
	function __construct($minimum = 1.0, $alpha = 1.0) {
		$this->minimum = $minimum;
		$this->alpha = $alpha;
	}
	
	//These are wrapper functions that call the static implementations with what we saved.
	
	/**
		Returns a random float between $minimum and $minimum plus $alpha
		
		@return float The random variate.
	*/
	public function rvs() {
		return self::getRvs($this->minimum, $this->alpha);
	}
	
	/**
		Returns the probability distribution function
		
		@param float $x The test value
		@return float The probability
	*/
	public function pdf($x) {
		return self::getPdf($x, $this->minimum, $this->alpha);
	}
	
	/**
		Returns the cumulative distribution function, the probability of getting the test value or something below it
		
		@param float $x The test value
		@return float The probability
	*/
	public function cdf($x) {
		return self::getCdf($x, $this->minimum, $this->alpha);
	}
	
	/**
		Returns the survival function, the probability of getting the test value or something above it
		
		@param float $x The test value
		@return float The probability
	*/
	public function sf($x) {
		return self::getSf($x, $this->minimum, $this->alpha);
	}
	
	/**
		Returns the percent-point function, the inverse of the cdf
		
		@param float $x The test value
		@return float The value that gives a cdf of $x
	*/
	public function ppf($x) {
		return self::getPpf($x, $this->minimum, $this->alpha);
	}
	
	/**
		Returns the inverse survival function, the inverse of the sf
		
		@param float $x The test value
		@return float The value that gives an sf of $x
	*/
	public function isf($x) {
		return self::getIsf($x, $this->minimum, $this->alpha);
	}
	
	/**
		Returns the moments of the distribution
		
		@param string $moments Which moments to compute. m for mean, v for variance, s for skew, k for kurtosis.  Default 'mv'
		@return type array A dictionary containing the first four moments of the distribution
	*/
	public function stats($moments = 'mv') {
		return self::getStats($moments, $this->minimum, $this->alpha);
	}
	
	//These represent the calculation engine of the class.
	
	/**
		Returns a random float between $minimum and $minimum plus $alpha
		
		@param float $minimum The scale parameter. Default 0.0
		@param float $alpha The shape parameter. Default 1.0
		@return float The random variate.
	*/
	static function getRvs($minimum = 1.0, $alpha = 1.0) {
		return $minimum/pow(self::randFloat(), 1/$alpha)
	}
	
	/**
		Returns the probability distribution function
		
		@param float $x The test value
		@param float $minimum The scale parameter. Default 0.0
		@param float $alpha The shape parameter. Default 1.0
		@return float The probability
	*/
	static function getPdf($x, $minimum = 1.0, $alpha = 1.0) {
		if ($x >= $minimum) return pow($minimum/$x, $alpha);
		else return 0.0;
	}
	
	/**
		Returns the cumulative distribution function, the probability of getting the test value or something below it
		
		@param float $x The test value
		@param float $minimum The scale parameter. Default 0.0
		@param float $alpha The shape parameter. Default 1.0
		@return float The probability
	*/
	static function getCdf($x, $minimum = 1.0, $alpha = 1.0) {
		if ($x >= $minimum) return 1 - pow($minimum/$x, $alpha);
		else return 0.0;
	}
	
	/**
		Returns the survival function, the probability of getting the test value or something above it
		
		@param float $x The test value
		@param float $minimum The scale parameter. Default 0.0
		@param float $alpha The shape parameter. Default 1.0
		@return float The probability
	*/
	static function getSf($x, $minimum = 1.0, $alpha = 1.0) {
		return 1.0 - self::getCdf($x, $minimum, $alpha);
	}
	
	/**
		Returns the percent-point function, the inverse of the cdf
		
		@param float $x The test value
		@param float $minimum The scale parameter. Default 0.0
		@param float $alpha The shape parameter. Default 1.0
		@return float The value that gives a cdf of $x
	*/
	static function getPpf($x, $minimum = 1.0, $alpha = 1.0) {
		return 0; //TODO: Pareto ppf
	}
	
	/**
		Returns the inverse survival function, the inverse of the sf
		
		@param float $x The test value
		@param float $minimum The scale parameter. Default 0.0
		@param float $alpha The shape parameter. Default 1.0
		@return float The value that gives an sf of $x
	*/
	static function getIsf($x, $minimum = 1.0, $alpha = 1.0) {
		return self::getPpf(1.0 - $x, $minimum, $alpha);
	}
	
	/**
		Returns the moments of the distribution
		
		@param string $moments Which moments to compute. m for mean, v for variance, s for skew, k for kurtosis.  Default 'mv'
		@param float $minimum The scale parameter. Default 0.0
		@param float $alpha The shape parameter. Default 1.0
		@return type array A dictionary containing the first four moments of the distribution
	*/
	static function getStats($moments = 'mv', $minimum = 1.0, $alpha = 1.0) {
		$moments = array();
		
		if (strpos($moments, 'm') !== FALSE) {
			if ($alpha > 1) $moments['mean'] = ($alpha*$minimum)/($alpha - 1);
			else $moments['mean'] = NAN;
		}
		if (strpos($moments, 'v') !== FALSE) {
			if ($alpha > 2) $moments['variance'] = (pow($minimum, 2)*$alpha)/(pow($alpha - 1, 2)*($alpha - 2))
			else $moments['variance'] = NAN;
		}
		if (strpos($moments, 's') !== FALSE) {
			if ($alpha > 3) $moments['skew'] = ((2 + 2*$alpha)/($alpha - 3))*sqrt(($alpha - 2)/$alpha);
			else $moments['skew'] = NAN;
		}
		if (strpos($moments, 'k') !== FALSE) {
			if ($alpha > 4) $moments['kurtosis'] = (6*(pow($alpha, 3) + pow($alpha, 2) - 6*$alpha - 2))/($alpha*($alpha - 3)*($alpha - 4));
			else $moments['kurtosis'] = NAN;
		}
		
		return $moments;
	}
}
?>
