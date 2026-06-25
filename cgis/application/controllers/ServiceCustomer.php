<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ServiceCustomer extends CI_Controller {
    public $content;
    
    public function __construct() {
        parent::__construct();
    }

    public function index(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/xml');
        $input = file_get_contents('php://input');

        $jeson = json_decode($input);
        $key = $jeson->request->header->key;
        $email = $jeson->request->data->email;
        $token = $jeson->request->data->token;

        if ($key != 'a92221edd3d41141160e1e274902728d') {
            $respon = array("Status"=>"Failed", "Message"=>"Invalid Key");
            echo json_encode($respon);
            die();
        }
        //kirim email


        $subject = "RESET PASSWORD OSBOS";
        $this->load->helper('email');
        $email_success = 0;
        if(valid_email($email)){
            $config = array(
                'protocol'  => 'smtp',
                'smtp_host' => 'mail2.edi-indonesia.co.id',
                'smtp_port' => 25,
                'smtp_user' => '',
                'smtp_pass' => '',
                'mailtype'  => 'html',
                'charset'   => 'iso-8859-1',
                'wrapchars' => 100,
                'crlf'         => "\r\n",
                'newline'     => "\r\n",
                'start_tls' => TRUE
            );
            $msg = '
                <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <title>Reset Password</title>
                    </head>
                    <body>
                    <div>
                        <p>
                            Dear Customer,<br><br>
                            Berikut Merupakan token untuk reset password bos customer anda:
                        </p>
                        <table border="1" class="table" width="80%">
                            <tr>
                                <th>Email</th>
                                <th>'.$email.'</th>
                            </tr>
                            <tr>
                                <td>Token</td>
                                <td>'.$token.'</td>
                            </tr>
                        </table>
                        <p>
                            HARAP TIDAK MEMBAGIKAN PASSWORD KEPADA SIAPAPUN.
                        </p>
                        <br>
                        <p>
                            TERIMAKASIH.
                        </p>
                    </div>
                    </body>
                    </html>
            ';


            $this->load->library('email', $config);
            #$this->email->set_newline("\r\n");
            $this->email->from('rifqy.aditya@edi-indonesia.co.id', 'BOS CUSTOMER');
            $email = str_replace(';', ',', $email);
            $this->email->to($email);
            $this->email->subject($subject);
            $this->email->message($msg);
            if ($this->email->send()){
                $email_success = 1;
                /*echo "<script>alert('Email Terkirim');window.location=''</script>";*/
                echo "Email Terkirim";
            }
        }
        return $email_success;
    }
    public function cekbayarlunas(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        $input = file_get_contents('php://input');

        $jeson = json_decode($input);
        $key = $jeson->request->header->key;
        $id = $jeson->request->data->id;

        if ($key != 'a92221edd3d41141160e1e274902728d') {
            $respon = array("Status"=>"Failed", "Message"=>"Invalid Key");
            echo json_encode($respon);
            die();
        }

        $Q = $this->db->query("SELECT tg.NO_DOK from t_gatepass tg where id = '$id' limit 1");
        foreach ($Q->result() as $key => $value1) {
            $NODOK = $value1->NO_DOK;

            $Q1 = $this->db->query("SELECT rdh.ID_REQ, b.SAP_TGL_PELUNASAN from req_delivery_hdr rdh 
            join t_log_kode_bayar_sap b on rdh.ID_REQ = b.PROFORMA
            where rdh.NO_DOK = '$NODOK'
            and b.SAP_TGL_PELUNASAN is null
            union
SELECT e.ID_REQ, f.SAP_TGL_PELUNASAN from req_delivery_hdr rdh 
            join t_log_kode_bayar_sap b on rdh.ID_REQ = b.PROFORMA
            join t_gatepass c on c.NO_DOK = rdh.NO_DOK and c.TGL_DOK = rdh.TGL_DOK
            join t_spk d on c.NO_SPK = d.NO_SPK
            join req_behandle_hdr e on e.NO_DOK = d.NO_DOK and e.TGL_DOK = d.TGL_DOK
            join t_log_kode_bayar_sap f on e.ID_REQ = f.PROFORMA
            where rdh.NO_DOK = '$NODOK'
            and f.SAP_TGL_PELUNASAN is null");
            foreach ($Q1->result() as $key => $value2) {
                $idreq = $value2->ID_REQ;
            }

            if ($idreq != null) {
                echo '0';
            } else {
                echo '1';
            }
        }
    }
}