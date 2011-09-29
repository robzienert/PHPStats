<?php

/*
	Convenience file to include all distributions in one shot.  Just include this and the rest will follow.
*/

$currentFile = FALSE;

$discreteDirectory = opendir('Discrete');

while ($currentFile = readdir($discreteDirectory) {
	if (strpos($currentFile, '.php') !== FALSE) require_once('Discrete'.DIRECTORY_SEPARATOR.$currentFile)
}

closedir($discreteDirectory);

$continuousDirectory = opendir('Discrete');

while ($currentFile = readdir($continuousDirectory) {
	if (strpos($currentFile, '.php') !== FALSE) require_once('Continuous'.DIRECTORY_SEPARATOR.$currentFile)
}

closedir($continuousDirectory);

?>