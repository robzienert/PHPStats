<?php
require_once('ContinuousDistribution.php');

class ChiSquare extends ContinuousDistribution {
	private $k;
	
	function __construct($k = 1.0) {
		$this->k = $k;
	}

	//These are wrapper functions that call the static implementations with what we saved.
	
	/**
		Returns a random float
		
		@return float The random variate.
	*/
	public function rvs() {
		return self::getRvs($this->k);
	}
	
	/**
		Returns the probability distribution function
		
		@param float $x The test value
		@return float The probability
	*/
	public function pdf($x) {
		return self::getPdf($x, $this->k);
	}
	
	/**
		Returns the cumulative distribution function, the probability of getting the test value or something below it
		
		@param float $x The test value
		@return float The probability
	*/
	public function cdf($x) {
		return self::getCdf($x, $this->k);
	}
	
	/**
		Returns the survival function, the probability of getting the test value or something above it
		
		@param float $x The test value
		@return float The probability
	*/
	public function sf($x) {
		return self::getSf($x, $this->k);
	}
	
	/**
		Returns the percent-point function, the inverse of the cdf
		
		@param float $x The test value
		@return float The value that gives a cdf of $x
	*/
	public function ppf($x) {
		return self::getPpf($x, $this->k);
	}
	
	/**
		Returns the inverse survival function, the inverse of the sf
		
		@param float $x The test value
		@return float The value that gives an sf of $x
	*/
	public function isf($x) {
		return self::getIsf($x, $this->k);
	}
	
	/**
		Returns the moments of the distribution
		
		@param string $moments Which moments to compute. m for mean, v for variance, s for skew, k for kurtosis.  Default 'mv'
		@return type array A dictionary containing the first four moments of the distribution
	*/
	public function stats($moments = 'mv') {
		return self::getStats($moments, $this->k);
	}
	
	//These represent the calculation engine of the class.
	
	/**
		Returns a random float between $minimum and $minimum plus $maximum
		
		@param float $k Shape parameter
		@return float The random variate.
	*/
	static function getRvs($k = 1) {
		$k /= 2;
		$floork = floor($k);
		$fractionalk = $k - $floork;

		$sumLogUniform = 0;
		for ($index = 1; $index <= $floork; $index++) {
			$sumLogUniform += log(self::randFloat());
		}

		$m = 0;
		$xi = 0;
		$V = array(0);
		do {
			$m++;

			$V[] = self::randFloat();
			$V[] = self::randFloat();
			$V[] = self::randFloat();

			if ($V[3*$m - 2] <= M_E/(M_E + $fractionalk)) {
				$xi = pow($V[3*$m - 1], 1/$fractionalk);
				$eta = $V[3*$m]*pow($xi, $fractionalk - 1);
			}
			else {
				$xi = 1 - log($V[3*$m - 1]);
				$eta = $V[3*$m]*exp(-$xi);
			}
		} while($eta > pow($xi, $fractionalk - 1)*exp(-$xi));

		return 2*($xi - $sumLogUniform);
	}
	
	/**
		Returns the probability distribution function
		
		@param float $x The test value
		@param float $k Shape parameter
		@return float The probability
	*/
	static function getPdf($x, $k = 1) {
		return pow($x, $k/2.0 - 1)*exp(-$x/2.0)/(Stats::gamma($k/2.0)*pow(2, $k/2.0));
	}
	
	/**
		Returns the cumulative distribution function, the probability of getting the test value or something below it
		
		@param float $x The test value
		@param float $k Shape parameter
		@return float The probability
	*/
	static function getCdf($x, $k = 1) {
		return Stats::lowerGamma($k/2.0, $x/2)/Stats::gamma($k/2.0);
	}
	
	/**
		Returns the survival function, the probability of getting the test value or something above it
		
		@param float $x The test value
		@param float $k Shape parameter
		@return float The probability
	*/
	static function getSf($x, $k = 1) {
		return 1.0 - self::getCdf($x, $k, $theta);
	}
	
	/**
		Returns the percent-point function, the inverse of the cdf
		
		@param float $x The test value
		@param float $k Shape parameter
		@return float The value that gives a cdf of $x
	*/
	static function getPpf($x, $k = 1) {
		return 0; //TODO: ChiSquare PPF
	}
	
	/**
		Returns the inverse survival function, the inverse of the sf
		
		@param float $x The test value
		@param float $k Shape parameter
		@return float The value that gives an sf of $x
	*/
	static function getIsf($x, $k = 1) {
		return self::getPpf(1.0 - $x, $k);
	}
	
	/**
		Returns the moments of the distribution
		
		@param string $moments Which moments to compute. m for mean, v for variance, s for skew, k for kurtosis.  Default 'mv'
		@param float $k Shape parameter
		@return type array A dictionary containing the first four moments of the distribution
	*/
	static function getStats($moments = 'mv', $k = 1) {
		$return = array();
		
		if (strpos($moments, 'm') !== FALSE) $return['mean'] = $k;
		if (strpos($moments, 'v') !== FALSE) $return['variance'] = $k*2;
		if (strpos($moments, 's') !== FALSE) $return['skew'] = sqrt(8.0/$k);
		if (strpos($moments, 'k') !== FALSE) $return['kurtosis'] = 12.0/$k;
		
		return $return;
	}
}
?>
