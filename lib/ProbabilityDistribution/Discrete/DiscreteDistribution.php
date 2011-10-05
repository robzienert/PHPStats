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
 
require_once('..'.DIRECTORY_SEPARATOR.'ProbabilityDistribution.php');

/**
 * DiscreteDistribution class
 * 
 * Parent class to all discrete probability distributions.  Extends the generic
 * ProbabilityDistribution interface with Discrete-specific functions and some
 * utility functions used by discrete distributions.
 */
abstract class DiscreteDistribution extends ProbabilityDistribution {
	//Internal Utility Functions
	protected static function BernoulliTrial($p = 0.5) {
		$standardVariate = ((float)mt_rand())/mt_getrandmax();
		return ($standardVariate <= $p)?1:0;
	}

	//Additional Wrapper Functions
	abstract public function pmf();

	//Additional Calculation Functions
	abstract static function pmf();
}
?>