<?php defined('BASEPATH') or exit('No direct script access allowed');

class Servicecustom extends CI_Controller
{
    public $content;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_home');
    }

    public function service()
    {
        $nocont = $this->input->post('container');
        $nopib = $this->input->post('nopib');

        $pass = $this->input->post('pass');
        $user = $this->input->post('user');

        if ($pass != '12344321' or $user != 'appmti' ) {
            $status = 'error';
            $message = 'access denied - user or password error !!';
            $data1 = '';
        }else{
            $nocont = strtoupper($nocont);
            $nocont = trim($nocont);
            $nopib = strtoupper($nopib);
            $nopib = trim($nopib);

            $status = 'success';

            $qcek = $this->db->query("SELECT A.NO_DOK,A.TGL_DOK,A.NO_SPK,A.NO_CONT,A.STATUS_CONT,B.DISCHARGE,B.WK_SEND,B.WK_FINISH FROM(
                SELECT a.NO_DOK,a.TGL_DOK,a.NO_SPK,b.NO_CONT,b.STATUS_CONT FROM t_spk a JOIN t_spk_cont b ON a.ID = b.ID) A
            JOIN (
                SELECT c.NO_DOK,c.TGL_DOK,c.WK_REQ,c.WK_SEND,c.WK_FINISH,d.NO_CONT,d.UKR_CONT,d.TIPE_CONT,d.KD_CONT_JENIS,d.DISCHARGE FROM t_request c JOIN t_request_cont d ON c.ID = d.ID) B ON  A.no_dok = B.no_dok AND A.NO_CONT = B.NO_CONT
            WHERE A.no_dok LIKE '$nopib%' and A.no_cont = '$nocont'
				ORDER BY B.DISCHARGE DESC");


            if ($qcek->num_rows() > 0) {
                
                $nospk = $qcek->row()->NO_SPK;
                $nodok = $qcek->row()->NO_DOK;

                $jobslip_pickup = $this->db->query("SELECT wk_status FROM t_job_slip WHERE no_spk = '$nospk' AND no_cont = '$nocont' AND jenis = 'PICKUP' ORDER BY wk_status desc");
                //echo "SELECT wk_status FROM t_job_slip WHERE no_spk = '$nospk' AND no_cont = '$nocont' AND jenis = 'PICKUP' ORDER BY wk_status desc";
                $jobslip_behandle1 = $this->db->query("SELECT wk_status FROM t_job_slip WHERE no_spk = '$nospk' AND no_cont = '$nocont' AND jenis = 'BEHANDLE 1' ORDER BY wk_status desc");
                //echo "SELECT wk_status FROM t_job_slip WHERE no_spk = '$nospk' AND no_cont = '$nocont' AND jenis = 'BEHANDLE 1' ORDER BY wk_status desc";
                $gatepass = $this->db->query("SELECT id,wk_respon FROM t_gatepass WHERE no_dok = '$nodok' AND no_cont = '$nocont' ORDER BY id DESC LIMIT 1");
                //echo "SELECT id,wk_respon FROM t_gatepass WHERE no_dok = '$nodok' AND no_cont = '$nocont' ORDER BY id DESC LIMIT 1";
                $idgatepass = $gatepass->row()->id;

                $antrian = $this->db->query("SELECT no_antrian FROM t_antrian_respon_ppk WHERE id_gatepass = '$idgatepass'");
                //echo "SELECT no_antrian FROM t_antrian_respon_ppk WHERE id_gatepass = '$idgatepass'";
                if ($qcek->row()->STATUS_CONT == '460') {
                    $jobslip_siap = $this->db->query("SELECT id_job_slip,wk_status FROM t_job_slip WHERE no_spk = '$nospk' AND no_cont = '$nocont' AND lokasi_akhir LIKE 'CIC%' ORDER BY id_job_slip DESC LIMIT 1");
                }else{
                    $jobslip_siap = $this->db->query("SELECT id_job_slip,wk_status FROM t_job_slip WHERE no_spk = '$nospk' AND no_cont = '$nocont' AND lokasi_akhir LIKE 'CIC%' and kd_status = 'DONE' ORDER BY id_job_slip DESC LIMIT 1");
                }
                //echo "SELECT id_job_slip,wk_status FROM t_job_slip WHERE no_spk = '$nospk' AND no_cont = '$nocont' AND lokasi_akhir LIKE 'CIC%' ORDER BY id_job_slip DESC LIMIT 1";
                $inspection = $this->db->query("SELECT start_insp,finish_insp FROM t_op_inspection WHERE no_cont = '$nocont' AND no_spk = '$nospk'");
                //echo "SELECT start_insp,finish_insp FROM t_op_inspection WHERE no_cont = '$nocont' AND no_spk = '$nospk'";
                $jobslip_after = $this->db->query("SELECT id_job_slip,wk_status FROM t_job_slip WHERE no_spk = '$nospk' AND no_cont = '$nocont' AND lokasi_akhir LIKE '1A%' ORDER BY id_job_slip DESC LIMIT 1");
                //echo "SELECT id_job_slip,wk_status FROM t_job_slip WHERE no_spk = '$nospk' AND no_cont = '$nocont' AND lokasi_akhir LIKE '1A%' ORDER BY id_job_slip DESC LIMIT 1";
                $op_del_gateout = $this->db->query("SELECT WK_GATEOUT FROM t_op_delivery WHERE no_spk = '$nospk' AND no_cont = '$nocont'");
                //echo "SELECT WK_GATEOUT FROM t_op_delivery WHERE no_spk = '$nospk' AND no_cont = '$nocont'";

                $stackingterminal = $qcek->row()->DISCHARGE;
                $dokumenspjmterbit = $qcek->row()->TGL_DOK;
                $reqgatepasssent = $qcek->row()->WK_SEND;
                $reqgatepassinquiry = $qcek->row()->WK_FINISH;
                $pickup = $jobslip_pickup->row()->wk_status;
                $behandleca = $jobslip_behandle1->row()->wk_status;;
                $responppk = $gatepass->row()->wk_respon;
                $nourutppk =  $antrian->row()->no_antrian;
                $siapperiksa = $jobslip_siap->row()->wk_status;
                $sedangperiksa = $inspection->row()->start_insp;
                $selesaiperiksa = $inspection->row()->finish_insp;
                $afterbehandle = $jobslip_after->row()->wk_status;
                $gateout = $op_del_gateout->row()->WK_GATEOUT;

                $data1 = array(
                    'stackingterminal' => $stackingterminal,
                    'dokumenspjmterbit' => $dokumenspjmterbit,
                    'reqgatepasssent' => $reqgatepasssent,
                    'reqgatepassinquiry' => $reqgatepassinquiry,
                    'pickup' => $pickup,
                    'behandleca' => $behandleca,
                    'responppk' => $responppk,
                    'nourutppk' => $nourutppk,
                    'siapperiksa' => $siapperiksa,
                    'sedangperiksa' => $sedangperiksa,
                    'selesaiperiksa' => $selesaiperiksa, 
                    'afterbehandle' => $afterbehandle,
                    'gateout' => $gateout
                );
                $message = 'Data Di Temukan No Dok :'.$nodok.' ,Tgl Dok :'.$nospk = $qcek->row()->TGL_DOK.' ,No Cont :'.$nocont;
            }else{
                $message = 'Data Tidak Di Temukan';
                $data1 = '';
            }
        }
        $data = array(
            'status' => $status,
            'message' => $message,
            'data'  => $data1
        );
      
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, OPTIONS");
        echo json_encode($data);
    }
}