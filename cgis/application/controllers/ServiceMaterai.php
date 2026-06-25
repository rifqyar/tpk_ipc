<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ServiceMaterai extends CI_Controller {
    public $content;
    
    public function __construct() {
        parent::__construct();
    }

    public function index(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        $data = $this->load->view('content/monitoring/service_materai');
        echo $data;
    }

    public function viewmaterai(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        $this->load->model("m_service_materai");
        $header_nota = $this->m_service_materai->setting_point();
        $data_nota['maindata'] = $this->m_service_materai->monitoring_all_nota();
        $data_nota['faildata'] = $this->m_service_materai->failed_nota();

        $data = $this->load->view('content/monitoring/service_materai', $data_nota);
        echo $data;
    }

    public function create_nota_delivery(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json');
        $this->load->model("m_service_materai");
        $header_nota = $this->m_service_materai->setting_point();
        $data_nota = $this->m_service_materai->get_list_nota_delivery();
        foreach ($data_nota as $list_nota) {

            $id = $list_nota->ID_REQ;
            // $id = 'tes ngadi';
            // echo '<br>';
            //proses create nota, contek dari billing
            $this->load->library('mpdf');
            $this->load->model("m_execute");
            $sess = 'not a session';
            $data['title'] = "".$sess; 
            $this->load->model("m_billing_delivery_materai");
            // $this->m_billing_delivery_materai->history_delivery($id);
            $data['result'] = $this->m_billing_delivery_materai->get_nota_del($id);
            $data['result_hdr'] = $this->m_billing_delivery_materai->get_nota_del_hdr($id);
            $data['result_cust'] = $this->m_billing_delivery_materai->get_nota_cust($id);
            $data['result_cont'] = $this->m_billing_delivery_materai->get_nota_cont($id);
            $data['result_reefer'] = $this->m_billing_delivery_materai->get_nota_reefer($id);
            $this->load->view('content/billing/delivery/simulasi3', $data);
            //update ke W agar nota tidak di create ulang
            $this->m_service_materai->update_stat_nota($id);
        }
    }
    public function create_nota_behandle(){
        $this->load->model("m_service_materai");
        $header_nota = $this->m_service_materai->setting_point();
        $data_nota = $this->m_service_materai->get_list_nota_behanle();
        if (empty($data_nota)) {
            echo 'no data';
        } else {
            foreach ($data_nota as $list_nota) {

            $id = $list_nota->ID_REQ;
            // $id = 'not a value';
            $data['id'] = $id;
            // var_dump($id);die();
            $this->load->library('mpdf');
            $this->load->model("m_execute");
            $sess = 'not a session';
            $data['title'] = "".$sess; 
            $this->load->model("m_billing_behandle_materai");
            $data['result'] = $this->m_billing_behandle_materai->get_nota_behandle($id);
            $data['result_hdr'] = $this->m_billing_behandle_materai->get_nota_behandle_hdr($id);
            $data['result_cust'] = $this->m_billing_behandle_materai->get_nota_cust($id);
            $data['result_cont'] = $this->m_billing_behandle_materai->get_nota_beh($id);
            $data['result_materai'] = $this->m_billing_behandle_materai->get_nota_materai();
            $this->load->view('content/billing/cetak_nota_behandle_materai', $data);
            //update ke W agar nota tidak di create ulang
            $this->m_service_materai->update_stat_nota_bhd($id);
        }
        }
    }
    public function cetak_nota_del_bpas2($act, $id) {

        $arrid = explode('~',$this->input->get('id'));
        $id = $arrid[0];

        $this->load->library('mpdf');
        $this->load->model("m_execute");
        $sess = 'not a session';
        $data['title'] = "".$sess; 
        $this->load->model("m_billing_delivery_materai");
        // $this->m_billing_delivery_materai->history_delivery($id);
        $data['result'] = $this->m_billing_delivery_materai->get_nota_del($id);
        $data['result_hdr'] = $this->m_billing_delivery_materai->get_nota_del_hdr($id);
        $data['result_cust'] = $this->m_billing_delivery_materai->get_nota_cust($id);
        $data['result_cont'] = $this->m_billing_delivery_materai->get_nota_cont($id);
        $data['result_reefer'] = $this->m_billing_delivery_materai->get_nota_reefer($id);
        $this->load->view('content/billing/delivery/simulasi3', $data);
    }
    public function get_access_token(){
        header('Content-Type: application/json');
        $this->load->model("m_service_materai");

        $header = $this->m_service_materai->setting_point();
        $url = $header['LINK_AUTH'];
        $postdata = $header['AUTH_INFO'];

        $post_service = $this->m_service_materai->postman($url, $postdata);
        $decoded_json = json_decode($post_service, false);

        if ($decoded_json->status != 0) {
            $msg = $decoded_json->message;
        } else {
            $access_token = $decoded_json->access_token;
            $expire = $decoded_json->expire_at;
            $additionalinfo = json_encode($decoded_json->data);
            $tokenid = json_encode($decoded_json->ID);

            $insert_tokeen = $this->m_service_materai->insert_token($access_token, $expire, $additionalinfo);
            echo $insert_tokeen;
            echo "<br>";
        }
    }

    //kirim kirim nota
    public function send_nota_bhd(){
        header('Content-Type: application/json');
        $this->load->model("m_service_materai");
        $token = $this->m_service_materai->get_latest_token();
        $active_token = $token['ACCESS_TOKEN'];
        // ambil nota yang udah ada file pdf
        $data_nota = $this->m_service_materai->nota_bhd_tercetak();
        //////////////
        $header_nota = $this->m_service_materai->setting_point();
        $KODE_CABANG = $header_nota['KODE_CABANG'];
        $KODE_LOKASI = $header_nota['KODE_LOKASI'];
        $KODE_JNS_DOK = $header_nota['KODE_JNS_DOK'];
        $URL_NOTA = $header_nota['LINK_NOTA'];
        $SIMOP = $header_nota['SIMOP'];
        $PATHNOTA = $header_nota['PATHNOTA'];
        $IDREQ = $data_nota[0]->ID_REQ;
        $NO_NOTA = $data_nota[0]->NO_NOTA_BEHANDLE;

        if (empty($data_nota)) {
          echo "Tidak ada nota yang perlu dikirim";
        } else {
          // echo "nota ".$data_nota[0]->NO_NOTA_BEHANDLE." perlu dikirim";

            $nota = array(
                'NO_DOK' => $data_nota[0]->NO_NOTA_BEHANDLE, 
                'KODE_CABANG' => $KODE_CABANG, 
                'KODE_LOKASI' => $KODE_LOKASI, 
                'KODE_JNS_DOK' => $KODE_JNS_DOK, 
                'SIMOP' => $SIMOP,
                'NPWP' => $data_nota[0]->NPWP, 
                'NILAI_NOTA' => $data_nota[0]->TOTAL_JUMLAH, 
                'NILAI_MATERAI' => $data_nota[0]->BIAYA_MATERAI, 
                'KET' => '-', 
                'FILE' => $PATHNOTA.$data_nota[0]->NO_NOTA_BEHANDLE.'.pdf',
            );

            //curl
            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => $URL_NOTA,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_SSL_VERIFYPEER => false,
              CURLOPT_SSL_VERIFYHOST => false,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS => array('NO_DOK' => $data_nota[0]->NO_NOTA_BEHANDLE,
                'KODE_CABANG' => $KODE_CABANG,
                'KODE_LOKASI' => $KODE_LOKASI,
                'KODE_JNS_DOK' => $KODE_JNS_DOK,
                'SIMOP' => '-',
                'NAMA_CUST' => $data_nota[0]->NAMA_CUST,
                'NPWP' => $data_nota[0]->NPWP,
                'NILAI_NOTA' => $data_nota[0]->TOTAL_JUMLAH,
                'NILAI_MATERAI' => $data_nota[0]->BIAYA_MATERAI,
                'KET' => '-',
                'FILE'=> '@'.$PATHNOTA.$data_nota[0]->NO_NOTA_BEHANDLE.'.pdf'),
              CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Authorization: Bearer '.$active_token,
                'Cookie: visid_incap_2917632=85Y5H5kKTsmvrLG61JMQmm6v1WQAAAAAQUIPAAAAAADCokIMffqYlewEVInOHnOl'
              ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            echo $response;
            echo "\n";
            echo "\n";
            $decoded_json = json_decode($response, false);
            $msg = $decoded_json->message;
            $data = $decoded_json->data;
            $encodeddata = json_encode($data);
            $id_transaksi = $decoded_json->data->ID;

            echo $msg;
            echo "\n";
            echo json_encode($data);
            echo "\n";
            echo $id_transaksi;


            if ($msg == 'success') {
                $SQL = "UPDATE req_behandle_hdr set FL_SEND_EMATERAI_SERVICE = 'S' where ID_REQ = '$IDREQ'";
                $Query =$this->db->query($SQL);

                $SQLSUCC = "INSERT INTO e_materai_services_main
                (RESPONSE_ID, NO_NOTA, RESPONSE, RAW_RESPONSE)
                VALUES('$id_transaksi', '$NO_NOTA', '$msg', '$encodeddata')";
                $execqsucc = $this->db->query($SQLSUCC);
            } else {
                $SQL = "UPDATE req_behandle_hdr set FL_SEND_EMATERAI_SERVICE = 'F' where ID_REQ = '$IDREQ'";
                $Query =$this->db->query($SQL);

                $SQLSUCC = "INSERT INTO e_materai_services_main
                (RESPONSE_ID, NO_NOTA, RESPONSE, RAW_RESPONSE)
                VALUES('$id_transaksi', '$NO_NOTA', '$msg', '$encodeddata')";
                $execqsucc = $this->db->query($SQLSUCC);
            }

        }
    }
    public function send_nota_del(){
        header('Content-Type: application/json');
        $this->load->model("m_service_materai");
        $token = $this->m_service_materai->get_latest_token();
        $active_token = $token['ACCESS_TOKEN'];
        // ambil nota yang udah ada file pdf
        $data_nota = $this->m_service_materai->nota_del_tercetak();
        $header_nota = $this->m_service_materai->setting_point();
        $KODE_CABANG = $header_nota['KODE_CABANG'];
        $KODE_LOKASI = $header_nota['KODE_LOKASI'];
        $KODE_JNS_DOK = $header_nota['KODE_JNS_DOK'];
        $SIMOP = $header_nota['SIMOP'];
        $PATHNOTA = $header_nota['PATHNOTA'];
        $URL_NOTA = $header_nota['LINK_NOTA'];
        $IDREQ = $data_nota[0]->ID_REQ;
        $NO_NOTA = $data_nota[0]->NO_NOTA_DELIVERY;

        if (empty($data_nota)) {
          echo "Tidak ada nota yang perlu dikirim";
        } else {
          // echo "nota ".$data_nota[0]->NO_NOTA_BEHANDLE." perlu dikirim";

            $nota = array(
                'TOKEN' => 'Bearer '.$active_token, 
                'NO_DOK' => $data_nota[0]->NO_NOTA_DELIVERY, 
                'KODE_CABANG' => $KODE_CABANG, 
                'KODE_LOKASI' => $KODE_LOKASI, 
                'KODE_JNS_DOK' => $KODE_JNS_DOK, 
                'SIMOP' => $SIMOP, 
                'NAMA_CUST' => $data_nota[0]->NAMA_CUST,
                'NPWP' => $data_nota[0]->NPWP, 
                'NILAI_NOTA' => $data_nota[0]->TOTAL, 
                'NILAI_MATERAI' => $data_nota[0]->BIAYA_MATERAI, 
                'KET' => '-', 
                'FILE' => $PATHNOTA.$data_nota[0]->NO_NOTA_DELIVERY.'.pdf',
            );

        // die();
            //curl
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => $URL_NOTA,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_SSL_VERIFYPEER => false,
              CURLOPT_SSL_VERIFYHOST => false,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS => array('NO_DOK' => $data_nota[0]->NO_NOTA_DELIVERY,
                'KODE_CABANG' => $KODE_CABANG,
                'KODE_LOKASI' => $KODE_LOKASI,
                'KODE_JNS_DOK' => $KODE_JNS_DOK,
                'SIMOP' => '-',
                'NAMA_CUST' => $data_nota[0]->NAMA_CUST,
                'NPWP' => $data_nota[0]->NPWP,
                'NILAI_NOTA' => $data_nota[0]->TOTAL,
                'NILAI_MATERAI' => $data_nota[0]->BIAYA_MATERAI,
                'KET' => '-',
                'FILE'=> '@'.$PATHNOTA.$data_nota[0]->NO_NOTA_DELIVERY.'.pdf'),
              CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Authorization: Bearer '.$active_token,
                'Cookie: visid_incap_2917632=85Y5H5kKTsmvrLG61JMQmm6v1WQAAAAAQUIPAAAAAADCokIMffqYlewEVInOHnOl'
              ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            echo $response;
            echo "\n";
            echo "\n";
            $decoded_json = json_decode($response, false);
            $msg = $decoded_json->message;
            $data = $decoded_json->data;
            $encodeddata = json_encode($data);
            $id_transaksi = $decoded_json->data->ID;

            echo $msg;
            echo "\n";
            echo json_encode($data);
            echo "\n";
            echo $id_transaksi;


            if ($msg == 'success') {
                $SQL = "UPDATE req_delivery_hdr set FL_SEND_EMATERAI_SERVICE = 'S' where ID_REQ = '$IDREQ'";
                $Query =$this->db->query($SQL);

                $SQLSUCC = "INSERT INTO e_materai_services_main
                (RESPONSE_ID, NO_NOTA, RESPONSE, RAW_RESPONSE)
                VALUES('$id_transaksi', '$NO_NOTA', '$msg', '$encodeddata')";
                $execqsucc = $this->db->query($SQLSUCC);
            } else {
                $SQL = "UPDATE req_delivery_hdr set FL_SEND_EMATERAI_SERVICE = 'F' where ID_REQ = '$IDREQ'";
                $Query =$this->db->query($SQL);

                $SQLSUCC = "INSERT INTO e_materai_services_main
                (RESPONSE_ID, NO_NOTA, RESPONSE, RAW_RESPONSE)
                VALUES('$id_transaksi', '$NO_NOTA', '$msg', '$encodeddata')";
                $execqsucc = $this->db->query($SQLSUCC);
            }

        }
    }
    public function stamp_nota(){
        header('Content-Type: application/json');
        $this->load->model("m_service_materai");
        $token = $this->m_service_materai->get_latest_token();
        $active_token = $token['ACCESS_TOKEN'];

        //ambil data nota siap di stamp
        $data_nota_siapstamp = $this->m_service_materai->nota_del_siap_stamp();
        $header_nota = $this->m_service_materai->setting_point();

        //olah data header nota
        $LINK_STAMP = $header_nota['LINK_STAMP'];

        //////////////////langsung loop nota yang siap kirim

        foreach ($data_nota_siapstamp as $list_nota) {
            $IDREQ = $list_nota->ID_REQ;
            $IDRESPONSE = $list_nota->RESPONSE_ID;
            $NO_NOTA = $list_nota->NO_NOTA;
            echo "\r\n";
            echo 'sending request to '.$LINK_STAMP.$IDRESPONSE;
            echo "\r\n";

            //KIRIM KE SERVICE

        $url_sementara = 'https://emeterai.multiterminal.co.id:2045/services/SvcDokumenProses/stamp/4f5b532f-5306-43c3-aa0e-75b97e3eba92';

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => $LINK_STAMP.$IDRESPONSE,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_SSL_VERIFYHOST => false,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Authorization: Bearer '.$active_token,
            'Cookie: visid_incap_2917632=85Y5H5kKTsmvrLG61JMQmm6v1WQAAAAAQUIPAAAAAADCokIMffqYlewEVInOHnOl'
          ),
        ));

        $response = curl_exec($curl);

        echo $response;
        echo "\r\n";

        curl_close($curl);
        echo "\n";
        $decoded_json = json_decode($response, false);
        $msg = $decoded_json->message;
        $data = $decoded_json->data;
        $encodeddata = json_encode($data);
        echo "\n";
        echo $msg;
        echo "\n";
        echo $IDRESPONSE;
        echo "\n";
        echo $IDREQ;

        if ($msg == 'HTTP 404 Not Found') {
            echo 'no nota to stamp';
        } else {
            if (strpos($IDREQ, 'BHD') !== false) {
                if ($msg == 'success') {
                    $SQL = "UPDATE req_behandle_hdr set FL_SEND_EMATERAI_SERVICE = 'V' where ID_REQ = '$IDREQ'";
                    $Query =$this->db->query($SQL);
                } else {
                    $SQL = "UPDATE req_behandle_hdr set FL_SEND_EMATERAI_SERVICE = 'Z' where ID_REQ = '$IDREQ'";
                    $Query =$this->db->query($SQL);
                }
            } else {
                if ($msg == 'success') {
                    $SQL = "UPDATE req_delivery_hdr set FL_SEND_EMATERAI_SERVICE = 'V' where ID_REQ = '$IDREQ'";
                    $Query =$this->db->query($SQL);
                } else {
                    $SQL = "UPDATE req_delivery_hdr set FL_SEND_EMATERAI_SERVICE = 'Z' where ID_REQ = '$IDREQ'";
                    $Query =$this->db->query($SQL);
                }
            }
        }


        $SQL = "INSERT INTO e_materai_stamp_log
                (RESPONSE_ID, NO_NOTA, RESPONSE, RAW_RESPONSE)
                VALUES('$IDRESPONSE', '$NO_NOTA', '$msg', '$encodeddata')";
        $Query =$this->db->query($SQL);

        }
    }



    // public function tokens(){
    //     header('Content-Type: application/json');
    //     $this->load->model("m_service_materai");
    //     $active_token = $this->m_service_materai->get_latest_token();
    //     $token = $active_token['ACCESS_TOKEN'];
    //     $tokenid = $header['ID_LOGIN'];


    //     echo $token;
    // }
    public function lihat_nota(){
        $nota = $this->input->get('nota');
        $this->load->model("m_service_materai");
        $header = $this->m_service_materai->setting_point();
        $url = $header['LINK_STAMPED_NOTA'];
        $data_nota = $this->m_service_materai->get_id_nota($nota);

        foreach ($data_nota as $list_nota) {
            $link = $list_nota->RESPONSE_ID;
            header("Location: ".$url."".$link.".pdf");
        }
    }

    //verifikasi status stamp
    public function stamp_status_test(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json');
        $this->load->model("m_service_materai");
        $header = $this->m_service_materai->setting_point();
        $url = $header['LINK_CEK_STATUS_STAMP'];
        $token = $this->m_service_materai->get_latest_token();
        $active_token = $token['ACCESS_TOKEN'];
        $data_nota = $this->m_service_materai->stamp_status_manual();
        
        foreach ($data_nota as $list_nota) {
            $nomor = $list_nota->NO_NOTA;
            $IDREQ = $list_nota->ID_REQ;
            echo "\r\n";
            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => $url.$nomor,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_SSL_VERIFYPEER => false,
              CURLOPT_SSL_VERIFYHOST => false,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'GET',
              CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Authorization: Bearer '.$active_token,
                'Cookie: visid_incap_2917632=85Y5H5kKTsmvrLG61JMQmm6v1WQAAAAAQUIPAAAAAADCokIMffqYlewEVInOHnOl'
            ),
          ));

            $response = curl_exec($curl);
            curl_close($curl);
            $decoded_json = json_decode($response, false);
            $msg = $decoded_json->message;
            $data = $decoded_json->data;
            $status_stamp = $data[0]->STATUS;
            echo $response;
            if (strpos($IDREQ, 'BHD') !== false) {
                if ($status_stamp == 'Downloaded') {
                    echo 'nota behandle '.$nomor.' sudah Distamp';
                    $SQL = "UPDATE req_behandle_hdr set FL_SEND_EMATERAI_SERVICE = 'D' where ID_REQ = '$IDREQ'";
                    $Query =$this->db->query($SQL);
                } else {
                    echo 'nota behandle '.$nomor.' belum Distamp, cek portal ematerai';
                    $SQL = "UPDATE req_behandle_hdr set FL_SEND_EMATERAI_SERVICE = 'P' where ID_REQ = '$IDREQ'";
                    $Query =$this->db->query($SQL);
                }
            } else {
                if ($status_stamp == 'Downloaded') {
                    echo 'nota delivery '.$nomor.' sudah Distamp';
                    $SQL = "UPDATE req_delivery_hdr set FL_SEND_EMATERAI_SERVICE = 'D' where ID_REQ = '$IDREQ'";
                    $Query =$this->db->query($SQL);
                } else {
                    echo 'nota delivery '.$nomor.' belum Distamp, cek portal ematerai';
                    $SQL = "UPDATE req_delivery_hdr set FL_SEND_EMATERAI_SERVICE = 'P' where ID_REQ = '$IDREQ'";
                    $Query =$this->db->query($SQL);
                }
            }
            echo "\n";
            echo $url.$nomor;
        }
    }

    public function stamp_status(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json');
        $this->load->model("m_service_materai");
        $header = $this->m_service_materai->setting_point();
        $url = $header['LINK_CEK_STATUS_STAMP'];
        $token = $this->m_service_materai->get_latest_token();
        $active_token = $token['ACCESS_TOKEN'];
        $data_nota = $this->m_service_materai->stamp_status();
        
        foreach ($data_nota as $list_nota) {
            $nomor = $list_nota->NO_NOTA;
            $IDREQ = $list_nota->ID_REQ;
            echo "\r\n";
            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => $url.$nomor,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_SSL_VERIFYPEER => false,
              CURLOPT_SSL_VERIFYHOST => false,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'GET',
              CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Authorization: Bearer '.$active_token,
                'Cookie: visid_incap_2917632=85Y5H5kKTsmvrLG61JMQmm6v1WQAAAAAQUIPAAAAAADCokIMffqYlewEVInOHnOl'
            ),
          ));

            $response = curl_exec($curl);
            curl_close($curl);
            $decoded_json = json_decode($response, false);
            $msg = $decoded_json->message;
            $data = $decoded_json->data;
            $status_stamp = $data[0]->STATUS;
            if (strpos($IDREQ, 'BHD') !== false) {
                if ($status_stamp == 'Downloaded') {
                    echo 'nota behandle '.$nomor.' sudah Distamp';
                    $SQL = "UPDATE req_behandle_hdr set FL_SEND_EMATERAI_SERVICE = 'D' where ID_REQ = '$IDREQ'";
                    $Query =$this->db->query($SQL);
                } else {
                    echo 'nota behandle '.$nomor.' belum Distamp, cek portal ematerai';
                    $SQL = "UPDATE req_behandle_hdr set FL_SEND_EMATERAI_SERVICE = 'P' where ID_REQ = '$IDREQ'";
                    $Query =$this->db->query($SQL);
                }
            } else {
                if ($status_stamp == 'Downloaded') {
                    echo 'nota delivery '.$nomor.' sudah Distamp';
                    $SQL = "UPDATE req_delivery_hdr set FL_SEND_EMATERAI_SERVICE = 'D' where ID_REQ = '$IDREQ'";
                    $Query =$this->db->query($SQL);
                } else {
                    echo 'nota delivery '.$nomor.' belum Distamp, cek portal ematerai';
                    $SQL = "UPDATE req_delivery_hdr set FL_SEND_EMATERAI_SERVICE = 'P' where ID_REQ = '$IDREQ'";
                    $Query =$this->db->query($SQL);
                }
            }
            echo "\n";
            echo $url.$nomor;
        }
    }

    //////////////////////////////////////////////////////////////////////////////
// BUAT REST API
    public function listnota_belumproses(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json');
        $input = file_get_contents('php://input');


        $sql = "SELECT rbh.ID_REQ, rbh.JNS_DOK, rbh.NO_DOK, rbh.TGL_NOTA, rbh.TOTAL_JUMLAH, rbh.NO_NOTA_BEHANDLE as 'NO_NOTA' from req_behandle_hdr rbh where
        rbh.BIAYA_MATERAI = '10000' and rbh.FL_SEND_EMATERAI_SERVICE = 'X' and rbh.TGL_NOTA > '2023-12-01'
        UNION
        SELECT rdh.ID_REQ, rdh.JNS_DOK, rdh.NO_DOK, rdh.TGL_NOTA, rdh.TOTAL as 'TOTAL JUMLAH', rdh.NO_NOTA_DELIVERY  as 'NO_NOTA'
        from req_delivery_hdr rdh 
        where rdh.BIAYA_MATERAI = '10000' 
        and rdh.FL_SEND_EMATERAI_SERVICE = 'X' and rdh.TGL_NOTA > '2023-12-01'";

        $Query =$this->db->query($sql);
        $result = $Query->result();
        echo json_encode($result);
    }
    public function listnota_sudah_kirim(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json');
        $input = file_get_contents('php://input');


        $sql = "SELECT rbh.ID_REQ, rbh.JNS_DOK, rbh.NO_DOK, rbh.TGL_NOTA, rbh.TOTAL_JUMLAH, rbh.NO_NOTA_BEHANDLE as 'NO_NOTA' from req_behandle_hdr rbh where
        rbh.BIAYA_MATERAI = '10000' and rbh.FL_SEND_EMATERAI_SERVICE = 'S' and rbh.TGL_NOTA > '2023-10-01'
        UNION
        select rdh.ID_REQ, rdh.JNS_DOK, rdh.NO_DOK, rdh.TGL_NOTA, rdh.TOTAL as 'TOTAL JUMLAH', rdh.NO_NOTA_DELIVERY  as 'NO_NOTA'
        from req_delivery_hdr rdh 
        where rdh.BIAYA_MATERAI = '10000' 
        and rdh.FL_SEND_EMATERAI_SERVICE = 'S' and rdh.TGL_NOTA > '2023-10-01'";

        $Query =$this->db->query($sql);
        $result = $Query->result();
        echo json_encode($result);
    }
    public function listnota_menunggu_stamp(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json');
        $input = file_get_contents('php://input');


        $sql = "SELECT rbh.ID_REQ, rbh.JNS_DOK, rbh.NO_DOK, rbh.TGL_NOTA, rbh.TOTAL_JUMLAH, rbh.NO_NOTA_BEHANDLE as 'NO_NOTA' from req_behandle_hdr rbh
where rbh.FL_SEND_EMATERAI_SERVICE = 'V' or rbh.FL_SEND_EMATERAI_SERVICE = 'P' or rbh.FL_SEND_EMATERAI_SERVICE = 'Z' and
        rbh.BIAYA_MATERAI = '10000' and rbh.TGL_NOTA > '2023-12-01'
        UNION
        SELECT rdh.ID_REQ, rdh.JNS_DOK, rdh.NO_DOK, rdh.TGL_NOTA, rdh.TOTAL as 'TOTAL JUMLAH', rdh.NO_NOTA_DELIVERY  as 'NO_NOTA'
        from req_delivery_hdr rdh 
        where rdh.FL_SEND_EMATERAI_SERVICE = 'V' or rdh.FL_SEND_EMATERAI_SERVICE = 'P' or rdh.FL_SEND_EMATERAI_SERVICE = 'Z' and
        rdh.BIAYA_MATERAI = '10000' and rdh.FL_SEND_EMATERAI_SERVICE = 'Z' and rdh.TGL_NOTA > '2023-12-01'";

        $Query =$this->db->query($sql);
        $result = $Query->result();
        echo json_encode($result);
    }
    public function stamped_nota_finished(){
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json');
        $input = file_get_contents('php://input');


        $sql = "SELECT rbh.ID_REQ, rbh.JNS_DOK, rbh.NO_DOK, rbh.TGL_NOTA, rbh.TOTAL_JUMLAH, rbh.NO_NOTA_BEHANDLE as 'NO_NOTA' from req_behandle_hdr rbh where
        rbh.BIAYA_MATERAI = '10000' and rbh.FL_SEND_EMATERAI_SERVICE = 'D' and rbh.TGL_NOTA > '2023-11-01'
        UNION
        SELECT rdh.ID_REQ, rdh.JNS_DOK, rdh.NO_DOK, rdh.TGL_NOTA, rdh.TOTAL as 'TOTAL JUMLAH', rdh.NO_NOTA_DELIVERY  as 'NO_NOTA'
        from req_delivery_hdr rdh 
        where rdh.BIAYA_MATERAI = '10000' 
        and rdh.FL_SEND_EMATERAI_SERVICE = 'D' and rdh.TGL_NOTA > '2023-11-01'";

        $Query =$this->db->query($sql);
        $result = $Query->result();
        echo json_encode($result);
    }

    public function redirector_stamp(){
        $arrid = explode('~',$this->input->get('nota'));
        $nota = $arrid[0];
        $sql = "SELECT RESPONSE_ID from e_materai_services_main where NO_NOTA = '$nota'";
        $Query =$this->db->query($sql);
        $result = $Query->result();
        foreach ($result as $list_nota) {
            $id = $list_nota->RESPONSE_ID;
            header("Location: https://invoice.multiterminal.co.id/APP-BOS_CA/".$id.".pdf");
        }
    }
}