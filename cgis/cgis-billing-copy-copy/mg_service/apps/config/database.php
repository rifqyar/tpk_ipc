<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$active_group = 'default';
$active_record = TRUE;

//$tnsname = '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.222.2.20)(PORT = 1552))(CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = ebstest)))';

$db['default']['hostname'] = '10.222.2.20:1552/ebstest';
$db['default']['username'] = 'XMTI';
$db['default']['password'] = 'welcome1$';
$db['default']['database'] = '';
$db['default']['dbdriver'] = 'oci8';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;

$db['wms']['hostname'] = '10.1.2.207';
$db['wms']['username'] = 'dev';
$db['wms']['password'] = 'd3v3D1indonesia!';
$db['wms']['database'] = 'tpk_ipc';
$db['wms']['dbdriver'] = 'mysqli';
$db['wms']['dbprefix'] = '';
$db['wms']['pconnect'] = FALSE;
$db['wms']['db_debug'] = FALSE;
$db['wms']['cache_on'] = FALSE;
$db['wms']['cachedir'] = '';
$db['wms']['char_set'] = 'utf8';
$db['wms']['dbcollat'] = 'utf8_general_ci';
$db['wms']['swap_pre'] = '';
$db['wms']['autoinit'] = TRUE;
$db['wms']['stricton'] = FALSE;


/* End of file database.php */
/* Location: ./application/config/database.php */