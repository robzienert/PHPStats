<?php
require_once('lib/Stats.php');

abstract class RegressionModel {
	protected $beta;
	protected $alpha;
	protected $r;

	abstract public function __construct($datax, $datay);
	abstract public function predict($x);

	public function getAlpha() {
		return $this->alpha;
	}

	public function getBeta() {
		return $this->beta;
	}

	public function getCorrelation() {
		return $this->r;
	}
}
?>
