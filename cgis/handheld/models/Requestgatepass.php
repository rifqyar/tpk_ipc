<?php defined('BASEPATH') or exit('No direct script access allowed');

class Requestgatepass extends CI_Model
{

    private $globurl1 = 'https://api.npct1.co.id/services/index.php/ipc';
    private $globurl2 = 'https://10.244.1.20:8904/goscg';
    
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * mesaage 2 A
     * edphoint https://10.244.20.14/services/index.php/ipc?wsdl
     * method get_validation
     * webserivice
     */
    public function message2a($arraydata) 
    {
        //echo "message2a";
        //var_dump($arraydata);die();
        $headers = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "SOAPAction: $this->globurl1",
        );


        $e = explode('-',$arraydata->ID_FLAT);
        $tid = trim($e[1]);
        $e2 = explode('/',$arraydata->TAR);
        $tar = $e2[0];
        $nocont = $arraydata->NO_CONT;
        $weight = $arraydata->BERAT_TRUCK;

        $xml = '<soapenv:Envelope
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xmlns:xsd="http://www.w3.org/2001/XMLSchema"
        xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
        xmlns:urn="urn:get_validation">
        <soapenv:Header/>
        <soapenv:Body>
            <urn:get_validation soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
                <username xsi:type="xsd:string">CGO</username>
                <password xsi:type="xsd:string">CGO@2017</password>
                <data xsi:type="xsd:string">
                    <![CDATA[<request><tid>'.$tid.'</tid><tar>'.$tar.'</tar><cont_no>'.$nocont.'</cont_no><weight>'.$weight.'</weight><handling_type>IN</handling_type></request>]]>
                </data>
            </urn:get_validation>
        </soapenv:Body>
        </soapenv:Envelope>';
        
        $data = $this->webservicecurl($this->globurl1,$headers,$xml,'get_validation');
        $rawrespon = json_encode($data);
        $this->db->query("INSERT INTO `tpk_ipc`.`log_integrasi_behandle` (`type`, `no_cont`, `raw_request`, `raw_response`) VALUES ('message2a', '$arraydata->NO_CONT', '$xml', '$rawrespon')");
        return $data;
    }

    /**
     * mesaage 2 B
     * edphoint http://10.244.1.40:8904/goscg
     * method POST
     * media type application/XML
     * REST
     */
    public function message2b($arraydata)
    {
        //echo "message2b";
        $e2 = explode('/',$arraydata->TAR);
        $tar = $e2[0];//'SQX789S';

        $xml = '<?xml version="1.0" encoding="utf-8"?>
        <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:cgt="http://cgtgos.com/">
          <soapenv:Header/>
          <soapenv:Body>
            <CheckAppointment_request>
              <TruckEvent>
                <MessageHeader>
                  <Sender>IPC</Sender>
                  <Recipient>NPCT1</Recipient>
                  <MessageType>CIC</MessageType>
                  <MessageVersion>1.0.0</MessageVersion>
                  <MessageId>9990</MessageId>
                  <MessageName>CHKTAR</MessageName>
                  <MessageFunction>CREATE</MessageFunction>
                  <Terminal>NPCT1</Terminal>
                  <TruckingCompany>CIC</TruckingCompany>
                </MessageHeader>
                <Status>
                  <StatusCode>ANC</StatusCode>
                </Status>
                <TruckCall>
                  <TAR>'.$tar.'</TAR>
                </TruckCall>
              </TruckEvent>
            </CheckAppointment_request>
          </soapenv:Body>
        </soapenv:Envelope>';
        
        $data = $this->restcurl($this->globurl2,$xml);
        $rawrespon = json_encode($data);
        $this->db->query("INSERT INTO `tpk_ipc`.`log_integrasi_behandle` (`type`, `no_cont`, `raw_request`, `raw_response`) VALUES ('message2b', '$arraydata->NO_CONT', '$xml', '$rawrespon')");
        return $data;
    }

    /**
     * mesaage 3 A
     * edphoint https://10.244.20.14/services/index.php/ipc?wsdl
     * method set_codeco_in
     * webserivice
     */
    public function message3a($arraydata) 
    {
        //echo "message3a";

        $ata = $timenow = date('YmdHis');//'20200430062107';
        $plate = trim($arraydata->NO_PLAT);//'B9678WG';
        $e2 = explode('/',$arraydata->TAR);
        $tar = $e2[0];//'ASX8558';
        $e = explode('-',$arraydata->ID_FLAT);
        $tid = trim($e[1]);//'18723';
        $weight = $arraydata->BERAT_TRUCK;//'12760';

        $ContainerId = $arraydata->NO_CONT;//'UETU4044009' ;
        $ISOCode = $arraydata->ISO_CODE;//'42G0' ;
        $LoadingStatus = $arraydata->KD_CONT_JENIS;//'F' ;
        $Vessel = $arraydata->VESSEL;//'MEPIS' ;
        $Voyage = $arraydata->VOY_IN;//'029S' ;
        $ContainerCondition = 'No Damage' ;
        $ContainerHeight = '0.0' ;
        $ContainerLength = '0.0' ;
        $ContainerType = $arraydata->TIPE_CONT;//'DRY' ;
        $CustomsReference = $arraydata->NO_DOK;//'SPPB211193/KPU.01/2020|PIB210813' ;

        $GrossWeight = $arraydata->BERAT_TRUCK;//'12760';
        $WeighingTime = $timenow = date('YmdHis');//'20200430062107';
        $totalWeight = $arraydata->BERAT_TRUCK;//'12760';

        $headers = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "SOAPAction: $this->globurl1",
        );
        $isi = '<?xml version="1.0" encoding="UTF-8"?>
        <document>
            <MessageHeader>
                <MessageFunction>CREATE</MessageFunction>
                <MessageId>9990</MessageId>
                <MessageName>CGPCHECK</MessageName>
                <MessageType>CIC</MessageType>
                <MessageVersion>1.0.0</MessageVersion>
                <Recipient>NPCT1</Recipient>
                <Sender>IPC</Sender>
                <Terminal>NPCT1</Terminal>
                <TruckingCompany>CIC</TruckingCompany>
            </MessageHeader>
            <Status>
                <StatusCode>IN</StatusCode>
            </Status>
            <TruckCall>
                <ATA>'.$ata.'</ATA>
                <LicensePlate>'.$plate.'</LicensePlate>
                <TAR>'.$tar.'</TAR>
                <TID>'.$tid.'</TID>
                <TruckingCompany />
                <TruckingWeight>'.$weight.'</TruckingWeight>
            </TruckCall>
            <Prenotifications>
                <Prenotification>
                    <Container>
                        <HandlingType>OUT</HandlingType>
                        <ContainerId>'.$ContainerId.'</ContainerId>
                        <ISOCode>'.$ISOCode.'</ISOCode>
                        <LoadingStatus>'.$LoadingStatus.'</LoadingStatus>
                        <OriginDestination>IDJKT</OriginDestination>
                        <Vessel>'.$Vessel.'</Vessel>
                        <Voyage>'.$Voyage.'</Voyage>
                        <ContainerCondition>'.$ContainerCondition.'</ContainerCondition>
                        <ContainerHeight>'.$ContainerHeight.'</ContainerHeight>
                        <ContainerIMDGClass />
                        <ContainerLength>'.$ContainerLength.'</ContainerLength>
                        <ContainerType>'.$ContainerType.'</ContainerType>
                        <ContainerUNnbr />
                        <CustomsReference>'.$CustomsReference.'</CustomsReference>
                        <DriveThrough>FALSE</DriveThrough>
                        <ETA />
                        <ATA />
                        <OrderReference />
                        <Reefer>FALSE</Reefer>
                        <ReleaseReference />
                        <Sequence>1</Sequence>
                        <GrossWeight>'.$GrossWeight.'</GrossWeight>
                        <WeighingTime>'.$WeighingTime.'</WeighingTime>
                        <totalWeight>'.$totalWeight.'</totalWeight>
                    </Container>
                </Prenotification>
            </Prenotifications>
        </document>';

        $xml = '<soapenv:Envelope
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xmlns:xsd="http://www.w3.org/2001/XMLSchema"
        xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
        xmlns:urn="urn:set_codeco_in">
        <soapenv:Header/>
        <soapenv:Body>
            <urn:set_codeco_in soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
                <username xsi:type="xsd:string">CGO</username>
                <password xsi:type="xsd:string">CGO@2017</password>
                <data xsi:type="xsd:string">
                    <![CDATA['.$isi.']]>
                </data>
            </urn:set_codeco_in>
        </soapenv:Body>
        </soapenv:Envelope>';

        $data = $this->webservicecurl($this->globurl1,$headers,$xml,'set_codeco_in');
        $rawrespon = json_encode($data);
        $this->db->query("INSERT INTO `tpk_ipc`.`log_integrasi_behandle` (`type`, `no_cont`, `raw_request`, `raw_response`) VALUES ('message3a', '$arraydata->NO_CONT', '$xml', '$rawrespon')");
        return $data;
    }

    /**
     * mesaage 3 B
     * edphoint http://10.244.1.40:8904/goscg
     * method POST
     * media type application/XML
     * REST
     */
    public function message3b($arraydata)
    {
        //echo "message3b";
        $LicensePlate = $arraydata->NO_PLAT;
        $e2 = explode('/',$arraydata->TAR);
        $TAR = $e2[0];
        $e = explode('-',$arraydata->ID_FLAT);
        $TID = trim($e[1]);
        $ATA = date('Y-m-d').'T'.date('H:i:s+07:00');

        $ContainerId = $arraydata->NO_CONT;
        $LoadingStatus = $arraydata->KD_CONT_JENIS;
        $GrossWeight = $arraydata->BERAT_TRUCK;
        $ISOCode = $arraydata->ISO_CODE;
        if ($arraydata->FL_DG = 'N') {
            $DamagePresent = 'N';
        }else{
            $DamagePresent = 'Y';
        }
        if ($arraydata->FL_OOG = 'N') {
            $ContainerOOG = 'F';
        }else{
            $ContainerOOG = 'T';
        }
        
        
        
        $xml = '<?xml version="1.0" encoding="utf-8" ?>
        <soapenv:Envelope
            xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
            xmlns:cgt="http://cgtgos.com/">
            <soapenv:Header/>
            <soapenv:Body>
                <TIDRegistration_request>
                    <TruckEvent>
                        <MessageHeader>
                            <Sender>IPC</Sender>
                            <Recipient>NPCT1</Recipient>
                            <MessageType>CIC</MessageType>
                            <MessageVersion>1.0.0</MessageVersion>
                            <MessageId>9990</MessageId>
                            <MessageName>CGPCHECK</MessageName>
                            <MessageFunction>CREATE</MessageFunction>
                            <Terminal>NPCT1</Terminal>
                            <TruckingCompany>CIC</TruckingCompany>
                        </MessageHeader>
                        <Status>
                            <StatusCode>ANC</StatusCode>
                        </Status>
                        <TruckCall>
                            <TruckingCompany>CIC</TruckingCompany>
                            <LicensePlate>'.$LicensePlate.'</LicensePlate>
                            <TAR>'.$TAR.'</TAR>
                            <TID>'.$TID.'</TID>
                            <ATA>'.$ATA.'</ATA>
                            <ExpectedLane>1</ExpectedLane>
                        </TruckCall>
                        <Prenotifications>
                            <Prenotification>
                                <Container>
                                    <ContainerId>'.$ContainerId.'</ContainerId>
                                    <PositionOnTruck></PositionOnTruck>
                                    <ContainerReverse>FALSE</ContainerReverse>
                                    <LoadingStatus>'.$LoadingStatus.'</LoadingStatus>
                                    <GrossWeight>'.$GrossWeight.'</GrossWeight>
                                    <ISOCode>'.$ISOCode.'</ISOCode>
                                    <SealPresent></SealPresent>
                                    <DamagePresent>'.$DamagePresent.'</DamagePresent>
                                    <IMDGPresent></IMDGPresent>
                                    <ContainerOOG>'.$ContainerOOG.'</ContainerOOG>
                                    <ContainerDam1></ContainerDam1>
                                    <ContainerDam2></ContainerDam2>
                                    <ContainerDam3></ContainerDam3>
                                    <ContainerDam4></ContainerDam4>
                                    <ContainerDam5></ContainerDam5>
                                    <ContainerDam6></ContainerDam6>
                                    <ContainerDam7></ContainerDam7>
                                    <ContainerDam8></ContainerDam8>
                                </Container>
                            </Prenotification>
                        </Prenotifications>
                    </TruckEvent>
                </TIDRegistration_request>
            </soapenv:Body>
        </soapenv:Envelope>';

        $data = $this->restcurl($this->globurl2,$xml);
        $rawrespon = json_encode($data);
        $this->db->query("INSERT INTO `tpk_ipc`.`log_integrasi_behandle` (`type`, `no_cont`, `raw_request`, `raw_response`) VALUES ('message3b', '$arraydata->NO_CONT', '$xml', '$rawrespon')");
        return $data;

    }

    /**
     * curl buat websrevice
     */
    public function webservicecurl($url,$headers,$xml,$m)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        curl_close($ch);

        $ar1 = '<ns1:'.$m.'Response xmlns:ns1="urn:'.$m.'">';
        $ar2 = '</ns1:'.$m.'Response>';
        $arrayName = array(
            '<?xml version="1.0" encoding="ISO-8859-1"?>',
            '<SOAP-ENV:Envelope SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/">',
            '<SOAP-ENV:Body>',
            $ar1,
            '<return xsi:type="xsd:string">',
            '</return>',
            $ar2,
            '</SOAP-ENV:Body>',
            '</SOAP-ENV:Envelope>',
        );
        foreach ($arrayName as $key => $value) {
            $response = str_replace($value, '', $response);
        }
        $response =  str_replace('&lt;', '<', $response);
        $response = $string = preg_replace('/\s+/', '', $response);
        $response =  str_replace('&gt;', '>', $response);
        $json = simplexml_load_string($response);
        return $json;
    }

    /**
    * curl buat rest
    */
    public function restcurl($url,$xml)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                            'Content-type: application/xml', 
                                            'Content-length: ' . strlen($xml)
                                            ));
        $curl1_response = curl_exec($ch);
        curl_close($ch);
        $data2 =  explode(PHP_EOL, $curl1_response);
        $response = $data2[8];
        $arrayName = array(
            '<?xml version="1.0" encoding="utf-8"?>',
            '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:ser="http://cgtgos.com/">',
            '<soap:Body>',
            '</soap:Body>',
            '</soap:Envelope>'
        );
        foreach ($arrayName as $key => $value) {
            $response = str_replace($value, '', $response);
        }
        $response =  str_replace('ser:', '', $response);
        $json = simplexml_load_string($response);
        return $json;
    }

}