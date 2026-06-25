<?php defined('BASEPATH') or exit('No direct script access allowed');

class Requestgatepass extends CI_Controller
{

    private $globurl1 = 'https://api.npct1.co.id/services/index.php/ipc';
    private $globurl2 = '';
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
    public function message2a() 
    {
        //echo "message2a";
        $url = 'https://api.npct1.co.id/services/index.php/ipc';
        $headers = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "SOAPAction: https://api.npct1.co.id/services/index.php/ipc",
        );

        $tid = 'MTI-12122';
        $tar = 'QPQ238K/NPCT1';
        $nocont = 'MNBU3969937';
        $weight = '29850';

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

        $data = $this->webservicecurl($url,$headers,$xml,'get_validation');
        echo $data->status;
    }

    /**
     * mesaage 2 B
     * edphoint http://10.244.1.40:8904/goscg
     * method POST
     * media type application/XML
     * REST
     */
    public function message2b()
    {
        //echo "message2b";
        $url = 'http://10.244.1.40:8904/goscg';
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
                  <TAR>SQX789S</TAR>
                </TruckCall>
              </TruckEvent>
            </CheckAppointment_request>
          </soapenv:Body>
        </soapenv:Envelope>';


        // <soap:Envelope
        //     xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"
        //     xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/"
        //     xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        //     xmlns:xsd="http://www.w3.org/2001/XMLSchema"
        //     xmlns:ser="http://cgtgos.com/">
        //     <soap:Body>
        //         <ser:CheckAppointment_response>
        //             <ser:TruckEvent>
        //                 <ser:MessageHeader>
        //                     <ser:Sender>NPCT1</ser:Sender>
        //                     <ser:Recipient>IPC</ser:Recipient>
        //                     <ser:MessageType>TAMS</ser:MessageType>
        //                     <ser:MessageVersion>1.0.0</ser:MessageVersion>
        //                     <ser:MessageId>9990</ser:MessageId>
        //                     <ser:MessageName>CHKTARR</ser:MessageName>
        //                     <ser:MessageFunction>CREATE</ser:MessageFunction>
        //                     <ser:Terminal>NPCT1</ser:Terminal>
        //                     <ser:TruckingCompany>CIC</ser:TruckingCompany>
        //                 </ser:MessageHeader>
        //                 <ser:Status>
        //                     <ser:StatusCode>ANC</ser:StatusCode>
        //                 </ser:Status>
        //                 <ser:TruckCall>
        //                     <ser:TAR>SQX789S</ser:TAR>
        //                     <ser:AppStatus>NOK</ser:AppStatus>
        //                     <ser:ErrorCode/>
        //                 </ser:TruckCall>
        //             </ser:TruckEvent>
        //         </ser:CheckAppointment_response>
        //     </soap:Body>
        // </soap:Envelope>
    }

    /**
     * mesaage 3 A
     * edphoint https://10.244.20.14/services/index.php/ipc?wsdl
     * method set_codeco_in
     * webserivice
     */
    public function message3a() 
    {
        //echo "message3a";
        $url = 'https://api.npct1.co.id/services/index.php/ipc';
        $headers = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "SOAPAction: https://api.npct1.co.id/services/index.php/ipc",
            //"Content-length: " . strlen($xml_post_string),
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
                <ATA>20200430062107</ATA>
                <LicensePlate>B9678WG</LicensePlate>
                <TAR>ASX8558</TAR>
                <TID>18723</TID>
                <TruckingCompany />
                <TruckingWeight>12760</TruckingWeight>
            </TruckCall>
            <Prenotifications>
                <Prenotification>
                    <Container>
                        <HandlingType>OUT</HandlingType>
                        <ContainerId>UETU4044009</ContainerId>
                        <ISOCode>42G0</ISOCode>
                        <LoadingStatus>F</LoadingStatus>
                        <OriginDestination>IDJKT</OriginDestination>
                        <Vessel>MEPIS</Vessel>
                        <Voyage>029S</Voyage>
                        <ContainerCondition>No Damage</ContainerCondition>
                        <ContainerHeight>0.0</ContainerHeight>
                        <ContainerIMDGClass />
                        <ContainerLength>0.0</ContainerLength>
                        <ContainerType>DRY</ContainerType>
                        <ContainerUNnbr />
                        <CustomsReference>SPPB211193/KPU.01/2020|PIB210813</CustomsReference>
                        <DriveThrough>FALSE</DriveThrough>
                        <ETA />
                        <ATA />
                        <OrderReference />
                        <Reefer>FALSE</Reefer>
                        <ReleaseReference />
                        <Sequence>1</Sequence>
                        <GrossWeight>12760</GrossWeight>
                        <WeighingTime>20200430062107</WeighingTime>
                        <totalWeight>12760</totalWeight>
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

        $data = $this->webservicecurl($url,$headers,$xml,'set_codeco_in');
        echo $data->message;
        // <response>
        //     <message>Success</message>
        //     <desc></desc>
        // </response>
        // Response failed :

        // <response>
        //     <message>Invalid Status Code</message>
        //     <desc></desc>
        // </response>
    }

    /**
     * mesaage 3 B
     * edphoint http://10.244.1.40:8904/goscg
     * method POST
     * media type application/XML
     * REST
     */
    public function message3b()
    {
        //echo "message3b";
        $url = 'http://10.244.1.40:8904/goscg';
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
                            <LicensePlate>B9902SEH</LicensePlate>
                            <TAR>SQX789S</TAR>
                            <TID>34253</TID>
                            <ATA>2020-05-04T00:01:02+07:00</ATA>
                            <ExpectedLane>1</ExpectedLane>
                        </TruckCall>
                        <Prenotifications>
                            <Prenotification>
                                <Container>
                                    <ContainerId>MOFU5890519</ContainerId>
                                    <PositionOnTruck></PositionOnTruck>
                                    <ContainerReverse>FALSE</ContainerReverse>
                                    <LoadingStatus>F</LoadingStatus>
                                    <GrossWeight>11680</GrossWeight>
                                    <ISOCode>42G0</ISOCode>
                                    <SealPresent></SealPresent>
                                    <DamagePresent>N</DamagePresent>
                                    <IMDGPresent></IMDGPresent>
                                    <ContainerOOG>F</ContainerOOG>
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


        //     <soap:Envelope
        //     xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"
        //     xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/"
        //     xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        //     xmlns:xsd="http://www.w3.org/2001/XMLSchema"
        //     xmlns:ser="http://cgtgos.com/">
        //     <ser:TIDRegistration_response>
        //         <ser:TruckEvent>
        //             <ser:MessageHeader>
        //                 <ser:Sender>NPCT1</ser:Sender>
        //                 <ser:Recipient>IPC</ser:Recipient>
        //                 <ser:MessageType>TAMS</ser:MessageType>
        //                 <ser:MessageVersion>1.0.0</ser:MessageVersion>
        //                 <ser:MessageId>9990</ser:MessageId>
        //                 <ser:MessageName>CGPCHECK</ser:MessageName>
        //                 <ser:MessageFunction>CREATE</ser:MessageFunction>
        //                 <ser:Terminal>NPCT1</ser:Terminal>
        //                 <ser:TruckingCompany>NPCT1</ser:TruckingCompany>
        //             </ser:MessageHeader>
        //             <ser:Status>
        //                 <ser:StatusCode>ANC</ser:StatusCode>
        //             </ser:Status>
        //             <ser:TruckCall>
        //                 <ser:TAR>USD896B</ser:TAR>
        //                 <ser:AppStatus>NOK</ser:AppStatus>
        //                 <ser:ErrorCode>UNKNOWN</ser:ErrorCode>
        //             </ser:TruckCall>
        //         </ser:TruckEvent>
        //     </ser:TIDRegistration_response>
        // </soap:Body>undefined</soap:Envelope>

    }

    /**
     * curl buat websrevice
     */
    public function webservicecurl($url,$headers,$xml,$m)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
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
        $service_url1 = $url;
        $curl1 = curl_init($service_url1);
        curl_setopt($curl1, CURLOPT_RETURNTRANSFER, true);
        $arr=array("key"=>$xml);
        curl_setopt($curl1, CURLOPT_POST, 1);
        curl_setopt($curl1, CURLOPT_POSTFIELDS,$arr);
        $curl1_response = curl_exec($curl1);
        curl_close($curl1);
        return $curl1_response;
    }

}