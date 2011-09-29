<?php
require_once('DiscreteDistribution.php');

class Binomial extends DiscreteDistribution {
	private $n;
	private $p;
	
	function __construct($p = 0, $n = 1) {
		$this->p = $p;
		$this->n = $n;
	}

	//These are wrapper functions that call the static implementations with what we saved.
	
	/**
		Returns a random variate of $n trials at $p probability each
		
		@return float The random variate.
	*/
	public function rvs() {
		return self::rvs($this->p, $this->n);
	}
	
	/**
		Returns the probability distribution function
		
		@param float $x The test value
		@return float The probability
	*/
	public function pmf($x) {
		return self::pmf($x, $this->p, $this->n);
	}
	
	/**
		Returns the cumulative distribution function, the probability of getting the test value or something below it
		
		@param float $x The test value
		@return float The probability
	*/
	public function cdf($x) {
		return self::cdf($x, $this->p, $this->n);
	}
	
	/**
		Returns the survival function, the probability of getting the test value or something above it
		
		@param float $x The test value
		@return float The probability
	*/
	public function sf($x) {
		return self::sf($x, $this->p, $this->n);
	}
	
	/**
		Returns the percent-point function, the inverse of the cdf
		
		@param float $x The test value
		@return float The value that gives a cdf of $x
	*/
	public function ppf($x) {
		return self::ppf($x, $this->p, $this->n);
	}
	
	/**
		Returns the inverse survival function, the inverse of the sf
		
		@param float $x The test value
		@return float The value that gives an sf of $x
	*/
	public function isf($x) {
		return self::isf($x, $this->p, $this->n);
	}
	
	/**
		Returns the moments of the distribution
		
		@param string $moments Which moments to compute. m for mean, v for variance, s for skew, k for kurtosis.  Default 'mv'
		@return type array A dictionary containing the first four moments of the distribution
	*/
	public function stats($moments = 'mv') {
		return self::stats($moments, $this->p, $this->n);
	}

	//These represent the calculation engine of the class.
	
	/**
		Returns a random variate of $n trials at $p probability each
		
		@param float $p The probability of success per trial.
		@param int $n The number of trials.
		@return float The random variate.
	*/
	static function rvs($p = 0.5, $n = 1) {
		$successes = 0;

		for ($i = 0; $i < $n; $i++;) {
			if (self::BernoulliTrial($p)) $successes++;
		}

		return $successes;
	}
	
	/**
		Returns the probability mass function
		
		@param float $x The test value
		@param float $p The probability of success per trial
		@param int $n The number of trials
		@return float The probability
	*/
	static function pmf($x, $p = 0.5, $n = 1) {
		return Stats::combinations($n, $x)*pow($p, $x)*pow(1 - p, $n - $x);
	}
	
	/**
		Returns the cumulative distribution function, the probability of getting the test value or something below it
		
		@param float $x The test value
		@param float $p The probability of success per trial
		@param int $n The number of trials
		@return float The probability
	*/
	static function cdf($x, $p = 0.5, $n = 1) {
		$sum = 0.0;
		for ($count = 0; $count <= $x; $count++) {
			$sum += self::pmf($count, $p, $n);
		}
		return $sum;
	}
	
	/**
		Returns the survival function, the probability of getting the test value or something above it
		
		@param float $x The test value
		@param float $p The probability of success per trial
		@param int $n The number of trials
		@return float The probability
	*/
	static function sf($x, $p = 0.5, $n = 1) {
		return 1.0 - self::cdf($x, $p, $n);
	}
	
	/**
		Returns the percent-point function, the inverse of the cdf
		
		@param float $x The test value
		@param float $p The probability of success per trial
		@param int $n The number of trials
		@return float The value that gives a cdf of $x
	*/
	static function ppf($x, $p = 0.5, $n = 1) {
		return 0; //TODO: Binomial PPF
	}
	
	/**
		Returns the inverse survival function, the inverse of the sf
		
		@param float $x The test value
		@param float $p The probability of success per trial
		@param int $n The number of trials
		@return float The value that gives an sf of $x
	*/
	static function isf($x, $p = 0.5, $n = 1) {
		return self::ppf(1.0 - $x, $p, $n);
	}
	
	/**
		Returns the moments of the distribution
		
		@param string $moments Which moments to compute. m for mean, v for variance, s for skew, k for kurtosis.  Default 'mv'
		@param float $p The probability of success per trial
		@param int $n The number of trials
		@return type array A dictionary containing the first four moments of the distribution
	*/
	static function stats($moments = 'mv', $p = 0.5, $n = 1) {
		$moments = array();
		
		if (strpos($moments, 'm') !== FALSE) $moments['mean'] = $n*$p;
		if (strpos($moments, 'v') !== FALSE) $moments['variance'] = $n*$p*(1-$p);
		if (strpos($moments, 's') !== FALSE) $moments['skew'] = (1-2*$p)/sqrt($n*$p*(1-$p));
		if (strpos($moments, 'k') !== FALSE) $moments['kurtosis'] = (1 - 6*$p*(1 - $p))/($n*$p*(1-$p));
		
		return $moments;
	}
}