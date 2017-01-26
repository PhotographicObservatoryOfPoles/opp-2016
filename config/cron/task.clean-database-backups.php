<?php

$directory = '${db.path.backupfolder}/';
$files = scandir($directory);

if ($files) {

	// Remove . and .. values from array
	unset($files[0]);
	unset($files[1]);

	// Sort files by filemtime desc
	$success = usort($files, function($file1, $file2) {
		$dir = '${db.path.backupfolder}/';
    	return filemtime($dir . $file1) > filemtime($dir . $file2);
	});

	if ($success) {

		// Remove older files to keep the 4 most recent files
		$nbFilesToDelete = count($files) - 4;
		
		for ($i=0; $i < $nbFilesToDelete; $i++) {
			exec('rm ' . $directory . $files[$i]);
		}
	}
}
