<?php
/*
putenv('DISPLAY_ERRORS_DETAILS=' . true);
putenv('CONTIFY_DEV_MYSQL_HOST=cazrdbs01.mysql.database.azure.com');

$tokenType = substr($_SERVER['PHP_AUTH_PW'], 0, 5);

if ($tokenType == "TEST_") {
	//putenv('CONTIFY_DEV_MYSQL_DBNAME=api');
	putenv('CONTIFY_DEV_MYSQL_DBNAME=azure_apps_01');
} else {
	//putenv('CONTIFY_DEV_MYSQL_DBNAME=contify');
	putenv('CONTIFY_DEV_MYSQL_DBNAME=azure_apps_01');
}

putenv('CONTIFY_DEV_MYSQL_USER=cazrdbsadmin@cazrdbs01');
putenv('CONTIFY_DEV_MYSQL_PASSWORD=Provisoria2020@');
putenv('CONTIFY_DEV_MYSQL_PORT=3306');
*/

/*
putenv('DISPLAY_ERRORS_DETAILS=' . true);
putenv('CONTIFY_DEV_MYSQL_HOST=localhost');

$tokenType = substr($_SERVER['PHP_AUTH_PW'], 0, 5);

if ($tokenType == "TEST_") {
	//putenv('CONTIFY_DEV_MYSQL_DBNAME=api');
	putenv('CONTIFY_DEV_MYSQL_DBNAME=contify_test');
} else {
	//putenv('CONTIFY_DEV_MYSQL_DBNAME=contify');
	putenv('CONTIFY_DEV_MYSQL_DBNAME=contify_test');
}

putenv('CONTIFY_DEV_MYSQL_USER=root');
putenv('CONTIFY_DEV_MYSQL_PASSWORD=root');
putenv('CONTIFY_DEV_MYSQL_PORT=3306');
*/

// HEROKU
/*
putenv('DISPLAY_ERRORS_DETAILS=' . true);
putenv('CONTIFY_DEV_MYSQL_HOST=wiad5ra41q8129zn.cbetxkdyhwsb.us-east-1.rds.amazonaws.com');

$tokenType = substr($_SERVER['PHP_AUTH_PW'], 0, 5);

if ($tokenType == "TEST_") {
	//putenv('CONTIFY_DEV_MYSQL_DBNAME=api');
	putenv('CONTIFY_DEV_MYSQL_DBNAME=l00ouwcvtbh44qvs');
} else {
	//putenv('CONTIFY_DEV_MYSQL_DBNAME=contify');
	putenv('CONTIFY_DEV_MYSQL_DBNAME=l00ouwcvtbh44qvs');
}

putenv('CONTIFY_DEV_MYSQL_USER=ijhmrwex1lk9vlbu');
putenv('CONTIFY_DEV_MYSQL_PASSWORD=wz44emkwiqb51wuw');
putenv('CONTIFY_DEV_MYSQL_PORT=3306');
*/

putenv('DISPLAY_ERRORS_DETAILS=' . true);
putenv('CONTIFY_DEV_MYSQL_HOST=localhost');

$tokenType = substr($_SERVER['PHP_AUTH_PW'], 0, 5);

if ($tokenType == "TEST_") {
	putenv('CONTIFY_DEV_MYSQL_DBNAME=api');
	// putenv('CONTIFY_DEV_MYSQL_DBNAME=contify_test');
} else {
	putenv('CONTIFY_DEV_MYSQL_DBNAME=contify');
	// putenv('CONTIFY_DEV_MYSQL_DBNAME=contify_test');
}

putenv('CONTIFY_DEV_MYSQL_USER=root');
putenv('CONTIFY_DEV_MYSQL_PASSWORD=root');
putenv('CONTIFY_DEV_MYSQL_PORT=3306');







