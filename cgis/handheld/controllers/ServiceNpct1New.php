<?php defined('BASEPATH') or exit('No direct script access allowed');

class ServiceNpct1New extends CI_Controller
{
    public $content;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_home');
    }

    public function getreefernpct1_trequest_N()
    {
        $url    = "https://api.npct1.co.id:9443/api/v1/tracking";
        $user   = "BEHANDLE";
        $key    = "5d3a2ffcb778f4b1c224f2447c048c8f";

        $q = $this->db->query("SELECT * FROM (SELECT * FROM t_request_cont
        WHERE date(tgl_status) >= DATE_ADD(NOW() , INTERVAL -35 DAY)) az
        WHERE fl_track = 'N'");
        // var_dump($q);die();
        $nocon11 = "";
        foreach ($q->result() as $key => $value1) {
            $nocon11 = $value1->NO_CONT;
            $addXML = '<request> 
            <containers>
                <cont_no>' . $value1->NO_CONT . '</cont_no> 
            </containers>
                ';
            $addXML .= '</request>
            ';

            $addXML = trim(preg_replace('/\s\s+/', '', str_replace("\n", " ", $addXML)));
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
                CURLOPT_POSTFIELDS => $addXML,
                CURLOPT_HTTPHEADER => array(
                    'User-ID: ' . $user,
                    'NPCT-API-Key: ' . $key,
                    'Content-Type: application/xml'
                ),
            ));
            $response = curl_exec($curl);
            if (!curl_errno($curl)) {
                $info = curl_getinfo($curl);
                echo "Connection Success , This is Url : ", $info['url'], "\r\n";
            } else {
                echo "Connection Failed =" . curl_error($curl);
            }
            curl_close($curl);
            // echo $response;die;
            // print_r($response);die();
            $xml = simplexml_load_string($response);
            // var_dump((string) $xml->response->containers->vessel_name);die();
            $VESSEL_NAME = $xml->response->containers->vessel_name;
            $CALL_SIGN = $xml->response->containers->call_sign;
            $VOYAGE_IN = $xml->response->containers->voyage_in;
            $VOYAGE_OUT = $xml->response->containers->voyage_out;
            $CONT_NO = $xml->response->containers->cont_no;
            $SIZE = $xml->response->containers->cont_size;
            $JENIS = $xml->response->containers->full_empty;
            $slice = substr($SIZE, 0, 2);
            $ISOCODE = $xml->response->containers->isocode;
            $REEFER = $xml->response->containers->reefer;
            $REQ_TEMP = $xml->response->containers->reefer_req_temp;
            $ACT_TEMP = $xml->response->containers->reefer_act_temp;
            $PLUG = $xml->response->containers->reefer_plug_in;
            $UNPLUG = $xml->response->containers->reefer_plug_out;
            $IMDG = $xml->response->containers->imdg;
            $OOG = $xml->response->containers->oog;
            $DISCHARGE = $xml->response->containers->discharge;
            $tgl_bongkar = date_format(new DateTime($DISCHARGE), 'Y-m-d H:i:s');
            $GATEOUT = $xml->response->containers->gateout;
            $REFERENCE_NO = $xml->response->containers->reference_no;
            $HOLD = $xml->response->containers->hold;
            $ON_YARD = $xml->response->containers->on_yard;

            // print_r($tgl_bongkar);die();
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
            // print_r($DISCHARGE);die();
            if ($REEFER == 'Y') {
                $SQL = "UPDATE t_request_cont SET FL_INQUIRY_DONE = 'Y', TIPE_CONT = 'RFR', KD_CONT_JENIS='$JENIS', UKR_CONT='$slice', VESSEL='$VESSEL_NAME', CALL_SIGN='$CALL_SIGN', VOY_IN='$VOYAGE_IN', VOY_OUT='$VOYAGE_OUT', ISO_CODE='$ISOCODE', $DISCHARGE_MOD, TEMP_CUST='$REQ_TEMP', TEMP_TERMINAL='$ACT_TEMP', $PLUGIN_MOD, $UNPLUGIN_MOD, FL_REEFER='$REEFER', FL_DG='$IMDG', FL_OOG='$OOG', HOLD='$HOLD', FL_YARD='$STAT', FL_TRACK='Y' WHERE ID = '" . $ID . "' AND NO_CONT = '" . $NO_CONT . "'";
            } else if ($REEFER == 'N') {
                $SQL = "UPDATE t_request_cont SET FL_INQUIRY_DONE = 'Y', TIPE_CONT = 'DRY', KD_CONT_JENIS='$JENIS', UKR_CONT='$slice', VESSEL='$VESSEL_NAME', CALL_SIGN='$CALL_SIGN', VOY_IN='$VOYAGE_IN', VOY_OUT='$VOYAGE_OUT', ISO_CODE='$ISOCODE', $DISCHARGE_MOD, $PLUGIN_MOD, $UNPLUGIN_MOD, FL_REEFER='$REEFER', FL_DG='$IMDG', FL_OOG='$OOG', HOLD='$HOLD', FL_YARD='$STAT', FL_TRACK='Y' WHERE ID = '" . $ID . "' AND NO_CONT = '" . $NO_CONT . "'";
            } else {
                $SQL = "UPDATE t_request_cont SET FL_TRACK='Y' WHERE ID = '" . $ID . "' AND NO_CONT = '" . $NO_CONT . "'";
            }
            $this->db->query($SQL);
            echo date("d-m-Y H:i:s") . " # " . $response . "\r\n";
            //die();
        }
    }

    public function RequestGatepassSPPMP()
    {

        $url    = "https://api.npct1.co.id:9443/api/v1/reqBehandle";
        $user   = "BEHANDLE";
        $key    = "5d3a2ffcb778f4b1c224f2447c048c8f";

        $SQL = "SELECT A.JNS_DOK, A.NO_DOK, DATE_FORMAT(A.TGL_DOK,'%Y%m%d') AS TGL_DOK, A.ANGKUTNAMA_TPS, '-' AS CALL_SIGN, A.ANGKUTNO_TPS , 
        '-' AS TGL_TIBA, DATE_FORMAT(A.WK_REQ,'%Y%m%d%H%i%s') AS PLANNING_OUT, DATE_FORMAT(A.WK_REQ,'%Y-%m-%d') as 'PLAN_OUT',
		CASE
	        WHEN HOUR(A.WK_REQ) BETWEEN 0 AND 7 THEN 1
	        WHEN HOUR(A.WK_REQ) BETWEEN 8 AND 15 THEN 2
	        ELSE 3
	    END AS SLOT,
        A.NPWP, A.CONSIGNEE, NULL AS REMARK, 
        A.ID, UPPER(B.KODE_NPCT1) AS JNS_DOK_DESC, A.NO_BL_AWB AS NO_BL_AWB, C.NO_DAFTAR_PABEAN as 'NO_PIB', C.TGL_DAFTAR_PABEAN as 'TGL_PABEAN'
        FROM t_request A
        left join t_permit_hdr C on A.NO_DOK = C.NO_DOK_INOUT and A.TGL_DOK = C.TGL_DOK_INOUT
        LEFT JOIN reff_kode_dok_bc B ON A.JNS_DOK = B.ID
        WHERE A.KD_REQ = 'QUEUED'
        ORDER BY A.ID DESC
        LIMIT 10";
        // echo $SQL;die();
        $Query = $this->db->query($SQL);
        // var_dump($Query);die();
        if ($Query->num_rows() > 0) {
            foreach ($Query->result() as $key => $value) {
                $JNS_DOK = $value->JNS_DOK;
                $NO_DOK =  $value->NO_DOK;
                $TGL_DOK = $value->TGL_DOK;
                $ANGKUTNAMA_TPS = $value->ANGKUTNAMA_TPS;
                $CALL_SIGN = $value->CALL_SIGN;
                $ANGKUTNO_TPS = $value->ANGKUTNO_TPS;
                $TGL_TIBA = $value->TGL_TIBA;
                $PLANNING_OUT = $value->PLANNING_OUT;
                $NPWP = $value->NPWP;
                $CONSIGNEE = $value->CONSIGNEE;
                $REMARK = $value->REMARK;
                $ID = $value->ID;
                $JNS_DOK_DESC = $value->JNS_DOK_DESC;
                $NO_BL_AWB = $value->NO_BL_AWB;
                $NO_BL_AWB = preg_replace("/[^0-9]/", "", $NO_BL_AWB);
                $CONSIGNEE = str_replace('&', '', $CONSIGNEE);
                $NO_PIB = $value->NO_PIB;
                $TGL_PABEAN = $value->TGL_PABEAN;
                $PLAN_OUT = $value->PLAN_OUT;
                $SLOT = $value->SLOT;;

                $xml = '<request> 
                            <header> 
                                <sender>CGO</sender> 
                                <type_doc>' . $JNS_DOK_DESC . '</type_doc> 
                                <no_doc>' . $NO_DOK . '</no_doc> 
                                <date_doc>' . $TGL_DOK . '</date_doc> 
                                <pib_no>' . $NO_PIB . '</pib_no>
                                <pib_date>' . $TGL_PABEAN . '</pib_date>
                                <vessel_name>' . $ANGKUTNAMA_TPS . '</vessel_name> 
                                <call_sign>' . $CALL_SIGN . '</call_sign> 
                                <voyage>' . $ANGKUTNO_TPS . '</voyage> 
                                <vessel_eta>' . $TGL_TIBA . '</vessel_eta> 
                                <planning_out>' . $PLANNING_OUT . '</planning_out>
                                <plan_in>' . $PLAN_OUT . '</plan_in>
                                <plan_in_slot>' . $SLOT . '</plan_in_slot>
                                <npwp>' . $NPWP . '</npwp>
                                <customer_name>' . $CONSIGNEE . '</customer_name> 
                                <no_bl_awb>' . $NO_BL_AWB . '</no_bl_awb> 
                                <remark>' . $REMARK . '</remark> 
                            </header>
                            ';
                /* $SQL = "SELECT A.NO_CONT, A.UKURAN, NULL AS REF_NUMBER
                FROM t_ppk_cont A
                WHERE A.ID_IJIN = '" . $ID_IJIN . "'"; */
                if ($JNS_DOK == "83") {
                    $SQL = "SELECT A.NO_CONT, A.ISO_CODE, A.REF_NUMBER, 'F' AS KD_CONT_JENIS
                            FROM t_request_cont A INNER JOIN t_request B ON A.ID = B.ID
                            WHERE A.ID = '" . $ID . "' AND A.KD_STATUS = 'DRAFT' AND A.REQ_PILIH = 'Y' AND A.REF_NUMBER IS NOT NULL";

                    /*$SQL = "SELECT A.NO_CONT, A.ISO_CODE, A.REF_NUMBER, 'F' AS KD_CONT_JENIS
                            FROM t_request_cont A INNER JOIN t_request B ON A.ID = B.ID
                                                LEFT JOIN t_lic_hdr C ON B.NO_DOK = C.NO_IJIN AND B.TGL_DOK = C.TGL_IJIN
                                                LEFT JOIN t_ppk_cont D ON C.ID_IJIN = D.ID_IJIN AND A.NO_CONT = D.NO_CONT
                            WHERE A.ID = '" . $ID . "'";*/
                    // echo "bb";
                } else {
                    $SQL = "SELECT A.NO_CONT, A.ISO_CODE, A.REF_NUMBER, A.KD_CONT_JENIS
                            FROM t_request_cont A INNER JOIN t_request B ON A.ID = B.ID
                            WHERE A.ID = '" . $ID . "' AND A.KD_STATUS = 'DRAFT' AND A.REQ_PILIH = 'Y' AND A.REF_NUMBER IS NOT NULL";

                    /*$SQL = "SELECT A.NO_CONT, A.ISO_CODE, A.REF_NUMBER, A.KD_CONT_JENIS
                            FROM t_request_cont A INNER JOIN t_request B ON A.ID = B.ID
                                                INNER JOIN t_permit_hdr C ON B.JNS_DOK = C.KD_DOK_INOUT AND B.NO_DOK = C.NO_DAFTAR_PABEAN AND B.TGL_DOK = C.TGL_DAFTAR_PABEAN
                                                INNER JOIN t_permit_cont D ON C.ID = D.ID AND A.NO_CONT = D.NO_CONT
                            WHERE A.ID = '" . $ID . "'";*/
                    // echo "aa";
                }
                // echo $SQL;die(); 
                $QueryKontainer =  $this->db->query($SQL);
                if ($QueryKontainer->num_rows() > 0) {
                    $xml .= '<detail>
                                    ';
                    foreach ($QueryKontainer->result() as $key => $value2) {
                        $NO_CONT = $value2->NO_CONT;
                        $ISO_CODE = $value2->ISO_CODE;
                        $REF_NUMBER = $value2->REF_NUMBER;
                        $KD_CONT_JENIS = $value2->KD_CONT_JENIS;
                        $xml .= '<loop> 
                                    <cont_no>' . $NO_CONT . '</cont_no>
                                    <isocode>' . $ISO_CODE . '</isocode> 
                                    <full_empty>' . $KD_CONT_JENIS . '</full_empty> 
                                    <reff_number>' . $REF_NUMBER . '</reff_number> 
                                </loop>
                                ';
                    }
                    $xml .= '</detail>
                            ';
                }
                $xml .= '</request>
                    ';
                $xml = trim(preg_replace('/\s\s+/', '', str_replace("\n", " ", $xml)));
                // header('Content-Type: text/xml');
                // exit();
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
                    CURLOPT_POSTFIELDS => $xml,
                    CURLOPT_HTTPHEADER => array(
                        'User-ID: ' . $user,
                        'NPCT-API-Key: ' . $key,
                        'Content-Type: application/xml'
                    ),
                ));

                $response = curl_exec($curl);
                if (!curl_errno($curl)) {
                    $info = curl_getinfo($curl);
                    echo "Connection Success , This is Url : ", $info['url'], "\r\n";
                } else {
                    echo "Connection Failed =" . curl_error($curl);
                }
                curl_close($curl);
                // echo $response;die();
                $xmlresponse = trim(strtoupper(preg_replace('/\s\s+/', '', str_replace("\n", " ", $response))));
                $parsexml = simplexml_load_string($response);
                // var_dump($parsexml);die();
                $respon = $parsexml->code;
                // echo $respon;die();
                $Remark = strtoupper($parsexml->response->desc);
                $Remarks = $Remark == "" ? "NULL" : "'" . $Remark . "'";
                // if($ID == '213427'){
                //     var_dump($parsexml);die();
                // }
                if ($respon == 00) {
                    $loop = $parsexml->response->data->loop;
                    $countloop = count($loop);
                    if ($countloop > 0) {
                        foreach ($loop as $value) {
                            $NO_CONT = $value->cont_no;
                            $TYPE_CONT = $value->reefer == 'N' ? 'DRY' : 'RFR';
                            // echo $NO_CONT;die();
                            $SQL = "UPDATE t_request_cont SET UKR_CONT = '" . $value->cont_size . "', 
                                        TIPE_CONT  = '" . $TYPE_CONT . "', 
                                        KD_CONT_JENIS  = '" . $value->full_empty . "', 
                                        CALL_SIGN  = '" . $value->call_sign . "', 
                                        ISO_CODE  = '" . $value->isocode . "', 
                                        VOY_IN  = '" . $value->voyage_in . "', 
                                        VOY_OUT  = '" . $value->voyage_out . "', 
                                        FL_IMO  = '" . $value->imdg . "', 
                                        FL_OOG  = '" . $value->oog . "', 
                                        HOLD  = '" . $value->hold . "'
                                        WHERE ID = '" . $ID . "' AND NO_CONT = '" . $NO_CONT . "' ";
                            $Execute = $this->db->query($SQL);
                            // var_dump($Execute);die();
                            if ($Execute) {
                                echo 'success';
                            } else {
                                echo 'error';
                            }
                        }
                    }
                    if ($respon == 00) {
                        $KD_STATUS = 'SENT';
                        echo $KD_STATUS;
                        $respon = $parsexml->code;
                        echo $respon;
                    } else {
                        $KD_STATUS = 'ERROR';
                        $respon = $parsexml->code;
                        echo $respon;
                    }
                } else {
                    $Remarks = strtoupper($parsexml->description);
                    $KD_STATUS = 'ERROR';
                    echo $KD_STATUS;
                    echo $respon;
                    $Remarks = $Remarks == "" ? "NULL" : "'" . $Remarks . "'";
                }
                echo 'RESPONSE_REQ : ' . $Remarks;
                echo 'KD_STATUS : ' . $KD_STATUS;
                $SQL = "UPDATE t_request SET KD_REQ = '" . $KD_STATUS . "', RESPONSE_REQ  = " . $Remarks . "
                        WHERE ID = '" . $ID . "'";
                // var_dump($SQL);die();
                $Execute = $this->db->query($SQL);
                if ($Execute) {
                    echo 'success';
                } else {
                    echo 'error';
                }
                $SQL = "INSERT INTO `tpk_ipc`.`log_services` (`METHOD`, `USERNAME`, `XML_REQUEST`, `XML_RESPONSE`, `IPADDRESS`, `REMARKS`, `WK_REKAM`)VALUES ('RequestGatePassSP2MP', 'Scheduler RequestGatePassSP2MP', '$xml', '$xmlresponse', 'unknown', $Remarks, NOW())";
                // var_dump($SQL);die();
                $this->db->query($SQL);
            }
        }
        echo "string";
    }

    public function getInquiry()
    {
        $KdAPRF = 'GETINQUIRY';
        $KD_ORG_SENDER = '0';
        $KD_ORG_RECEIVER = '0';
        $url    = "https://api.npct1.co.id:9443/api/v1/getGatePassData";
        // $url    = "https://api.npct1.co.id:9443/api/v1/inquiryGatePass";
        $user   = "BEHANDLE";
        $key    = "5d3a2ffcb778f4b1c224f2447c048c8f";

        $SQL = "SELECT B.ID, A.JNS_DOK, B.NO_CONT, B.REF_NUMBER FROM t_request A INNER JOIN t_request_cont B ON A.ID = B.ID WHERE B.KD_STATUS='APPROVED' AND B.REF_NUMBER IS NOT NULL 
        ORDER BY B.ID DESC LIMIT 5";

        $Query = $this->db->query($SQL);

        if ($Query->num_rows() > 0) {
            foreach ($Query->result() as $key => $value) {
                $REF_NUMBER = $value->REF_NUMBER;
                $JNS_DOK = $value->JNS_DOK;
                $NO_CONT = $value->NO_CONT;
                $ID = $value->ID;

                if ($NO_CONT != '') {
                    $SQLCEK = "SELECT A.NO_CONT, A.ISO_CODE, A.REF_NUMBER, 'F' AS KD_CONT_JENIS
                    FROM t_request_cont A INNER JOIN t_request B ON A.ID = B.ID
                    WHERE A.ID = '" . $ID . "' AND A.NO_CONT = '" . $NO_CONT . "' AND A.KD_STATUS = 'APPROVED' AND A.REQ_PILIH = 'Y' AND A.REF_NUMBER IS NOT NULL";
                }

                $QueryKontainer =  $this->db->query($SQLCEK);
                if ($QueryKontainer->num_rows() > 0) {
                    foreach ($QueryKontainer->result() as $key => $value2) {
                        $REF_NUMBER = $value2->REF_NUMBER;
                        $xml = '<request><reff_number>' . $REF_NUMBER . '</reff_number></request>';
                        // var_dump($xml);die();
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => $url,
                            CURLOPT_SSL_VERIFYPEER => false,
                            CURLOPT_SSL_VERIFYHOST => false,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_CONNECTTIMEOUT => 10,
                            CURLOPT_TIMEOUT => 60,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => $xml,
                            CURLOPT_HTTPHEADER => array(
                                'User-ID: ' . $user,
                                'NPCT-API-Key: ' . $key,
                                'Content-Type: application/xml'
                            ),
                        ));
                        $response = curl_exec($curl);
                        if (!curl_errno($curl)) {
                            $info = curl_getinfo($curl);
                            echo "Connection Success , This is Url : ", $info['url'], "\r\n";
                        } else {
                            echo "Connection Failed =" . curl_error($curl);
                        }
                        curl_close($curl);
                        // var_dump($response);die();
                        $xmlresponse = trim(strtoupper(preg_replace('/\s\s+/', '', str_replace("\n", " ", $response))));
                        $xml = simplexml_load_string($response);
                        $code = $xml->code;
                        $status = $xml->status;
                        $loop = $xml->response->data->loop;
                        $countloop = count($loop);
                        // var_dump($countloop);die();
                        if ($code == 00) {
                            if ($countloop > 0) {
                                foreach ($loop as $value) {
                                    $NO_CONT = $value->cont_no;
                                    $TYPE_CONT = $value->reefer == 'N' ? 'DRY' : 'RFR';
                                    $paidthrough = Date('Y-m-d H:m:s.0', strtotime(str_replace("", "-", ($value->paidthrough))));
                                    $imdg = $value->imdg_value;
                                    $IMDG_VALUES = $imdg == "" ? "NULL" : "'" . $imdg . "'";
                                    // echo $NO_CONT;die();
                                    $SQL = "UPDATE t_request_cont A 
                                    JOIN t_request B
                                        ON A.ID = B.ID 
                                        SET A.KD_STATUS ='INQUIRY', B.KD_REQ ='INQUIRY', A.TGL_STATUS = NOW(), A.TAR = '" . $value->tar . "', A.BRUTO = '" . $value->weight . "', A.VESSEL= '" . $value->vessel_name . "', A.VOY_IN = '" . $value->voyage_in . "', A.VOY_OUT = '" . $value->voyage_out . "', A.IMO = " . $IMDG_VALUES  . ", B.SHIPPER = '" . $value->customer_name . "', A.POD1 = '" . $value->pod . "', A.POD2 = '" . $value->spod . "', A.CLOSING_TIME = '" . $paidthrough . "'
                                        WHERE
                                            A.REF_NUMBER = '" . $value->reff_number . "' AND
                                            A.NO_CONT = '" . $NO_CONT . "'
                                        ";
                                    // var_dump($SQL);die();
                                    $Execute = $this->db->query($SQL);
                                }
                            }
                            $data = array(
                                'KD_APRF' => $KdAPRF,
                                'KD_ORG_SENDER' => $KD_ORG_SENDER,
                                'KD_ORG_RECEIVER' => $KD_ORG_RECEIVER,
                                'STR_DATA' => $xmlresponse,
                                'KD_STATUS' => '100',
                                'TGL_STATUS' => date('Y-m-d H:i:s'),
                                'KETERANGAN' => $REF_NUMBER
                            );
                            $this->db->insert('mailbox', $data);
                            if ($Execute) {
                                echo "Success\n";
                            } else {
                                $messageErr = "error update sql\n";
                                echo $messageErr;
                            }
                        }
                    }
                } else {
                    echo "tidak ada\n";
                }
            }
        } else {
            echo "tidak ada\n";
        }
    }

    public function getInquiry_manual()
    {
        $no_cont = $this->input->get('no_cont');
        if (empty($no_cont)) {
            echo "Parameter no_cont is required\n";
            return;
        }
        $KdAPRF = 'GETINQUIRY';
        $KD_ORG_SENDER = '0';
        $KD_ORG_RECEIVER = '0';
        $url    = "https://api.npct1.co.id:9443/api/v1/getGatePassData";
        // $url    = "https://api.npct1.co.id:9443/api/v1/inquiryGatePass";
        $user   = "BEHANDLE";
        $key    = "5d3a2ffcb778f4b1c224f2447c048c8f";

        $SQL = "SELECT B.ID, A.JNS_DOK, B.NO_CONT, B.REF_NUMBER FROM t_request A INNER JOIN t_request_cont B ON A.ID = B.ID WHERE B.NO_CONT = '" . $no_cont . "' ORDER BY B.ID DESC LIMIT 5";

        $Query = $this->db->query($SQL);

        if ($Query->num_rows() > 0) {
            foreach ($Query->result() as $key => $value) {
                $REF_NUMBER = $value->REF_NUMBER;
                $JNS_DOK = $value->JNS_DOK;
                $NO_CONT = $value->NO_CONT;
                $ID = $value->ID;

                if ($NO_CONT != '') {
                    $SQLCEK = "SELECT A.NO_CONT, A.ISO_CODE, A.REF_NUMBER, 'F' AS KD_CONT_JENIS
                    FROM t_request_cont A INNER JOIN t_request B ON A.ID = B.ID
                    WHERE A.ID = '" . $ID . "' AND A.NO_CONT = '" . $NO_CONT . "'";
                }

                $QueryKontainer =  $this->db->query($SQLCEK);
                if ($QueryKontainer->num_rows() > 0) {
                    foreach ($QueryKontainer->result() as $key => $value2) {
                        $REF_NUMBER = $value2->REF_NUMBER;
                        $xml = '<request><reff_number>' . $REF_NUMBER . '</reff_number></request>';
                        // var_dump($xml);die();
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
                            CURLOPT_POSTFIELDS => $xml,
                            CURLOPT_HTTPHEADER => array(
                                'User-ID: ' . $user,
                                'NPCT-API-Key: ' . $key,
                                'Content-Type: application/xml'
                            ),
                        ));
                        $response = curl_exec($curl);
                        if (!curl_errno($curl)) {
                            $info = curl_getinfo($curl);
                            echo "Connection Success , This is Url : ", $info['url'], "\r\n";
                        } else {
                            echo "Connection Failed =" . curl_error($curl);
                        }
                        curl_close($curl);
                        // var_dump($response);die();
                        $xmlresponse = trim(strtoupper(preg_replace('/\s\s+/', '', str_replace("\n", " ", $response))));
                        echo $xmlresponse; // Debugging line
                        $xml = simplexml_load_string($response);
                        $code = $xml->code;
                        $status = $xml->status;
                        $loop = $xml->response->data->loop;
                        $countloop = count($loop);
                        // var_dump($countloop);die();
                        if ($code == 00) {
                            if ($countloop > 0) {
                                foreach ($loop as $value) {
                                    $NO_CONT = $value->cont_no;
                                    $TYPE_CONT = $value->reefer == 'N' ? 'DRY' : 'RFR';
                                    $paidthrough = Date('Y-m-d H:m:s.0', strtotime(str_replace("", "-", ($value->paidthrough))));
                                    $imdg = $value->imdg_value;
                                    $IMDG_VALUES = $imdg == "" ? "NULL" : "'" . $imdg . "'";
                                    // echo $NO_CONT;die();
                                    $SQL = "UPDATE t_request_cont A 
                                    JOIN t_request B
                                        ON A.ID = B.ID 
                                        SET A.KD_STATUS ='INQUIRY', B.KD_REQ ='INQUIRY', A.TGL_STATUS = NOW(), A.TAR = '" . $value->tar . "', A.BRUTO = '" . $value->weight . "', A.VESSEL= '" . $value->vessel_name . "', A.VOY_IN = '" . $value->voyage_in . "', A.VOY_OUT = '" . $value->voyage_out . "', A.IMO = " . $IMDG_VALUES  . ", B.SHIPPER = '" . $value->customer_name . "', A.POD1 = '" . $value->pod . "', A.POD2 = '" . $value->spod . "', A.CLOSING_TIME = '" . $paidthrough . "'
                                        WHERE
                                            A.REF_NUMBER = '" . $value->reff_number . "' AND
                                            A.NO_CONT = '" . $NO_CONT . "'
                                        ";
                                    // var_dump($SQL);die();
                                    $Execute = $this->db->query($SQL);
                                }
                            }
                            $data = array(
                                'KD_APRF' => $KdAPRF,
                                'KD_ORG_SENDER' => $KD_ORG_SENDER,
                                'KD_ORG_RECEIVER' => $KD_ORG_RECEIVER,
                                'STR_DATA' => $xmlresponse,
                                'KD_STATUS' => '100',
                                'TGL_STATUS' => date('Y-m-d H:i:s'),
                                'KETERANGAN' => $REF_NUMBER
                            );
                            $this->db->insert('mailbox', $data);
                            if ($Execute) {
                                echo "Success\n";
                            } else {
                                $messageErr = "error update sql\n";
                                echo $messageErr;
                            }
                        }
                    }
                } else {
                    echo "tidak ada\n";
                }
            }
        } else {
            echo "tidak ada\n";
        }
    }

    public function nhi()
    {

        $url    = "https://api.npct1.co.id:9443/api/v1/set-nhi";
        $user   = "BEHANDLE";
        $key    = "5d3a2ffcb778f4b1c224f2447c048c8f";

        $SQL = "SELECT DISTINCT ID, NO_DOK_INOUT, DATE_FORMAT(TGL_DOK_INOUT,'%Y%m%d') AS 'TGL_DOK', NM_ANGKUT, NO_VOY_FLIGHT AS 'VOY' 
        FROM t_permit_hdr 
        WHERE KD_DOK_INOUT = 81 and FL_NHI = 'N'
        ORDER BY ID DESC limit 7";
        $Query = $this->db->query($SQL);
        if ($Query->num_rows() > 0) {
            foreach ($Query->result() as $key => $value) {
                $idreq = $value->NO_DOK_INOUT;
                $nhi_no = $value->NO_DOK_INOUT;
                $nhi_date = $value->TGL_DOK;
                $vessel_name = $value->NM_ANGKUT;
                $voyage = $value->VOY;
                $id = $value->ID;

                $addXML = '<document> 
                <header> 
                        <nhi_no>' . $nhi_no . '</nhi_no> 
                        <nhi_date>' . $nhi_date . '</nhi_date> 
                        <vessel_name>' . $vessel_name . '</vessel_name> 
                        <voyage>' . $voyage . '</voyage> 
                </header>
                    ';
                $SQL = "SELECT DISTINCT A.NO_CONT, A.KD_CONT_UKURAN FROM t_permit_cont A INNER JOIN t_permit_hdr B ON A.ID = B.ID WHERE A.ID='" . $id . "'";

                $QueryKontainer = $this->db->query($SQL);

                if ($QueryKontainer->num_rows() > 0) {

                    $addXML .= '<detail>
                    ';
                    foreach ($QueryKontainer->result() as $key => $value2) {
                        $no_cont = $value2->NO_CONT;
                        $ukr = $value2->KD_CONT_UKURAN;
                        // $no_cont='FDCU0322521'; 
                        // $ukr ='40';
                        $addXML .= '<cont> 
                            <cont_no>' . $no_cont . '</cont_no> 
                            <cont_size>' . $ukr . '</cont_size> 
                    </cont>
                ';
                    }
                    $addXML .= '</detail>
                ';
                }
                $addXML .= '</document>
                ';

                $addXML = trim(preg_replace('/\s\s+/', '', str_replace("\n", " ", $addXML)));
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
                    CURLOPT_POSTFIELDS => $addXML,
                    CURLOPT_HTTPHEADER => array(
                        'User-ID: ' . $user,
                        'NPCT-API-Key: ' . $key,
                        'Content-Type: application/xml'
                    ),
                ));
                $response = curl_exec($curl);
                if (!curl_errno($curl)) {
                    $info = curl_getinfo($curl);
                    echo "Connection Success , This is Url : ", $info['url'], "\r\n";
                } else {
                    echo "Connection Failed =" . curl_error($curl);
                }
                curl_close($curl);
                // echo $response;
                $xml = simplexml_load_string($response);
                $json = json_encode($xml);
                $array = json_decode($json, TRUE);
                // var_dump($array['status']);
                if ($array['status'] == 'OK') {
                    $this->db->query("UPDATE t_permit_hdr SET FL_NHI = 'Y' WHERE ID = '$id'");
                    echo "Berhasil";
                } else {
                    echo "Gagal";
                }
                $this->db->query("INSERT INTO `tpk_ipc`.`log_nhi_baru` (`id_req`, `raw_data`, `respon_data`) VALUES ('$idreq', '$xml', '$json')");
            }
        } else {
            echo "Tidak Ada \r\n";
        }
    }

    public function getreefernpct1_trequest_Y()
    {

        $url    = "https://api.npct1.co.id:9443/api/v1/tracking";
        $user   = "BEHANDLE";
        $key    = "5d3a2ffcb778f4b1c224f2447c048c8f";

        // Query Lama
        // $q = $this->db->query("SELECT A.*,B.STATUS_CONT FROM (
        //         SELECT a.id,a.NO_DOK,a.TGL_DOK,b.NO_CONT,b.FL_TRACK,b.KD_STATUS,b.FL_INQUIRY_DONE FROM t_request a JOIN t_request_cont b ON a.id = b.id and fl_track = 'Y' AND b.kd_status = 'INQUIRY' AND b.FL_RFR_DONE = 'N' and b.TIPE_CONT = 'RFR') A
        //      JOIN (
        //         SELECT a.NO_DOK,a.TGL_DOK,b.NO_CONT,b.STATUS_CONT FROM t_spk a JOIN t_spk_cont b ON a.id = b.id  AND b.STATUS_CONT >= 450) B 
        //      ON A.no_dok = B.no_dok AND A.no_cont = B.no_cont
        //      WHERE DATE(A.TGL_DOK) >= DATE_ADD(NOW() , INTERVAL -30 DAY)");
        
        // Ini yg baru
        $q = $this->db->query("SELECT
                                    A.*,
                                    B.STATUS_CONT
                                from
                                    (
                                    select
                                        a.id,
                                        a.NO_DOK,
                                        a.TGL_DOK,
                                        b.NO_CONT,
                                        b.FL_TRACK,
                                        b.KD_STATUS,
                                        b.FL_INQUIRY_DONE
                                    from
                                        t_request a
                                    join t_request_cont b on
                                        a.id = b.id
                                    where
                                        b.fl_track = 'Y'
                                        and b.kd_status = 'INQUIRY'
                                        and b.FL_RFR_DONE = 'N'
                                        and b.TIPE_CONT = 'RFR'
                                ) A
                                join (
                                    select
                                        a.NO_DOK,
                                        a.TGL_DOK,
                                        b.NO_CONT,
                                        b.STATUS_CONT
                                    from
                                        t_spk a
                                    join t_spk_cont b on
                                        a.id = b.id
                                    where
                                        b.STATUS_CONT >= 450
                                ) B
                                on
                                    A.no_dok = B.no_dok
                                    and A.no_cont = B.no_cont
                                where
                                    A.TGL_DOK >= NOW() - interval 30 day
                                ORDER BY RAND()
                                limit 100)");

        // var_dump($q);die();
        $nocon11 = "";
        foreach ($q->result() as $key => $value1) {
            $nocon11 = $value1->NO_CONT;
            $addXML = '<request> 
            <containers>
                <cont_no>' . $value1->NO_CONT . '</cont_no> 
            </containers>';
            $addXML .= '</request>';
            // print_r($addXML);die();
            $addXML = trim(preg_replace('/\s\s+/', '', str_replace("\n", " ", $addXML)));

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_CONNECTTIMEOUT => 120, //tambah timeout
                CURLOPT_TIMEOUT => 240, //tambah timeout
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $addXML,
                CURLOPT_HTTPHEADER => array(
                    'User-ID: ' . $user,
                    'NPCT-API-Key: ' . $key,
                    'Content-Type: application/xml'
                ),
            ));
            $response = curl_exec($curl);
            if (!curl_errno($curl)) {
                $info = curl_getinfo($curl);
                echo "Connection Success , This is Url : ", $info['url'], "\r\n";
            } else {
                echo "Connection Failed =" . curl_error($curl);
            }
            curl_close($curl);
            // echo $response;die;
            // print_r($response);die();
            $xml = simplexml_load_string($response);
            // var_dump((string) $xml->containers[0]->gateout);die();
            $VESSEL_NAME = $xml->response->containers->vessel_name;
            $CALL_SIGN = $xml->response->containers->call_sign;
            $VOYAGE_IN = $xml->response->containers->voyage_in;
            $VOYAGE_OUT = $xml->response->containers->voyage_out;
            $CONT_NO = $xml->response->containers->cont_no;
            $SIZE = $xml->response->containers->cont_size;
            $JENIS = $xml->response->containers->full_empty;
            $slice = substr($SIZE, 0, 2);
            $ISOCODE = $xml->response->containers->isocode;
            $REEFER = $xml->response->containers->reefer;
            $REQ_TEMP = $xml->response->containers->reefer_req_temp;
            $ACT_TEMP = $xml->response->containers->reefer_act_temp;
            $PLUG = $xml->response->containers->reefer_plug_in;
            $UNPLUG = $xml->response->containers->reefer_plug_out;
            $IMDG = $xml->response->containers->imdg;
            $OOG = $xml->response->containers->oog;
            $DISCHARGE = $xml->response->containers->discharge;
            $tgl_bongkar = date_format(new DateTime($DISCHARGE), 'Y-m-d H:i:s');
            $GATEOUT = $xml->response->containers->gateout;
            $REFERENCE_NO = $xml->response->containers->reference_no;
            $HOLD = $xml->response->containers->hold;
            $ON_YARD = $xml->response->containers->on_yard;
            // print_r($DISCHARGE);die();
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
            // print_r($DISCHARGE);die();
            if ($REEFER == 'Y') {
                $SQL = "UPDATE t_request_cont SET FL_INQUIRY_DONE = 'Y', TIPE_CONT = 'RFR', KD_CONT_JENIS='$JENIS', UKR_CONT='$slice', VESSEL='$VESSEL_NAME', CALL_SIGN='$CALL_SIGN', VOY_IN='$VOYAGE_IN', VOY_OUT='$VOYAGE_OUT', ISO_CODE='$ISOCODE', $DISCHARGE_MOD, TEMP_CUST='$REQ_TEMP', TEMP_TERMINAL='$ACT_TEMP', $PLUGIN_MOD, $UNPLUGIN_MOD, FL_REEFER='$REEFER', FL_DG='$IMDG', FL_OOG='$OOG', HOLD='$HOLD', FL_YARD='$STAT', FL_TRACK='Y' WHERE ID = '" . $ID . "' AND NO_CONT = '" . $NO_CONT . "'";
            } else if ($REEFER == 'N') {
                $SQL = "UPDATE t_request_cont SET FL_INQUIRY_DONE = 'Y', TIPE_CONT = 'DRY', KD_CONT_JENIS='$JENIS', UKR_CONT='$slice', VESSEL='$VESSEL_NAME', CALL_SIGN='$CALL_SIGN', VOY_IN='$VOYAGE_IN', VOY_OUT='$VOYAGE_OUT', ISO_CODE='$ISOCODE', $DISCHARGE_MOD, $PLUGIN_MOD, $UNPLUGIN_MOD, FL_REEFER='$REEFER', FL_DG='$IMDG', FL_OOG='$OOG', HOLD='$HOLD', FL_YARD='$STAT', FL_TRACK='Y' WHERE ID = '" . $ID . "' AND NO_CONT = '" . $NO_CONT . "'";
            } else {
                $SQL = "UPDATE t_request_cont SET FL_TRACK='Y' WHERE ID = '" . $ID . "' AND NO_CONT = '" . $NO_CONT . "'";
            }
            $this->db->query($SQL);
            echo date("d-m-Y H:i:s") . " # " . $response . "\r\n";
            //die();
        }
    }

    public function getreefernpct1_trequest_B()
    {

        $url    = "https://api.npct1.co.id:9443/api/v1/tracking";
        $user   = "BEHANDLE";
        $key    = "5d3a2ffcb778f4b1c224f2447c048c8f";

        $q = $this->db->query("SELECT * FROM (SELECT * FROM t_request_cont
        WHERE date(tgl_status) >= DATE_ADD(NOW() , INTERVAL -10 DAY) AND tipe_cont = 'RFR') az
        WHERE fl_track = 'Y' AND kd_status = 'INQUIRY' AND fl_inquiry_done = 'Y' AND unplug_terminal IS null");
        // var_dump($q);die();
        $nocon11 = "";
        foreach ($q->result() as $key => $value1) {
            $nocon11 = $value1->NO_CONT;
            $addXML = '<request> 
            <containers>
                <cont_no>' . $value1->NO_CONT . '</cont_no> 
            </containers>';
            $addXML .= '</request>';
            $addXML = trim(preg_replace('/\s\s+/', '', str_replace("\n", " ", $addXML)));

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
                CURLOPT_POSTFIELDS => $addXML,
                CURLOPT_HTTPHEADER => array(
                    'User-ID: ' . $user,
                    'NPCT-API-Key: ' . $key,
                    'Content-Type: application/xml'
                ),
            ));
            $response = curl_exec($curl);
            if (!curl_errno($curl)) {
                $info = curl_getinfo($curl);
                echo "Connection Success , This is Url : ", $info['url'], "\r\n";
            } else {
                echo "Connection Failed =" . curl_error($curl);
            }
            curl_close($curl);
            // echo $response;die;
            // print_r($response);die();
            $xml = simplexml_load_string($response);
            // var_dump((string) $xml->containers[0]->gateout);die();
            $VESSEL_NAME = $xml->response->containers->vessel_name;
            $CALL_SIGN = $xml->response->containers->call_sign;
            $VOYAGE_IN = $xml->response->containers->voyage_in;
            $VOYAGE_OUT = $xml->response->containers->voyage_out;
            $CONT_NO = $xml->response->containers->cont_no;
            $SIZE = $xml->response->containers->cont_size;
            $JENIS = $xml->response->containers->full_empty;
            $slice = substr($SIZE, 0, 2);
            $ISOCODE = $xml->response->containers->isocode;
            $REEFER = $xml->response->containers->reefer;
            $REQ_TEMP = $xml->response->containers->reefer_req_temp;
            $ACT_TEMP = $xml->response->containers->reefer_act_temp;
            $PLUG = $xml->response->containers->reefer_plug_in;
            $UNPLUG = $xml->response->containers->reefer_plug_out;
            $IMDG = $xml->response->containers->imdg;
            $OOG = $xml->response->containers->oog;
            $DISCHARGE = $xml->response->containers->discharge;
            $tgl_bongkar = date_format(new DateTime($DISCHARGE), 'Y-m-d H:i:s');
            $GATEOUT = $xml->response->containers->gateout;
            $REFERENCE_NO = $xml->response->containers->reference_no;
            $HOLD = $xml->response->containers->hold;
            $ON_YARD = $xml->response->containers->on_yard;
            // print_r($DISCHARGE);die();
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
            // print_r($DISCHARGE);die();
            if ($REEFER == 'Y') {
                $SQL = "UPDATE t_request_cont SET FL_INQUIRY_DONE = 'Y', TIPE_CONT = 'RFR', KD_CONT_JENIS='$JENIS', UKR_CONT='$slice', VESSEL='$VESSEL_NAME', CALL_SIGN='$CALL_SIGN', VOY_IN='$VOYAGE_IN', VOY_OUT='$VOYAGE_OUT', ISO_CODE='$ISOCODE', $DISCHARGE_MOD, TEMP_CUST='$REQ_TEMP', TEMP_TERMINAL='$ACT_TEMP', $PLUGIN_MOD, $UNPLUGIN_MOD, FL_REEFER='$REEFER', FL_DG='$IMDG', FL_OOG='$OOG', HOLD='$HOLD', FL_YARD='$STAT', FL_TRACK='Y' WHERE ID = '" . $ID . "' AND NO_CONT = '" . $NO_CONT . "'";
            } else if ($REEFER == 'N') {
                $SQL = "UPDATE t_request_cont SET FL_INQUIRY_DONE = 'Y', TIPE_CONT = 'DRY', KD_CONT_JENIS='$JENIS', UKR_CONT='$slice', VESSEL='$VESSEL_NAME', CALL_SIGN='$CALL_SIGN', VOY_IN='$VOYAGE_IN', VOY_OUT='$VOYAGE_OUT', ISO_CODE='$ISOCODE', $DISCHARGE_MOD, $PLUGIN_MOD, $UNPLUGIN_MOD, FL_REEFER='$REEFER', FL_DG='$IMDG', FL_OOG='$OOG', HOLD='$HOLD', FL_YARD='$STAT', FL_TRACK='Y' WHERE ID = '" . $ID . "' AND NO_CONT = '" . $NO_CONT . "'";
            } else {
                $SQL = "UPDATE t_request_cont SET FL_TRACK='Y' WHERE ID = '" . $ID . "' AND NO_CONT = '" . $NO_CONT . "'";
            }
            $this->db->query($SQL);
            echo date("d-m-Y H:i:s") . " # " . $response . "\r\n";
            //die();
        }
    }

    public function getreefernpct1_trequest_R()
    {

        $url    = "https://api.npct1.co.id:9443/api/v1/tracking";
        $user   = "BEHANDLE";
        $key    = "5d3a2ffcb778f4b1c224f2447c048c8f";

        // Query Lama
        // $q = $this->db->query("SELECT * FROM (SELECT * FROM t_request_cont
        // WHERE date(tgl_status) >= DATE_ADD(NOW() , INTERVAL -10 DAY)) az
        // WHERE fl_track = 'Y' and FL_YARD = 'N' AND tipe_cont IS NULL AND kd_cont_jenis IS null AND kd_status <> 'INQUIRY'");

        // ini yg baru ges dikasih limit biar ga meledak
        $q = $this->db->query("SELECT *
                                FROM t_request_cont
                                WHERE tgl_status >= NOW() - INTERVAL 10 DAY
                                AND fl_track = 'Y'
                                AND FL_YARD = 'N'
                                AND tipe_cont IS NULL
                                AND kd_cont_jenis IS NULL
                                AND kd_status <> 'INQUIRY'
                                ORDER BY RAND()
                                LIMIT 10");
        // var_dump($q);die();
        $nocon11 = "";
        foreach ($q->result() as $key => $value1) {
            $nocon11 = $value1->NO_CONT;
            $addXML = '<request> 
            <containers>
                <cont_no>' . $value1->NO_CONT . '</cont_no> 
            </containers>';
            $addXML .= '</request>';
            $addXML = trim(preg_replace('/\s\s+/', '', str_replace("\n", " ", $addXML)));
            // print_r($addXML);die();
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_CONNECTTIMEOUT => 120, //tambah timeout
                CURLOPT_TIMEOUT => 240, //tambah timeout
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $addXML,
                CURLOPT_HTTPHEADER => array(
                    'User-ID: ' . $user,
                    'NPCT-API-Key: ' . $key,
                    'Content-Type: application/xml'
                ),
            ));
            $response = curl_exec($curl);
            if (!curl_errno($curl)) {
                $info = curl_getinfo($curl);
                echo "Connection Success , This is Url : ", $info['url'], "\r\n";
            } else {
                echo "Connection Failed =" . curl_error($curl);
            }
            curl_close($curl);
            // echo $response;die;
            // print_r($response);die();
            $xml = simplexml_load_string($response);
            // var_dump((string) $xml->containers[0]->gateout);die();
            $VESSEL_NAME = $xml->response->containers->vessel_name;
            $CALL_SIGN = $xml->response->containers->call_sign;
            $VOYAGE_IN = $xml->response->containers->voyage_in;
            $VOYAGE_OUT = $xml->response->containers->voyage_out;
            $CONT_NO = $xml->response->containers->cont_no;
            $SIZE = $xml->response->containers->cont_size;
            $JENIS = $xml->response->containers->full_empty;
            $slice = substr($SIZE, 0, 2);
            $ISOCODE = $xml->response->containers->isocode;
            $REEFER = $xml->response->containers->reefer;
            $REQ_TEMP = $xml->response->containers->reefer_req_temp;
            $ACT_TEMP = $xml->response->containers->reefer_act_temp;
            $PLUG = $xml->response->containers->reefer_plug_in;
            $UNPLUG = $xml->response->containers->reefer_plug_out;
            $IMDG = $xml->response->containers->imdg;
            $OOG = $xml->response->containers->oog;
            $DISCHARGE = $xml->response->containers->discharge;
            $tgl_bongkar = date_format(new DateTime($DISCHARGE), 'Y-m-d H:i:s');
            $GATEOUT = $xml->response->containers->gateout;
            $REFERENCE_NO = $xml->response->containers->reference_no;
            $HOLD = $xml->response->containers->hold;
            $ON_YARD = $xml->response->containers->on_yard;
            // print_r($DISCHARGE);die();
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
            // print_r($DISCHARGE);die();
            if ($REEFER == 'Y') {
                $SQL = "UPDATE t_request_cont SET FL_INQUIRY_DONE = 'Y', TIPE_CONT = 'RFR', KD_CONT_JENIS='$JENIS', UKR_CONT='$slice', VESSEL='$VESSEL_NAME', CALL_SIGN='$CALL_SIGN', VOY_IN='$VOYAGE_IN', VOY_OUT='$VOYAGE_OUT', ISO_CODE='$ISOCODE', $DISCHARGE_MOD, TEMP_CUST='$REQ_TEMP', TEMP_TERMINAL='$ACT_TEMP', $PLUGIN_MOD, $UNPLUGIN_MOD, FL_REEFER='$REEFER', FL_DG='$IMDG', FL_OOG='$OOG', HOLD='$HOLD', FL_YARD='$STAT', FL_TRACK='Y' WHERE ID = '" . $ID . "' AND NO_CONT = '" . $NO_CONT . "'";
            } else if ($REEFER == 'N') {
                $SQL = "UPDATE t_request_cont SET FL_INQUIRY_DONE = 'Y', TIPE_CONT = 'DRY', KD_CONT_JENIS='$JENIS', UKR_CONT='$slice', VESSEL='$VESSEL_NAME', CALL_SIGN='$CALL_SIGN', VOY_IN='$VOYAGE_IN', VOY_OUT='$VOYAGE_OUT', ISO_CODE='$ISOCODE', $DISCHARGE_MOD, $PLUGIN_MOD, $UNPLUGIN_MOD, FL_REEFER='$REEFER', FL_DG='$IMDG', FL_OOG='$OOG', HOLD='$HOLD', FL_YARD='$STAT', FL_TRACK='Y' WHERE ID = '" . $ID . "' AND NO_CONT = '" . $NO_CONT . "'";
            } else {
                $SQL = "UPDATE t_request_cont SET FL_TRACK='Y' WHERE ID = '" . $ID . "' AND NO_CONT = '" . $NO_CONT . "'";
            }
            $this->db->query($SQL);
            echo date("d-m-Y H:i:s") . " # " . $response . "\r\n";
            //die();
        }
    }

    public function getreefernpct1_trequest_dry()
    {

        $url    = "https://api.npct1.co.id:9443/api/v1/tracking";
        $user   = "BEHANDLE";
        $key    = "5d3a2ffcb778f4b1c224f2447c048c8f";

        $q = $this->db->query("SELECT * FROM (SELECT * FROM t_request_cont
        WHERE date(tgl_status) >= DATE_ADD(NOW() , INTERVAL -10 DAY) and KD_CONT_JENIS is null and KD_STATUS = 'INQUIRY') az
        WHERE az.FL_TRACK = 'Y' limit 10");
        // var_dump($q);die();
        $nocon11 = "";
        foreach ($q->result() as $key => $value1) {
            $nocon11 = $value1->NO_CONT;
            $addXML = '<request> 
            <containers>
                <cont_no>' . $value1->NO_CONT . '</cont_no> 
            </containers>';
            $addXML .= '</request>';
            $addXML = trim(preg_replace('/\s\s+/', '', str_replace("\n", " ", $addXML)));
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
                CURLOPT_POSTFIELDS => $addXML,
                CURLOPT_HTTPHEADER => array(
                    'User-ID: ' . $user,
                    'NPCT-API-Key: ' . $key,
                    'Content-Type: application/xml'
                ),
            ));
            $response = curl_exec($curl);
            if (!curl_errno($curl)) {
                $info = curl_getinfo($curl);
                echo "Connection Success , This is Url : ", $info['url'], "\r\n";
            } else {
                echo "Connection Failed =" . curl_error($curl);
            }
            curl_close($curl);
            // echo $response;die;
            // print_r($response);die();
            $xml = simplexml_load_string($response);
            // var_dump((string) $xml->containers[0]->gateout);die();
            $VESSEL_NAME = $xml->response->containers->vessel_name;
            $CALL_SIGN = $xml->response->containers->call_sign;
            $VOYAGE_IN = $xml->response->containers->voyage_in;
            $VOYAGE_OUT = $xml->response->containers->voyage_out;
            $CONT_NO = $xml->response->containers->cont_no;
            $SIZE = $xml->response->containers->cont_size;
            $JENIS = $xml->response->containers->full_empty;
            $slice = substr($SIZE, 0, 2);
            $ISOCODE = $xml->response->containers->isocode;
            $REEFER = $xml->response->containers->reefer;
            $REQ_TEMP = $xml->response->containers->reefer_req_temp;
            $ACT_TEMP = $xml->response->containers->reefer_act_temp;
            $PLUG = $xml->response->containers->reefer_plug_in;
            $UNPLUG = $xml->response->containers->reefer_plug_out;
            $IMDG = $xml->response->containers->imdg;
            $OOG = $xml->response->containers->oog;
            $DISCHARGE = $xml->response->containers->discharge;
            $tgl_bongkar = date_format(new DateTime($DISCHARGE), 'Y-m-d H:i:s');
            $GATEOUT = $xml->response->containers->gateout;
            $REFERENCE_NO = $xml->response->containers->reference_no;
            $HOLD = $xml->response->containers->hold;
            $ON_YARD = $xml->response->containers->on_yard;
            // print_r($DISCHARGE);die();
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
            // print_r($DISCHARGE);die();
            if ($REEFER == 'Y') {
                $SQL = "UPDATE t_request_cont SET FL_INQUIRY_DONE = 'Y', TIPE_CONT = 'RFR', KD_CONT_JENIS='$JENIS', UKR_CONT='$slice', VESSEL='$VESSEL_NAME', CALL_SIGN='$CALL_SIGN', VOY_IN='$VOYAGE_IN', VOY_OUT='$VOYAGE_OUT', ISO_CODE='$ISOCODE', $DISCHARGE_MOD, TEMP_CUST='$REQ_TEMP', TEMP_TERMINAL='$ACT_TEMP', $PLUGIN_MOD, $UNPLUGIN_MOD, FL_REEFER='$REEFER', FL_DG='$IMDG', FL_OOG='$OOG', HOLD='$HOLD', FL_YARD='$STAT', FL_TRACK='Y' WHERE ID = '" . $ID . "' AND NO_CONT = '" . $NO_CONT . "'";
            } else if ($REEFER == 'N') {
                $SQL = "UPDATE t_request_cont SET FL_INQUIRY_DONE = 'Y', TIPE_CONT = 'DRY', KD_CONT_JENIS='$JENIS', UKR_CONT='$slice', VESSEL='$VESSEL_NAME', CALL_SIGN='$CALL_SIGN', VOY_IN='$VOYAGE_IN', VOY_OUT='$VOYAGE_OUT', ISO_CODE='$ISOCODE', $DISCHARGE_MOD, $PLUGIN_MOD, $UNPLUGIN_MOD, FL_REEFER='$REEFER', FL_DG='$IMDG', FL_OOG='$OOG', HOLD='$HOLD', FL_YARD='$STAT', FL_TRACK='Y' WHERE ID = '" . $ID . "' AND NO_CONT = '" . $NO_CONT . "'";
            } else {
                $SQL = "UPDATE t_request_cont SET FL_TRACK='Y' WHERE ID = '" . $ID . "' AND NO_CONT = '" . $NO_CONT . "'";
            }
            $this->db->query($SQL);
            echo date("d-m-Y H:i:s") . " # " . $response . "\r\n";
            //die();
        }
    }

    public function getreefernpct1_trequest_Rfrdata()
    {

        $url    = "https://api.npct1.co.id:9443/api/v1/tracking";
        $user   = "BEHANDLE";
        $key    = "5d3a2ffcb778f4b1c224f2447c048c8f";

        $q = $this->db->query("SELECT * FROM (SELECT * FROM t_request_cont
        WHERE date(tgl_status) >= DATE_ADD(NOW() , INTERVAL -35 DAY)) az
        WHERE TIPE_CONT = 'RFR' and PLUG_TERMINAL is null and UNPLUG_TERMINAL is null and TEMP_CUST is null and TEMP_TERMINAL is NULL");
        // var_dump($q);die();
        $nocon11 = "";
        foreach ($q->result() as $key => $value1) {
            $nocon11 = $value1->NO_CONT;
            $addXML = '<request> 
            <containers>
                <cont_no>' . $value1->NO_CONT . '</cont_no> 
            </containers>';
            $addXML .= '</request>';
            // print_r($addXML);die();
            $addXML = trim(preg_replace('/\s\s+/', '', str_replace("\n", " ", $addXML)));

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
                CURLOPT_POSTFIELDS => $addXML,
                CURLOPT_HTTPHEADER => array(
                    'User-ID: ' . $user,
                    'NPCT-API-Key: ' . $key,
                    'Content-Type: application/xml'
                ),
            ));
            $response = curl_exec($curl);
            if (!curl_errno($curl)) {
                $info = curl_getinfo($curl);
                echo "Connection Success , This is Url : ", $info['url'], "\r\n";
            } else {
                echo "Connection Failed =" . curl_error($curl);
            }
            curl_close($curl);
            // echo $response;die;
            // print_r($response);die();
            $xml = simplexml_load_string($response);
            // var_dump((string) $xml->containers[0]->gateout);die();
            $VESSEL_NAME = $xml->response->containers->vessel_name;
            $CALL_SIGN = $xml->response->containers->call_sign;
            $VOYAGE_IN = $xml->response->containers->voyage_in;
            $VOYAGE_OUT = $xml->response->containers->voyage_out;
            $CONT_NO = $xml->response->containers->cont_no;
            $SIZE = $xml->response->containers->cont_size;
            $JENIS = $xml->response->containers->full_empty;
            $slice = substr($SIZE, 0, 2);
            $ISOCODE = $xml->response->containers->isocode;
            $REEFER = $xml->response->containers->reefer;
            $REQ_TEMP = $xml->response->containers->reefer_req_temp;
            $ACT_TEMP = $xml->response->containers->reefer_act_temp;
            $PLUG = $xml->response->containers->reefer_plug_in;
            $UNPLUG = $xml->response->containers->reefer_plug_out;
            $IMDG = $xml->response->containers->imdg;
            $OOG = $xml->response->containers->oog;
            $DISCHARGE = $xml->response->containers->discharge;
            $tgl_bongkar = date_format(new DateTime($DISCHARGE), 'Y-m-d H:i:s');
            $GATEOUT = $xml->response->containers->gateout;
            $REFERENCE_NO = $xml->response->containers->reference_no;
            $HOLD = $xml->response->containers->hold;
            $ON_YARD = $xml->response->containers->on_yard;
            // print_r($DISCHARGE);die();
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
            // print_r($DISCHARGE);die();
            if ($REEFER == 'Y') {
                $SQL = "UPDATE t_request_cont SET  TEMP_CUST='$REQ_TEMP', TEMP_TERMINAL='$ACT_TEMP', $PLUGIN_MOD, $UNPLUGIN_MOD, FL_REEFER='$REEFER' WHERE ID = '" . $ID . "' AND NO_CONT = '" . $NO_CONT . "'";
            } else {
                $SQL = "UPDATE t_request_cont SET FL_TRACK='Y' WHERE ID = '" . $ID . "' AND NO_CONT = '" . $NO_CONT . "'";
            }
            $this->db->query($SQL);
            echo date("d-m-Y H:i:s") . " # " . $response . "\r\n";
            //die();
        }
    }
    public function get_discharge()
    {
        $url    = "https://api.npct1.co.id:9443/api/v1/tracking";
        $user   = "BEHANDLE";
        $key    = "5d3a2ffcb778f4b1c224f2447c048c8f";

        // Lama tanpa limit
        // $q = $this->db->query("SELECT * FROM (SELECT * FROM t_request_cont
        // WHERE date(tgl_status) >= DATE_ADD(NOW() , INTERVAL -35 DAY)) az
        // WHERE DISCHARGE is null");
        // var_dump($q);die();

        // Baru limit 100 data tiap cron
        $q = $this->db->query("SELECT
                                    *
                                from
                                    t_request_cont
                                where
                                    DATE(tgl_status) >= DATE_ADD(NOW(), interval -35 day)
                                    and DISCHARGE is null
                                ORDER BY RAND()
                                limit 10");

        $nocon11 = "";
        foreach ($q->result() as $key => $value1) {
            $nocon11 = $value1->NO_CONT;
            $addXML = '<request> 
            <containers>
                <cont_no>' . $value1->NO_CONT . '</cont_no> 
            </containers>
                ';
            $addXML .= '</request>
            ';

            $addXML = trim(preg_replace('/\s\s+/', '', str_replace("\n", " ", $addXML)));
            // print_r($addXML);die();
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_CONNECTTIMEOUT => 120, //tambah timeout
                CURLOPT_TIMEOUT => 240, //tambah timeout
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $addXML,
                CURLOPT_HTTPHEADER => array(
                    'User-ID: ' . $user,
                    'NPCT-API-Key: ' . $key,
                    'Content-Type: application/xml'
                ),
            ));
            $response = curl_exec($curl);
            if (!curl_errno($curl)) {
                $info = curl_getinfo($curl);
                echo "Connection Success , This is Url : ", $info['url'], "\r\n";
            } else {
                echo "Connection Failed =" . curl_error($curl);
            }
            curl_close($curl);
            // echo $response;die;
            // print_r($response);die();
            $xml = simplexml_load_string($response);
            // var_dump((string) $xml->response->containers->vessel_name);die();
            $VESSEL_NAME = $xml->response->containers->vessel_name;
            $CALL_SIGN = $xml->response->containers->call_sign;
            $VOYAGE_IN = $xml->response->containers->voyage_in;
            $VOYAGE_OUT = $xml->response->containers->voyage_out;
            $CONT_NO = $xml->response->containers->cont_no;
            $SIZE = $xml->response->containers->cont_size;
            $JENIS = $xml->response->containers->full_empty;
            $slice = substr($SIZE, 0, 2);
            $ISOCODE = $xml->response->containers->isocode;
            $REEFER = $xml->response->containers->reefer;
            $REQ_TEMP = $xml->response->containers->reefer_req_temp;
            $ACT_TEMP = $xml->response->containers->reefer_act_temp;
            $PLUG = $xml->response->containers->reefer_plug_in;
            $UNPLUG = $xml->response->containers->reefer_plug_out;
            $IMDG = $xml->response->containers->imdg;
            $OOG = $xml->response->containers->oog;
            $DISCHARGE = $xml->response->containers->discharge;
            $tgl_bongkar = date_format(new DateTime($DISCHARGE), 'Y-m-d H:i:s');
            $GATEOUT = $xml->response->containers->gateout;
            $REFERENCE_NO = $xml->response->containers->reference_no;
            $HOLD = $xml->response->containers->hold;
            $ON_YARD = $xml->response->containers->on_yard;

            // print_r($tgl_bongkar);die();
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

            if ($GATEOUT != null) {
                $GATEOUT = date_format(new DateTime($GATEOUT), 'Y-m-d H:i:s');
                $GATEOUT_MOD = "WK_GATEOUT='$GATEOUT'";
            } else {
                $DISCHARGE = NULL;
                $GATEOUT_MOD = "WK_GATEOUT=NULL";
            }

            // print_r($DISCHARGE);die();
            if ($REEFER == 'Y') {
                $SQL = "UPDATE t_request_cont SET TIPE_CONT = 'RFR', KD_CONT_JENIS='$JENIS', UKR_CONT='$slice', VESSEL='$VESSEL_NAME', CALL_SIGN='$CALL_SIGN', VOY_IN='$VOYAGE_IN', VOY_OUT='$VOYAGE_OUT', ISO_CODE='$ISOCODE', $DISCHARGE_MOD, TEMP_CUST='$REQ_TEMP', TEMP_TERMINAL='$ACT_TEMP', $PLUGIN_MOD, $UNPLUGIN_MOD, $GATEOUT_MOD, FL_REEFER='$REEFER', FL_DG='$IMDG', FL_OOG='$OOG', HOLD='$HOLD', FL_YARD='$STAT' WHERE ID = '" . $ID . "' AND NO_CONT = '" . $NO_CONT . "'";
            } else if ($REEFER == 'N') {
                $SQL = "UPDATE t_request_cont SET TIPE_CONT = 'DRY', KD_CONT_JENIS='$JENIS', UKR_CONT='$slice', VESSEL='$VESSEL_NAME', CALL_SIGN='$CALL_SIGN', VOY_IN='$VOYAGE_IN', VOY_OUT='$VOYAGE_OUT', ISO_CODE='$ISOCODE', $DISCHARGE_MOD, $PLUGIN_MOD, $UNPLUGIN_MOD, $GATEOUT_MOD, FL_REEFER='$REEFER', FL_DG='$IMDG', FL_OOG='$OOG', HOLD='$HOLD', FL_YARD='$STAT' WHERE ID = '" . $ID . "' AND NO_CONT = '" . $NO_CONT . "'";
            } else {
                $SQL = "UPDATE t_request_cont SET FL_TRACK='Y' WHERE ID = '" . $ID . "' AND NO_CONT = '" . $NO_CONT . "'";
            }
            $this->db->query($SQL);
            echo date("d-m-Y H:i:s") . " # " . $response . "\r\n";
        }
    }

    public function get_discharge_wget()
    {
        $url    = "https://api.npct1.co.id:9443/api/v1/tracking";
        $user   = "BEHANDLE";
        $key    = "5d3a2ffcb778f4b1c224f2447c048c8f";

        $no_cont = $this->input->get('no_cont');
    
            // Validasi input
            if (empty($no_cont)) {
                echo "Error: parameter 'no_cont' wajib diisi, contoh: ?no_cont=TGHU1234567\r\n";
                return;
            }
        // Bangun XML request
            $addXML = '<request>
                <containers>
                    <cont_no>' . $no_cont . '</cont_no>
                </containers>
            </request>';

        $addXML = trim(preg_replace('/\s\s+/', '', str_replace("\n", " ", $addXML)));
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
            CURLOPT_POSTFIELDS => $addXML,
            CURLOPT_HTTPHEADER => array(
                'User-ID: ' . $user,
                'NPCT-API-Key: ' . $key,
                'Content-Type: application/xml'
            ),
        ));
        $response = curl_exec($curl);
        if (!curl_errno($curl)) {
            $info = curl_getinfo($curl);
            echo "Connection Success , This is Url : ", $info['url'], "\r\n";
        } else {
            echo "Connection Failed =" . curl_error($curl);
        }
        curl_close($curl);
        echo $response;
        die;
    }

    public function get_terminal_in_out()
    {
        $url    = "https://api.npct1.co.id:9443/api/v1/tracking";
        $user   = "BEHANDLE";
        $key    = "5d3a2ffcb778f4b1c224f2447c048c8f";

        $q = $this->db->query("SELECT A.NO_SPK, A.NO_CONT from t_operation A
            join t_spk B on A.NO_SPK = B.NO_SPK
            join t_spk_cont C on C.ID = B.ID and C.NO_CONT = A.NO_CONT
            where A.WK_TERMINAL_IN is null and B.WK_REQ > '2025-01-01'
            and C.STATUS_CONT != 900");

        foreach ($q->result() as $key => $value1) {
            echo "KONTAINER : " . $value1->NO_CONT . " SPK " . $value1->NO_SPK . "; ";
            $nocon11 = $value1->NO_CONT;
            $addXML = '<request> 
            <containers>
                <cont_no>' . $value1->NO_CONT . '</cont_no> 
            </containers>';
            $addXML .= '</request>';
            // print_r($addXML);die();
            $addXML = trim(preg_replace('/\s\s+/', '', str_replace("\n", " ", $addXML)));

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $addXML,
                CURLOPT_HTTPHEADER => array(
                    'User-ID: ' . $user,
                    'NPCT-API-Key: ' . $key,
                    'Content-Type: application/xml'
                ),
            ));
            $response = curl_exec($curl);
            if (!curl_errno($curl)) {
                $info = curl_getinfo($curl);
                echo "Connection Success , This is Url : ", $info['url'], "\r\n";
            } else {
                echo "Connection Failed =" . curl_error($curl);
            }
            curl_close($curl);
            $xml = simplexml_load_string($response);
            $GATEOUT = $xml->response->containers->gateout;
            $GATEIN = $xml->response->containers->gatein;

            if ($GATEOUT != null) {
                $GATEOUT = date_format(new DateTime($GATEOUT), 'Y-m-d H:i:s');
                $GATEOUT_MOD = "WK_TERMINAL_OUT='$GATEOUT'";
            } else {
                $GATEOUT = NULL;
                $GATEOUT_MOD = "WK_TERMINAL_OUT=NULL";
            }

            if ($GATEIN != null) {
                $GATEIN = date_format(new DateTime($GATEIN), 'Y-m-d H:i:s');
                $GATEIN_MOD = "WK_TERMINAL_IN='$GATEIN'";
            } else {
                $GATEIN = NULL;
                $GATEIN_MOD = "WK_TERMINAL_IN=NULL";
            }
            $SQL = "UPDATE t_operation SET $GATEOUT_MOD, $GATEIN_MOD WHERE NO_CONT = '" . $nocon11 . "' AND NO_SPK = '" . $value1->NO_SPK . "'";
            $this->db->query($SQL);
            echo date("d-m-Y H:i:s") . " # " . "WK TERMINAL IN = " . $GATEIN . ". # WK TERMINAL OUT = " . $GATEOUT . "\r\n";
        }
    }
    public function testfunc()
    {
        $url    = "https://api.npct1.co.id:9443/api/v1/get-ssm-ondemand";
        $user   = "BEHANDLE";
        $key    = "5d3a2ffcb778f4b1c224f2447c048c8f";
        $addXML = '<request>    
        				<request_no>201202CD241A20241016000007</request_no>
                        <document_no></document_no>
					</request>';

        $addXML = trim(preg_replace('/\s\s+/', '', str_replace("\n", " ", $addXML)));
        // print_r($addXML);die();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $addXML,
            CURLOPT_HTTPHEADER => array(
                'User-ID: ' . $user,
                'NPCT-API-Key: ' . $key,
                'Content-Type: application/xml'
            ),
        ));
        $response = curl_exec($curl);
        if (!curl_errno($curl)) {
            $info = curl_getinfo($curl);
            echo "Connection Success , This is Url : ", $info['url'], "\r\n";
        } else {
            echo "Connection Failed =" . curl_error($curl);
        }
        curl_close($curl);
        // echo $response;die;
        // print_r($response);die();
        // $xml = simplexml_load_string($response);
        // // var_dump((string) $xml->response->containers->vessel_name);die();
        // $VESSEL_NAME = $xml->response->containers->vessel_name;
        // $CALL_SIGN = $xml->response->containers->call_sign;
        // $VOYAGE_IN = $xml->response->containers->voyage_in;
        // $VOYAGE_OUT = $xml->response->containers->voyage_out;
        // $CONT_NO = $xml->response->containers->cont_no;
        // $SIZE = $xml->response->containers->cont_size;
        // $JENIS = $xml->response->containers->full_empty;
        // $slice = substr($SIZE, 0, 2);
        // $ISOCODE = $xml->response->containers->isocode;
        // $REEFER = $xml->response->containers->reefer;
        // $REQ_TEMP = $xml->response->containers->reefer_req_temp;
        // $ACT_TEMP = $xml->response->containers->reefer_act_temp;
        // $PLUG = $xml->response->containers->reefer_plug_in;
        // $UNPLUG = $xml->response->containers->reefer_plug_out;
        // $IMDG = $xml->response->containers->imdg;
        // $OOG = $xml->response->containers->oog;
        // $DISCHARGE = $xml->response->containers->discharge;
        // $tgl_bongkar = date_format(new DateTime($DISCHARGE), 'Y-m-d H:i:s');
        // $GATEOUT = $xml->response->containers->gateout;
        // $REFERENCE_NO = $xml->response->containers->reference_no;
        // $HOLD = $xml->response->containers->hold;
        $ON_YARD = $xml->response->containers->on_yard;

        // print_r($tgl_bongkar);die();
        // if ($ON_YARD == 'OK') {
        //     $STAT = 'Y';
        // } else {
        //     $STAT = 'N';
        // }

        // $ID = $value1->ID;
        // $NO_CONT = $value1->NO_CONT;
        // if ($PLUG != null or $PLUG != "") {
        //     $PLUGIN = date_format(new DateTime($PLUG), 'Y-m-d H:i:s');
        //     $PLUGIN_MOD = "PLUG_TERMINAL='$PLUGIN'";
        // } else {
        //     $PLUGIN = NULL;
        //     $PLUGIN_MOD = "PLUG_TERMINAL=NULL";
        // }

        // if ($UNPLUG != null or $UNPLUG != "") {
        //     $UNPLUGIN = date_format(new DateTime($UNPLUG), 'Y-m-d H:i:s');
        //     $UNPLUGIN_MOD = "UNPLUG_TERMINAL='$UNPLUGIN'";
        // } else {
        //     $UNPLUGIN = NULL;
        //     $UNPLUGIN_MOD = "UNPLUG_TERMINAL=NULL";
        // }

        // if ($DISCHARGE != null or $UNPLUG != "") {
        //     $DISCHARGE = date_format(new DateTime($DISCHARGE), 'Y-m-d H:i:s');
        //     $DISCHARGE_MOD = "DISCHARGE='$DISCHARGE'";
        // } else {
        //     $DISCHARGE = NULL;
        //     $DISCHARGE_MOD = "DISCHARGE=NULL";
        // }

        // // print_r($DISCHARGE);die();
        // if ($REEFER == 'Y') {
        //     $SQL = "UPDATE t_request_cont SET TIPE_CONT = 'RFR', KD_CONT_JENIS='$JENIS', UKR_CONT='$slice', VESSEL='$VESSEL_NAME', CALL_SIGN='$CALL_SIGN', VOY_IN='$VOYAGE_IN', VOY_OUT='$VOYAGE_OUT', ISO_CODE='$ISOCODE', $DISCHARGE_MOD, TEMP_CUST='$REQ_TEMP', TEMP_TERMINAL='$ACT_TEMP', $PLUGIN_MOD, $UNPLUGIN_MOD, FL_REEFER='$REEFER', FL_DG='$IMDG', FL_OOG='$OOG', HOLD='$HOLD', FL_YARD='$STAT' WHERE ID = '".$ID."' AND NO_CONT = '".$NO_CONT."'";
        // }else if ($REEFER == 'N') {
        //     $SQL = "UPDATE t_request_cont SET TIPE_CONT = 'DRY', KD_CONT_JENIS='$JENIS', UKR_CONT='$slice', VESSEL='$VESSEL_NAME', CALL_SIGN='$CALL_SIGN', VOY_IN='$VOYAGE_IN', VOY_OUT='$VOYAGE_OUT', ISO_CODE='$ISOCODE', $DISCHARGE_MOD, $PLUGIN_MOD, $UNPLUGIN_MOD, FL_REEFER='$REEFER', FL_DG='$IMDG', FL_OOG='$OOG', HOLD='$HOLD', FL_YARD='$STAT' WHERE ID = '".$ID."' AND NO_CONT = '".$NO_CONT."'";
        // }else{
        //     $SQL = "UPDATE t_request_cont SET FL_TRACK='Y' WHERE ID = '".$ID."' AND NO_CONT = '".$NO_CONT."'";
        // }
        // $this->db->query($SQL);
        echo date("d-m-Y H:i:s") . " # " . $response . "\r\n";
    }

    public function ssmnpct()
    {
        $url    = "https://api.npct1.co.id:9443/api/v1/setSSMOnDemand	";
        $user   = "BEHANDLE";
        $key    = "5d3a2ffcb778f4b1c224f2447c048c8f";
        $addXML = '<request>    
        					<request_no>201201768F3420241007000011</request_no>
						  </request>';

        $addXML = trim(preg_replace('/\s\s+/', '', str_replace("\n", " ", $addXML)));
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
            CURLOPT_POSTFIELDS => $addXML,
            CURLOPT_HTTPHEADER => array(
                'User-ID: ' . $user,
                'NPCT-API-Key: ' . $key,
                'Content-Type: application/xml'
            ),
        ));
        $response = curl_exec($curl);
        if (!curl_errno($curl)) {
            $info = curl_getinfo($curl);
            echo "Connection Success , This is Url : ", $info['url'], "<br>\r\n";
        } else {
            echo "Connection Failed =" . curl_error($curl);
        }
        curl_close($curl);
        $xml1 = str_replace('<?xml version="1.0"?>', "", $response);
        echo $response;
    }
}
