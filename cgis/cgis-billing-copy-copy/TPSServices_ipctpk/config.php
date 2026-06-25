<?php

date_default_timezone_set('Asia/Jakarta');
//error_reporting(-1);
ini_set('display_error', 'E_ALL');
$CONF['root.dir'] = '/var/www/html/dev/cgis-billing/TPSServices/';
print_r($CONF);
//$CONF['root.dir'] = 'F:/WEB/TPS-ONLINE-MASS/TPSServices/';
//$CONF['url.wsdl'] = 'https://tpsonline.beacukai.go.id/tps/service.asmx';
//$CONF['url.wsdl'] = 'https://202.137.230.158/tps/service.asmx';
$CONF['proxyhost'] = "";
$CONF['proxyport'] = "";

$CONF['host'] = "10.1.2.207";
$CONF['username'] = "dev";
$CONF['password'] = "d3v3D1indonesia!";
$CONF['database'] = "tpk_ipc";
$CONF['port'] = "3306";

/*$CONF['host'] = "10.1.2.49";
$CONF['username'] = "tpft";
$CONF['password'] = "tpft3d11";
$CONF['database'] = "tpk_ipc";
$CONF['port'] = "3306";*/

/* $CONF['host'] = "localhost";
  $CONF['username'] = "root";
  $CONF['password'] = "phpMyAdmin";
  $CONF['database'] = "dbport";
  $CONF['port'] = "3306"; */

require_once($CONF['root.dir'] . "Libraries/functions.php");
require_once($CONF['root.dir'] . "Libraries/xml2array.php");
require_once($CONF['root.dir'] . "ClassData/main.class.php");

//setting database
require_once($CONF['root.dir'] . "Libraries/dbLite/DBManager.php");
$conn = new DBManager($DB_MANAGER->DB_MYSQL);
$conn->parseURL("db.MYSQL://" . $CONF['username'] . ":" . $CONF['password'] . "@" . $CONF['host']);
$conn->setDBName($CONF['database']);
?>