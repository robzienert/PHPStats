<?php
class StatisticalTests {
	static function oneSampleTTest($data, $populationAverage = 0) {
		$sampleT = (Stats::average($data)-$populationAverage)/(Stats::sampleStddev($data)/sqrt(count($data)));
		return self::studentsTCDF(count($data)-1, $sampleT);
	}

	static function twoSampleTTest($datax, $datay) {
		$df = pow(pow(Stats::sampleStddev($datax), 2)/count($datax)+pow(Stats::sampleStddev($datay), 2)/count($datay), 2)/(pow(pow(Stats::sampleStddev($datax), 2)/count($datax), 2)/(count($datax)-1)+pow(pow(Stats::sampleStddev($datay), 2)/count($datay), 2)/(count($datay)-1));
		$sampleT = (Stats::average($datax)-Stats::average($datay))/sqrt(pow(Stats::sampleStddev($datax), 2)/count($datax)+pow(Stats::sampleStddev($datay), 2)/count($datay));
	
		return self::studentsTCDF($df, $sampleT);
	}

	static function pairedTTest($datax, $datay, $populationAverage = 0) {
		$data = array();
		for ($count = 0; $count < min(count($datax), count($datay)); $count++) {
			$data[$count] = $datax[$count] - $datay[$count];
		}
		return self::oneSampleTTest($data, $populationAverage);
	}
}
?>
