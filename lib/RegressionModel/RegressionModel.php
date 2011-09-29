<?php
require_once('..'.DIRECTORY_SEPARATOR.'Stats.php');

abstract class RegressionModel {
	protected $beta;
	protected $alpha;

	abstract public function __construct($datax, $datay);
	abstract public function predict();
}
?>