<?php

$tns = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.222.2.20)(PORT = 1552))(CONNECT_DATA = (SERVER = DEDICATED)(SERVICE_NAME = ebstest)))";
if(!$connora = oci_connect('XMTI', 'welcome1$', $tns)){
	$err = oci_error();
	echo "ERROR! Unable to connect - ";
	echo htmlentities($err['message']);
	die();
}else{
	echo "OK";
}
?>