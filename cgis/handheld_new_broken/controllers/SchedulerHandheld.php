<?php defined('BASEPATH') or exit('No direct script access allowed');
class SchedulerHandheld extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }
    //NOTE sceduler get data reefer
    /**
     * tarik data reefer dari npct1 untuk bisa plug di ca
     */
    public function getreefernpct1()
    {
        $q = $this->db->query("SELECT B.ID,B.TIPE_CONT,B.NO_CONT,B.KD_STATUS,B.FL_RFR_DONE,A.STATUS_CONT,A.TGL_SPK,A.KD_STATUS,A.LOKASI FROM (
            SELECT a.NO_DOK,a.TGL_DOK,a.NO_SPK,b.NO_CONT,b.STATUS_CONT,a.TGL_SPK,a.KD_STATUS,b.LOKASI FROM t_spk a JOIN t_spk_cont b ON a.ID = b.ID ) A
        JOIN (
            SELECT d.ID,c.NO_DOK,c.TGL_DOK,d.NO_CONT,d.UKR_CONT,d.TIPE_CONT,d.KD_CONT_JENIS,d.KD_STATUS,d.FL_RFR_DONE FROM t_request c JOIN t_request_cont d ON c.ID = d.ID) B ON A.NO_DOK AND B.NO_DOK AND A.TGL_DOK = B.TGL_DOK AND A.NO_CONT = B.NO_CONT
        WHERE B.TIPE_CONT = 'RFR' and B.FL_RFR_DONE = 'N' AND A.KD_STATUS = '500' AND MONTH(A.TGL_SPK) >= 3 AND YEAR(A.TGL_SPK) = 2020");


        $nocon11 = "";
        foreach ($q->result() as $key => $value1) {
            $nocon11 = $value1->NO_CONT;
            $soapUrl = "https://api.npct1.co.id/services/index.php/behandle"; // asmx URL of WSDL

            $xml_post_string = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:trackingContainers">
                                <soapenv:Header/>
                                <soapenv:Body>
                                    <urn:trackingContainers soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
                                        <username xsi:type="xsd:string">CGO</username>
                                        <password xsi:type="xsd:string">CGO@2017</password>
                                        <xml xsi:type="xsd:string"><![CDATA[
                                                                <request>
                                                                <containers>
                                                                    <cont_no>'.$value1->NO_CONT.'</cont_no>
                                                                </containers>
                                                            </request>
                                                            ]]></xml>
                                    </urn:trackingContainers>
                                </soapenv:Body>
                                </soapenv:Envelope>'; // data from the form, e.g. some ID number

            $headers = array(
                "Content-type: text/xml;charset=\"utf-8\"",
                "Accept: text/xml",
                "Cache-Control: no-cache",
                "Pragma: no-cache",
                "SOAPAction: https://api.npct1.co.id/services/index.php/behandle",
                //"Content-length: " . strlen($xml_post_string),
            ); //SOAPAction: your op URL
            $url = $soapUrl;
            // PHP cURL  for https connection with auth
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $response = curl_exec($ch);
            curl_close($ch);
            $arrayName = array(
                '<SOAP-ENV:Body>',
                '<ns1:trackingContainersResponse xmlns:ns1="urn:trackingContainers">',
                '<return xsi:type="xsd:string">',
                '</return>',
                '</ns1:trackingContainersResponse>',
                '</SOAP-ENV:Body>',
                //'</SOAP-ENV:Envelope>'
            );
            foreach ($arrayName as $key => $value) {
                $response = str_replace($value, '', $response);
            }
            
        $xml = simplexml_load_string($response);
        header('content-Type: application/json');
        $xml = simplexml_load_string($xml);
        $raw = json_encode($xml);
            $VESSEL_NAME = $xml->LOOP->VESSEL_NAME;
            $CALL_SIGN = $xml->LOOP->CALL_SIGN;
            $VOYAGE_IN = $xml->LOOP->VOYAGE_IN;
            $VOYAGE_OUT = $xml->LOOP->VOYAGE_OUT;
            $SIZE = $xml->LOOP->CONT_SIZE;
            $JENIS = $xml->LOOP->CONT_STATUS;
            $slice = substr($SIZE, 0, 2);
            $ISOCODE = $xml->LOOP->ISOCODE;
            $REQ_TEMP = $xml->LOOP->REEFER_REQ_TEMP;
            $ACT_TEMP = $xml->LOOP->REEFER_ACT_TEMP;
            $PLUG = $xml->LOOP->REEFER_PLUG_IN;
            $UNPLUG = $xml->LOOP->REEFER_PLUG_OUT;
            $REEFER = $xml->LOOP->REEFER;
            $IMDG = $xml->LOOP->IMDG;
            $DISCHARGE = $xml->LOOP->DISCHARGE;
            $tgl_bongkar = date_format(new DateTime($DISCHARGE), 'Y-m-d H:i:s');
            $OOG = $xml->LOOP->OOG;
            $HOLD = $xml->LOOP->HOLD;
            $ON_YARD = $xml->LOOP->ON_YARD;

            if ($ON_YARD == 'OK') {
                $STAT = 'Y';
            } else {
                $STAT = 'N';
            }

            $ID = $value1->ID;
            $NO_CONT = $value1->NO_CONT;
            if ($PLUG != null or $PLUG != "") {
                $PLUGIN = date_format(new DateTime($PLUG), 'Y-m-d H:i:s');
                $PLUGIN_MOD = "PLUG_TERMINAL='$PLUGIN'";
            } else {
                $PLUGIN = NULL;
                $PLUGIN_MOD = "PLUG_TERMINAL=NULL";
            }

            if ($UNPLUG != null or $UNPLUG != "") {
                $UNPLUGIN = date_format(new DateTime($UNPLUG), 'Y-m-d H:i:s');
                $UNPLUGIN_MOD = "UNPLUG_TERMINAL='$UNPLUGIN'";
            } else {
                $UNPLUGIN = NULL;
                $UNPLUGIN_MOD = "UNPLUG_TERMINAL=NULL";
            }

            if ($DISCHARGE != null or $UNPLUG != "") {
                $DISCHARGE = date_format(new DateTime($DISCHARGE), 'Y-m-d H:i:s');
                $DISCHARGE_MOD = "DISCHARGE='$DISCHARGE'";
            } else {
                $DISCHARGE = NULL;
                $DISCHARGE_MOD = "DISCHARGE=NULL";
            }

            if ($REEFER == 'Y') {
                $SQL = "UPDATE t_request_cont SET FL_RFR_DONE = 'Y', TIPE_CONT = 'RFR', KD_CONT_JENIS='$JENIS', UKR_CONT='$slice', VESSEL='$VESSEL_NAME', CALL_SIGN='$CALL_SIGN', VOY_IN='$VOYAGE_IN', VOY_OUT='$VOYAGE_OUT', ISO_CODE='$ISOCODE', $DISCHARGE_MOD, TEMP_CUST='$REQ_TEMP', TEMP_TERMINAL='$ACT_TEMP', $PLUGIN_MOD, $UNPLUGIN_MOD, FL_REEFER='$REEFER', FL_DG='$IMDG', FL_OOG='$OOG', HOLD='$HOLD', FL_YARD='$STAT', FL_TRACK='Y' WHERE ID = '".$ID."' AND NO_CONT = '".$NO_CONT."'";
            }else if ($REEFER == 'N') {
                $SQL = "UPDATE t_request_cont SET FL_RFR_DONE = 'Y', TIPE_CONT = 'DRY', KD_CONT_JENIS='$JENIS', UKR_CONT='$slice', VESSEL='$VESSEL_NAME', CALL_SIGN='$CALL_SIGN', VOY_IN='$VOYAGE_IN', VOY_OUT='$VOYAGE_OUT', ISO_CODE='$ISOCODE', $DISCHARGE_MOD, $PLUGIN_MOD, $UNPLUGIN_MOD, FL_REEFER='$REEFER', FL_DG='$IMDG', FL_OOG='$OOG', HOLD='$HOLD', FL_YARD='$STAT', FL_TRACK='Y' WHERE ID = '".$ID."' AND NO_CONT = '".$NO_CONT."'";
            }else{
                $SQL = "UPDATE t_request_cont SET FL_TRACK='Y' WHERE ID = '".$ID."' AND NO_CONT = '".$NO_CONT."'";
            }
            $this->db->query($SQL);
            echo $SQL."\r\n";
            //die();
        }
    }
    // update t_request_cont - get yang belum di tarck 
    /**
     * 
     */
    public function getreefernpct1_trequest_N()
    {
        $q = $this->db->query("SELECT * FROM (SELECT * FROM t_request_cont
        WHERE date(tgl_status) >= DATE_ADD(NOW() , INTERVAL -35 DAY)) az
        WHERE fl_track = 'N'");


        $nocon11 = "";
        foreach ($q->result() as $key => $value1) {
            $nocon11 = $value1->NO_CONT;
            $soapUrl = "https://api.npct1.co.id/services/index.php/behandle"; // asmx URL of WSDL

            $xml_post_string = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:trackingContainers">
                                <soapenv:Header/>
                                <soapenv:Body>
                                    <urn:trackingContainers soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
                                        <username xsi:type="xsd:string">CGO</username>
                                        <password xsi:type="xsd:string">CGO@2017</password>
                                        <xml xsi:type="xsd:string"><![CDATA[
                                                                <request>
                                                                <containers>
                                                                    <cont_no>'.$value1->NO_CONT.'</cont_no>
                                                                </containers>
                                                            </request>
                                                            ]]></xml>
                                    </urn:trackingContainers>
                                </soapenv:Body>
                                </soapenv:Envelope>'; // data from the form, e.g. some ID number

            $headers = array(
                "Content-type: text/xml;charset=\"utf-8\"",
                "Accept: text/xml",
                "Cache-Control: no-cache",
                "Pragma: no-cache",
                "SOAPAction: https://api.npct1.co.id/services/index.php/behandle",
                //"Content-length: " . strlen($xml_post_string),
            ); //SOAPAction: your op URL
            $url = $soapUrl;
            // PHP cURL  for https connection with auth
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $response = curl_exec($ch);
            curl_close($ch);
            $arrayName = array(
                '<SOAP-ENV:Body>',
                '<ns1:trackingContainersResponse xmlns:ns1="urn:trackingContainers">',
                '<return xsi:type="xsd:string">',
                '</return>',
                '</ns1:trackingContainersResponse>',
                '</SOAP-ENV:Body>',
                //'</SOAP-ENV:Envelope>'
            );
            foreach ($arrayName as $key => $value) {
                $response = str_replace($value, '', $response);
            }
            
        $xml = simplexml_load_string($response);
        header('content-Type: application/json');
        $xml = simplexml_load_string($xml);
        $raw = json_encode($xml);
            $VESSEL_NAME = $xml->LOOP->VESSEL_NAME;
            $CALL_SIGN = $xml->LOOP->CALL_SIGN;
            $VOYAGE_IN = $xml->LOOP->VOYAGE_IN;
            $VOYAGE_OUT = $xml->LOOP->VOYAGE_OUT;
            $SIZE = $xml->LOOP->CONT_SIZE;
            $JENIS = $xml->LOOP->CONT_STATUS;
            $slice = substr($SIZE, 0, 2);
            $ISOCODE = $xml->LOOP->ISOCODE;
            $REQ_TEMP = $xml->LOOP->REEFER_REQ_TEMP;
            $ACT_TEMP = $xml->LOOP->REEFER_ACT_TEMP;
            $PLUG = $xml->LOOP->REEFER_PLUG_IN;
            $UNPLUG = $xml->LOOP->REEFER_PLUG_OUT;
            $REEFER = $xml->LOOP->REEFER;
            $IMDG = $xml->LOOP->IMDG;
            $DISCHARGE = $xml->LOOP->DISCHARGE;
            $tgl_bongkar = date_format(new DateTime($DISCHARGE), 'Y-m-d H:i:s');
            $OOG = $xml->LOOP->OOG;
            $HOLD = $xml->LOOP->HOLD;
            $ON_YARD = $xml->LOOP->ON_YARD;

            if ($ON_YARD == 'OK') {
                $STAT = 'Y';
            } else {
                $STAT = 'N';
            }

            $ID = $value1->ID;
            $NO_CONT = $value1->NO_CONT;
            if ($PLUG != null or $PLUG != "") {
                $PLUGIN = date_format(new DateTime($PLUG), 'Y-m-d H:i:s');
                $PLUGIN_MOD = "PLUG_TERMINAL='$PLUGIN'";
            } else {
                $PLUGIN = NULL;
                $PLUGIN_MOD = "PLUG_TERMINAL=NULL";
            }

            if ($UNPLUG != null or $UNPLUG != "") {
                $UNPLUGIN = date_format(new DateTime($UNPLUG), 'Y-m-d H:i:s');
                $UNPLUGIN_MOD = "UNPLUG_TERMINAL='$UNPLUGIN'";
            } else {
                $UNPLUGIN = NULL;
                $UNPLUGIN_MOD = "UNPLUG_TERMINAL=NULL";
            }

            if ($DISCHARGE != null or $UNPLUG != "") {
                $DISCHARGE = date_format(new DateTime($DISCHARGE), 'Y-m-d H:i:s');
                $DISCHARGE_MOD = "DISCHARGE='$DISCHARGE'";
            } else {
                $DISCHARGE = NULL;
                $DISCHARGE_MOD = "DISCHARGE=NULL";
            }

            if ($REEFER == 'Y') {
                $SQL = "UPDATE t_request_cont SET FL_INQUIRY_DONE = 'Y', TIPE_CONT = 'RFR', KD_CONT_JENIS='$JENIS', UKR_CONT='$slice', VESSEL='$VESSEL_NAME', CALL_SIGN='$CALL_SIGN', VOY_IN='$VOYAGE_IN', VOY_OUT='$VOYAGE_OUT', ISO_CODE='$ISOCODE', $DISCHARGE_MOD, TEMP_CUST='$REQ_TEMP', TEMP_TERMINAL='$ACT_TEMP', $PLUGIN_MOD, $UNPLUGIN_MOD, FL_REEFER='$REEFER', FL_DG='$IMDG', FL_OOG='$OOG', HOLD='$HOLD', FL_YARD='$STAT', FL_TRACK='Y' WHERE ID = '".$ID."' AND NO_CONT = '".$NO_CONT."'";
            }else if ($REEFER == 'N') {
                $SQL = "UPDATE t_request_cont SET FL_INQUIRY_DONE = 'Y', TIPE_CONT = 'DRY', KD_CONT_JENIS='$JENIS', UKR_CONT='$slice', VESSEL='$VESSEL_NAME', CALL_SIGN='$CALL_SIGN', VOY_IN='$VOYAGE_IN', VOY_OUT='$VOYAGE_OUT', ISO_CODE='$ISOCODE', $DISCHARGE_MOD, $PLUGIN_MOD, $UNPLUGIN_MOD, FL_REEFER='$REEFER', FL_DG='$IMDG', FL_OOG='$OOG', HOLD='$HOLD', FL_YARD='$STAT', FL_TRACK='Y' WHERE ID = '".$ID."' AND NO_CONT = '".$NO_CONT."'";
            }else{
                $SQL = "UPDATE t_request_cont SET FL_TRACK='Y' WHERE ID = '".$ID."' AND NO_CONT = '".$NO_CONT."'";
            }
            $this->db->query($SQL);
            echo date("d-m-Y H:i:s")." # ".$response."\r\n";
            //die();
        }

    }
    // update t_request_cont - get yang sudah di tarck dan sudah inquiry 
    /**
     * 
     */
    public function getreefernpct1_trequest_Y()
    {
        $q = $this->db->query("SELECT A.*,B.STATUS_CONT FROM (
            SELECT a.id,a.NO_DOK,a.TGL_DOK,b.NO_CONT,b.FL_TRACK,b.KD_STATUS,b.FL_INQUIRY_DONE FROM t_request a JOIN t_request_cont b ON a.id = b.id and fl_track = 'Y' AND b.kd_status = 'INQUIRY' AND b.FL_RFR_DONE = 'N' and b.TIPE_CONT = 'RFR') A
        JOIN (
            SELECT a.NO_DOK,a.TGL_DOK,b.NO_CONT,b.STATUS_CONT FROM t_spk a JOIN t_spk_cont b ON a.id = b.id  AND b.STATUS_CONT >= 450) B 
        ON A.no_dok = B.no_dok AND A.no_cont = B.no_cont
        WHERE DATE(A.TGL_DOK) >= DATE_ADD(NOW() , INTERVAL -30 DAY)");


        $nocon11 = "";
        foreach ($q->result() as $key => $value1) {
            $nocon11 = $value1->NO_CONT;
            $soapUrl = "https://api.npct1.co.id/services/index.php/behandle"; // asmx URL of WSDL

            $xml_post_string = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:trackingContainers">
                                <soapenv:Header/>
                                <soapenv:Body>
                                    <urn:trackingContainers soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
                                        <username xsi:type="xsd:string">CGO</username>
                                        <password xsi:type="xsd:string">CGO@2017</password>
                                        <xml xsi:type="xsd:string"><![CDATA[
                                                                <request>
                                                                <containers>
                                                                    <cont_no>'.$value1->NO_CONT.'</cont_no>
                                                                </containers>
                                                            </request>
                                                            ]]></xml>
                                    </urn:trackingContainers>
                                </soapenv:Body>
                                </soapenv:Envelope>'; // data from the form, e.g. some ID number

            $headers = array(
                "Content-type: text/xml;charset=\"utf-8\"",
                "Accept: text/xml",
                "Cache-Control: no-cache",
                "Pragma: no-cache",
                "SOAPAction: https://api.npct1.co.id/services/index.php/behandle",
                //"Content-length: " . strlen($xml_post_string),
            ); //SOAPAction: your op URL
            $url = $soapUrl;
            // PHP cURL  for https connection with auth
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $response = curl_exec($ch);
            curl_close($ch);
            $arrayName = array(
                '<SOAP-ENV:Body>',
                '<ns1:trackingContainersResponse xmlns:ns1="urn:trackingContainers">',
                '<return xsi:type="xsd:string">',
                '</return>',
                '</ns1:trackingContainersResponse>',
                '</SOAP-ENV:Body>',
                //'</SOAP-ENV:Envelope>'
            );
            foreach ($arrayName as $key => $value) {
                $response = str_replace($value, '', $response);
            }
            
        $xml = simplexml_load_string($response);
        header('content-Type: application/json');
        $xml = simplexml_load_string($xml);
        $raw = json_encode($xml);
            $VESSEL_NAME = $xml->LOOP->VESSEL_NAME;
            $CALL_SIGN = $xml->LOOP->CALL_SIGN;
            $VOYAGE_IN = $xml->LOOP->VOYAGE_IN;
            $VOYAGE_OUT = $xml->LOOP->VOYAGE_OUT;
            $SIZE = $xml->LOOP->CONT_SIZE;
            $JENIS = $xml->LOOP->CONT_STATUS;
            $slice = substr($SIZE, 0, 2);
            $ISOCODE = $xml->LOOP->ISOCODE;
            $REQ_TEMP = $xml->LOOP->REEFER_REQ_TEMP;
            $ACT_TEMP = $xml->LOOP->REEFER_ACT_TEMP;
            $PLUG = $xml->LOOP->REEFER_PLUG_IN;
            $UNPLUG = $xml->LOOP->REEFER_PLUG_OUT;
            $REEFER = $xml->LOOP->REEFER;
            $IMDG = $xml->LOOP->IMDG;
            $DISCHARGE = $xml->LOOP->DISCHARGE;
            $tgl_bongkar = date_format(new DateTime($DISCHARGE), 'Y-m-d H:i:s');
            $OOG = $xml->LOOP->OOG;
            $HOLD = $xml->LOOP->HOLD;
            $ON_YARD = $xml->LOOP->ON_YARD;

            if ($ON_YARD == 'OK') {
                $STAT = 'Y';
            } else {
                $STAT = 'N';
            }

            $ID = $value1->id;
            $NO_CONT = $value1->NO_CONT;
            if ($PLUG != null or $PLUG != "") {
                $PLUGIN = date_format(new DateTime($PLUG), 'Y-m-d H:i:s');
                $PLUGIN_MOD = "PLUG_TERMINAL='$PLUGIN'";
            } else {
                $PLUGIN = NULL;
                $PLUGIN_MOD = "PLUG_TERMINAL=NULL";
            }

            if ($UNPLUG != null or $UNPLUG != "") {
                $UNPLUGIN = date_format(new DateTime($UNPLUG), 'Y-m-d H:i:s');
                $UNPLUGIN_MOD = "UNPLUG_TERMINAL='$UNPLUGIN'";
            } else {
                $UNPLUGIN = NULL;
                $UNPLUGIN_MOD = "UNPLUG_TERMINAL=NULL";
            }

            if ($DISCHARGE != null or $UNPLUG != "") {
                $DISCHARGE = date_format(new DateTime($DISCHARGE), 'Y-m-d H:i:s');
                $DISCHARGE_MOD = "DISCHARGE='$DISCHARGE'";
            } else {
                $DISCHARGE = NULL;
                $DISCHARGE_MOD = "DISCHARGE=NULL";
            }

            if ($REEFER == 'Y') {
                $SQL = "UPDATE t_request_cont SET FL_RFR_DONE = 'Y', FL_INQUIRY_DONE = 'Y', TIPE_CONT = 'RFR', KD_CONT_JENIS='$JENIS', UKR_CONT='$slice', VESSEL='$VESSEL_NAME', CALL_SIGN='$CALL_SIGN', VOY_IN='$VOYAGE_IN', VOY_OUT='$VOYAGE_OUT', ISO_CODE='$ISOCODE', $DISCHARGE_MOD, TEMP_CUST='$REQ_TEMP', TEMP_TERMINAL='$ACT_TEMP', $PLUGIN_MOD, $UNPLUGIN_MOD, FL_REEFER='$REEFER', FL_DG='$IMDG', FL_OOG='$OOG', HOLD='$HOLD', FL_YARD='$STAT', FL_TRACK='Y' WHERE ID = '".$ID."' AND NO_CONT = '".$NO_CONT."'";
            }else if ($REEFER == 'N') {
                $SQL = "UPDATE t_request_cont SET FL_RFR_DONE = 'Y', FL_INQUIRY_DONE = 'Y', TIPE_CONT = 'DRY', KD_CONT_JENIS='$JENIS', UKR_CONT='$slice', VESSEL='$VESSEL_NAME', CALL_SIGN='$CALL_SIGN', VOY_IN='$VOYAGE_IN', VOY_OUT='$VOYAGE_OUT', ISO_CODE='$ISOCODE', $DISCHARGE_MOD, $PLUGIN_MOD, $UNPLUGIN_MOD, FL_REEFER='$REEFER', FL_DG='$IMDG', FL_OOG='$OOG', HOLD='$HOLD', FL_YARD='$STAT', FL_TRACK='Y' WHERE ID = '".$ID."' AND NO_CONT = '".$NO_CONT."'";
            }else{
                $SQL = "UPDATE t_request_cont SET FL_TRACK='Y' WHERE ID = '".$ID."' AND NO_CONT = '".$NO_CONT."'";
            }
            $this->db->query($SQL);
            echo date("d-m-Y H:i:s")." # ".$response."\r\n";
            //die();
        }

    }
    // update t_request_cont - get data sudah yard before 
    /**
     * 
     */
    public function getreefernpct1_trequest_B()
    {
        $q = $this->db->query("SELECT * FROM (SELECT * FROM t_request_cont
        WHERE date(tgl_status) >= DATE_ADD(NOW() , INTERVAL -10 DAY) AND tipe_cont = 'RFR') az
        WHERE fl_track = 'Y' AND kd_status = 'INQUIRY' AND fl_inquiry_done = 'Y' AND unplug_terminal IS null");


        $nocon11 = "";
        foreach ($q->result() as $key => $value1) {
            $nocon11 = $value1->NO_CONT;
            $soapUrl = "https://api.npct1.co.id/services/index.php/behandle"; // asmx URL of WSDL

            $xml_post_string = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:trackingContainers">
                                <soapenv:Header/>
                                <soapenv:Body>
                                    <urn:trackingContainers soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
                                        <username xsi:type="xsd:string">CGO</username>
                                        <password xsi:type="xsd:string">CGO@2017</password>
                                        <xml xsi:type="xsd:string"><![CDATA[
                                                                <request>
                                                                <containers>
                                                                    <cont_no>'.$value1->NO_CONT.'</cont_no>
                                                                </containers>
                                                            </request>
                                                            ]]></xml>
                                    </urn:trackingContainers>
                                </soapenv:Body>
                                </soapenv:Envelope>'; // data from the form, e.g. some ID number

            $headers = array(
                "Content-type: text/xml;charset=\"utf-8\"",
                "Accept: text/xml",
                "Cache-Control: no-cache",
                "Pragma: no-cache",
                "SOAPAction: https://api.npct1.co.id/services/index.php/behandle",
                //"Content-length: " . strlen($xml_post_string),
            ); //SOAPAction: your op URL
            $url = $soapUrl;
            // PHP cURL  for https connection with auth
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $response = curl_exec($ch);
            curl_close($ch);
            $arrayName = array(
                '<SOAP-ENV:Body>',
                '<ns1:trackingContainersResponse xmlns:ns1="urn:trackingContainers">',
                '<return xsi:type="xsd:string">',
                '</return>',
                '</ns1:trackingContainersResponse>',
                '</SOAP-ENV:Body>',
                //'</SOAP-ENV:Envelope>'
            );
            foreach ($arrayName as $key => $value) {
                $response = str_replace($value, '', $response);
            }
            
        $xml = simplexml_load_string($response);
        header('content-Type: application/json');
        $xml = simplexml_load_string($xml);
        $raw = json_encode($xml);
            $VESSEL_NAME = $xml->LOOP->VESSEL_NAME;
            $CALL_SIGN = $xml->LOOP->CALL_SIGN;
            $VOYAGE_IN = $xml->LOOP->VOYAGE_IN;
            $VOYAGE_OUT = $xml->LOOP->VOYAGE_OUT;
            $SIZE = $xml->LOOP->CONT_SIZE;
            $JENIS = $xml->LOOP->CONT_STATUS;
            $slice = substr($SIZE, 0, 2);
            $ISOCODE = $xml->LOOP->ISOCODE;
            $REQ_TEMP = $xml->LOOP->REEFER_REQ_TEMP;
            $ACT_TEMP = $xml->LOOP->REEFER_ACT_TEMP;
            $PLUG = $xml->LOOP->REEFER_PLUG_IN;
            $UNPLUG = $xml->LOOP->REEFER_PLUG_OUT;
            $REEFER = $xml->LOOP->REEFER;
            $IMDG = $xml->LOOP->IMDG;
            $DISCHARGE = $xml->LOOP->DISCHARGE;
            $tgl_bongkar = date_format(new DateTime($DISCHARGE), 'Y-m-d H:i:s');
            $OOG = $xml->LOOP->OOG;
            $HOLD = $xml->LOOP->HOLD;
            $ON_YARD = $xml->LOOP->ON_YARD;

            if ($ON_YARD == 'OK') {
                $STAT = 'Y';
            } else {
                $STAT = 'N';
            }

            $ID = $value1->ID;
            $NO_CONT = $value1->NO_CONT;
            if ($PLUG != null or $PLUG != "") {
                $PLUGIN = date_format(new DateTime($PLUG), 'Y-m-d H:i:s');
                $PLUGIN_MOD = "PLUG_TERMINAL='$PLUGIN'";
            } else {
                $PLUGIN = NULL;
                $PLUGIN_MOD = "PLUG_TERMINAL=NULL";
            }

            if ($UNPLUG != null or $UNPLUG != "") {
                $UNPLUGIN = date_format(new DateTime($UNPLUG), 'Y-m-d H:i:s');
                $UNPLUGIN_MOD = "UNPLUG_TERMINAL='$UNPLUGIN'";
            } else {
                $UNPLUGIN = NULL;
                $UNPLUGIN_MOD = "UNPLUG_TERMINAL=NULL";
            }

            if ($DISCHARGE != null or $UNPLUG != "") {
                $DISCHARGE = date_format(new DateTime($DISCHARGE), 'Y-m-d H:i:s');
                $DISCHARGE_MOD = "DISCHARGE='$DISCHARGE'";
            } else {
                $DISCHARGE = NULL;
                $DISCHARGE_MOD = "DISCHARGE=NULL";
            }

            if ($REEFER == 'Y') {
                $SQL = "UPDATE t_request_cont SET FL_INQUIRY_DONE = 'Y', TIPE_CONT = 'RFR', KD_CONT_JENIS='$JENIS', UKR_CONT='$slice', VESSEL='$VESSEL_NAME', CALL_SIGN='$CALL_SIGN', VOY_IN='$VOYAGE_IN', VOY_OUT='$VOYAGE_OUT', ISO_CODE='$ISOCODE', $DISCHARGE_MOD, TEMP_CUST='$REQ_TEMP', TEMP_TERMINAL='$ACT_TEMP', $PLUGIN_MOD, $UNPLUGIN_MOD, FL_REEFER='$REEFER', FL_DG='$IMDG', FL_OOG='$OOG', HOLD='$HOLD', FL_YARD='$STAT', FL_TRACK='Y' WHERE ID = '".$ID."' AND NO_CONT = '".$NO_CONT."'";
            }else if ($REEFER == 'N') {
                $SQL = "UPDATE t_request_cont SET FL_INQUIRY_DONE = 'Y', TIPE_CONT = 'DRY', KD_CONT_JENIS='$JENIS', UKR_CONT='$slice', VESSEL='$VESSEL_NAME', CALL_SIGN='$CALL_SIGN', VOY_IN='$VOYAGE_IN', VOY_OUT='$VOYAGE_OUT', ISO_CODE='$ISOCODE', $DISCHARGE_MOD, $PLUGIN_MOD, $UNPLUGIN_MOD, FL_REEFER='$REEFER', FL_DG='$IMDG', FL_OOG='$OOG', HOLD='$HOLD', FL_YARD='$STAT', FL_TRACK='Y' WHERE ID = '".$ID."' AND NO_CONT = '".$NO_CONT."'";
            }else{
                $SQL = "UPDATE t_request_cont SET FL_TRACK='Y' WHERE ID = '".$ID."' AND NO_CONT = '".$NO_CONT."'";
            }
            $this->db->query($SQL);
            echo date("d-m-Y H:i:s")." # ".$response."\r\n";
            //die();
        }

    }
    // update t_request_cont - Rekon Data yang sudah di track belum inquiri tapi data tidak lengkap
    /**
     * 
     */
    public function getreefernpct1_trequest_R()
    {
        $q = $this->db->query("SELECT * FROM (SELECT * FROM t_request_cont
        WHERE date(tgl_status) >= DATE_ADD(NOW() , INTERVAL -10 DAY)) az
        WHERE fl_track = 'Y' and FL_YARD = 'N' AND tipe_cont IS NULL AND kd_cont_jenis IS null AND kd_status <> 'INQUIRY'");


        $nocon11 = "";
        foreach ($q->result() as $key => $value1) {
            $nocon11 = $value1->NO_CONT;
            $soapUrl = "https://api.npct1.co.id/services/index.php/behandle"; // asmx URL of WSDL

            $xml_post_string = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:trackingContainers">
                                <soapenv:Header/>
                                <soapenv:Body>
                                    <urn:trackingContainers soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
                                        <username xsi:type="xsd:string">CGO</username>
                                        <password xsi:type="xsd:string">CGO@2017</password>
                                        <xml xsi:type="xsd:string"><![CDATA[
                                                                <request>
                                                                <containers>
                                                                    <cont_no>'.$value1->NO_CONT.'</cont_no>
                                                                </containers>
                                                            </request>
                                                            ]]></xml>
                                    </urn:trackingContainers>
                                </soapenv:Body>
                                </soapenv:Envelope>'; // data from the form, e.g. some ID number

            $headers = array(
                "Content-type: text/xml;charset=\"utf-8\"",
                "Accept: text/xml",
                "Cache-Control: no-cache",
                "Pragma: no-cache",
                "SOAPAction: https://api.npct1.co.id/services/index.php/behandle",
                //"Content-length: " . strlen($xml_post_string),
            ); //SOAPAction: your op URL
            $url = $soapUrl;
            // PHP cURL  for https connection with auth
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $response = curl_exec($ch);
            curl_close($ch);
            $arrayName = array(
                '<SOAP-ENV:Body>',
                '<ns1:trackingContainersResponse xmlns:ns1="urn:trackingContainers">',
                '<return xsi:type="xsd:string">',
                '</return>',
                '</ns1:trackingContainersResponse>',
                '</SOAP-ENV:Body>',
                //'</SOAP-ENV:Envelope>'
            );
            foreach ($arrayName as $key => $value) {
                $response = str_replace($value, '', $response);
            }
            
        $xml = simplexml_load_string($response);
        header('content-Type: application/json');
        $xml = simplexml_load_string($xml);
        $raw = json_encode($xml);
            $VESSEL_NAME = $xml->LOOP->VESSEL_NAME;
            $CALL_SIGN = $xml->LOOP->CALL_SIGN;
            $VOYAGE_IN = $xml->LOOP->VOYAGE_IN;
            $VOYAGE_OUT = $xml->LOOP->VOYAGE_OUT;
            $SIZE = $xml->LOOP->CONT_SIZE;
            $JENIS = $xml->LOOP->CONT_STATUS;
            $slice = substr($SIZE, 0, 2);
            $ISOCODE = $xml->LOOP->ISOCODE;
            $REQ_TEMP = $xml->LOOP->REEFER_REQ_TEMP;
            $ACT_TEMP = $xml->LOOP->REEFER_ACT_TEMP;
            $PLUG = $xml->LOOP->REEFER_PLUG_IN;
            $UNPLUG = $xml->LOOP->REEFER_PLUG_OUT;
            $REEFER = $xml->LOOP->REEFER;
            $IMDG = $xml->LOOP->IMDG;
            $DISCHARGE = $xml->LOOP->DISCHARGE;
            $tgl_bongkar = date_format(new DateTime($DISCHARGE), 'Y-m-d H:i:s');
            $OOG = $xml->LOOP->OOG;
            $HOLD = $xml->LOOP->HOLD;
            $ON_YARD = $xml->LOOP->ON_YARD;

            if ($ON_YARD == 'OK') {
                $STAT = 'Y';
            } else {
                $STAT = 'N';
            }

            $ID = $value1->ID;
            $NO_CONT = $value1->NO_CONT;
            if ($PLUG != null or $PLUG != "") {
                $PLUGIN = date_format(new DateTime($PLUG), 'Y-m-d H:i:s');
                $PLUGIN_MOD = "PLUG_TERMINAL='$PLUGIN'";
            } else {
                $PLUGIN = NULL;
                $PLUGIN_MOD = "PLUG_TERMINAL=NULL";
            }

            if ($UNPLUG != null or $UNPLUG != "") {
                $UNPLUGIN = date_format(new DateTime($UNPLUG), 'Y-m-d H:i:s');
                $UNPLUGIN_MOD = "UNPLUG_TERMINAL='$UNPLUGIN'";
            } else {
                $UNPLUGIN = NULL;
                $UNPLUGIN_MOD = "UNPLUG_TERMINAL=NULL";
            }

            if ($DISCHARGE != null or $UNPLUG != "") {
                $DISCHARGE = date_format(new DateTime($DISCHARGE), 'Y-m-d H:i:s');
                $DISCHARGE_MOD = "DISCHARGE='$DISCHARGE'";
            } else {
                $DISCHARGE = NULL;
                $DISCHARGE_MOD = "DISCHARGE=NULL";
            }

            if ($REEFER == 'Y') {
                $SQL = "UPDATE t_request_cont SET TIPE_CONT = 'RFR', KD_CONT_JENIS='$JENIS', UKR_CONT='$slice', VESSEL='$VESSEL_NAME', CALL_SIGN='$CALL_SIGN', VOY_IN='$VOYAGE_IN', VOY_OUT='$VOYAGE_OUT', ISO_CODE='$ISOCODE', $DISCHARGE_MOD, TEMP_CUST='$REQ_TEMP', TEMP_TERMINAL='$ACT_TEMP', $PLUGIN_MOD, $UNPLUGIN_MOD, FL_REEFER='$REEFER', FL_DG='$IMDG', FL_OOG='$OOG', HOLD='$HOLD', FL_YARD='$STAT', FL_TRACK='Y' WHERE ID = '".$ID."' AND NO_CONT = '".$NO_CONT."'";
            }else if ($REEFER == 'N') {
                $SQL = "UPDATE t_request_cont SET TIPE_CONT = 'DRY', KD_CONT_JENIS='$JENIS', UKR_CONT='$slice', VESSEL='$VESSEL_NAME', CALL_SIGN='$CALL_SIGN', VOY_IN='$VOYAGE_IN', VOY_OUT='$VOYAGE_OUT', ISO_CODE='$ISOCODE', $DISCHARGE_MOD, $PLUGIN_MOD, $UNPLUGIN_MOD, FL_REEFER='$REEFER', FL_DG='$IMDG', FL_OOG='$OOG', HOLD='$HOLD', FL_YARD='$STAT', FL_TRACK='Y' WHERE ID = '".$ID."' AND NO_CONT = '".$NO_CONT."'";
            }else{
                $SQL = "UPDATE t_request_cont SET FL_TRACK='Y' WHERE ID = '".$ID."' AND NO_CONT = '".$NO_CONT."'";
            }

            if ($ON_YARD == 'OK') {
                $in = $this->db->query($SQL);
                if ($in) {
                    echo date("d-m-Y H:i:s")." # ".$response."\r\n";
                }
            } else {
                $STAT = 'N';
            }

            
            //die();
        }

    }

    //getdatadrykenpct1
    public function getreefernpct1_trequest_dry()
    {
        $q = $this->db->query("SELECT * FROM (SELECT * FROM t_request_cont
        WHERE date(tgl_status) >= DATE_ADD(NOW() , INTERVAL -10 DAY) and KD_CONT_JENIS is null and KD_STATUS = 'INQUIRY') az
        WHERE az.FL_TRACK = 'Y' limit 10");


        $nocon11 = "";
        foreach ($q->result() as $key => $value1) {
            $nocon11 = $value1->NO_CONT;
            $soapUrl = "https://api.npct1.co.id/services/index.php/behandle"; // asmx URL of WSDL

            $xml_post_string = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:trackingContainers">
                                <soapenv:Header/>
                                <soapenv:Body>
                                    <urn:trackingContainers soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
                                        <username xsi:type="xsd:string">CGO</username>
                                        <password xsi:type="xsd:string">CGO@2017</password>
                                        <xml xsi:type="xsd:string"><![CDATA[
                                                                <request>
                                                                <containers>
                                                                    <cont_no>'.$value1->NO_CONT.'</cont_no>
                                                                </containers>
                                                            </request>
                                                            ]]></xml>
                                    </urn:trackingContainers>
                                </soapenv:Body>
                                </soapenv:Envelope>'; // data from the form, e.g. some ID number

            $headers = array(
                "Content-type: text/xml;charset=\"utf-8\"",
                "Accept: text/xml",
                "Cache-Control: no-cache",
                "Pragma: no-cache",
                "SOAPAction: https://api.npct1.co.id/services/index.php/behandle",
                //"Content-length: " . strlen($xml_post_string),
            ); //SOAPAction: your op URL
            $url = $soapUrl;
            // PHP cURL  for https connection with auth
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $response = curl_exec($ch);
            curl_close($ch);
            $arrayName = array(
                '<SOAP-ENV:Body>',
                '<ns1:trackingContainersResponse xmlns:ns1="urn:trackingContainers">',
                '<return xsi:type="xsd:string">',
                '</return>',
                '</ns1:trackingContainersResponse>',
                '</SOAP-ENV:Body>',
                //'</SOAP-ENV:Envelope>'
            );
            foreach ($arrayName as $key => $value) {
                $response = str_replace($value, '', $response);
            }
            
        $xml = simplexml_load_string($response);
        header('content-Type: application/json');
        $xml = simplexml_load_string($xml);
        $raw = json_encode($xml);
            $VESSEL_NAME = $xml->LOOP->VESSEL_NAME;
            $CALL_SIGN = $xml->LOOP->CALL_SIGN;
            $VOYAGE_IN = $xml->LOOP->VOYAGE_IN;
            $VOYAGE_OUT = $xml->LOOP->VOYAGE_OUT;
            $SIZE = $xml->LOOP->CONT_SIZE;
            $JENIS = $xml->LOOP->CONT_STATUS;
            $slice = substr($SIZE, 0, 2);
            $ISOCODE = $xml->LOOP->ISOCODE;
            $REQ_TEMP = $xml->LOOP->REEFER_REQ_TEMP;
            $ACT_TEMP = $xml->LOOP->REEFER_ACT_TEMP;
            $PLUG = $xml->LOOP->REEFER_PLUG_IN;
            $UNPLUG = $xml->LOOP->REEFER_PLUG_OUT;
            $REEFER = $xml->LOOP->REEFER;
            $IMDG = $xml->LOOP->IMDG;
            $DISCHARGE = $xml->LOOP->DISCHARGE;
            $tgl_bongkar = date_format(new DateTime($DISCHARGE), 'Y-m-d H:i:s');
            $OOG = $xml->LOOP->OOG;
            $HOLD = $xml->LOOP->HOLD;
            $ON_YARD = $xml->LOOP->ON_YARD;

            if ($ON_YARD == 'OK') {
                $STAT = 'Y';
            } else {
                $STAT = 'N';
            }

            $ID = $value1->ID;
            $NO_CONT = $value1->NO_CONT;
            if ($PLUG != null or $PLUG != "") {
                $PLUGIN = date_format(new DateTime($PLUG), 'Y-m-d H:i:s');
                $PLUGIN_MOD = "PLUG_TERMINAL='$PLUGIN'";
            } else {
                $PLUGIN = NULL;
                $PLUGIN_MOD = "PLUG_TERMINAL=NULL";
            }

            if ($UNPLUG != null or $UNPLUG != "") {
                $UNPLUGIN = date_format(new DateTime($UNPLUG), 'Y-m-d H:i:s');
                $UNPLUGIN_MOD = "UNPLUG_TERMINAL='$UNPLUGIN'";
            } else {
                $UNPLUGIN = NULL;
                $UNPLUGIN_MOD = "UNPLUG_TERMINAL=NULL";
            }

            if ($DISCHARGE != null or $UNPLUG != "") {
                $DISCHARGE = date_format(new DateTime($DISCHARGE), 'Y-m-d H:i:s');
                $DISCHARGE_MOD = "DISCHARGE='$DISCHARGE'";
            } else {
                $DISCHARGE = NULL;
                $DISCHARGE_MOD = "DISCHARGE=NULL";
            }

            if ($REEFER == 'Y') {
                $SQL = "UPDATE t_request_cont SET FL_INQUIRY_DONE = 'Y', TIPE_CONT = 'RFR', KD_CONT_JENIS='$JENIS', UKR_CONT='$slice', VESSEL='$VESSEL_NAME', CALL_SIGN='$CALL_SIGN', VOY_IN='$VOYAGE_IN', VOY_OUT='$VOYAGE_OUT', ISO_CODE='$ISOCODE', $DISCHARGE_MOD, TEMP_CUST='$REQ_TEMP', TEMP_TERMINAL='$ACT_TEMP', $PLUGIN_MOD, $UNPLUGIN_MOD, FL_REEFER='$REEFER', FL_DG='$IMDG', FL_OOG='$OOG', HOLD='$HOLD', FL_YARD='$STAT', FL_TRACK='Y' WHERE ID = '".$ID."' AND NO_CONT = '".$NO_CONT."'";
            }else if ($REEFER == 'N') {
                $SQL = "UPDATE t_request_cont SET FL_INQUIRY_DONE = 'Y', TIPE_CONT = 'DRY', KD_CONT_JENIS='$JENIS', UKR_CONT='$slice', VESSEL='$VESSEL_NAME', CALL_SIGN='$CALL_SIGN', VOY_IN='$VOYAGE_IN', VOY_OUT='$VOYAGE_OUT', ISO_CODE='$ISOCODE', $DISCHARGE_MOD, $PLUGIN_MOD, $UNPLUGIN_MOD, FL_REEFER='$REEFER', FL_DG='$IMDG', FL_OOG='$OOG', HOLD='$HOLD', FL_YARD='$STAT', FL_TRACK='Y' WHERE ID = '".$ID."' AND NO_CONT = '".$NO_CONT."'";
            }else{
                $SQL = "UPDATE t_request_cont SET FL_TRACK='Y' WHERE ID = '".$ID."' AND NO_CONT = '".$NO_CONT."'";
            }
            $this->db->query($SQL);
            echo date("d-m-Y H:i:s")." # ".$response."\r\n";
            //die();
        }

    }
    //NOTE sceduler set gatepass Y
    /**
     * membuat status gate pass jadi y agar bisa di ppk
     */
    public function setgatepass()
    {
        $query = $this->db->query("SELECT c.ID,a.NO_SPK,a.NO_DOK,b.NO_CONT,b.STATUS_CONT,c.JNS_KEGIATAN FROM t_spk a
        JOIN t_spk_cont b on a.ID = b.ID
        JOIN t_gatepass c on a.NO_DOK = c.NO_DOK AND b.NO_CONT = c.NO_CONT
        WHERE SUBSTR(a.no_spk,1,3) = 'MTI' AND c.JNS_KEGIATAN = 1 AND c.FL_ACTIVE = 'N'");
        echo date('Y-m-d H:i:s')." : Jumlah di ubah = ".$query->num_rows()."\r\n";
        foreach ($query->result() as $key => $value) {
            $DATA['FL_ACTIVE'] = "Y";
			$DATA['WK_ACTIVE'] = date('Y-m-d H:i:s');
			$this->db->where(array('ID' => $value->ID));
            $this->db->update('t_gatepass', $DATA);
            echo $value->ID."--".$value->NO_DOK."--".$value->NO_CONT."\r\n";
        }
        echo "\r\n";
    }
    //NOTE sceduler-rekon manual ca
    /**
     * rekon manual di ca
     */
    public function rekonsppmp()
    {
        $qw = $this->db->query("SELECT no_cont FROM data_rekon_sppmp WHERE STATUS = 'n'");
        $datacon = "";
        if ($qw->num_rows() > 0) {
            foreach ($qw->result() as $key => $value) {
                $valtam ="<cont_no>".$value->no_cont."></cont_no>";
                $datacon = $datacon.$valtam;
            }
            $soapUrl = "https://api.npct1.co.id/services/index.php/behandle"; // asmx URL of WSDL
            $soapUser = "CGO"; //  username
            $soapPassword = "CGO@2017"; // password
            
            $xml_post_string = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:reconcileContainers">
            <soapenv:Header/>
            <soapenv:Body>
               <urn:reconcileContainers soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
                  <username xsi:type="xsd:string">CGO</username>
                  <password xsi:type="xsd:string">CGO@2017</password>
                  <xml xsi:type="xsd:string"><![CDATA[
                      <request>
                   <containers>
                       '.$datacon.'
                   </containers>  
                 </request>
                 ]]></xml>
               </urn:reconcileContainers>
            </soapenv:Body>
         </soapenv:Envelope>'; // data from the form, e.g. some ID number
    
            $headers = array(
                "Content-type: text/xml;charset=\"utf-8\"",
                "Accept: text/xml",
                "Cache-Control: no-cache",
                "Pragma: no-cache",
                "SOAPAction: https://api.npct1.co.id/services/index.php/behandle",
                //"Content-length: " . strlen($xml_post_string),
            ); //SOAPAction: your op URL
    
            $url = $soapUrl;
    
            // PHP cURL  for https connection with auth
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //curl_setopt($ch, CURLOPT_USERPWD, $soapUser . ":" . $soapPassword); // username and password - declared at the top of the doc
            //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
            // converting
            $response = curl_exec($ch);
            curl_close($ch);
    
            $arrayName = array(
                '<!--?xml version="1.0" encoding="ISO-8859-1"?-->',
                '<SOAP-ENV:Envelope SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/">',
                '<SOAP-ENV:Body>',
                '<ns1:reconcileContainers xmlns:ns1="urn:reconcileContainers">',
                '<return xsi:type="xsd:string">',
                '</return>',
                '</ns1:reconcileContainers>',
                '</SOAP-ENV:Body>',
                '</SOAP-ENV:Envelope>',
                '<?xml version="1.0" encoding="ISO-8859-1"?>',
                '<ns1:reconcileContainersResponse xmlns:ns1="urn:reconcileContainers">',
                '</ns1:reconcileContainersResponse>'
            );
            foreach ($arrayName as $key => $value) {
                $response = str_replace($value, '', $response);
            }
            $response =  str_replace('&lt;', '<', $response);
            $response =  str_replace('&gt;', '>', $response);
            header('content-Type: application/json');
            $xml = simplexml_load_string($response);
            echo json_encode($xml)."\r\n";
        }

    }
    //NOTE sceduler-send rekonsppmp
    /**
     * : kirim data sppmp ke npct1 agar bisa di rekon
     */
    public function sendrekonsppmpnpct1()
    {
        $soapUrl = "https://api.npct1.co.id/services/index.php/behandle"; // asmx URL of WSDL
        $soapUser = "CGO"; //  username
        $soapPassword = "CGO@2017"; // password
        
        $query = $this->db->query("SELECT DISTINCT A.XML_REQUEST, A.ID,A.WK_REKAM
        FROM log_services A 
        WHERE A.METHOD = 'setLicense'
            AND A.FL_NPCT1 = 'N'
            AND A.XML_REQUEST IS NOT NULL AND A.WK_REKAM > '2020-01-15'
        ORDER BY A.WK_REKAM asc		
        LIMIT 0,10")->result();

        $jml = $this->db->query("SELECT DISTINCT A.XML_REQUEST, A.ID,A.WK_REKAM
        FROM log_services A 
        WHERE A.METHOD = 'setLicense'
            AND A.FL_NPCT1 = 'N'
            AND A.XML_REQUEST IS NOT NULL AND A.WK_REKAM > '2020-01-15'
        ORDER BY A.WK_REKAM asc		
        LIMIT 0,10")->num_rows();

        $idq = "";
        $xmlreq = "";
        
        if ($jml > 0) {
            foreach ($query as $key => $value) {
                $idq = $value->ID;
                $xmlreq = $value->XML_REQUEST;
    
                $xml_post_string = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:insertSPPMP">
                    <soapenv:Header/>
                    <soapenv:Body>
                    <urn:insertSPPMP soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
                        <username xsi:type="xsd:string">CGO</username>
                        <password xsi:type="xsd:string">CGO@2017</password>
                        <xml xsi:type="xsd:string"><![CDATA['.$value->XML_REQUEST.']]></xml>
                    </urn:insertSPPMP>
                    </soapenv:Body>
                </soapenv:Envelope>';
    
                $headers = array(
                    "Content-type: text/xml;charset=\"utf-8\"",
                    "Accept: text/xml",
                    "Cache-Control: no-cache",
                    "Pragma: no-cache",
                    "SOAPAction: https://api.npct1.co.id/services/index.php/behandle",
                );
    
                $url = $soapUrl;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $response = curl_exec($ch);
                curl_close($ch);
    
                $arrayName = array(
                    '<!--?xml version="1.0" encoding="ISO-8859-1"?-->',
                    '<SOAP-ENV:Envelope SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/">',
                    '<SOAP-ENV:Body>',
                    '<ns1:insertSPPMP xmlns:ns1="urn:insertSPPMP">',
                    '<return xsi:type="xsd:string">',
                    '</return>',
                    '</ns1:insertSPPMP>',
                    '</SOAP-ENV:Body>',
                    '</SOAP-ENV:Envelope>',
                    '<?xml version="1.0" encoding="ISO-8859-1"?>',
                    '<ns1:insertSPPMPResponse xmlns:ns1="urn:insertSPPMP">',
                    '</ns1:insertSPPMPResponse>'
                );
                foreach ($arrayName as $key => $value) {
                    $response = str_replace($value, '', $response);
                }
                $response =  str_replace('&lt;', '<', $response);
                $response =  str_replace('&gt;', '>', $response);
                $response = $string = preg_replace('/\s+/', '', $response);
                //$xml = simplexml_load_string($response);
                $search = 'are y';
                if(preg_match("/Success/i", $response)) {
                    echo $idq.' - Success'."\r\n";
                    $SQL11 = "UPDATE log_services SET FL_NPCT1 = 'Y', WK_NPCT1 = NOW() WHERE ID = '".$idq."'";
                    echo $SQL11." - Success"."\r\n\r\n";
                    $this->db->query($SQL11);
                }else {
                    echo $idq.' - Gagal'."\r\n";
                }
                $this->db->query("INSERT INTO log_kirim_sppmp_rekon (idlogservice,raw_response) VALUES ('$idq', '$response')");
    
            }
        }echo "tidak ada data";
        
    }

    public function reqnhi()
    {
        $soapUrl = "https://api.npct1.co.id/services/index.php/behandle"; // asmx URL of WSDL
        $SOAPAction = 'urn:insertNHI#insertNHI';
        $USERNAME_TPSONLINE_BC = 'CGO';
        $PASSWORD_TPSONLINE_BC = 'CGO@2017';
        $SQL = "SELECT distinct a.ID_REQ,a.NO_DOK,a.TGL_DOK,a.NO_VOY,a.NM_KAPAL,a.NO_NOTA_DELIVERY,a.TGL_NOTA,d.id_req FROM req_delivery_hdr a 
        JOIN req_delivery_dtl b ON a.ID_REQ = b.ID_REQ 
        LEFT join log_nhi_baru d ON a.ID_REQ = d.ID_REQ
        WHERE b.NHI_START_DATE IS NOT NULL AND DATE(a.TGL_DOK) >= DATE('2020-06-01') AND d.id_req IS NULL AND a.NO_NOTA_DELIVERY IS NOT null";

        $idreq = '';
        $resp = '';
        $Query =$this->db->query($SQL);
        if ($Query->num_rows() > 0) {
            foreach ($Query->result() as $key => $value) {
                $idreq = $value->ID_REQ;
                $addXML2 = '';
                $addXML ='';
                $NO_DOK = $value->NO_DOK;
                $TGL_DOK = $value->TGL_DOK;
                //$NO_NOTA_DELIVERY = value->$NO_NOTA_DELIVERY;
                $NM_ANGKUT = $value->NM_KAPAL;
                $VOY = $value->NO_VOY;
                $NO_NHI = '';
                $TGL_NHI = '';
            
                $SQL = "SELECT c.NO_CONT,c.UKR_CONT,c.NHI_START_DATE,c.NHI_END_DATE FROM req_delivery_dtl c WHERE c.id_req = '$value->ID_REQ' AND c.no_cont IS NOT NULL AND c.NHI_START_DATE IS NOT null";

                $QueryKontainer = $this->db->query($SQL);

                if ($QueryKontainer->num_rows() > 0) {
                    $addXML2 .= '<DETAIL>';
                    foreach ($QueryKontainer->result() as $key => $va) {
                        $addXML2 .= '<CONT>
                                        <NO_CONT>'.$va->NO_CONT.'</NO_CONT>
                                        <SIZE>'.$va->UKR_CONT.'</SIZE>
                                    </CONT>';
                    }
                    $addXML2 .= '</DETAIL>';
                }

                $addXML = '<?xml version="1.0" encoding="UTF-8"?>
                        <DOCUMENT>
                        <HEADER>
                            <NO_NHI>'. $NO_DOK .'</NO_NHI>
                            <TGL_NHI>'. $TGL_DOK .'</TGL_NHI>
                            <NM_ANGKUT>'. $NM_ANGKUT .'</NM_ANGKUT>
                            <NO_VOY_FLIGHT>'. $VOY .'</NO_VOY_FLIGHT>
                        </HEADER>';
                $addXML .= $addXML2;
                $addXML .= '</DOCUMENT>';

                $xml = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:insertNHI">
                        <soapenv:Header/>
                        <soapenv:Body>
                        <urn:insertNHI soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
                            <username xsi:type="xsd:string">'. $USERNAME_TPSONLINE_BC .'</username>
                            <password xsi:type="xsd:string">'. $PASSWORD_TPSONLINE_BC .'</password>
                            <xml xsi:type="xsd:string"><![CDATA['.$addXML.']]></xml>
                        </urn:insertNHI>
                        </soapenv:Body>
                        </soapenv:Envelope>';
                $headers = array(
                    "Content-type: text/xml;charset=\"utf-8\"",
                    "Accept: text/xml",
                    "Cache-Control: no-cache",
                    "Pragma: no-cache",
                    "SOAPAction: https://api.npct1.co.id/services/index.php/behandle",
                );
                $url = $soapUrl;

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $xml); // the SOAP request
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $response = curl_exec($ch);
                curl_close($ch);

                $arrayName = array(
                    '<?xml version="1.0" encoding="ISO-8859-1"?>',
                    '<SOAP-ENV:Envelope SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/">',
                    '<SOAP-ENV:Body>',
                    '<ns1:insertNHIResponse xmlns:ns1="urn:insertNHI">',
                    '<return xsi:type="xsd:string">',
                    '</return>',
                    '</ns1:insertNHIResponse>',
                    '</SOAP-ENV:Body>',
                    '</SOAP-ENV:Envelope>'
                );
                foreach ($arrayName as $key => $value) {
                    $response = str_replace($value, '', $response);
                }
                $response = str_replace('&lt;', '<', $response);
                $response = $string = preg_replace('/\s+/', '', $response);
                $response = str_replace('<desc&gt;<', '</desc><', $response);
                $response = str_replace('&gt;', '>', $response);
                $resp = $response;
                $json = simplexml_load_string($response);
                if ($json->desc == 'Success') {
                    $this->db->query("INSERT INTO `tpk_ipc`.`log_nhi_baru` (`id_req`, `raw_data`, `respon_data`) VALUES ('$idreq', '$xml', '$resp')");
                    echo $idreq.' = Berhasil';
                }else{
                    echo $idreq." = agal \r\n";
                }
            }
        
        }else{
            echo "Tidak Ada \r\n";
        }
    }

    public function sentNHI()
    {   
        $soapUrl = "https://api.npct1.co.id/services/index.php/behandle"; // asmx URL of WSDL
        $method = 'sentNHI';
        $SOAPAction = 'urn:insertNHI#insertNHI';
        $idreq = '';
        $resp = '';
        $USERNAME_TPSONLINE_BC = 'CGO';
        $PASSWORD_TPSONLINE_BC = 'CGO@2017';
        $respon = '';

        $SQL = "SELECT DISTINCT ID, NO_DOK_INOUT, DATE_FORMAT(TGL_DOK_INOUT,'%Y%m%d') AS 'TGL_DOK', NM_ANGKUT, NO_VOY_FLIGHT AS 'VOY' 
                FROM t_permit_hdr 
                WHERE KD_DOK_INOUT = 81 and FL_NHI = 'N'
                ORDER BY ID DESC limit 5";

        $Query =$this->db->query($SQL);
        if ($Query->num_rows() > 0) {
            foreach ($Query->result() as $key => $value) {
                $idreq = $value->NO_DOK_INOUT;
                $NO_DOK = $value->NO_DOK_INOUT;
                $TGL_DOK = $value->TGL_DOK;
                $NM_ANGKUT = $value->NM_ANGKUT;
                $VOY = $value->VOY;
                $ID = $value->ID;
                
                $addXML = '<?xml version="1.0" encoding="UTF-8"?><DOCUMENT><HEADER><NO_NHI>'. $NO_DOK .'</NO_NHI><TGL_NHI>'. $TGL_DOK .'</TGL_NHI><NM_ANGKUT>'. $NM_ANGKUT .'</NM_ANGKUT><NO_VOY_FLIGHT>'. $VOY .'</NO_VOY_FLIGHT></HEADER>';

                    $SQL = "SELECT DISTINCT A.NO_CONT, A.KD_CONT_UKURAN FROM t_permit_cont A INNER JOIN t_permit_hdr B ON A.ID = B.ID WHERE A.ID='". $ID ."'";

                    $QueryKontainer =$this->db->query($SQL);

                    if ($QueryKontainer->num_rows() > 0) {
                        $addXML .= '<DETAIL>';
                        foreach ($QueryKontainer->result() as $key => $value2) {
                            $NO_CONT = $value2->NO_CONT;
                            $KD_CONT_UKURAN = $value2->KD_CONT_UKURAN;
                            
                            $addXML .= '<CONT><NO_CONT>'. $NO_CONT .'</NO_CONT><SIZE>'. $KD_CONT_UKURAN .'</SIZE></CONT>';
                        }
                        $addXML .= '</DETAIL>';
                    }
                    $addXML .= '</DOCUMENT>';

                    $SOAPAction = 'urn:insertNHI#insertNHI';
                    $xml = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:insertNHI">
                            <soapenv:Header/>
                            <soapenv:Body>
                                <urn:insertNHI soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
                                    <username xsi:type="xsd:string">'. $USERNAME_TPSONLINE_BC .'</username>
                                    <password xsi:type="xsd:string">'. $PASSWORD_TPSONLINE_BC .'</password>
                                    <xml xsi:type="xsd:string"><![CDATA['.$addXML.']]></xml>
                                </urn:insertNHI>
                            </soapenv:Body>
                            </soapenv:Envelope>';

                    $headers = array(
                        "Content-type: text/xml;charset=\"utf-8\"",
                        "Accept: text/xml",
                        "Cache-Control: no-cache",
                        "Pragma: no-cache",
                        "SOAPAction: https://api.npct1.co.id/services/index.php/behandle",
                    );

                    //var_dump($xml);die();

                    $url = $soapUrl;
                    // PHP cURL  for https connection with auth
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml); // the SOAP request
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    $response = curl_exec($ch);
                    curl_close($ch);

                    $arrayName = array(
                        '<?xml version="1.0" encoding="ISO-8859-1"?>',
                        '<SOAP-ENV:Envelope SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/">',
                        '<SOAP-ENV:Body>',
                        '<ns1:insertNHIResponse xmlns:ns1="urn:insertNHI">',
                        '<return xsi:type="xsd:string">',
                        '</return>',
                        '</ns1:insertNHIResponse>',
                        '</SOAP-ENV:Body>',
                        '</SOAP-ENV:Envelope>'
                    );

                    foreach ($arrayName as $key => $value) {
                        $response = str_replace($value, '', $response);
                    }

                    $response = str_replace('&lt;', '<', $response);
                    $response = $string = preg_replace('/\s+/', '', $response);
                    $response = str_replace('<desc&gt;<', '</desc><', $response);
                    $response = str_replace('&gt;', '>', $response);
                    $resp = $response;
                    $json = simplexml_load_string($response);

                    if ($json->desc == 'Success') {
                        $this->db->query("UPDATE t_permit_hdr SET FL_NHI = 'Y' WHERE ID = '$ID'");
                        $respon = "Berhasil";
                    }else{
                        $respon = "Gagal";
                    }
                    $this->db->query("INSERT INTO `tpk_ipc`.`log_nhi_baru` (`id_req`, `raw_data`, `respon_data`) VALUES ('$idreq', '$xml', '$resp')");
            }
        
        }else{
            echo "Tidak Ada \r\n";
        }
    }


    public function getreefernpct1_trequest_N_test()
    {
        $q = $this->db->query("SELECT * FROM (SELECT * FROM t_request_cont
        WHERE date(tgl_status) >= DATE_ADD(NOW() , INTERVAL -35 DAY)) az
        WHERE fl_track = 'N'");


        $nocon11 = "";
        foreach ($q->result() as $key => $value1) {
            $nocon11 = $value1->NO_CONT;
            $soapUrl = "https://api.npct1.co.id/services/index.php/behandle"; // asmx URL of WSDL

            $xml_post_string = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:trackingContainers">
                                <soapenv:Header/>
                                <soapenv:Body>
                                    <urn:trackingContainers soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
                                        <username xsi:type="xsd:string">CGO</username>
                                        <password xsi:type="xsd:string">CGO@2017</password>
                                        <xml xsi:type="xsd:string"><![CDATA[
                                                                <request>
                                                                <containers>
                                                                    <cont_no>'.$value1->NO_CONT.'</cont_no>
                                                                </containers>
                                                            </request>
                                                            ]]></xml>
                                    </urn:trackingContainers>
                                </soapenv:Body>
                                </soapenv:Envelope>'; // data from the form, e.g. some ID number

            $headers = array(
                "Content-type: text/xml;charset=\"utf-8\"",
                "Accept: text/xml",
                "Cache-Control: no-cache",
                "Pragma: no-cache",
                "SOAPAction: https://api.npct1.co.id/services/index.php/behandle",
                //"Content-length: " . strlen($xml_post_string),
            ); //SOAPAction: your op URL
            $url = $soapUrl;
            // PHP cURL  for https connection with auth
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $response = curl_exec($ch);
            curl_close($ch);
            $arrayName = array(
                '<SOAP-ENV:Body>',
                '<ns1:trackingContainersResponse xmlns:ns1="urn:trackingContainers">',
                '<return xsi:type="xsd:string">',
                '</return>',
                '</ns1:trackingContainersResponse>',
                '</SOAP-ENV:Body>',
                //'</SOAP-ENV:Envelope>'
            );
            foreach ($arrayName as $key => $value) {
                $response = str_replace($value, '', $response);
            }
            
        $xml = simplexml_load_string($response);
        header('content-Type: application/json');
        $xml = simplexml_load_string($xml);
        echo $xml . "\r\n" . $response."\r\n";
        die();
        // $raw = json_encode($xml);
        //     $VESSEL_NAME = $xml->LOOP->VESSEL_NAME;
        //     $CALL_SIGN = $xml->LOOP->CALL_SIGN;
        //     $VOYAGE_IN = $xml->LOOP->VOYAGE_IN;
        //     $VOYAGE_OUT = $xml->LOOP->VOYAGE_OUT;
        //     $SIZE = $xml->LOOP->CONT_SIZE;
        //     $JENIS = $xml->LOOP->CONT_STATUS;
        //     $slice = substr($SIZE, 0, 2);
        //     $ISOCODE = $xml->LOOP->ISOCODE;
        //     $REQ_TEMP = $xml->LOOP->REEFER_REQ_TEMP;
        //     $ACT_TEMP = $xml->LOOP->REEFER_ACT_TEMP;
        //     $PLUG = $xml->LOOP->REEFER_PLUG_IN;
        //     $UNPLUG = $xml->LOOP->REEFER_PLUG_OUT;
        //     $REEFER = $xml->LOOP->REEFER;
        //     $IMDG = $xml->LOOP->IMDG;
        //     $DISCHARGE = $xml->LOOP->DISCHARGE;
        //     $tgl_bongkar = date_format(new DateTime($DISCHARGE), 'Y-m-d H:i:s');
        //     $OOG = $xml->LOOP->OOG;
        //     $HOLD = $xml->LOOP->HOLD;
        //     $ON_YARD = $xml->LOOP->ON_YARD;

        //     if ($ON_YARD == 'OK') {
        //         $STAT = 'Y';
        //     } else {
        //         $STAT = 'N';
        //     }

        //     $ID = $value1->ID;
        //     $NO_CONT = $value1->NO_CONT;
        //     if ($PLUG != null or $PLUG != "") {
        //         $PLUGIN = date_format(new DateTime($PLUG), 'Y-m-d H:i:s');
        //         $PLUGIN_MOD = "PLUG_TERMINAL='$PLUGIN'";
        //     } else {
        //         $PLUGIN = NULL;
        //         $PLUGIN_MOD = "PLUG_TERMINAL=NULL";
        //     }

        //     if ($UNPLUG != null or $UNPLUG != "") {
        //         $UNPLUGIN = date_format(new DateTime($UNPLUG), 'Y-m-d H:i:s');
        //         $UNPLUGIN_MOD = "UNPLUG_TERMINAL='$UNPLUGIN'";
        //     } else {
        //         $UNPLUGIN = NULL;
        //         $UNPLUGIN_MOD = "UNPLUG_TERMINAL=NULL";
        //     }

        //     if ($DISCHARGE != null or $UNPLUG != "") {
        //         $DISCHARGE = date_format(new DateTime($DISCHARGE), 'Y-m-d H:i:s');
        //         $DISCHARGE_MOD = "DISCHARGE='$DISCHARGE'";
        //     } else {
        //         $DISCHARGE = NULL;
        //         $DISCHARGE_MOD = "DISCHARGE=NULL";
        //     }

        //     if ($REEFER == 'Y') {
        //         $SQL = "UPDATE t_request_cont SET FL_INQUIRY_DONE = 'Y', TIPE_CONT = 'RFR', KD_CONT_JENIS='$JENIS', UKR_CONT='$slice', VESSEL='$VESSEL_NAME', CALL_SIGN='$CALL_SIGN', VOY_IN='$VOYAGE_IN', VOY_OUT='$VOYAGE_OUT', ISO_CODE='$ISOCODE', $DISCHARGE_MOD, TEMP_CUST='$REQ_TEMP', TEMP_TERMINAL='$ACT_TEMP', $PLUGIN_MOD, $UNPLUGIN_MOD, FL_REEFER='$REEFER', FL_DG='$IMDG', FL_OOG='$OOG', HOLD='$HOLD', FL_YARD='$STAT', FL_TRACK='Y' WHERE ID = '".$ID."' AND NO_CONT = '".$NO_CONT."'";
        //     }else if ($REEFER == 'N') {
        //         $SQL = "UPDATE t_request_cont SET FL_INQUIRY_DONE = 'Y', TIPE_CONT = 'DRY', KD_CONT_JENIS='$JENIS', UKR_CONT='$slice', VESSEL='$VESSEL_NAME', CALL_SIGN='$CALL_SIGN', VOY_IN='$VOYAGE_IN', VOY_OUT='$VOYAGE_OUT', ISO_CODE='$ISOCODE', $DISCHARGE_MOD, $PLUGIN_MOD, $UNPLUGIN_MOD, FL_REEFER='$REEFER', FL_DG='$IMDG', FL_OOG='$OOG', HOLD='$HOLD', FL_YARD='$STAT', FL_TRACK='Y' WHERE ID = '".$ID."' AND NO_CONT = '".$NO_CONT."'";
        //     }else{
        //         $SQL = "UPDATE t_request_cont SET FL_TRACK='Y' WHERE ID = '".$ID."' AND NO_CONT = '".$NO_CONT."'";
        //     }
        //     $this->db->query($SQL);
        //     echo date("d-m-Y H:i:s")." # ".$response."\r\n";
            //die();
        }

    }

    public function getreefernpct1_trequest_Y_test()
    {
        // $q = $this->db->query("SELECT A.*,B.STATUS_CONT FROM (
        //     SELECT a.id,a.NO_DOK,a.TGL_DOK,b.NO_CONT,b.FL_TRACK,b.KD_STATUS,b.FL_INQUIRY_DONE FROM t_request a JOIN t_request_cont b ON a.id = b.id and fl_track = 'Y' AND b.kd_status = 'INQUIRY' AND b.FL_RFR_DONE = 'N' and b.TIPE_CONT = 'RFR') A
        // JOIN (
        //     SELECT a.NO_DOK,a.TGL_DOK,b.NO_CONT,b.STATUS_CONT FROM t_spk a JOIN t_spk_cont b ON a.id = b.id  AND b.STATUS_CONT >= 450) B 
        // ON A.no_dok = B.no_dok AND A.no_cont = B.no_cont
        // WHERE DATE(A.TGL_DOK) >= DATE_ADD(NOW() , INTERVAL -30 DAY)");


        $nocon11 = "";
        // foreach ($q->result() as $key => $value1) {
            $nocon11 = $value1->NO_CONT;
            $soapUrl = "https://api.npct1.co.id/services/index.php/behandle"; // asmx URL of WSDL

            $xml_post_string = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:trackingContainers">
                                <soapenv:Header/>
                                <soapenv:Body>
                                    <urn:trackingContainers soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
                                        <username xsi:type="xsd:string">CGO</username>
                                        <password xsi:type="xsd:string">CGO@2017</password>
                                        <xml xsi:type="xsd:string"><![CDATA[
                                                                <request>
                                                                <containers>
                                                                    <cont_no>SUDU8211903</cont_no>
                                                                </containers>
                                                            </request>
                                                            ]]></xml>
                                    </urn:trackingContainers>
                                </soapenv:Body>
                                </soapenv:Envelope>'; // data from the form, e.g. some ID number

            $headers = array(
                "Content-type: text/xml;charset=\"utf-8\"",
                "Accept: text/xml",
                "Cache-Control: no-cache",
                "Pragma: no-cache",
                "SOAPAction: https://api.npct1.co.id/services/index.php/behandle",
                //"Content-length: " . strlen($xml_post_string),
            ); //SOAPAction: your op URL
            $url = $soapUrl;
            // PHP cURL  for https connection with auth
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $response = curl_exec($ch);
            curl_close($ch);
            $arrayName = array(
                '<SOAP-ENV:Body>',
                '<ns1:trackingContainersResponse xmlns:ns1="urn:trackingContainers">',
                '<return xsi:type="xsd:string">',
                '</return>',
                '</ns1:trackingContainersResponse>',
                '</SOAP-ENV:Body>',
                //'</SOAP-ENV:Envelope>'
            );
            foreach ($arrayName as $key => $value) {
                $response = str_replace($value, '', $response);
            }
           
        $xml = simplexml_load_string($response);
        echo $xml . "\r\n" .'asdasds'  . $response."\r\n";
        die();
        header('content-Type: application/json');
        $xml = simplexml_load_string($xml);
       
        // $raw = json_encode($xml);
        //     $VESSEL_NAME = $xml->LOOP->VESSEL_NAME;
        //     $CALL_SIGN = $xml->LOOP->CALL_SIGN;
        //     $VOYAGE_IN = $xml->LOOP->VOYAGE_IN;
        //     $VOYAGE_OUT = $xml->LOOP->VOYAGE_OUT;
        //     $SIZE = $xml->LOOP->CONT_SIZE;
        //     $JENIS = $xml->LOOP->CONT_STATUS;
        //     $slice = substr($SIZE, 0, 2);
        //     $ISOCODE = $xml->LOOP->ISOCODE;
        //     $REQ_TEMP = $xml->LOOP->REEFER_REQ_TEMP;
        //     $ACT_TEMP = $xml->LOOP->REEFER_ACT_TEMP;
        //     $PLUG = $xml->LOOP->REEFER_PLUG_IN;
        //     $UNPLUG = $xml->LOOP->REEFER_PLUG_OUT;
        //     $REEFER = $xml->LOOP->REEFER;
        //     $IMDG = $xml->LOOP->IMDG;
        //     $DISCHARGE = $xml->LOOP->DISCHARGE;
        //     $tgl_bongkar = date_format(new DateTime($DISCHARGE), 'Y-m-d H:i:s');
        //     $OOG = $xml->LOOP->OOG;
        //     $HOLD = $xml->LOOP->HOLD;
        //     $ON_YARD = $xml->LOOP->ON_YARD;

        //     if ($ON_YARD == 'OK') {
        //         $STAT = 'Y';
        //     } else {
        //         $STAT = 'N';
        //     }

        //     $ID = $value1->id;
        //     $NO_CONT = $value1->NO_CONT;
        //     if ($PLUG != null or $PLUG != "") {
        //         $PLUGIN = date_format(new DateTime($PLUG), 'Y-m-d H:i:s');
        //         $PLUGIN_MOD = "PLUG_TERMINAL='$PLUGIN'";
        //     } else {
        //         $PLUGIN = NULL;
        //         $PLUGIN_MOD = "PLUG_TERMINAL=NULL";
        //     }

        //     if ($UNPLUG != null or $UNPLUG != "") {
        //         $UNPLUGIN = date_format(new DateTime($UNPLUG), 'Y-m-d H:i:s');
        //         $UNPLUGIN_MOD = "UNPLUG_TERMINAL='$UNPLUGIN'";
        //     } else {
        //         $UNPLUGIN = NULL;
        //         $UNPLUGIN_MOD = "UNPLUG_TERMINAL=NULL";
        //     }

        //     if ($DISCHARGE != null or $UNPLUG != "") {
        //         $DISCHARGE = date_format(new DateTime($DISCHARGE), 'Y-m-d H:i:s');
        //         $DISCHARGE_MOD = "DISCHARGE='$DISCHARGE'";
        //     } else {
        //         $DISCHARGE = NULL;
        //         $DISCHARGE_MOD = "DISCHARGE=NULL";
        //     }

        //     if ($REEFER == 'Y') {
        //         $SQL = "UPDATE t_request_cont SET FL_RFR_DONE = 'Y', FL_INQUIRY_DONE = 'Y', TIPE_CONT = 'RFR', KD_CONT_JENIS='$JENIS', UKR_CONT='$slice', VESSEL='$VESSEL_NAME', CALL_SIGN='$CALL_SIGN', VOY_IN='$VOYAGE_IN', VOY_OUT='$VOYAGE_OUT', ISO_CODE='$ISOCODE', $DISCHARGE_MOD, TEMP_CUST='$REQ_TEMP', TEMP_TERMINAL='$ACT_TEMP', $PLUGIN_MOD, $UNPLUGIN_MOD, FL_REEFER='$REEFER', FL_DG='$IMDG', FL_OOG='$OOG', HOLD='$HOLD', FL_YARD='$STAT', FL_TRACK='Y' WHERE ID = '".$ID."' AND NO_CONT = '".$NO_CONT."'";
        //     }else if ($REEFER == 'N') {
        //         $SQL = "UPDATE t_request_cont SET FL_RFR_DONE = 'Y', FL_INQUIRY_DONE = 'Y', TIPE_CONT = 'DRY', KD_CONT_JENIS='$JENIS', UKR_CONT='$slice', VESSEL='$VESSEL_NAME', CALL_SIGN='$CALL_SIGN', VOY_IN='$VOYAGE_IN', VOY_OUT='$VOYAGE_OUT', ISO_CODE='$ISOCODE', $DISCHARGE_MOD, $PLUGIN_MOD, $UNPLUGIN_MOD, FL_REEFER='$REEFER', FL_DG='$IMDG', FL_OOG='$OOG', HOLD='$HOLD', FL_YARD='$STAT', FL_TRACK='Y' WHERE ID = '".$ID."' AND NO_CONT = '".$NO_CONT."'";
        //     }else{
        //         $SQL = "UPDATE t_request_cont SET FL_TRACK='Y' WHERE ID = '".$ID."' AND NO_CONT = '".$NO_CONT."'";
        //     }
        //     $this->db->query($SQL);
        //     echo date("d-m-Y H:i:s")." # ".$response."\r\n";
            //die();
        // }

    }

}