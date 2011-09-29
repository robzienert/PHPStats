<?php
require_once('..'.DIRECTORY_SEPARATOR.'ProbabilityDistribution.php');

abstract class ContinuousDistribution extends ProbabilityDistribution {
	abstract public function pdf();

	abstract static function pdf();
}
?>