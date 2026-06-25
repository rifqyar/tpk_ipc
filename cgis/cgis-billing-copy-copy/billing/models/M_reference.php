<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_reference extends CI_Model {

	public function __construct(){
		parent::__construct();

	}

	function get_referensi($type, $kode, $uraian) {
        $func = get_instance();
        $func->load->model("m_main", "main", true);
        $return = NULL;
        switch ($type) {
            case 'kapal' :
                if ($uraian != "") {
                    $SQL = "SELECT ID, NAMA FROM reff_kapal
							WHERE NAMA = " . $this->db->escape(trim($uraian));
                    $result = $func->main->get_result($SQL);
                    if ($result) {
                        foreach ($SQL->result_array() as $row => $value) {
                            $arrdata = $value;
                        }
                        $kode_angkut = $arrdata['ID'];
                    } else {
                        $arrdata['NAMA'] = $uraian;
                        $arrdata['CALL_SIGN'] = $kode;
                        $this->db->insert('reff_kapal', $arrdata);
                        $kode_angkut = $this->db->insert_id();
                    }
                    if ($kode != "") {
                        $data['NAMA'] = $uraian;
                        $data['CALL_SIGN'] = $kode;
                        $this->db->where(array('ID' => $arrdata['ID']));
                        $this->db->update('reff_kapal', $data);
                        $kode_angkut = $arrdata['ID'];
                    }
                }
                $return = $kode_angkut;
                break;
        }
        return $return;
    }
	
	function execute($type, $act, $id) {
        $func = get_instance();
        $func->load->model("m_main", "main", true);
        $success = 0;
        $error = 0;
        $USERLOGIN = $this->session->userdata('USERLOGIN');
        $KD_TPS = $this->session->userdata('KD_TPS');
        $KD_GUDANG = $this->session->userdata('KD_GUDANG');
        if ($type == "save") {
            if ($act == "libur") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        $DATA[$a] = NULL;
                    else
                        $DATA[$a] = strtoupper(trim($b));
                }
				$DATA['TANGGAL'] = $DATA['TANGGAL'];
                $result = $this->db->insert('t_hari_libur', $DATA);
                if (!$result) {
                    $error += 1;
                    $message = "Data gagal diproses";
                }
                if ($error == 0) {
                    $func->main->get_log("add", "t_hari_libur");
                    echo "MSG#OK#Data berhasil diproses#" . $this->input->post('action');
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            }else if ($act == "truck") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        $DATA[$a] = NULL;
                    else
                        $DATA[$a] = strtoupper(trim($b));
                }
                $result = $this->db->insert('reff_truck', $DATA);
                if (!$result) {
                    $error += 1;
                    $message = "Data gagal diproses";
                }
                if ($error == 0) {
                    $func->main->get_log("add", "reff_truck");
                    echo "MSG#OK#Data berhasil diproses#" . $this->input->post('action');
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "reff_kapal") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        $DATA[$a] = NULL;
                    else
                        $DATA[$a] = strtoupper(trim($b));
                }
                $result = $this->db->insert('reff_kapal', $DATA);
                if (!$result) {
                    $error += 1;
                    $message = "Data gagal diproses";
                }
                if ($error == 0) {
                    $func->main->get_log("add", "reff_kapal");
                    echo "MSG#OK#Data berhasil diproses#" . $this->input->post('action');
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "t_organisasi") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        $DATA[$a] = NULL;
                    else
                        $DATA[$a] = strtoupper(trim($b));
                }
                $DATA['KD_TIPE_ORGANISASI'] = 'CONS';
                $result = $this->db->insert('t_organisasi', $DATA);
                if (!$result) {
                    $error += 1;
                    $message = "Data gagal diproses";
                }
                if ($error == 0) {
                    $func->main->get_log("add", "t_organisasi");
                    echo "MSG#OK#Data berhasil diproses#" . $this->input->post('action');
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            }
        } else if ($type == "update") {
            if ($act == "libur") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        $DATA[$a] = NULL;
                    else
                        $DATA[$a] = strtoupper(trim($b));
                }
				$DATA['TANGGAL'] = validate($DATA['TANGGAL'], 'DATE');
                $this->db->where(array('ID' => $id));
                $result = $this->db->update('t_hari_libur', $DATA);
                if (!$result) {
                    $error += 1;
                    $message = "Data gagal diproses";
                }
                if ($error == 0) {
                    $func->main->get_log("update", "t_hari_libur");
                    echo "MSG#OK#Data berhasil diproses#" . $this->input->post('action');
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            }else if ($act == "truck") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        $DATA[$a] = NULL;
                    else
                        $DATA[$a] = strtoupper(trim($b));
                }
                $this->db->where(array('ID_TRUCK' => $id));
                $result = $this->db->update('reff_truck', $DATA);
                if (!$result) {
                    $error += 1;
                    $message = "Data gagal diproses";
                }
                if ($error == 0) {
                    $func->main->get_log("update", "reff_truck");
                    echo "MSG#OK#Data berhasil diproses#" . $this->input->post('action');
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "reff_kapal") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        $DATA[$a] = NULL;
                    else
                        $DATA[$a] = strtoupper(trim($b));
                }
                $this->db->where(array('ID' => $id));
                $result = $this->db->update('reff_kapal', $DATA);
                if (!$result) {
                    $error += 1;
                    $message = "Data gagal diproses";
                }
                if ($error == 0) {
                    $func->main->get_log("update", "reff_kapal");
                    echo "MSG#OK#Data berhasil diproses#" . $this->input->post('action');
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "t_organisasi") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        $DATA[$a] = NULL;
                    else
                        $DATA[$a] = strtoupper(trim($b));
                }
                $this->db->where(array('ID' => $id));
                $result = $this->db->update('t_organisasi', $DATA);
                if (!$result) {
                    $error += 1;
                    $message = "Data gagal diproses";
                }
                if ($error == 0) {
                    $func->main->get_log("update", "t_organisasi");
                    echo "MSG#OK#Data berhasil diproses#" . $this->input->post('action');
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            }
        } else if ($type == "get") {
            if ($act == "libur") {
                $arrid = explode("~", $id);
                $SQL = "SELECT A.* FROM t_hari_libur A
						WHERE A.ID = " . $this->db->escape($arrid[0]);
                $result = $func->main->get_result($SQL);
                if ($result) {
                    foreach ($SQL->result_array() as $row => $value) {
                        $arrdata = $value;
                    }
                    return $arrdata;
                } else {
                    redirect(site_url(), 'refresh');
                }
            }else if ($act == "truck") {
                $arrid = explode("~", $id);
                $SQL = "SELECT A.* FROM reff_truck A
                        WHERE A.ID_TRUCK = " . $this->db->escape($arrid[0]);
                $result = $func->main->get_result($SQL);
                if ($result) {
                    foreach ($SQL->result_array() as $row => $value) {
                        $arrdata = $value;
                    }
                    return $arrdata;
                } else {
                    redirect(site_url(), 'refresh');
                }
            }else if ($act == "reff_kapal") {
                $arrid = explode("~", $id);
                $SQL = "SELECT A.* FROM reff_kapal A
						WHERE A.ID = " . $this->db->escape($arrid[0]);
                $result = $func->main->get_result($SQL);
                if ($result) {
                    foreach ($SQL->result_array() as $row => $value) {
                        $arrdata = $value;
                    }
                    return $arrdata;
                } else {
                    redirect(site_url(), 'refresh');
                }
            } else if ($act == "t_organisasi") {
                $arrid = explode("~", $id);
                $SQL = "SELECT A.* FROM t_organisasi A
						WHERE A.ID = " . $this->db->escape($arrid[0]);
                $result = $func->main->get_result($SQL);
                if ($result) {
                    foreach ($SQL->result_array() as $row => $value) {
                        $arrdata = $value;
                    }
                    return $arrdata;
                } else {
                    redirect(site_url(), 'refresh');
                }
            }
        } else if ($type == "delete") {
            if ($act == "libur") {
                foreach ($this->input->post('tb_chktbllibur') as $chkitem) {
                    $arrchk = explode("~", $chkitem);
                    $ID = $arrchk[0];
                    $result = $this->db->delete('t_hari_libur', array('ID' => $ID));
                    if (!$result) {
                        $error += 1;
                        $message .= "Could not be processed data";
                    }
                }
                if ($error == 0) {
                    $func->main->get_log("delete", "t_hari_libur");
                    echo "MSG#OK#Successfully to be processed#" . site_url() . "/reference/hrlibur/post#";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            }elseif($act == "truck"){
                foreach ($this->input->post('tb_chktbltruck') as $chkitem) {
                    $arrchk = explode("~", $chkitem);
                    $ID = $arrchk[0];
                    $result = $this->db->delete('reff_truck', array('ID_TRUCK' => $ID));
                    if (!$result) {
                        $error += 1;
                        $message .= "Could not be processed data";
                    }
                }
                if ($error == 0) {
                    $func->main->get_log("delete", "reff_truck");
                    echo "MSG#OK#Successfully to be processed#" . site_url() . "/reference/truck/post#";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            }
        }
    }
	
	public function customer($act, $id){
		$page_title = "CUSTOMER";
		$title = "CUSTOMER";
		$this->newtable->breadcrumb('Dashboard', site_url(),'icon-home');
		$this->newtable->breadcrumb('Reference', 'javascript:void(0)','');
		$this->newtable->breadcrumb('Customer', 'javascript:void(0)','');
		$check = (grant()=="W")?true:false;
		$SQL = "SELECT ID_CUST AS 'ID', NPWP AS 'NO. NPWP', NAMA_CUST AS 'NAMA CUSTOMER', ALAMAT AS 'ALAMAT', EMAIL AS 'E-MAIL', TELEPON AS 'TELEPON', TLP_KANTOR AS 'NO. TELEPON KANTOR'  FROM m_pelanggan";
		$proses = array('ENTRY'  => array('MODAL',"reference/customer/add", '0','','md-plus-circle','', 'menu'),
						'UPDATE' => array('MODAL',"reference/customer/update", '1','','md-edit','', 'list'),
						'DELETE'  => array('DELETE',"execute/process/delete/customer", '1','','md-close-circle','', 'menu'));
						//'UPLOAD' => array('ADD',site_url()."/coarri/discharge/upload", '','','md-attachment'));
						//'REALISASI' => array('MODAL',"planning/shipment/release", '1','','md-refresh-alt','', 'list'),
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(true);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('NPWP','NO. NPWP'),array('NAMA_CUST','NAMA CUSTOMER')));
		$this->newtable->action(site_url() . "/reference/customer");
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("NPWP");
		$this->newtable->sortby("ASC");
		$this->newtable->set_formid("tblcustomer");
		$this->newtable->set_divid("divcustomer");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			return $tabel;
		else
			return $arrdata;
	}

	public function hrlibur($act, $id){
		$page_title = "HARI LIBUR";
		$title = "HARI LIBUR";
		$this->newtable->breadcrumb('Dashboard', site_url(),'icon-home');
		$this->newtable->breadcrumb('Reference', 'javascript:void(0)','');
		$this->newtable->breadcrumb('HARI LIBUR', 'javascript:void(0)','');
		$check = (grant()=="W")?true:false;
		if($KD_GROUP!="SPA"){
			///$addsql .= " AND A.KD_TPS = ".$this->db->escape($KD_TPS)." AND A.KD_GUDANG = ".$this->db->escape($KD_GUDANG);
		}
		$SQL ="SELECT ID,DATE_FORMAT(TANGGAL,'%d-%m-%Y') AS 'TANGGAL LIBUR', KETERANGAN FROM t_hari_libur ";

		$proses = array('ENTRY'  => array('MODAL',"reference/hrlibur/add", '0','','md-plus-circle','', 'menu'),
						'UPDATE' => array('MODAL',"reference/hrlibur/update", '1','','md-edit','', 'list'),
						'DELETE'  => array('DELETE',"reference/execute/delete/libur", 'all','','md-close-circle','', 'menu'));
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('TANGGAL','TANGGAL LIBUR','DATERANGE'),array('KETERANGAN','KETERANGAN')));
		$this->newtable->action(site_url() . "/reference/hrlibur");
		//if($check) $this->newtable->detail(array('DRILLDOWN',site_url()."/coarri/discharge/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("ID");
		$this->newtable->sortby("ASC");
		$this->newtable->set_formid("tbllibur");
		$this->newtable->set_divid("divlibur");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			return $tabel;
		else
			return $arrdata;
	}
	
	public function truck($act, $id){
        $page_title = "TRUCK";
        $title = "TRUCK";
        $this->newtable->breadcrumb('Dashboard', site_url(),'icon-home');
        $this->newtable->breadcrumb('Reference', 'javascript:void(0)','');
        $this->newtable->breadcrumb('Truck', 'javascript:void(0)','');
        $check = (grant()=="W")?true:false;
        if($KD_GROUP!="SPA"){
            ///$addsql .= " AND A.KD_TPS = ".$this->db->escape($KD_TPS)." AND A.KD_GUDANG = ".$this->db->escape($KD_GUDANG);
        }
        $SQL ="SELECT ID_TRUCK,NM_PEMILIK AS 'PEMILIK TRUCK',NO_TRUCK AS 'NO POLISI',UKURAN_TRUCK AS 'UKURAN' FROM reff_truck ";

        $proses = array('ENTRY'  => array('MODAL',"reference/truck/add", '0','','md-plus-circle','', 'menu'),
                        'UPDATE' => array('MODAL',"reference/truck/update", '1','','md-edit','', 'list'),
                        'DELETE'  => array('DELETE',"reference/execute/delete/truck", 'all','','md-close-circle','', 'menu'));
        $this->newtable->multiple_search(true);
        $this->newtable->show_chk($check);
        $this->newtable->show_menu($check);
        $this->newtable->show_search(true);
        $this->newtable->search(array(array('NM_PEMILIK','PEMILIK TRUCK'),array('NO_TRUCK','NO POLISI')));
        $this->newtable->action(site_url() . "/reference/truck");
        //if($check) $this->newtable->detail(array('DRILLDOWN',site_url()."/coarri/discharge/detail"));
        $this->newtable->tipe_proses('button');
        $this->newtable->hiddens(array("ID_TRUCK"));
        $this->newtable->keys(array("ID_TRUCK"));
        $this->newtable->cidb($this->db);
        $this->newtable->orderby("ID_TRUCK");
        $this->newtable->sortby("ASC");
        $this->newtable->set_formid("tbltruck");
        $this->newtable->set_divid("divtruck");
        $this->newtable->rowcount(10);
        $this->newtable->clear();
        $this->newtable->menu($proses);
        $tabel .= $this->newtable->generate($SQL);
        $arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
        if($this->input->post("ajax")||$act == "post")
            return $tabel;
        else
            return $arrdata;
    }

	public function mail($act, $id){
		$page_title = "E-MAIL";
		$title = "E-MAIL";
		$this->newtable->breadcrumb('Dashboard', site_url(),'icon-home');
		$this->newtable->breadcrumb('Reference', 'javascript:void(0)','');
		$this->newtable->breadcrumb('E-Mail', 'javascript:void(0)','');
		$check = (grant()=="W")?true:false;
		if($KD_GROUP!="SPA"){
			///$addsql .= " AND A.KD_TPS = ".$this->db->escape($KD_TPS)." AND A.KD_GUDANG = ".$this->db->escape($KD_GUDANG);
		}
		$SQL = "SELECT ID,EMAIL AS 'E-MAIL', JNS_EMAIL AS 'JENIS E-MAIL', NAMA_USER AS 'NAMA USER', KEGIATAN FROM reff_mail";
		$proses = array('ENTRY'  => array('MODAL',"reference/mail/add", '0','','md-plus-circle','', 'menu'),
						'UPDATE' => array('MODAL',"reference/mail/update", '1','','md-edit','', 'list'),
						// 'REALISASI' => array('MODAL',"planning/shipment/release", '1','','md-refresh-alt','', 'list'),
						'DELETE'  => array('DELETE',"execute/process/delete/mail", '1','','md-close-circle','', 'list'));
						//'UPLOAD' => array('ADD',site_url()."/coarri/discharge/upload", '','','md-attachment'));
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$arr_keg = array(""=>"","GATE"=>"GATE PASS","ANNOUNCE"=>"ANNOUNCEMENT");
		$this->newtable->search(array(array('EMAIL','NAMA E-MAIL'),array('NAMA_USER','NAMA USER'),array('KEGIATAN','KEGIATAN','OPTION',$arr_keg)));
		$this->newtable->action(site_url() . "/reference/mail");
		//if($check) $this->newtable->detail(array('DRILLDOWN',site_url()."/coarri/discharge/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("NAMA_USER");
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblmail");
		$this->newtable->set_divid("divmail");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			return $tabel;
		else
			return $arrdata;
	}

	public function user($act, $id){
		$page_title = "USER";
		$title = "USER";
		$this->newtable->breadcrumb('Dashboard', site_url(),'icon-home');
		$this->newtable->breadcrumb('Reference', 'javascript:void(0)','');
		$this->newtable->breadcrumb('USER', 'javascript:void(0)','');
		$check = (grant()=="W")?true:false;
		if($KD_GROUP!="SPA"){
			///$addsql .= " AND A.KD_TPS = ".$this->db->escape($KD_TPS)." AND A.KD_GUDANG = ".$this->db->escape($KD_GUDANG);
		}
		$SQL = "SELECT ID,USER_NAME AS 'USERNAME', NAMA AS 'NAMA USER', EMAIL AS 'E-MAIL',KD_GROUP AS 'KODE GROUP', STATUS, LAST_LOGIN AS 'LAST LOGIN' FROM reff_user";

		$proses = array('ENTRY'  => array('MODAL',"reference/user/add", '0','','md-plus-circle','', 'menu'),
						'UPDATE' => array('MODAL',"reference/user/update", '1','','md-edit','', 'menu'),
						// 'REALISASI' => array('MODAL',"planning/shipment/release", '1','','md-refresh-alt','', 'list'),
						'DELETE'  => array('DELETE',"execute/process/delete/user", '1','','md-close-circle','', 'menu'));
						//'UPLOAD' => array('ADD',site_url()."/coarri/discharge/upload", '','','md-attachment'));
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('USER_NAME','USERNAME'),array('NAMA','NAMA PENGGUNA'),array('EMAIL','E-MAIL')));
		$this->newtable->action(site_url() . "/reference/user");
		//if($check) $this->newtable->detail(array('DRILLDOWN',site_url()."/coarri/discharge/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("ID");
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tbluser");
		$this->newtable->set_divid("divuser");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			return $tabel;
		else
			return $arrdata;
	}

	public function dokumenbc($act, $id){
		$page_title = "DOKUMEN BEA CUKAI";
		$title = "DOKUMEN BEA CUKAI";
		$this->newtable->breadcrumb('Dashboard', site_url(),'icon-home');
		$this->newtable->breadcrumb('Reference', 'javascript:void(0)','');
		$this->newtable->breadcrumb('Dokumen Bea Cukai', 'javascript:void(0)','');
		$check = (grant()=="W")?true:false;
		if($KD_GROUP!="SPA"){
			///$addsql .= " AND A.KD_TPS = ".$this->db->escape($KD_TPS)." AND A.KD_GUDANG = ".$this->db->escape($KD_GUDANG);
		}
		$SQL = "SELECT ID AS 'ID', NAMA, KD_PERMIT AS 'KODE PERMIT' FROM reff_kode_dok_bc";

		$proses = array('ENTRY'  => array('MODAL',"reference/dokumenbc/add", '0','','md-plus-circle','', 'menu'),
						'UPDATE' => array('MODAL',"reference/dokumenbc/update", '1','','md-edit','', 'list'),
						// 'REALISASI' => array('MODAL',"planning/shipment/release", '1','','md-refresh-alt','', 'list'),
						'DELETE'  => array('DELETE',"execute/process/delete/dokumenbc", '1','','md-close-circle','', 'menu'));
						//'UPLOAD' => array('ADD',site_url()."/coarri/discharge/upload", '','','md-attachment'));
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$arr_sts = array(""=>"","IMP"=>"IMP","EXP"=>"EXP");
		//$this->newtable->search(array(array('NO_DOK','NO. DOKUMEN'),array('NO_SPK','NO. SPK'),array('KETERANGAN','STATUS','OPTION',$arr_sts)));
		$this->newtable->search(array(array('NAMA','NAMA'),array('KD_PERMIT','KODE PERMIT','OPTION',$arr_sts)));
		$this->newtable->action(site_url() . "/reference/dokumenbc");
		//if($check) $this->newtable->detail(array('DRILLDOWN',site_url()."/coarri/discharge/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("ID");
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblbc");
		$this->newtable->set_divid("divbc");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			return $tabel;
		else
			return $arrdata;
	}


}

?>
