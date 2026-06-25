<?php

//header("Access-Control-Allow-Origin: *");
//header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
//header("Access-Control-Max-Age: 604800");
//header("Access-Control-Allow-Headers: x-requested-with, Content-Type, origin, authorization, accept, soapaction");
//ob_start();
//ini_set('memory_limit', '512M');
//ini_set('memory_limit', '1024M');
// call library
require_once ('config.php' );
require_once ($CONF['root.dir'] . 'Libraries/nusoap/nusoap.php' );

$appsClass = new apps($CONF, $conn);
$wsdlCaption = 'BillingServices';

// create instance
$server = new soap_server();

// initialize WSDL support
$server->configureWSDL($wsdlCaption, 'urn:' . $wsdlCaption . 'wsdl');

// place schema at namespace with prefix tns
$server->wsdl->schemaTargetNamespace = 'urn:' . $wsdlCaption . 'wsdl';

// register method
$server->register('HelloWorld', // method name
        array('UserName' => 'xsd:string'),
        // input parameter
        array('return' => 'xsd:string'), // output
        'urn:HelloWorldwsdl', // namespace
        'urn:' . $wsdlCaption, // soapaction
        'rpc', // style
        'encoded', // use
        'HelloWorld'// documentation
);

$server->register('saveIntegrasi', // method name
        array('in_param' => 'xsd:string'), // input parameter
        array('return' => 'xsd:string'), // output
        'urn:saveIntegrasiwsdl', // namespace
        'urn:portalintegrasiipc', // soapaction
        'rpc', // style
        'encoded', // use
        'Fungsi untuk saveIntegrasi'// documentation
);

$server->register('getMessage', // method name
        array('source_system' => 'xsd:string', 'is_transaction' => 'xsd:string', 'is_receipt' => 'xsd:string', 'is_payable' => 'xsd:string'), // input parameter
        array('return' => 'xsd:string'), // output
        'urn:getMessagewsdl', // namespace
        'urn:portalintegrasiipc', // soapaction
        'rpc', // style
        'encoded', // use
        'Fungsi untuk getMessage'// documentation
);

$server->register('getMessageOnDemand', // method name
        array('source_system' => 'xsd:string', 'transaction_no' => 'xsd:string', 'is_transaction' => 'xsd:string', 'is_receipt' => 'xsd:string', 'is_payable' => 'xsd:string'), // input parameter
        array('return' => 'xsd:string'), // output
        'urn:getMessagewsdl', // namespace
        'urn:portalintegrasiipc', // soapaction
        'rpc', // style
        'encoded', // use
        'Fungsi untuk getMessage'// documentation
);

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);

function saveIntegrasi($in_param) {
    global $conn, $appsClass;
    $conn->connect();
    $data = $appsClass->saveIntegrasi($in_param);
    $Response = $data;
    $conn->disconnect();
    return $Response;
}

function getMessage($source_system, $is_transaction, $is_receipt, $is_payable) {
    global $conn, $appsClass;
    $conn->connect();
    $data = $appsClass->getMessage($source_system, $is_transaction, $is_receipt, $is_payable);
    $Response = $data;
    $conn->disconnect();
    return $Response;
}

function getMessageOnDemand($source_system, $transaction_no, $is_transaction, $is_receipt, $is_payable) {
    global $conn, $appsClass;
    $conn->connect();
    $data = $appsClass->getMessage($source_system, $is_transaction, $is_receipt, $is_payable, $transaction_no);
    $Response = $data;
    $conn->disconnect();
    return $Response;
}

function HelloWorld($UserName) {
    $Response = "Hello " . $UserName;
    return $Response;
}
?>

