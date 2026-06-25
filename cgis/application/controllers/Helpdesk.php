<?php defined('BASEPATH') or exit('No direct script access allowed');

class Helpdesk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('LOGGED')) {
            redirect(base_url('index.php'), 'refresh');
        }
    }

    public function index()
    {

        echo $this->load->view("content/helpdesk/main");
        echo $this->load->view("content/helpdesk/mainmenu");
    }

    public function reefer()
    {
        $cont = $this->input->get('cont');

        $data['datser'] = array('cont' => '');
        if ($cont == '') {
            $data['search'] = NULL;
        } else {
            $data['datser'] = array('cont' => $cont);
            $data['search'] = $this->db->query("SELECT * from t_op_reefer where NO_CONT = '$cont'")->result();
        }
        echo $this->load->view("content/helpdesk/main");
        echo $this->load->view("content/helpdesk/reefer", $data);
    }

    public function fixreefer()
    {
        $id = $this->input->get('id');
        $cont = $this->input->get('cont');

        // var_dump($id); var_dump($cont); die();
        $this->db->query("UPDATE t_op_reefer set WAKTU = null, FL_PLUG = 'N' where ID = '$id'");

        redirect("helpdesk/reefer?cont=$cont");

    }

    public function pck()
    {
        $cont = $this->input->post('cont');

        $data['datser'] = array('cont' => '');
        if ($cont == '') {
            $data['search'] = NULL;
        } else {
            $data['datser'] = array('cont' => $cont);
            $data['search'] = $this->db->query("SELECT ts.ID, ts.NO_SPK, tsc.NO_CONT, tsc.ID_FLAT, tsc.FL_SEND_NPCT1 
                                                from t_spk ts join t_spk_cont tsc on ts.ID = tsc.ID 
                                                where ts.NO_SPK like '%$cont%' or tsc.NO_CONT like '%$cont%'")->result();
            $data['truk'] = $this->db->query("SELECT NO_TRUCK  from reff_truck rt")->result();
        }
        echo $this->load->view("content/helpdesk/main");
        echo $this->load->view("content/helpdesk/pickup", $data);
    }
    public function ppck()
    {
        $cont = $this->input->post('cont');
        $id = $this->input->post('id');
        $trek = $this->input->post('trek');

        $data['datser'] = array('cont' => '');
        if ($cont == '') {
            $data['search'] = NULL;
        } else {
            $data['datser'] = array('cont' => $cont);
            $data['search'] = $this->db->query("SELECT ts.ID, ts.NO_SPK, tsc.NO_CONT, tsc.ID_FLAT, tsc.FL_SEND_NPCT1 
                                                from t_spk ts join t_spk_cont tsc on ts.ID = tsc.ID 
                                                where ts.NO_SPK like '%$cont%' or tsc.NO_CONT like '%$cont%'")->result();
            $data['truk'] = $this->db->query("SELECT NO_TRUCK  from reff_truck rt")->result();
        }
        echo $this->load->view("content/helpdesk/main");
        echo $this->load->view("content/helpdesk/pickup", $data);
    }

    public function sch()
    {

        $data['search'] = $this->db->query("SELECT tgl_get from t_log_lnsw tll order by tgl_get desc limit 1")->result();

        echo $this->load->view("content/helpdesk/main");
        echo $this->load->view("content/helpdesk/sch", $data);
    }

    public function dokspjm()
    {
        $data['log_data'] = $this->db->query("SELECT * FROM solver_req_dokumen_log WHERE tipe = 'spjm' ORDER BY id DESC LIMIT 20")->result();
        echo $this->load->view("content/dashboard/dokspjm", $data);
    }
    public function dokmanual()
    {
        $data['log_data'] = $this->db->query("SELECT a.*,b.NO_DOK_INOUT FROM solver_req_dokumen_log a LEFT JOIN t_permit_hdr b ON a.no_dok = b.NO_DOK_INOUT  WHERE a.tipe = 'manual' ORDER BY a.id DESC LIMIT 20")->result();;
        echo $this->load->view("content/dashboard/dokmanual", $data);
    }
    public function doksppb()
    {
        $data['log_data'] = $this->db->query("SELECT a.*,b.NO_DOK_INOUT FROM solver_req_dokumen_log a LEFT JOIN t_permit_hdr b ON a.no_dok = b.NO_DOK_INOUT  WHERE a.tipe = 'sppb' ORDER BY a.id DESC LIMIT 20")->result();;
        echo $this->load->view("content/dashboard/doksppb", $data);
    }

    public function requestdokumen()
    {
        $type = $this->input->post('type');
        $no_dok = preg_replace('/\s+/', '', $this->input->post('nodok'));
        $nomanual = preg_replace('/\s+/', '', $this->input->post('noman'));
        $tgl_dok = preg_replace("/[^a-zA-Z0-9]+/", "", $this->input->post('tgldok'));
        $npwp = preg_replace("/[^a-zA-Z0-9]+/", "", $this->input->post('npwp'));

        if ($type != '') {

            if ($type == 'sppb') {
                $url = "10.1.5.130/TPSServices/WsGetImpor_Sppb_NPCT1.php?NO_SPPB=$no_dok&TGL_SPPB=$tgl_dok&NPWP=$npwp";
            } elseif ($type == 'manual') {
                $url = "10.1.5.130/TPSServices/WsGetDokumenManual_NPCT1.php?KD_DOK=$nomanual&NO_SPPB=$no_dok&TGL_SPPB=$tgl_dok";
            } elseif ($type == 'spjm') {
                $url = "10.1.5.130/TPSServices/WsGetSPJM_NPCT1.php?NO_PIB=$no_dok&TGL_PIB=$tgl_dok";
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

    public function updatecode()
    {
        $data['code'] = $this->db->query("SELECT * FROM solver_kode_billing  ORDER BY id DESC LIMIT 10")->result();
        echo $this->load->view("content/dashboard/updatecode", $data);
    }

    public function ubahcode()
    {
        //var_dump($_SESSION['USERLOGIN']);die();
        if ($_POST['password'] == '123') {
            $jns = $this->input->post('jenis');

            $this->session->set_flashdata('msg', 'Ubah Kode sukses');
            $num = rand(100, 106);
            $us = $_SESSION['USERLOGIN'];
            $this->db->query("INSERT INTO solver_kode_billing (`jenis`, `kode`, `user_update`) VALUES ('$jns', '$num', '$us')");
        } else {
            $this->session->set_flashdata('msg', 'Password yang Anda Masukan Salah');
        }

        redirect("/PortalDashboard/updatecode");
    }

    public function inforeefer()
    {
        $data['ca'] = $this->db->query("SELECT DISTINCT B.NO_CONT
        FROM t_spk A INNER JOIN t_spk_cont B ON A.ID = B.ID INNER JOIN t_request C ON A.NO_DOK = C.NO_DOK AND A.TGL_DOK = C.TGL_DOK
        INNER JOIN t_request_cont D ON B.NO_CONT =  D.NO_CONT 
        WHERE D.TIPE_CONT = 'RFR' AND B.STATUS_CONT NOT IN (900,950)")->num_rows();

        $data['slot'] = $this->db->query("SELECT kode FROM solver_kode_billing WHERE jenis = 'RFR'")->row()->kode;

        echo $this->load->view("content/dashboard/inforeefer", $data);
    }

    public function stackingkontainer()
    {
        $data['cocos'] = $this->db->query("SELECT * from t_cocostshdr order by id desc limit 1000")->result();
        echo $this->load->view("content/dashboard/stackingcont", $data);
    }

    public function pindahcocos()
    {
        $vesel = $this->input->post('vesel');
        $voy = $this->input->post('voy');
        $id = $this->input->post('id');

        $where = "vessel = '$vesel' and voy_in = '$voy'";
        $idcocos = $id;
        $a = $this->db->query("SELECT * FROM t_request_cont WHERE $where");
        foreach ($a->result() as $key => $value) {
            if ($value->UKR_CONT == '') {
                $UKR_CONT = NULL;
            } else {
                $UKR_CONT = $value->UKR_CONT;
            }
            if ($value->KD_CONT_JENIS == '') {
                $KD_CONT_JENIS = NULL;
            } else {
                $KD_CONT_JENIS = $value->KD_CONT_JENIS;
            }
            if ($value->ISO_CODE == '') {
                $ISO_CODE = NULL;
            } else {
                $ISO_CODE = $value->ISO_CODE;
            }
            if ($value->TIPE_CONT == '') {
                $TIPE_CONT = NULL;
            } else {
                $TIPE_CONT = $value->TIPE_CONT;
            }
            if ($value->BRUTO == '') {
                $BRUTO = 0;
            } else {
                $BRUTO = $value->BRUTO;
            }
            $b = $this->db->query("SELECT ID,NO_CONT from t_cocostscont where NO_CONT = '$value->NO_CONT' and ID = '$idcocos'")->num_rows();
            if ($b == 0) {
                $this->db->query("INSERT INTO `t_cocostscont` (`ID`, `NO_CONT`, `UK_CONT`, `JNS_CONT`, `ISO_CODE`, `TEMPERATURE`, `KD_CONT_TIPE`, `BRUTO`, `NO_SEGEL`, `NO_BL_AWB`, `TGL_BL_AWB`, `NO_MASTER_BL_AWB`, `TGL_MASTER_BL_AWB`, `NO_BC11`, `TGL_BC11`, `NO_POS_BC11`, `ID_CONSIGNEE`, `CONSIGNEE`, `KD_TIMBUN`, `PEL_MUAT`, `PEL_TRANSIT`, `PEL_BONGKAR`, `KD_DOK_IN`, `NO_DOK_IN`, `TGL_DOK_IN`, `WK_IN`, `FL_CONT_KOSONG_IN`, `KD_SARANA_ANGKUT_IN`, `NO_POL_IN`, `GUDANG_TUJUAN_IN`, `NO_DAFTAR_PABEAN_IN`, `TGL_DAFTAR_PABEAN_IN`, `NO_SEGEL_BC_IN`, `TGL_SEGEL_BC_IN`, `NO_IJIN_TPS_IN`, `TGL_IJIN_TPS_IN`, `KODE_KANTOR_IN`, `KD_DOK_OUT`, `NO_DOK_OUT`, `TGL_DOK_OUT`, `WK_OUT`, `FL_CONT_KOSONG_OUT`, `KD_SARANA_ANGKUT_OUT`, `NO_POL_OUT`, `GUDANG_TUJUAN_OUT`, `NO_DAFTAR_PABEAN_OUT`, `TGL_DAFTAR_PABEAN_OUT`, `NO_SEGEL_BC_OUT`, `TGL_SEGEL_BC_OUT`, `NO_IJIN_TPS_OUT`, `TGL_IJIN_TPS_OUT`, `KODE_KANTOR_OUT`, `WK_REKAM`, `FL_BILLING`) VALUES ($idcocos, '$value->NO_CONT', '$UKR_CONT', '$KD_CONT_JENIS', '$ISO_CODE', NULL, '$TIPE_CONT', $BRUTO, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IDJKT', NULL, NULL, NULL, '$value->DISCHARGE', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$date', 'N')");
                echo $value->NO_CONT . " --- terkirim <br>";
            } else {
                echo $value->NO_CONT . " --- Sudah Ada <br>";
            }
        }
    }

    public function getrespononrequest()
    {
        $data['log_data'] = $this->db->query("SELECT a.*,b.LNSW_NOAJU FROM solver_req_dokumen_log a
        left join t_ppk_hdr b on a.no_dok = b.LNSW_NOAJU
        where a.tipe = 'JI' ORDER BY a.id DESC LIMIT 10")->result();;
        echo $this->load->view("content/dashboard/dokji", $data);
    }

    public function pickup()
    {
        if (!$this->session->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $data['title'] = 'MENU HANDHELD';
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nomerspk', 'NO SPK', 'required');
        if ($this->form_validation->run() === false) {
            $data['code'] = $this->db->query("SELECT ts.NO_SPK, tsc.NO_CONT, ts.NO_DOK, ts.TGL_DOK, ru.NAMA as OPERATOR, tsc.WK_UPDATE from t_spk ts 
            inner join t_spk_cont tsc on ts.ID = tsc.ID
            left join reff_user ru on ru.USER_NAME = tsc.OPERATOR 
            where year(tsc.WK_UPDATE ) >= 2020 and tsc.FL_UPDATE in ('Y') order by tsc.WK_UPDATE desc")->result();
            echo $this->load->view('content/dashboard/pickup', $data);
        } else {
            $this->M_operationn->set_pickup();
        }
    }

    public function search_pickup()
    {

        $data['menuu'] = 'HANDHELD';
        $ss = date('y');
        $keyword    =  strtoupper(str_replace(' ', '', $this->input->post('search_spk')));
        $keyword1    =  strtoupper(str_replace(' ', '', $this->input->post('search_spk')));

        if (substr($keyword, 1, 3) != 'MTI') {
            $keyword    =  "MTI-" . $ss . "/" . $this->input->post('search_spk');
            $keyword1    =  "ITPK-" . $ss . "/" . $this->input->post('search_spk');
        } else {
            $keyword    =  strtoupper(str_replace(' ', '', $this->input->post('search_spk')));
            $keyword1    =  strtoupper(str_replace(' ', '', $this->input->post('search_spk')));
        }
        $this->load->model('M_operationn');
        $re  =   $this->M_operationn->cek_tspk3($keyword, $keyword1);
        $spk = $this->M_operationn->searchco($re['ID']);
        $kondis = $this->M_operationn->ambiltruck();

        if (count($spk) == 0) {
            $data['status'] = 0;
            $data['spk'] = $keyword;
            $data['kode'] = 1;
            $data['code'] = $this->db->query("SELECT ts.NO_SPK, tsc.NO_CONT, ts.NO_DOK, ts.TGL_DOK, ru.NAMA as OPERATOR, tsc.WK_UPDATE from t_spk ts 
            inner join t_spk_cont tsc on ts.ID = tsc.ID
            left join reff_user ru on ru.USER_NAME = tsc.OPERATOR 
            where year(tsc.WK_UPDATE ) >= 2020 and tsc.FL_UPDATE in ('Y') order by tsc.WK_UPDATE desc")->result();
            echo $this->load->view('content/dashboard/pickup', $data);
        } else {
            $data['nilai'] = $spk;
            $data['totale'] = count($spk);
            $data['status'] = 1;
            $data['kondisi'] = $kondis;
            $data['spk'] = $keyword;
            $data['code'] = $this->db->query("SELECT ts.NO_SPK, tsc.NO_CONT, ts.NO_DOK, ts.TGL_DOK, ru.NAMA as OPERATOR, tsc.WK_UPDATE from t_spk ts 
            inner join t_spk_cont tsc on ts.ID = tsc.ID
            left join reff_user ru on ru.USER_NAME = tsc.OPERATOR 
            where year(tsc.WK_UPDATE ) >= 2020 and tsc.FL_UPDATE in ('Y') order by tsc.WK_UPDATE desc")->result();
            echo $this->load->view('content/dashboard/pickup', $data);
        }
    }

    public function kirimnpct1()
    {
        //echo var_dump($_POST);die();
        //var_dump($_SESSION['USERLOGIN']);die();
        $OPERATOR = $_SESSION['USERLOGIN'];
        $cont = $this->input->post('container');
        $plat = $this->input->post('no_plat');
        $this->load->model('Requestgatepass');
        $plat = ltrim($plat);
        $plat = rtrim($plat);

        //$this->db->query("UPDATE t_spk_cont SET ID_FLAT='' WHERE ID= AND NO_CONT=''");

        $datacont = $this->db->query("SELECT A.NO_DOK,A.NO_SPK,A.TGL_DOK,A.NO_CONT,'$plat' as ID_FLAT,B.TAR,B.TIPE_CONT,B.KD_CONT_JENIS,B.VESSEL,B.VOY_IN,B.ISO_CODE,C.NO_PLAT,C.BERAT_TRUCK,B.BRUTO,B.FL_DG,B.FL_OOG FROM(
            SELECT a.NO_DOK,a.TGL_DOK,a.NO_SPK,b.NO_CONT,b.ID_FLAT,b.ISO_CODE FROM t_spk a JOIN t_spk_cont b ON a.ID = b.ID  AND YEAR(a.TGL_DOK)=YEAR(NOW())) A
         JOIN (
            SELECT c.NO_DOK,c.TGL_DOK,d.NO_CONT,d.TAR,d.TIPE_CONT,d.KD_CONT_JENIS,d.VESSEL,d.VOY_IN,d.ISO_CODE,d.BRUTO,d.FL_DG,d.FL_OOG FROM t_request c JOIN t_request_cont d ON c.ID = d.ID) B ON  A.no_dok = B.no_dok AND A.NO_CONT = B.NO_CONT
         LEFT JOIN reff_truck C ON '$plat' = C.NO_TRUCK
		 WHERE A.NO_CONT = '$cont' ORDER BY A.TGL_DOK desc")->row();



        //$data1 = $this->Requestgatepass->message2a($datacont);

        $cek1 = $this->db->query("select a.no_cont, max(a.raw_response) as raw_response from log_integrasi_behandle a where a.no_cont ='$cont' and a.type in ('message2b') order by a.no_cont desc limit 1")->result();

        foreach ($cek1 as $key => $value) {
            $raw_response = $value->raw_response;
            $no_cont = $value->no_cont;
        }
        $r = json_encode($raw_response);
        //echo $no_cont;
        //var_dump($r);die();
        //$data2 = $this->Requestgatepass->message2b($datacont);

        //$data3 = json_encode($data1);di
        //  $data3 = $this->Requestgatepass->message3a($datacont);
        //  $data4 = $this->Requestgatepass->message3b($datacont);
        // echo $data1->status;
        // echo $data2->TruckEvent->TruckCall->AppStatus;
        // echo $data3->message;
        // echo $data4->TruckEvent->TruckCall->AppStatus;

        $mes = '';
        if (true) {
            //$data3 = $this->Requestgatepass->message3a($datacont);
            if (true) {
                //$data4 = $this->Requestgatepass->message3b($datacont);
                if (preg_match("/NOK/i", $r)) {
                    $stat = 'success';
                    $this->db->query("UPDATE `t_spk_cont` SET `FL_SEND_NPCT1`='Y' WHERE NO_CONT = '$cont' AND status_cont = '100'");
                    $this->db->query("UPDATE `t_spk_cont` SET `FL_UPDATE`='Y' WHERE `NO_CONT`='$cont' AND status_cont = '100'");
                    $this->db->query("UPDATE `t_spk_cont` SET `OPERATOR`='$OPERATOR' WHERE `NO_CONT`='$cont' AND status_cont = '100'");
                    $this->db->query("UPDATE `t_spk_cont` SET `ID_FLAT`='$plat' WHERE `NO_CONT`='$cont' AND status_cont = '100'");
                } else {
                    $stat = 'Error';
                    $mes = 'error3';
                }
            } else {
                $stat = 'Error';
                $mes = 'error2';
            }
        } else {
            $stat = 'Error';
            $mes = 'error1';
        }
        $data['cont'] =  $datacont;
        $data['message'] = $mes;
        $data['status'] = $stat;
        echo json_encode($data);
    }



    public function human_error()
    {
        if (!$this->session->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $data['title'] = 'Portal Dashboard';
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nomerspk', 'NO SPK', 'required');
        if ($this->form_validation->run() === false) {
            $data['code'] = $this->db->query("SELECT distinct ts.NO_SPK, ts.NO_CONT, ru.NAMA as OPERATOR_UPDATE, ts.WK_UPDATE from t_op_reefer ts 
            left join reff_user ru on ru.USER_NAME = ts.OPERATOR_UPDATE 
            where year(ts.WK_UPDATE) >= 2020 and ts.FL_UPDATE_UNPLUG in ('Y') group by ts.NO_CONT order by ts.WK_UPDATE DESC")->result();
            echo $this->load->view('content/dashboard/human_error', $data);
        } else {
            echo "gagal";
        }
    }

    public function search_container()
    {

        $data['menuu'] = 'HANDHELD';
        $ss = date('y');
        $keyword    =  strtoupper(str_replace(' ', '', $this->input->post('search_spk')));
        $keyword1    =  strtoupper(str_replace(' ', '', $this->input->post('search_spk')));

        if (substr($keyword, 1, 3) != 'MTI') {
            $keyword    =  "MTI-" . $ss . "/" . $this->input->post('search_spk');
            $keyword1    =  "ITPK-" . $ss . "/" . $this->input->post('search_spk');
        } else {
            $keyword    =  strtoupper(str_replace(' ', '', $this->input->post('search_spk')));
            $keyword1    =  strtoupper(str_replace(' ', '', $this->input->post('search_spk')));
        }
        $this->load->model('M_operationn');
        $re  =   $this->M_operationn->cek_tspk4($keyword, $keyword1);
        $spk = $this->M_operationn->searchcon($re['ID']);

        if (count($spk) == 0) {
            $data['status'] = 0;
            $data['spk'] = $keyword;
            $data['kode'] = 1;
            $data['code'] = $this->db->query("SELECT distinct ts.NO_SPK, ts.NO_CONT, ru.NAMA as OPERATOR_UPDATE, ts.WK_UPDATE from t_op_reefer ts 
            left join reff_user ru on ru.USER_NAME = ts.OPERATOR_UPDATE 
            where year(ts.WK_UPDATE) >= 2020 and ts.FL_UPDATE_UNPLUG in ('Y') group by ts.NO_CONT order by ts.WK_UPDATE DESC")->result();
            echo $this->load->view('content/dashboard/human_error', $data);
        } else {
            $data['nilai'] = $spk;
            $data['totale'] = count($spk);
            $data['status'] = 1;
            $data['spk'] = $keyword;
            $data['code'] = $this->db->query("SELECT distinct ts.NO_SPK, ts.NO_CONT, ru.NAMA as OPERATOR_UPDATE, ts.WK_UPDATE from t_op_reefer ts 
            left join reff_user ru on ru.USER_NAME = ts.OPERATOR_UPDATE 
            where year(ts.WK_UPDATE) >= 2020 and ts.FL_UPDATE_UNPLUG in ('Y') group by ts.NO_CONT order by ts.WK_UPDATE DESC")->result();
            echo $this->load->view('content/dashboard/human_error', $data);
        }
    }


    public function ubahunplug()
    {
        //echo var_dump($_POST);die();
        //var_dump($_SESSION['USERLOGIN']);die();
        $OPERATOR = $_SESSION['USERLOGIN'];
        //$nospk = $this->input->post('nospk');
        $cont = $this->input->post('container');
        //$plat = $this->input->post('no_plat');
        $this->load->model('Requestgatepass');
        // $plat = ltrim($plat);
        // $plat = rtrim($plat);

        //$this->db->query("UPDATE t_spk_cont SET ID_FLAT='' WHERE ID= AND NO_CONT=''");

        // $datacont = $this->db->query("SELECT A.NO_DOK,A.NO_SPK,A.TGL_DOK,A.NO_CONT,'$plat' as ID_FLAT,B.TAR,B.TIPE_CONT,B.KD_CONT_JENIS,B.VESSEL,B.VOY_IN,B.ISO_CODE,C.NO_PLAT,C.BERAT_TRUCK,B.BRUTO,B.FL_DG,B.FL_OOG FROM(
        //     SELECT a.NO_DOK,a.TGL_DOK,a.NO_SPK,b.NO_CONT,b.ID_FLAT,b.ISO_CODE FROM t_spk a JOIN t_spk_cont b ON a.ID = b.ID  AND YEAR(a.TGL_DOK)=YEAR(NOW())) A
        //  JOIN (
        //     SELECT c.NO_DOK,c.TGL_DOK,d.NO_CONT,d.TAR,d.TIPE_CONT,d.KD_CONT_JENIS,d.VESSEL,d.VOY_IN,d.ISO_CODE,d.BRUTO,d.FL_DG,d.FL_OOG FROM t_request c JOIN t_request_cont d ON c.ID = d.ID) B ON  A.no_dok = B.no_dok AND A.NO_CONT = B.NO_CONT
        //  LEFT JOIN reff_truck C ON '$plat' = C.NO_TRUCK
        //  WHERE A.NO_CONT = '$cont' ORDER BY A.TGL_DOK desc")->row();



        //$data1 = $this->Requestgatepass->message2a($datacont);

        //  $cek1 = $this->db->query("select a.no_cont, a.raw_response as raw_response from log_integrasi_behandle a where a.no_cont ='$cont' order by a.no_cont desc limit 1")->result();

        //  foreach($cek1 as $key=>$value){
        //   $raw_response = $value->raw_response;
        //   $no_cont= $value->no_cont;
        //  }
        //  $r = json_encode($raw_response);
        //  //echo $no_cont;
        //  var_dump($r);die();
        //$data2 = $this->Requestgatepass->message2b($datacont);

        //$data3 = json_encode($data1);di
        //  $data3 = $this->Requestgatepass->message3a($datacont);
        //  $data4 = $this->Requestgatepass->message3b($datacont);
        // echo $data1->status;
        // echo $data2->TruckEvent->TruckCall->AppStatus;
        // echo $data3->message;
        // echo $data4->TruckEvent->TruckCall->AppStatus;

        $mes = '';
        if (true) {
            //$data3 = $this->Requestgatepass->message3a($datacont);
            if (true) {
                //$data4 = $this->Requestgatepass->message3b($datacont);
                if (true) {
                    $stat = 'success';
                    $this->db->query("UPDATE `t_op_reefer` SET `FL_UNPLUG`='N' WHERE `NO_CONT`='$cont'");
                    $this->db->query("UPDATE `t_op_reefer` SET `FL_UPDATE_UNPLUG`='Y' WHERE `NO_CONT`='$cont'");
                    $this->db->query("UPDATE `t_op_reefer` SET `OPERATOR_UPDATE`='$OPERATOR' WHERE `NO_CONT`='$cont'");
                    $this->db->query("UPDATE `t_op_reefer` SET `WAKTU_END`=null WHERE `NO_CONT`='$cont'");
                } else {
                    $stat = 'Error';
                    $mes = 'error3';
                }
            } else {
                $stat = 'Error';
                $mes = 'error2';
            }
        } else {
            $stat = 'Error';
            $mes = 'error1';
        }
        $data['cont'] =  $datacont;
        $data['message'] = $mes;
        $data['status'] = $stat;
        echo json_encode($data);
    }

    public function jionrequest()
    {
        //echo json_encode($_POST);
        $noaju = $this->input->post('noaju');
        $tglaju = $this->input->post('tglaju');
        $nodok = $this->input->post('nodok');
        $tgldok = $this->input->post('tgldok');
        $jenis = $this->input->post('jnsdok');

        // $q0 = $this->db->query("select a.LNSW_TGLAJU from t_ppk_hdr a where a.LNSW_NOAJU = '$noaju'")->num_rows();

        // if ($q0 > 0) {
        //     redirect('PortalDashboard/getrespononrequest?err=dokada');
        // }
        // echo '$noaju-'.$noaju."<br>";
        // echo '$tglaju-'.$tglaju."<br>";
        // echo '$nodok-'.$nodok."<br>";
        // echo '$tgldok-'.$tgldok."<br>";
        // echo '$jenis-'.$jenis."<br>";
        // die();
        $xml = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.insw.go.id/">
        <soapenv:Header/>
        <soapenv:Body>
           <ser:getContainerPeriksaOnRequest soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
              <username xsi:type="xsd:string">wsnpct1</username>
              <password xsi:type="xsd:string">pass123abc</password>
              <instansi xsi:type="xsd:string">NPCT1</instansi>
              <no_aju xsi:type="xsd:string">' . $noaju . '</no_aju>
              <tgl_aju xsi:type="xsd:string">' . $tglaju . '</tgl_aju>
              <no_dok xsi:type="xsd:string">' . $nodok . '</no_dok>
              <tgl_dok xsi:type="xsd:string">' . $tgldok . '</tgl_dok>
              <jns_dok xsi:type="xsd:string">' . $jenis . '</jns_dok>
           </ser:getContainerPeriksaOnRequest>
        </soapenv:Body>
     </soapenv:Envelope>';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://10.1.6.206/SSMJIQC/server_insw.php');
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-type: text/xml',
            'Content-length: ' . strlen($xml)
        ));
        $curl1_response = curl_exec($ch);
        if (!curl_errno($ch)) {
            echo "Connection Success , Message from Curl : " . curl_getinfo($ch) . "\r\n";
            echo "Get Data XML .... \r\n";
            $response = $this->db->escape($curl1_response);
            //echo json_encode($response);
            //$response = $this->db->escape($curl1_response);

        } else {
            echo "Connection Failed =" . curl_error($ch);
            die();
        }

        if (preg_match("/{$noaju}/i", $response)) {
            $response =  str_replace('GETCONTAINERPERIKSAONREQUEST', 'GETCONTAINERPERIKSA', $response);
            $sukses = 'SUKSES';
            $insert = $this->db->query("INSERT INTO `t_log_lnsw` (`typelog`, `raw_request`, `raw_respon`) VALUES ('getdokonrespon', '$xml', $response)");
        } else {
            $sukses = 'DATA TIDAK DITEMUKAN';
        }
        $output = $nodok . '#' . $tgldok . '#' . $jenis;
        if ($insert) {
            $this->db->query("INSERT INTO `tpk_ipc`.`solver_req_dokumen_log` (`url`, `tipe`, `no_dok`, `tgl_dok`, `npwp`, `data_respons`, `tambahan`) VALUES ('http://10.1.6.206/SSMJIQC/server_insw.php', 'JI', '$noaju', '$tglaju', NULL, '$sukses', '$output')");
        } else {
            $this->db->query("INSERT INTO `tpk_ipc`.`solver_req_dokumen_log` (`url`, `tipe`, `no_dok`, `tgl_dok`, `npwp`, `data_respons`, `tambahan`) VALUES ('http://10.1.6.206/SSMJIQC/server_insw.php', 'JI', '$noaju', '$tglaju', NULL, '$sukses', '$output')");
        }
        redirect('PortalDashboard/getrespononrequest');
    }

    public function manualbiling()
    {
        $us = $_SESSION['USERLOGIN'];
        $data['search'] = NULL;
        $data['radio'] = '';
        $data['msg'] = '';
        $data['message'] = '';
        $se = $this->input->post('idreq');
        $req = $this->input->post('optradio');
        $sub = $this->input->post('sub');
        $pass = $this->input->post('pass');
        $idbank = $this->input->post('idbank');
        if ($se != '') {
            if ($sub == 1) {
                if ($pass == 'mti2020') {
                    $data['msg'] = '1';
                    if ($req == 'behandle') {

                        $ID_REQ = $se;
                        $ID_BANK = $idbank;
                        $SQL = $this->db->query("SELECT NO_NOTA_BEHANDLE AS NO_NOTA FROM req_behandle_hdr WHERE ID_REQ = '$ID_REQ'")->row();
                        if ($SQL->NO_NOTA != null) {
                            // UPDATE DATA BANK
                            $data['msg'] = '0';
                            $data['message'] = 'Invoice sudah jadi nota';
                        } else {
                            $NOTA = $this->db->query("SELECT LPAD(SEQUENCE+1,'6','0') SEQ, (SEQUENCE+1) SEQUE FROM m_generate_nota WHERE TYPE_NOTA = 'FAKTUR'")->row_array();
                            $FAKTUR = $this->db->query("SELECT LPAD(SEQUENCE+1,'8','0') SEQ, (SEQUENCE+1) SEQUE FROM m_generate_nota WHERE TYPE_NOTA = 'FAKTUR'")->row_array();

                            // VARIABEL
                            $YEAR = substr(date('Y'), 2);
                            $VAR['NO_FAKTUR'] = '010.031.' . $YEAR . '.' . $FAKTUR['SEQ'];
                            $VAR['NO_NOTA_BEHANDLE'] = '31.' . date('Y') . '.' . $NOTA['SEQ'];
                            $VAR['TGL_FAKTUR'] = date('Y-m-d H:i:s');
                            $VAR['TGL_NOTA'] = date('Y-m-d H:i:s');
                            $VAR['BANK_ID'] = $ID_BANK;

                            $this->db->where(array('ID_REQ' => $ID_REQ));
                            $EXCT = $this->db->update('req_behandle_hdr', $VAR);

                            // UPDATE SEQUENCE
                            $this->db->where('TYPE_NOTA', 'FAKTUR');
                            $this->db->update('m_generate_nota', array('SEQUENCE' => $FAKTUR['SEQUE']));

                            if (!$EXCT) {
                                $data['msg'] = '0';
                                $data['message'] = 'Gagal';
                            } else {
                                $this->db->query("INSERT INTO `portaldashboard_log` (`typelog`, `user_login`, `isi`) VALUES ('manualbilling', '$us', '$ID_REQ')");
                                $data['msg'] = '1';
                            }
                        }
                    }
                    if ($req == 'delivery') {
                        $ID_REQ = $se;

                        $ID_BANK     = $idbank;

                        $SQL = $this->db->query("SELECT NO_NOTA_DELIVERY AS NO_NOTA FROM req_delivery_hdr WHERE ID_REQ = '$ID_REQ'")->row();

                        if ($SQL->NO_NOTA != null) {
                            $data['msg'] = '0';
                            $data['message'] = 'Invoice sudah jadi nota';
                        } else {
                            $NOTA = $this->db->query("SELECT LPAD(SEQUENCE+1,'6','0') SEQ, (SEQUENCE+1) SEQUE FROM m_generate_nota WHERE TYPE_NOTA = 'FAKTUR'")->row_array();
                            $FAKTUR = $this->db->query("SELECT LPAD(SEQUENCE+1,'8','0') SEQ, (SEQUENCE+1) SEQUE FROM m_generate_nota WHERE TYPE_NOTA = 'FAKTUR'")->row_array();

                            // VARIABEL
                            $YEAR = substr(date('Y'), 2);
                            $VAR['NO_FAKTUR'] = '010.031.' . $YEAR . '.' . $FAKTUR['SEQ'];
                            $VAR['NO_NOTA_DELIVERY'] = '31.' . date('Y') . '.' . $NOTA['SEQ'];
                            $VAR['TGL_FAKTUR'] = date('Y-m-d H:i:s');
                            $VAR['TGL_NOTA'] = date('Y-m-d H:i:s');
                            $VAR['BANK_ID'] = $ID_BANK;
                            $VAR['PAID_STATUS'] = 'DONE';

                            $this->db->where(array('ID_REQ' => $ID_REQ));
                            $EXCT = $this->db->update('req_delivery_hdr', $VAR);

                            // UPDATE SEQUENCE
                            $this->db->where('TYPE_NOTA', 'FAKTUR');
                            $this->db->update('m_generate_nota', array('SEQUENCE' => $FAKTUR['SEQUE']));

                            if (!$EXCT) {
                                $data['msg'] = '0';
                                $data['message'] = 'Gagal';
                            } else {
                                $data['msg'] = '1';
                                $this->db->query("INSERT INTO `portaldashboard_log` (`typelog`, `user_login`, `isi`) VALUES ('manualbilling', '$us', '$ID_REQ')");
                            }
                        }
                        // INSERT TO GATEPASS
                        $SQL = $this->db->query("SELECT EXPIRED,NO_DOK FROM req_delivery_hdr WHERE ID_REQ = '$ID_REQ'")->row_array();
                        $EXPIRED = $SQL['EXPIRED'];
                        $NO_DOK = $SQL['NO_DOK'];

                        $this->insertGatepassDelivery($NO_DOK, $EXPIRED, $ID_REQ);
                    }
                } else {
                    $data['msg'] = '0';
                    $data['message'] = 'Password Salah';
                }
            }
            if ($req == 'delivery') {
                $data['search'] = $this->db->query("SELECT * from req_delivery_hdr where id_req = '$se' ")->row();
                $data['radio'] = 'delivery';
            } else {
                $data['search'] = $this->db->query("SELECT * from req_behandle_hdr where id_req = '$se' ")->row();
                $data['radio'] = 'behandle';
            }
        }
        //echo json_encode($data);
        echo $this->load->view("content/dashboard/manualbilling", $data);
    }

    public function insertGatepassDelivery($cek_nodok, $cek_exp, $id_req)
    {
        $SQLInsGatePAss = "SELECT A.ID, E.NAMA AS 'JNS_DOK',A.NO_DOK_INOUT,A.TGL_DOK_INOUT,'WAITING' AS 'STATUS', '3' AS JNS_KEGIATAN, G.NO_CONT,B.KD_CONT_UKURAN,A.ID_CONSIGNEE,A.CONSIGNEE,F.NM_KAPAL AS 'ANGKUTNAMA_TPS',F.NO_VOY AS 'ANGKUTNO_TPS','' AS 'EXPIRED DATE', D.NO_SPK, NOW() AS 'WK_REQ'
							FROM t_permit_hdr A
							INNER JOIN t_permit_cont B ON A.ID = B.ID
							LEFT JOIN t_spk_cont C ON B.NO_CONT=C.NO_CONT
							LEFT JOIN t_spk D ON C.ID = D.ID
							LEFT JOIN reff_kode_dok_bc E ON A.KD_DOK_INOUT = E.ID
							INNER JOIN req_delivery_hdr F ON A.NO_DOK_INOUT = F.NO_DOK
							INNER JOIN req_delivery_dtl G ON F.ID_REQ = G.ID_REQ
							WHERE  F.ID_REQ='$id_req' AND A.NO_DOK_INOUT = '$cek_nodok' AND D.NO_SPK IS NOT NULL AND G.NO_CONT IS NOT NULL
							GROUP BY G.NO_CONT";
        $result = $this->db->query($SQLInsGatePAss)->result_array();
        $totalCont = count($result);
        for ($i = 0; $i < $totalCont; $i++) {
            $SQLCekGatePass = "SELECT NO_DOK FROM t_gatepass WHERE NO_CONT='" . $result[$i]['NO_CONT'] . "' AND JNS_KEGIATAN = 3 AND NO_DOK = '" . $result[$i]['NO_DOK_INOUT'] . "' AND STATUS='WAITING'";
            $resultGatePass = $this->db->query($SQLCekGatePass)->result_array();
            if (count($resultGatePass) == 0) {
                $tmpData = array(
                    "JNS_DOK" => $result[$i]['JNS_DOK'],
                    "NO_DOK" => $result[$i]['NO_DOK_INOUT'],
                    "TGL_DOK" => $result[$i]['TGL_DOK_INOUT'],
                    "STATUS" => $result[$i]['STATUS'],
                    "JNS_KEGIATAN" => $result[$i]['JNS_KEGIATAN'],
                    "NO_CONT" => $result[$i]['NO_CONT'],
                    "UKR_CONT" => $result[$i]['KD_CONT_UKURAN'],
                    "NPWP" => $result[$i]['ID_CONSIGNEE'],
                    "NAMA_CUST" => $result[$i]['CONSIGNEE'],
                    "NM_KAPAL" => $result[$i]['ANGKUTNAMA_TPS'],
                    "NO_VOY" => $result[$i]['ANGKUTNO_TPS'],
                    "EXPIRED_DATE" => $cek_exp,
                    "NO_SPK" => $result[$i]['NO_SPK'],
                    "WK_REK" => date('Y-m-d H:i:s')
                );
                $this->db->insert('t_gatepass', $tmpData);
            } else {
                $tmpData = array(
                    "JNS_DOK" => $result[$i]['JNS_DOK'],
                    "NO_DOK" => $result[$i]['NO_DOK_INOUT'],
                    "TGL_DOK" => $result[$i]['TGL_DOK_INOUT'],
                    "STATUS" => $result[$i]['STATUS'],
                    "JNS_KEGIATAN" => $result[$i]['JNS_KEGIATAN'],
                    "NO_CONT" => $result[$i]['NO_CONT'],
                    "UKR_CONT" => $result[$i]['KD_CONT_UKURAN'],
                    "NPWP" => $result[$i]['ID_CONSIGNEE'],
                    "NAMA_CUST" => $result[$i]['CONSIGNEE'],
                    "NM_KAPAL" => $result[$i]['ANGKUTNAMA_TPS'],
                    "NO_VOY" => $result[$i]['ANGKUTNO_TPS'],
                    "EXPIRED_DATE" => $cek_exp,
                    "NO_SPK" => $result[$i]['NO_SPK'],
                    "WK_REK" => date('Y-m-d H:i:s')
                );
                $this->db->where(array('ID' => $result[$i]['ID'], 'NO_CONT' => $result[$i]['NO_CONT']));
                $this->db->update('t_gatepass', $tmpData);
            }
            $this->db->where(array('ID' => $result[$i]['ID'], 'NO_CONT' => $result[$i]['NO_CONT']));
            $this->db->update('t_permit_cont', array('FL_GATEPASS' => 'Y'));
        }
    }

    public function updatecoari()
    {
        $dok = $this->input->get('nodok');
        $tgl = $this->input->get('tgldok');

        $tgl = date_format(new DateTime($tgl), 'Y-m-d');

        $data['datser'] = array('nod' => '', 'tgl' => '');
        if ($dok == '' or $tgl == '') {
            $data['search'] = NULL;
        } else {
            $data['datser'] = array('nod' => $dok, 'tgl' => $tgl);
            $data['search'] = $this->db->query("SELECT a.NO_DOK,a.TGL_DOK,b.* FROM t_request a JOIN t_request_cont b ON a.ID = b.ID WHERE a.NO_DOK = '$dok' AND a.TGL_DOK = '$tgl' and b.kd_status ='INQUIRY'")->result();
            // var_dump($data['search']);die();
            // $data['search'] = $this->db->query("SELECT a.NO_DOK,a.TGL_DOK,b.* FROM t_request a 
            // JOIN t_request_cont b ON a.ID = b.ID 
            // JOIN t_spk c ON a.NO_DOK = c.NO_DOK AND c.TGL_SPK = a.TGL_DOK
            // JOIN t_spk_cont d ON c.ID = d.ID AND b.NO_CONT = d.NO_CONT
            // WHERE a.NO_DOK = '$dok' AND d.STATUS_CONT != '900' AND a.TGL_DOK = '$tgl'")->result();
        }


        echo $this->load->view("content/dashboard/updatecoary", $data);
    }
    public function upcoari()
    {

        $id = $this->input->get('id');
        $co = $this->input->get('cont');
        $dok = $this->input->get('nodok');
        $tgl = $this->input->get('tgldok');

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

        $xml = simplexml_load_string($response);
        header('content-Type: application/json');
        $xml = simplexml_load_string($xml);
        $dat = json_encode($xml);

        // var_dump($dat);die();

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
        WHERE ID = '$id' AND NO_CONT = '$co'";
        if ($slice != '') {

            $this->db->query($stringq);
            $msg = array('msg' => 'Update Berhasil', 'stat' => '1', 'dok' => $dok, 'tgl' => $tgl);
            $this->session->set_flashdata('msg', $msg);
            $us = $_SESSION['USERLOGIN'];
            $this->db->query("INSERT INTO `portaldashboard_log` (`typelog`, `user_login`, `isi`) VALUES ('UpdateCont', '$us', '$co')");
        } else {
            $msg = array('msg' => 'Update Gagal', 'stat' => '2', 'dok' => $dok, 'tgl' => $tgl);
            $this->session->set_flashdata('msg', $msg);
        }

        redirect("/PortalDashboard/updatecoari?nodok=$dok&tgldok=$tgl");
    }
    public function plugerror()
    {
        $cont = $this->input->get('cont');


        $data['datser'] = array('cont' => '');
        if ($cont == '') {
            $data['search'] = NULL;
        } else {
            $data['datser'] = array('cont' => $cont);
            $data['search'] = $this->db->query("SELECT * from t_request_cont trc where trc.NO_CONT = '$cont' order by trc.id DESC")->result();
            // var_dump($data['search']);die();
            // $data['search'] = $this->db->query("SELECT a.NO_DOK,a.TGL_DOK,b.* FROM t_request a 
            // JOIN t_request_cont b ON a.ID = b.ID 
            // JOIN t_spk c ON a.NO_DOK = c.NO_DOK AND c.TGL_SPK = a.TGL_DOK
            // JOIN t_spk_cont d ON c.ID = d.ID AND b.NO_CONT = d.NO_CONT
            // WHERE a.NO_DOK = '$dok' AND d.STATUS_CONT != '900' AND a.TGL_DOK = '$tgl'")->result();
        }


        echo $this->load->view("content/dashboard/plugerror", $data);
    }
    public function fixplugerror()
    {

        $id = $this->input->post('id');
        $cont = $this->input->post('no_cont');
        $plug = date_format(date_create($this->input->post('tgl_plug')), "Y-m-d H:i:s");
        $temper = $this->input->post('temper');

        $temp = $this->db->query("SELECT TEMPERATURE from t_cocostscont tc where tc.NO_CONT = '$cont' order by WK_REKAM desc LIMIT 1")->row_array();
        $tempratur = $temp['TEMPERATURE'];
        // $waktu = date("Y-m-d h:i:s");


        if ($temper == '' || $temper == null)
            $this->db->query("UPDATE `t_request_cont` SET `DISCHARGE`= '$plug', TEMP_CUST = '$tempratur', TEMP_TERMINAL = '$tempratur', PLUG_TERMINAL = '$plug', UNPLUG_TERMINAL = '$plug', FL_REEFER = 'Y' WHERE ID = '$id'");
        else
            $this->db->query("UPDATE `t_request_cont` SET `DISCHARGE`= '$plug', TEMP_CUST = '$temper', TEMP_TERMINAL = '$temper', PLUG_TERMINAL = '$plug', UNPLUG_TERMINAL = '$plug', FL_REEFER = 'Y' WHERE ID = '$id'");
    }
}
