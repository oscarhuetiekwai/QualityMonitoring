<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$active_group = 'qm';
$active_record = TRUE;

$db['qm']['hostname'] = 'localhost';
$db['qm']['username'] = 'callcenter';
$db['qm']['password'] = 'ca11c3nt3r';
$db['qm']['database'] = 'qm';
$db['qm']['dbdriver'] = 'mysql';
$db['qm']['dbprefix'] = '';
$db['qm']['pconnect'] = TRUE;
$db['qm']['db_debug'] = TRUE;
$db['qm']['cache_on'] = FALSE;
$db['qm']['cachedir'] = '';
$db['qm']['char_set'] = 'utf8';
$db['qm']['dbcollat'] = 'utf8_general_ci';
$db['qm']['swap_pre'] = '';
$db['qm']['autoinit'] = TRUE;
$db['qm']['stricton'] = FALSE;

/* call contact detail table */
$active_group = "reportcallcenter";
$active_record = TRUE;

$db['reportcallcenter']['hostname'] = 'localhost';
$db['reportcallcenter']['username'] = 'callcenter';
$db['reportcallcenter']['password'] = 'ca11c3nt3r';
$db['reportcallcenter']['database'] = 'reportcallcenter';
$db['reportcallcenter']['dbdriver'] = 'mysql';
$db['reportcallcenter']['dbprefix'] = '';
$db['reportcallcenter']['pconnect'] = TRUE;
$db['reportcallcenter']['db_debug'] = TRUE;
$db['reportcallcenter']['cache_on'] = FALSE;
$db['reportcallcenter']['cachedir'] = '';
$db['reportcallcenter']['char_set'] = 'utf8';
$db['reportcallcenter']['dbcollat'] = 'utf8_general_ci';
$db['reportcallcenter']['swap_pre'] = '';
$db['reportcallcenter']['autoinit'] = TRUE;
$db['reportcallcenter']['stricton'] = FALSE;

/* call contact detail table */
$active_group = "callcenter";
$active_record = TRUE;

$db['callcenter']['hostname'] = 'localhost';
$db['callcenter']['username'] = 'callcenter';
$db['callcenter']['password'] = 'ca11c3nt3r';
$db['callcenter']['database'] = 'callcenter';
$db['callcenter']['dbdriver'] = 'mysql';
$db['callcenter']['dbprefix'] = '';
$db['callcenter']['pconnect'] = TRUE;
$db['callcenter']['db_debug'] = TRUE;
$db['callcenter']['cache_on'] = FALSE;
$db['callcenter']['cachedir'] = '';
$db['callcenter']['char_set'] = 'utf8';
$db['callcenter']['dbcollat'] = 'utf8_general_ci';
$db['callcenter']['swap_pre'] = '';
$db['callcenter']['autoinit'] = TRUE;
$db['callcenter']['stricton'] = FALSE;


/* call contact detail table */
$active_group = "webim_db";
$active_record = TRUE;

$db['webim_db']['hostname'] = 'localhost';
$db['webim_db']['username'] = 'callcenter';
$db['webim_db']['password'] = 'ca11c3nt3r';
$db['webim_db']['database'] = 'webim_db';
$db['webim_db']['dbdriver'] = 'mysql';
$db['webim_db']['dbprefix'] = '';
$db['webim_db']['pconnect'] = TRUE;
$db['webim_db']['db_debug'] = TRUE;
$db['webim_db']['cache_on'] = FALSE;
$db['webim_db']['cachedir'] = '';
$db['webim_db']['char_set'] = 'utf8';
$db['webim_db']['dbcollat'] = 'utf8_general_ci';
$db['webim_db']['swap_pre'] = '';
$db['webim_db']['autoinit'] = TRUE;
$db['webim_db']['stricton'] = FALSE;
/* End of file database.php */
/* Location: ./application/config/database.php */