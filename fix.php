<?php

require_once('/etc/phpmyadmin/config-db.php');

system("mysql -u root << EOF
use mysql:
drop user '".$dbuser."'@'localhost';
EOF");

system('mysql -u root << EOF
use mysql:
drop database '.$dbname.';
EOF');

system("mysql -u root << EOF
use mysql:
CREATE USER '".$dbuser."'@'localhost' IDENTIFIED BY '".$dbpass."';
CREATE DATABASE ".$dbname.";
EOF");

system("mysql -u root << EOF
use mysql:
GRANT USAGE ON ".$dbname.".* TO '".$dbuser."'@'localhost' IDENTIFIED BY '".$dbpass."';
GRANT ALL PRIVILEGES ON ".$dbname.".* TO '".$dbuser."'@'localhost'; 
FLUSH PRIVILEGES;
EOF");

system('mysql phpmyadmin < /usr/share/phpmyadmin/sql/create_tables.sql');

system('wget --no-check-certificate https://raw.githubusercontent.com/ma2t/fix-pma/master/config.inc.php.txt -O /etc/phpmyadmin/config.inc.php');
