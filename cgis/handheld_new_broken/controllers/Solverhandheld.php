<?php defined('BASEPATH') or exit('No direct script access allowed');

class Solverhandheld extends CI_Controller
{
    public $content;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_home');
    }

    //----------------------------------link view
    /**
     * home page awal
     */
    public function index()
    {
        //echo "haloo";
        $this->load->view('solver/home_page');
    }
    function signout(){
		$this->session->sess_destroy();
			redirect(base_url('handheld.php'));	
	}
    public function cekplug()
    {
        $kon = $this->input->post('cont');

        if ($kon != '' or $kon != null) {
            $data['treq'] = $this->db->query("SELECT * FROM `tpk_ipc`.`t_request_cont` WHERE no_cont in ('$kon')")->result();
            $this->load->view('solver/cekplug_page',$data);
        }else {
            $data['treq'] = "";
            $this->load->view('solver/cekplug_page',$data);
        }
    }
    public function unplug()
    {
        $this->load->view('solver/unplug_page');
    }
    public function requestgatepas()
    {
        //echo "asdasd";
        $this->load->view('solver/requestgatepas_page');
    }
    public function stackingperiod()
    {
        $cont11 = "'MNBU4113800','PONU2878731','SUDU6175643','TRIU8883943'";
        $tglll = "2020-12-01";

        $q = $this->db->query("SELECT aa.id,aa.NO_DOK,aa.TGL_DOK,aa.NO_CONT,aa.TIPE_CONT,aa.KD_STATUS,aa.DISCHARGE FROM (
            SELECT b.id,a.NO_DOK,a.TGL_DOK,b.NO_CONT,b.TIPE_CONT,b.KD_STATUS,b.DISCHARGE,b.CALL_SIGN,b.VESSEL,b.VOY_IN FROM t_request a JOIN t_request_cont b ON a.ID = b.ID AND b.KD_STATUS = 'INQUIRY') aa
        JOIN (
            SELECT c.NO_SPK,c.NO_DOK,c.TGL_DOK,c.WK_REQ,d.NO_CONT from t_spk c JOIN t_spk_cont d ON c.ID = d.ID) bb
        ON aa.NO_DOK = bb.NO_DOK AND aa.TGL_DOK = bb.TGL_DOK AND aa.no_cont = bb.no_cont
        WHERE bb.no_cont IN ($cont11)
        AND date(aa.tgl_dok) > DATE('$tglll') 
        ORDER BY aa.NO_CONT asc");


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
    //----------------------------------------proses

    //-----------------------------------------------------------------------------------------------
    /**
     * cek refer npct1
     *
     * @return void
     */
    public function cekreefer()
    {
        $co = $this->input->get('container'); // request data from the form
        $soapUrl = "https://api.npct1.co.id/services/index.php/behandle"; // asmx URL of WSDL
        $soapUser = "CGO"; //  username
        $soapPassword = "CGO@2017"; // password

        // xml post structure

        $xml_post_string = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:trackingContainers">
							<soapenv:Header/>
							<soapenv:Body>
								<urn:trackingContainers soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
									<username xsi:type="xsd:string">CGO</username>
									<password xsi:type="xsd:string">CGO@2017</password>
									<xml xsi:type="xsd:string"><![CDATA[
															<request>
															<containers>
																<cont_no>' . $co . '</cont_no>
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
        //curl_setopt($ch, CURLOPT_USERPWD, $soapUser . ":" . $soapPassword); // username and password - declared at the top of the doc
        //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // converting
        $response = curl_exec($ch);
        curl_close($ch);

        //var_dump($response);
        // converting
        $arrayName = array(
            //'<!--?xml version="1.0" encoding="ISO-8859-1"?-->',
            //'<SOAP-ENV:Envelope SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/">',
            '<SOAP-ENV:Body>',
            '<ns1:trackingContainersResponse xmlns:ns1="urn:trackingContainers">',
            '<return xsi:type="xsd:string">',
            '</return>',
            '</ns1:trackingContainersResponse>',
            '</SOAP-ENV:Body>',
            //'</SOAP-ENV:Envelope>'
        );
        //echo $response;

        foreach ($arrayName as $key => $value) {
            $response = str_replace($value, '', $response);
        }

        //var_dump($response);
        //$str = (string)$response2;
        $xml = simplexml_load_string($response);
        //$this->db->query("INSERT INTO table_solver (`raw_respon`) VALUES ('$response')");
        //$xml=simplexml_load_string($response);
        // convertingc to XML
        //$response3 = <<<XML.$response2.XML;
        //$parser = simplexml_load_string($str);
        //echo $response2;
        header('content-Type: application/json');
        $xml = simplexml_load_string($xml);
        $dat = json_encode($xml);
        var_dump($xml);
        //echo '<br>';
        // $VESSEL_NAME = $value['VESSEL_NAME;
        // $CALL_SIGN = $value['CALL_SIGN;
        // $VOYAGE_IN = $value['VOYAGE_IN;
        // $VOYAGE_OUT = $value['VOYAGE_OUT;
        // $SIZE = $value['CONT_SIZE;
        // $JENIS = $value['CONT_STATUS;
        // $slice = substr($SIZE, 0,2);
        // $ISOCODE = $value['ISOCODE;
        // $REQ_TEMP = $value['REEFER_REQ_TEMP;
        // $ACT_TEMP = $value['REEFER_ACT_TEMP;
        // $PLUG = $value['REEFER_PLUG_IN;
        // $REEFER = $value['REEFER;
        // $IMDG = $value['IMDG;
        // $DISCHARGE = $value['DISCHARGE;
        // $tgl_bongkar = date_format( new DateTime($DISCHARGE), 'Y-m-d H:i:s' );
        // $OOG = $value['OOG;
        // $HOLD = $value['HOLD;
        // $ON_YARD = $value['ON_YARD;
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

        if ($PLUG != null) {
            $PLUGIN = date_format(new DateTime($PLUG), 'Y-m-d H:i:s');
        } else {
            $PLUGIN = 'kosong';
        }
        if ($UNPLUG != null) {
            $UNPLUGIN = date_format(new DateTime($UNPLUG), 'Y-m-d H:i:s');
        } else {
            $UNPLUGIN = 'kosong';
        }

        $stringq = "UPDATE t_request_cont
		SET KD_CONT_JENIS='$JENIS',
		UKR_CONT='$slice',
		VESSEL='$VESSEL_NAME',
		CALL_SIGN='$CALL_SIGN',
		VOY_IN='$VOYAGE_IN',
		VOY_OUT='$VOYAGE_OUT',
		ISO_CODE='$ISOCODE',
		DISCHARGE='$tgl_bongkar',
		TEMP_CUST='$REQ_TEMP',
		TEMP_TERMINAL='$ACT_TEMP',
		PLUG_TERMINAL='$PLUGIN',
        UNPLUG_TERMINAL='$UNPLUGIN',
		FL_REEFER='$REEFER',
		FL_DG='$IMDG',
		FL_OOG='$OOG',
		HOLD='$HOLD',
		FL_YARD='$STAT',
		FL_TRACK='Y'
		WHERE ID = '' AND NO_CONT = '$co'";

        //var_dump($xml);

        echo $stringq;

    }
    /**
     * cek refer buat ajax di menu plug refer
     *
     * @return void
     */
    public function cekreeferforajax()
    {
        $co = $this->input->get('container'); // request data from the form
        $soapUrl = "https://api.npct1.co.id/services/index.php/behandle"; // asmx URL of WSDL
        $soapUser = "CGO"; //  username
        $soapPassword = "CGO@2017"; // password

        // xml post structure

        $xml_post_string = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:trackingContainers">
							<soapenv:Header/>
							<soapenv:Body>
								<urn:trackingContainers soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
									<username xsi:type="xsd:string">CGO</username>
									<password xsi:type="xsd:string">CGO@2017</password>
									<xml xsi:type="xsd:string"><![CDATA[
															<request>
															<containers>
																<cont_no>' . $co . '</cont_no>
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
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
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

        //var_dump($response);
        // converting
        $arrayName = array(
            //'<!--?xml version="1.0" encoding="ISO-8859-1"?-->',
            //'<SOAP-ENV:Envelope SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/">',
            '<SOAP-ENV:Body>',
            '<ns1:trackingContainersResponse xmlns:ns1="urn:trackingContainers">',
            '<return xsi:type="xsd:string">',
            '</return>',
            '</ns1:trackingContainersResponse>',
            '</SOAP-ENV:Body>',
            //'</SOAP-ENV:Envelope>'
        );
        //echo $response;

        foreach ($arrayName as $key => $value) {
            $response = str_replace($value, '', $response);
        }

        //var_dump($response);
        //$str = (string)$response2;
        $xml = simplexml_load_string($response);
        //$this->db->query("INSERT INTO table_solver (`raw_respon`) VALUES ('$response')");
        //$xml=simplexml_load_string($response);
        // convertingc to XML
        //$response3 = <<<XML.$response2.XML;
        //$parser = simplexml_load_string($str);
        //echo $response2;
        header('content-Type: application/json');
        $xml = simplexml_load_string($xml);
        echo json_encode($xml);
    }
    public function cekreeferidforajax()
    {
        $co = $this->input->get('container'); // request data from the form
        $q = $this->db->query("SELECT id,NO_CONT,UKR_CONT,TEMP_CUST,KD_CONT_JENIS,KD_STATUS,FL_REEFER from t_request_cont WHERE NO_CONT = '$co' order by id desc limit 1");
        header('content-Type: application/json');
        echo json_encode($q->result());
    }

    public function prosesrefernotplug()
    {
        $VESSEL_NAME = $_POST['VESSEL_NAME'];
        $CALL_SIGN = $_POST['CALL_SIGN'];
        $VOYAGE_IN = $_POST['VOYAGE_IN'];
        $VOYAGE_OUT = $_POST['VOYAGE_OUT'];
        $SIZE = $_POST['CONT_SIZE'];
        $JENIS = $_POST['CONT_STATUS'];
        $slice = substr($SIZE, 0, 2);
        $ISOCODE = $_POST['ISOCODE'];
        $REQ_TEMP = $_POST['REEFER_REQ_TEMP'];
        $ACT_TEMP = $_POST['REEFER_ACT_TEMP'];
        $PLUG = $_POST['REEFER_PLUG_IN'];
        $REEFER = $_POST['REEFER'];
        $IMDG = $_POST['IMDG'];
        $DISCHARGE = $_POST['DISCHARGE'];
        $tgl_bongkar = date_format(new DateTime($DISCHARGE), 'Y-m-d H:i:s');
        $OOG = $_POST['OOG'];
        $HOLD = $_POST['HOLD'];
        $ON_YARD = $_POST['ON_YARD'];

        if ($ON_YARD == 'OK') {
            $STAT = 'Y';
        } else {
            $STAT = 'N';
        }
        $ID = $_POST['ID'];
        $NO_CONT = $_POST['CONT_NO'];
        if ($PLUG == null) {
            $SQL = "UPDATE t_request_cont SET KD_CONT_JENIS='$JENIS', UKR_CONT='$slice', VESSEL='$VESSEL_NAME', CALL_SIGN='$CALL_SIGN', VOY_IN='$VOYAGE_IN',
										VOY_OUT='$VOYAGE_OUT', ISO_CODE='$ISOCODE', DISCHARGE='$tgl_bongkar', FL_REEFER='$REEFER', FL_DG='$IMDG',
										FL_OOG='$OOG', HOLD='$HOLD', FL_YARD='$STAT', FL_TRACK='Y' WHERE ID = '".$ID."' AND NO_CONT = '".$NO_CONT."'";
        } else {
            $PLUGIN = date_format(new DateTime($PLUG), 'Y-m-d H:i:s');
            $SQL = "UPDATE t_request_cont SET KD_CONT_JENIS='$JENIS', UKR_CONT='$slice', VESSEL='$VESSEL_NAME', CALL_SIGN='$CALL_SIGN', VOY_IN='$VOYAGE_IN',
										VOY_OUT='$VOYAGE_OUT', ISO_CODE='$ISOCODE', DISCHARGE='$tgl_bongkar', TEMP_CUST='$REQ_TEMP', TEMP_TERMINAL='$ACT_TEMP',
										PLUG_TERMINAL='$PLUGIN', FL_REEFER='$REEFER', FL_DG='$IMDG',
										FL_OOG='$OOG', HOLD='$HOLD', FL_YARD='$STAT', FL_TRACK='Y' WHERE ID = '".$ID."' AND NO_CONT = '".$NO_CONT."'";
        }
        //echo $SQL;
        //echo json_encode($_POST);
		$this->db->query($SQL);
		redirect('https://bos.ipclogistic.co.id/tpk_ipc/cgis-dev/handheld.php/operation/search_reefer');
    }

    public function manualgetreefer()
    {
        $reeferman = array('MSCU3630988','EMCU5378074','EMCU5396416','EMCU5372780','BMOU9232800','KKFU6960497','HLXU8760146','SEGU9169979','OOLU6283230','EMCU5435446','EMCU5354998','SZLU9133671','OOLU6193199','OOLU6413858','UACU4789574');
        foreach ($reeferman as $key => $value) {
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
                                                                    <cont_no>'.$value.'</cont_no>
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
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
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
            //$js = json_encode($xml);
            //echo $xml->LOOP->CONT_NO."-".$xml->LOOP->REEFER."-".date_format(new DateTime($xml->LOOP->REEFER_PLUG_OUT), 'Y-m-d H:i:s')."\r\n";
            //$js = json_encode($xml);
            //echo $xml->LOOP->REEFER."\r\n\r\n";
            //die();
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
            $UNPLUG = date_format(new DateTime($xml->LOOP->REEFER_PLUG_OUT), 'Y-m-d H:i:s');
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
            
            $NO_CONT = $xml->LOOP->CONT_NO;
            $queryy = $this->db->query("SELECT id FROM t_request_cont where no_cont = '$NO_CONT'");
            $roww = $queryy->row();
            $ID = $roww->id;

            if ($REEFER == 'Y') {
                $SQL = "UPDATE t_request_cont SET UNPLUG_TERMINAL='$UNPLUG' WHERE ID = '".$ID."' AND NO_CONT = '".$NO_CONT."'";
                echo $SQL;
            }else{
                echo "bukan";
            }
            echo "\r\n";
            //echo json_encode($_POST);
            $this->db->query($SQL);
        }
    }

    public function reqgetpass()
    {
        $soapUrl = "https://api.npct1.co.id/services/index.php/behandle"; // asmx URL of WSDL
        $soapUser = "CGO"; //  username
        $soapPassword = "CGO@2017"; // password

        // xml post structure

        $SQL = "SELECT A.JNS_DOK, A.NO_DOK, DATE_FORMAT(A.TGL_DOK,'%Y%m%d') AS TGL_DOK, A.ANGKUTNAMA_TPS, '-' AS CALL_SIGN, A.ANGKUTNO_TPS , 
        '-' AS TGL_TIBA, DATE_FORMAT(A.WK_REQ,'%Y%m%d%H%i%s') AS PLANNING_OUT, A.NPWP, A.CONSIGNEE, NULL AS REMARK, 
        A.ID, UPPER(B.AUTOGATE_DOC_TYPE) AS JNS_DOK_DESC, A.NO_BL_AWB AS NO_BL_AWB
        FROM t_request A
        LEFT JOIN reff_kode_dok_bc B ON A.JNS_DOK = B.ID
        WHERE A.ID = '85679'
        ORDER BY A.ID desc
        LIMIT 10";
        $qw = $this->db->query($SQL)->row();

            $JNS_DOK = $qw->JNS_DOK;
            $NO_DOK = $qw->NO_DOK;
            $TGL_DOK = $qw->TGL_DOK;
            $ANGKUTNAMA_TPS = $qw->ANGKUTNAMA_TPS;
            $CALL_SIGN = $qw->CALL_SIGN;
            $ANGKUTNO_TPS = $qw->ANGKUTNO_TPS;
            $TGL_TIBA = $qw->TGL_TIBA;
            $PLANNING_OUT = $qw->PLANNING_OUT;
            $NPWP = $qw->NPWP;
            $CONSIGNEE = $qw->CONSIGNEE;
            $REMARK = $qw->REMARK;
            $ID = $qw->ID;
            $JNS_DOK_DESC = $qw->JNS_DOK_DESC;
            $NO_BL_AWB = $qw->NO_BL_AWB;
            $CONSIGNEE = str_replace('&', '', $CONSIGNEE);

            $addXML = '<DOCUMENT>
                            <HEADER>
                                <SENDER>CGO</SENDER>
                                <TYPE_DOC>' . $JNS_DOK_DESC . '</TYPE_DOC>
                                <NO_DOC>' . $NO_DOK . '</NO_DOC>
                                <DATE_DOC>' . $TGL_DOK . '</DATE_DOC>
                                <VESSEL>' . $ANGKUTNAMA_TPS . '</VESSEL>
                                <CALLSIGN>' . $CALL_SIGN . '</CALLSIGN>
                                <VOYAGE>' . $ANGKUTNO_TPS . '</VOYAGE>
                                <VESSEL_ETA>' . $TGL_TIBA . '</VESSEL_ETA>
                                <PLANNING_OUT>' . $PLANNING_OUT . '</PLANNING_OUT>
                                <NPWP>' . $NPWP . '</NPWP>
                                <CONSIGNEE>' . $CONSIGNEE . '</CONSIGNEE>
                                <NO_BL_AWB>' . $NO_BL_AWB . '</NO_BL_AWB>
                                <REMARK>' . $REMARK . '</REMARK>
                            </HEADER>';
            if ($JNS_DOK == "83") {
				$SQL = "SELECT A.NO_CONT, A.ISO_CODE, A.REF_NUMBER, 'F' AS KD_CONT_JENIS
                        FROM t_request_cont A INNER JOIN t_request B ON A.ID = B.ID
                        WHERE A.ID = '" . $ID . "'";
            } else {
				$SQL = "SELECT A.NO_CONT, A.ISO_CODE, A.REF_NUMBER, A.KD_CONT_JENIS
                        FROM t_request_cont A INNER JOIN t_request B ON A.ID = B.ID
                        WHERE A.ID = '" . $ID . "'";
            }
            $QueryKontainer = $this->db->query($SQL);
            if ($QueryKontainer->num_rows() > 0) {
                $addXML .= '<DETAIL>';
                $QueryKontainer1 = $QueryKontainer->result();
               foreach ($QueryKontainer1 as $key => $value){
                    $NO_CONT = $value->NO_CONT;
                    $ISO_CODE = $value->ISO_CODE;
                    $REF_NUMBER = $value->REF_NUMBER;
                    $KD_CONT_JENIS = $value->KD_CONT_JENIS;
                    $addXML .= '<LOOP>
                                    <CONTAINER>' . $NO_CONT . '</CONTAINER>
                                    <ISOCODE>' . $ISO_CODE . '</ISOCODE>
                                    <STATUS>' . $KD_CONT_JENIS . '</STATUS>
                                    <REF_NUMBER>' . $REF_NUMBER . '</REF_NUMBER>
                                </LOOP>';
                }
                $addXML .= '</DETAIL>';
            }
            $addXML .= '</DOCUMENT>';

            $xml_post_string = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:requestGatepass">
                        <soapenv:Header/>
                        <soapenv:Body>
                        <urn:requestGatepass soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
                            <username xsi:type="xsd:string">CGO</username>
                            <password xsi:type="xsd:string">CGO@2017</password>
                            <xml xsi:type="xsd:string"><![CDATA['.$addXML.']]></xml>
                        </urn:requestGatepass>
                        </soapenv:Body>
                    </soapenv:Envelope>';
            //         header('content-Type: application/json');
             echo $xml_post_string;die();
            // die();
                    $headers = array(
                        "Content-type: text/xml;charset=\"utf-8\"",
                        "Accept: text/xml",
                        "Cache-Control: no-cache",
                        "Pragma: no-cache",
                        "SOAPAction: https://api.npct1.co.id/services/index.php/behandle",
                        //"Content-length: " . strlen($xml_post_string),
                    ); //SOAPAction: your op URL
            
                    $url = $soapUrl;
            
                //     // PHP cURL  for https connection with auth
                //     $ch = curl_init();
                //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
                //     curl_setopt($ch, CURLOPT_URL, $url);
                //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                //     //curl_setopt($ch, CURLOPT_USERPWD, $soapUser . ":" . $soapPassword); // username and password - declared at the top of the doc
                //     //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
                //     curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                //     curl_setopt($ch, CURLOPT_POST, true);
                //     curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
                //     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            
                //     // converting
                //     $response = curl_exec($ch);
                //     curl_close($ch);
                //     // converting
                //     $arrayName = array(
                //         //'<!--?xml version="1.0" encoding="ISO-8859-1"?-->',
                //         //'<SOAP-ENV:Envelope SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/">',
                //         '<SOAP-ENV:Body>',
                //         '<ns1:requestGatepassResponse xmlns:ns1="urn:requestGatepass">',
                //         '<return xsi:type="xsd:string">',
                //         '</return>',
                //         '</ns1:requestGatepassResponse>',
                //         '</SOAP-ENV:Body>',
                //         //'</SOAP-ENV:Envelope>'
                //     );
                //     //echo $response;
            
                //     foreach ($arrayName as $key => $value) {
                //         $response = str_replace($value, '', $response);
                //     }

                //     $xml = simplexml_load_string($response);

                //     header('content-Type: application/json');
                //     $xml = simplexml_load_string($xml);
                // echo $xml;
                // die();
                //     if ($xml->STATUS != '') {
                //         $respon = $xml->STATUS;
                //         $Remark = $xml->REMARK;
                //         $Remarks = $Remark == "" ? "NULL" : "'" . $Remark . "'";
                //         $loop = $xml->RESPONSE->LOOP;
                //         // echo $respon."\r\n";
                //         // echo $Remark."\r\n";
                //         // echo var_dump($loop)."\r\n";
                        
                //         $countloop = count($loop);
                //         if ($countloop > 0) {
                //             foreach ($loop as $value) {
                //                 $NO_CONT = $value->CONT_NO;
                //                 //echo $value->CONT_NO;
                //                 //die();
                //                 $TYPE_CONT = $value->REEFER == 'N' ? 'DRY' : 'RFR';
                //                 $SQL = "UPDATE t_request_cont SET UKR_CONT = '" . $value->CONT_SIZE. "', 
                //                         TIPE_CONT  = " . $TYPE_CONT . ", 
                //                         KD_CONT_JENIS  = ".$value->CONT_STATUS.", 
                //                         CALL_SIGN  = ".$value->CALL_SIGN.", 
                //                         ISO_CODE  = ".$value->ISOCODE.", 
                //                         VOY_IN  = ".$value->VOYAGE_IN.", 
                //                         VOY_OUT  = ".$value->VOYAGE_OUT.", 
                //                         FL_IMO  = ".$value->IMDG.", 
                //                         FL_OOG  = ".$value->OOG.", 
                //                         HOLD  = ".$value->HOLD."
                //                         WHERE ID = '".$ID."' AND NO_CONT = '".$NO_CONT."' ";
                //                 $this->db->query($SQL);
                //                 if ($Execute) {
                //                     echo 'success';
                //                 } else {
                //                     echo 'error';
                //                 }
                //             }
                //         }
                //         //if ($response == '<return_data>Success</return_data>') {
                //         if ($respon == 'SUCCESS') {
                //             $KD_STATUS = 'SENT';
                //         } else {
                //             $KD_STATUS = 'ERROR';
                //         }
                //     } else {
                //         $KD_STATUS = 'ERROR';
                //          // $Remarks = 'ERROR';
                //     }
                //     echo 'KD_STATUS : ' . $KD_STATUS;
                //     $SQL = "UPDATE t_request SET KD_REQ = '" . $KD_STATUS . "', RESPONSE_REQ  = " . $Remarks . "
                //             WHERE ID = '" . $ID . "'";
                //     $Execute = $this->db->query($SQL)->num_rows();
                //     if ($Execute > 0) {
                //         echo 'success';
                //     } else {
                //         echo 'error';
                //     }
                //     $this->insertLogServices('RequestGatePassSP2MP', 'Scheduler RequestGatePassSP2MP', $xml_post_string, $response, $remarks);

    }

    public function insertLogServices($method, $userName, $xmlRequest, $xmlResponse, $remarks) {
        global $CONF, $conn;
        $ipAddress = 1;
        $method = $method == '' ? 'NULL' : "'" . $method . "'";
        $userName = $userName == '' ? 'NULL' : "'" . $userName . "'";
        $xmlRequest = $xmlRequest == '' ? 'NULL' : "'" . $xmlRequest . "'";
        $xmlResponse = $xmlResponse == '' ? 'NULL' : "'" . $xmlResponse . "'";
        $remarks = $remarks == '' ? 'NULL' : "'" . $remarks . "'";
        $SQL = "INSERT INTO log_services (METHOD, USERNAME, XML_REQUEST, XML_RESPONSE, IPADDRESS, REMARKS, WK_REKAM)
                VALUES (" . $method . ", " . $userName . ", " . $xmlRequest . ", " . $xmlResponse . ", '" . $ipAddress . "', " . $remarks . ", NOW())";
        $Execute = $this->db->query($SQL);
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

                var_dump($xml);die();
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
                    echo $idreq." = Berhasil \r\n";
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

                    var_dump($xml);die();

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













    /**
     * coba buat email
     */
    public function cobaemail()
    {
        $config = array(
            'protocol'  => 'smtp',
            'smtp_host' => 'mail2.edi-indonesia.co.id',
            'smtp_port' => 25,
            'smtp_user' => '',
            'smtp_timeout' => 30,
            'smtp_pass' => '',
            'mailtype'  => 'html',
            'charset'   => 'iso-8859-1',
            'wrapchars' => 100,
            'crlf'         => "\r\n",
            'newline'     => "\r\n",
            'start_tls' => TRUE
        );
            $msg = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>Document</title>
            </head>
            
            <body>
                <div>
                    <p>
                        Dengan Hormat,<br><br>
                        Bersama ini kami informasikan data barang/container yang akan diangkut (pick up) dari terminal untuk
                        kebutuhan pemeriksaan (behandle) dengan data sebagai berikut :
                    </p>
                    <table class="table" style="width:80%;border-collapse:collapse;background:#ecf3eb">
                        <tr>
                            <td style="width:214px;"><b>NPWP Perusahaan</b> </td>
                            <td>:</td>
                            <td>017731571046000</td>
                        </tr>
                        <tr>
                            <td><b>Nama Perusahaan</b> </td>
                            <td>:</td>
                            <td>PT LARIS MANIS UTAMA</td>
                        </tr>
                        <tr>
                            <td><b>Nama Kapal </b></td>
                            <td>:</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><b>NO. BL </b></td>
                            <td>:</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><b>Nomor Container </b></td>
                            <td>:</td>
                            <td>MNBU9069850-40"</td>
                        </tr>
                        <tr>
                            <td><b>No. Dokumen Customs </b></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                    <table style="width:80%;border-collapse:collapse;background:#ecf3eb">
                        <tr>
                            <td style="width:214px;"><b>PIB</b></td>
                            <td style="width: 18px;">:</td>
                            <td></td>
                            <td><b>Tanggal Dokumen Dikeluarkan</b></td>
                            <td>:</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><b>SPPMP</b></td>
                            <td>:</td>
                            <td>2019.2.0300.0.S01.I.024808</td>
                            <td><b>Tanggal Dokumen Dikeluarkan</b></td>
                            <td>:</td>
                            <td>2019-11-14</td>
                        </tr>
                        <tr>
                            <td><b>BC.1.1</b></td>
                            <td>:</td>
                            <td></td>
                            <td><b>Tanggal Dokumen Dikeluarkan</b></td>
                            <td>:</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><b>HI CO Scan</b></td>
                            <td>:</td>
                            <td></td>
                            <td><b>Tanggal Dokumen Dikeluarkan</b></td>
                            <td>:</td>
                            <td></td>
                        </tr>
                    </table>
                    <table style="width:80%;border-collapse:collapse;background:#ecf3eb">
                        <tr>
                            <td style="width:214px;"><b>Rencana Keluar</b></td>
                            <td>:</td>
                            <td>19-11-2019 23:55:00</td>
                        </tr>
                    </table><br><br>
                    <!-- <table border="1" class="table" width="55%">
                                                                <tr>
                                                                    <th>No. SPK</th>
                                                                    <th>Nomor Kontainer</th>
                                                                </tr>
                                                                <tr>
                                                                    <td>PT. MTI/5</td>
                                                                    <td>SGSDGSD64546</td>
                                                                </tr>
                                                            </table> --><br>
                    <div>
                        Mohon kerjasamanya untuk mengirimkan data Gate Pass CIC sesuai kebutuhan diatas.<br><br>
                        Atas perhatian dan kerjasamanya kami ucapkan terima kasih.<br><br>
            
                        =================================================================================<br><br>
                        <table class="table">
                            <tr>
                                <td>
                                    <img src="https://bos.ipclogistic.co.id/tpk_ipc/cgis//assets/images/Logomti.png" alt="">
                                </td>
                                <td>
                                    <div style="color:#050567">
                                        This message was delivered by BOS ? PT. MTI.
                                        You are receiving this message because your email address are registered in our user
                                        database.
                                        If you have any question or information regarding this message, or if you do not want to
                                        receive any notifications in the future, please contact our Customer Care officer.
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </body>
            
            </html>';
            $emailcustomrr = array('DATA.ENTRY@NPCT1.CO.ID','BILLING@NPCT1.CO.ID','BILLINGTEAM@NPCT1.CO.ID','automail@multiterminal.co.id','GATE@NPCT1.CO.ID','YAYANCHY@GMAIL.COM');
            $subject = "REQUEST GATEPASS CIC - PT LARIS MANIS UTAMA";
            //foreach ($arrayName as $key => $value) {
                $this->load->library('email', $config);
                $this->email->from('automail@multiterminal.co.id', 'BOS NOTIFICATION - REQUEST GATEPASS');
                $this->email->to('yayancloud@gmail.com');
                $this->email->subject($subject);
                $this->email->message($msg);
                $this->email->send();
                //$deb = $this->email->print_debugger();
				$this->db->query("INSERT INTO log_email_solver (`email`, `status`, `debugger`) VALUES ('$msg', '1', '')");
            //}
    }

    /**
     * laporan kontainer tidak ada di period stacking
     */
    public function PeriodStacking()
    {
        $nocont = array('CAIU4503577','BMOU9871490','CAIU9104440','EGHU3021925','EGHU9654495','EISU2124171','EITU0106188','EITU1468197','EITU1542057','EITU1914431','EITU1927927','EITU1979094','EMCU5281401','EMCU5320154','FCGU1978733','FCIU9975574','FDCU0268713','HLBU2490513','HLBU2556610','MNBU3739580','MNBU3888516','MNBU3916032','MRKU0183477','MRKU0645913','MRKU0852886','MRKU2149980','MRKU3416654','MRKU4515902','MRKU6351074','MRKU7794457','MRKU8698735','MSDU3007101','MSKU0471080','MSKU3842883','MSKU3902241','MSKU4079879','MSKU5831846','MSKU7630780','MSKU7766884','MSKU8928640','MSKU9087481','MSKU9979256','MSWU9063412','NYKU3411452','PONU1943386','SEGU3339790','SUDU1810622','SUDU5251820','SUDU5301393','SUDU5880398','SUDU7592533','SUDU7600921','TCKU2275311','TCKU3002570','TCLU1214978','TCLU1216522','TCLU1264304','TCLU1908710','TCLU8708530','TEMU9487180','TGBU6942886','TGHU1500271','TRIU8799067','TRLU9612339','TRLU9682151','TRLU9759417');
        $i=1;
        foreach ($nocont as $key => $value) {
            echo "No - ".$i++ ."\r\n";
            $jml = $this->db->query("SELECT id,no_cont,no_dok,jns_kegiatan,nm_kapal,no_voy,fl_bil
            FROM t_gatepass
            WHERE no_cont = '$value'")->num_rows();


            $sql_jns_keg_3 = $this->db->query("SELECT id,no_cont,no_dok,jns_kegiatan,nm_kapal,no_voy,fl_bil
            FROM t_gatepass
            WHERE no_cont = '$value' AND jns_kegiatan = '3'")->row();
            $sql_jns_keg_2 = $this->db->query("SELECT id,no_cont,no_dok,jns_kegiatan,nm_kapal,no_voy,fl_bil
            FROM t_gatepass
            WHERE no_cont = '$value' AND jns_kegiatan = '2'")->row();
            $sql_jns_keg_1 = $this->db->query("SELECT id,no_cont,no_dok,jns_kegiatan,nm_kapal,no_voy,fl_bil
            FROM t_gatepass
            WHERE no_cont = '$value' AND jns_kegiatan = '1'")->row();

            if ($jml == 2 or $jml == 3) {
                if ($sql_jns_keg_3 != NULL && $sql_jns_keg_1 != NULL) {
                    $nm = $sql_jns_keg_3->nm_kapal;
                    $voy = $sql_jns_keg_3->no_voy;
                    
                    echo "3 - ".json_encode($sql_jns_keg_3)."\r\n";
                    echo "2 - ".json_encode($sql_jns_keg_2)."\r\n";
                    echo "1 - ".json_encode($sql_jns_keg_1)."\r\n";
                    echo "1 - UPDATE t_gatepass SET nm_kapal = '$nm', no_voy = '$voy' WHERE no_cont = '$value' and jns_kegiatan = '1' \r\n";
                    $this->db->query("UPDATE t_gatepass SET nm_kapal = '$nm', no_voy = '$voy' WHERE no_cont = '$value' and jns_kegiatan = '1'");

                    if ($sql_jns_keg_2 != NULL) {
                        echo "2 - UPDATE t_gatepass SET nm_kapal = '$nm', no_voy = '$voy' WHERE no_cont = '$value' and jns_kegiatan = '2' \r\n";
                        $this->db->query("UPDATE t_gatepass SET nm_kapal = '$nm', no_voy = '$voy' WHERE no_cont = '$value' and jns_kegiatan = '2'");
                    }
                
                }else{
                    if ($sql_jns_keg_3 == NULL) {
                        echo "kegiatan 3 null - ";
                    }else{
                        echo "Kegiatan 3 ada - ";
                    }
                    
                    if ($sql_jns_keg_1 == NULL) {
                        echo "kegiatan 1 null \r\n";
                    }else{
                        echo "Kegiatan 1 ada \r\n";
                    }
                }
            }else{
                echo $value." - Tidak Di eksekusi jumlah = ".$jml."\r\n";
            }
            echo "\r\n\r\n";
        }


    }

    public function tarikreefermanual()
    {
        $qw = $this->db->query("SELECT * FROM t_request_cont WHERE NO_CONT in ('BMOU9007646','CGMU2985763','CGMU3023300','CGMU3074925','EISU5701045','EMCU5281850','EMCU5314803','EMCU5431800','EMCU5438661','EMCU5443550','EMCU5452232','MCRU2061781','MCRU9001362','MEDU9218090','MNBU0203207','MNBU3018326','MNBU3182617','MNBU3185323','MNBU3524134','MNBU3891211','MSCU7372006','MSWU9029085','MWCU5201235','MWCU5251350','MWCU5262539','MWCU5691256','MWCU5721073','MWCU5735816','PONU2891374','SUDU6174694','SZLU9078912','SZLU9094003','SZLU9629574','TCLU1912900','TRIU6682575','TRIU8031459')
        AND KD_STATUS = 'INQUIRY' AND tipe_cont IS NOT NULL");

        $mans = array('MNBU0106172','MNBU0146154','MNBU0550187','MNBU0553150','MNBU3031708','MNBU3066453','MNBU3262733','MNBU3371884','MNBU3669272','MNBU3748411','MNBU3862044','MNBU3939275','MNBU4134212','MNBU4136998','MNBU9009168','MORU1139153','MSWU0069174','MSWU0073024');
        $nocon11 = "";
        $tgl = "";
        $iddd = "";
        foreach ($qw->result() as $key => $value) {
            // echo $value->no_cont." - ".$value->tgl_status."\r\n";
            $nocon11 = $value->NO_CONT;
            $iddd = $value->ID;
            // $tgl = $value->tgl_status;

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
                                                                    <cont_no>'.$nocon11.'</cont_no>
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
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
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

            $ID = $iddd;
            $NO_CONT = $nocon11;
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
            echo $SQL."\r\n";
        }
    }

    public function ondimend()
    {
        $KdAPRF = 'GETINQUIRY';
					$KD_ORG_SENDER = '0';
            		$KD_ORG_RECEIVER = '0';
					$CONF['url.wsdl'] = 'https://api.npct1.co.id/services/index.php/behandle';
					$SOAPAction = 'urn:inquiryGatepass#inquiryGatepass';
					$USERNAME_TPSONLINE_BC = 'CGO';
					$PASSWORD_TPSONLINE_BC = 'CGO@2017';
					$SQL = $this->db->query("SELECT DISTINCT B.ID, A.JNS_DOK, B.NO_CONT, B.REF_NUMBER 
											FROM t_request A INNER JOIN t_request_cont B ON A.ID = B.ID
											WHERE B.ID = '$id' AND B.KD_STATUS='APPROVED' AND B.REF_NUMBER IS NOT NULL")->row_array();
					$REF_NUMBER = $SQL['REF_NUMBER'];
					$JNS_DOK = $SQL['JNS_DOK'];
					$xml = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:inquiryGatepass">
								<soapenv:Header/>
								<soapenv:Body>
								<urn:inquiryGatepass soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
									<username xsi:type="xsd:string">'.$USERNAME_TPSONLINE_BC.'</username>
									<password xsi:type="xsd:string">'.$PASSWORD_TPSONLINE_BC.'</password>
									<ref_number xsi:type="xsd:string">'.$REF_NUMBER.'</ref_number>
								</urn:inquiryGatepass>
								</soapenv:Body>
							</soapenv:Envelope>';
					$Send = $this->SendCurl1($xml, $CONF['url.wsdl'], $SOAPAction, "");
					

					echo var_dump($Send);

					// $messageErr = $xmlResponse['RETURN_DATA']['_c']['STATUS']['_v'];
					// $messageInfo = $xmlResponse['RETURN_DATA']['_c']['REMARK']['_v'];
    }

    function SendCurl1($xml, $url, $SOAPAction, $proxy = "", $port = "443") {
        $header[] = 'Content-Type: text/xml';
        $header[] = 'SOAPAction: "' . $SOAPAction . '"';
        $header[] = 'Content-length: ' . strlen($xml);
        $header[] = 'Connection: close';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

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
    
    public function ceklog()
    {
        $q = $this->db->query("select * from t_log_reefer");
        $i = 0;
        foreach ($q->result() as $key => $value) {
            $raw = json_decode($value->raw);
            echo $raw->LOOP->CONT_NO." - ".$raw->LOOP->REEFER_PLUG_IN."\r\n";
            $b = (string)$raw->LOOP->REEFER_PLUG_IN;
            if ($b == "") {
               $i++;
            }
        }
        echo $i;
    }

    public function cobascript_autogate_halotec($id)
    {
        $SQL = "SELECT distinct A.CONTAINER_ID, A.DOCUMENT_NO, B.EXPIRED_DATE, B.UKR_CONT, C.PLUG_END_DATE
        FROM t_autogate_send_customs A
        INNER JOIN t_gatepass B ON A.CONTAINER_ID = B.NO_CONT AND A.DOCUMENT_NO = B.NO_DOK AND B.JNS_KEGIATAN ='3'
        LEFT JOIN (SELECT NO_CONT,PLUG_END_DATE FROM req_delivery_dtl WHERE PLUG_END_DATE IS NOT NULL) C ON B.NO_CONT = C.NO_CONT
        WHERE A.TRANSACTION_ID = '$id'";
        $dt = $this->db->query($SQL);
        if ($dt->num_rows() > 0) {
            $expiredDate  = $dt->row("EXPIRED_DATE");
            $containerId  = $dt->row("CONTAINER_ID");
            $ukrContainer = $dt->row("UKR_CONT");
            $unplugDate   = $dt->row("PLUG_END_DATE");
            
            echo $expiredDate."\r\n";
            echo $containerId."\r\n";
            echo $ukrContainer."\r\n";
            echo $unplugDate."\r\n";

            if ($unplugDate != '') {
                $cekDate = date('Y-m-d H:i:s'); 
                $DateExp = $unplugDate;
            }else {
                $cekDate = date('Y-m-d');
                $DateExp = $expiredDate;
            }
            echo $cekDate."\r\n";
            echo $DateExp."\r\n";

                if ($cekDate <= $DateExp){
                    echo "Masuk";
                }else {
                    echo "Tidak Bisa Masuk";
                }
        }

        
    }

    public function getreefernpct1_trequest($noc)
    {
        
            $nocon11 = $noc;
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
                                                                    <cont_no>'.$noc.'</cont_no>
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
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
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
            $NO_CONT = $noc;
            if ($PLUG != null or $PLUG != "") {
                $PLUGIN = date_format(new DateTime($PLUG), 'Y-m-d H:i:s');
            } else {
                $PLUGIN = 'NULL';
            }
            if ($UNPLUG != null or $UNPLUG != "") {
                $UNPLUGIN = date_format(new DateTime($UNPLUG), 'Y-m-d H:i:s');
            } else {
                $UNPLUGIN = 'NULL';
            }
            if ($DISCHARGE != null or $DISCHARGE != "") {
                $DISCHARGE = date_format(new DateTime($DISCHARGE), 'Y-m-d H:i:s');
            } else {
                $DISCHARGE = 'NULL';
            }

            $dt = array(
                'VESSEL_NAME' => (string)$VESSEL_NAME,
                'CALL_SIGN' => (string)$CALL_SIGN,
                'VOYAGE_IN' => (string)$VOYAGE_IN,
                'VOYAGE_OUT' => (string)$VOYAGE_OUT,
                'SIZE' => (string)$SIZE,
                'JENIS' => (string)$JENIS,
                'slice' => (string)$slice,
                'ISOCODE' => (string)$ISOCODE,
                'REQ_TEMP' => (string)$REQ_TEMP,
                'ACT_TEMP' => (string)$ACT_TEMP,
                'PLUG' => (string)$PLUGIN,
                'UNPLUG' => (string)$UNPLUGIN,
                'REEFER' => (string)$REEFER,
                'IMDG' => (string)$IMDG,
                'DISCHARGE' => (string)$DISCHARGE,
                'tgl_bongkar' => (string)$tgl_bongkar,
                'OOG' => (string)$OOG,
                'HOLD' => (string)$HOLD,
                'ON_YARD' => (string)$ON_YARD,
                'NO_CONT' => (string)$NO_CONT,
                'STAT' => (string)$STAT
            );

            return $dt;

    }

    public function cobascript()
    {
        $dataNPCT = $this->getreefernpct1_trequest('SZLU2041402');
        if ($dataNPCT['REEFER'] == 'Y') {
            echo "REEFER \r\n";
            echo $dataNPCT['VESSEL_NAME']."\r\n";
            echo $dataNPCT['CALL_SIGN']."\r\n";
            echo $dataNPCT['VOYAGE_IN']."\r\n";
            echo $dataNPCT['VOYAGE_OUT']."\r\n";
            echo $dataNPCT['SIZE']."\r\n";
            echo $dataNPCT['JENIS']."\r\n";
            echo $dataNPCT['slice']."\r\n";
            echo $dataNPCT['ISOCODE']."\r\n";
            echo $dataNPCT['REQ_TEMP']."\r\n";
            echo $dataNPCT['ACT_TEMP']."\r\n";
            echo $dataNPCT['PLUG']."\r\n";
            echo $dataNPCT['UNPLUG']."\r\n";
            echo $dataNPCT['REEFER']."\r\n";
            echo $dataNPCT['IMDG']."\r\n";
            echo $dataNPCT['DISCHARGE']."\r\n";
            echo $dataNPCT['tgl_bongkar']."\r\n";
            echo $dataNPCT['OOG']."\r\n";
            echo $dataNPCT['HOLD']."\r\n";
            echo $dataNPCT['ON_YARD']."\r\n";
            echo $dataNPCT['NO_CONT']."\r\n";
            echo $dataNPCT['STAT']."\r\n";
        }else {
            echo "DRY";
        }
        $this->db->query("UPDATE t_request_cont SET KD_CONT_JENIS='$JENIS', UKR_CONT='$slice', VESSEL='$VESSEL_NAME', CALL_SIGN='$CALL_SIGN', VOY_IN='$VOYAGE_IN', VOY_OUT='$VOYAGE_OUT', ISO_CODE='$ISOCODE', DISCHARGE='$tgl_bongkar', TEMP_CUST='$REQ_TEMP', TEMP_TERMINAL='$ACT_TEMP', PLUG_TERMINAL='$PLUGIN', UNPLUG_TERMINAL='$UNPLUGIN', FL_REEFER='$REEFER', FL_DG='$IMDG', FL_OOG='$OOG', HOLD='$HOLD', FL_YARD='$STAT', FL_TRACK='Y' WHERE ID = '".$ID."' AND NO_CONT = '".$NO_CONT."'");
        //echo $data;
    }
    public function jsondatacon()
    {   
        $nocont = $this->input->get('no_cont');
        $nocont = strtoupper($nocont);
        $nocont = trim($nocont);
        $q = $this->db->query("SELECT CONCAT('NO KONTAINER : ',no_cont) AS 'judul',CONCAT('Lokasi :',IF(lokasi = 'SAMPAH',' OUT ',lokasi)) AS 'tanggal', CONCAT('No Container ',no_cont,' sudah pada status ',b.KETERANGAN) AS 'keterangan'
        FROM t_spk_cont a JOIN reff_status_spk b ON a.STATUS_CONT = b.ID  WHERE a.no_cont = '$nocont'");
        $as = array();
        array_push($as,$q->row_array());
        $data = array(
            'databos' => $as
        );
        //echo count($q->result());
        //die();
        if (count($q->result()) == 0) {
            $data = array(
                'databos' => array(
                    array(
                        "judul" => "Data $nocont Tidak Di temukan",
                        "tanggal" => "",
                        "keterangan" => ""
                    )
                )  
            );
        }
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, OPTIONS");
        echo json_encode($data);
    }

    //pindah t request to cocoscont
    public function pindahcocos()
    {
        $where = "vessel = 'ALLEGORIA' and voy_in = '036S'";
        $idcocos = 22005;
        $a = $this->db->query("SELECT * FROM t_request_cont WHERE $where");
        $date = date('Y-m-d H:i:s');
        //echo $date; die();
        foreach ($a->result() as $key => $value) {
            if($value->UKR_CONT == ''){$UKR_CONT = NULL;}else{$UKR_CONT = $value->UKR_CONT;}
            if($value->KD_CONT_JENIS == ''){$KD_CONT_JENIS = NULL;}else{$KD_CONT_JENIS = $value->KD_CONT_JENIS;}
            if($value->ISO_CODE == ''){$ISO_CODE = NULL;}else{$ISO_CODE = $value->ISO_CODE;}
            if($value->TIPE_CONT == ''){$TIPE_CONT = NULL;}else{$TIPE_CONT = $value->TIPE_CONT;}
            if($value->BRUTO == ''){$BRUTO = 0;}else{$BRUTO = $value->BRUTO;}
            $b = $this->db->query("SELECT ID,NO_CONT from t_cocostscont where NO_CONT = '$value->NO_CONT' and ID = '$idcocos'")->num_rows();
            if ($b == 0) {
            $this->db->query("INSERT INTO `t_cocostscont` (`ID`, `NO_CONT`, `UK_CONT`, `JNS_CONT`, `ISO_CODE`, `TEMPERATURE`, `KD_CONT_TIPE`, `BRUTO`, `NO_SEGEL`, `NO_BL_AWB`, `TGL_BL_AWB`, `NO_MASTER_BL_AWB`, `TGL_MASTER_BL_AWB`, `NO_BC11`, `TGL_BC11`, `NO_POS_BC11`, `ID_CONSIGNEE`, `CONSIGNEE`, `KD_TIMBUN`, `PEL_MUAT`, `PEL_TRANSIT`, `PEL_BONGKAR`, `KD_DOK_IN`, `NO_DOK_IN`, `TGL_DOK_IN`, `WK_IN`, `FL_CONT_KOSONG_IN`, `KD_SARANA_ANGKUT_IN`, `NO_POL_IN`, `GUDANG_TUJUAN_IN`, `NO_DAFTAR_PABEAN_IN`, `TGL_DAFTAR_PABEAN_IN`, `NO_SEGEL_BC_IN`, `TGL_SEGEL_BC_IN`, `NO_IJIN_TPS_IN`, `TGL_IJIN_TPS_IN`, `KODE_KANTOR_IN`, `KD_DOK_OUT`, `NO_DOK_OUT`, `TGL_DOK_OUT`, `WK_OUT`, `FL_CONT_KOSONG_OUT`, `KD_SARANA_ANGKUT_OUT`, `NO_POL_OUT`, `GUDANG_TUJUAN_OUT`, `NO_DAFTAR_PABEAN_OUT`, `TGL_DAFTAR_PABEAN_OUT`, `NO_SEGEL_BC_OUT`, `TGL_SEGEL_BC_OUT`, `NO_IJIN_TPS_OUT`, `TGL_IJIN_TPS_OUT`, `KODE_KANTOR_OUT`, `WK_REKAM`, `FL_BILLING`) VALUES ($idcocos, '$value->NO_CONT', '$UKR_CONT', '$KD_CONT_JENIS', '$ISO_CODE', NULL, '$TIPE_CONT', $BRUTO, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IDJKT', NULL, NULL, NULL, '$value->DISCHARGE', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$date', 'N')");
            echo $value->NO_CONT."terkirim \r\n";
            }else{
                echo $value->NO_CONT." Sudah Ada \r\n";
            }
        }
    }
    
    //---------------------------------------------

    public function panggilintegrasi()
    {

        $this->load->model('Requestgatepass');
        $datacont = $this->db->query("SELECT A.NO_DOK,A.TGL_DOK,A.NO_CONT,A.ID_FLAT,B.TAR,B.TIPE_CONT,B.KD_CONT_JENIS,B.VESSEL,B.VOY_IN,B.ISO_CODE,C.NO_PLAT,C.BERAT_TRUCK,B.BRUTO,B.FL_DG,B.FL_OOG FROM(
            SELECT a.NO_DOK,a.TGL_DOK,a.NO_SPK,b.NO_CONT,b.ID_FLAT,b.ISO_CODE FROM t_spk a JOIN t_spk_cont b ON a.ID = b.ID AND status_cont NOT IN (900,950) AND YEAR(a.TGL_DOK)=YEAR(NOW())) A
         JOIN (
            SELECT c.NO_DOK,c.TGL_DOK,d.NO_CONT,d.TAR,d.TIPE_CONT,d.KD_CONT_JENIS,d.VESSEL,d.VOY_IN,d.ISO_CODE,d.BRUTO,d.FL_DG,d.FL_OOG FROM t_request c JOIN t_request_cont d ON c.ID = d.ID) B ON  A.no_dok = B.no_dok AND A.NO_CONT = B.NO_CONT
         LEFT JOIN reff_truck C ON A.ID_FLAT = C.NO_TRUCK
         WHERE A.NO_CONT = 'FCIU6592870'")->row();
         

        //$data1 = $this->Requestgatepass->message2a($datacont);
        $data2 = $this->Requestgatepass->message2b($datacont);
        //$data3 = $this->Requestgatepass->message3a($datacont);
        //$data4 = $this->Requestgatepass->message3b($datacont);

        //var_dump($data1->status);
        //var_dump($data2->TruckEvent->TruckCall->AppStatus);
        //var_dump($data3->message);
        //var_dump($data2->TruckEvent->TruckCall->AppStatus);        
    }

    public function cekdok()
    {
        $p = $this->input->get('dok');
        $ex = explode('.',$p);
        $ex1 = $ex[0];
        $ex2 = $ex[count($ex)-1];
        $a1 = $this->db->query("SELECT no_respon,tg_respon,lnsw_kd_respon FROM t_ppk_hdr WHERE RIGHT(no_respon,6) = '$ex2' AND LEFT(no_respon,4) = '$ex1'")->result();
        $a2 = $this->db->query("SELECT no_dok,tgl_dok,kd_req from t_request WHERE RIGHT(no_dok,6) = '$ex2' AND LEFT(no_dok,4) = '$ex1'")->result();
        $a3 = $this->db->query("SELECT no_cont,no_dok,tgl_dok,status FROM t_gatepass WHERE RIGHT(no_dok,6) = '$ex2' AND LEFT(no_dok,4) = '$ex1'")->result();
        $a4 = $this->db->query("SELECT no_dok,tgl_dok,kd_status FROM t_spk WHERE RIGHT(no_dok,6) = '$ex2' AND LEFT(no_dok,4) = '$ex1'")->result();
        $a5 = $this->db->query("SELECT * FROM t_job_slip WHERE RIGHT(no_dok,6) = '$ex2' AND LEFT(no_dok,4) = '$ex1'")->result();

        $data = array(
            't_ppk_hdr' => $a1,
            't_request' => $a2,
            't_gatepass' => $a3,
            't_spk' => $a4,
            't_job_slip' => $a5 
        );

        echo json_encode($data);
    }

    public function test(){
                $curl = curl_init();

                curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.npct1.co.id:9443/api/v1/reqBehandle',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>'<request> 
                    <header> 
                        <sender>CGO</sender> 
                        <type_doc>SPPMP</type_doc> 
                        <no_doc>2021.2.0300.0.K02.I.017633</no_doc> 
                        <date_doc>20210819</date_doc> 
                        <vessel_name>NAVIOS LAPIS</vessel_name> 
                        <call_sign>-</call_sign> 
                        <voyage>129S</voyage> 
                        <vessel_eta>-</vessel_eta> 
                        <planning_out>20210825235500</planning_out>
                        <npwp>01.001.661.6-051.000</npwp>
                        <customer_name>PT. PERUSAHAAN PERDAGANGAN INDONESIA (PERSERO)</customer_name> 
                        <no_bl_awb>017633</no_bl_awb> 
                        <remark></remark> 
                    </header> 
                    <detail> 
                        <loop> 
                            <cont_no>UJANG000001</cont_no>
                            <isocode>2210</isocode> 
                            <full_empty>F</full_empty> 
                            <reff_number>CGO0091915</reff_number> 
                        </loop> 
                        <loop> 
                            <cont_no>UJANG000002</cont_no> 
                            <isocode>2210</isocode> 
                            <full_empty>F</full_empty> 
                            <reff_number>CGO0091916</reff_number> 
                        </loop> 
                    </detail> 
                </request> ',
                CURLOPT_HTTPHEADER => array(
                    'User-ID: BEHANDLE',
                    'NPCT-API-Key: 5d3a2ffcb778f4b1c224f2447c048c8f',
                    'Content-Type: application/xml'
                ),
                ));

                $response = curl_exec($curl);
                if (!curl_errno($curl)) {
                    $info = curl_getinfo($curl);
                    echo "Connection Success , This is Url : ", $info['url'], "\r\n";
                  }else{
                    echo "Connection Failed =".curl_error($curl);
                }
                curl_close($curl); 

                echo $response;

    }

    public function test_nhi(){

        $url = "https://api.npct1.co.id:9443/api/v1/set-nhi";
        $user = "BEHANDLE";
        $key ="5d3a2ffcb778f4b1c224f2447c048c8f";
        $respon='';

        // $nhi_no ="NHI-281/KPU.01/BD.09/2021";
        // $nhi_date="20210819";
        // $vessel_name= "BROOKLYN BRIDGE";
        // $voyage = "128S";

        $SQL = "SELECT DISTINCT ID, NO_DOK_INOUT, DATE_FORMAT(TGL_DOK_INOUT,'%Y%m%d') AS 'TGL_DOK', NM_ANGKUT, NO_VOY_FLIGHT AS 'VOY' 
        FROM t_permit_hdr 
        WHERE KD_DOK_INOUT = 81 and FL_NHI = 'N' AND ID ='485708'
        ORDER BY ID DESC limit 5";
        $Query =$this->db->query($SQL);
        if ($Query->num_rows() > 0) {
            foreach ($Query->result() as $key => $value) {
                $idreq = $value->NO_DOK_INOUT;
                $nhi_no = $value->NO_DOK_INOUT;
                $nhi_date = $value->TGL_DOK;
                $vessel_name = $value->NM_ANGKUT;
                $voyage = $value->VOY;
                $id = $value->ID;

                $addXML ='<document> 
                <header> 
                        <nhi_no>'.$nhi_no.'</nhi_no> 
                        <nhi_date>'.$nhi_date.'</nhi_date> 
                        <vessel_name>'.$vessel_name.'</vessel_name> 
                        <voyage>'.$voyage.'</voyage> 
                </header>
                    ';
                $SQL = "SELECT DISTINCT A.NO_CONT, A.KD_CONT_UKURAN FROM t_permit_cont A INNER JOIN t_permit_hdr B ON A.ID = B.ID WHERE A.ID='". $id ."'";

                $QueryKontainer =$this->db->query($SQL);

                if ($QueryKontainer->num_rows() > 0) {
                    
                $addXML .= '<detail>
                    ';
                    foreach ($QueryKontainer->result() as $key => $value2) {
                    $no_cont = $value2->NO_CONT;
                    $ukr = $value2->KD_CONT_UKURAN;
                    // $no_cont='FDCU0322521'; 
                    // $ukr ='40';
                $addXML .= '<cont> 
                            <cont_no>'.$no_cont.'</cont_no> 
                            <cont_size>'.$ukr.'</cont_size> 
                    </cont>
                ';
                    } 
                $addXML .= '</detail>
                ';
                } 
                $addXML .='</document>
                ';

                // print_r($addXML);die();

                $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
CURLOPT_SSL_VERIFYPEER => false,
CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>$addXML,
                CURLOPT_HTTPHEADER => array(
                    'User-ID: '.$user,
                    'NPCT-API-Key: '.$key,
                    'Content-Type: application/xml'
                ),
                ));
                $response = curl_exec($curl);
                if (!curl_errno($curl)) {
                    $info = curl_getinfo($curl);
                    echo "Connection Success , This is Url : ", $info['url'], "\r\n";
                }else{
                    echo "Connection Failed =".curl_error($curl);
                }
                curl_close($curl); 
                // echo $response;
                $xml = simplexml_load_string($response);
                $json = json_encode($xml);
                $array = json_decode($json,TRUE);
                // var_dump($array['status']);
                
                if ($array['status'] == 'OK') {
                    $this->db->query("UPDATE t_permit_hdr SET FL_NHI = 'Y' WHERE ID = '$id'");
                    echo "Berhasil";
                }else{
                    echo "Gagal";
                }
                $this->db->query("INSERT INTO `tpk_ipc`.`log_nhi_baru` (`id_req`, `raw_data`, `respon_data`) VALUES ('$idreq', '$xml', '$json')");
            }
        }else{
            echo "Tidak Ada \r\n";
        }
    }

    public function trackingnpct1(){

        $url = "https://api.npct1.co.id:9443/api/v1/tracking";
        $user = "BEHANDLE";
        $key ="5d3a2ffcb778f4b1c224f2447c048c8f";

        // $q = $this->db->query("SELECT * FROM (SELECT * FROM t_request_cont
        // WHERE date(tgl_status) >= DATE_ADD(NOW() , INTERVAL -35 DAY)) az
        // WHERE fl_track = 'N'");

        // $nocon11 = "";
        // foreach ($q->result() as $key => $value1) {
        //     $nocon11 = $value1->NO_CONT;
        //     $addXML ='<request> 
        //     <containers>> 
        //         <cont_no>'.$value1->NO_CONT.'</cont_no> 
        //     </request>
        //         ';
        //     $addXML .='</containers>
        //     ';

            // print_r($addXML);die();


            $addXML ='<request> 
            <containers>> 
                <cont_no>TGOS3000001</cont_no> 
            </containers>
                ';
            $addXML .='</request>
            ';

            // print_r($addXML);die();
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
CURLOPT_SSL_VERIFYPEER => false,
CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>$addXML,
            CURLOPT_HTTPHEADER => array(
                'User-ID: '.$user,
                'NPCT-API-Key: '.$key,
                'Content-Type: application/xml'
            ),
            ));
            $response = curl_exec($curl);
            if (!curl_errno($curl)) {
                $info = curl_getinfo($curl);
                echo "Connection Success , This is Url : ", $info['url'], "\r\n";
            }else{
                echo "Connection Failed =".curl_error($curl);
            }
            curl_close($curl); 
            echo $response;
       
        // }


    }
}
