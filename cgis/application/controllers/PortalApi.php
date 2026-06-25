<?php defined('BASEPATH') or exit('No direct script access allowed');

class PortalApi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // if (!$this->session->userdata('LOGGED')) {
        //     redirect(base_url('index.php'), 'refresh');
        // }
    }

    public function gantiformattglgblk($tgl){
        $date=date_create_from_format("m/d/Y",$tgl);
        $date1 = date_format($date,"Y-m-d");
        return $date1;
    }
    public function formatdatenpct($tgl){
        $date=date_create_from_format("dmY",$tgl);
        $date1 = date_format($date,"Ymd");
        return $date1;
    }

    public function requestdokumen()
    {
        $type = $this->input->post('type');
        $no_dok = preg_replace('/\s+/', '', $this->input->post('nodok'));
        $nosppb = $this->input->post('nodok');
        $tglsppb = $this->input->post('tgldok');
        $npwpsppb = $this->input->post('npwp');
        $nomanual = preg_replace('/\s+/', '', $this->input->post('noman'));
        $tgl_dok = preg_replace("/[^a-zA-Z0-9]+/", "", $this->input->post('tgldok'));
        $tgl_dok_format_npct = $this->formatdatenpct(preg_replace("/[^a-zA-Z0-9]+/", "", $this->input->post('tgldok')));
        $npwp = preg_replace("/[^a-zA-Z0-9]+/", "", $this->input->post('npwp'));

        if ($type != '') {

            if ($type == 'sppb') {
                $url = "10.1.5.130/TPSServices/WsGetImpor_Sppb_NPCT1.php?NO_SPPB=$no_dok&TGL_SPPB=$tgl_dok&NPWP=$npwp";
            } elseif ($type == 'sppbnew') {
                $url    = "https://api.npct1.co.id:9443/api/v1/get-ondemand";
                $user   = "BEHANDLE";
                $key    = "5d3a2ffcb778f4b1c224f2447c048c8f";
                $addXML ='<request>
                <document_code>1</document_code>
                <document_no>'.$nosppb.'</document_no>
                <document_date>'.$tglsppb.'</document_date>
                <npwp>'.$npwpsppb.'</npwp>
                </request>';
                $addXML .='</request>
                ';

                $addXML= trim(preg_replace('/\s\s+/', '', str_replace("\n", " ", $addXML)));
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
                    echo "Connection Success , This is Url : ", $info['url'], "<br>\r\n";
                }else{
                    echo "Connection Failed =".curl_error($curl);
                }
                curl_close($curl); 
                $xml1 = str_replace('<?xml version="1.0"?>',"",$response);

                $xml = simplexml_load_string($xml1);
                $CAR = $xml->DOCUMENT->SPPB->HEADER->CAR;
                $NO_SPPB = $xml->DOCUMENT->SPPB->HEADER->NO_SPPB;
                $TGL_SPPB = $this->gantiformattglgblk($xml->DOCUMENT->SPPB->HEADER->TGL_SPPB);
                $KD_KPBC = $xml->DOCUMENT->SPPB->HEADER->KD_KPBC;
                $NO_PIB = $xml->DOCUMENT->SPPB->HEADER->NO_PIB;
                $TGL_PIB = $this->gantiformattglgblk($xml->DOCUMENT->SPPB->HEADER->TGL_PIB);
                $NPWP_IMP = $xml->DOCUMENT->SPPB->HEADER->NPWP_IMP;
                $NAMA_IMP = $xml->DOCUMENT->SPPB->HEADER->NAMA_IMP;
                $ALAMAT_IMP = $xml->DOCUMENT->SPPB->HEADER->ALAMAT_IMP;
                $NPWP_PPJK = $xml->DOCUMENT->SPPB->HEADER->NPWP_PPJK;
                $NAMA_PPJK = $xml->DOCUMENT->SPPB->HEADER->NAMA_PPJK;
                $ALAMAT_PPJK = $xml->DOCUMENT->SPPB->HEADER->ALAMAT_PPJK;
                $NM_ANGKUT = $xml->DOCUMENT->SPPB->HEADER->NM_ANGKUT;
                $NO_VOY_FLIGHT = $xml->DOCUMENT->SPPB->HEADER->NO_VOY_FLIGHT;
                $BRUTO = $xml->DOCUMENT->SPPB->HEADER->BRUTO;
                $NETTO = $xml->DOCUMENT->SPPB->HEADER->NETTO;
                $GUDANG = $xml->DOCUMENT->SPPB->HEADER->GUDANG;
                $STATUS_JALUR = $xml->DOCUMENT->SPPB->HEADER->STATUS_JALUR;
                $JML_CONT = $xml->DOCUMENT->SPPB->HEADER->JML_CONT;
                $NO_BC11 = $xml->DOCUMENT->SPPB->HEADER->NO_BC11;
                $TGL_BC11 = $this->gantiformattglgblk($xml->DOCUMENT->SPPB->HEADER->TGL_BC11);
                $NO_POS_BC11 = $xml->DOCUMENT->SPPB->HEADER->NO_POS_BC11;
                $NO_BL_AWB = $xml->DOCUMENT->SPPB->HEADER->NO_BL_AWB;
                $TG_BL_AWB = $this->gantiformattglgblk($xml->DOCUMENT->SPPB->HEADER->TG_BL_AWB);
                $NO_MASTER_BL_AWB = $xml->DOCUMENT->SPPB->HEADER->NO_MASTER_BL_AWB;
                $TG_MASTER_BL_AWB = $this->gantiformattglgblk($xml->DOCUMENT->SPPB->HEADER->TG_MASTER_BL_AWB);

            // echo 'CAR = '.$CAR.'<br>';
            // echo 'NO_SPPB = '.$NO_SPPB.'<br>';
            // echo 'TGL_SPPB = '.$TGL_SPPB.'<br>';
            // echo 'KD_KPBC = '.$KD_KPBC.'<br>';
            // echo 'NO_PIB = '.$NO_PIB.'<br>';
            // echo 'TGL_PIB = '.$TGL_PIB.'<br>';
            // echo 'NPWP_IMP = '.$NPWP_IMP.'<br>';
            // echo 'NAMA_IMP = '.$NAMA_IMP.'<br>';
            // echo 'ALAMAT_IMP = '.$ALAMAT_IMP.'<br>';
            // echo 'NPWP_PPJK = '.$NPWP_PPJK.'<br>';
            // echo 'NAMA_PPJK = '.$NAMA_PPJK.'<br>';
            // echo 'ALAMAT_PPJK = '.$ALAMAT_PPJK.'<br>';
            // echo 'NM_ANGKUT = '.$NM_ANGKUT.'<br>';
            // echo 'NO_VOY_FLIGHT = '.$NO_VOY_FLIGHT.'<br>';
            // echo 'BRUTO = '.$BRUTO.'<br>';
            // echo 'NETTO = '.$NETTO.'<br>';
            // echo 'GUDANG = '.$GUDANG.'<br>';
            // echo 'STATUS_JALUR = '.$STATUS_JALUR.'<br>';
            // echo 'JML_CONT = '.$JML_CONT.'<br>';
            // echo 'NO_BC11 = '.$NO_BC11.'<br>';
            // echo 'TGL_BC11 = '.$TGL_BC11.'<br>';
            // echo 'NO_POS_BC11 = '.$NO_POS_BC11.'<br>';
            // echo 'NO_BL_AWB = '.$NO_BL_AWB.'<br>';
            // echo 'TG_BL_AWB = '.$TG_BL_AWB.'<br>';
            // echo 'NO_MASTER_BL_AWB = '.$NO_MASTER_BL_AWB.'<br>';
            // echo 'TG_MASTER_BL_AWB = '.$$TG_MASTER_BL_AWB.'<br>';
            // echo 'DATA CONT <br>';

                foreach ($xml->DOCUMENT->SPPB->DETIL->CONT as $contdata){
                    $NO_CONT = $contdata->NO_CONT;
                    $SIZE = $contdata->SIZE;
                    $JNS_MUAT = $contdata->JNS_MUAT;
                    $datenow = date("Y-m-d H:i:s");
                //check document udah ada pa belom di permit
                    $query = $this->db->query("SELECT * from t_permit_hdr where NO_DOK_INOUT = '$NO_SPPB' and TGL_DOK_INOUT = '$TGL_SPPB'");
                    $count = $query->num_rows();
                    if ($count === 0){
                        $this->db->query("INSERT INTO t_permit_hdr (CAR, KD_KANTOR, KD_DOK_INOUT, NO_DOK_INOUT, TGL_DOK_INOUT, NO_DAFTAR_PABEAN, TGL_DAFTAR_PABEAN, ID_CONSIGNEE, CONSIGNEE, ALAMAT_CONSIGNEE, NPWP_PPJK, NAMA_PPJK, ALAMAT_PPJK, NM_ANGKUT, NO_VOY_FLIGHT, KD_GUDANG, JML_CONT, BRUTO, NETTO, NO_BC11, TGL_BC11, NO_POS_BC11, NO_BL_AWB, TGL_BL_AWB, NO_MASTER_BL_AWB, TGL_MASTER_BL_AWB, KD_KANTOR_PENGAWAS, KD_KANTOR_BONGKAR, FL_SEGEL, STATUS_JALUR, FL_KARANTINA, KD_STATUS, TGL_STATUS, FL_BAPLIE, BAPLIE_DATE, ANGKUTKODE_TPS, ANGKUTNAMA_TPS, ANGKUTNO_TPS, TMP_TIMBUN_TPS, STATUS, STATUS_MAIL, KD_STATUS_BIL, WK_STATUS, FL_MANUAL, OPERATOR, FL_MIGRASI, FL_NHI, FL_LNSW, LNSW_KD_RESPON, LNSW_IDLOG, LNSW_NOAJU, LNSW_TGLAJU)
                            VALUES ('$CAR', '$KD_KPBC', '1', '$NO_SPPB', '$TGL_SPPB', '$NO_PIB', '$TGL_PIB', '$NPWP_IMP', '$NAMA_IMP', '$ALAMAT_IMP', '$NPWP_PPJK', '$NAMA_PPJK', '$ALAMAT_PPJK', '$NM_ANGKUT', '$NO_VOY_FLIGHT', '$GUDANG', '$JML_CONT', '$BRUTO', '$NETTO', '$NO_BC11', '$TGL_BC11', '$NO_POS_BC11', '$NO_BL_AWB', '$TG_BL_AWB', '$NO_MASTER_BL_AWB', '$TG_MASTER_BL_AWB', NULL, NULL, NULL, '$STATUS_JALUR', NULL, '100', '$datenow', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', 'DASHBOARD', NULL, NULL, NULL, NULL, NULL, NULL, NULL)");
                        $insert_id = $this->db->insert_id();
                    //insert ke permit cont
                        $this->db->query("INSERT into t_permit_cont (ID, NO_CONT, KD_CONT_UKURAN, KD_CONT_JENIS, TGL_STATUS) values ('$insert_id', '$NO_CONT', '$SIZE', '$JNS_MUAT', '0000-00-00 00:00:00')");
                    } else {
                        $q = $this->db->query("SELECT * from t_permit_hdr where NO_DOK_INOUT = '$NO_SPPB' and TGL_DOK_INOUT = '$TGL_SPPB'");
                        foreach ($q->result() as $key => $value1) {
                         $permitid = $value1->ID;
                         echo 'insert pake id = '.$permitid;
                         // cek sudah ada data kontainer biar gak duplikat
                         $query = $this->db->query("SELECT * from t_permit_cont where ID = '$permitid' and NO_CONT = '$NO_CONT'");
                         $count = $query->num_rows();
                         if ($count === 0){
                            $this->db->query("INSERT IGNORE into t_permit_cont (ID, NO_CONT, KD_CONT_UKURAN, KD_CONT_JENIS, TGL_STATUS) values ('$permitid', '$NO_CONT', '$SIZE', '$JNS_MUAT', '0000-00-00 00:00:00')");
                        } else {
                            echo 'data dah ada.<br>';
                        }

                    }
                }
            }
            $responget = 'success';
            if (strpos($response, 'Data tidak ditemukan') !== false) {
                $responget = 'data tidak ditemukan';
            };
            // die();
            $this->db->query("INSERT INTO `tpk_ipc`.`solver_req_dokumen_log` (`url`, `tipe`, `no_dok`, `tgl_dok`, `npwp`, `data_respons`) VALUES ('https://api.npct1.co.id:9443/api/v1/get-ondemand', 'sppb', '$no_dok', '$tgl_dok', '$npwp', '$responget')");
         redirect("/PortalDashboard/doksppbnew");
        die();

        } elseif ($type == 'manual') {
            $url    = "https://api.npct1.co.id:9443/api/v1/get-ondemand";
                $user   = "BEHANDLE";
                $key    = "5d3a2ffcb778f4b1c224f2447c048c8f";
                $addXML ='<request>
                <document_code>31</document_code>
                <document_no>S-1171/KPU.01/BD.0404/2019</document_no>
                <document_date>12122019</document_date>
                <npwp></npwp>
                </request>';
                $addXML .='</request>
                ';

                $addXML= trim(preg_replace('/\s\s+/', '', str_replace("\n", " ", $addXML)));
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
                    echo "Connection Success , This is Url : ", $info['url'], "<br>\r\n";
                }else{
                    echo "Connection Failed =".curl_error($curl);
                }
                curl_close($curl); 
                $xml1 = str_replace('<?xml version="1.0"?>',"",$response);
                $xml = simplexml_load_string($xml1);
                echo $response;
                die();
                $ID = $xml->DOCUMENT->MANUAL->HEADER->ID;
                $KD_KANTOR = $xml->DOCUMENT->MANUAL->HEADER->KD_KANTOR; 
                $KD_DOK_INOUT = $xml->DOCUMENT->MANUAL->HEADER->KD_DOK_INOUT; 
                $NO_DOK_INOUT = $xml->DOCUMENT->MANUAL->HEADER->NO_DOK_INOUT; 
                $TGL_DOK_INOUT = $this->gantiformattglgblk($xml->DOCUMENT->MANUAL->HEADER->TGL_DOK_INOUT); 
                $ID_CONSIGNEE = $xml->DOCUMENT->MANUAL->HEADER->ID_CONSIGNEE; 
                $CONSIGNEE = $xml->DOCUMENT->MANUAL->HEADER->CONSIGNEE; 
                $NPWP_PPJK = $xml->DOCUMENT->MANUAL->HEADER->NPWP_PPJK; 
                $NAMA_PPJK = $xml->DOCUMENT->MANUAL->HEADER->NAMA_PPJK; 
                $NM_ANGKUT = $xml->DOCUMENT->MANUAL->HEADER->NM_ANGKUT; 
                $NO_VOY_FLIGHT = $xml->DOCUMENT->MANUAL->HEADER->NO_VOY_FLIGHT; 
                $KD_GUDANG = $xml->DOCUMENT->MANUAL->HEADER->KD_GUDANG; 
                $JML_CONT = $xml->DOCUMENT->MANUAL->HEADER->JML_CONT; 
                $NO_BC11 = $xml->DOCUMENT->MANUAL->HEADER->NO_BC11; 
                $TGL_BC11 = $this->gantiformattglgblk($xml->DOCUMENT->MANUAL->HEADER->TGL_BC11); 
                $NO_POS_BC11 = $xml->DOCUMENT->MANUAL->HEADER->NO_POS_BC11; 
                $NO_BL_AWB = $xml->DOCUMENT->MANUAL->HEADER->NO_BL_AWB; 
                $TG_BL_AWB = $this->gantiformattglgblk($xml->DOCUMENT->MANUAL->HEADER->TG_BL_AWB); 
                $FL_SEGEL = $xml->DOCUMENT->MANUAL->HEADER->FL_SEGEL;
                $datenow = date("Y-m-d H:i:s"); 
                
                echo 'ID = '.$ID.'<br>';
                echo 'KD_KANTOR = '.$KD_KANTOR.'<br>';
                echo 'KD_DOK_INOUT = '.$KD_DOK_INOUT.'<br>';
                echo 'NO_DOK_INOUT = '.$NO_DOK_INOUT.'<br>';
                echo 'TGL_DOK_INOUT = '.$TGL_DOK_INOUT.'<br>';
                echo 'ID_CONSIGNEE = '.$ID_CONSIGNEE.'<br>';
                echo 'CONSIGNEE = '.$CONSIGNEE.'<br>';
                echo 'NPWP_PPJK = '.$NPWP_PPJK.'<br>';
                echo 'NAMA_PPJK = '.$NAMA_PPJK.'<br>';
                echo 'NM_ANGKUT = '.$NM_ANGKUT.'<br>';
                echo 'NO_VOY_FLIGHT = '.$NO_VOY_FLIGHT.'<br>';
                echo 'KD_GUDANG = '.$KD_GUDANG.'<br>';
                echo 'JML_CONT = '.$JML_CONT.'<br>';
                echo 'NO_BC11 = '.$NO_BC11.'<br>';
                echo 'TGL_BC11 = '.$TGL_BC11.'<br>';
                echo 'NO_POS_BC11 = '.$NO_POS_BC11.'<br>';
                echo 'NO_BL_AWB = '.$NO_BL_AWB.'<br>';
                echo 'TG_BL_AWB = '.$TG_BL_AWB.'<br>';
                echo 'FL_SEGEL = '.$FL_SEGEL.'<br>';

            $responget = 'success';
            if (strpos($response, 'Data Tidak Ditemukan') !== false) {
                $responget = 'data tidak ditemukan';
            };

            if ($responget !== 'data tidak ditemukan') {
                $query = $this->db->query("SELECT * from t_permit_hdr where NO_DOK_INOUT = '$NO_DOK_INOUT' and TGL_DOK_INOUT = '$TGL_DOK_INOUT'");
                    $count = $query->num_rows();
                    if ($count === 0){
                        $this->db->query("INSERT INTO t_permit_hdr (CAR, KD_KANTOR, KD_DOK_INOUT, NO_DOK_INOUT, TGL_DOK_INOUT, ID_CONSIGNEE, CONSIGNEE, NPWP_PPJK, NAMA_PPJK, NM_ANGKUT, NO_VOY_FLIGHT, KD_GUDANG, JML_CONT, NO_BC11, TGL_BC11, NO_POS_BC11, NO_BL_AWB, TGL_BL_AWB, FL_SEGEL, TGL_STATUS)
                        VALUES ('$ID', '$KD_KANTOR', '$KD_DOK_INOUT', '$NO_DOK_INOUT', '$TGL_DOK_INOUT', '$ID_CONSIGNEE', '$CONSIGNEE', '$NPWP_PPJK', '$NAMA_PPJK', '$NM_ANGKUT', '$NO_VOY_FLIGHT', '$KD_GUDANG', '$JML_CONT', '$NO_BC11', '$TGL_BC11', '$NO_POS_BC11', '$NO_BL_AWB', '$TG_BL_AWB', '$FL_SEGEL', '$datenow')");
                        $insert_id = $this->db->insert_id();

                        foreach ($xml->DOCUMENT->MANUAL->DETIL->CONT as $contdata){
                            $ID = $contdata->ID;
                            $NO_CONT = $contdata->NO_CONT;
                            $SIZE = $contdata->SIZE;
                            $JNS_MUAT = $contdata->JNS_MUAT;
                            $this->db->query("INSERT IGNORE INTO t_permit_cont (ID, NO_CONT, KD_CONT_UKURAN, KD_CONT_JENIS, TGL_STATUS)
                                VALUES ('$insert_id', '$NO_CONT', '$SIZE', '$JNS_MUAT', '$datenow')");
                        }
                    }
            }
            $this->db->query("INSERT INTO `tpk_ipc`.`solver_req_dokumen_log` (`url`, `tipe`, `no_dok`, `tgl_dok`, `npwp`, `data_respons`) VALUES ('https://api.npct1.co.id:9443/api/v1/get-ondemand', '$type', '$no_dok', '$tgl_dok', '$npwp', '$responget')");
                //             echo '<textarea rows="30" cols="120">'.$response.'</textarea>';
                // die();
         redirect("/PortalDashboard/dokmanual");
        die();
        } elseif ($type == 'spjm') {
            $url = "10.1.5.130/TPSServices/WsGetSPJM_NPCT1.php?NO_PIB=$no_dok&TGL_PIB=$tgl_dok";
        } elseif ($type == 'npe') {
            redirect('http://10.1.5.130/TPSServices/curl.php');
                // $url = "10.1.5.130/TPSServices/curl.php";
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        $this->db->query("INSERT INTO `tpk_ipc`.`solver_req_dokumen_log` (`url`, `tipe`, `no_dok`, `tgl_dok`, `npwp`, `data_respons`) VALUES ('$url', '$type', '$no_dok', '$tgl_dok', '$npwp', '$output')");

    }

        if ($type == 'sppb') {
            $data['log_data'] = $this->db->query("SELECT a.*,b.NO_DOK_INOUT FROM solver_req_dokumen_log a LEFT JOIN t_permit_hdr b ON a.no_dok = b.NO_DOK_INOUT  WHERE a.tipe = 'sppb' ORDER BY a.id DESC LIMIT 20")->result();;
            echo $this->load->view("content/dashboard/doksppb", $data);
        } elseif ($type == 'manual') {
            $data['log_data'] = $this->db->query("SELECT a.*,b.NO_DOK_INOUT FROM solver_req_dokumen_log a LEFT JOIN t_permit_hdr b ON a.no_dok = b.NO_DOK_INOUT  WHERE a.tipe = 'manual' ORDER BY a.id DESC LIMIT 20")->result();;
            echo $this->load->view("content/dashboard/dokmanual", $data);
        } elseif ($type == 'spjm') {
            $data['log_data'] = $this->db->query("SELECT * FROM solver_req_dokumen_log WHERE tipe = 'spjm' ORDER BY id DESC LIMIT 20")->result();;
            echo $this->load->view("content/dashboard/dokspjm", $data);
        }
    }
}
