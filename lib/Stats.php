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

/**
 * Stats class
 * 
 * Static class containing a variety of useful statistical functions.  
 * Fills in where PHP's math functions fall short.  Many functions are
 * Used extensively by the probability distributions.
 */
class Stats {
	//Useful to tell if a float has a mathematically integer value.
	private static function is_integer($x) {
		return ($x == floor($x));
	}

	/**
	 * Sum Function
	 * 
	 * Sums an array of numeric values.  Non-numeric values
	 * are treated as zeroes.
	 * 
	 * @param array $data An array of numeric values
	 * @return float The sum of the elements of the array
	 */
	public static function sum(array $data) {
		$sum = 0.0;
		foreach ($data as $element) {
			if (is_numeric($element)) $sum += $element;
		}
		return $sum;
	}

	/**
	 * Product Function
	 * 
	 * Multiplies an array of numeric values.  Non-numeric values
	 * are treated as ones.
	 * 
	 * @param array $data An array of numeric values
	 * @return float The product of the elements of the array
	 */
	public static function product(array $data) {
		$product = 1;
		foreach ($data as $element) {
			if (is_numeric($element)) $product *= $element;
		}
		return $product;
	}

	/**
	 * Average Function
	 * 
	 * Takes the arithmetic mean of tan array of numeric values.
	 * Non-numeric values are treated as zeroes.
	 * 
	 * @param array $data An array of numeric values
	 * @return float The arithmetic average of the elements of the array
	 */
	public static function average(array $data) {
		return self::sum($data)/count($data);
	}

	/**
	 * Geometric Average Function
	 * 
	 * Takes the geometic mean of an array of numeric values.
	 * Non-numeric values are treated as ones.
	 * 
	 * @param array $data An array of numeric values
	 * @return float The geometic average of the elements of the array
	 */
	public static function gaverage(array $data) {
		return pow(self::product($data), 1/count($data));
	}

	/**
	 * Sum-Squared Function
	 * 
	 * Returns the sum of squares of an array of numeric values.
	 * Non-numeric values are treated as zeroes.
	 * 
	 * @param array $data An array of numeric values
	 * @return float The arithmetic average of the elements of the array
	 */
	public static function sumsquared(array $data) {
		$sum = 0.0;
		foreach ($data as $element) {
			if (is_numeric($element)) $sum += pow($element, 2);
		}
		return $sum;
	}


	/**
	 * Sum-XY Function
	 * 
	 * Returns the sum of products of paired variables in a pair of arrays
	 * of numeric values.  The two arrays must be of equal length.
	 * Non-numeric values are treated as zeroes.
	 * 
	 * @param array $datax An array of numeric values
	 * @param array $datay An array of numeric values
	 * @return float The products of the paired elements of the arrays
	 */
	public static function sumXY(array $datax, array $datay) {
		$n = min(count($datax), count($datay));
		$sum = 0.0;
		for ($count = 0; $count < $n; $count++) {
			if (is_numeric($datax[$count])) $x = $datax[$count];
			else $x = 0; //Non-numeric elements count as zero.

			if (is_numeric($datay[$count])) $y = $datay[$count];
			else $y = 0; //Non-numeric elements count as zero.

			$sum += $x*$y;
		}
		return $sum;
	}

	/**
	 * Sum-Squared Error Function
	 * 
	 * Returns the sum of squares of errors of an array of numeric values.
	 * Non-numeric values are treated as zeroes.
	 * 
	 * @param array $data An array of numeric values
	 * @return float The sum of the squared errors of the elements of the array
	 */
	public static function sse(array $data) {
		$average = self::average($data);
		$sum = 0.0;
		foreach ($data as $element) {
			if (is_numeric($element)) $sum += pow($element - $average, 2);
			else $sum += pow(0 - $average, 2);
		}
		return $sum;
	}

	/**
	 * Mean-Squared Error Function
	 * 
	 * Returns the arithmetic mean of squares of errors of an array
	 * of numeric values. Non-numeric values are treated as zeroes.
	 * 
	 * @param array $data An array of numeric values
	 * @return float The average squared error of the elements of the array
	 */
	public static function mse(array $data) {
		return self::sse($data)/count($data);
	}

	/**
	 * Covariance Function
	 * 
	 * Returns the covariance of two arrays.  The two arrays must
	 * be of equal length. Non-numeric values are treated as zeroes.
	 * 
	 * @param array $datax An array of numeric values
	 * @param array $datay An array of numeric values
	 * @return float The covariance of the two supplied arrays
	 */
	public static function covariance(array $datax, array $datay) {
		return self::sumXY($datax, $datay)/count($datax) - self::average($datax)*self::average($datay);
	}

	/**
	 * Variance Function
	 * 
	 * Returns the population variance of an array.
	 * Non-numeric values are treated as zeroes.
	 * 
	 * @param array $data An array of numeric values
	 * @return float The variance of the supplied array
	 */
	public static function variance(array $data) {
		return self::covariance($data, $data);
	}

	/**
	 * Standard Deviation Function
	 * 
	 * Returns the population standard deviation of an array.
	 * Non-numeric values are treated as zeroes.
	 * 
	 * @param array $data An array of numeric values
	 * @return float The population standard deviation of the supplied array
	 */
	public static function stddev(array $data) {
		return sqrt(self::variance($data));
	}

	/**
	 * Sample Standard Deviation Function
	 * 
	 * Returns the sample (unbiased) standard deviation of an array.
	 * Non-numeric values are treated as zeroes.
	 * 
	 * @param array $data An array of numeric values
	 * @return float The unbiased standard deviation of the supplied array
	 */
	public static function sampleStddev(array $data) {
		return sqrt(self::sse($data)/(count($data)-1));
	}

	/**
	 * Correlation Function
	 * 
	 * Returns the correlation of two arrays.  The two arrays must
	 * be of equal length. Non-numeric values are treated as zeroes.
	 * 
	 * @param array $datax An array of numeric values
	 * @param array $datay An array of numeric values
	 * @return float The correlation of the two supplied arrays
	 */
	public static function correlation($datax, $datay) {
		return self::covariance($datax, $datay)/(self::stddev($datax)*self::stddev($datay));
	}

	/**
	 * Factorial Function
	 * 
	 * Returns the factorial of an integer.  Values less than 1 return
	 * as 1.  Non-integer arguments are evaluated only for the integer
	 * portion (the floor).  
	 * 
	 * @param int $x An array of numeric values
	 * @return int The factorial of $x, i.e. x!
	 */
	public static function factorial($x) {
		$sum = 1;
		for ($i = 1; $i <= floor($x); $i++) $sum *= $i;
		return $sum;
	}
	
	/**
	 * Error Function
	 * 
	 * Returns the real error function of a number.
	 * An approximation from Abramowitz and Stegurn is used.
	 * Maximum error is 1.5e-7. More information can be found at
	 * http://en.wikipedia.org/wiki/Error_function#Approximation_with_elementary_functions
	 * 
	 * @param float $x Argument to the real error function
	 * @return float A value between -1 and 1
	 */
	public static function erf($x) {
		$t = 1 / (1 + 0.3275911 * $x);
		return 1 - (0.254829592*$t - 0.284496736*pow($t, 2) + 1.421413741*pow($t, 3) + -1.453152027*pow($t, 4) + 1.061405429*pow($t, 5))*exp(-pow($x, 2));
	}
	
	/**
	 * Gamma Function
	 * 
	 * Returns the gamma function of a number.
	 * The gamma function is a generalization of the factorial function
	 * to non-integer and negative non-integer values. 
	 * The relationship is as follows: gamma(n) = (n - 1)!
	 * Stirling's approximation is used.  Though the actual gamma function
	 * is defined for negative, non-integer values, this approximation is
	 * undefined for anything less than or equal to zero.
	 * More information can be found at
	 * http://en.wikipedia.org/wiki/Stirling%27s_approximation
	 * 
	 * @param float $x Argument to the gamma function
	 * @return float The gamma of $x
	 */
	public static function gamma($x) {
		if ($x <= 0) return NAN;
		else {
			return sqrt(2*M_PI/$x)*pow((1/M_E)*($x+(1/(12*$x - 1/(10*$x)))), $x);
		}
	}

	/**
	 * Log Gamma Function
	 * 
	 * Returns the natural logarithm of the gamma function.  Useful for
	 * scaling.  From the jStat library.
	 * 
	 * @param float $x Argument to the gamma function
	 * @return The natural log of gamma of $x
	 */
	public static function gammaln($x) {
		$cof = array(
			76.18009172947146, -86.50532032941677, 24.01409824083091,
			-1.231739572450155, 0.1208650973866179e-2, -0.5395239384953e-5);
		$xx = $x;
		$y = $xx;
		$tmp = $x + 5.5;
		$tmp -= ($xx + 0.5) * log($tmp);
		$ser = 1.000000000190015;

		for($j = 0; $j < 6; $j++ ) $ser += $cof[$j] / ++$y;

		return log( 2.5066282746310005 * $ser / $xx) - $tmp;
	}
	
	/**
	 * Incomplete (Lower) Gamma Function
	 * 
	 * Returns the lower gamma function of a number.
	 * 
	 * @param float $s Upper bound of integration
	 * @param float $x Argument to the lower gamma function.
	 * @return float The lower gamma of $x
	 */
	public static function lowerGamma($s, $x) {
		//Special thanks to http://www.reddit.com/user/harlows_monkeys for this algorithm.
		if ($x == 0) return 0;
		$t = exp($s*log($x)) / $s;
		$v = $t;
		for ($k = 1; $k < 150; ++$k) {
			$t = -$t * $x * ($s + $k - 1) / (($s + $k) * $k);
			$v += $t;
			if (abs($t) < 0.00000000001) break;
		}
		return $v;
	}
	
	/**
	 * Incomplete (Upper) Gamma Function
	 * 
	 * Returns the upper gamma function of a number.
	 * 
	 * @param float $s Lower bound of integration
	 * @param float $x Argument to the upper gamma function
	 * @return float The upper gamma of $x
	 */
	public static function upperGamma($s, $x) {
		return self::gamma($s) - self::lowerGamma($s, $x);
	}

	/**
	 * Beta Function
	 * 
	 * Returns the beta function of a pair of numbers.
	 * 
	 * @param float $a The alpha parameter
	 * @param float $b The beta parameter
	 * @return float The beta of $a and $b
	 */
	public static function beta($a, $b) {
		return self::gamma($a)*self::gamma($b) / self::gamma($a + $b);
	}
	
	/**
	 * Calculates the regularized incomplete beta function.
	 * 
	 * Implements the jStat method of calculating the incomplete beta,
	 * 
	 * @param float $a The alpha parameter
	 * @param float $b The beta parameter
	 * @param float $x Upper bound of integration
	 * @return float The incomplete beta of $a and $b, up to $x
	 */
	public static function regularizedIncompleteBeta($a, $b, $x) {
		// Factors in front of the continued fraction.
		if ($x < 0 || $x > 1) return false;
		if ($x == 0 || $x == 1) $bt = 0;
		else $bt = exp(self::gammaln($a + $b) - self::gammaln($a) - self::gammaln($b) + $a * log($x) + $b * log(1 - $x));

		if( $x < ( $a + 1 ) / ( $a + $b + 2 ) )
			// Use continued fraction directly.
			return $bt * self::betacf($x, $a, $b) / $a;
		else
			// else use continued fraction after making the symmetry transformation.
			return 1 - $bt * self::betacf(1 - $x, $b, $a) / $b;
	}

	// Evaluates the continued fraction for incomplete beta function by modified Lentz's method.
	private static function betacf($x, $a, $b) {
		$fpmin = 1e-30;

		// These q's will be used in factors that occur in the coefficients
		$qab = $a + $b;
		$qap = $a + 1;
		$qam = $a - 1;
		$c = 1;
		$d = 1 - $qab * $x / $qap;
		if(abs($d) < $fpmin ) $d = $fpmin;
		$d = 1 / $d;
		$h = $d;
		for ($m = 1; $m <= 100; $m++) {
			$m2 = 2 * $m;
			$aa = $m * ($b - $m) * $x / (($qam + $m2) * ($a + $m2));

			// One step (the even one) of the recurrence
			$d = 1 + $aa * $d;
			if(abs($d) < $fpmin ) $d = $fpmin;
			$c = 1 + $aa / $c;
			if(abs($c) < $fpmin ) $c = $fpmin;
			$d = 1 / $d;
			$h *= $d * $c;
			$aa = -($a + $m) * ($qab + $m) * $x / (($a + $m2) * ($qap + $m2));

			// Next step of the recurrence (the odd one)
			$d = 1 + $aa * $d;
			if(abs($d) < $fpmin) $d = $fpmin;
			$c = 1 + $aa / $c;
			if(abs($c) < $fpmin) $c = $fpmin;
			$d = 1 / $d;
			$del = $d * $c;
			$h *= $del;

			if(abs($del - 1.0) < 3e-7 ) break;
		}
		return $h;
	}

	/**
	 * Permutation Function
	 * 
	 * Returns the number of ways of choosing $r objects from a collection
	 * of $n objects, where the order of selection matters.
	 * 
	 * @param int $n The size of the collection
	 * @param int $r The size of the selection
	 * @return int $n pick $r
	 */
	public static function permutations($n, $r) {
		return self::factorial($n)/self::factorial($n - $r);
	}

	/**
	 * Combination Function
	 * 
	 * Returns the number of ways of choosing $r objects from a collection
	 * of $n objects, where the order of selection does not matter.
	 * 
	 * @param int $n The size of the collection
	 * @param int $r The size of the selection
	 * @return int $n choose $r
	 */
	public static function combinations($n, $r) {
		return self::permutations($n, $r)/self::factorial($r);
	}
}
?>
