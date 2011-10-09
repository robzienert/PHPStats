<?php
require_once('ContinuousDistribution.php');

class StudentsT extends ContinuousDistribution {
	private $df;
	
	function __construct($df = 1) {
		$this->df = $df;
	}
	
	//These are wrapper functions that call the static implementations with what we saved.
	
	/**
		Returns a random float between $minimum and $minimum plus $maximum
		
		@return float The random variate.
	*/
	public function rvs() {
		return self::getRvs($this->df);
	}
	
	/**
		Returns the probability distribution function
		
		@param float $x The test value
		@return float The probability
	*/
	public function pdf($x) {
		return self::getPdf($x, $this->df);
	}
	
	/**
		Returns the cumulative distribution function, the probability of getting the test value or something below it
		
		@param float $x The test value
		@return float The probability
	*/
	public function cdf($x) {
		return self::getCdf($x, $this->df);
	}
	
	/**
		Returns the survival function, the probability of getting the test value or something above it
		
		@param float $x The test value
		@return float The probability
	*/
	public function sf($x) {
		return self::getSf($x, $this->df);
	}
	
	/**
		Returns the percent-point function, the inverse of the cdf
		
		@param float $x The test value
		@return float The value that gives a cdf of $x
	*/
	public function ppf($x) {
		return self::getPpf($x, $this->df);
	}
	
	/**
		Returns the inverse survival function, the inverse of the sf
		
		@param float $x The test value
		@return float The value that gives an sf of $x
	*/
	public function isf($x) {
		return self::getIsf($x, $this->df);
	}
	
	/**
		Returns the moments of the distribution
		
		@param string $moments Which moments to compute. m for mean, v for variance, s for skew, k for kurtosis.  Default 'mv'
		@return type array A dictionary containing the first four moments of the distribution
	*/
	public function stats($moments = 'mv') {
		return self::getStats($moments, $this->df);
	}
	
	//These represent the calculation engine of the class.
	
	/**
		Returns a random float between $minimum and $minimum plus $maximum
		
		@param float $df The degrees of freedeom.  Default 1
		@return float The random variate.
	*/
	static function getRvs($df = 1) {
		return 0; //TODO: Student's T rvs
	}
	
	/**
		Returns the probability distribution function
		
		@param float $x The test value
		@param float $df The degrees of freedeom.  Default 1
		@return float The probability
	*/
	static function getPdf($x, $df = 1) {
		return pow(1 + pow($x, 2)/$df, -($df + 1)/2)/(sqrt($df)*Stats::beta(.5, $df/2))
	}
	
	/**
		Returns the cumulative distribution function, the probability of getting the test value or something below it
		
		@param float $x The test value
		@param float $df The degrees of freedeom.  Default 1
		@return float The probability
	*/
	static function getCdf($x, $df = 1) {
		$return = 1 - .5*Stats::regularizedIncompleteBeta($df/2, .5, $df/(pow($x, 2) + $df)); //Valid only for $x > 0
		
		if ($x < 0) return 1 - $return; //...but we can infer < 0 by way of symmetry.
		elseif ($x == 0) return .5; //Can't mirror it for zero, but the mean is here so the CDF is 0.5 at this point.
		else return $return;
	}
	
	/**
		Returns the survival function, the probability of getting the test value or something above it
		
		@param float $x The test value
		@param float $df The degrees of freedeom.  Default 1
		@return float The probability
	*/
	static function getSf($x, $df = 1) {
		return 1.0 - self::getCdf($x, $minimum, $maximum);
	}
	
	/**
		Returns the percent-point function, the inverse of the cdf
		
		@param float $x The test value
		@param float $df The degrees of freedeom.  Default 1
		@return float The value that gives a cdf of $x
	*/
	static function getPpf($x, $df = 1) {
		return 0; //TODO: Student's T ppf
	}
	
	/**
		Returns the inverse survival function, the inverse of the sf
		
		@param float $x The test value
		@param float $df The degrees of freedeom.  Default 1
		@return float The value that gives an sf of $x
	*/
	static function getIsf($x, $df = 1) {
		return self::getPpf(1.0 - $x, $minimum, $maximum);
	}
	
	/**
		Returns the moments of the distribution
		
		@param string $moments Which moments to compute. m for mean, v for variance, s for skew, k for kurtosis.  Default 'mv'
		@param float $df The degrees of freedeom.  Default 1
		@return type array A dictionary containing the first four moments of the distribution
	*/
	static function getStats($moments = 'mv', $df = 1) {
		$moments = array();
		
		if (strpos($moments, 'm') !== FALSE) {
			if ($df > 1) $moments['mean'] = 0;
			else $moments['mean'] = NAN;
		}
		if (strpos($moments, 'v') !== FALSE) {
			if ($df > 2) $moments['variance'] = $df / ($df - 2);
			elseif ($df > 1 && $df <= 2) $moments['variance'] = INF;
			else $moments['variance'] = NAN;
		}
		if (strpos($moments, 's') !== FALSE) {
			if ($df > 3) $moments['skew'] = 0;
			else $moments['skew'] = NAN;
		}
		if (strpos($moments, 'k') !== FALSE) {
			if ($df > 4) $moments['kurtosis'] = 6/($df - 4));
			else $moments['kurtosis'] = NAN;
		}
		
		return $moments;
	}
}
?>
