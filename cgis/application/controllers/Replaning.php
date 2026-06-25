<?php defined('BASEPATH') or exit('No direct script access allowed');

class Replaning extends CI_Controller
{
    public $content;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_operation');
    }

    public function index()
    {
        $headers .= '<link rel="apple-touch-icon" href="' . base_url() . 'assets/images/apple-touch-icon.png">';
        #Stylesheetss
        $headers  = '<link rel="stylesheet" href="' . base_url() . 'assets/css/bootstrap.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/css/bootstrap-extend.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/css/site.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/jquery-ui/jquery-ui.min.css?v2.1.0">';
        #Plugins For This Page
        $headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/filament-tablesaw/tablesaw.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/uikit/modals.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/jquery-wizard/jquery-wizard.min.css?v2.1.0">';
        #Plugins
        $headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/animsition/animsition.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/asscrollable/asScrollable.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/switchery/switchery.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/intro-js/introjs.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/slidepanel/slidePanel.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/waves/waves.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/sweetalert/sweetalert.css">';
        $headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/themes/twitter.css">';
        $headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/css/newtable.css">';
        $headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/toastr/toastr.min.css">';
        #Fonts
        $headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/fonts/material-design/material-design.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/fonts/brand-icons/brand-icons.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/fonts/font.css?v2.1.0">';
        #Scripts
        $headers .= '<script src="' . base_url() . 'assets/js/jquery.min.js"></script>';
        $headers .= '<script src="' . base_url() . 'assets/js/alerts.js"></script>';
        $headers .= '<script src="' . base_url() . 'assets/vendor/modernizr/modernizr.min.js"></script>';
        $headers .= '<script src="' . base_url() . 'assets/vendor/breakpoints/breakpoints.min.js"></script>';
        $headers .= '<script>Breakpoints();</script>';
        #Core
        $footers  = '<script src="' . base_url() . 'assets/vendor/jquery/jquery.min.js"></script>';
        $footers .= '<script src="' . base_url() . 'assets/vendor/jquery-ui/jquery-ui.min.js"></script>';
        $footers .= '<script src="' . base_url() . 'assets/vendor/bootstrap/bootstrap.js"></script>';
        $footers .= '<script src="' . base_url() . 'assets/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.js"></script>';
        $footers .= '<script src="' . base_url() . 'assets/vendor/animsition/animsition.min.js"></script>';
        $footers .= '<script src="' . base_url() . 'assets/vendor/asscroll/jquery-asScroll.min.js"></script>';
        $footers .= '<script src="' . base_url() . 'assets/vendor/mousewheel/jquery.mousewheel.min.js"></script>';
        $footers .= '<script src="' . base_url() . 'assets/vendor/asscrollable/jquery.asScrollable.all.min.js"></script>';
        $footers .= '<script src="' . base_url() . 'assets/vendor/ashoverscroll/jquery-asHoverScroll.min.js"></script>';
        $footers .= '<script src="' . base_url() . 'assets/vendor/waves/waves.min.js"></script>';
        #Plugins
        $footers .= '<script src="' . base_url() . 'assets/vendor/switchery/switchery.min.js"></script>';
        $footers .= '<script src="' . base_url() . 'assets/vendor/intro-js/intro.min.js"></script>';
        $footers .= '<script src="' . base_url() . 'assets/vendor/screenfull/screenfull.min.js"></script>';
        $footers .= '<script src="' . base_url() . 'assets/vendor/slidepanel/jquery-slidePanel.min.js"></script>';
        $footers .= '<script src="' . base_url() . 'assets/vendor/formatter-js/jquery.formatter.min.js"></script>';
        $footers .= '<script src="' . base_url() . 'assets/vendor/jquery-wizard/jquery-wizard.min.js"></script>';
        #Scripts
        $footers .= '<script src="' . base_url() . 'assets/js/core.min.js"></script>';
        $footers .= '<script src="' . base_url() . 'assets/js/site.min.js"></script>';
        $footers .= '<script src="' . base_url() . 'assets/js/sections/menu.min.js"></script>';
        $footers .= '<script src="' . base_url() . 'assets/js/sections/menubar.min.js"></script>';
        $footers .= '<script src="' . base_url() . 'assets/js/sections/gridmenu.min.js"></script>';
        $footers .= '<script src="' . base_url() . 'assets/js/sections/sidebar.min.js"></script>';
        $footers .= '<script src="' . base_url() . 'assets/js/configs/config-colors.min.js"></script>';
        $footers .= '<script src="' . base_url() . 'assets/js/components/asscrollable.min.js"></script>';
        $footers .= '<script src="' . base_url() . 'assets/js/components/animsition.min.js"></script>';
        $footers .= '<script src="' . base_url() . 'assets/js/components/slidepanel.min.js"></script>';
        $footers .= '<script src="' . base_url() . 'assets/js/components/switchery.min.js"></script>';
        $footers .= '<script src="' . base_url() . 'assets/js/newtable.js"></script>';
        $footers .= '<script src="' . base_url() . 'assets/js/main.js"></script>';
        $footers .= '<script src="' . base_url() . 'assets/vendor/sweetalert/sweetalert.min.js"></script>';
        $footers .= '<script src="' . base_url() . 'assets/vendor/filament-tablesaw/tablesaw.js"></script>';
        $footers .= '<script src="' . base_url() . 'assets/vendor/toastr/toastr.min.js"></script>';
        $footers .= '<script src="' . base_url() . 'assets/js/components/input-group-file.min.js"></script>';
        $footers .= '<script src="' . base_url() . 'assets/js/components/formatter-js.min.js"></script>';
        $footers .= '<script src="' . base_url() . 'assets/js/components/jquery-wizard.min.js"></script>';

        if ($this->session->userdata('LOGGED')) {
            if ($this->content == "") {
                redirect(site_url(), 'refresh');
            }
            $data = array(
                '_title_'       => 'BOS',
                '_headers_'       => $headers,
                '_header_'       => $this->load->view('content/header', '', true),
                '_menus_'          => $this->load->view('content/menus', '', true),
                '_breadcrumbs_' => $this->load->view('content/breadcrumbs', '', true),
                '_content_'       => (grant() == "") ? $this->load->view('content/error', '', true) : $this->content,
                '_footers_'       => $footers,
                '_footer_'       => $this->load->view('content/menus', '', true)
            );
            $this->parser->parse('index', $data);
        } else {
            redirect(base_url('index.php'), 'refresh');
        }
    }

    public function opr()
    {
        if (!$this->session->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $this->newtable->breadcrumb('Menu Handheld', site_url('operation/opr'));
        // $data['title'] = 'Menu Handheld';
        // $data['usernya'] = $this->session->userdata('KD_GROUP');
        // $data['jumlahmarshcic'] = $this->M_operation->datajumlahmarshallingcic();
        // $data['jumlahmarshyard'] = $this->M_operation->datajumlahmarshallingyard();
        // $data['jumlah'] = $this->M_operation->getalldelivery();
        $this->content = $this->load->view('content/replaning/index', $data, true);
        $this->index();
    }

    public function get_spk_for_announce()
    {
        // Ambil parameter dari POST
        $no_spk   = $this->input->post('no_spk');
        $no_cont  = $this->input->post('no_container');

        if (!$no_spk || !$no_cont) {
            $response = array(
                'status' => false,
                'message' => 'no_spk dan no_cont harus diberikan'
            );
            echo json_encode($response);
            return;
        }

        $this->db->select('A.NO_SPK, B.NO_CONT, C.KETERANGAN');
        $this->db->from('t_spk A');
        $this->db->join('t_spk_cont B', 'A.ID = B.ID');
        $this->db->join('reff_status_spk C', 'B.STATUS_CONT = C.ID');
        $this->db->where('A.NO_SPK', $no_spk);
        $this->db->where('B.NO_CONT', $no_cont);
        $this->db->where_in('B.STATUS_CONT', array(200, 510));

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $response = array(
                'status' => true,
                'data' => $query->result_array()
            );
        } else {
            $response = array(
                'status' => false,
                'message' => 'Data tidak ditemukan'
            );
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function set_announce()
    {
        // Ambil parameter dari POST
        $no_cont = $this->input->post('no_container');
        $no_spk  = $this->input->post('no_spk');

        // Validasi sederhana
        if (!$no_cont || !$no_spk) {
            echo json_encode(array(
                'status' => false,
                'message' => 'NO_CONT dan NO_SPK harus diberikan'
            ));
            return;
        }

        // Load database
        $this->load->database();
        $log = array();

        // 1. Ambil record berdasarkan NO_CONT dan NO_SPK
        $sql_select = "SELECT tr.ID as ID_T_REQUEST, ts.NO_SPK, tsc.NO_CONT, ts.NO_DOK, ts.ID as ID_SPK 
                   FROM t_spk ts 
                   JOIN t_spk_cont tsc ON ts.ID = tsc.ID 
                   JOIN t_request tr ON tr.NO_DOK = ts.NO_DOK AND tr.TGL_DOK = tr.TGL_DOK
                   WHERE tsc.NO_CONT = ? AND ts.NO_SPK = ? AND tr.TGL_DOK >= DATE_SUB(NOW(), INTERVAL 1 YEAR)";

        $query = $this->db->query($sql_select, array($no_cont, $no_spk));
        $result = $query->row();

        if ($result) {
            $log['select_query'] = 'Success';
            $id_spk = $result->ID_SPK;
            $id_t_request = $result->ID_T_REQUEST;

            // 2. Update t_spk_cont
            $sql_update_spk_cont = "UPDATE t_spk_cont 
                                SET STATUS_CONT = '100', FL_SEND_NPCT1 = 'N', ID_FLAT = NULL 
                                WHERE NO_CONT = ? AND ID = ?";
            $log['update_spk_cont'] = $this->db->query($sql_update_spk_cont, array($no_cont, $id_spk)) ? 'Success' : 'Failed';

            // 3. Delete operasi dari tabel terkait
            $tables_delete = array(
                't_operation' => array($no_cont, $id_spk),
                't_op_pickup' => array($no_cont, $id_spk),
                't_op_behandlein' => array($no_cont, $id_spk),
                't_job_slip' => array($no_cont, $id_spk, 'BEHANDLE 1')
            );

            foreach ($tables_delete as $table => $params) {
                if ($table == 't_job_slip') {
                    $sql = "DELETE FROM $table WHERE NO_CONT = ? AND NO_SPK = ? AND JENIS = ?";
                } else {
                    $sql = "DELETE FROM $table WHERE NO_CONT = ? AND NO_SPK = ?";
                }
                $log['delete_' . $table] = $this->db->query($sql, $params) ? 'Success' : 'Failed';
            }

            // 4. Update job slip untuk PICKUP
            $sql_update_job_slip = "UPDATE t_job_slip 
                                SET STATUS = 'WAITING', KD_STATUS = '10' 
                                WHERE NO_SPK = ? AND NO_CONT = ? AND JENIS = 'PICKUP'";
            $log['update_job_slip'] = $this->db->query($sql_update_job_slip, array($id_spk, $no_cont)) ? 'Success' : 'Failed';

            // 5. Update request container
            $sql_update_request_cont = "UPDATE t_request_cont 
                                    SET FL_PERBAIKI = 'N' 
                                    WHERE NO_CONT = ? AND ID = ?";
            $log['update_request_cont'] = $this->db->query($sql_update_request_cont, array($no_cont, $id_t_request)) ? 'Success' : 'Failed';

            $log['status'] = true;
        } else {
            $log['status'] = false;
            $log['message'] = 'Data tidak ditemukan untuk NO_CONT dan NO_SPK yang diberikan.';
        }

        // Kembalikan response JSON
        header('Content-Type: application/json');
        echo json_encode($log);
    }

    //mundurin ke belum siap periksa
    public function get_spk_periksa()
    {
        $no_cont = $this->input->post('no_container');

        if (!$no_cont) {
            echo json_encode(array(
                'status' => false,
                'message' => 'NO_CONT wajib diisi'
            ));
            return;
        }

        $this->db->select('A.ID, B.NO_SPK, B.NO_DOK, A.NO_CONT, A.STATUS_CONT, CONCAT(A.LOKASI, A.TIER) as LOKASI');
        $this->db->from('t_spk_cont A');
        $this->db->join('t_spk B', 'A.ID = B.ID');
        $this->db->where('A.NO_CONT', $no_cont);
        $this->db->where('A.STATUS_CONT', '460');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            echo json_encode(array(
                'status' => true,
                'data' => $query->result_array()
            ));
        } else {
            echo json_encode(array(
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ));
        }
    }
    public function set_periksa()
    {
        $no_cont = $this->input->post('no_container');
        $no_dok  = $this->input->post('no_dok');

        if (!$no_cont || !$no_dok) {
            echo json_encode(array(
                'status' => false,
                'message' => 'Parameter tidak lengkap'
            ));
            return;
        }

        $log = array();

        // OPTIONAL tapi sangat disarankan
        $this->db->trans_start();

        // 🔹 1. Ambil lokasi awal
        $sql_lokasi = "SELECT LOKASI_AWAL, TIER_AWAL 
                    FROM t_job_slip 
                    WHERE NO_CONT = ? AND NO_DOK = ? AND JENIS = 'BEHANDLE 1'";

        $lokasi = $this->db->query($sql_lokasi, array($no_cont, $no_dok))->row();

        if (!$lokasi) {
            echo json_encode(array(
                'status' => false,
                'message' => 'Lokasi awal tidak ditemukan'
            ));
            return;
        }

        $log['get_lokasi_awal'] = 'OK';

        // 🔹 2. Update job slip
        $sql_update_job = "UPDATE t_job_slip 
                        SET KD_STATUS='20', STATUS='WAITING'
                        WHERE NO_CONT = ? AND NO_DOK = ? AND JENIS = 'BEHANDLE 1'";

        $log['update_job_slip'] = $this->db->query($sql_update_job, array($no_cont, $no_dok)) ? 'OK' : 'FAILED';

        // 🔹 3. Ambil ID SPK (IMPORTANT: pakai NO_CONT + NO_DOK biar presisi)
        $sql_id = "SELECT A.ID 
                FROM t_spk_cont A
                JOIN t_spk B ON A.ID = B.ID
                WHERE A.NO_CONT = ? AND B.NO_DOK = ?";

        $id_row = $this->db->query($sql_id, array($no_cont, $no_dok))->row();

        if (!$id_row) {
            echo json_encode(array(
                'status' => false,
                'message' => 'ID SPK tidak ditemukan'
            ));
            return;
        }

        $id = $id_row->ID;

        // 🔹 4. Update t_spk_cont
        $sql_update_spk = "UPDATE t_spk_cont 
                        SET LOKASI = ?, 
                            TIER = ?, 
                            STATUS_CONT = '510'
                        WHERE ID = ? AND NO_CONT = ?";

        $log['update_spk_cont'] = $this->db->query(
            $sql_update_spk,
            array(
                $lokasi->LOKASI_AWAL,
                $lokasi->TIER_AWAL,
                $id,
                $no_cont
            )
        ) ? 'OK' : 'FAILED';

        // 🔹 commit transaksi
        $this->db->trans_complete();

        $log['status'] = $this->db->trans_status();

        echo json_encode($log);
    }

    // selesai periksa ke siap periksa
    public function get_spk_selesai()
    {
        $no_cont = $this->input->post('no_container');

        if (!$no_cont) {
            echo json_encode(array(
                'status' => false,
                'message' => 'NO_CONT wajib diisi'
            ));
            return;
        }

        $sql = "SELECT 
                    A.ID, 
                    A.NO_CONT, 
                    B.NO_DOK, 
                    B.TGL_DOK, 
                    B.NO_SPK
                FROM t_spk_cont A
                JOIN t_spk B 
                    ON A.ID = B.ID
                JOIN t_gatepass C 
                    ON A.NO_CONT = C.NO_CONT 
                    AND B.NO_DOK = C.NO_DOK
                JOIN t_op_inspection D 
                    ON A.NO_CONT = D.NO_CONT 
                    AND B.NO_DOK = D.NO_DOK 
                    AND D.STATUS = 'DONE'
                WHERE A.NO_CONT = ?
                AND A.STATUS_CONT = '450'";

        $query = $this->db->query($sql, array($no_cont));

        if ($query->num_rows() > 0) {
            echo json_encode(array(
                'status' => true,
                'data' => $query->result_array()
            ));
        } else {
            echo json_encode(array(
                'status' => false,
                'message' => 'Data selesai periksa tidak ditemukan'
            ));
        }
    }
}
