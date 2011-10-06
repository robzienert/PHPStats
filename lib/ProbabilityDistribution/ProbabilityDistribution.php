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
 
require_once('lib/Stats.php');

/**
 * ProbabilityDistribution class
 * 
 * Parent class to all probability distributions.  Enforces a common interface
 * across subclasses and provides internal utility functions to them.
 */
abstract class ProbabilityDistribution {
	//Internal Utility Functions
	protected static function randFloat() {
		return ((float)mt_rand())/mt_getrandmax(); //A number between 0 and 1.
	}
}
?>
