<?php
defined('BASEPATH') or exit('No direct script access allowed');
include_once './vendor/autoload.php';
use Firebase\JWT\JWT;

class Apibosbaru extends CI_Controller
{

    public function index()
    {
        $this->load->view('welcome_message');
    }
    public function token()
    {
        $key = "beacukai_mti";
        $payload = array(
            "name" => "beacukai",
            "pass" => "123456mti",
        );

        $jwt = JWT::encode($payload, $key);
        //print_r($jwt);
    }

    public function cekdokumen_dll()
    {
        $token = $this->input->get('token');
        $nodok = $this->input->get('no_dok');
        $tgdok = $this->input->get('tgl_dok');
        try {
            $key = "beacukai_mti";
            $decoded = JWT::decode($token, $key, array('HS256'));
            $q = $this->db->query("SELECT a.NO_DOK ,a.TGL_DOK ,b.NO_CONT,b.UKR_CONT,b.VESSEL ,b.VOY_IN,b.DISCHARGE,b.TIPE_CONT ,b.KD_STATUS,e.NAMA ,c.KD_STATUS ,d.STATUS_CONT,d.LOKASI
            from t_request a
            join t_request_cont b on a.ID = b.ID
            left join t_spk c on a.TGL_DOK = c.TGL_DOK and a.NO_DOK = c.NO_DOK
            left join t_spk_cont d  on c.ID = d.ID and b.NO_CONT = d.NO_CONT
			left join reff_kode_dok_bc e on c.JNS_DOK = e.ID
            where a.NO_DOK = '$nodok' and a.TGL_DOK = '$tgdok' and a.KD_REQ in ('SENT','APPROVED','ERROR','REJECTED','INQUIRY','BYPASS','QUEUED')
            order by a.ID desc")->result();
            if ($q) {
                $this->httpres(200, 'success', $q, '');
            } else {
                $this->httpres(200, 'error', '', 'Data Tidak Di Temukan');
            }

        } catch (Exception $e) {
            $this->httpres(200, 'error', '', $e->getMessage());
        }
    }

    public function cekdokumen_sppmp()
    {
        $token = $this->input->get('token');
        $nodok = $this->input->get('no_dok');
        $tgdok = $this->input->get('tgl_dok');
        try {
            $key = "beacukai_mti";
            $decoded = JWT::decode($token, $key, array('HS256'));
            $q = $this->db->query("SELECT a.NO_DOK ,a.TGL_DOK ,b.NO_CONT,b.UKR_CONT,b.VESSEL ,b.VOY_IN,b.DISCHARGE,b.TIPE_CONT ,b.KD_STATUS,e.NAMA ,c.KD_STATUS ,d.STATUS_CONT,d.LOKASI
            from t_request a
            join t_request_cont b on a.ID = b.ID
            left join t_spk c on a.TGL_DOK = c.TGL_DOK and a.NO_DOK = c.NO_DOK
            left join t_spk_cont d  on c.ID = d.ID and b.NO_CONT = d.NO_CONT
			left join reff_kode_dok_bc e on c.JNS_DOK = e.ID
            where a.NO_DOK = '$nodok' and a.TGL_DOK = '$tgdok' and a.KD_REQ in ('SENT','APPROVED','ERROR','REJECTED','INQUIRY','BYPASS','QUEUED')
            order by a.ID desc")->result();
            if ($q) {
                $this->httpres(200, 'success', $q, '');
            } else {
                $this->httpres(200, 'error', '', 'Data Tidak Di Temukan');
            }

        } catch (Exception $e) {
            $this->httpres(200, 'error', '', $e->getMessage());
        }
    }

    public function CallApi($method, $url, $data = false)
    {
        $curl = curl_init();
        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }

                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                curl_setopt($curl, CURLOPT_PUT, 1);
                if ($data) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }

                break;
            default:
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, strtoupper($method));
                curl_setopt($curl, CURLOPT_HEADER, false);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                if ($data) {
                    $url = $url . '/' . $data;
                }

        }

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }

    public function paymentbhd()
    {

        try {

            $token = $this->input->post('token');
            $ID_REQ = $this->input->post('id_req');
            $NO_DOK = $this->input->post('no_dok');
            $ID_BANK = $this->input->post('id_bank');
            $NAMA_BANK = $this->input->post('nama_bank'); //5260919191

            $key = "bos_mti";
            $decoded = JWT::decode($token, $key, array('HS256'));

            $SQL = $this->db->query("SELECT DISTINCT A.ID_REQ, A.TGL_REQ, A.NO_DOK, A.NPWP, A.NAMA_CUST, C.ALAMAT, C.EMAIL, C.TELEPON,
												(20000 + A.SUBTOTAL) AS SUBTOTAL, A.PPN AS PPN, A.TOTAL_JUMLAH AS TOTAL_BAYAR, B.JENIS_TARIF, SUM(B.TOTAL) AS TOTAL_NOMINAL,
												DATE_FORMAT(A.TGL_REQ,'%Y-%m-%d 23:59:59') AS EXPIRED
												FROM req_behandle_hdr A
												INNER JOIN req_delivery_simkeu B ON A.ID_REQ = B.ID_REQ
												INNER JOIN m_pelanggan C ON A.NPWP = C.NPWP
												WHERE A.ID_REQ = '" . $ID_REQ . "' AND A.BILLING_ID IS NULL GROUP BY B.JENIS_TARIF
						");
            $RESULT = $SQL->result_array();
            $COUNT_RESULT = count($RESULT);
            if ($COUNT_RESULT > 0) {
                $VAR = array();
                $ARRHEADER = "";
                $ARRDETAIL = "";
                $index = -1;
                $code = 1;
                $CHANNEL_ID = $ID_BANK == '11021' ? 'B00201' : 'B00601';
                for ($i = 0; $i < $COUNT_RESULT; $i++) {
                    $BILLING_ID = $codecustom->kode . preg_replace('/\D/', '', $RESULT[$i]['ID_REQ']);
                    if ($ARRHEADER != $RESULT[$i]['ID_REQ']) {
                        $index++;
                        $VAR['user'] = 'admin.mti';
                        $VAR['password'] = 'b8ad6e10f5d8789c587d2f2b0d173b7e';
                        $VAR['billerId'] = '19';
                        $VAR['productId'] = 'C03001';
                        $VAR['channelId'] = $CHANNEL_ID;
                        $VAR['data']['billingId'] = $BILLING_ID;
                        $VAR['data']['billingDate'] = $RESULT[$i]['TGL_REQ'];
                        $VAR['data']['billingType'] = '1';
                        $VAR['data']['customerId'] = preg_replace('/\D/', '', $RESULT[$i]['NPWP']);
                        $VAR['data']['customerName'] = substr($RESULT[$i]['NAMA_CUST'], 0, 30);
                        $VAR['data']['customerAddress'] = $RESULT[$i]['ALAMAT'];
                        $VAR['data']['customerMail'] = $RESULT[$i]['EMAIL'];
                        $VAR['data']['customerPhone'] = $RESULT[$i]['TELEPON'];
                        $VAR['data']['billerAccountNo'] = '00000000';
                        $VAR['data']['billerName'] = 'PT MTI COMMON AREA';
                        $VAR['data']['currency'] = 'IDR';
                        $VAR['data']['amount'] = $RESULT[$i]['SUBTOTAL'];
                        $VAR['data']['tax'] = $RESULT[$i]['PPN'];
                        $VAR['data']['totalAmount'] = $RESULT[$i]['TOTAL_BAYAR'];
                        $VAR['data']['expiredDate'] = $RESULT[$i]['EXPIRED'];
                        $VAR['data']['interval'] = '50000';
                        $VAR['data']['remark'] = 'Pembayaran Behandle MTI';
                        $VAR['data']['signature'] = hash("sha256", "admin.mti" . "19" . $BILLING_ID);
                        $VAR['data']['documentNo'] = $RESULT[$i]['NO_DOK'];
                        $VAR['data']['bankClientId'] = $ID_BANK;
                        $VAR['data']['accountNo'] = $NAMA_BANK;
                    }
                    if ($ARRHEADER == $RESULT[$i]['ID_REQ'] && $ARRDETAIL != $RESULT[$i]['ID_REQ']) {
                        $index++;
                        $ARRDETAIL['data']['detail']['code'][] = $RESULT[$i]['ID_REQ'];
                    }
                    $DETAIL['code'] = '00' . (string) $code++;
                    $DETAIL['description'] = $RESULT[$i]['JENIS_TARIF'];
                    $DETAIL['nominal'] = $RESULT[$i]['TOTAL_NOMINAL'];
                    $VAR['data']['detail'][] = $DETAIL;
                    $ARRHEADER = $RESULT[$i]['ID_REQ'];
                    $ARRDETAIL = $RESULT[$i]['ID_REQ'];
                }
                $ARRVAR = json_encode($VAR);
                //$this->insertMailBox('PAYMENTSEND', str_replace("'", "''", json_encode($ARRVAR)));
                $URL = 'https://devpay.edi-indonesia.co.id/services_api/index.php/api/server/sendBilling';
                //$URL = 'https://apipay.edi-indonesia.co.id/api/server/sendBilling';
                $SEND = $this->CallApi('POST', $URL, $ARRVAR);
                $response = json_decode($ARRVAR);
                //var_dump($ARRVAR);die();
                if ($response->status == true) {
                    $this->db->where('ID_REQ', $RESULT[0]['ID_REQ']);
                    $this->db->update('req_behandle_hdr', array('BANK_ID' => $ID_BANK, 'FL_PAYMENT' => 'Y', 'BILLING_ID' => $response->data->billingId, 'PAYMENT_ID' => $response->data->paymentId, 'VAID' => $response->data->vaid, 'MESSAGE_PAYMENT' => 'SEND', 'WK_PAYMENT' => date('Y-m-d H:i:s')));
                    //$action = '/billingBehandle/behandle/post';
                    $q = $arrayName = array(
                        'id_req' => $RESULT[0]['ID_REQ'],
                        'id_bank' => $ID_BANK,
                        'response' => $response->data,
                    );
                    $this->httpres(200, 'success', $q, '');
                } else {
                    $this->db->where('ID_REQ', $RESULT[0]['ID_REQ']);
                    $this->db->update('req_behandle_hdr', array('FL_PAYMENT' => 'E', 'MESSAGE_PAYMENT' => 'FAILED', 'WK_PAYMENT' => date('Y-m-d H:i:s')));
                    $this->httpres(200, 'error', '', $response->errDesc);
                    //////echo"MSG#ERR#" . $response->errDesc . "#";
                }
            } else {
                $this->httpres(200, 'error', '', 'Billing Behandle Not Found');
            }
        } catch (\Throwable $th) {
            $this->httpres(200, 'error', '', $e->getMessage());
        }
    }

    public function paymentdel()
    {

        try {
            $token = $this->input->post('token');
            $ID_REQ = $this->input->post('id_req');
            $NO_DOK = $this->input->post('no_dok');
            $ID_BANK = $this->input->post('id_bank');
            $NAMA_BANK = $this->input->post('nama_bank');

            $key = "bos_mti";
            $decoded = JWT::decode($token, $key, array('HS256'));

            $SQL = $this->db->query("SELECT DISTINCT A.ID_REQ, A.TGL_REQ, A.NO_DOK, A.NPWP, A.NAMA_CUST, C.ALAMAT, C.EMAIL, C.TELEPON,
												(20000 + A.SUBTOTAL) AS SUBTOTAL, A.PPN AS PPN, A.TOTAL_JUMLAH AS TOTAL_BAYAR, B.JENIS_TARIF, SUM(B.TOTAL) AS TOTAL_NOMINAL,
												DATE_FORMAT(A.TGL_REQ,'%Y-%m-%d 23:59:59') AS EXPIRED
												FROM req_behandle_hdr A
												INNER JOIN req_delivery_simkeu B ON A.ID_REQ = B.ID_REQ
												INNER JOIN m_pelanggan C ON A.NPWP = C.NPWP
												WHERE A.ID_REQ = '" . $ID_REQ . "' AND A.NO_DOK = '" . $NO_DOK . "' AND A.BILLING_ID IS NULL GROUP BY B.JENIS_TARIF
						");
            $RESULT = $SQL->result_array();
            $COUNT_RESULT = count($RESULT);
            if ($COUNT_RESULT > 0) {
                $VAR = array();
                $ARRHEADER = "";
                $ARRDETAIL = "";
                $INDEX = -1;
                $CODE = 1;
                $CHANNEL_ID = $ID_BANK == '11021' ? 'B00201' : 'B00601';
                for ($i = 0; $i < $COUNT_RESULT; $i++) {
                    $BILLING_ID = '103' . preg_replace('/\D/', '', $RESULT[$i]['ID_REQ']);
                    if ($ARRHEADER != $RESULT[$i]['ID_REQ']) {
                        $index++;
                        $VAR['user'] = 'admin.mti';
                        $VAR['password'] = 'b8ad6e10f5d8789c587d2f2b0d173b7e';
                        $VAR['billerId'] = '19';
                        $VAR['productId'] = 'C03001';
                        $VAR['channelId'] = $CHANNEL_ID;
                        $VAR['data']['billingId'] = $BILLING_ID;
                        $VAR['data']['billingDate'] = $RESULT[$i]['TGL_REQ'];
                        $VAR['data']['billingType'] = '1';
                        $VAR['data']['customerId'] = preg_replace('/\D/', '', $RESULT[$i]['NPWP']);
                        $VAR['data']['customerName'] = $RESULT[$i]['NAMA_CUST'];
                        $VAR['data']['customerAddress'] = $RESULT[$i]['ALAMAT'];
                        $VAR['data']['customerMail'] = $RESULT[$i]['EMAIL'];
                        $VAR['data']['customerPhone'] = $RESULT[$i]['TELEPON'];
                        $VAR['data']['billerAccountNo'] = '00000000';
                        $VAR['data']['billerName'] = 'PT MTI COMMON AREA';
                        $VAR['data']['currency'] = 'IDR';
                        $VAR['data']['amount'] = $RESULT[$i]['SUBTOTAL'];
                        $VAR['data']['tax'] = $RESULT[$i]['PPN'];
                        $VAR['data']['totalAmount'] = $RESULT[$i]['TOTAL_BAYAR'];
                        $VAR['data']['expiredDate'] = $RESULT[$i]['EXPIRED'];
                        $VAR['data']['interval'] = '50000';
                        $VAR['data']['remark'] = 'Pembayaran Behandle MTI';
                        $VAR['data']['signature'] = hash("sha256", "admin.mti" . "19" . $BILLING_ID);
                        $VAR['data']['documentNo'] = $RESULT[$i]['NO_DOK'];
                        $VAR['data']['bankClientId'] = $ID_BANK;
                        $VAR['data']['accountNo'] = $NAMA_BANK;
                    }
                    if ($ARRHEADER == $RESULT[$i]['ID_REQ'] && $ARRDETAIL != $RESULT[$i]['ID_REQ']) {
                        $index++;
                        $ARRDETAIL['data']['detail']['code'][] = $RESULT[$i]['ID_REQ'];
                    }
                    $DETAIL['code'] = '00' . (string) $code++;
                    $DETAIL['description'] = $RESULT[$i]['JENIS_TARIF'];
                    $DETAIL['nominal'] = $RESULT[$i]['TOTAL_NOMINAL'];
                    $VAR['data']['detail'][] = $DETAIL;
                    $ARRHEADER = $RESULT[$i]['ID_REQ'];
                    $ARRDETAIL = $RESULT[$i]['ID_REQ'];
                }
                $ARRVAR = json_encode($VAR);
                //$this->insertMailBox('PAYMENTSEND', str_replace("'", "''", json_encode($ARRVAR)));
                $URL = 'https://devpay.edi-indonesia.co.id/services_api/index.php/api/server/sendBilling';
                //$URL = 'https://apipay.edi-indonesia.co.id/api/server/sendBilling';
                $SEND = $this->CallApi('POST', $URL, $ARRVAR);
                $response = json_decode($SEND);
                ////print_r($response);
                if ($response->status == true) {
                    $this->db->where('ID_REQ', $RESULT[0]['ID_REQ']);
                    $this->db->update('req_behandle_hdr', array('BANK_ID' => $ID_BANK, 'FL_PAYMENT' => 'Y', 'BILLING_ID' => $response->data->billingId, 'PAYMENT_ID' => $response->data->paymentId, 'VAID' => $response->data->vaid, 'MESSAGE_PAYMENT' => 'SEND', 'WK_PAYMENT' => date('Y-m-d H:i:s')));
                    $action = '/billingBehandle/behandle/post';
                    $q = $arrayName = array(
                        'id_req' => $RESULT[0]['ID_REQ'],
                        'id_bank' => $ID_BANK,
                        'response' => $response->data,
                    );
                    $this->httpres(200, 'success', $q, '');
                } else {
                    $this->db->where('ID_REQ', $RESULT[0]['ID_REQ']);
                    $this->db->update('req_behandle_hdr', array('FL_PAYMENT' => 'E', 'MESSAGE_PAYMENT' => 'FAILED', 'WK_PAYMENT' => date('Y-m-d H:i:s')));
                    $this->httpres(200, 'error', '', $response->errDesc);
                    //////echo"MSG#ERR#" . $response->errDesc . "#";
                }
            } else {
                $this->httpres(200, 'error', '', 'Billing del Not Found');
            }
        } catch (\Throwable $th) {
            $this->httpres(200, 'error', '', $e->getMessage());
        }
    }

    public function paymentext()
    {
        try {
            $token = $this->input->post('token');
            $ID_REQ = $this->input->post('id_req');
            $NO_DOK = $this->input->post('no_dok');
            $ID_BANK = $this->input->post('id_bank');
            $NAMA_BANK = $this->input->post('nama_bank');

            $key = "bos_mti";
            $decoded = JWT::decode($token, $key, array('HS256'));

            $SQL = $this->db->query("SELECT DISTINCT A.ID_REQ, A.TGL_REQ, A.NO_DOK, A.NPWP, A.NAMA_CUST, C.ALAMAT, C.EMAIL, C.TELEPON,
												(20000 + A.SUBTOTAL) AS SUBTOTAL, A.PPN AS PPN, A.TOTAL_JUMLAH AS TOTAL_BAYAR, B.JENIS_TARIF, SUM(B.TOTAL) AS TOTAL_NOMINAL,
												DATE_FORMAT(A.TGL_REQ,'%Y-%m-%d 23:59:59') AS EXPIRED
												FROM req_behandle_hdr A
												INNER JOIN req_delivery_simkeu B ON A.ID_REQ = B.ID_REQ
												INNER JOIN m_pelanggan C ON A.NPWP = C.NPWP
												WHERE A.ID_REQ = '" . $ID_REQ . "' AND A.BILLING_ID IS NULL GROUP BY B.JENIS_TARIF
						");
            $RESULT = $SQL->result_array();
            $COUNT_RESULT = count($RESULT);
            if ($COUNT_RESULT > 0) {
                $VAR = array();
                $ARRHEADER = "";
                $ARRDETAIL = "";
                $INDEX = -1;
                $CODE = 1;
                $CHANNEL_ID = $ID_BANK == '11021' ? 'B00201' : 'B00601';
                for ($i = 0; $i < $COUNT_RESULT; $i++) {
                    $BILLING_ID = '103' . preg_replace('/\D/', '', $RESULT[$i]['ID_REQ']);
                    if ($ARRHEADER != $RESULT[$i]['ID_REQ']) {
                        $index++;
                        $VAR['user'] = 'admin.mti';
                        $VAR['password'] = 'b8ad6e10f5d8789c587d2f2b0d173b7e';
                        $VAR['billerId'] = '19';
                        $VAR['productId'] = 'C03001';
                        $VAR['channelId'] = $CHANNEL_ID;
                        $VAR['data']['billingId'] = $BILLING_ID;
                        $VAR['data']['billingDate'] = $RESULT[$i]['TGL_REQ'];
                        $VAR['data']['billingType'] = '1';
                        $VAR['data']['customerId'] = preg_replace('/\D/', '', $RESULT[$i]['NPWP']);
                        $VAR['data']['customerName'] = $RESULT[$i]['NAMA_CUST'];
                        $VAR['data']['customerAddress'] = $RESULT[$i]['ALAMAT'];
                        $VAR['data']['customerMail'] = $RESULT[$i]['EMAIL'];
                        $VAR['data']['customerPhone'] = $RESULT[$i]['TELEPON'];
                        $VAR['data']['billerAccountNo'] = '00000000';
                        $VAR['data']['billerName'] = 'PT MTI COMMON AREA';
                        $VAR['data']['currency'] = 'IDR';
                        $VAR['data']['amount'] = $RESULT[$i]['SUBTOTAL'];
                        $VAR['data']['tax'] = $RESULT[$i]['PPN'];
                        $VAR['data']['totalAmount'] = $RESULT[$i]['TOTAL_BAYAR'];
                        $VAR['data']['expiredDate'] = $RESULT[$i]['EXPIRED'];
                        $VAR['data']['interval'] = '50000';
                        $VAR['data']['remark'] = 'Pembayaran Behandle MTI';
                        $VAR['data']['signature'] = hash("sha256", "admin.mti" . "19" . $BILLING_ID);
                        $VAR['data']['documentNo'] = $RESULT[$i]['NO_DOK'];
                        $VAR['data']['bankClientId'] = $ID_BANK;
                        $VAR['data']['accountNo'] = $NAMA_BANK;
                    }
                    if ($ARRHEADER == $RESULT[$i]['ID_REQ'] && $ARRDETAIL != $RESULT[$i]['ID_REQ']) {
                        $index++;
                        $ARRDETAIL['data']['detail']['code'][] = $RESULT[$i]['ID_REQ'];
                    }
                    $DETAIL['code'] = '00' . (string) $code++;
                    $DETAIL['description'] = $RESULT[$i]['JENIS_TARIF'];
                    $DETAIL['nominal'] = $RESULT[$i]['TOTAL_NOMINAL'];
                    $VAR['data']['detail'][] = $DETAIL;
                    $ARRHEADER = $RESULT[$i]['ID_REQ'];
                    $ARRDETAIL = $RESULT[$i]['ID_REQ'];
                }
                $ARRVAR = json_encode($VAR);
                //$this->insertMailBox('PAYMENTSEND', str_replace("'", "''", json_encode($ARRVAR)));
                $URL = 'https://devpay.edi-indonesia.co.id/services_api/index.php/api/server/sendBilling';
                //$URL = 'https://apipay.edi-indonesia.co.id/api/server/sendBilling';
                $SEND = $this->CallApi('POST', $URL, $ARRVAR);
                $response = json_decode($SEND);
                ////print_r($response);
                if ($response->status == true) {
                    $this->db->where('ID_REQ', $RESULT[0]['ID_REQ']);
                    $this->db->update('req_behandle_hdr', array('BANK_ID' => $ID_BANK, 'FL_PAYMENT' => 'Y', 'BILLING_ID' => $response->data->billingId, 'PAYMENT_ID' => $response->data->paymentId, 'VAID' => $response->data->vaid, 'MESSAGE_PAYMENT' => 'SEND', 'WK_PAYMENT' => date('Y-m-d H:i:s')));
                    $action = '/billingBehandle/behandle/post';
                    $q = $arrayName = array(
                        'id_req' => $RESULT[0]['ID_REQ'],
                        'id_bank' => $ID_BANK,
                        'response' => $response->data,
                    );
                    $this->httpres(200, 'success', $q, '');
                } else {
                    $this->db->where('ID_REQ', $RESULT[0]['ID_REQ']);
                    $this->db->update('req_behandle_hdr', array('FL_PAYMENT' => 'E', 'MESSAGE_PAYMENT' => 'FAILED', 'WK_PAYMENT' => date('Y-m-d H:i:s')));
                    $this->httpres(200, 'error', '', $response->errDesc);
                    //////echo"MSG#ERR#" . $response->errDesc . "#";
                }
            } else {
                $this->httpres(200, 'error', '', 'Billing EXT Not Found');
            }
        } catch (\Throwable $th) {
            $this->httpres(200, 'error', '', $e->getMessage());
        }
    }

    public function billingbehandle()
    {

        try {

            $cekdetail = $this->db->query("SELECT DISTINCT A.ID_IJIN, C.JNS_DOK, A.NO_RESPON, A.TG_RESPON, C.NO_CONT, C.UKR_CONT,
		CASE WHEN C.JNS_KEGIATAN = '1' AND H.LNSW_NOAJU IS null THEN 'BEHANDLE 1' WHEN C.JNS_KEGIATAN ='2' AND H.LNSW_NOAJU IS null THEN 'BEHANDLE 2' WHEN H.LNSW_NOAJU IS not NULL then 'BEHANDLE JOIN' ELSE '' END AS JNS_KEGIATAN
		FROM t_ppk_hdr A
		INNER JOIN t_ppk_cont B ON A.ID_IJIN = B.ID_IJIN
		INNER JOIN t_gatepass C ON A.NO_RESPON = C.NO_DOK AND B.NO_CONT = C.NO_CONT AND C.STATUS ='DONE'
		INNER JOIN t_op_inspection D ON B.NO_CONT = D.NO_CONT AND C.NO_CONT = D.NO_CONT AND D.STATUS = 'DONE'
		LEFT JOIN v_ppk_permit_join H ON C.NO_DOK = H.NO_RESPON AND C.NO_CONT = H.NO_CONT
		WHERE A.NO_RESPON = '111123' and A.TG_RESPON = '2021-07-31' AND C.JNS_KEGIATAN !='' AND C.FL_BIL IS NULL
		GROUP BY C.NO_CONT, C.JNS_KEGIATAN");

            $DT = array();
            $DATA = array();

            if ($cekdetail->num_rows() > 0) {
                foreach ($cekdetail->result() as $key => $value) {
                    $DT['NO_CONT'][$key] = $value->NO_CONT;
                    $DT['UKR_CONT'][$key] = $value->UKR_CONT;
                    $DT['JNS_KEGIATAN'][$key] = $value->JNS_KEGIATAN;
                }
            } else {
                return $this->httpres(200, 'error', '', 'Tidak Ada Data Behandle Yang Harus Di Bayar');
            }

            foreach ($this->input->post('DATA') as $a => $b) {
                if ($b == "") {
                    unset($DATA[$a]);
                } else {
                    $DATA[$a] = strtoupper(trim($b));
                }

            }

            $seq = $this->db->query("SELECT MAX(id) AS 'urut' FROM req_behandle_hdr")->row()->urut;
            $norut = $seq + 1;

            $REQ = "BHD/" . date('Y-m-d') . "/" . $norut;
            $DATA_BHD['ID_REQ'] = $REQ;
            $DATA_BHD['JNS_DOK'] = $DATA['JNS_DOK'];
            $DATA_BHD['NO_DOK'] = $DATA['NO_DOK'];
            $DATA_BHD['TGL_DOK'] = $DATA['TGL_DOK'];
            $DATA_BHD['NM_KAPAL'] = $DATA['NM_KAPAL'];
            $DATA_BHD['NO_VOY'] = $DATA['NO_VOY'];
            $DATA_BHD['NO_DO'] = $DATA['NO_DO'];
            $DATA_BHD['NO_BL'] = $DATA['NO_BL'];
            $DATA_BHD['TGL_REQ'] = date('Y-m-d H:i:s');
            $DATA_BHD['NAMA_CUST'] = $DATA['CUSTOMER'];
            $DATA_BHD['OPERATOR'] = 'online';
            $DATA_BHD['NPWP'] = $DATA['NPWP'];

            $this->db->insert('req_behandle_hdr', $DATA_BHD);
            $this->db->where(array('NO_DOK' => $DATA['NO_DOK']));
            $this->db->update('t_gatepass', array('FL_BIL' => 'DONE'));

            // foreach($this->input->post('DT[]') as $a => $b){
            //     foreach($b as $value){
            //         if($value=="") unset($DT[$a]);
            //         else $DT[$a][] = strtoupper(trim($value));
            //     }
            // }

            $jumlah_dipilih = count($DT['NO_CONT']);
            $sub_total = 0;
            $tarif = 0;
            $seal = 0;

            for ($x = 0; $x < $jumlah_dipilih; $x++) {
                $DETAIL = array();
                $SIZE = array();
                $SIZE = $DT['UKR_CONT'][$x];
                $KET = $DT['JNS_KEGIATAN'][$x];

                if ($KET == 'BEHANDLE 1') {
                    $KEGIATAN = 1;
                } else if ($KET == 'BEHANDLE 2') {
                    $KEGIATAN = 2;
                } else if ($KET == 'BEHANDLE JOIN') {
                    $KEGIATAN = 3;
                }

                $nmkpl = $DATA_BHD['NM_KAPAL'];
                $novy = $DATA_BHD['NO_VOY'];
                // ////echo"nama kapal".$nmkpl."<br>";
                // ////echo"nama voy".$novy;
                $kapalsandar = $this->db->query("SELECT * from t_cocostshdr where date(TGL_TIBA) >= date('2021-04-15') and NM_ANGKUT = '$nmkpl' and NO_VOY_FLIGHT = '$novy'")->num_rows();
                if ($kapalsandar == 1) {
                    $SQL = $this->db->query("SELECT * FROM m_tarif2 WHERE SIZE = '$SIZE' AND JENIS_BIAYA = 'PAKET BEHANDLE' AND KET LIKE '$KEGIATAN'")->row();
                } else {
                    $SQL = $this->db->query("SELECT * FROM m_tarif WHERE SIZE = '$SIZE' AND JENIS_BIAYA = 'PAKET BEHANDLE' AND KET LIKE '$KEGIATAN'")->row();
                }

                $SQL2 = $this->db->query("SELECT * FROM m_tarif WHERE JENIS_BIAYA = 'SEAL'")->row();
                $sub_total = $sub_total + $SQL->TARIF;
                //$tarif= $SQL->TARIF + $SQL2->TARIF;
                $seal = $seal + $SQL2->TARIF;

                if ($KET == 'BEHANDLE JOIN') {
                    $KEGIATAN = 'JOIN';
                }

                $DETAIL['ID_REQ'] = $REQ;
                $DETAIL['NO_CONT'] = $DT['NO_CONT'][$x];
                $DETAIL['UK_CONT'] = $DT['UKR_CONT'][$x];
                $DETAIL['JNS_KEGIATAN'] = $KEGIATAN;
                $DETAIL['TOTAL'] = $SQL->TARIF;
                $this->db->insert('req_behandle_dtl', $DETAIL);

                // INSERT SIMKEU
                if ($DETAIL['TOTAL'] > 0) {
                    $SIM['ID_REQ'] = $REQ;
                    $SIM['NO_CONT'] = $DT['NO_CONT'][$x];
                    $SIM['UKR_CONT'] = $DT['UKR_CONT'][$x];
                    $SIM['CHARGE'] = $SQL->TARIF;
                    $SIM['JENIS_TARIF'] = 'BEHANDLE ' . $KEGIATAN;
                    $SIM['TOTAL'] = $SQL->TARIF;
                    $SIM['WK_REKAM'] = date('Y-m-d H:i:s');
                    $this->db->insert('req_delivery_simkeu', $SIM);
                }
            }

            $SUM_MAX_ID = $this->db->query("SELECT ID_REQ AS 'ID' FROM req_behandle_dtl WHERE ID_REQ IN
												(SELECT ID_REQ FROM req_behandle_dtl WHERE SUBSTRING(ID_REQ, 16) =
												(SELECT IFNULL(COUNT(id_req),1) AS 'urut' FROM req_behandle_hdr))")->row()->ID;
            $SQL_MAX = $this->db->query("SELECT MAX(ID) AS ID FROM req_behandle_hdr")->row()->ID;
            ////echo$SQL_MAX;die();
            $MAX_ID = $SQL_MAX;
            $sub_total1 = $this->db->query("SELECT SUM(TOTAL) AS TOTAL FROM req_behandle_dtl WHERE ID_REQ = '$REQ'")->row()->TOTAL;
            $BA = $this->db->query("SELECT TARIF AS 'Tarif' FROM m_tarif WHERE JENIS_BIAYA = 'ADMINISTRASI'")->row()->Tarif;

            $sub_totalA = $sub_total1 + $BA + $seal;
            $PPN = $sub_totalA * 0.11;

            $sub_totalBM = $sub_totalA + $PPN;
            if ($sub_totalBM > 5000000) {
                $MAT = 10000;
            } else {
                $MAT = 0;
            }

            $TOTAL_ALL = $sub_totalA + $PPN + $MAT;
            $DATA_HDR_BH['BIAYA_ADMIN'] = $BA;
            $DATA_HDR_BH['BIAYA_MATERAI'] = $MAT;
            $DATA_HDR_BH['SUBTOTAL'] = $sub_total1;
            $DATA_HDR_BH['PPN'] = $PPN;
            $DATA_HDR_BH['SEAL'] = $seal;
            $DATA_HDR_BH['TOTAL_JUMLAH'] = $TOTAL_ALL;
            $this->db->where(array('ID_REQ' => $REQ));
            $this->db->update('req_behandle_hdr', $DATA_HDR_BH);

            // INSERT SIMKEU
            $SIM_MAT['ID_REQ'] = $REQ;
            $SIM_MAT['CHARGE'] = $MAT;
            $SIM_MAT['JENIS_TARIF'] = 'MATERAI BHD';
            $SIM_MAT['TOTAL'] = $MAT;
            $SIM_MAT['WK_REKAM'] = date('Y-m-d H:i:s');
            ////print_r($SIM_MAT);
            $this->db->insert('req_delivery_simkeu', $SIM_MAT);

            // INSERT BIAYA SEAL SIMKEU
            $SIM_SEAL['ID_REQ'] = $REQ;
            $SIM_SEAL['CHARGE'] = $SQL2->TARIF;
            $SIM_SEAL['JENIS_TARIF'] = 'SEAL';
            $SIM_SEAL['TOTAL'] = $seal;
            $SIM_SEAL['WK_REKAM'] = date('Y-m-d H:i:s');
            ////print_r($SIM_SEAL);
            $this->db->insert('req_delivery_simkeu', $SIM_SEAL);

            // INSERT BIAYA ADM SIMKEU

            $SIM_ADM['ID_REQ'] = $REQ;
            $SIM_ADM['CHARGE'] = $BA;
            $SIM_ADM['JENIS_TARIF'] = 'ADMINISTRASI';
            $SIM_ADM['TOTAL'] = $BA;
            $SIM_ADM['WK_REKAM'] = date('Y-m-d H:i:s');
            ////print_r($SIM_ADM);
            $this->db->insert('req_delivery_simkeu', $SIM_ADM);

            $npwp = $DATA_BHD['NPWP'];
            $cus = $DATA_BHD['NAMA_CUST'];
            $ceknpwp = $this->db->query("select NPWP from m_pelanggan where NPWP = '$npwp'");
            if ($ceknpwp->num_rows() == 0) {
                $this->db->query("INSERT INTO m_pelanggan (NPWP, NAMA_CUST, PASSWORD, ALAMAT, EMAIL, TELEPON, TLP_KANTOR, WK_REKAM) VALUES('$npwp', '$cus', '202cb962ac59075b964b07152d234b70', '', '-', '', NULL, NOW())");
            }
            return $this->httpres(200, 'success', $REQ, '');
        } catch (Exception $e) {
            $this->httpres(200, 'error', '', $e->getMessage());
        }

    }

    public function billingdelivery()
    {

        try {
            $DATAR = $this->input->post('DATA');
            $no_dok = $DATAR['NO_DOK'];
            $arrnocont = $this->input->post('arrnocont');
            $arrnocont = explode(',', $arrnocont);
            $arrnocont2 = '';
            foreach ($arrnocont as $k => $vl) {
                if ($k == 0) {
                    $arrnocont2 .= "'" . $vl . "'";
                } else {
                    $arrnocont2 .= ",'" . $vl . "'";
                }
            }
            $buatcont = $this->db->query("SELECT A.ID , A.NO_CONT ,C.ID ID2,C.UKR_CONT ,C.TIPE_CONT ,C.KD_CONT_JENIS ,C.FL_DG
		from t_permit_cont A
		inner join t_permit_hdr B on A.ID = B.ID
		inner join t_request_cont C on A.NO_CONT = C.NO_CONT and C.KD_STATUS = 'INQUIRY'
		where A.KD_STATUS_BIL is null and B.NO_DOK_INOUT = '$no_dok' and A.NO_CONT in ($arrnocont2)
		group by C.NO_CONT")->result();

            $DATAPOST = array();
            $dt = array();
            $dtcontpost = '';
            $chkcont = array();
            $dataid = '';
            $custom_refer = 'off';
            if ($buatcont) {
                foreach ($buatcont as $key => $value) {
                    if ($value->KD_CONT_JENIS == 'F') {
                        $vkdj = 'FULL';
                    } else {
                        $vkdj = 'EMPTY';
                    }
                    $dt['DTL_' . $value->NO_CONT]['NO_CONT'] = $value->NO_CONT;
                    $dt['DTL_' . $value->NO_CONT]['UKR_CONT'] = $value->UKR_CONT;
                    $dt['DTL_' . $value->NO_CONT]['TYPE'] = $value->TIPE_CONT;
                    $dt['DTL_' . $value->NO_CONT]['STATUS'] = $vkdj;
                    $dt['DTL_' . $value->NO_CONT]['DG'] = $value->FL_DG;
                    if ($dtcontpost == '') {
                        $dtcontpost = $value->ID2 . '~' . $value->NO_CONT;
                    } else {
                        $dtcontpost .= ',' . $value->ID2 . '~' . $value->NO_CONT;
                    }
                    $chkcont[$key] = $value->ID2 . '~' . $value->NO_CONT;
                    if ($value->TIPE_CONT == 'RFR') {
                        $custom_refer = 'on';
                    }
                    $dataid = $value->ID;
                }
            } else {
                return $this->httpres(200, 'error', '', 'Data Tidak Di Temukan');
            }

            $cont_post_c = $dtcontpost;

            // $DATAPOST['chk_cont'] =  $chkcont;
            // $DATAPOST['DTL'] =  $dt;
            // $DATAPOST['cont_post'] =  $cont_post_c;
            $act = 'save';
            $id = '';

            $custom_unplug = $this->input->post('unplugrefer1');
            $datacusrefere = $this->input->post('DATA');
            if ($custom_refer == 'on' && $custom_unplug != '') {
                foreach (explode(',', $cont_post_c) as $key1 => $valuerfr1) {
                    $exprefr = explode('~', $valuerfr1);
                    $exprefrtemp = $exprefr[1];
                    $ref11 = $this->db->query("select id,no_Cont,waktu,waktu_end from t_op_reefer where no_cont = '$exprefrtemp' and waktu is not null order by id desc limit 1")->row();
                    if ($ref11 != null) {
                        $this->db->set('waktu_end', $custom_unplug);
                        $this->db->set('fl_unplug', 'Y');
                        $this->db->set('operator_end', 'admin2');
                        $this->db->where('id', $ref11->id);
                        $this->db->update('t_op_reefer');
                    }
                }
                $PaidThruReferc = date('Y-m-d', strtotime($custom_unplug));
            } else {
                $PaidThruReferc = date('Y-m-d', strtotime($datacusrefere['PAIDTHRU']));
            }
            $error = 0;
            if ($act == "save") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "") {
                        unset($DATA[$a]);
                    } else {
                        $DATA[$a] = strtoupper(trim($b));
                    }

                }

                $SEQ = $this->db->query("SELECT MAX(id) AS 'urut' FROM req_delivery_hdr")->row()->urut;
                $NO_URT = $SEQ + 1;
                $REQ = "DEL/" . date('Y-m-d') . "/" . $NO_URT;
                $DATA_HDR['ID_REQ'] = $REQ;
                $DATA_HDR['TGL_REQ'] = date('Y-m-d H:i:s');
                $DATA_HDR['JNS_DOK'] = "SPPB PIB 2.0";
                $DATA_HDR['NO_DOK'] = $DATA['NO_DOK'];
                $DATA_HDR['TGL_DOK'] = $DATA['TGL_DOK'];
                $DATA_HDR['NO_DO'] = $DATA['NO_DO'];
                $DATA_HDR['NO_BL'] = $DATA['NO_BL'];
                $DATA_HDR['NO_VOY'] = $DATA['VOYAGE'];
                $DATA_HDR['NM_KAPAL'] = $DATA['NM_KAPAL'];
                $DATA_HDR['NPWP'] = $DATA['NPWP'];
                $DATA_HDR['NO_REQUEST'] = '010.000-16.61000007';
                $DATA_HDR['CREATOR'] = 'online';
                $DATA_HDR['EXPIRED'] = $PaidThruReferc;
                $this->db->insert('req_delivery_hdr', $DATA_HDR);

                $ID_POST = $cont_post_c;
                $ARRID_POST = explode(',', $ID_POST);
                $JML_CONT = count($ARRID_POST);

                $nmkpl = $DATA_HDR['NM_KAPAL'];
                $novy = $DATA_HDR['NO_VOY'];
                $kapalsandar = $this->db->query("SELECT * from t_cocostshdr where date(TGL_TIBA) >= date('2021-04-15') and NM_ANGKUT = '$nmkpl' and NO_VOY_FLIGHT = '$novy'")->num_rows();
                if ($kapalsandar == 1) {
                    $mtarif = 'm_tarif2';
                    $tDendaMHISp2 = 2;
                    $proses_m4 = '6';
                    $tnhi = 1.5;
                    $tjmlmasabebas1 = 4;
                    $tjmlmasabebas2 = 3;
                    $tpenumpukanmasa3 = 6;
                } else {
                    $mtarif = 'm_tarif';
                    $tDendaMHISp2 = 3;
                    $proses_m4 = '9';
                    $tnhi = 2;
                    $tjmlmasabebas1 = 3;
                    $tjmlmasabebas2 = 2;
                    $tpenumpukanmasa3 = 9;
                }

                for ($x = 0; $x < $JML_CONT; $x++) {
                    $arrid_val = explode('~', $ARRID_POST[$x]);
                    foreach ($dt['DTL_' . $arrid_val[1]] as $a => $b) {
                        if ($b == "") {
                            unset($DTL[$a]);
                        } else {
                            $DTL[$a] = strtoupper(trim($b));
                        }

                    }

                    $NO_CONT = $DTL['NO_CONT'];
                    $SIZE = $DTL['UKR_CONT'];
                    $TYPE = $DTL['TYPE'];
                    $STATUS = $DTL['STATUS'];
                    $NM_KAPAL = $DATA['NM_KAPAL'];
                    $NO_VOY = $DATA['VOYAGE'];
                    $FL_DG = $DTL['DG'];
                    $StartNHI = $DATA['TGL_NHI'];
                    $EndNHI = $DATA['TGL_BK_SEGEL'];
                    $TglSPPB = $DATA['TGL_DOK'];
                    $NO_DOK = $DATA['NO_DOK'];
                    $NOW = date('Y-m-d H:i:s');
                    $ID_CONT = $dataid;

                    if ($TYPE == 'RFR') {
                        // Cek biaya tarif dasar berdasarkan type dan statusnya
                        $SQL = $this->db->query("SELECT * FROM $mtarif WHERE SIZE = '$SIZE' AND TYPE ='$TYPE' AND STATUS =  '$STATUS' AND JENIS_BIAYA != 'LIFT ON'")->row();

                        // Tarif Reefer
                        $SQL_P_REEFER = $this->db->query("SELECT * FROM $mtarif WHERE SIZE = '$SIZE' AND TYPE ='$TYPE' AND STATUS =  '$STATUS' AND JENIS_BIAYA = 'PLUGIN REEFER'")->row();
                        $SQL_M_REEFER = $this->db->query("SELECT * FROM $mtarif WHERE SIZE = '$SIZE' AND TYPE ='$TYPE' AND STATUS =  '$STATUS' AND JENIS_BIAYA = 'MONITORING'")->row();

                        // jika OVD maka tampilkan biaya OVD jika tidak tampilkan berdasarkan tarif status dan size kontainer LIFT ON
                        if ($TYPE == 'OVD') {
                            $SQL_LO = $this->db->query("SELECT * FROM $mtarif WHERE SIZE = '$SIZE' AND TYPE ='$TYPE' AND JENIS_BIAYA = 'LIFT ON'")->row();
                        } else {
                            $SQL_LO = $this->db->query("SELECT * FROM $mtarif WHERE SIZE = '$SIZE' AND STATUS =  '$STATUS' AND JENIS_BIAYA = 'LIFT ON'")->row();
                        }

                        //     // Cari waktu stacking kontainer di terminal
                        $WK_IN = $this->db->query("SELECT WK_IN FROM t_cocostscont A INNER JOIN t_cocostshdr B ON A.ID = B.ID WHERE NO_CONT = '$NO_CONT' AND B.NM_ANGKUT = '$NM_KAPAL' AND B.NO_VOY_FLIGHT LIKE '%$NO_VOY%' AND WK_IN IS NOT NULL")->row()->WK_IN;
                        // Cari biaya administrasi
                        $SQL_ADMIN = $this->db->query("SELECT * FROM $mtarif WHERE JENIS_BIAYA = 'ADMIN'")->row();
                        // cari tarif biaya SPPB berdasarkan size, type dan status (FULL/Empty)
                        $SQL_SPPB = $this->db->query("SELECT * FROM $mtarif WHERE SIZE = '$SIZE' AND TYPE ='$TYPE' AND STATUS =  '$STATUS' AND JENIS_BIAYA='SPPB'")->row();
                        // cari tarif biaya SP2 berdasarkan size, type, dan status (FULL/Empty)
                        $SQL_SP2 = $this->db->query("SELECT * FROM $mtarif WHERE SIZE = '$SIZE' AND TYPE ='$TYPE' AND STATUS =  '$STATUS' AND JENIS_BIAYA='SP2'")->row();
                        // Hitung jumlah kontainer yang ingin keluar berdasarkan dokumen SPPB
                        $COUNT_CONT = $this->db->query("SELECT COUNT(A.NO_CONT) AS 'NO_CONT' FROM t_permit_cont A, t_permit_hdr C WHERE C.ID = A.ID AND C.NO_DOK_INOUT ='$NO_DOK'")->row();
                        // Cari biaya Plug
                        $SQL_PLUG = $this->db->query("SELECT * FROM $mtarif WHERE SIZE = '$SIZE' AND TYPE ='$TYPE' AND JENIS_BIAYA='PLUGIN REEFER'")->row();
                        // Cari biaya Monitoring
                        $SQL_MONITOR = $this->db->query("SELECT * FROM $mtarif WHERE SIZE = '$SIZE' AND TYPE ='$TYPE' AND JENIS_BIAYA='MONITORING'")->row();
                        // Cari PLUG and UNPLUGIN
                        // $MONITOR_PLUG = $this->db->query("SELECT C.PLUG_TERMINAL AS 'WAKTU', D.WAKTU_END FROM t_permit_hdr A INNER JOIN t_permit_cont B ON A.ID = B.ID INNER JOIN t_request_cont C ON B.NO_CONT = C.NO_CONT INNER JOIN t_op_reefer D ON B.NO_CONT = D.NO_CONT
                        // WHERE B.NO_CONT='$NO_CONT' AND A.NO_DOK_INOUT='$NO_DOK' AND C.PLUG_TERMINAL IS NOT NULL GROUP BY B.NO_CONT ASC")->row();
                        $MONITOR_PLUG = $this->db->query("SELECT C.PLUG_TERMINAL AS 'WAKTU', D.WAKTU_END FROM t_permit_hdr A INNER JOIN t_permit_cont B ON A.ID = B.ID INNER JOIN t_request_cont C ON B.NO_CONT = C.NO_CONT INNER JOIN t_op_reefer D ON B.NO_CONT = D.NO_CONT
					WHERE B.NO_CONT='$NO_CONT' AND A.NO_DOK_INOUT='$NO_DOK' AND C.PLUG_TERMINAL IS NOT NULL AND d.waktu_end IS NOT NULL ORDER BY c.PLUG_TERMINAL desc,D.WAKTU_END desc LIMIT 1")->row();
                        // $MONITOR_PLUG = $this->db->query("SELECT C.PLUG_TERMINAL AS 'WAKTU' FROM t_permit_hdr A INNER JOIN t_permit_cont B ON A.ID = B.ID INNER JOIN t_request_cont C ON B.NO_CONT = C.NO_CONT INNER JOIN t_op_reefer D ON B.NO_CONT = D.NO_CONT
                        // WHERE B.NO_CONT='$NO_CONT' AND A.NO_DOK_INOUT='$NO_DOK' AND C.PLUG_TERMINAL IS NOT NULL GROUP BY B.NO_CONT ASC")->row();
                        $SQL_TRUCK = $this->db->query("SELECT * FROM $mtarif WHERE JENIS_BIAYA = 'TRUCK'")->row();

                        //     // Tampung data ke variable
                        $TARIF_ID = $SQL->TARIF_ID; // Tarik ID
                        $TARIF_HARGA = $SQL->TARIF; // Tarif dasar
                        //$MAX_ID        = $SQL_MAX;
                        $cek = $WK_IN; // Stacking Kontainer di terminal
                        $COUNTCONT = $COUNT_CONT->NO_CONT; // Hitung berapa banyak kontainer

                        if ($FL_DG == '') {
                            $TARIF_PLUG = $SQL_PLUG->TARIF;
                            $TARIF_MONITOR = $SQL_MONITOR->TARIF;
                        } else if ($FL_DG == 'DG') { // Jika FL_DG ada maka
                            $TARIF_PLUG = $SQL_PLUG->TARIF * 2;
                            $TARIF_MONITOR = $SQL_MONITOR->TARIF * 2;
                        }

                        $WK_PLUG = date('Y-m-d H:i:s', strtotime($MONITOR_PLUG->WAKTU));
                        $WK_UNPLUG = date('Y-m-d H:i:s', strtotime($MONITOR_PLUG->WAKTU_END));
                        $CEKPLUG = $MONITOR_PLUG->WAKTU;
                        $CEKUNPLUG = $MONITOR_PLUG->WAKTU_END;

                        if ($cek == null) {
                            $error += 1;
                            // ////echo"ERROR";
                            // $message = "Tgl Stacking Tidak Ada";
                            // ////echo"MSG#ERR#".$message."#";
                            # ++++ DELETE BILLING NPCT1 ++++ #
                            $this->db->where(array('ID_REQ' => $REQ));
                            $this->db->delete('req_delivery_hdr');

                            # ++++ DELETE BILLING DETAIL ++++ #
                            $this->db->where(array('ID_REQ' => $REQ));
                            $this->db->delete('req_delivery_dtl');

                            # ++++ DELETE BILLING DETAIL SIMKEU++++ #
                            $this->db->where(array('ID_REQ' => $REQ));
                            $this->db->delete('req_delivery_simkeu');

                            # ++++ SFLAG CONTAINER++++ #
                            $this->db->where(array('ID' => $ID_CONT, 'NO_CONT' => $NO_CONT));
                            $this->db->update('t_permit_cont', array('KD_STATUS_BIL' => null, 'WK_STATUS_BIL' => null));

                            return $this->httpres(200, 'error', '', 'Tgl Stacking Tidak Ada');
                            die();
                        } else if ($CEKPLUG != null and $CEKUNPLUG == null) {
                            $error += 1;
                            // ////echo"ERROR";
                            // $message = "KONTAINER BELUM DI UNPLUG";
                            // ////echo"MSG#ERR#".$message."#";
                            # ++++ DELETE BILLING NPCT1 ++++ #
                            $this->db->where(array('ID_REQ' => $REQ));
                            $this->db->delete('req_delivery_hdr');

                            # ++++ DELETE BILLING DETAIL ++++ #
                            $this->db->where(array('ID_REQ' => $REQ));
                            $this->db->delete('req_delivery_dtl');

                            # ++++ DELETE BILLING DETAIL SIMKEU++++ #
                            $this->db->where(array('ID_REQ' => $REQ));
                            $this->db->delete('req_delivery_simkeu');

                            # ++++ SFLAG CONTAINER++++ #
                            $this->db->where(array('ID' => $ID_CONT, 'NO_CONT' => $NO_CONT));
                            $this->db->update('t_permit_cont', array('KD_STATUS_BIL' => null, 'WK_STATUS_BIL' => null));

                            return $this->httpres(200, 'error', '', 'KONTAINER BELUM DI UNPLUG');
                            die();
                        } else if ($cek != null) {
                            // ubah kd_status_bil menjadi 901
                            $this->db->where(array('ID' => $ID_CONT, 'NO_CONT' => $NO_CONT));
                            $this->db->update('t_permit_cont', array('KD_STATUS_BIL' => '901', 'WK_STATUS_BIL' => $NOW));

                            // Ambil data paidthru
                            $PaidThru = $PaidThruReferc;
                            $WkBilling = date('Y-m-d H:i:s');
                            // $WKBHD         = date('Y-m-d', strtotime($WK_BHD));

                            // Jika FL_DG kosong
                            if ($FL_DG == '') {
                                $Charge = $TARIF_HARGA;
                                $TYPE_CONT = $DTL['TYPE'];
                                $Charge_sppb = $SQL_SPPB->TARIF;
                                $Charge_sp2 = $SQL_SP2->TARIF;
                            } else if ($FL_DG == 'DG') { // Jika FL_DG ada maka
                                $Charge = ($TARIF_HARGA * 2);
                                $TYPE_CONT = $DTL['TYPE'];
                                $Charge_sppb = ($SQL_SPPB->TARIF * 2);
                                $Charge_sp2 = ($SQL_SP2->TARIF * 2);
                            } else { // Jika tidak maka
                                $Charge = ($TARIF_HARGA * 3);
                                $TYPE_CONT = $DTL['TYPE'];
                                $Charge_sppb = ($SQL_SPPB->TARIF * 3);
                                $Charge_sp2 = ($SQL_SP2->TARIF * 3);
                            }

                            // Penghitungan hari dimulai dari WK_IN kontainer di terminal jika melebihi jam 12:00 maka bertambah +1

                            $jam = date("Hi", strtotime($cek)); // ambil data jam + menit example [1342] = 13:42
                            // Jika jam lebih dari 1200 [12:00]
                            if ($jam > "1200" && $DTL['STATUS'] != "EMPTY") {
                                $MasaBebas = date("Y-m-d", strtotime($cek . "+1 days")); // hari + 1
                            } else { // jika tidak maka normal
                                $MasaBebas = date("Y-m-d", strtotime($cek));
                            }

                            // Buat variable awal dengan nilai 0
                            $indexNHI = 0;
                            $SelisihNHI = 0;
                            $SelisihMasa1 = 0;
                            $SelisihMasa2 = 0;
                            $SelisihMasa3 = 0;
                            $PenumpukanNHI = 0;
                            $PenumpukanMasa1 = 0;
                            $PenumpukanMasa2 = 0;
                            $PenumpukanMasa3 = 0;
                            $SelisihNPCT1Masa1 = 0;
                            $SelisihNPCT1Masa2 = 0;
                            $SelisihNPCT1Masa3 = 0;
                            $PenumpukanNPCT1Masa1 = 0;
                            $PenumpukanNPCT1Masa2 = 0;
                            $PenumpukanNPCT1Masa3 = 0;
                            $pluginReefer = 0;
                            $monitoringReefer = 0;

                            if ($STATUS == 'EMPTY') {
                                $Masa1 = date("Y-m-d", strtotime($MasaBebas . "+2 days"));
                                $Masa2 = date("Y-m-d", strtotime($Masa1 . "+7 days"));
                                $Masa3 = date("Y-m-d", strtotime($Masa2 . "+1 days"));

                                // ////echo"Masa Bebas     > ".$MasaBebas."<br>";
                                // ////echo"Masa 1         > ".$Masa1."<br>";
                                // ////echo"Masa 2         > ".$Masa2."<br>";
                                // ////echo"Masa 3         > ".$Masa3."<br>";
                                // ////echo"Masa Paid        > ".$PaidThru."<br>";
                                // -------------------------------------------------------------------------------    PERHITUNGAN CG
                                $DateTime1 = new DateTime($MasaBebas);
                                $DateTime2 = new DateTime($PaidThru);
                                $difference = $DateTime1->diff($DateTime2);
                                $selisihDiff = $difference->days;
                                $selisih = $selisihDiff;

                                for ($i = 0; $i <= $selisih; $i++) {
                                    $checkDate = date("Y-m-d", strtotime($i . " days" . $MasaBebas));
                                    //////echo$checkDate."--";
                                    if ($checkDate <= $Masa1) {
                                        $SelisihMasa1++;
                                        $PenumpukanMasa1 = $PenumpukanMasa1 + ($Charge * 0);
                                        //////echo$PenumpukanMasa1 ;
                                    }
                                    if (($checkDate > $Masa1) && ($checkDate <= $Masa2)) {
                                        $SelisihMasa2++;
                                        $PenumpukanMasa2 = $PenumpukanMasa2 + ($Charge * 2);
                                        //////echo$PenumpukanMasa2;
                                        if ($PaidThru >= $Masa2) {
                                            $EndDateMasa2 = $Masa2;
                                        } else {
                                            $EndDateMasa2 = $PaidThru;
                                        }
                                    }
                                    if (($checkDate >= $Masa3) && ($checkDate <= $PaidThru)) {
                                        $SelisihMasa3++;
                                        $PenumpukanMasa3 = $PenumpukanMasa3 + ($Charge * 3);
                                        //////echo$PenumpukanMasa3;
                                    }
                                    //////echo"<br>";
                                }
                                $Total = $PenumpukanMasa1 + $PenumpukanMasa2 + $PenumpukanMasa3;
                                if ($Total > 0) {
                                    $DETAIL['ID_REQ'] = $REQ;
                                    $DETAIL['NO_CONT'] = $DTL['NO_CONT'];
                                    $DETAIL['UKR_CONT'] = $DTL['UKR_CONT'];
                                    $DETAIL['ISO_CODE'] = $TYPE_CONT;
                                    $DETAIL['STATUS'] = $DTL['STATUS'];
                                    $DETAIL['TARIF_ID'] = $TARIF_ID;
                                    $DETAIL['CHARGE'] = $Charge;
                                    $DETAIL['TOTAL_UNIT'] = '1';
                                    $DETAIL['TOTAL'] = $Total;
                                    $DETAIL['PROSEN_M1'] = '0';
                                    $DETAIL['SELISIH_M1'] = '0';
                                    $DETAIL['M1_START_DATE'] = null;
                                    $DETAIL['M1_END_DATE'] = null;
                                    $DETAIL['TOTAL_M1'] = '0';
                                    $DETAIL['PROSEN_M2'] = '0';
                                    $DETAIL['SELISIH_M2'] = '0';
                                    $DETAIL['M2_START_DATE'] = null;
                                    $DETAIL['M2_END_DATE'] = null;
                                    $DETAIL['TOTAL_M2'] = $PenumpukanMasa1;
                                    $DETAIL['PROSEN_M3'] = '2';
                                    $DETAIL['SELISIH_M3'] = $SelisihMasa2;
                                    $DETAIL['M3_START_DATE'] = date("Y-m-d", strtotime($Masa1 . "+1 days"));
                                    $DETAIL['M3_END_DATE'] = $EndDateMasa2;
                                    $DETAIL['TOTAL_M3'] = $PenumpukanMasa2;
                                    $DETAIL['PROSEN_M4'] = '3';
                                    $DETAIL['SELISIH_M4'] = $SelisihMasa3;
                                    $DETAIL['M4_START_DATE'] = $Masa3;
                                    $DETAIL['M4_END_DATE'] = $PaidThru;
                                    $DETAIL['TOTAL_M4'] = $PenumpukanMasa3;
                                    $DETAIL['WK_REKAM'] = date('Y-m-d H:i:s');
                                    $DETAIL['FL_DG'] = $DTL['DG'];
                                    $this->db->insert('req_delivery_dtl', $DETAIL);
                                    if ($PenumpukanMasa1 > 0) {
                                        $SIM_M1['ID_REQ'] = $REQ;
                                        $SIM_M1['NO_CONT'] = $DTL['NO_CONT'];
                                        $SIM_M1['UKR_CONT'] = $DTL['UKR_CONT'];
                                        $SIM_M1['CHARGE'] = $Charge;
                                        $SIM_M1['JENIS_TARIF'] = 'PENUMPUKAN 1';
                                        $SIM_M1['TOTAL'] = $PenumpukanMasa1;
                                        $SIM_M1['WK_REKAM'] = date('Y-m-d H:i:s');
                                        ////print_r($SIM_M1);
                                        $this->db->insert('req_delivery_simkeu', $SIM_M1);
                                    }
                                    if ($PenumpukanMasa2 > 0) {
                                        $SIM_M2['ID_REQ'] = $REQ;
                                        $SIM_M2['NO_CONT'] = $DTL['NO_CONT'];
                                        $SIM_M2['UKR_CONT'] = $DTL['UKR_CONT'];
                                        $SIM_M2['CHARGE'] = $Charge;
                                        $SIM_M2['JENIS_TARIF'] = 'PENUMPUKAN 1.1';
                                        $SIM_M2['TOTAL'] = $PenumpukanMasa2;
                                        $SIM_M2['WK_REKAM'] = date('Y-m-d H:i:s');
                                        ////print_r($SIM_M2);
                                        $this->db->insert('req_delivery_simkeu', $SIM_M2);
                                    }
                                    if ($PenumpukanMasa3 > 0) {
                                        $SIM_M3['ID_REQ'] = $REQ;
                                        $SIM_M3['NO_CONT'] = $DTL['NO_CONT'];
                                        $SIM_M3['UKR_CONT'] = $DTL['UKR_CONT'];
                                        $SIM_M3['CHARGE'] = $Charge;
                                        $SIM_M3['JENIS_TARIF'] = 'PENUMPUKAN 2';
                                        $SIM_M3['TOTAL'] = $PenumpukanMasa3;
                                        $SIM_M3['WK_REKAM'] = date('Y-m-d H:i:s');
                                        ////print_r($SIM_M3);
                                        $this->db->insert('req_delivery_simkeu', $SIM_M3);
                                    }
                                }
                            } else {
                                $Masa1 = date("Y-m-d", strtotime($MasaBebas . "+1 days")); // Masa 1 = ambil masa bebas + 1 day
                                $Masa2 = date("Y-m-d", strtotime($Masa1 . "+1 days")); // Masa 2 = masa 1 + 1 day
                                $Masa3 = date("Y-m-d", strtotime($Masa2 . "+1 days")); // Masa 3 = masa 2 + 1 day

                                // ////echo"Masa Bebas     > ".$MasaBebas."<br>";
                                // ////echo"Masa 1         > ".$Masa1."<br>";
                                // ////echo"Masa 2         > ".$Masa2."<br>";
                                // ////echo"Masa 3         > ".$Masa3."<br>";
                                // ////echo"Masa Paid        > ".$PaidThru."<br>";
                                // ////echo"Masa NHI        > ".$StartNHI."<br>";
                                // ////echo"Masa END NHI    > ".$EndNHI."<br>";
                                // ////echo"Masa BEHANDLE    > ".$WK_BHD."<br>";
                                // ////echo"Masa PLUGIN   > ".$WK_PLUG."<br>";
                                // ////echo"Masa UNPLUGIN > ".$WK_UNPLUG."<br>";
                                // -------------------------------------------------------------------------------    PERHITUNGAN CG
                                $DateTime1 = new DateTime($MasaBebas); // buat timezone dengan tgl masabebas
                                $DateTime2 = new DateTime($PaidThru); // buat timezone berdasarkan tgl paidthru
                                $difference = $DateTime1->diff($DateTime2); // membuat selisih antara masa bebas dengan paidthru
                                $selisihDiff = $difference->days; // conver selisih menjadi hari
                                $selisih = $selisihDiff; // tampung data selisih hari di variable
                                //////echo"Selisih Paid > ".$selisih."<br>";

                                $DateTime3 = new DateTime($StartNHI); // buat timezone dengan tgl start NHI
                                $DateTime4 = new DateTime($EndNHI); // buat timezone dengan tgl end NHI
                                $difference = $DateTime3->diff($DateTime4); // membuat selisih antara tgl start NHI dengan tgl end NHI
                                $selisihDiff = $difference->days; // convert selisih menjadi hari
                                $selisihNHI = $selisihDiff; // tampung data selisih hari di variable
                                //////echo"Selisih NHI > ".$selisihNHI."<br>";

                                // looping data selisih NHI dan jabarkan datanya berdasarkan jumlah data selisihNHI
                                // output data berdasarkan jumlah selisih
                                /**
                                 * Contoh jika $startNHI tgl '2019-09-12' dan selisihnya 3 hari, maka hasilnya :
                                 * 2019-09-12
                                 * 2019-09-13
                                 * 2019-09-14
                                 * 2019-09-15
                                 */
                                for ($i = 0; $i <= $selisihNHI; $i++) {
                                    $checkDate1[] = date("Y-m-d", strtotime($i . " days" . $StartNHI));
                                }

                                /**
                                 * Jumlah selisih di jabarkan berdasarkan jumlah selisinya
                                 */
                                $PenumpukanMasaBebas = 0;
                                $SelisihMasaBebas = 0;
                                for ($j = 0; $j <= $selisih; $j++) {
                                    $checkDate = date("Y-m-d", strtotime($j . " days" . $MasaBebas));
                                    //////echo$checkDate." - ";
                                    // Jika data $checkDate dan $checkDate1 ada && selisihNHI tidak kosong maka
                                    if ((in_array($checkDate, $checkDate1)) && ($selisihNHI != 0)) {
                                        if ($indexNHI == 0) {
                                            // PenumpukanNHI = penumpukanNIH + (tarif harga FL_DG/dry * 0)
                                            $PenumpukanNHI = $PenumpukanNHI + ($Charge * 0);
                                            //////echo$PenumpukanNHI;
                                        } else {
                                            // selisih bertambah + 1;
                                            $SelisihNHI++;
                                            // penumpukan NHI = selisihNHI * (tarif harga FL_DG/dry * 2)
                                            $PenumpukanNHI = $SelisihNHI * ($Charge * $tnhi);
                                            //////echo$PenumpukanNHI;
                                        }
                                        // indexNHI + 1;
                                        $indexNHI++;
                                    } else {
                                        // jika tgl selisih sama dengan tgl masa bebas
                                        if ($checkDate == $MasaBebas) {
                                            $SelisihMasaBebas = 0;
                                            // penumpukan = selisih masa bebas * (tarif harga FL_DG/dry * 0)
                                            $PenumpukanMasaBebas = $SelisihMasaBebas * ($Charge * 0);
                                            //////echo$PenumpukanMasaBebas;
                                        }
                                        // jika tgl selisih sama dengan tgl masa 1
                                        if ($checkDate == $Masa1) {
                                            $SelisihMasa1 = 1;
                                            // penumpukan = selisihmasa1 * (tarif harga FL_DG/dry * 3)
                                            $PenumpukanMasa1 = $SelisihMasa1 * ($Charge * 3);
                                            //////echo$PenumpukanMasa1;
                                        }
                                        // jika tgl selisih sama dengan tgl masa 2
                                        if ($checkDate == $Masa2) {
                                            $SelisihMasa2 = 1;
                                            // penumpukan = selisihmasa2 * (tarif harga FL_DG/dry * 6)
                                            $PenumpukanMasa2 = $SelisihMasa2 * ($Charge * 6);
                                            //////echo$PenumpukanMasa2;
                                        }
                                        // Jika selisih melebihi masa 3 && selisih tidak kurang dari paidthru
                                        if (($checkDate >= $Masa3) && ($checkDate <= $PaidThru)) {
                                            // selisihmasa3 + 1;
                                            $SelisihMasa3++;
                                            // penumpukan = penumpukanmasa 3 + (tarif biaya FL_DG/dry * 9)
                                            $PenumpukanMasa3 = $PenumpukanMasa3 + ($Charge * $tpenumpukanmasa3);
                                            //////echo$PenumpukanMasa3;
                                        }
                                    }
                                    //////echo"<br>";
                                }

                                // Biaya Monitoring
                                $startPlug = strtotime($WK_PLUG);
                                $endPlug = strtotime($WK_UNPLUG);
                                $selisihPlug = ($endPlug - $startPlug) * 3;
                                $jamPlug = $endPlug - $startPlug;
                                $hitungJam = ceil($jamPlug / (60 * 60));
                                //////echo"SELISIH JAM : ".$hitungJam;

                                $kontainer = count($NO_CONT);
                                $hitungSelisih = ceil($selisihPlug / (60 * 60 * 24));
                                $monitoringReefer = $hitungSelisih * $kontainer * $TARIF_MONITOR;
                                //////echo"SELISIH PLUG : ".$hitungSelisih;
                                //////echo"Rp. ".$monitoringReefer;

                                // Biaya Plug
                                $startPlug = strtotime($WK_PLUG);
                                $endPlug = strtotime($WK_UNPLUG);
                                $selisihPlug = ($endPlug - $startPlug) * 3;
                                $hitungSelisih = ceil($selisihPlug / (60 * 60 * 24));
                                $kontainer = count($NO_CONT);
                                $pluginReefer = $hitungSelisih * $kontainer * $TARIF_PLUG;

                                //////echo"Rp. ".$pluginReefer;

                                // $totalMonitor = $monitoringReefer + $pluginReefer;
                                // //////echo"TOTAL MONITORING + PLUG : ".$totalMonitor;

                                // Total = masa bebas + penumpukanNHI + masa 1 + masa 2 + masa 3;
                                $Total = $PenumpukanMasaBebas + $PenumpukanNHI + $PenumpukanMasa1 + $PenumpukanMasa2 + $PenumpukanMasa3;
                                //////echo"Total Harga: ".$Total;
                                // Jika total lebih dari 0
                                if ($Total > 0) {
                                    $DETAIL['ID_REQ'] = $REQ;
                                    $DETAIL['NO_CONT'] = $DTL['NO_CONT'];
                                    $DETAIL['UKR_CONT'] = $DTL['UKR_CONT'];
                                    $DETAIL['ISO_CODE'] = $TYPE_CONT;
                                    $DETAIL['STATUS'] = $DTL['STATUS'];
                                    $DETAIL['TARIF_ID'] = $TARIF_ID;
                                    $DETAIL['CHARGE'] = $Charge;
                                    $DETAIL['TOTAL_UNIT'] = '1';
                                    $DETAIL['TOTAL'] = $Total;
                                    $DETAIL['PROSEN_M1'] = '0';
                                    $DETAIL['SELISIH_M1'] = $SelisihMasaBebas;
                                    $DETAIL['M1_START_DATE'] = $MasaBebas;
                                    $DETAIL['M1_END_DATE'] = $MasaBebas;
                                    $DETAIL['TOTAL_M1'] = $PenumpukanMasaBebas;
                                    $DETAIL['PROSEN_M2'] = '3';
                                    $DETAIL['SELISIH_M2'] = $SelisihMasa1;
                                    $DETAIL['M2_START_DATE'] = $Masa1;
                                    $DETAIL['M2_END_DATE'] = $Masa1;
                                    $DETAIL['TOTAL_M2'] = $PenumpukanMasa1;
                                    $DETAIL['PROSEN_M3'] = '6';
                                    $DETAIL['SELISIH_M3'] = $SelisihMasa2;
                                    $DETAIL['M3_START_DATE'] = $Masa2;
                                    $DETAIL['M3_END_DATE'] = $Masa2;
                                    $DETAIL['TOTAL_M3'] = $PenumpukanMasa2;
                                    $DETAIL['PROSEN_M4'] = $proses_m4;
                                    $DETAIL['SELISIH_M4'] = $SelisihMasa3;
                                    $DETAIL['M4_START_DATE'] = $Masa3;
                                    $DETAIL['M4_END_DATE'] = $PaidThru;
                                    $DETAIL['TOTAL_M4'] = $PenumpukanMasa3;
                                    $DETAIL['PROSEN_NHI'] = '1.5';
                                    $DETAIL['SELISIH_NHI'] = $selisihNHI;
                                    $DETAIL['NHI_START_DATE'] = $StartNHI;
                                    $DETAIL['NHI_END_DATE'] = $EndNHI;
                                    $DETAIL['TOTAL_NHI4'] = $PenumpukanNHI;
                                    $DETAIL['WK_REKAM'] = date('Y-m-d H:i:s');
                                    $DETAIL['FL_DG'] = $DTL['DG'];
                                    $this->db->insert('req_delivery_dtl', $DETAIL);

                                    // jika penumpukan masa 1 lebih dari 0
                                    if ($PenumpukanMasa1 > 0) {
                                        $SIM_M1['ID_REQ'] = $REQ;
                                        $SIM_M1['NO_CONT'] = $DTL['NO_CONT'];
                                        $SIM_M1['UKR_CONT'] = $DTL['UKR_CONT'];
                                        $SIM_M1['CHARGE'] = $Charge;
                                        $SIM_M1['JENIS_TARIF'] = 'PENUMPUKAN 1';
                                        $SIM_M1['TOTAL'] = $PenumpukanMasa1;
                                        $SIM_M1['WK_REKAM'] = date('Y-m-d H:i:s');
                                        //print_r($SIM_M1);
                                        $this->db->insert('req_delivery_simkeu', $SIM_M1);
                                    }
                                    // jika penumpukan masa 2 lebih dari 0
                                    if ($PenumpukanMasa2 > 0) {
                                        $SIM_M2['ID_REQ'] = $REQ;
                                        $SIM_M2['NO_CONT'] = $DTL['NO_CONT'];
                                        $SIM_M2['UKR_CONT'] = $DTL['UKR_CONT'];
                                        $SIM_M2['CHARGE'] = $Charge;
                                        $SIM_M2['JENIS_TARIF'] = 'PENUMPUKAN 1.1';
                                        $SIM_M2['TOTAL'] = $PenumpukanMasa2;
                                        $SIM_M2['WK_REKAM'] = date('Y-m-d H:i:s');
                                        //print_r($SIM_M2);
                                        $this->db->insert('req_delivery_simkeu', $SIM_M2);
                                    }

                                    // jika penumpukan masa 3 lebih dari 0
                                    if ($PenumpukanMasa3 > 0) {
                                        $SIM_M3['ID_REQ'] = $REQ;
                                        $SIM_M3['NO_CONT'] = $DTL['NO_CONT'];
                                        $SIM_M3['UKR_CONT'] = $DTL['UKR_CONT'];
                                        $SIM_M3['CHARGE'] = $Charge;
                                        $SIM_M3['JENIS_TARIF'] = 'PENUMPUKAN 2';
                                        $SIM_M3['TOTAL'] = $PenumpukanMasa3;
                                        $SIM_M3['WK_REKAM'] = date('Y-m-d H:i:s');
                                        //print_r($SIM_M3);
                                        $this->db->insert('req_delivery_simkeu', $SIM_M3);
                                    }

                                    // jika penumpukan masa NHI lebih dari 0
                                    if ($PenumpukanNHI > 0) {
                                        $SIM_NHI['ID_REQ'] = $REQ;
                                        $SIM_NHI['NO_CONT'] = $DTL['NO_CONT'];
                                        $SIM_NHI['UKR_CONT'] = $DTL['UKR_CONT'];
                                        $SIM_NHI['CHARGE'] = $Charge;
                                        $SIM_NHI['JENIS_TARIF'] = 'PENUMPUKAN NHI';
                                        $SIM_NHI['TOTAL'] = $PenumpukanNHI;
                                        $SIM_NHI['WK_REKAM'] = date('Y-m-d H:i:s');
                                        //print_r($SIM_NHI);
                                        $this->db->insert('req_delivery_simkeu', $SIM_NHI);
                                    }
                                }

                                #DENDA_SPPB
                                // Cek ada hari libur atau tidak
                                $holiday = $this->db->query("SELECT * FROM t_hari_libur WHERE DATE_FORMAT(TANGGAL,'%Y-%m-%d') = '$TglSPPB'")->row();
                                if ($holiday) {
                                    $check_libur = date('Y-m-d', strtotime($holiday->TANGGAL . ' + 1 days'));
                                }

                                if ($holiday != null) {
                                    $CheckHariLibur = true;
                                } else {
                                    $CheckHariLibur = false;
                                }

                                $CheckDaySppb = strtoupper(trim(date("D", strtotime($TglSPPB)))); // Cek hari sppb
                                $day = strtoupper(trim(date("D", strtotime($WkBilling)))); // cek hari waktu billing
                                $TglBilling = strtoupper(trim(date("Y-m-d", strtotime($WkBilling)))); // cek tgl billing
                                $TglStack = strtoupper(trim(date("Y-m-d", strtotime($cek)))); // cek tgl stacking

                                //////echo"TglBilling         > ".$TglBilling."<br>";
                                //////echo"TglStack             > ".$TglStack."<br>";
                                //////echo"TglSPPB             > ".$TglSPPB."<br>";

                                // Jika tgl SPPB tidak sama dengan tgl billing
                                if ($TglSPPB != $TglBilling) {
                                    if ($TglSPPB <= $TglStack) { // jika tglsppb kurang dari sama dengan tgl stacking
                                        $JumlahMasaBebas = 2; // 3 hari
                                        $DateTime5 = new DateTime($TglBilling); // create timezone tgl billing
                                        $DateTime6 = new DateTime($TglStack); // create timezone tgl stacking
                                        $difference = $DateTime5->diff($DateTime6); // selisih antara tgl billing dengan tgl stacking
                                        $selisihM44 = $difference->days; // simpan sisa hari selisih
                                        $selisihM4 = $selisihM44; // tampung data ke variaable
                                        $RangeDate = $selisihM4; // tampung data ke variable
                                        //////echo"1. RangeDate : ".$RangeDate."<br>";
                                    } else {
                                        // jika ada hari libur (sabtu, minggu) || check tgl libur || hari SPPB di jumat atau sabtu
                                        if (($day == "SUN") || ($day == "SAT") || ($CheckHariLibur) || ($CheckDaySppb == "FRI") || ($CheckDaySppb == "SAT")) {
                                            $JumlahMasaBebas = $tjmlmasabebas1; // 3 hari
                                        } else {
                                            $JumlahMasaBebas = $tjmlmasabebas2; // 2 hari
                                        }
                                        $DateTime7 = new DateTime($TglBilling); // create timezone tgl billing
                                        $DateTime8 = new DateTime($TglSPPB); // create timezone tgl sppb
                                        $difference = $DateTime7->diff($DateTime8); // hitung jarak tgl billing dengan tgl sppb
                                        $selisihM44 = $difference->days; // tampung data hari selisih
                                        $selisihM46 = $selisihM44; // tampung ke variable
                                        $RangeDate = $selisihM46;
                                        //////echo"2. RangeDate : ".$RangeDate."<br>";
                                    }
                                    // selisih masa bebas = jarak hari - jumlah hari masa bebas
                                    $SelisihMasaBebas = $RangeDate - $JumlahMasaBebas;
                                    //////echo"SelisihMasaBebas     : ".$SelisihMasaBebas."<br>";
                                    //////echo"JumlahMasaBebas    : ".$JumlahMasaBebas."<br>";

                                    $DendaM1 = 0;
                                    $DendaM2 = 0;
                                    $DendaM3 = 0;
                                    $DendaM4 = 0;
                                    $SelisihDateM1 = 0;
                                    $SelisihDateM2 = 0;
                                    $SelisihDateM3 = 0;
                                    $SelisihDateM4 = 0;

                                    // Jika selisih masa bebas lebih dari nol
                                    if ($SelisihMasaBebas > 0) {
                                        $startDenda = date("Y-m-d", strtotime($TglBilling . "-" . $SelisihMasaBebas . " days")); // mulai start denda
                                        //////echo"startDenda : ".$startDenda."<br>";

                                        $DateTimeDenda1 = new DateTime($startDenda); // get timezone mulai denda
                                        $DateTimeDenda2 = new DateTime($TglBilling); // get timezone tgl billing
                                        $difference = $DateTimeDenda1->diff($DateTimeDenda2); // hitung selisih mulai denda dengan tgl billing
                                        $selisihD = $difference->days; // convert selisih menjadi hari
                                        $selisihDenda = $selisihD; // simpan kedalam variable
                                        //////echo"Selisih DENDA : ".$selisihDenda."<br>";

                                        // Loop data kurang dari sama dengan jumlah selisih denda
                                        for ($c = 0; $c <= $selisihDenda; $c++) {
                                            $checkDendaDate = date("Y-m-d", strtotime($c . " days" . $startDenda));
                                            //////echo$checkDendaDate." - ";
                                            // Jika data $checkDate dan $checkDate1 ada && selisihNHI tidak kosong maka
                                            if ((in_array($checkDendaDate, $checkDate1)) && ($selisihNHI != 0)) {
                                                $SelisihDateNHI = 0;
                                                $DendaNHI = $SelisihDateNHI * (($Charge_sppb * 0) * $tnhi); // Denda NHI = selisih tgl NHI * ((biaya dasar sppb * 0) * 2)
                                                //////echo"$DendaNHI";
                                            } else {
                                                if ($checkDendaDate == $MasaBebas) {
                                                    $SelisihDateM1 = 0;
                                                    $DendaM1 = $SelisihDateM1 * (($Charge_sppb * 0) * $tnhi); // Denda Masa 1 = selisih tgl masa 1 * ((biaya dasar sppb * 0) * 2)
                                                    //////echo"$DendaM1";
                                                }
                                                if ($checkDendaDate == $Masa1) {
                                                    $SelisihDateM2 = 1;
                                                    $DendaM2 = $SelisihDateM2 * (($Charge_sppb * 3) * $tnhi); // Denda masa 2 = 1 * ((biaya dasar sppb * 3) * 2)
                                                    //////echo"$DendaM2";
                                                }
                                                if ($checkDendaDate == $Masa2) {
                                                    $SelisihDateM3 = 1;
                                                    $DendaM3 = $SelisihDateM3 * (($Charge_sppb * 6) * $tnhi); // Denda masa 3 = 1 * ((biaya dasar sppb * 6) * 2)
                                                    //////echo"$DendaM3";
                                                }
                                                if (($checkDendaDate >= $Masa3) && ($checkDendaDate <= $TglBilling)) {
                                                    $SelisihDateM4++;
                                                    $DendaM4 = $DendaM4 + (($Charge_sppb * 6) * $tnhi); // Denda masa 4 = denda masa 4 + ((biaya dasar sppb * 9) * 2)
                                                    //////echo"$DendaM4";
                                                }
                                            }
                                            //////echo"<br>";
                                        }
                                        // Total = denda masa 1 + denda masa 2 + denda masa 3 + denda masa 4
                                        $TOTAL_DENDA = $DendaM1 + $DendaM2 + $DendaM3 + $DendaM4;
                                        //jika lebih dari nol
                                        if ($TOTAL_DENDA > 0) {
                                            $DETAIL_DENDASPPB['ID_REQ'] = $REQ;
                                            $DETAIL_DENDASPPB['NO_CONT'] = $DTL['NO_CONT'];
                                            $DETAIL_DENDASPPB['UKR_CONT'] = $DTL['UKR_CONT'];
                                            $DETAIL_DENDASPPB['ISO_CODE'] = $TYPE_CONT;
                                            $DETAIL_DENDASPPB['STATUS'] = $DTL['STATUS'];
                                            $DETAIL_DENDASPPB['TARIF_ID'] = $SQL_SPPB->TARIF_ID;
                                            $DETAIL_DENDASPPB['CHARGE'] = $Charge_sppb;
                                            $DETAIL_DENDASPPB['TOTAL_UNIT'] = '1';
                                            $DETAIL_DENDASPPB['TOTAL'] = $TOTAL_DENDA;
                                            $DETAIL_DENDASPPB['PROSEN_M1'] = '0';
                                            $DETAIL_DENDASPPB['SELISIH_M1'] = $SelisihDateM1;
                                            $DETAIL_DENDASPPB['M1_START_DATE'] = $MasaBebas;
                                            $DETAIL_DENDASPPB['M1_END_DATE'] = $MasaBebas;
                                            $DETAIL_DENDASPPB['TOTAL_M1'] = $DendaM1;
                                            $DETAIL_DENDASPPB['PROSEN_M2'] = '3';
                                            $DETAIL_DENDASPPB['SELISIH_M2'] = $SelisihDateM2;
                                            $DETAIL_DENDASPPB['M2_START_DATE'] = $Masa1;
                                            $DETAIL_DENDASPPB['M2_END_DATE'] = $Masa1;
                                            $DETAIL_DENDASPPB['TOTAL_M2'] = $DendaM2;
                                            $DETAIL_DENDASPPB['PROSEN_M3'] = '6';
                                            $DETAIL_DENDASPPB['SELISIH_M3'] = $SelisihDateM3;
                                            $DETAIL_DENDASPPB['M3_START_DATE'] = $Masa2;
                                            $DETAIL_DENDASPPB['M3_END_DATE'] = $Masa2;
                                            $DETAIL_DENDASPPB['TOTAL_M3'] = $DendaM3;
                                            $DETAIL_DENDASPPB['PROSEN_M4'] = $proses_m4;
                                            $DETAIL_DENDASPPB['SELISIH_M4'] = $SelisihDateM4;
                                            $DETAIL_DENDASPPB['M4_START_DATE'] = $startDenda;
                                            $DETAIL_DENDASPPB['M4_END_DATE'] = $TglBilling;
                                            $DETAIL_DENDASPPB['TOTAL_M4'] = $DendaM4;
                                            $DETAIL_DENDASPPB['WK_REKAM'] = date('Y-m-d H:i:s');
                                            $DETAIL_DENDASPPB['FL_DG'] = $DTL['DG'];
                                            $this->db->insert('req_delivery_dtl', $DETAIL_DENDASPPB);
                                            if ($TOTAL_DENDA > 0) {
                                                $SIM_DM1['ID_REQ'] = $REQ;
                                                $SIM_DM1['NO_CONT'] = $DTL['NO_CONT'];
                                                $SIM_DM1['UKR_CONT'] = $DTL['UKR_CONT'];
                                                $SIM_DM1['CHARGE'] = $Charge_sppb;
                                                $SIM_DM1['JENIS_TARIF'] = 'DENDA SPPB 2';
                                                $SIM_DM1['TOTAL'] = $TOTAL_DENDA;
                                                $SIM_DM1['WK_REKAM'] = date('Y-m-d H:i:s');
                                                //print_r($SIM_DM1);
                                                $this->db->insert('req_delivery_simkeu', $SIM_DM1);
                                            }
                                        }
                                    }
                                }

                                #DENDA SP2
                                // Hitung jumlah kontainer per BL
                                $JumlahKontainerPerBL = $COUNTCONT;
                                //////echo"jum cont ".$JumlahKontainerPerBL."<br>";
                                if ($JumlahKontainerPerBL > 30) {
                                    $JumlahMasaBebas = 3;
                                } else {
                                    $JumlahMasaBebas = 2;
                                }

                                $DateTimeSp21 = new DateTime($PaidThru);
                                $DateTimeSp22 = new DateTime($TglBilling);
                                $difference = $DateTimeSp21->diff($DateTimeSp22);
                                $selisih = $difference->days;
                                $GetDateDiff = $selisih;
                                $RangeDate = $GetDateDiff;
                                //////echo"Selisih SP2 > ".$RangeDate."<br>";

                                if ($RangeDate >= $JumlahMasaBebas) {
                                    $SelisihMasaBebas = $RangeDate - $JumlahMasaBebas;
                                    //////echo"SelisihMasaBebas ".$SelisihMasaBebas."<br>";
                                    $startDendaSP2 = date("Y-m-d", strtotime($TglBilling . "+" . $JumlahMasaBebas . " days"));
                                    //////echo"startDendaSp2 : ".$startDendaSP2."<br>";
                                    $SelisihDateM1Sp2 = 0;
                                    $SelisihDateM2Sp2 = 0;
                                    $SelisihDateM3Sp2 = 0;
                                    $SelisihDateM4Sp2 = 0;
                                    $DendaM1Sp2 = 0;
                                    $DendaM2Sp2 = 0;
                                    $DendaM3Sp2 = 0;
                                    $DendaM4Sp2 = 0;
                                    if ($SelisihMasaBebas >= 0) {
                                        for ($c = 0; $c <= $SelisihMasaBebas; $c++) {
                                            $checkDendaPS2Date = date("Y-m-d", strtotime($c . " days" . $startDendaSP2));
                                            //////echo$checkDendaPS2Date." - ";
                                            if ((in_array($checkDendaPS2Date, $checkDate1)) && ($selisihNHI != 0)) {
                                                $SelisihDateNHISp2 = 0;
                                                $DendaMHISp2 = $SelisihDateNHISp2 * (($Charge_sp2 * 0) * $tDendaMHISp2);
                                                //////echo$DendaMHISp2;
                                            } else {
                                                if ($checkDendaPS2Date == $MasaBebas) {
                                                    $SelisihDateM1Sp2 = 0;
                                                    $DendaM1Sp2 = $SelisihDateM1Sp2 * (($Charge_sp2 * 0) * $tDendaMHISp2);
                                                    //////echo$DendaM1Sp2;
                                                }
                                                if ($checkDendaPS2Date == $Masa1) {
                                                    $SelisihDateM2Sp2 = 1;
                                                    $DendaM2Sp2 = $SelisihDateM2Sp2 * (($Charge_sp2 * 3) * $tDendaMHISp2);
                                                    //////echo$DendaM2Sp2;
                                                }
                                                if ($checkDendaPS2Date == $Masa2) {
                                                    $SelisihDateM3Sp2 = 1;
                                                    $DendaM3Sp2 = $SelisihDateM3Sp2 * (($Charge_sp2 * 6) * $tDendaMHISp2);
                                                    //////echo$DendaM3Sp2;
                                                }
                                                if (($checkDendaPS2Date >= $Masa3) && ($checkDendaPS2Date <= $PaidThru)) {
                                                    $SelisihDateM4Sp2++;
                                                    $DendaM4Sp2 = $DendaM4Sp2 + (($Charge_sp2 * 6) * $tDendaMHISp2);
                                                    //////echo$DendaM4Sp2;
                                                }
                                            }
                                            //////echo"<br>";
                                        }
                                    }
                                    $TotalDendaSp2 = $DendaM1Sp2 + $DendaM2Sp2 + $DendaM3Sp2 + $DendaM4Sp2;
                                    if ($TotalDendaSp2 > 0) {
                                        $DENDA_SP2['ID_REQ'] = $REQ;
                                        $DENDA_SP2['NO_CONT'] = $DTL['NO_CONT'];
                                        $DENDA_SP2['UKR_CONT'] = $DTL['UKR_CONT'];
                                        $DENDA_SP2['ISO_CODE'] = $TYPE_CONT;
                                        $DENDA_SP2['STATUS'] = $DTL['STATUS'];
                                        $DENDA_SP2['TARIF_ID'] = $SQL_SP2->TARIF_ID;
                                        $DENDA_SP2['CHARGE'] = $Charge_sp2;
                                        $DENDA_SP2['TOTAL_UNIT'] = '1';
                                        $DENDA_SP2['TOTAL'] = $TotalDendaSp2;
                                        $DENDA_SP2['PROSEN_M1'] = '0';
                                        $DENDA_SP2['SELISIH_M1'] = $SelisihDateM1Sp2;
                                        $DENDA_SP2['M1_START_DATE'] = $MasaBebas;
                                        $DENDA_SP2['M1_END_DATE'] = $MasaBebas;
                                        $DENDA_SP2['TOTAL_M1'] = $DendaM1Sp2;
                                        $DENDA_SP2['PROSEN_M2'] = '3';
                                        $DENDA_SP2['SELISIH_M2'] = $SelisihDateM2Sp2;
                                        $DENDA_SP2['M2_START_DATE'] = $Masa1;
                                        $DENDA_SP2['M2_END_DATE'] = $Masa1;
                                        $DENDA_SP2['TOTAL_M2'] = $DendaM2Sp2;
                                        $DENDA_SP2['PROSEN_M3'] = '6';
                                        $DENDA_SP2['SELISIH_M3'] = $SelisihDateM3Sp2;
                                        $DENDA_SP2['M3_START_DATE'] = $Masa2;
                                        $DENDA_SP2['M3_END_DATE'] = $Masa2;
                                        $DENDA_SP2['TOTAL_M3'] = $DendaM3Sp2;
                                        $DENDA_SP2['PROSEN_M4'] = $proses_m4;
                                        $DENDA_SP2['SELISIH_M4'] = $SelisihDateM4Sp2;
                                        $DENDA_SP2['M4_START_DATE'] = $startDendaSP2;
                                        $DENDA_SP2['M4_END_DATE'] = $PaidThru;
                                        $DENDA_SP2['TOTAL_M4'] = $DendaM4Sp2;
                                        $DENDA_SP2['WK_REKAM'] = date('Y-m-d H:i:s');
                                        $this->db->insert('req_delivery_dtl', $DENDA_SP2);
                                        $GantiTglSp2['TGL_REQ_SP2'] = $PaidThru;
                                        $this->db->where(array('ID_REQ' => $REQ));
                                        $this->db->update('req_delivery_hdr', $GantiTglSp2);
                                        if ($TotalDendaSp2 > 0) {
                                            $SIM_M1SP2['ID_REQ'] = $REQ;
                                            $SIM_M1SP2['NO_CONT'] = $DTL['NO_CONT'];
                                            $SIM_M1SP2['UKR_CONT'] = $DTL['UKR_CONT'];
                                            $SIM_M1SP2['CHARGE'] = $Charge_sp2;
                                            $SIM_M1SP2['JENIS_TARIF'] = 'DENDA SP 2';
                                            $SIM_M1SP2['TOTAL'] = $TotalDendaSp2;
                                            $SIM_M1SP2['WK_REKAM'] = date('Y-m-d H:i:s');
                                            $this->db->insert('req_delivery_simkeu', $SIM_M1SP2);
                                        }
                                    }
                                }
                            }
                            #MONITOR
                            // SQL_P_REEFER
                            $TARIF_ID_MONITOR = $SQL_M_REEFER->TARIF_ID;
                            if ($FL_DG == '') {
                                $TARIF_MONITOR = $SQL_M_REEFER->TARIF;
                            } else if ($FL_DG == 'DG') { // Jika FL_DG ada maka
                                $TARIF_MONITOR = $SQL_M_REEFER->TARIF * 2;
                            }

                            if ($CEKUNPLUG == null) {
                                $monitoringReefer = 0;
                            }

                            //////echo'TARIF ID : '.$TARIF_ID_MONITOR;
                            //////echo'$TARIF_MONITOR : '.$TARIF_MONITOR;
                            $DETAIL_MONITOR['ID_REQ'] = $REQ;
                            $DETAIL_MONITOR['NO_CONT'] = $DTL['NO_CONT'];
                            $DETAIL_MONITOR['UKR_CONT'] = $DTL['UKR_CONT'];
                            $DETAIL_MONITOR['ISO_CODE'] = $TYPE_CONT;
                            $DETAIL_MONITOR['STATUS'] = $DTL['STATUS'];
                            $DETAIL_MONITOR['TARIF_ID'] = $TARIF_ID_MONITOR;
                            $DETAIL_MONITOR['CHARGE'] = $TARIF_MONITOR;
                            $DETAIL_MONITOR['TOTAL_UNIT'] = '1';
                            $DETAIL_MONITOR['TOTAL'] = $monitoringReefer;
                            $DETAIL_MONITOR['PLUG_START_DATE'] = $WK_PLUG;
                            $DETAIL_MONITOR['PLUG_END_DATE'] = $WK_UNPLUG;
                            $DETAIL_MONITOR['TOTAL_JAM'] = $hitungJam;
                            $DETAIL_MONITOR['TOTAL_SHIFT'] = $hitungSelisih;
                            $DETAIL_MONITOR['WK_REKAM'] = date('Y-m-d H:i:s');

                            $SIM_DETAIL_MONITOR['ID_REQ'] = $REQ;
                            $SIM_DETAIL_MONITOR['NO_CONT'] = $DTL['NO_CONT'];
                            $SIM_DETAIL_MONITOR['UKR_CONT'] = $DTL['UKR_CONT'];
                            $SIM_DETAIL_MONITOR['CHARGE'] = $TARIF_MONITOR;
                            $SIM_DETAIL_MONITOR['JENIS_TARIF'] = 'MONITORING';
                            $SIM_DETAIL_MONITOR['TOTAL'] = $monitoringReefer;
                            $SIM_DETAIL_MONITOR['WK_REKAM'] = date('Y-m-d H:i:s');
                            $this->db->insert('req_delivery_dtl', $DETAIL_MONITOR);
                            $this->db->insert('req_delivery_simkeu', $SIM_DETAIL_MONITOR);

                            #PLUG
                            if ($FL_DG == '') {
                                $TARIF_PLUG = $SQL_P_REEFER->TARIF;
                            } else if ($FL_DG == 'DG') { // Jika FL_DG ada maka
                                $TARIF_PLUG = $SQL_P_REEFER->TARIF * 2;
                            }
                            $TARIF_ID_PLUG = $SQL_P_REEFER->TARIF_ID;

                            if ($CEKUNPLUG == null) {
                                $pluginReefer = 0;
                            }
                            //////echo'TARIF PLUG ID : '.$TARIF_ID_PLUG;
                            //////echo'$TARIF_PLUG : '.$TARIF_PLUG;
                            $DETAIL_PLUG['ID_REQ'] = $REQ;
                            $DETAIL_PLUG['NO_CONT'] = $DTL['NO_CONT'];
                            $DETAIL_PLUG['UKR_CONT'] = $DTL['UKR_CONT'];
                            $DETAIL_PLUG['ISO_CODE'] = $TYPE_CONT;
                            $DETAIL_PLUG['STATUS'] = $DTL['STATUS'];
                            $DETAIL_PLUG['TARIF_ID'] = $TARIF_ID_PLUG;
                            $DETAIL_PLUG['CHARGE'] = $TARIF_PLUG;
                            $DETAIL_PLUG['TOTAL_UNIT'] = '1';
                            $DETAIL_PLUG['TOTAL'] = $pluginReefer;
                            $DETAIL_PLUG['PLUG_START_DATE'] = $WK_PLUG;
                            $DETAIL_PLUG['PLUG_END_DATE'] = $WK_UNPLUG;
                            $DETAIL_PLUG['TOTAL_JAM'] = $hitungJam;
                            $DETAIL_PLUG['TOTAL_SHIFT'] = $hitungSelisih;
                            $DETAIL_PLUG['WK_REKAM'] = date('Y-m-d H:i:s');

                            $SIM_DETAIL_PLUG['ID_REQ'] = $REQ;
                            $SIM_DETAIL_PLUG['NO_CONT'] = $DTL['NO_CONT'];
                            $SIM_DETAIL_PLUG['UKR_CONT'] = $DTL['UKR_CONT'];
                            $SIM_DETAIL_PLUG['CHARGE'] = $TARIF_PLUG;
                            $SIM_DETAIL_PLUG['JENIS_TARIF'] = 'PLUGIN REEFER';
                            $SIM_DETAIL_PLUG['TOTAL'] = $pluginReefer;
                            $SIM_DETAIL_PLUG['WK_REKAM'] = date('Y-m-d H:i:s');
                            $this->db->insert('req_delivery_dtl', $DETAIL_PLUG);
                            $this->db->insert('req_delivery_simkeu', $SIM_DETAIL_PLUG);

                            #LIFT ON
                            $TARIF_ID_LO = $SQL_LO->TARIF_ID;
                            $TARIF_LO = $SQL_LO->TARIF;
                            //////echo"TARIF ID LO : ".$TARIF_ID_LO;
                            //////echo"TARIF LO : ".$TARIF_LO;
                            $DATA_LO['ID_REQ'] = $REQ;
                            $DATA_LO['NO_CONT'] = $DTL['NO_CONT'];
                            $DATA_LO['UKR_CONT'] = $DTL['UKR_CONT'];
                            $DATA_LO['ISO_CODE'] = $TYPE_CONT;
                            $DATA_LO['STATUS'] = $DTL['STATUS'];
                            $DATA_LO['TARIF_ID'] = $TARIF_ID_LO;
                            $DATA_LO['CHARGE'] = $TARIF_LO;
                            $DATA_LO['TOTAL_UNIT'] = '1';
                            $DATA_LO['TOTAL'] = $TARIF_LO;
                            $DATA_LO['WK_REKAM'] = date('Y-m-d H:i:s');
                            $SIM_LOSP2['ID_REQ'] = $REQ;
                            $SIM_LOSP2['NO_CONT'] = $DTL['NO_CONT'];
                            $SIM_LOSP2['UKR_CONT'] = $DTL['UKR_CONT'];
                            $SIM_LOSP2['CHARGE'] = $TARIF_LO;
                            $SIM_LOSP2['JENIS_TARIF'] = 'LIFT ON';
                            $SIM_LOSP2['TOTAL'] = $TARIF_LO;
                            $SIM_LOSP2['WK_REKAM'] = date('Y-m-d H:i:s');
                            $this->db->insert('req_delivery_dtl', $DATA_LO);
                            $this->db->insert('req_delivery_simkeu', $SIM_LOSP2);
                        }
                    } else {
                        //////echo"SELECT * FROM $mtarif WHERE SIZE = '$SIZE' AND TYPE ='$TYPE' AND STATUS =  '$STATUS' AND JENIS_BIAYA != 'LIFT ON'";die();
                        $SQL = $this->db->query("SELECT * FROM $mtarif WHERE SIZE = '$SIZE' AND TYPE ='$TYPE' AND STATUS =  '$STATUS' AND JENIS_BIAYA != 'LIFT ON'")->row();
                        if ($TYPE == 'OVD') {
                            $SQL_LO = $this->db->query("SELECT * FROM $mtarif WHERE SIZE = '$SIZE' AND TYPE ='$TYPE' AND JENIS_BIAYA = 'LIFT ON'")->row();
                        } else {
                            $SQL_LO = $this->db->query("SELECT * FROM $mtarif WHERE SIZE = '$SIZE' AND STATUS =  '$STATUS' AND JENIS_BIAYA = 'LIFT ON'")->row();
                        }
                        $WK_IN = $this->db->query("SELECT WK_IN FROM t_cocostscont A INNER JOIN t_cocostshdr B ON A.ID = B.ID WHERE NO_CONT = '$NO_CONT' AND B.NM_ANGKUT = '$NM_KAPAL' AND B.NO_VOY_FLIGHT LIKE '%$NO_VOY%' AND WK_IN IS NOT NULL")->row()->WK_IN;
                        $SQL_ADMIN = $this->db->query("SELECT * FROM $mtarif WHERE JENIS_BIAYA = 'ADMIN'")->row();
                        $SQL_SPPB = $this->db->query("SELECT * FROM $mtarif WHERE SIZE = '$SIZE' AND TYPE ='$TYPE' AND STATUS =  '$STATUS' AND JENIS_BIAYA='SPPB'")->row();
                        $SQL_SP2 = $this->db->query("SELECT * FROM $mtarif WHERE SIZE = '$SIZE' AND TYPE ='$TYPE' AND STATUS =  '$STATUS' AND JENIS_BIAYA='SP2'")->row();
                        $COUNT_CONT = $this->db->query("SELECT COUNT(A.NO_CONT) AS 'NO_CONT' FROM t_permit_cont A, t_permit_hdr C WHERE C.ID = A.ID AND C.NO_DOK_INOUT ='$NO_DOK'")->row();
                        $SQL_TRUCK = $this->db->query("SELECT * FROM $mtarif WHERE JENIS_BIAYA = 'TRUCK'")->row();

                        $TARIF_ID = $SQL->TARIF_ID;
                        $TARIF_HARGA = $SQL->TARIF;
                        //$MAX_ID      = $SQL_MAX;
                        $cek = $WK_IN;
                        $COUNTCONT = $COUNT_CONT->NO_CONT;

                        if ($cek == null) {
                            $error += 1;
                            // ////echo"ERROR";
                            // $message = "Tgl Stacking Tidak Ada";
                            // ////echo"MSG#ERR#".$message."#";
                            # ++++ DELETE BILLING NPCT1 ++++ #
                            $this->db->where(array('ID_REQ' => $REQ));
                            $this->db->delete('req_delivery_hdr');

                            # ++++ DELETE BILLING DETAIL ++++ #
                            $this->db->where(array('ID_REQ' => $REQ));
                            $this->db->delete('req_delivery_dtl');

                            # ++++ DELETE BILLING DETAIL SIMKEU++++ #
                            $this->db->where(array('ID_REQ' => $REQ));
                            $this->db->delete('req_delivery_simkeu');

                            # ++++ SFLAG CONTAINER++++ #
                            $this->db->where(array('ID' => $ID_CONT, 'NO_CONT' => $NO_CONT));
                            $this->db->update('t_permit_cont', array('KD_STATUS_BIL' => null, 'WK_STATUS_BIL' => null));

                            return $this->httpres(200, 'error', '', 'Tgl Stacking Tidak Ada');
                            die();
                        } else if ($cek != null) {
                            $this->db->where(array('ID' => $ID_CONT, 'NO_CONT' => $NO_CONT));
                            $this->db->update('t_permit_cont', array('KD_STATUS_BIL' => '901', 'WK_STATUS_BIL' => $NOW));

                            $PaidThru = $PaidThruReferc;
                            $WkBilling = date('Y-m-d H:i:s');
                            // $WKBHD         = date('Y-m-d', strtotime($WK_BHD));

                            if ($FL_DG == '') {
                                $Charge = $TARIF_HARGA;
                                $TYPE_CONT = $DTL['TYPE'];
                                $Charge_sppb = $SQL_SPPB->TARIF;
                                $Charge_sp2 = $SQL_SP2->TARIF;
                            } else if ($FL_DG == 'DG') {
                                $Charge = ($TARIF_HARGA * 2);
                                $TYPE_CONT = $DTL['DG'];
                                $Charge_sppb = ($SQL_SPPB->TARIF * 2);
                                $Charge_sp2 = ($SQL_SP2->TARIF * 2);
                            } else {
                                $Charge = ($TARIF_HARGA * 3);
                                $TYPE_CONT = $DTL['DG'];
                                $Charge_sppb = ($SQL_SPPB->TARIF * 3);
                                $Charge_sp2 = ($SQL_SP2->TARIF * 3);
                            }

                            $jam = date("Hi", strtotime($cek));
                            if ($jam > "1200" && $DTL['STATUS'] != "EMPTY") {
                                $MasaBebas = date("Y-m-d", strtotime($cek . "+1 days"));
                            } else {
                                $MasaBebas = date("Y-m-d", strtotime($cek));
                            }

                            $indexNHI = 0;
                            $SelisihNHI = 0;
                            $SelisihMasa1 = 0;
                            $SelisihMasa2 = 0;
                            $SelisihMasa3 = 0;
                            $PenumpukanNHI = 0;
                            $PenumpukanMasa1 = 0;
                            $PenumpukanMasa2 = 0;
                            $PenumpukanMasa3 = 0;
                            $SelisihNPCT1Masa1 = 0;
                            $SelisihNPCT1Masa2 = 0;
                            $SelisihNPCT1Masa3 = 0;
                            $PenumpukanNPCT1Masa1 = 0;
                            $PenumpukanNPCT1Masa2 = 0;
                            $PenumpukanNPCT1Masa3 = 0;

                            if ($STATUS == 'EMPTY') {
                                $Masa1 = date("Y-m-d", strtotime($MasaBebas . "+2 days"));
                                $Masa2 = date("Y-m-d", strtotime($Masa1 . "+7 days"));
                                $Masa3 = date("Y-m-d", strtotime($Masa2 . "+1 days"));

                                ////echo"Masa Bebas     > ".$MasaBebas."<br>";
                                ////echo"Masa 1         > ".$Masa1."<br>";
                                ////echo"Masa 2         > ".$Masa2."<br>";
                                ////echo"Masa 3         > ".$Masa3."<br>";
                                ////echo"Masa Paid        > ".$PaidThru."<br>";
                                // -------------------------------------------------------------------------------    PERHITUNGAN CG
                                $DateTime1 = new DateTime($MasaBebas);
                                $DateTime2 = new DateTime($PaidThru);
                                $difference = $DateTime1->diff($DateTime2);
                                $selisihDiff = $difference->days;
                                $selisih = $selisihDiff;

                                for ($i = 0; $i <= $selisih; $i++) {
                                    $checkDate = date("Y-m-d", strtotime($i . " days" . $MasaBebas));
                                    ////echo$checkDate."--";
                                    if ($checkDate <= $Masa1) {
                                        $SelisihMasa1++;
                                        $PenumpukanMasa1 = $PenumpukanMasa1 + ($Charge * 0);
                                        ////echo$PenumpukanMasa1 ;
                                    }
                                    if (($checkDate > $Masa1) && ($checkDate <= $Masa2)) {
                                        $SelisihMasa2++;
                                        $PenumpukanMasa2 = $PenumpukanMasa2 + ($Charge * 2);
                                        ////echo$PenumpukanMasa2;
                                        if ($PaidThru >= $Masa2) {
                                            $EndDateMasa2 = $Masa2;
                                        } else {
                                            $EndDateMasa2 = $PaidThru;
                                        }
                                    }
                                    if (($checkDate >= $Masa3) && ($checkDate <= $PaidThru)) {
                                        $SelisihMasa3++;
                                        $PenumpukanMasa3 = $PenumpukanMasa3 + ($Charge * 3);
                                        ////echo$PenumpukanMasa3;
                                    }
                                    ////echo"<br>";
                                }
                                $Total = $PenumpukanMasa1 + $PenumpukanMasa2 + $PenumpukanMasa3;
                                if ($Total > 0) {
                                    $DETAIL['ID_REQ'] = $REQ;
                                    $DETAIL['NO_CONT'] = $DTL['NO_CONT'];
                                    $DETAIL['UKR_CONT'] = $DTL['UKR_CONT'];
                                    $DETAIL['ISO_CODE'] = $TYPE_CONT;
                                    $DETAIL['STATUS'] = $DTL['STATUS'];
                                    $DETAIL['TARIF_ID'] = $TARIF_ID;
                                    $DETAIL['CHARGE'] = $Charge;
                                    $DETAIL['TOTAL_UNIT'] = '1';
                                    $DETAIL['TOTAL'] = $Total;
                                    $DETAIL['PROSEN_M1'] = '0';
                                    $DETAIL['SELISIH_M1'] = '0';
                                    $DETAIL['M1_START_DATE'] = null;
                                    $DETAIL['M1_END_DATE'] = null;
                                    $DETAIL['TOTAL_M1'] = '0';
                                    $DETAIL['PROSEN_M2'] = '0';
                                    $DETAIL['SELISIH_M2'] = '0';
                                    $DETAIL['M2_START_DATE'] = null;
                                    $DETAIL['M2_END_DATE'] = null;
                                    $DETAIL['TOTAL_M2'] = $PenumpukanMasa1;
                                    $DETAIL['PROSEN_M3'] = '2';
                                    $DETAIL['SELISIH_M3'] = $SelisihMasa2;
                                    $DETAIL['M3_START_DATE'] = date("Y-m-d", strtotime($Masa1 . "+1 days"));
                                    $DETAIL['M3_END_DATE'] = $EndDateMasa2;
                                    $DETAIL['TOTAL_M3'] = $PenumpukanMasa2;
                                    $DETAIL['PROSEN_M4'] = '3';
                                    $DETAIL['SELISIH_M4'] = $SelisihMasa3;
                                    $DETAIL['M4_START_DATE'] = $Masa3;
                                    $DETAIL['M4_END_DATE'] = $PaidThru;
                                    $DETAIL['TOTAL_M4'] = $PenumpukanMasa3;
                                    $DETAIL['WK_REKAM'] = date('Y-m-d H:i:s');
                                    $DETAIL['FL_DG'] = $DTL['DG'];
                                    $this->db->insert('req_delivery_dtl', $DETAIL);
                                    if ($PenumpukanMasa1 > 0) {
                                        $SIM_M1['ID_REQ'] = $REQ;
                                        $SIM_M1['NO_CONT'] = $DTL['NO_CONT'];
                                        $SIM_M1['UKR_CONT'] = $DTL['UKR_CONT'];
                                        $SIM_M1['CHARGE'] = $Charge;
                                        $SIM_M1['JENIS_TARIF'] = 'PENUMPUKAN 1';
                                        $SIM_M1['TOTAL'] = $PenumpukanMasa1;
                                        $SIM_M1['WK_REKAM'] = date('Y-m-d H:i:s');
                                        //print_r($SIM_M1);
                                        $this->db->insert('req_delivery_simkeu', $SIM_M1);
                                    }
                                    if ($PenumpukanMasa2 > 0) {
                                        $SIM_M2['ID_REQ'] = $REQ;
                                        $SIM_M2['NO_CONT'] = $DTL['NO_CONT'];
                                        $SIM_M2['UKR_CONT'] = $DTL['UKR_CONT'];
                                        $SIM_M2['CHARGE'] = $Charge;
                                        $SIM_M2['JENIS_TARIF'] = 'PENUMPUKAN 1.1';
                                        $SIM_M2['TOTAL'] = $PenumpukanMasa2;
                                        $SIM_M2['WK_REKAM'] = date('Y-m-d H:i:s');
                                        //print_r($SIM_M2);
                                        $this->db->insert('req_delivery_simkeu', $SIM_M2);
                                    }
                                    if ($PenumpukanMasa3 > 0) {
                                        $SIM_M3['ID_REQ'] = $REQ;
                                        $SIM_M3['NO_CONT'] = $DTL['NO_CONT'];
                                        $SIM_M3['UKR_CONT'] = $DTL['UKR_CONT'];
                                        $SIM_M3['CHARGE'] = $Charge;
                                        $SIM_M3['JENIS_TARIF'] = 'PENUMPUKAN 2';
                                        $SIM_M3['TOTAL'] = $PenumpukanMasa3;
                                        $SIM_M3['WK_REKAM'] = date('Y-m-d H:i:s');
                                        //print_r($SIM_M3);
                                        $this->db->insert('req_delivery_simkeu', $SIM_M3);
                                    }
                                }
                            } else {
                                $Masa1 = date("Y-m-d", strtotime($MasaBebas . "+1 days"));
                                $Masa2 = date("Y-m-d", strtotime($Masa1 . "+1 days"));
                                $Masa3 = date("Y-m-d", strtotime($Masa2 . "+1 days"));

                                ////echo"Masa Bebas     > ".$MasaBebas."<br>";
                                ////echo"Masa 1         > ".$Masa1."<br>";
                                ////echo"Masa 2         > ".$Masa2."<br>";
                                ////echo"Masa 3         > ".$Masa3."<br>";
                                ////echo"Masa Paid        > ".$PaidThru."<br>";
                                ////echo"Masa NHI        > ".$StartNHI."<br>";
                                ////echo"Masa END NHI    > ".$EndNHI."<br>";
                                ////echo"Masa BEHANDLE    > ".$WK_BHD."<br>";
                                // -------------------------------------------------------------------------------    PERHITUNGAN CG
                                $DateTime1 = new DateTime($MasaBebas);
                                $DateTime2 = new DateTime($PaidThru);
                                $difference = $DateTime1->diff($DateTime2);
                                $selisihDiff = $difference->days;
                                $selisih = $selisihDiff;
                                ////echo"Selisih Paid > ".$selisih."<br>";

                                $DateTime3 = new DateTime($StartNHI);
                                $DateTime4 = new DateTime($EndNHI);
                                $difference = $DateTime3->diff($DateTime4);
                                $selisihDiff = $difference->days;
                                $selisihNHI = $selisihDiff;
                                ////echo"Selisih NHI > ".$selisihNHI."<br>";

                                for ($i = 0; $i <= $selisihNHI; $i++) {
                                    $checkDate1[] = date("Y-m-d", strtotime($i . " days" . $StartNHI));
                                }
                                $PenumpukanMasaBebas = 0;
                                $SelisihMasaBebas = 0;
                                for ($j = 0; $j <= $selisih; $j++) {
                                    $checkDate = date("Y-m-d", strtotime($j . " days" . $MasaBebas));
                                    ////echo$checkDate." - ";
                                    if ((in_array($checkDate, $checkDate1)) && ($selisihNHI != 0)) {
                                        if ($indexNHI == 0) {
                                            $PenumpukanNHI = $PenumpukanNHI + ($Charge * 0);
                                            ////echo$PenumpukanNHI;
                                        } else {
                                            $SelisihNHI++;
                                            $PenumpukanNHI = $SelisihNHI * ($Charge * $tnhi);
                                            ////echo$PenumpukanNHI;
                                        }
                                        $indexNHI++;
                                    } else {
                                        if ($checkDate == $MasaBebas) {
                                            $SelisihMasaBebas = 0;
                                            $PenumpukanMasaBebas = $SelisihMasaBebas * ($Charge * 0);
                                            ////echo$PenumpukanMasaBebas;
                                        }
                                        if ($checkDate == $Masa1) {
                                            $SelisihMasa1 = 1;
                                            $PenumpukanMasa1 = $SelisihMasa1 * ($Charge * 3);
                                            ////echo$PenumpukanMasa1;
                                        }
                                        if ($checkDate == $Masa2) {
                                            $SelisihMasa2 = 1;
                                            $PenumpukanMasa2 = $SelisihMasa2 * ($Charge * 6);
                                            ////echo$PenumpukanMasa2;
                                        }
                                        if (($checkDate >= $Masa3) && ($checkDate <= $PaidThru)) {
                                            $SelisihMasa3++;
                                            $PenumpukanMasa3 = $PenumpukanMasa3 + ($Charge * $tpenumpukanmasa3);
                                            ////echo$PenumpukanMasa3;
                                        }
                                    }
                                    ////echo"<br>";
                                }

                                $Total = $PenumpukanMasaBebas + $PenumpukanNHI + $PenumpukanMasa1 + $PenumpukanMasa2 + $PenumpukanMasa3;
                                ////echo"Total         > ".$Total."<br>";
                                if ($Total > 0) {
                                    $DETAIL['ID_REQ'] = $REQ;
                                    $DETAIL['NO_CONT'] = $DTL['NO_CONT'];
                                    $DETAIL['UKR_CONT'] = $DTL['UKR_CONT'];
                                    $DETAIL['ISO_CODE'] = $TYPE_CONT;
                                    $DETAIL['STATUS'] = $DTL['STATUS'];
                                    $DETAIL['TARIF_ID'] = $TARIF_ID;
                                    $DETAIL['CHARGE'] = $Charge;
                                    $DETAIL['TOTAL_UNIT'] = '1';
                                    $DETAIL['TOTAL'] = $Total;
                                    $DETAIL['PROSEN_M1'] = '0';
                                    $DETAIL['SELISIH_M1'] = $SelisihMasaBebas;
                                    $DETAIL['M1_START_DATE'] = $MasaBebas;
                                    $DETAIL['M1_END_DATE'] = $MasaBebas;
                                    $DETAIL['TOTAL_M1'] = $PenumpukanMasaBebas;
                                    $DETAIL['PROSEN_M2'] = '3';
                                    $DETAIL['SELISIH_M2'] = $SelisihMasa1;
                                    $DETAIL['M2_START_DATE'] = $Masa1;
                                    $DETAIL['M2_END_DATE'] = $Masa1;
                                    $DETAIL['TOTAL_M2'] = $PenumpukanMasa1;
                                    $DETAIL['PROSEN_M3'] = '6';
                                    $DETAIL['SELISIH_M3'] = $SelisihMasa2;
                                    $DETAIL['M3_START_DATE'] = $Masa2;
                                    $DETAIL['M3_END_DATE'] = $Masa2;
                                    $DETAIL['TOTAL_M3'] = $PenumpukanMasa2;
                                    $DETAIL['PROSEN_M4'] = $proses_m4;
                                    $DETAIL['SELISIH_M4'] = $SelisihMasa3;
                                    $DETAIL['M4_START_DATE'] = $Masa3;
                                    $DETAIL['M4_END_DATE'] = $PaidThru;
                                    $DETAIL['TOTAL_M4'] = $PenumpukanMasa3;
                                    $DETAIL['PROSEN_NHI'] = '1.5';
                                    $DETAIL['SELISIH_NHI'] = $selisihNHI;
                                    $DETAIL['NHI_START_DATE'] = $StartNHI;
                                    $DETAIL['NHI_END_DATE'] = $EndNHI;
                                    $DETAIL['TOTAL_NHI4'] = $PenumpukanNHI;
                                    $DETAIL['WK_REKAM'] = date('Y-m-d H:i:s');
                                    $DETAIL['FL_DG'] = $DTL['DG'];
                                    $this->db->insert('req_delivery_dtl', $DETAIL);
                                    if ($PenumpukanMasa1 > 0) {
                                        $SIM_M1['ID_REQ'] = $REQ;
                                        $SIM_M1['NO_CONT'] = $DTL['NO_CONT'];
                                        $SIM_M1['UKR_CONT'] = $DTL['UKR_CONT'];
                                        $SIM_M1['CHARGE'] = $Charge;
                                        $SIM_M1['JENIS_TARIF'] = 'PENUMPUKAN 1';
                                        $SIM_M1['TOTAL'] = $PenumpukanMasa1;
                                        $SIM_M1['WK_REKAM'] = date('Y-m-d H:i:s');
                                        //print_r($SIM_M1);
                                        $this->db->insert('req_delivery_simkeu', $SIM_M1);
                                    }
                                    if ($PenumpukanMasa2 > 0) {
                                        $SIM_M2['ID_REQ'] = $REQ;
                                        $SIM_M2['NO_CONT'] = $DTL['NO_CONT'];
                                        $SIM_M2['UKR_CONT'] = $DTL['UKR_CONT'];
                                        $SIM_M2['CHARGE'] = $Charge;
                                        $SIM_M2['JENIS_TARIF'] = 'PENUMPUKAN 1.1';
                                        $SIM_M2['TOTAL'] = $PenumpukanMasa2;
                                        $SIM_M2['WK_REKAM'] = date('Y-m-d H:i:s');
                                        //print_r($SIM_M2);
                                        $this->db->insert('req_delivery_simkeu', $SIM_M2);
                                    }
                                    if ($PenumpukanMasa3 > 0) {
                                        $SIM_M3['ID_REQ'] = $REQ;
                                        $SIM_M3['NO_CONT'] = $DTL['NO_CONT'];
                                        $SIM_M3['UKR_CONT'] = $DTL['UKR_CONT'];
                                        $SIM_M3['CHARGE'] = $Charge;
                                        $SIM_M3['JENIS_TARIF'] = 'PENUMPUKAN 2';
                                        $SIM_M3['TOTAL'] = $PenumpukanMasa3;
                                        $SIM_M3['WK_REKAM'] = date('Y-m-d H:i:s');
                                        //print_r($SIM_M3);
                                        $this->db->insert('req_delivery_simkeu', $SIM_M3);
                                    }
                                    if ($PenumpukanNHI > 0) {
                                        $SIM_NHI['ID_REQ'] = $REQ;
                                        $SIM_NHI['NO_CONT'] = $DTL['NO_CONT'];
                                        $SIM_NHI['UKR_CONT'] = $DTL['UKR_CONT'];
                                        $SIM_NHI['CHARGE'] = $Charge;
                                        $SIM_NHI['JENIS_TARIF'] = 'PENUMPUKAN NHI';
                                        $SIM_NHI['TOTAL'] = $PenumpukanNHI;
                                        $SIM_NHI['WK_REKAM'] = date('Y-m-d H:i:s');
                                        //print_r($SIM_NHI);
                                        $this->db->insert('req_delivery_simkeu', $SIM_NHI);
                                    }
                                }

                                #DENDA_SPPB
                                $holiday = $this->db->query("SELECT * FROM t_hari_libur WHERE DATE_FORMAT(TANGGAL,'%Y-%m-%d') = '$TglSPPB'")->row();
                                if ($holiday) {
                                    $check_libur = date('Y-m-d', strtotime($holiday->TANGGAL . ' + 1 days'));
                                }

                                if ($holiday != null) {
                                    $CheckHariLibur = true;
                                } else {
                                    $CheckHariLibur = false;
                                }

                                $CheckDaySppb = strtoupper(trim(date("D", strtotime($TglSPPB))));
                                $day = strtoupper(trim(date("D", strtotime($WkBilling))));
                                $TglBilling = strtoupper(trim(date("Y-m-d", strtotime($WkBilling))));
                                $TglStack = strtoupper(trim(date("Y-m-d", strtotime($cek))));

                                ////echo"TglBilling         > ".$TglBilling."<br>";
                                ////echo"TglStack             > ".$TglStack."<br>";
                                ////echo"TglSPPB             > ".$TglSPPB."<br>";

                                if ($TglSPPB != $TglBilling) {
                                    if ($TglSPPB <= $TglStack) {
                                        $JumlahMasaBebas = 2; // 3 hari
                                        $DateTime5 = new DateTime($TglBilling);
                                        $DateTime6 = new DateTime($TglStack);
                                        $difference = $DateTime5->diff($DateTime6);
                                        $selisihM44 = $difference->days;
                                        $selisihM4 = $selisihM44;
                                        $RangeDate = $selisihM4;
                                        ////echo"1. RangeDate : ".$RangeDate."<br>";
                                    } else {
                                        if (($day == "SUN") || ($day == "SAT") || ($CheckHariLibur) || ($CheckDaySppb == "FRI") || ($CheckDaySppb == "SAT")) {
                                            $JumlahMasaBebas = $tjmlmasabebas1; // 3 hari
                                        } else {
                                            $JumlahMasaBebas = $tjmlmasabebas2; // 2 hari
                                        }
                                        $DateTime7 = new DateTime($TglBilling);
                                        $DateTime8 = new DateTime($TglSPPB);
                                        $difference = $DateTime7->diff($DateTime8);
                                        $selisihM44 = $difference->days;
                                        $selisihM46 = $selisihM44;
                                        $RangeDate = $selisihM46;
                                        ////echo"2. RangeDate : ".$RangeDate."<br>";
                                    }
                                    $SelisihMasaBebas = $RangeDate - $JumlahMasaBebas;
                                    ////echo"SelisihMasaBebas     : ".$SelisihMasaBebas."<br>";
                                    ////echo"JumlahMasaBebas    : ".$JumlahMasaBebas."<br>";

                                    $DendaM1 = 0;
                                    $DendaM2 = 0;
                                    $DendaM3 = 0;
                                    $DendaM4 = 0;
                                    $SelisihDateM1 = 0;
                                    $SelisihDateM2 = 0;
                                    $SelisihDateM3 = 0;
                                    $SelisihDateM4 = 0;

                                    if ($SelisihMasaBebas > 0) {
                                        $startDenda = date("Y-m-d", strtotime($TglBilling . "-" . $SelisihMasaBebas . " days"));
                                        ////echo"startDenda : ".$startDenda."<br>";

                                        $DateTimeDenda1 = new DateTime($startDenda);
                                        $DateTimeDenda2 = new DateTime($TglBilling);
                                        $difference = $DateTimeDenda1->diff($DateTimeDenda2);
                                        $selisihD = $difference->days;
                                        $selisihDenda = $selisihD;
                                        ////echo"Selisih DENDA : ".$selisihDenda."<br>";

                                        for ($c = 0; $c <= $selisihDenda; $c++) {
                                            $checkDendaDate = date("Y-m-d", strtotime($c . " days" . $startDenda));
                                            ////echo$checkDendaDate." - ";
                                            if ((in_array($checkDendaDate, $checkDate1)) && ($selisihNHI != 0)) {
                                                $SelisihDateNHI = 0;
                                                $DendaNHI = $SelisihDateNHI * (($Charge_sppb * 0) * $tnhi);
                                                ////echo"$DendaNHI";
                                            } else {
                                                if ($checkDendaDate == $MasaBebas) {
                                                    $SelisihDateM1 = 0;
                                                    $DendaM1 = $SelisihDateM1 * (($Charge_sppb * 0) * $tnhi);
                                                    ////echo"$DendaM1";
                                                }
                                                if ($checkDendaDate == $Masa1) {
                                                    $SelisihDateM2 = 1;
                                                    $DendaM2 = $SelisihDateM2 * (($Charge_sppb * 3) * $tnhi);
                                                    ////echo"$DendaM2";
                                                }
                                                if ($checkDendaDate == $Masa2) {
                                                    $SelisihDateM3 = 1;
                                                    $DendaM3 = $SelisihDateM3 * (($Charge_sppb * 6) * $tnhi);
                                                    ////echo"$DendaM3";
                                                }
                                                if (($checkDendaDate >= $Masa3) && ($checkDendaDate <= $TglBilling)) {
                                                    $SelisihDateM4++;
                                                    $DendaM4 = $DendaM4 + (($Charge_sppb * 6) * $tnhi);
                                                    ////echo"$DendaM4";
                                                }
                                            }
                                            ////echo"<br>";
                                        }
                                        $TOTAL_DENDA = $DendaM1 + $DendaM2 + $DendaM3 + $DendaM4;
                                        if ($TOTAL_DENDA > 0) {
                                            $DETAIL_DENDASPPB['ID_REQ'] = $REQ;
                                            $DETAIL_DENDASPPB['NO_CONT'] = $DTL['NO_CONT'];
                                            $DETAIL_DENDASPPB['UKR_CONT'] = $DTL['UKR_CONT'];
                                            $DETAIL_DENDASPPB['ISO_CODE'] = $TYPE_CONT;
                                            $DETAIL_DENDASPPB['STATUS'] = $DTL['STATUS'];
                                            $DETAIL_DENDASPPB['TARIF_ID'] = $SQL_SPPB->TARIF_ID;
                                            $DETAIL_DENDASPPB['CHARGE'] = $Charge_sppb;
                                            $DETAIL_DENDASPPB['TOTAL_UNIT'] = '1';
                                            $DETAIL_DENDASPPB['TOTAL'] = $TOTAL_DENDA;
                                            $DETAIL_DENDASPPB['PROSEN_M1'] = '0';
                                            $DETAIL_DENDASPPB['SELISIH_M1'] = $SelisihDateM1;
                                            $DETAIL_DENDASPPB['M1_START_DATE'] = $MasaBebas;
                                            $DETAIL_DENDASPPB['M1_END_DATE'] = $MasaBebas;
                                            $DETAIL_DENDASPPB['TOTAL_M1'] = $DendaM1;
                                            $DETAIL_DENDASPPB['PROSEN_M2'] = '3';
                                            $DETAIL_DENDASPPB['SELISIH_M2'] = $SelisihDateM2;
                                            $DETAIL_DENDASPPB['M2_START_DATE'] = $Masa1;
                                            $DETAIL_DENDASPPB['M2_END_DATE'] = $Masa1;
                                            $DETAIL_DENDASPPB['TOTAL_M2'] = $DendaM2;
                                            $DETAIL_DENDASPPB['PROSEN_M3'] = '6';
                                            $DETAIL_DENDASPPB['SELISIH_M3'] = $SelisihDateM3;
                                            $DETAIL_DENDASPPB['M3_START_DATE'] = $Masa2;
                                            $DETAIL_DENDASPPB['M3_END_DATE'] = $Masa2;
                                            $DETAIL_DENDASPPB['TOTAL_M3'] = $DendaM3;
                                            $DETAIL_DENDASPPB['PROSEN_M4'] = $proses_m4;
                                            $DETAIL_DENDASPPB['SELISIH_M4'] = $SelisihDateM4;
                                            $DETAIL_DENDASPPB['M4_START_DATE'] = $startDenda;
                                            $DETAIL_DENDASPPB['M4_END_DATE'] = $TglBilling;
                                            $DETAIL_DENDASPPB['TOTAL_M4'] = $DendaM4;
                                            $DETAIL_DENDASPPB['WK_REKAM'] = date('Y-m-d H:i:s');
                                            $DETAIL_DENDASPPB['FL_DG'] = $DTL['DG'];
                                            $this->db->insert('req_delivery_dtl', $DETAIL_DENDASPPB);
                                            if ($TOTAL_DENDA > 0) {
                                                $SIM_DM1['ID_REQ'] = $REQ;
                                                $SIM_DM1['NO_CONT'] = $DTL['NO_CONT'];
                                                $SIM_DM1['UKR_CONT'] = $DTL['UKR_CONT'];
                                                $SIM_DM1['CHARGE'] = $Charge_sppb;
                                                $SIM_DM1['JENIS_TARIF'] = 'DENDA SPPB 2';
                                                $SIM_DM1['TOTAL'] = $TOTAL_DENDA;
                                                $SIM_DM1['WK_REKAM'] = date('Y-m-d H:i:s');
                                                //print_r($SIM_DM1);
                                                $this->db->insert('req_delivery_simkeu', $SIM_DM1);
                                            }
                                        }
                                    }
                                }
                                #DENDA SP2
                                $JumlahKontainerPerBL = $COUNTCONT;
                                ////echo"jum cont ".$JumlahKontainerPerBL."<br>";
                                if ($JumlahKontainerPerBL > 30) {
                                    $JumlahMasaBebas = 3;
                                } else {
                                    $JumlahMasaBebas = 2;
                                }

                                $DateTimeSp21 = new DateTime($PaidThru);
                                $DateTimeSp22 = new DateTime($TglBilling);
                                $difference = $DateTimeSp21->diff($DateTimeSp22);
                                $selisih = $difference->days;
                                $GetDateDiff = $selisih;
                                $RangeDate = $GetDateDiff;
                                ////echo"Selisih SP2 > ".$RangeDate."<br>";

                                if ($RangeDate >= $JumlahMasaBebas) {
                                    $SelisihMasaBebas = $RangeDate - $JumlahMasaBebas;
                                    ////echo"SelisihMasaBebas ".$SelisihMasaBebas."<br>";
                                    $startDendaSP2 = date("Y-m-d", strtotime($TglBilling . "+" . $JumlahMasaBebas . " days"));
                                    ////echo"startDendaSp2 : ".$startDendaSP2."<br>";
                                    $SelisihDateM1Sp2 = 0;
                                    $SelisihDateM2Sp2 = 0;
                                    $SelisihDateM3Sp2 = 0;
                                    $SelisihDateM4Sp2 = 0;
                                    $DendaM1Sp2 = 0;
                                    $DendaM2Sp2 = 0;
                                    $DendaM3Sp2 = 0;
                                    $DendaM4Sp2 = 0;
                                    if ($SelisihMasaBebas >= 0) {
                                        for ($c = 0; $c <= $SelisihMasaBebas; $c++) {
                                            $checkDendaPS2Date = date("Y-m-d", strtotime($c . " days" . $startDendaSP2));
                                            ////echo$checkDendaPS2Date." - ";
                                            if ((in_array($checkDendaPS2Date, $checkDate1)) && ($selisihNHI != 0)) {
                                                $SelisihDateNHISp2 = 0;
                                                $DendaMHISp2 = $SelisihDateNHISp2 * (($Charge_sp2 * 0) * $tDendaMHISp2);
                                                ////echo$DendaMHISp2;
                                            } else {
                                                if ($checkDendaPS2Date == $MasaBebas) {
                                                    $SelisihDateM1Sp2 = 0;
                                                    $DendaM1Sp2 = $SelisihDateM1Sp2 * (($Charge_sp2 * 0) * $tDendaMHISp2);
                                                    ////echo$DendaM1Sp2;
                                                }
                                                if ($checkDendaPS2Date == $Masa1) {
                                                    $SelisihDateM2Sp2 = 1;
                                                    $DendaM2Sp2 = $SelisihDateM2Sp2 * (($Charge_sp2 * 3) * $tDendaMHISp2);
                                                    ////echo$DendaM2Sp2;
                                                }
                                                if ($checkDendaPS2Date == $Masa2) {
                                                    $SelisihDateM3Sp2 = 1;
                                                    $DendaM3Sp2 = $SelisihDateM3Sp2 * (($Charge_sp2 * 6) * $tDendaMHISp2);
                                                    ////echo$DendaM3Sp2;
                                                }
                                                if (($checkDendaPS2Date >= $Masa3) && ($checkDendaPS2Date <= $PaidThru)) {
                                                    $SelisihDateM4Sp2++;
                                                    $DendaM4Sp2 = $DendaM4Sp2 + (($Charge_sp2 * 6) * $tDendaMHISp2);
                                                    ////echo$DendaM4Sp2;
                                                }
                                            }
                                            ////echo"<br>";
                                        }
                                    }
                                    $TotalDendaSp2 = $DendaM1Sp2 + $DendaM2Sp2 + $DendaM3Sp2 + $DendaM4Sp2;
                                    if ($TotalDendaSp2 > 0) {
                                        $DENDA_SP2['ID_REQ'] = $REQ;
                                        $DENDA_SP2['NO_CONT'] = $DTL['NO_CONT'];
                                        $DENDA_SP2['UKR_CONT'] = $DTL['UKR_CONT'];
                                        $DENDA_SP2['ISO_CODE'] = $TYPE_CONT;
                                        $DENDA_SP2['STATUS'] = $DTL['STATUS'];
                                        $DENDA_SP2['TARIF_ID'] = $SQL_SP2->TARIF_ID;
                                        $DENDA_SP2['CHARGE'] = $Charge_sp2;
                                        $DENDA_SP2['TOTAL_UNIT'] = '1';
                                        $DENDA_SP2['TOTAL'] = $TotalDendaSp2;
                                        $DENDA_SP2['PROSEN_M1'] = '0';
                                        $DENDA_SP2['SELISIH_M1'] = $SelisihDateM1Sp2;
                                        $DENDA_SP2['M1_START_DATE'] = $MasaBebas;
                                        $DENDA_SP2['M1_END_DATE'] = $MasaBebas;
                                        $DENDA_SP2['TOTAL_M1'] = $DendaM1Sp2;
                                        $DENDA_SP2['PROSEN_M2'] = '3';
                                        $DENDA_SP2['SELISIH_M2'] = $SelisihDateM2Sp2;
                                        $DENDA_SP2['M2_START_DATE'] = $Masa1;
                                        $DENDA_SP2['M2_END_DATE'] = $Masa1;
                                        $DENDA_SP2['TOTAL_M2'] = $DendaM2Sp2;
                                        $DENDA_SP2['PROSEN_M3'] = '6';
                                        $DENDA_SP2['SELISIH_M3'] = $SelisihDateM3Sp2;
                                        $DENDA_SP2['M3_START_DATE'] = $Masa2;
                                        $DENDA_SP2['M3_END_DATE'] = $Masa2;
                                        $DENDA_SP2['TOTAL_M3'] = $DendaM3Sp2;
                                        $DENDA_SP2['PROSEN_M4'] = $proses_m4;
                                        $DENDA_SP2['SELISIH_M4'] = $SelisihDateM4Sp2;
                                        $DENDA_SP2['M4_START_DATE'] = $startDendaSP2;
                                        $DENDA_SP2['M4_END_DATE'] = $PaidThru;
                                        $DENDA_SP2['TOTAL_M4'] = $DendaM4Sp2;
                                        $DENDA_SP2['WK_REKAM'] = date('Y-m-d H:i:s');
                                        $this->db->insert('req_delivery_dtl', $DENDA_SP2);
                                        $GantiTglSp2['TGL_REQ_SP2'] = $PaidThru;
                                        $this->db->where(array('ID_REQ' => $REQ));
                                        $this->db->update('req_delivery_hdr', $GantiTglSp2);
                                        if ($TotalDendaSp2 > 0) {
                                            $SIM_M1SP2['ID_REQ'] = $REQ;
                                            $SIM_M1SP2['NO_CONT'] = $DTL['NO_CONT'];
                                            $SIM_M1SP2['UKR_CONT'] = $DTL['UKR_CONT'];
                                            $SIM_M1SP2['CHARGE'] = $Charge_sp2;
                                            $SIM_M1SP2['JENIS_TARIF'] = 'DENDA SP 2';
                                            $SIM_M1SP2['TOTAL'] = $TotalDendaSp2;
                                            $SIM_M1SP2['WK_REKAM'] = date('Y-m-d H:i:s');
                                            $this->db->insert('req_delivery_simkeu', $SIM_M1SP2);
                                        }
                                    }
                                }
                            }
                            #LIFT ON
                            $TARIF_ID_LO = $SQL_LO->TARIF_ID;
                            $TARIF_LO = $SQL_LO->TARIF;
                            $DATA_LO['ID_REQ'] = $REQ;
                            $DATA_LO['NO_CONT'] = $DTL['NO_CONT'];
                            $DATA_LO['UKR_CONT'] = $DTL['UKR_CONT'];
                            $DATA_LO['ISO_CODE'] = $TYPE_CONT;
                            $DATA_LO['STATUS'] = $DTL['STATUS'];
                            $DATA_LO['TARIF_ID'] = $TARIF_ID_LO;
                            $DATA_LO['CHARGE'] = $TARIF_LO;
                            $DATA_LO['TOTAL_UNIT'] = '1';
                            $DATA_LO['TOTAL'] = $TARIF_LO;
                            $DATA_LO['WK_REKAM'] = date('Y-m-d H:i:s');
                            $SIM_LOSP2['ID_REQ'] = $REQ;
                            $SIM_LOSP2['NO_CONT'] = $DTL['NO_CONT'];
                            $SIM_LOSP2['UKR_CONT'] = $DTL['UKR_CONT'];
                            $SIM_LOSP2['CHARGE'] = $TARIF_LO;
                            $SIM_LOSP2['JENIS_TARIF'] = 'LIFT ON';
                            $SIM_LOSP2['TOTAL'] = $TARIF_LO;
                            $SIM_LOSP2['WK_REKAM'] = date('Y-m-d H:i:s');
                            $this->db->insert('req_delivery_dtl', $DATA_LO);
                            $this->db->insert('req_delivery_simkeu', $SIM_LOSP2);
                        }
                    }
                }

                #ADMIN
                $TARIF_ADMIN = $SQL_ADMIN->TARIF;
                $TARIF_ADMIN_ID = $SQL_ADMIN->TARIF_ID;
                $DATA_ADM['ID_REQ'] = $REQ;
                $DATA_ADM['ISO_CODE'] = $TYPE_CONT;
                $DATA_ADM['STATUS'] = $DTL['STATUS'];
                $DATA_ADM['TARIF_ID'] = $TARIF_ADMIN_ID;
                $DATA_ADM['CHARGE'] = $TARIF_ADMIN;
                $DATA_ADM['TOTAL_UNIT'] = $JML_CONT;
                $DATA_ADM['TOTAL'] = $TARIF_ADMIN;
                $DATA_ADM['WK_REKAM'] = date('Y-m-d H:i:s');
                $this->db->insert('req_delivery_dtl', $DATA_ADM);
                $SIM_ADM['ID_REQ'] = $REQ;
                $SIM_ADM['CHARGE'] = $TARIF_ADMIN;
                $SIM_ADM['JENIS_TARIF'] = 'ADMINISTRASI';
                $SIM_ADM['TOTAL'] = $TARIF_ADMIN;
                $SIM_ADM['WK_REKAM'] = date('Y-m-d H:i:s');
                $this->db->insert('req_delivery_simkeu', $SIM_ADM);

                #TRUCK
                $TARIF_TRUCK = $SQL_TRUCK->TARIF;
                $TARIF_TRUCK_ID = $SQL_TRUCK->TARIF_ID;
                $HITUNGCONT = $TARIF_TRUCK * $JML_CONT;

                $DATA_ADM['ID_REQ'] = $REQ;
                $DATA_ADM['ISO_CODE'] = $TYPE_CONT;
                $DATA_ADM['STATUS'] = $DTL['STATUS'];
                $DATA_ADM['TARIF_ID'] = $TARIF_TRUCK_ID;
                $DATA_ADM['CHARGE'] = $TARIF_TRUCK;
                $DATA_ADM['TOTAL_UNIT'] = $JML_CONT;
                $DATA_ADM['TOTAL'] = $HITUNGCONT;
                $DATA_ADM['WK_REKAM'] = date('Y-m-d H:i:s');
                $this->db->insert('req_delivery_dtl', $DATA_ADM);
                $SIM_ADM['ID_REQ'] = $REQ;
                $SIM_ADM['CHARGE'] = $TARIF_TRUCK;
                $SIM_ADM['JENIS_TARIF'] = 'TRUCK';
                $SIM_ADM['TOTAL'] = $HITUNGCONT;
                $SIM_ADM['WK_REKAM'] = date('Y-m-d H:i:s');
                $this->db->insert('req_delivery_simkeu', $SIM_ADM);

                //TAIF RECOVERY
                $SQL_COST = $this->db->query("SELECT * FROM $mtarif WHERE STATUS = 'COST'")->row();

                if ($kapalsandar == 1) {
                    $COST = 0;
                    $JUMLAH_COST = 0;
                } else {
                    $TARIF_COST = $SQL_COST->TARIF;
                    $TARIF_COST_ID = $SQL_COST->TARIF_ID;
                    $HITUNGCONT = $TARIF_COST * $JML_CONT;

                    $DATA_ADM['ID_REQ'] = $REQ;
                    $DATA_ADM['ISO_CODE'] = $TYPE_CONT;
                    $DATA_ADM['STATUS'] = $DTL['STATUS'];
                    $DATA_ADM['TARIF_ID'] = $TARIF_COST_ID;
                    $DATA_ADM['CHARGE'] = $TARIF_COST;
                    $DATA_ADM['TOTAL_UNIT'] = $JML_CONT;
                    $DATA_ADM['TOTAL'] = $HITUNGCONT;
                    $DATA_ADM['WK_REKAM'] = date('Y-m-d H:i:s');
                    $this->db->insert('req_delivery_dtl', $DATA_ADM);
                    $SIM_ADM['ID_REQ'] = $REQ;
                    $SIM_ADM['CHARGE'] = $TARIF_COST;
                    $SIM_ADM['JENIS_TARIF'] = 'COST RECOVERY';
                    $SIM_ADM['TOTAL'] = $HITUNGCONT;
                    $SIM_ADM['WK_REKAM'] = date('Y-m-d H:i:s');
                    $this->db->insert('req_delivery_simkeu', $SIM_ADM);

                    $COST = $SQL_COST->TARIF;
                    $JUMLAH_COST = $COST * $JML_CONT;
                }

                //EDITBILLING CG
                $sub_total = $this->db->query("SELECT SUM(TOTAL) AS TOTAL FROM req_delivery_dtl WHERE ID_REQ = '$REQ'")->row()->TOTAL;

                $PPN = $sub_total * 0.11;
                $sub_totalBM = $sub_total + $PPN;
                if ($sub_totalBM > 5000000) {
                    $MAT = 10000;
                } else {
                    $MAT = 0;
                }
                $TOTAL_ALL = $MAT + $sub_total + $PPN;

                $DATA_HDR_UP['BIAYA_MATERAI'] = $MAT;
                $DATA_HDR_UP['SUBTOTAL'] = $sub_total;
                $DATA_HDR_UP['PPN'] = $PPN;
                $DATA_HDR_UP['COST'] = $JUMLAH_COST;
                $DATA_HDR_UP['TOTAL'] = $TOTAL_ALL;
                $DATA_HDR_UP['TGL_STACK'] = $cek;
                $this->db->where(array('ID_REQ' => $REQ));
                $this->db->update('req_delivery_hdr', $DATA_HDR_UP);

                $SIM_MAT['ID_REQ'] = $REQ;
                $SIM_MAT['CHARGE'] = $MAT;
                $SIM_MAT['JENIS_TARIF'] = 'MATERAI DEL';
                $SIM_MAT['TOTAL'] = $MAT;
                $SIM_MAT['WK_REKAM'] = date('Y-m-d H:i:s');
                $this->db->insert('req_delivery_simkeu', $SIM_MAT);

                if ($error == 0) {
                    return $this->httpres(200, 'success', $REQ, '');
                    //////echo"MSG#OK#Data berhasil diproses#".site_url()."/billingDelivery/delivery/post";
                } else {
                    return $this->httpres(200, 'error', '', 'Terjadi Error');
                    //////echo"MSG#ERR#".$message."#";
                }
            } else if ($act == "update") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "") {
                        unset($DATA[$a]);
                    } else {
                        $DATA[$a] = strtoupper(trim($b));
                    }

                }

                $id = $dataid;
                $DATAN['NPWP'] = $DATA['NPWP'];
                $DATAN['EXPIRED'] = $DATA['EXPIRED'];
                $DATAN['NM_KAPAL'] = $DATA['NM_KAPAL'];
                $DATAN['NO_DOK'] = $DATA['NO_DOK'];
                $DATAN['NO_DO'] = $DATA['NO_DO'];
                $DATAN['NO_VOY'] = $DATA['NO_VOY'];
                $DATAN['TGL_DOK'] = $DATA['TGL_DOK'];

                $this->db->where(array('ID_REQ' => $id));
                $result = $this->db->update('req_delivery_hdr', $DATAN);

                if ($error == 0) {
                    $action = '/billingDelivery/delivery/post';
                    ////echo"MSG#OK#Data berhasil diproses#".site_url().$action;
                } else {
                    ////echo"MSG#ERR#".$message."#";
                }
            }
            if ($custom_refer == 'on' && $custom_unplug != '') {
                foreach (explode(',', $cont_post_c) as $key1 => $valuerfr1) {
                    $exprefr = explode('~', $valuerfr1);
                    $exprefrtemp = $exprefr[1];
                    $ref11 = $this->db->query("select id,no_Cont,waktu,waktu_end from t_op_reefer where no_cont = '$exprefrtemp' and waktu is not null order by id desc limit 1")->row();
                    if ($ref11 != null) {
                        $this->db->set('waktu_end', null);
                        $this->db->set('fl_unplug', 'N');
                        $this->db->set('operator_end', null);
                        $this->db->where('id', $ref11->id);
                        $this->db->update('t_op_reefer');
                    }
                }
            }
        } catch (Exception $e) {
            $this->httpres(200, 'error', '', $e->getMessage());
        }

    }

    public function billingextdelivery()
    {

        try {
            $DATAR = $this->input->post('DATA');
            $no_dok = $DATAR['NO_DOK'];
            $arrnocont = $this->input->post('arrnocont');
            $arrnocont = explode(',', $arrnocont);
            $arrnocont2 = '';
            foreach ($arrnocont as $k => $vl) {
                if ($k == 0) {
                    $arrnocont2 .= "'" . $vl . "'";
                } else {
                    $arrnocont2 .= ",'" . $vl . "'";
                }
            }
            $buatcont = $this->db->query("SELECT A.ID , A.NO_CONT ,C.ID ID2,C.UKR_CONT ,C.TIPE_CONT ,C.KD_CONT_JENIS ,C.FL_DG
		from t_permit_cont A
		inner join t_permit_hdr B on A.ID = B.ID
		inner join t_request_cont C on A.NO_CONT = C.NO_CONT and C.KD_STATUS = 'INQUIRY'
		where A.KD_STATUS_BIL is not null and B.NO_DOK_INOUT = '$no_dok' and A.NO_CONT in ($arrnocont2)
		group by C.NO_CONT")->result();

            $DATAPOST = array();
            $dt = array();
            $dtcontpost = '';
            $chkcont = array();
            $dataid = '';
            $custom_refer = 'off';
            $idreqolc = '';
            $no_doc = '';
            $no_blc = '';
            if ($buatcont) {
                foreach ($buatcont as $key => $value) {
                    if ($value->KD_CONT_JENIS == 'F') {
                        $vkdj = 'FULL';
                    } else {
                        $vkdj = 'EMPTY';
                    }
                    $dt['DTL_' . $value->NO_CONT]['NO_CONT'] = $value->NO_CONT;
                    $dt['DTL_' . $value->NO_CONT]['UKR_CONT'] = $value->UKR_CONT;
                    $dt['DTL_' . $value->NO_CONT]['TYPE'] = $value->TIPE_CONT;
                    $dt['DTL_' . $value->NO_CONT]['STATUS'] = $vkdj;
                    $dt['DTL_' . $value->NO_CONT]['DG'] = $value->FL_DG;
                    if ($dtcontpost == '') {
                        $dtcontpost = $value->ID2 . '~' . $value->NO_CONT;
                    } else {
                        $dtcontpost .= ',' . $value->ID2 . '~' . $value->NO_CONT;
                    }
                    $chkcont[$key] = $value->ID2 . '~' . $value->NO_CONT;
                    if ($value->TIPE_CONT == 'RFR') {
                        $custom_refer = 'on';
                    }
                    $dataid = $value->ID;
                }
            } else {
                return $this->httpres(200, 'error', '', 'Data Tidak Di Temukan');
            }

            //echo json_encode($dt);die();
            $idreqoldss = $this->db->query("SELECT DISTINCT A.ID_REQ,A.NM_KAPAL ,A.NO_VOY ,A.NO_DO ,A.NO_BL , A.NO_NOTA_DELIVERY FROM req_delivery_hdr A
        LEFT JOIN m_pelanggan B ON A.NPWP = B.NPWP
        WHERE A.NO_NOTA_DELIVERY > 0 AND A.FL_ID_REQ_OLD ='N' and A.NO_DOK = '$no_dok' limit 1")->row();

            if ($idreqoldss) {
                $idreqolc = $idreqoldss->ID_REQ;
                $notaoldc = $idreqoldss->NO_NOTA_DELIVERY;
                $no_doc = $idreqoldss->NO_DO;
                $no_blc = $idreqoldss->NO_BL;
            } else {
                return $this->httpres(200, 'error', '', 'Data ID lama Tidak Di Temukan');
            }
            $cont_post_c = $dtcontpost;

            // $DATAPOST['chk_cont'] =  $chkcont;
            // $DATAPOST['DTL'] =  $dt;
            // $DATAPOST['cont_post'] =  $cont_post_c;

            $act = 'save';
            $id = '';

            $custom_unplug = $this->input->post('unplugrefer1');
            $datacusrefere = $this->input->post('DATA');
            if ($custom_refer == 'on' && $custom_unplug != '') {
                foreach (explode(',', $cont_post_c) as $key1 => $valuerfr1) {
                    $exprefr = explode('~', $valuerfr1);
                    $exprefrtemp = $exprefr[1];
                    $ref11 = $this->db->query("select id,no_Cont,waktu,waktu_end from t_op_reefer where no_cont = '$exprefrtemp' and waktu is not null")->row();
                    if ($ref11 != null) {
                        $this->db->set('waktu_end', $custom_unplug);
                        $this->db->set('fl_unplug', 'Y');
                        $this->db->set('operator_end', 'admin2');
                        $this->db->where('id', $ref11->id);
                        $this->db->update('t_op_reefer');
                    }
                }
                $PaidThruReferc = date('Y-m-d', strtotime($custom_unplug));
            } else {
                $PaidThruReferc = date('Y-m-d', strtotime($datacusrefere['PAIDTHRU']));
            }
            $error = 0;
            if ($act == "save") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "") {
                        unset($DATA[$a]);
                    } else {
                        $DATA[$a] = strtoupper(trim($b));
                    }

                }

                $SEQ = $this->db->query("SELECT MAX(id) AS 'urut' FROM req_delivery_hdr")->row()->urut;
                $NO_URT = $SEQ + 1;
                $REQ = "EXT/" . date('Y-m-d') . "/" . $NO_URT;
                $DATA_HDR['ID_REQ'] = $REQ;
                $DATA_HDR['TGL_REQ'] = date('Y-m-d H:i:s');
                $DATA_HDR['JNS_DOK'] = "SPPB PIB 2.0";
                $DATA_HDR['NO_DOK'] = $DATA['NO_DOK'];
                $DATA_HDR['TGL_DOK'] = $DATA['TGL_DOK'];
                $DATA_HDR['NO_DO'] = $no_doc;
                $DATA_HDR['NO_BL'] = $no_blc;
                $DATA_HDR['NO_VOY'] = $DATA['VOYAGE'];
                $DATA_HDR['NM_KAPAL'] = $DATA['NM_KAPAL'];
                $DATA_HDR['NPWP'] = $DATA['NPWP'];
                $DATA_HDR['ID_REQ_OLD'] = $notaoldc;
                $DATA_HDR['NO_REQUEST'] = '010.000-16.61000007';
                $DATA_HDR['OPERATOR'] = 'online';
                $DATA_HDR['EXPIRED'] = $PaidThruReferc;
                $this->db->insert('req_delivery_hdr', $DATA_HDR);

                $ID_POST = $cont_post_c;
                $ARRID_POST = explode(',', $ID_POST);
                $JML_CONT = count($ARRID_POST);

                $nmkpl = $DATA_HDR['NM_KAPAL'];
                $novy = $DATA_HDR['NO_VOY'];
                $kapalsandar = $this->db->query("SELECT * from t_cocostshdr where date(TGL_TIBA) >= date('2021-04-15') and NM_ANGKUT = '$nmkpl' and NO_VOY_FLIGHT = '$novy'")->num_rows();
                if ($kapalsandar == 1) {
                    $mtarif = 'm_tarif2';
                    $tDendaMHISp2 = 2;
                    $proses_m4 = '6';
                    $tnhi = 1.5;
                    $tjmlmasabebas1 = 4;
                    $tjmlmasabebas2 = 3;
                    $tpenumpukanmasa3 = 6;
                } else {
                    $mtarif = 'm_tarif';
                    $tDendaMHISp2 = 3;
                    $proses_m4 = '9';
                    $tnhi = 2;
                    $tjmlmasabebas1 = 3;
                    $tjmlmasabebas2 = 2;
                    $tpenumpukanmasa3 = 9;
                }

                for ($x = 0; $x < $JML_CONT; $x++) {
                    $arrid_val = explode('~', $ARRID_POST[$x]);
                    foreach ($dt['DTL_' . $arrid_val[1]] as $a => $b) {
                        if ($b == "") {
                            unset($DTL[$a]);
                        } else {
                            $DTL[$a] = strtoupper(trim($b));
                        }

                    }

                    $NO_CONT = $DTL['NO_CONT'];
                    $SIZE = $DTL['UKR_CONT'];
                    $TYPE = $DTL['TYPE'];
                    $STATUS = $DTL['STATUS'];
                    $FL_DG = $DTL['DG'];
                    $StartNHI = $DATA['TGL_NHI'];
                    $EndNHI = $DATA['TGL_BK_SEGEL'];
                    $IDREQ = $idreqolc;
                    $NO_DOK = $DATA['NO_DOK'];
                    $IdReqOld = $idreqolc;

                    if ($TYPE == 'RFR') {

                        $SQL = $this->db->query("SELECT * FROM $mtarif WHERE SIZE = '$SIZE' AND TYPE ='$TYPE' AND STATUS =  '$STATUS'")->row();

                        // Tarif Reefer
                        $SQL_P_REEFER = $this->db->query("SELECT * FROM $mtarif WHERE SIZE = '$SIZE' AND TYPE ='$TYPE' AND STATUS =  '$STATUS' AND JENIS_BIAYA = 'PLUGIN REEFER'")->row();
                        $SQL_M_REEFER = $this->db->query("SELECT * FROM $mtarif WHERE SIZE = '$SIZE' AND TYPE ='$TYPE' AND STATUS =  '$STATUS' AND JENIS_BIAYA = 'MONITORING'")->row();

                        // jika OVD maka tampilkan biaya OVD jika tidak tampilkan berdasarkan tarif status dan size kontainer LIFT ON
                        if ($TYPE == 'OVD') {
                            $SQL_LO = $this->db->query("SELECT * FROM $mtarif WHERE SIZE = '$SIZE' AND TYPE ='$TYPE' AND JENIS_BIAYA = 'LIFT ON'")->row();
                        } else {
                            $SQL_LO = $this->db->query("SELECT * FROM $mtarif WHERE SIZE = '$SIZE' AND STATUS =  '$STATUS' AND JENIS_BIAYA = 'LIFT ON'")->row();
                        }

                        $SQL_SP2 = $this->db->query("SELECT * FROM $mtarif WHERE SIZE = '$SIZE' AND TYPE ='$TYPE' AND STATUS =  '$STATUS' AND JENIS_BIAYA='SP2'")->row();
                        $SQL_PAID = $this->db->query("SELECT EXPIRED AS PAID FROM req_delivery_hdr WHERE ID_REQ = '$IDREQ'")->row()->PAID;
                        $SQL_STACK = $this->db->query("SELECT DISTINCT M1_START_DATE AS FIRSTACK FROM req_delivery_dtl WHERE ID_REQ = '$IDREQ' AND M1_START_DATE IS NOT NULL")->row()->FIRSTACK;
                        $TGL_BONGKAR = $this->db->query("SELECT DISTINCT TGL_STACK AS TGL_BONGKAR FROM req_delivery_HDR WHERE ID_REQ = '$IDREQ' AND TGL_STACK IS NOT NULL")->row()->TGL_BONGKAR;
                        $COUNT_CONT = $this->db->query("SELECT COUNT(A.NO_CONT) AS 'NO_CONT' FROM t_permit_cont A, t_permit_hdr C WHERE C.ID = A.ID AND C.NO_DOK_INOUT ='$NO_DOK'")->row();
                        $SQL_BILLING = $this->db->query("SELECT DISTINCT IFNULL(TGL_REQ_SP2,TGL_REQ) AS 'SQL_BILLING' FROM req_delivery_hdr WHERE ID_REQ = '$IDREQ'")->row()->SQL_BILLING;
                        $CekBilling = $this->db->query("SELECT DISTINCT TGL_REQ_SP2 AS 'CEK_SQL_BILLING' FROM req_delivery_hdr WHERE ID_REQ = '$IDREQ'")->row()->CEK_SQL_BILLING;
                        $SQL_ADMIN = $this->db->query("SELECT * FROM $mtarif WHERE JENIS_BIAYA = 'ADMIN'")->row();
                        $SQL_PLUG = $this->db->query("SELECT * FROM $mtarif WHERE SIZE = '$SIZE' AND TYPE ='$TYPE' AND JENIS_BIAYA='PLUGIN REEFER'")->row();
                        // Cari biaya Monitoring
                        $SQL_MONITOR = $this->db->query("SELECT * FROM $mtarif WHERE SIZE = '$SIZE' AND TYPE ='$TYPE' AND JENIS_BIAYA='MONITORING'")->row();
                        // Cari PLUG and UNPLUGIN
                        $MONITOR_PLUG = $this->db->query("SELECT C.PLUG_TERMINAL AS 'WAKTU', D.WAKTU_END FROM t_permit_hdr A INNER JOIN t_permit_cont B ON A.ID = B.ID INNER JOIN t_request_cont C ON B.NO_CONT = C.NO_CONT INNER JOIN t_op_reefer D ON B.NO_CONT = D.NO_CONT
					WHERE B.NO_CONT='$NO_CONT' AND A.NO_DOK_INOUT='$NO_DOK' AND C.PLUG_TERMINAL IS NOT NULL GROUP BY B.NO_CONT ASC")->row();

                        $MONITOR_PLUG2 = $this->db->query("SELECT PLUG_START_DATE,PLUG_END_DATE FROM req_delivery_dtl WHERE id_req = '$IdReqOld' AND no_cont = '$NO_CONT' AND PLUG_END_DATE IS NOT null")->row();
                        // $MONITOR_PLUG = $this->db->query("SELECT C.PLUG_TERMINAL AS 'WAKTU' FROM t_permit_hdr A INNER JOIN t_permit_cont B ON A.ID = B.ID INNER JOIN t_request_cont C ON B.NO_CONT = C.NO_CONT INNER JOIN t_op_reefer D ON B.NO_CONT = D.NO_CONT
                        // WHERE B.NO_CONT='$NO_CONT' AND A.NO_DOK_INOUT='$NO_DOK' AND C.PLUG_TERMINAL IS NOT NULL GROUP BY B.NO_CONT ASC")->row();
                        $SQL_TRUCK = $this->db->query("SELECT * FROM $mtarif WHERE JENIS_BIAYA = 'TRUCK'")->row();

                        //     // Tampung data ke variable

                        // Tarif dasar
                        $MAX_ID = $SQL_MAX;
                        $cek = $WK_IN; // Stacking Kontainer di terminal
                        $COUNTCONT = $COUNT_CONT->NO_CONT; // Hitung berapa banyak kontainer
                        $TARIF_HARGA = $SQL->TARIF;
                        $TARIF_ID = $SQL->TARIF_ID;
                        $PaidThruOld = $SQL_PAID;

                        if ($SQL_STACK != '') {
                            $FirstStack = date('Y-m-d', strtotime($SQL_STACK));
                        } else {
                            $FirstStack = date('Y-m-d', strtotime($PaidThruOld));
                        }

                        $PaidThru = $PaidThruReferc;
                        $COUNTCONT = $COUNT_CONT->NO_CONT;
                        $TglSp2 = date("Y-m-d", strtotime($SQL_BILLING));
                        $WK_PLUG = date('Y-m-d H:i:s', strtotime($MONITOR_PLUG2->PLUG_END_DATE));
                        $WK_UNPLUG = date('Y-m-d H:i:s', strtotime($custom_unplug));
                        $TARIF_PLUG = $SQL_PLUG->TARIF;
                        $TARIF_MONITOR = $SQL_MONITOR->TARIF;
                        $CEKPLUG = $MONITOR_PLUG2->PLUG_END_DATE;
                        $CEKUNPLUG = $custom_unplug;
                        // //echo'TARIF_HARGA = '.$TARIF_HARGA."<br>";
                        // //echo'TARIF_ID = '.$TARIF_ID."<br>";
                        // //echo'PaidThruOld = '.$PaidThruOld."<br>";
                        // //echo'FirstStack = '.$FirstStack."<br>";
                        // //echo'PaidThru = '.$PaidThru."<br>";
                        // //echo'COUNTCONT = '.$COUNTCONT."<br>";
                        // //echo'TglSp2 = '.$TglSp2."<br>";
                        // //echo'WK_PLUG = '.$WK_PLUG."<br>";
                        // //echo'WK_UNPLUG = '.$WK_UNPLUG."<br>";
                        // //echo'TARIF_PLUG = '.$TARIF_PLUG."<br>";
                        // //echo'TARIF_MONITOR = '.$TARIF_MONITOR."<br>";
                        // //echo'CEKPLUG = '.$CEKPLUG."<br>";
                        // //echo'CEKUNPLUG = '.$CEKUNPLUG."<br>";
                        if ($FL_DG == '') {
                            $TARIF_PLUG = $SQL_PLUG->TARIF;
                            $TARIF_MONITOR = $SQL_MONITOR->TARIF;
                        } else if ($FL_DG == 'DG') { // Jika FL_DG ada maka
                            $TARIF_PLUG = $SQL_PLUG->TARIF * 2;
                            $TARIF_MONITOR = $SQL_MONITOR->TARIF * 2;
                        }

                        if ($FL_DG == '') {
                            $Charge = $TARIF_HARGA;
                            $TYPE_CONT = $DTL['TYPE'];
                            $Charge_sp2 = $SQL_SP2->TARIF;
                        } else if ($FL_DG == 'DG') {
                            $Charge = ($TARIF_HARGA * 2);
                            $TYPE_CONT = $DTL['DG'];
                            $Charge_sp2 = ($SQL_SP2->TARIF * 2);
                        } else {
                            $Charge = ($TARIF_HARGA * 3);
                            $TYPE_CONT = $DTL['DG'];
                            $Charge_sp2 = ($SQL_SP2->TARIF * 3);
                        }
                        //echo'Charge = ' . $Charge . "<br>";
                        //echo'Charge_sp2 = ' . $Charge_sp2 . "<br>";
                        //echo'TYPE_CONT = ' . $TYPE_CONT . "<br>";
                        // die();
                        $jam = date("Hi", strtotime($FirstStack));
                        if ($jam > "1200" && $DTL['STATUS'] != "EMPTY") {
                            $MasaBebas = date("Y-m-d", strtotime($FirstStack . "+1 days"));
                        } else {
                            $MasaBebas = date("Y-m-d", strtotime($FirstStack));
                        }

                        $indexNHI = 0;
                        $SelisihNHI = 0;
                        $SelisihMasa1 = 0;
                        $SelisihMasa2 = 0;
                        $SelisihMasa3 = 0;
                        $PenumpukanNHI = 0;
                        $PenumpukanMasa1 = 0;
                        $PenumpukanMasa2 = 0;
                        $PenumpukanMasa3 = 0;
                        $pluginReefer = 0;
                        $monitoringReefer = 0;

                        if ($STATUS == 'EMPTY') {
                            $Masa1 = date("Y-m-d", strtotime($MasaBebas . "+2 days"));
                            $Masa2 = date("Y-m-d", strtotime($Masa1 . "+7 days"));
                            $Masa3 = date("Y-m-d", strtotime($Masa2 . "+1 days"));

                            //echo"Masa Bebas     > " . $MasaBebas . "<br>";
                            //echo"Masa 1         > " . $Masa1 . "<br>";
                            //echo"Masa 2         > " . $Masa2 . "<br>";
                            //echo"Masa 3         > " . $Masa3 . "<br>";
                            //echo"Masa Paid        > " . $PaidThru . "<br>";
                            //echo"Masa Paid Old    > " . $PaidThruOld . "<br>";

                            $DateTime1 = new DateTime($MasaBebas);
                            $DateTime2 = new DateTime($PaidThru);
                            $difference = $DateTime1->diff($DateTime2);
                            $selisihDiff = $difference->days;
                            $selisih = $selisihDiff;
                            //echo"Selisih Paid > " . $selisih . "<br>";

                            for ($i = 0; $i <= $selisih; $i++) {
                                $checkDate = date("Y-m-d", strtotime($i . " days" . $MasaBebas));
                                //echo$checkDate . " - ";
                                if (($checkDate <= $Masa1) && ($checkDate > $PaidThruOld)) {
                                    $SelisihMasa1++;
                                    $PenumpukanMasa1 = $PenumpukanMasa1 + ($Charge * 0);
                                    //echo'PenumpukanMasa1 = ' . $PenumpukanMasa1 . "<br>";
                                }
                                if (($checkDate > $Masa1) && ($checkDate <= $Masa2) && ($checkDate > $PaidThruOld)) {
                                    $SelisihMasa2++;
                                    $PenumpukanMasa2 = $PenumpukanMasa2 + ($Charge * 2);
                                    //echo'PenumpukanMasa2 = ' . $PenumpukanMasa2 . "<br>";
                                    if ($PaidThru >= $Masa2) {
                                        $EndDateMasa2 = $Masa2;
                                    } else {
                                        $EndDateMasa2 = $PaidThru;
                                    }
                                }
                                if (($checkDate >= $Masa3) && ($checkDate <= $PaidThru) && ($checkDate > $PaidThruOld)) {
                                    $SelisihMasa3++;
                                    $PenumpukanMasa3 = $PenumpukanMasa3 + ($Charge * 3);
                                    //echo'PenumpukanMasa3 = ' . $PenumpukanMasa3 . "<br>";
                                }
                                //echo"<br>";
                            }
                            $Total = $PenumpukanMasa1 + $PenumpukanMasa2 + $PenumpukanMasa3;
                            if ($Total > 0) {
                                $DETAIL['ID_REQ'] = $REQ;
                                $DETAIL['NO_CONT'] = $DTL['NO_CONT'];
                                $DETAIL['UKR_CONT'] = $DTL['UKR_CONT'];
                                $DETAIL['ISO_CODE'] = $TYPE_CONT;
                                $DETAIL['STATUS'] = $DTL['STATUS'];
                                $DETAIL['TARIF_ID'] = $TARIF_ID;
                                $DETAIL['CHARGE'] = $Charge;
                                $DETAIL['TOTAL_UNIT'] = '1';
                                $DETAIL['TOTAL'] = $Total;
                                $DETAIL['PROSEN_M1'] = '0';
                                $DETAIL['SELISIH_M1'] = '0';
                                $DETAIL['M1_START_DATE'] = null;
                                $DETAIL['M1_END_DATE'] = null;
                                $DETAIL['TOTAL_M1'] = '0';
                                $DETAIL['PROSEN_M2'] = '0';
                                $DETAIL['SELISIH_M2'] = '0';
                                $DETAIL['M2_START_DATE'] = null;
                                $DETAIL['M2_END_DATE'] = null;
                                $DETAIL['TOTAL_M2'] = $PenumpukanMasa1;
                                $DETAIL['PROSEN_M3'] = '2';
                                $DETAIL['SELISIH_M3'] = $SelisihMasa2;
                                $DETAIL['M3_START_DATE'] = date("Y-m-d", strtotime($Masa1 . "+1 days"));
                                $DETAIL['M3_END_DATE'] = $EndDateMasa2;
                                $DETAIL['TOTAL_M3'] = $PenumpukanMasa2;
                                $DETAIL['PROSEN_M4'] = '3';
                                $DETAIL['SELISIH_M4'] = $SelisihMasa3;
                                $DETAIL['M4_START_DATE'] = date("Y-m-d", strtotime($PaidThruOld . "+1 days"));
                                $DETAIL['M4_END_DATE'] = $PaidThru;
                                $DETAIL['TOTAL_M4'] = $PenumpukanMasa3;
                                $DETAIL['WK_REKAM'] = date('Y-m-d H:i:s');
                                $DETAIL['FL_DG'] = $DTL['DG'];
                                $this->db->insert('req_delivery_dtl', $DETAIL);
                                if ($PenumpukanMasa1 > 0) {
                                    $SIM_M1['ID_REQ'] = $REQ;
                                    $SIM_M1['NO_CONT'] = $DTL['NO_CONT'];
                                    $SIM_M1['UKR_CONT'] = $DTL['UKR_CONT'];
                                    $SIM_M1['CHARGE'] = $Charge;
                                    $SIM_M1['JENIS_TARIF'] = 'PENUMPUKAN 1';
                                    $SIM_M1['TOTAL'] = $PenumpukanMasa1;
                                    $SIM_M1['WK_REKAM'] = date('Y-m-d H:i:s');
                                    $this->db->insert('req_delivery_simkeu', $SIM_M1);
                                }
                                if ($PenumpukanMasa2 > 0) {
                                    $SIM_M2['ID_REQ'] = $REQ;
                                    $SIM_M2['NO_CONT'] = $DTL['NO_CONT'];
                                    $SIM_M2['UKR_CONT'] = $DTL['UKR_CONT'];
                                    $SIM_M2['CHARGE'] = $Charge;
                                    $SIM_M2['JENIS_TARIF'] = 'PENUMPUKAN 1.1';
                                    $SIM_M2['TOTAL'] = $PenumpukanMasa2;
                                    $SIM_M2['WK_REKAM'] = date('Y-m-d H:i:s');
                                    $this->db->insert('req_delivery_simkeu', $SIM_M2);
                                }
                                if ($PenumpukanMasa3 > 0) {
                                    $SIM_M3['ID_REQ'] = $REQ;
                                    $SIM_M3['NO_CONT'] = $DTL['NO_CONT'];
                                    $SIM_M3['UKR_CONT'] = $DTL['UKR_CONT'];
                                    $SIM_M3['CHARGE'] = $Charge;
                                    $SIM_M3['JENIS_TARIF'] = 'PENUMPUKAN 2';
                                    $SIM_M3['TOTAL'] = $PenumpukanMasa3;
                                    $SIM_M3['WK_REKAM'] = date('Y-m-d H:i:s');
                                    $this->db->insert('req_delivery_simkeu', $SIM_M3);
                                }
                            }
                        } else {
                            $Masa1 = date("Y-m-d", strtotime($MasaBebas . "+1 days"));
                            $Masa2 = date("Y-m-d", strtotime($Masa1 . "+1 days"));
                            $Masa3 = date("Y-m-d", strtotime($Masa2 . "+1 days"));

                            //echo"Masa Bebas     > " . $MasaBebas . "<br>";
                            //echo"Masa 1         > " . $Masa1 . "<br>";
                            //echo"Masa 2         > " . $Masa2 . "<br>";
                            //echo"Masa 3         > " . $Masa3 . "<br>";
                            //echo"Masa Paid        > " . $PaidThru . "<br>";
                            //echo"Masa PaidOld    > " . $PaidThruOld . "<br>";
                            //echo"Masa NHI        > " . $StartNHI . "<br>";
                            //echo"Masa END NHI    > " . $EndNHI . "<br>";

                            $DateTime1 = new DateTime($MasaBebas);
                            $DateTime2 = new DateTime($PaidThru);
                            $difference = $DateTime1->diff($DateTime2);
                            $selisihDiff = $difference->days;
                            $selisih = $selisihDiff;
                            //echo"Selisih Paid > " . $selisih . "<br>";

                            $DateTime3 = new DateTime($StartNHI);
                            $DateTime4 = new DateTime($EndNHI);
                            $difference = $DateTime3->diff($DateTime4);
                            $selisihDiff = $difference->days;
                            $selisihNHI = $selisihDiff;
                            ////echo"Selisih NHI > ".$selisihNHI."<br>";

                            for ($i = 0; $i <= $selisihNHI; $i++) {
                                $checkDate1[] = date("Y-m-d", strtotime($i . " days" . $StartNHI));
                            }
                            $PenumpukanMasaBebas = 0;
                            $SelisihMasaBebas = 0;
                            for ($j = 0; $j <= $selisih; $j++) {
                                $checkDate = date("Y-m-d", strtotime($j . " days" . $MasaBebas));
                                //echo'$checkDate =' . $checkDate . "<br>";
                                if ((in_array($checkDate, $checkDate1)) && ($selisihNHI != 0)) {
                                    if ($checkDate > $PaidThruOld) {
                                        $PenumpukanNHI = $PenumpukanNHI + ($Charge * 0);
                                        //echo'PenumpukanNHI = ' . $PenumpukanNHI . "<br>";
                                    }
                                } else {
                                    if (($checkDate <= $MasaBebas) && ($checkDate > $PaidThruOld)) {
                                        $SelisihMasaBebas = 0;
                                        $PenumpukanMasaBebas = $SelisihMasaBebas * ($Charge * 0);
                                        //echo'PenumpukanMasaBebas = ' . $PenumpukanMasaBebas . "<br>";
                                    }
                                    if (($checkDate <= $Masa1) && ($checkDate > $PaidThruOld)) {
                                        $SelisihMasa1 = 1;
                                        $PenumpukanMasa1 = $SelisihMasa1 * ($Charge * 3);
                                        //echo'PenumpukanMasa1 = ' . $PenumpukanMasa1 . "<br>";
                                    }
                                    if (($checkDate <= $Masa2) && ($checkDate > $PaidThruOld)) {
                                        $SelisihMasa2 = 1;
                                        $PenumpukanMasa2 = $SelisihMasa2 * ($Charge * 6);
                                        //echo'PenumpukanMasa2 = ' . $PenumpukanMasa2 . "<br>";
                                    }
                                    if (($checkDate >= $Masa3) && ($checkDate <= $PaidThru) && ($checkDate > $PaidThruOld)) {
                                        $SelisihMasa3++;
                                        $PenumpukanMasa3 = $PenumpukanMasa3 + ($Charge * $tpenumpukanmasa3);
                                        //echo'PenumpukanMasa3 = ' . $PenumpukanMasa3 . "<br>";
                                    }
                                }
                                //echo"<br>";
                            }

                            // Biaya Monitoring
                            $startPlug = strtotime($WK_PLUG);
                            $endPlug = strtotime($WK_UNPLUG);
                            $selisihPlug = ($endPlug - $startPlug) * 3;
                            $jamPlug = $endPlug - $startPlug;
                            $hitungJam = ceil($jamPlug / (60 * 60));
                            //echo"startPlug = " . $startPlug . "<br>";
                            //echo"endPlug = " . $endPlug . "<br>";
                            //echo"selisihPlug = " . $selisihPlug . "<br>";
                            //echo"jamPlug = " . $jamPlug . "<br>";
                            //echo"SELISIH JAM : " . $hitungJam . "<br>";

                            $kontainer = count($NO_CONT);
                            $hitungSelisih = ceil($selisihPlug / (60 * 60 * 24));
                            $monitoringReefer = $hitungSelisih * $kontainer * $TARIF_MONITOR;
                            //echo"SELISIH PLUG : " . $hitungSelisih;
                            //echo"Rp. " . $monitoringReefer . "<br>";

                            // Biaya Plug
                            $startPlug = strtotime($WK_PLUG);
                            $endPlug = strtotime($WK_UNPLUG);
                            $selisihPlug = ($endPlug - $startPlug) * 3;
                            $hitungSelisih = ceil($selisihPlug / (60 * 60 * 24));
                            $kontainer = count($NO_CONT);
                            $pluginReefer = $hitungSelisih * $kontainer * $TARIF_PLUG;
                            //echo"startPlug  = " . $startPlug . "<br>";
                            //echo"endPlug  = " . $endPlug . "<br>";
                            //echo"selisihPlug  = " . $selisihPlug . "<br>";
                            //echo"hitungSelisih  = " . $hitungSelisih . "<br>";
                            //echo"kontainer  = " . $kontainer . "<br>";
                            //echo"Plugin reefer Rp. " . $pluginReefer . "<br>";

                            $Total = $PenumpukanMasaBebas + $PenumpukanNHI + $PenumpukanMasa1 + $PenumpukanMasa2 + $PenumpukanMasa3;
                            //echo"total" . $Total . "<br>";
                            //die();
                            if ($Total > 0) {
                                $DETAIL['ID_REQ'] = $REQ;
                                $DETAIL['NO_CONT'] = $DTL['NO_CONT'];
                                $DETAIL['UKR_CONT'] = $DTL['UKR_CONT'];
                                $DETAIL['ISO_CODE'] = $TYPE_CONT;
                                $DETAIL['STATUS'] = $DTL['STATUS'];
                                $DETAIL['TARIF_ID'] = $TARIF_ID;
                                $DETAIL['CHARGE'] = $Charge;
                                $DETAIL['TOTAL_UNIT'] = '1';
                                $DETAIL['TOTAL'] = $Total;
                                $DETAIL['PROSEN_M1'] = '0';
                                $DETAIL['SELISIH_M1'] = $SelisihMasaBebas;
                                $DETAIL['M1_START_DATE'] = $MasaBebas;
                                $DETAIL['M1_END_DATE'] = $MasaBebas;
                                $DETAIL['TOTAL_M1'] = $PenumpukanMasaBebas;
                                $DETAIL['PROSEN_M2'] = '3';
                                $DETAIL['SELISIH_M2'] = $SelisihMasa1;
                                $DETAIL['M2_START_DATE'] = $Masa1;
                                $DETAIL['M2_END_DATE'] = $Masa1;
                                $DETAIL['TOTAL_M2'] = $PenumpukanMasa1;
                                $DETAIL['PROSEN_M3'] = '6';
                                $DETAIL['SELISIH_M3'] = $SelisihMasa2;
                                $DETAIL['M3_START_DATE'] = $Masa2;
                                $DETAIL['M3_END_DATE'] = $Masa2;
                                $DETAIL['TOTAL_M3'] = $PenumpukanMasa2;
                                $DETAIL['PROSEN_M4'] = $proses_m4;
                                $DETAIL['SELISIH_M4'] = $SelisihMasa3;
                                $DETAIL['M4_START_DATE'] = date("Y-m-d", strtotime($PaidThruOld . "+1 days"));
                                $DETAIL['M4_END_DATE'] = $PaidThru;
                                $DETAIL['TOTAL_M4'] = $PenumpukanMasa3;
                                $DETAIL['PROSEN_NHI'] = '2';
                                $DETAIL['SELISIH_NHI'] = $selisihNHI;
                                $DETAIL['NHI_START_DATE'] = $StartNHI;
                                $DETAIL['NHI_END_DATE'] = $EndNHI;
                                $DETAIL['TOTAL_NHI4'] = $PenumpukanNHI;
                                $DETAIL['WK_REKAM'] = date('Y-m-d H:i:s');
                                $DETAIL['FL_DG'] = $DTL['DG'];
                                $this->db->insert('req_delivery_dtl', $DETAIL);
                                if ($PenumpukanMasa1 > 0) {
                                    $SIM_M1['ID_REQ'] = $REQ;
                                    $SIM_M1['NO_CONT'] = $DTL['NO_CONT'];
                                    $SIM_M1['UKR_CONT'] = $DTL['UKR_CONT'];
                                    $SIM_M1['CHARGE'] = $Charge;
                                    $SIM_M1['JENIS_TARIF'] = 'PENUMPUKAN 1';
                                    $SIM_M1['TOTAL'] = $PenumpukanMasa1;
                                    $SIM_M1['WK_REKAM'] = date('Y-m-d H:i:s');
                                    $this->db->insert('req_delivery_simkeu', $SIM_M1);
                                }
                                if ($PenumpukanMasa2 > 0) {
                                    $SIM_M2['ID_REQ'] = $REQ;
                                    $SIM_M2['NO_CONT'] = $DTL['NO_CONT'];
                                    $SIM_M2['UKR_CONT'] = $DTL['UKR_CONT'];
                                    $SIM_M2['CHARGE'] = $Charge;
                                    $SIM_M2['JENIS_TARIF'] = 'PENUMPUKAN 1.1';
                                    $SIM_M2['TOTAL'] = $PenumpukanMasa2;
                                    $SIM_M2['WK_REKAM'] = date('Y-m-d H:i:s');
                                    $this->db->insert('req_delivery_simkeu', $SIM_M2);
                                }
                                if ($PenumpukanMasa3 > 0) {
                                    $SIM_M3['ID_REQ'] = $REQ;
                                    $SIM_M3['NO_CONT'] = $DTL['NO_CONT'];
                                    $SIM_M3['UKR_CONT'] = $DTL['UKR_CONT'];
                                    $SIM_M3['CHARGE'] = $Charge;
                                    $SIM_M3['JENIS_TARIF'] = 'PENUMPUKAN 2';
                                    $SIM_M3['TOTAL'] = $PenumpukanMasa3;
                                    $SIM_M3['WK_REKAM'] = date('Y-m-d H:i:s');
                                    $this->db->insert('req_delivery_simkeu', $SIM_M3);
                                }
                                if ($PenumpukanNHI > 0) {
                                    $SIM_NHI['ID_REQ'] = $REQ;
                                    $SIM_NHI['NO_CONT'] = $DTL['NO_CONT'];
                                    $SIM_NHI['UKR_CONT'] = $DTL['UKR_CONT'];
                                    $SIM_NHI['CHARGE'] = $Charge;
                                    $SIM_NHI['JENIS_TARIF'] = 'PENUMPUKAN NHI';
                                    $SIM_NHI['TOTAL'] = $PenumpukanNHI;
                                    $SIM_NHI['WK_REKAM'] = date('Y-m-d H:i:s');
                                    //print_r($SIM_NHI);
                                    $this->db->insert('req_delivery_simkeu', $SIM_NHI);
                                }
                            }
                            #DENDA SP2
                            $JumlahKontainerPerBL = $COUNTCONT;
                            //echo"jum cont " . $JumlahKontainerPerBL . "<br>";
                            if ($JumlahKontainerPerBL > 30) {
                                $JumlahMasaBebas = 4;
                            } else {
                                $JumlahMasaBebas = 2;
                            }

                            $DateTimeSp21 = new DateTime($PaidThru);
                            $DateTimeSp22 = new DateTime($TglSp2);
                            $difference = $DateTimeSp21->diff($DateTimeSp22);
                            $selisih = $difference->days;
                            $GetDateDiff = $selisih;
                            //echo"Selisih SP2 > " . $GetDateDiff . "<br>";

                            $SelisihDateM1Sp2 = 0;
                            $SelisihDateM2Sp2 = 0;
                            $SelisihDateM3Sp2 = 0;
                            $SelisihDateM4Sp2 = 0;
                            $DendaM1Sp2 = 0;
                            $DendaM2Sp2 = 0;
                            $DendaM3Sp2 = 0;
                            $DendaM4Sp2 = 0;

                            $SelisihMasaBebas = $GetDateDiff;
                            //echo"SelisihMasaBebas " . $SelisihMasaBebas . "<br>";
                            if ($SelisihMasaBebas > 0) {
                                if ($CekBilling != 0) {
                                    $StartDenda = date("Y-m-d", strtotime($TglSp2 . "+1 days"));
                                    //echo"Tanggal SP2<br>";
                                } else {
                                    $StartDenda = date("Y-m-d", strtotime($TglSp2 . "+2 days"));
                                    //echo"Tanggal REQUEST<br>";
                                }
                                for ($i = 0; $i <= $SelisihMasaBebas; $i++) {
                                    $checkDendaPS2Date = date("Y-m-d", strtotime($i . " days" . $TglSp2));
                                    //echo$checkDendaPS2Date . "--";
                                    if ((in_array($checkDendaPS2Date, $checkDate1)) && ($selisihNHI != 0)) {
                                        $SelisihDateNHISp2 = 0;
                                        $DendaMHISp2 = $SelisihDateNHISp2 * (($Charge_sp2 * 0) * $tDendaMHISp2);
                                        //echo$DendaMHISp2;
                                    } else {
                                        if ($checkDendaPS2Date == $MasaBebas) {
                                            if ($checkDendaPS2Date >= $StartDenda) {
                                                $SelisihDateM1Sp2 = 0;
                                                $DendaM1Sp2 = $SelisihDateM1Sp2 * (($Charge_sp2 * 0) * $tDendaMHISp2);
                                                //echo$DendaM1Sp2;
                                            }
                                        }
                                        if ($checkDendaPS2Date == $Masa1) {
                                            if ($checkDendaPS2Date >= $StartDenda) {
                                                $SelisihDateM2Sp2 = 1;
                                                $DendaM2Sp2 = $SelisihDateM2Sp2 * (($Charge_sp2 * 3) * $tDendaMHISp2);
                                                //echo$DendaM2Sp2;
                                            }
                                        }
                                        if ($checkDendaPS2Date == $Masa2) {
                                            if ($checkDendaPS2Date >= $StartDenda) {
                                                $SelisihDateM3Sp2 = 1;
                                                $DendaM3Sp2 = $SelisihDateM3Sp2 * (($Charge_sp2 * 6) * $tDendaMHISp2);
                                                //echo$DendaM3Sp2;
                                            }
                                        }
                                        if (($checkDendaPS2Date >= $Masa3) && ($checkDendaPS2Date <= $PaidThru)) {
                                            if ($checkDendaPS2Date >= $StartDenda) {
                                                $SelisihDateM4Sp2++;
                                                $DendaM4Sp2 = $DendaM4Sp2 + (($Charge_sp2 * $tpenumpukanmasa3) * $tDendaMHISp2);
                                                //echo$DendaM4Sp2;
                                            }
                                        }
                                    }
                                    //echo"<br>";
                                }
                                $TotalDendaSp2 = $DendaM1Sp2 + $DendaM2Sp2 + $DendaM3Sp2 + $DendaM4Sp2;
                                if ($TotalDendaSp2 > 0) {
                                    $DENDA_SP2['ID_REQ'] = $REQ;
                                    $DENDA_SP2['NO_CONT'] = $DTL['NO_CONT'];
                                    $DENDA_SP2['UKR_CONT'] = $DTL['UKR_CONT'];
                                    $DENDA_SP2['ISO_CODE'] = $TYPE_CONT;
                                    $DENDA_SP2['STATUS'] = $DTL['STATUS'];
                                    $DENDA_SP2['TARIF_ID'] = $SQL_SP2->TARIF_ID;
                                    $DENDA_SP2['CHARGE'] = $Charge_sp2;
                                    $DENDA_SP2['TOTAL_UNIT'] = '1';
                                    $DENDA_SP2['TOTAL'] = $TotalDendaSp2;
                                    $DENDA_SP2['PROSEN_M1'] = '0';
                                    $DENDA_SP2['SELISIH_M1'] = $SelisihDateM1Sp2;
                                    $DENDA_SP2['M1_START_DATE'] = $MasaBebas;
                                    $DENDA_SP2['M1_END_DATE'] = $MasaBebas;
                                    $DENDA_SP2['TOTAL_M1'] = $DendaM1Sp2;
                                    $DENDA_SP2['PROSEN_M2'] = '3';
                                    $DENDA_SP2['SELISIH_M2'] = $SelisihDateM2Sp2;
                                    $DENDA_SP2['M2_START_DATE'] = $Masa1;
                                    $DENDA_SP2['M2_END_DATE'] = $Masa1;
                                    $DENDA_SP2['TOTAL_M2'] = $DendaM2Sp2;
                                    $DENDA_SP2['PROSEN_M3'] = '6';
                                    $DENDA_SP2['SELISIH_M3'] = $SelisihDateM3Sp2;
                                    $DENDA_SP2['M3_START_DATE'] = $Masa2;
                                    $DENDA_SP2['M3_END_DATE'] = $Masa2;
                                    $DENDA_SP2['TOTAL_M3'] = $DendaM3Sp2;
                                    $DENDA_SP2['PROSEN_M4'] = $proses_m4;
                                    $DENDA_SP2['SELISIH_M4'] = $SelisihDateM4Sp2;
                                    $DENDA_SP2['M4_START_DATE'] = $StartDenda;
                                    $DENDA_SP2['M4_END_DATE'] = $PaidThru;
                                    $DENDA_SP2['TOTAL_M4'] = $DendaM4Sp2;
                                    $DENDA_SP2['WK_REKAM'] = date('Y-m-d H:i:s');
                                    $this->db->insert('req_delivery_dtl', $DENDA_SP2);
                                    $GantiTglSp2['TGL_REQ_SP2'] = $PaidThru;
                                    $this->db->where(array('ID_REQ' => $REQ));
                                    $this->db->update('req_delivery_hdr', $GantiTglSp2);
                                    if ($TotalDendaSp2 > 0) {
                                        $SIM_M1SP2['ID_REQ'] = $REQ;
                                        $SIM_M1SP2['NO_CONT'] = $DTL['NO_CONT'];
                                        $SIM_M1SP2['UKR_CONT'] = $DTL['UKR_CONT'];
                                        $SIM_M1SP2['CHARGE'] = $Charge_sp2;
                                        $SIM_M1SP2['JENIS_TARIF'] = 'DENDA SP 2';
                                        $SIM_M1SP2['TOTAL'] = $TotalDendaSp2;
                                        $SIM_M1SP2['WK_REKAM'] = date('Y-m-d H:i:s');
                                        $this->db->insert('req_delivery_simkeu', $SIM_M1SP2);
                                    }
                                }
                            }
                        }
                        #MONITOR
                        // SQL_P_REEFER
                        $TARIF_ID_MONITOR = $SQL_M_REEFER->TARIF_ID;
                        if ($FL_DG == '') {
                            $TARIF_MONITOR = $SQL_M_REEFER->TARIF;
                        } else if ($FL_DG == 'DG') { // Jika FL_DG ada maka
                            $TARIF_MONITOR = $SQL_M_REEFER->TARIF * 2;
                        }

                        //echo'TARIF ID : ' . $TARIF_ID_MONITOR;
                        //echo'$TARIF_MONITOR : ' . $TARIF_MONITOR;
                        $DETAIL_MONITOR['ID_REQ'] = $REQ;
                        $DETAIL_MONITOR['NO_CONT'] = $DTL['NO_CONT'];
                        $DETAIL_MONITOR['UKR_CONT'] = $DTL['UKR_CONT'];
                        $DETAIL_MONITOR['ISO_CODE'] = $TYPE_CONT;
                        $DETAIL_MONITOR['STATUS'] = $DTL['STATUS'];
                        $DETAIL_MONITOR['TARIF_ID'] = $TARIF_ID_MONITOR;
                        $DETAIL_MONITOR['CHARGE'] = $TARIF_MONITOR;
                        $DETAIL_MONITOR['TOTAL_UNIT'] = '1';
                        $DETAIL_MONITOR['TOTAL'] = $monitoringReefer;
                        $DETAIL_MONITOR['PLUG_START_DATE'] = $WK_PLUG;
                        $DETAIL_MONITOR['PLUG_END_DATE'] = $WK_UNPLUG;
                        $DETAIL_MONITOR['TOTAL_JAM'] = $hitungJam;
                        $DETAIL_MONITOR['TOTAL_SHIFT'] = $hitungSelisih;
                        $DETAIL_MONITOR['WK_REKAM'] = date('Y-m-d H:i:s');

                        $SIM_DETAIL_MONITOR['ID_REQ'] = $REQ;
                        $SIM_DETAIL_MONITOR['NO_CONT'] = $DTL['NO_CONT'];
                        $SIM_DETAIL_MONITOR['UKR_CONT'] = $DTL['UKR_CONT'];
                        $SIM_DETAIL_MONITOR['CHARGE'] = $TARIF_MONITOR;
                        $SIM_DETAIL_MONITOR['JENIS_TARIF'] = 'MONITORING';
                        $SIM_DETAIL_MONITOR['TOTAL'] = $monitoringReefer;
                        $SIM_DETAIL_MONITOR['WK_REKAM'] = date('Y-m-d H:i:s');
                        $this->db->insert('req_delivery_dtl', $DETAIL_MONITOR);
                        $this->db->insert('req_delivery_simkeu', $SIM_DETAIL_MONITOR);

                        if ($FL_DG == '') {
                            $TARIF_PLUG = $SQL_P_REEFER->TARIF;
                        } else if ($FL_DG == 'DG') { // Jika FL_DG ada maka
                            $TARIF_PLUG = $SQL_P_REEFER->TARIF * 2;
                        }
                        $TARIF_ID_PLUG = $SQL_P_REEFER->TARIF_ID;

                        #PLUG
                        //echo'TARIF PLUG ID : ' . $TARIF_ID_PLUG;
                        //echo'$TARIF_PLUG : ' . $TARIF_PLUG;
                        $DETAIL_PLUG['ID_REQ'] = $REQ;
                        $DETAIL_PLUG['NO_CONT'] = $DTL['NO_CONT'];
                        $DETAIL_PLUG['UKR_CONT'] = $DTL['UKR_CONT'];
                        $DETAIL_PLUG['ISO_CODE'] = $TYPE_CONT;
                        $DETAIL_PLUG['STATUS'] = $DTL['STATUS'];
                        $DETAIL_PLUG['TARIF_ID'] = $TARIF_ID_PLUG;
                        $DETAIL_PLUG['CHARGE'] = $TARIF_PLUG;
                        $DETAIL_PLUG['TOTAL_UNIT'] = '1';
                        $DETAIL_PLUG['TOTAL'] = $pluginReefer;
                        $DETAIL_PLUG['PLUG_START_DATE'] = $WK_PLUG;
                        $DETAIL_PLUG['PLUG_END_DATE'] = $WK_UNPLUG;
                        $DETAIL_PLUG['TOTAL_JAM'] = $hitungJam;
                        $DETAIL_PLUG['TOTAL_SHIFT'] = $hitungSelisih;
                        $DETAIL_PLUG['WK_REKAM'] = date('Y-m-d H:i:s');

                        $SIM_DETAIL_PLUG['ID_REQ'] = $REQ;
                        $SIM_DETAIL_PLUG['NO_CONT'] = $DTL['NO_CONT'];
                        $SIM_DETAIL_PLUG['UKR_CONT'] = $DTL['UKR_CONT'];
                        $SIM_DETAIL_PLUG['CHARGE'] = $TARIF_PLUG;
                        $SIM_DETAIL_PLUG['JENIS_TARIF'] = 'PLUGIN REEFER';
                        $SIM_DETAIL_PLUG['TOTAL'] = $pluginReefer;
                        $SIM_DETAIL_PLUG['WK_REKAM'] = date('Y-m-d H:i:s');
                        $this->db->insert('req_delivery_dtl', $DETAIL_PLUG);
                        $this->db->insert('req_delivery_simkeu', $SIM_DETAIL_PLUG);
                    } else {
                        $SQL = $this->db->query("SELECT * FROM $mtarif WHERE SIZE = '$SIZE' AND TYPE ='$TYPE' AND STATUS =  '$STATUS'")->row();
                        $SQL_SP2 = $this->db->query("SELECT * FROM $mtarif WHERE SIZE = '$SIZE' AND TYPE ='$TYPE' AND STATUS =  '$STATUS' AND JENIS_BIAYA='SP2'")->row();
                        $SQL_PAID = $this->db->query("SELECT EXPIRED AS PAID FROM req_delivery_hdr WHERE ID_REQ = '$IDREQ'")->row()->PAID;
                        $SQL_STACK = $this->db->query("SELECT DISTINCT M1_START_DATE AS FIRSTACK FROM req_delivery_dtl WHERE ID_REQ = '$IDREQ' AND M1_START_DATE IS NOT NULL")->row()->FIRSTACK;
                        $TGL_BONGKAR = $this->db->query("SELECT DISTINCT TGL_STACK AS TGL_BONGKAR FROM req_delivery_HDR WHERE ID_REQ = '$IDREQ' AND TGL_STACK IS NOT NULL")->row()->TGL_BONGKAR;
                        $COUNT_CONT = $this->db->query("SELECT COUNT(A.NO_CONT) AS 'NO_CONT' FROM t_permit_cont A, t_permit_hdr C WHERE C.ID = A.ID AND C.NO_DOK_INOUT ='$NO_DOK'")->row();
                        $SQL_BILLING = $this->db->query("SELECT DISTINCT IFNULL(TGL_REQ_SP2,TGL_REQ) AS 'SQL_BILLING' FROM req_delivery_hdr WHERE ID_REQ = '$IDREQ'")->row()->SQL_BILLING;
                        $CekBilling = $this->db->query("SELECT DISTINCT TGL_REQ_SP2 AS 'CEK_SQL_BILLING' FROM req_delivery_hdr WHERE ID_REQ = '$IDREQ'")->row()->CEK_SQL_BILLING;
                        $SQL_ADMIN = $this->db->query("SELECT * FROM $mtarif WHERE JENIS_BIAYA = 'ADMIN'")->row();
                        $SQL_TRUCK = $this->db->query("SELECT * FROM $mtarif WHERE JENIS_BIAYA = 'TRUCK'")->row();

                        $TARIF_HARGA = $SQL->TARIF;
                        $TARIF_ID = $SQL->TARIF_ID;
                        $PaidThruOld = $SQL_PAID;
                        $FirstStack = date('Y-m-d', strtotime($SQL_STACK));
                        $PaidThru = date("Y-m-d", strtotime($DATA['PAIDTHRU']));
                        $COUNTCONT = $COUNT_CONT->NO_CONT;
                        $TglSp2 = date("Y-m-d", strtotime($SQL_BILLING));

                        if ($FL_DG == '') {
                            $Charge = $TARIF_HARGA;
                            $TYPE_CONT = $DTL['TYPE'];
                            $Charge_sp2 = $SQL_SP2->TARIF;
                        } else if ($FL_DG == 'DG') {
                            $Charge = ($TARIF_HARGA * 2);
                            $TYPE_CONT = $DTL['DG'];
                            $Charge_sp2 = ($SQL_SP2->TARIF * 2);
                        } else {
                            $Charge = ($TARIF_HARGA * 3);
                            $TYPE_CONT = $DTL['DG'];
                            $Charge_sp2 = ($SQL_SP2->TARIF * 3);
                        }

                        $jam = date("Hi", strtotime($FirstStack));
                        if ($jam > "1200" && $DTL['STATUS'] != "EMPTY") {
                            $MasaBebas = date("Y-m-d", strtotime($FirstStack . "+1 days"));
                        } else {
                            $MasaBebas = date("Y-m-d", strtotime($FirstStack));
                        }

                        $indexNHI = 0;
                        $SelisihNHI = 0;
                        $SelisihMasa1 = 0;
                        $SelisihMasa2 = 0;
                        $SelisihMasa3 = 0;
                        $PenumpukanNHI = 0;
                        $PenumpukanMasa1 = 0;
                        $PenumpukanMasa2 = 0;
                        $PenumpukanMasa3 = 0;

                        if ($STATUS == 'EMPTY') {
                            $Masa1 = date("Y-m-d", strtotime($MasaBebas . "+2 days"));
                            $Masa2 = date("Y-m-d", strtotime($Masa1 . "+7 days"));
                            $Masa3 = date("Y-m-d", strtotime($Masa2 . "+1 days"));

                            //echo"Masa Bebas     > " . $MasaBebas . "<br>";
                            //echo"Masa 1         > " . $Masa1 . "<br>";
                            //echo"Masa 2         > " . $Masa2 . "<br>";
                            //echo"Masa 3         > " . $Masa3 . "<br>";
                            //echo"Masa Paid        > " . $PaidThru . "<br>";
                            //echo"Masa Paid Old    > " . $PaidThruOld . "<br>";

                            $DateTime1 = new DateTime($MasaBebas);
                            $DateTime2 = new DateTime($PaidThru);
                            $difference = $DateTime1->diff($DateTime2);
                            $selisihDiff = $difference->days;
                            $selisih = $selisihDiff;
                            //echo"Selisih Paid > " . $selisih . "<br>";

                            for ($i = 0; $i <= $selisih; $i++) {
                                $checkDate = date("Y-m-d", strtotime($i . " days" . $MasaBebas));
                                //echo$checkDate . " - ";
                                if (($checkDate <= $Masa1) && ($checkDate > $PaidThruOld)) {
                                    $SelisihMasa1++;
                                    $PenumpukanMasa1 = $PenumpukanMasa1 + ($Charge * 0);
                                    //echo$PenumpukanMasa1;
                                }
                                if (($checkDate > $Masa1) && ($checkDate <= $Masa2) && ($checkDate > $PaidThruOld)) {
                                    $SelisihMasa2++;
                                    $PenumpukanMasa2 = $PenumpukanMasa2 + ($Charge * 2);
                                    //echo$PenumpukanMasa2;
                                    if ($PaidThru >= $Masa2) {
                                        $EndDateMasa2 = $Masa2;
                                    } else {
                                        $EndDateMasa2 = $PaidThru;
                                    }
                                }
                                if (($checkDate >= $Masa3) && ($checkDate <= $PaidThru) && ($checkDate > $PaidThruOld)) {
                                    $SelisihMasa3++;
                                    $PenumpukanMasa3 = $PenumpukanMasa3 + ($Charge * 3);
                                    //echo$PenumpukanMasa3;
                                }
                                //echo"<br>";
                            }
                            $Total = $PenumpukanMasa1 + $PenumpukanMasa2 + $PenumpukanMasa3;
                            if ($Total > 0) {
                                $DETAIL['ID_REQ'] = $REQ;
                                $DETAIL['NO_CONT'] = $DTL['NO_CONT'];
                                $DETAIL['UKR_CONT'] = $DTL['UKR_CONT'];
                                $DETAIL['ISO_CODE'] = $TYPE_CONT;
                                $DETAIL['STATUS'] = $DTL['STATUS'];
                                $DETAIL['TARIF_ID'] = $TARIF_ID;
                                $DETAIL['CHARGE'] = $Charge;
                                $DETAIL['TOTAL_UNIT'] = '1';
                                $DETAIL['TOTAL'] = $Total;
                                $DETAIL['PROSEN_M1'] = '0';
                                $DETAIL['SELISIH_M1'] = '0';
                                $DETAIL['M1_START_DATE'] = null;
                                $DETAIL['M1_END_DATE'] = null;
                                $DETAIL['TOTAL_M1'] = '0';
                                $DETAIL['PROSEN_M2'] = '0';
                                $DETAIL['SELISIH_M2'] = '0';
                                $DETAIL['M2_START_DATE'] = null;
                                $DETAIL['M2_END_DATE'] = null;
                                $DETAIL['TOTAL_M2'] = $PenumpukanMasa1;
                                $DETAIL['PROSEN_M3'] = '2';
                                $DETAIL['SELISIH_M3'] = $SelisihMasa2;
                                $DETAIL['M3_START_DATE'] = date("Y-m-d", strtotime($Masa1 . "+1 days"));
                                $DETAIL['M3_END_DATE'] = $EndDateMasa2;
                                $DETAIL['TOTAL_M3'] = $PenumpukanMasa2;
                                $DETAIL['PROSEN_M4'] = '3';
                                $DETAIL['SELISIH_M4'] = $SelisihMasa3;
                                $DETAIL['M4_START_DATE'] = date("Y-m-d", strtotime($PaidThruOld . "+1 days"));
                                $DETAIL['M4_END_DATE'] = $PaidThru;
                                $DETAIL['TOTAL_M4'] = $PenumpukanMasa3;
                                $DETAIL['WK_REKAM'] = date('Y-m-d H:i:s');
                                $DETAIL['FL_DG'] = $DTL['DG'];
                                $this->db->insert('req_delivery_dtl', $DETAIL);
                                if ($PenumpukanMasa1 > 0) {
                                    $SIM_M1['ID_REQ'] = $REQ;
                                    $SIM_M1['NO_CONT'] = $DTL['NO_CONT'];
                                    $SIM_M1['UKR_CONT'] = $DTL['UKR_CONT'];
                                    $SIM_M1['CHARGE'] = $Charge;
                                    $SIM_M1['JENIS_TARIF'] = 'PENUMPUKAN 1';
                                    $SIM_M1['TOTAL'] = $PenumpukanMasa1;
                                    $SIM_M1['WK_REKAM'] = date('Y-m-d H:i:s');
                                    $this->db->insert('req_delivery_simkeu', $SIM_M1);
                                }
                                if ($PenumpukanMasa2 > 0) {
                                    $SIM_M2['ID_REQ'] = $REQ;
                                    $SIM_M2['NO_CONT'] = $DTL['NO_CONT'];
                                    $SIM_M2['UKR_CONT'] = $DTL['UKR_CONT'];
                                    $SIM_M2['CHARGE'] = $Charge;
                                    $SIM_M2['JENIS_TARIF'] = 'PENUMPUKAN 1.1';
                                    $SIM_M2['TOTAL'] = $PenumpukanMasa2;
                                    $SIM_M2['WK_REKAM'] = date('Y-m-d H:i:s');
                                    $this->db->insert('req_delivery_simkeu', $SIM_M2);
                                }
                                if ($PenumpukanMasa3 > 0) {
                                    $SIM_M3['ID_REQ'] = $REQ;
                                    $SIM_M3['NO_CONT'] = $DTL['NO_CONT'];
                                    $SIM_M3['UKR_CONT'] = $DTL['UKR_CONT'];
                                    $SIM_M3['CHARGE'] = $Charge;
                                    $SIM_M3['JENIS_TARIF'] = 'PENUMPUKAN 2';
                                    $SIM_M3['TOTAL'] = $PenumpukanMasa3;
                                    $SIM_M3['WK_REKAM'] = date('Y-m-d H:i:s');
                                    $this->db->insert('req_delivery_simkeu', $SIM_M3);
                                }
                            }
                        } else {
                            $Masa1 = date("Y-m-d", strtotime($MasaBebas . "+1 days"));
                            $Masa2 = date("Y-m-d", strtotime($Masa1 . "+1 days"));
                            $Masa3 = date("Y-m-d", strtotime($Masa2 . "+1 days"));

                            //echo"Masa Bebas     > " . $MasaBebas . "<br>";
                            //echo"Masa 1         > " . $Masa1 . "<br>";
                            //echo"Masa 2         > " . $Masa2 . "<br>";
                            //echo"Masa 3         > " . $Masa3 . "<br>";
                            //echo"Masa Paid        > " . $PaidThru . "<br>";
                            //echo"Masa PaidOld    > " . $PaidThruOld . "<br>";
                            //echo"Masa NHI        > " . $StartNHI . "<br>";
                            //echo"Masa END NHI    > " . $EndNHI . "<br>";

                            $DateTime1 = new DateTime($MasaBebas);
                            $DateTime2 = new DateTime($PaidThru);
                            $difference = $DateTime1->diff($DateTime2);
                            $selisihDiff = $difference->days;
                            $selisih = $selisihDiff;
                            //echo"Selisih Paid > " . $selisih . "<br>";

                            $DateTime3 = new DateTime($StartNHI);
                            $DateTime4 = new DateTime($EndNHI);
                            $difference = $DateTime3->diff($DateTime4);
                            $selisihDiff = $difference->days;
                            $selisihNHI = $selisihDiff;
                            //echo"Selisih NHI > " . $selisihNHI . "<br>";

                            for ($i = 0; $i <= $selisihNHI; $i++) {
                                $checkDate1[] = date("Y-m-d", strtotime($i . " days" . $StartNHI));
                            }
                            $PenumpukanMasaBebas = 0;
                            $SelisihMasaBebas = 0;
                            for ($j = 0; $j <= $selisih; $j++) {
                                $checkDate = date("Y-m-d", strtotime($j . " days" . $MasaBebas));
                                //echo$checkDate . " - ";
                                if ((in_array($checkDate, $checkDate1)) && ($selisihNHI != 0)) {
                                    if ($checkDate > $PaidThruOld) {
                                        $PenumpukanNHI = $PenumpukanNHI + ($Charge * 0);
                                        //echo$PenumpukanNHI;
                                    }
                                } else {
                                    if (($checkDate <= $MasaBebas) && ($checkDate > $PaidThruOld)) {
                                        $SelisihMasaBebas = 0;
                                        $PenumpukanMasaBebas = $SelisihMasaBebas * ($Charge * 0);
                                        //echo$PenumpukanMasaBebas;
                                    }
                                    if (($checkDate <= $Masa1) && ($checkDate > $PaidThruOld)) {
                                        $SelisihMasa1 = 1;
                                        $PenumpukanMasa1 = $SelisihMasa1 * ($Charge * 3);
                                        //echo$PenumpukanMasa1;
                                    }
                                    if (($checkDate <= $Masa2) && ($checkDate > $PaidThruOld)) {
                                        $SelisihMasa2 = 1;
                                        $PenumpukanMasa2 = $SelisihMasa2 * ($Charge * 6);
                                        //echo$PenumpukanMasa2;
                                    }
                                    if (($checkDate >= $Masa3) && ($checkDate <= $PaidThru) && ($checkDate > $PaidThruOld)) {
                                        $SelisihMasa3++;
                                        $PenumpukanMasa3 = $PenumpukanMasa3 + ($Charge * $tpenumpukanmasa3);
                                        //echo$PenumpukanMasa3;
                                    }
                                }
                                //echo"<br>";
                            }
                            $Total = $PenumpukanMasaBebas + $PenumpukanNHI + $PenumpukanMasa1 + $PenumpukanMasa2 + $PenumpukanMasa3;
                            if ($Total > 0) {
                                $DETAIL['ID_REQ'] = $REQ;
                                $DETAIL['NO_CONT'] = $DTL['NO_CONT'];
                                $DETAIL['UKR_CONT'] = $DTL['UKR_CONT'];
                                $DETAIL['ISO_CODE'] = $TYPE_CONT;
                                $DETAIL['STATUS'] = $DTL['STATUS'];
                                $DETAIL['TARIF_ID'] = $TARIF_ID;
                                $DETAIL['CHARGE'] = $Charge;
                                $DETAIL['TOTAL_UNIT'] = '1';
                                $DETAIL['TOTAL'] = $Total;
                                $DETAIL['PROSEN_M1'] = '0';
                                $DETAIL['SELISIH_M1'] = $SelisihMasaBebas;
                                $DETAIL['M1_START_DATE'] = $MasaBebas;
                                $DETAIL['M1_END_DATE'] = $MasaBebas;
                                $DETAIL['TOTAL_M1'] = $PenumpukanMasaBebas;
                                $DETAIL['PROSEN_M2'] = '3';
                                $DETAIL['SELISIH_M2'] = $SelisihMasa1;
                                $DETAIL['M2_START_DATE'] = $Masa1;
                                $DETAIL['M2_END_DATE'] = $Masa1;
                                $DETAIL['TOTAL_M2'] = $PenumpukanMasa1;
                                $DETAIL['PROSEN_M3'] = '6';
                                $DETAIL['SELISIH_M3'] = $SelisihMasa2;
                                $DETAIL['M3_START_DATE'] = $Masa2;
                                $DETAIL['M3_END_DATE'] = $Masa2;
                                $DETAIL['TOTAL_M3'] = $PenumpukanMasa2;
                                $DETAIL['PROSEN_M4'] = $proses_m4;
                                $DETAIL['SELISIH_M4'] = $SelisihMasa3;
                                $DETAIL['M4_START_DATE'] = date("Y-m-d", strtotime($PaidThruOld . "+1 days"));
                                $DETAIL['M4_END_DATE'] = $PaidThru;
                                $DETAIL['TOTAL_M4'] = $PenumpukanMasa3;
                                $DETAIL['PROSEN_NHI'] = '2';
                                $DETAIL['SELISIH_NHI'] = $selisihNHI;
                                $DETAIL['NHI_START_DATE'] = $StartNHI;
                                $DETAIL['NHI_END_DATE'] = $EndNHI;
                                $DETAIL['TOTAL_NHI4'] = $PenumpukanNHI;
                                $DETAIL['WK_REKAM'] = date('Y-m-d H:i:s');
                                $DETAIL['FL_DG'] = $DTL['DG'];
                                $this->db->insert('req_delivery_dtl', $DETAIL);
                                if ($PenumpukanMasa1 > 0) {
                                    $SIM_M1['ID_REQ'] = $REQ;
                                    $SIM_M1['NO_CONT'] = $DTL['NO_CONT'];
                                    $SIM_M1['UKR_CONT'] = $DTL['UKR_CONT'];
                                    $SIM_M1['CHARGE'] = $Charge;
                                    $SIM_M1['JENIS_TARIF'] = 'PENUMPUKAN 1';
                                    $SIM_M1['TOTAL'] = $PenumpukanMasa1;
                                    $SIM_M1['WK_REKAM'] = date('Y-m-d H:i:s');
                                    $this->db->insert('req_delivery_simkeu', $SIM_M1);
                                }
                                if ($PenumpukanMasa2 > 0) {
                                    $SIM_M2['ID_REQ'] = $REQ;
                                    $SIM_M2['NO_CONT'] = $DTL['NO_CONT'];
                                    $SIM_M2['UKR_CONT'] = $DTL['UKR_CONT'];
                                    $SIM_M2['CHARGE'] = $Charge;
                                    $SIM_M2['JENIS_TARIF'] = 'PENUMPUKAN 1.1';
                                    $SIM_M2['TOTAL'] = $PenumpukanMasa2;
                                    $SIM_M2['WK_REKAM'] = date('Y-m-d H:i:s');
                                    $this->db->insert('req_delivery_simkeu', $SIM_M2);
                                }
                                if ($PenumpukanMasa3 > 0) {
                                    $SIM_M3['ID_REQ'] = $REQ;
                                    $SIM_M3['NO_CONT'] = $DTL['NO_CONT'];
                                    $SIM_M3['UKR_CONT'] = $DTL['UKR_CONT'];
                                    $SIM_M3['CHARGE'] = $Charge;
                                    $SIM_M3['JENIS_TARIF'] = 'PENUMPUKAN 2';
                                    $SIM_M3['TOTAL'] = $PenumpukanMasa3;
                                    $SIM_M3['WK_REKAM'] = date('Y-m-d H:i:s');
                                    $this->db->insert('req_delivery_simkeu', $SIM_M3);
                                }
                                if ($PenumpukanNHI > 0) {
                                    $SIM_NHI['ID_REQ'] = $REQ;
                                    $SIM_NHI['NO_CONT'] = $DTL['NO_CONT'];
                                    $SIM_NHI['UKR_CONT'] = $DTL['UKR_CONT'];
                                    $SIM_NHI['CHARGE'] = $Charge;
                                    $SIM_NHI['JENIS_TARIF'] = 'PENUMPUKAN NHI';
                                    $SIM_NHI['TOTAL'] = $PenumpukanNHI;
                                    $SIM_NHI['WK_REKAM'] = date('Y-m-d H:i:s');
                                    //print_r($SIM_NHI);
                                    $this->db->insert('req_delivery_simkeu', $SIM_NHI);
                                }
                            }
                            #DENDA SP2
                            $JumlahKontainerPerBL = $COUNTCONT;
                            //echo"jum cont " . $JumlahKontainerPerBL . "<br>";
                            if ($JumlahKontainerPerBL > 30) {
                                $JumlahMasaBebas = 4;
                            } else {
                                $JumlahMasaBebas = 2;
                            }

                            $DateTimeSp21 = new DateTime($PaidThru);
                            $DateTimeSp22 = new DateTime($TglSp2);
                            $difference = $DateTimeSp21->diff($DateTimeSp22);
                            $selisih = $difference->days;
                            $GetDateDiff = $selisih;
                            //echo"Selisih SP2 > " . $GetDateDiff . "<br>";

                            $SelisihDateM1Sp2 = 0;
                            $SelisihDateM2Sp2 = 0;
                            $SelisihDateM3Sp2 = 0;
                            $SelisihDateM4Sp2 = 0;
                            $DendaM1Sp2 = 0;
                            $DendaM2Sp2 = 0;
                            $DendaM3Sp2 = 0;
                            $DendaM4Sp2 = 0;

                            $SelisihMasaBebas = $GetDateDiff;
                            //echo"SelisihMasaBebas " . $SelisihMasaBebas . "<br>";
                            if ($SelisihMasaBebas > 0) {
                                if ($CekBilling != 0) {
                                    $StartDenda = date("Y-m-d", strtotime($TglSp2 . "+1 days"));
                                    //echo"Tanggal SP2<br>";
                                } else {
                                    $StartDenda = date("Y-m-d", strtotime($TglSp2 . "+2 days"));
                                    //echo"Tanggal REQUEST<br>";
                                }
                                for ($i = 0; $i <= $SelisihMasaBebas; $i++) {
                                    $checkDendaPS2Date = date("Y-m-d", strtotime($i . " days" . $TglSp2));
                                    //echo$checkDendaPS2Date . "--";
                                    if ((in_array($checkDendaPS2Date, $checkDate1)) && ($selisihNHI != 0)) {
                                        $SelisihDateNHISp2 = 0;
                                        $DendaMHISp2 = $SelisihDateNHISp2 * (($Charge_sp2 * 0) * $tDendaMHISp2);
                                        //echo$DendaMHISp2;
                                    } else {
                                        if ($checkDendaPS2Date == $MasaBebas) {
                                            if ($checkDendaPS2Date >= $StartDenda) {
                                                $SelisihDateM1Sp2 = 0;
                                                $DendaM1Sp2 = $SelisihDateM1Sp2 * (($Charge_sp2 * 0) * $tDendaMHISp2);
                                                //echo$DendaM1Sp2;
                                            }
                                        }
                                        if ($checkDendaPS2Date == $Masa1) {
                                            if ($checkDendaPS2Date >= $StartDenda) {
                                                $SelisihDateM2Sp2 = 1;
                                                $DendaM2Sp2 = $SelisihDateM2Sp2 * (($Charge_sp2 * 3) * $tDendaMHISp2);
                                                //echo$DendaM2Sp2;
                                            }
                                        }
                                        if ($checkDendaPS2Date == $Masa2) {
                                            if ($checkDendaPS2Date >= $StartDenda) {
                                                $SelisihDateM3Sp2 = 1;
                                                $DendaM3Sp2 = $SelisihDateM3Sp2 * (($Charge_sp2 * 6) * $tDendaMHISp2);
                                                //echo$DendaM3Sp2;
                                            }
                                        }
                                        if (($checkDendaPS2Date >= $Masa3) && ($checkDendaPS2Date <= $PaidThru)) {
                                            if ($checkDendaPS2Date >= $StartDenda) {
                                                $SelisihDateM4Sp2++;
                                                $DendaM4Sp2 = $DendaM4Sp2 + (($Charge_sp2 * $tpenumpukanmasa3) * $tDendaMHISp2);
                                                //echo$DendaM4Sp2;
                                            }
                                        }
                                    }
                                    //echo"<br>";
                                }
                                $TotalDendaSp2 = $DendaM1Sp2 + $DendaM2Sp2 + $DendaM3Sp2 + $DendaM4Sp2;
                                if ($TotalDendaSp2 > 0) {
                                    $DENDA_SP2['ID_REQ'] = $REQ;
                                    $DENDA_SP2['NO_CONT'] = $DTL['NO_CONT'];
                                    $DENDA_SP2['UKR_CONT'] = $DTL['UKR_CONT'];
                                    $DENDA_SP2['ISO_CODE'] = $TYPE_CONT;
                                    $DENDA_SP2['STATUS'] = $DTL['STATUS'];
                                    $DENDA_SP2['TARIF_ID'] = $SQL_SP2->TARIF_ID;
                                    $DENDA_SP2['CHARGE'] = $Charge_sp2;
                                    $DENDA_SP2['TOTAL_UNIT'] = '1';
                                    $DENDA_SP2['TOTAL'] = $TotalDendaSp2;
                                    $DENDA_SP2['PROSEN_M1'] = '0';
                                    $DENDA_SP2['SELISIH_M1'] = $SelisihDateM1Sp2;
                                    $DENDA_SP2['M1_START_DATE'] = $MasaBebas;
                                    $DENDA_SP2['M1_END_DATE'] = $MasaBebas;
                                    $DENDA_SP2['TOTAL_M1'] = $DendaM1Sp2;
                                    $DENDA_SP2['PROSEN_M2'] = '3';
                                    $DENDA_SP2['SELISIH_M2'] = $SelisihDateM2Sp2;
                                    $DENDA_SP2['M2_START_DATE'] = $Masa1;
                                    $DENDA_SP2['M2_END_DATE'] = $Masa1;
                                    $DENDA_SP2['TOTAL_M2'] = $DendaM2Sp2;
                                    $DENDA_SP2['PROSEN_M3'] = '6';
                                    $DENDA_SP2['SELISIH_M3'] = $SelisihDateM3Sp2;
                                    $DENDA_SP2['M3_START_DATE'] = $Masa2;
                                    $DENDA_SP2['M3_END_DATE'] = $Masa2;
                                    $DENDA_SP2['TOTAL_M3'] = $DendaM3Sp2;
                                    $DENDA_SP2['PROSEN_M4'] = $proses_m4;
                                    $DENDA_SP2['SELISIH_M4'] = $SelisihDateM4Sp2;
                                    $DENDA_SP2['M4_START_DATE'] = $StartDenda;
                                    $DENDA_SP2['M4_END_DATE'] = $PaidThru;
                                    $DENDA_SP2['TOTAL_M4'] = $DendaM4Sp2;
                                    $DENDA_SP2['WK_REKAM'] = date('Y-m-d H:i:s');
                                    $this->db->insert('req_delivery_dtl', $DENDA_SP2);
                                    $GantiTglSp2['TGL_REQ_SP2'] = $PaidThru;
                                    $this->db->where(array('ID_REQ' => $REQ));
                                    $this->db->update('req_delivery_hdr', $GantiTglSp2);
                                    if ($TotalDendaSp2 > 0) {
                                        $SIM_M1SP2['ID_REQ'] = $REQ;
                                        $SIM_M1SP2['NO_CONT'] = $DTL['NO_CONT'];
                                        $SIM_M1SP2['UKR_CONT'] = $DTL['UKR_CONT'];
                                        $SIM_M1SP2['CHARGE'] = $Charge_sp2;
                                        $SIM_M1SP2['JENIS_TARIF'] = 'DENDA SP 2';
                                        $SIM_M1SP2['TOTAL'] = $TotalDendaSp2;
                                        $SIM_M1SP2['WK_REKAM'] = date('Y-m-d H:i:s');
                                        $this->db->insert('req_delivery_simkeu', $SIM_M1SP2);
                                    }
                                }
                            }
                        }
                    }
                }
                // BIAYA ADMIN
                $TARIF_ADMIN = $SQL_ADMIN->TARIF;
                $TARIF_ADMIN_ID = $SQL_ADMIN->TARIF_ID;
                $DATA_ADM['ID_REQ'] = $REQ;
                $DATA_ADM['TARIF_ID'] = $TARIF_ADMIN_ID;
                $DATA_ADM['CHARGE'] = $TARIF_ADMIN;
                $DATA_ADM['TOTAL'] = $TARIF_ADMIN;
                $this->db->insert('req_delivery_dtl', $DATA_ADM);
                $SIM_ADM['ID_REQ'] = $REQ;
                $SIM_ADM['CHARGE'] = $TARIF_ADMIN;
                $SIM_ADM['JENIS_TARIF'] = 'ADMINISTRASI';
                $SIM_ADM['TOTAL'] = $TARIF_ADMIN;
                $SIM_ADM['WK_REKAM'] = date('Y-m-d H:i:s');
                $this->db->insert('req_delivery_simkeu', $SIM_ADM);

                $TARIF_TRUCK = $SQL_TRUCK->TARIF;
                $TARIF_TRUCK_ID = $SQL_TRUCK->TARIF_ID;
                $HITUNGCONT = $TARIF_TRUCK * $JML_CONT;

                $DATA_ADM['ID_REQ'] = $REQ;
                $DATA_ADM['ISO_CODE'] = $TYPE_CONT;
                $DATA_ADM['STATUS'] = $DTL['STATUS'];
                $DATA_ADM['TARIF_ID'] = $TARIF_TRUCK_ID;
                $DATA_ADM['CHARGE'] = $TARIF_TRUCK;
                $DATA_ADM['TOTAL_UNIT'] = $JML_CONT;
                $DATA_ADM['TOTAL'] = $HITUNGCONT;
                $DATA_ADM['WK_REKAM'] = date('Y-m-d H:i:s');
                $this->db->insert('req_delivery_dtl', $DATA_ADM);
                $SIM_ADM['ID_REQ'] = $REQ;
                $SIM_ADM['CHARGE'] = $TARIF_TRUCK;
                $SIM_ADM['JENIS_TARIF'] = 'TRUCK';
                $SIM_ADM['TOTAL'] = $HITUNGCONT;
                $SIM_ADM['WK_REKAM'] = date('Y-m-d H:i:s');
                $this->db->insert('req_delivery_simkeu', $SIM_ADM);
                //EDITBILLING CG
                $sub_total = $this->db->query("SELECT SUM(TOTAL) AS TOTAL FROM req_delivery_dtl WHERE ID_REQ = '$REQ'")->row()->TOTAL;
                $PPN = $sub_total * 0.11;
                $sub_totalBM = $sub_total + $PPN;
                if ($sub_totalBM > 5000000) {
                    $MAT = 10000;
                } else {
                    $MAT = 0;
                }
                $TOTAL_ALL = $MAT + $sub_total + $PPN;
                $DATA_HDR_UP['BIAYA_MATERAI'] = $MAT;
                $DATA_HDR_UP['SUBTOTAL'] = $sub_total;
                $DATA_HDR_UP['PPN'] = $PPN;
                $DATA_HDR_UP['TOTAL'] = $TOTAL_ALL;
                $DATA_HDR_UP['TGL_STACK'] = $TGL_BONGKAR;
                $this->db->where(array('ID_REQ' => $REQ));
                $this->db->update('req_delivery_hdr', $DATA_HDR_UP);

                $SIM_MAT['ID_REQ'] = $REQ;
                $SIM_MAT['CHARGE'] = $MAT;
                $SIM_MAT['JENIS_TARIF'] = 'MATERAI DEL';
                $SIM_MAT['TOTAL'] = $MAT;
                $SIM_MAT['WK_REKAM'] = date('Y-m-d H:i:s');
                $this->db->insert('req_delivery_simkeu', $SIM_MAT);

                $this->db->where(array('ID_REQ' => $IdReqOld));
                $this->db->update('req_delivery_hdr', array('FL_ID_REQ_OLD' => 'Y'));

                //echo"MSG#OK#Data berhasil diproses#" . site_url() . "/billingDeliveryExt/delivery_ext/post";
                if ($error == 0) {
                    return $this->httpres(200, 'success', $REQ, '');
                    //////echo"MSG#OK#Data berhasil diproses#".site_url()."/billingDelivery/delivery/post";
                } else {
                    return $this->httpres(200, 'error', '', 'Terjadi Error');
                    //////echo"MSG#ERR#".$message."#";
                }
            } else if ($act == "update") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "") {
                        unset($DATA[$a]);
                    } else {
                        $DATA[$a] = strtoupper(trim($b));
                    }

                }

                $id = $idreqolc;
                $DATAN['NPWP'] = $DATA['NPWP'];
                $DATAN['EXPIRED'] = $DATA['EXPIRED'];
                $DATAN['NM_KAPAL'] = $DATA['NM_KAPAL'];
                $DATAN['NO_DOK'] = $DATA['NO_DOK'];
                $DATAN['NO_DO'] = $DATA['NO_DO'];
                $DATAN['NO_VOY'] = $DATA['NO_VOY'];
                $DATAN['TGL_DOK'] = $DATA['TGL_DOK'];

                $this->db->where(array('ID_REQ' => $id));
                $result = $this->db->update('req_delivery_hdr', $DATAN);

                if ($error == 0) {
                    $action = '/billingDeliveryExt/delivery_ext/post';
                    //echo"MSG#OK#Data berhasil diproses#" . $this->input->post('action');
                } else {
                    //echo"MSG#ERR#" . $message . "#";
                }
            }

            if ($custom_refer == 'on' && $custom_unplug != '') {
                foreach (explode(',', $cont_post_c) as $key1 => $valuerfr1) {
                    $exprefr = explode('~', $valuerfr1);
                    $exprefrtemp = $exprefr[1];
                    $ref11 = $this->db->query("select id,no_Cont,waktu,waktu_end from t_op_reefer where no_cont = '$exprefrtemp' and waktu is not null")->row();
                    if ($ref11 != null) {
                        $this->db->set('waktu_end', null);
                        $this->db->set('fl_unplug', 'N');
                        $this->db->set('operator_end', null);
                        $this->db->where('id', $ref11->id);
                        $this->db->update('t_op_reefer');
                    }
                }
            }
        } catch (Exception $e) {
            $this->httpres(200, 'error', '', $e->getMessage());
        }
    }

    public function syncdok()
    {
        $token = $this->input->get('token');
        $nodok = $this->input->get('no_dok');
        $tgdok = $this->input->get('tgl_dok');
        $nocon = $this->input->get('no_cont');
        try {
            $key = "beacukai_mti";
            $decoded = JWT::decode($token, $key, array('HS256'));
            $q = $this->db->query("SELECT a.NO_DOK ,a.TGL_DOK ,a.RESPONSE_REQ,b.NO_CONT,b.UKR_CONT,b.VESSEL ,b.VOY_IN,b.DISCHARGE,b.TIPE_CONT ,b.KD_STATUS,e.NAMA ,c.KD_STATUS ,d.STATUS_CONT,d.LOKASI
            from t_request a
            join t_request_cont b on a.ID = b.ID
            left join t_spk c on a.TGL_DOK = c.TGL_DOK and a.NO_DOK = c.NO_DOK
            left join t_spk_cont d  on c.ID = d.ID and b.NO_CONT = d.NO_CONT
			left join reff_kode_dok_bc e on c.JNS_DOK = e.ID
            where a.NO_DOK = '$nodok' and a.TGL_DOK = '$tgdok' and b.NO_CONT = '$nocon'
            order by a.ID desc")->result();
            if ($q) {
                $this->httpres(200, 'success', $q, '');
            } else {
                $this->httpres(200, 'error', '', 'Data Tidak Di Temukan');
            }

        } catch (Exception $e) {
            $this->httpres(200, 'error', '', $e->getMessage());
        }
    }

    public function login()
    {
        $token = $this->input->get('token');
        $user = $this->input->get('username');
        $pass = $this->input->get('password');
        try {
            $key = "beacukai_mti";
            $decoded = JWT::decode($token, $key, array('HS256'));
            $q = $this->db->query("select id,email,nama,notelp,npwp from reff_user where EMAIL = '$user' and PASS = md5('$pass')")->result();
            if ($q) {
                $this->httpres(200, 'success', $q, '');
            } else {
                $this->httpres(200, 'error', '', 'Data Tidak Di Temukan');
            }

        } catch (Exception $e) {
            $this->httpres(200, 'error', '', $e->getMessage());
        }
    }

    public function getppk()
    {
        $cont = $this->input->get('cont');
        $e = explode(',',$cont);
        $cont2 = '';
        foreach ($e as $key => $value) {
            if ($key==0) {
                $cont2 .= "'".$value."'";
            }else {
                $cont2 .= ",'".$value."'";
            }
        }
        $q = $this->db->query("SELECT * FROM (SELECT k.no_antrian,a.NO_CONT,a.UKR_CONT,a.TGL_DOK,a.JNS_DOK,a.`STATUS`,a.NO_DOK,b.LOKASI,a.JNS_KEGIATAN,a.NAMA_CUST,b.STATUS_CONT,d.START_INSP,d.FINISH_INSP,a.RESPON,a.WK_RESPON,
        CASE
                    WHEN b.STATUS_CONT IN (450,510,530) AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND a.RESPON IS NULL THEN 3
                    WHEN b.STATUS_CONT IN (450,510,530) AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL AND a.RESPON IS NOT NULL THEN 2
                    WHEN b.STATUS_CONT = 460 AND d.START_INSP IS NULL AND d.FINISH_INSP IS NULL  AND a.RESPON IS NOT NULL THEN 1
                    WHEN b.STATUS_CONT = 460 AND d.START_INSP IS NOT NULL AND d.FINISH_INSP IS NULL THEN 4
                    WHEN b.STATUS_CONT IN (500,540,520) THEN 6 
                    ELSE 5 
                END AS STATUS2,s.NOTE, t.tipe_cont AS tipe_cont 
        FROM t_gatepass a
        left JOIN (SELECT * FROM t_spk_cont WHERE STATUS_CONT != 900) b on a.NO_CONT = b.NO_CONT 
        JOIN t_spk c ON c.ID = b.ID
        LEFT JOIN t_op_inspection d ON a.NO_CONT = d.NO_CONT AND a.NO_DOK = d.NO_DOK
        LEFT JOIN (select * from t_antrian_respon_ppk where reset = 'N') k ON a.ID = k.id_gatepass
        LEFT JOIN t_job_slip s ON c.NO_SPK = s.NO_SPK AND a.NO_CONT = s.NO_CONT AND s.JENIS = CONCAT('BEHANDLE ',a.JNS_KEGIATAN)
        LEFT JOIN (SELECT a.id, a.no_dok, a.tgl_dok, b.NO_CONT, b.UKR_CONT, b.tipe_cont
            FROM t_request a
            JOIN t_request_cont b ON a.id = b.id ) t ON c.NO_DOK = t.no_dok AND t.no_cont = a.no_cont
        WHERE  a.JNS_KEGIATAN  != 3) az
        where  NO_CONT in ($cont2)
        ORDER BY STATUS2,WK_RESPON")->result();

        return $this->httpres(200, 'success', $q, '');
    }

    public function getppk2()
    {
        $cont = $this->input->get('cont');
        $dok = $this->input->get('dok');
        $e = explode(',',$cont);
        $cont2 = '';
        foreach ($e as $key => $value) {
            if ($key==0) {
                $cont2 .= "'".$value."'";
            }else {
                $cont2 .= ",'".$value."'";
            }
        }

        $e2 = explode(',',$dok);
        $dok = '';
        foreach ($e2 as $key => $value) {
            if ($key==0) {
                $dok .= "'".$value."'";
            }else {
                $dok .= ",'".$value."'";
            }
        }
        $q = $this->db->query("SELECT a.NO_DOK,a.TGL_DOK, a.KD_STATUS ,b.NO_CONT , b.STATUS_CONT,d.VESSEL ,d.VOY_IN 
        from t_spk a 
        join t_spk_cont b on a.ID = b.ID 
        join t_request c on a.NO_DOK = c.NO_DOK and a.TGL_DOK = c.TGL_DOK 
        join t_request_cont d on c.ID = d.ID and b.NO_CONT = d.NO_CONT
        where b.NO_CONT in ($cont2) and a.NO_DOK in ($dok)")->result();

        return $this->httpres(200, 'success', $q, '');
    }
    public function getppk3()
    {
        $dok = $this->input->get('dok');
        $q = $this->db->query("SELECT b.NO_CONT,b.TIPE_CONT , b.UKR_CONT ,b.KD_CONT_JENIS,b.DISCHARGE from t_request a join t_request_cont b on a.ID = b.ID where NO_DOK = '$dok' and DATE(a.WK_REKAM) > DATE_ADD(NOW() , INTERVAL -1 MONTH)")->result();

        return $this->httpres(200, 'success', $q, '');
    }

    public function getbilling()
    {
        $id = $this->input->get('id');
        $jns = $this->input->get('jns');
        $e = explode(',',$id);
        $id2 = '';
        foreach ($e as $key => $value) {
            if ($key==0) {
                $id2 .= "'".$value."'";
            }else {
                $id2 .= ",'".$value."'";
            }
        }

        if ($jns == 'bhd') {
            $q = $this->db->query("SELECT ID_REQ,NO_NOTA_BEHANDLE as NOTA from req_behandle_hdr where ID_REQ in ($id2) and NO_NOTA_BEHANDLE is not null")->result();
        }else {
            $q = $this->db->query("SELECT ID_REQ,NO_NOTA_DELIVERY as NOTA from req_delivery_hdr where ID_REQ in ($id2) and NO_NOTA_DELIVERY is not null")->result();
        }
        

        return $this->httpres(200, 'success', $q, '');
    }

    public function httpres($header, $status, $data = array(), $message = '')
    {
        if ($status === 'success') {
            $response = array(
                'status' => $status,
                'data' => $data,
            );
            $this->output
                ->set_status_header($header)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode($response));
        } else {
            $response = array(
                'status' => $status,
                'message' => $message,
            );
            $this->output
                ->set_status_header($header)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode($response));
        }
    }

    public function cekkartu()
    {
        $id = $this->input->post('cont');
        //var_dump($id);die();
        $cek = $this->db->query("SELECT A.*,C.NO_SPK,CASE WHEN LEFT(LOKASI,3) = 'CIC' THEN LOKASI WHEN LOKASI IS NULL THEN 'TERMINAL' ELSE CONCAT(LOKASI,'0', TIER) END AS 'LOKASI', X.TIPE, X.ISO_CODE, X.BRUTO
        FROM t_gatepass A
        LEFT JOIN t_spk_cont B ON A.NO_CONT = B.NO_CONT
        LEFT JOIN t_spk C ON A.NO_DOK = C.NO_DOK AND A.TGL_DOK = C.TGL_DOK
        LEFT JOIN (
            SELECT NO_CONT, KD_CONT_TIPE AS 'TIPE', ISO_CODE, BRUTO
            FROM t_cocostscont 
            ) X ON X.NO_CONT = A.NO_CONT 
        WHERE A.NO_CONT ='$id' and A.JNS_KEGIATAN in (1,2) order by A.ID DESC limit 1")->num_rows();

        if ($cek > 0) {
            return $this->httpres(200, 'success', 'ada','');
        }else{
            return $this->httpres(200, 'error', '', 'Kartu Gatepass Belum Ada');
        }
    }

    public function getsppb()
    {
        $method = 'GetImpor_Sppb';
        $xml = '';
        $SOAPAction = 'http://services.beacukai.go.id/' . $method;
        $NO_DOK_INOUT = $_GET['NO_SPPB'];
        $TGL_DOK_INOUT = $_GET['TGL_SPPB'];
        $NPWP_CONSIGNEE = $_GET['NPWP'];

        $xml = '<?xml version="1.0" encoding="utf-8"?>
        <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
        <soap:Body>
        <GetImpor_Sppb xmlns="http://services.beacukai.go.id/">
        <UserName>NCT1</UserName>
        <Password>NCT1123456</Password>
        <No_Sppb>' . $NO_DOK_INOUT . '</No_Sppb>
        <Tgl_Sppb>' . $TGL_DOK_INOUT . '</Tgl_Sppb>
        <NPWP_Imp>' . $NPWP_CONSIGNEE . '</NPWP_Imp>
        </GetImpor_Sppb>
        </soap:Body>
        </soap:Envelope>';
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
