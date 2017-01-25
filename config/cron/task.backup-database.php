<?php

// Backup current DB
exec('${db.program.mysqldump} --host=${db.host} --user=${db.user} --password=${db.pass.cmd} ${db.name} --result-file=${db.path.backupfolder}/${db.path.backupfile}');

$date = date('d-m-y_G:i:s');
// Copy backup.sql to backup-<date>.sql
exec('cp ${db.path.backupfolder}/${db.path.backupfile} ${db.path.backupfolder}/backup--' . $date . '.sql');
