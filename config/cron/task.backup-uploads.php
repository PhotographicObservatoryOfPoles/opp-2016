<?php

// Compress files into uploads.tar.gz
exec('cd src/wp-content/ && tar -zcf ${wp.path.backupfolder}/uploads.tar.gz uploads');

$date = date('d-m-y_G:i:s');
// Copy uploads.tar.gz to uploads
exec('cp ${wp.path.backupfolder}/uploads.tar.gz ${wp.path.backupfolder}/uploads--' . $date . '.tar.gz');
