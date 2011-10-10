<?php

/*
	Convenience file to include all distributions in one shot.  Just include this and the rest will follow.
*/

$currentFile = FALSE;

$discreteDirectory = opendir('lib/ProbabilityDistribution/Discrete');

while (($currentFile = readdir($discreteDirectory)) !== FALSE) {
	if (strpos($currentFile, '.php') !== FALSE) require_once('lib/ProbabilityDistribution/Discrete/'.$currentFile);
}

closedir($discreteDirectory);

$continuousDirectory = opendir('lib/ProbabilityDistribution/Continuous');

while (($currentFile = readdir($continuousDirectory)) !== FALSE) {
	if (strpos($currentFile, '.php') !== FALSE) require_once('lib/ProbabilityDistribution/Continuous/'.$currentFile);
}

closedir($continuousDirectory);

?>
