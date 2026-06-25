<?php
defined('BASEPATH') or exit('No direct script access allowed');
include_once './vendor/autoload.php';
use Firebase\JWT\JWT;

class coba extends CI_Controller
{
    public function getsppb()
        {
            $method = 'GetImpor_Sppb';
            $xml = '';
            $SOAPAction = 'http://services.beacukai.go.id/' . $method;
            $NO_DOK_INOUT = $_GET['NO_SPPB'];
            $TGL_DOK_INOUT = $_GET['TGL_SPPB'];
            $NPWP_CONSIGNEE = $_GET['NPWP'];

            $xml = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:ser="http://services.beacukai.go.id/">
            <soap:Header/>
            <soap:Body>
            <GetImpor_Sppb xmlns="http://services.beacukai.go.id/">
                    <UserName>NCT1</UserName>
                    <Password>NCT1123456</Password>
                    <No_Sppb>'.$NO_DOK_INOUT.'</No_Sppb>
                    <Tgl_Sppb>'.$TGL_DOK_INOUT.'</Tgl_Sppb>
                    <NPWP_Imp>'.$NPWP_CONSIGNEE.'</NPWP_Imp>
                </GetImpor_Sppb>
            </soap:Body>
        </soap:Envelope>
        ';
            echo var_dump($xml);
            die(); 
            $Send = $this->SendCurl1($xml, $SOAPAction, $SOAPAction);
            if ($Send['response'] != '') {
                echo $Send['response'];
            } else {
                echo "";
            }
    }

    function SendCurl1($xml, $url, $SOAPAction) {
            $header[] = 'Content-Type: text/xml';
            $header[] = 'SOAPAction: "' . $SOAPAction . '"';
            $header[] = 'Content-length: ' . strlen($xml);
            $header[] = 'Connection: close';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            //curl_setopt($ch, CURLOPT_PORT, $port);
            //curl_setopt($ch, CURLOPT_PROXY, $proxy);
            #curl_setopt($ch, CURLOPT_VERBOSE, 0);
            #curl_setopt($ch, CURLOPT_HEADER, 0);
            #curl_setopt($ch, CURLOPT_SSLVERSION, 3);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            //curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POST, true);
            //curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            /*
            curl_setopt($ch, CURLOPT_URL, $url);
    //        curl_setopt($ch, CURLOPT_PORT, $port);
    //        curl_setopt($ch, CURLOPT_PROXY, $proxy);
            curl_setopt($ch, CURLOPT_VERBOSE, 0);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_SSLVERSION, 3);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            */
            $response = curl_exec($ch);
            if (!curl_errno($ch)) {
                $return['return'] = TRUE;
                $return['info'] = curl_getinfo($ch);
                $return['response'] = $response;
            } else {
                $return['return'] = FALSE;
                $return['info'] = curl_error($ch);
                $return['response'] = '';
            }
            return $return;
        }
        
        function WhiteSpaceXML($text) {

        $hasil = str_replace("&amp;"," ",$text);
        $hasil = str_replace("&apos;"," ",$hasil);
        $hasil = str_replace("&"," ",$hasil);
        $hasil = str_replace("'"," ",$hasil);
        //$hasil = str_replace("\"","&quot;",$hasil);
        //$hasil = str_replace("<","&lt;",$hasil);
        //$hasil = str_replace(">","&gt;",$hasil);  
        return $hasil;
    }
}