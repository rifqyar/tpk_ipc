<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_respon extends CI_Model {
	
	public function __construct(){
		parent::__construct();
	}
	
	function get_combobox($act,$id){
        $func = get_instance();
        $func->load->model("m_main", "main", true);
		if($act == "dok_bc"){
            $sql = "SELECT ID, NAMA FROM reff_kode_dok_bc WHERE KD_PERMIT = '".$id."' ORDER BY ID ASC";
            $arrdata = $func->main->get_combobox($sql, "ID", "NAMA", TRUE);
		}
		return $arrdata;
    }
	
	public function impor_kontainer($act, $id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$page_title = "DOKUMEN IMPOR";
		$title = "";
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		$KD_GROUP = $this->session->userdata('KD_GROUP');
		$check = (grant()=="W")?true:false;
		if($KD_GROUP!="SPA"){
			$addsql .= " AND A.KD_GUDANG = ".$this->db->escape($KD_GUDANG);
		}
		$SQL = "SELECT C.NAMA AS 'JENIS DOKUMEN', CONCAT('NO. : ',IFNULL(A.NO_DOK_INOUT,'-'),'<BR>TGL. : ',IFNULL(A.TGL_DOK_INOUT,'-')) AS DOKUMEN,
				CONCAT('NO. : ',IFNULL(A.NO_DAFTAR_PABEAN,'-'),'<BR>TGL. : ',IFNULL(A.TGL_DAFTAR_PABEAN,'-')) AS 'DAFTAR PABEAN',
				CONCAT('NO. : ',IFNULL(B.NO_CONT,'-'),'<BR>UKURAN : ',IFNULL(func_name(B.KD_CONT_UKURAN,'CONT_UKURAN'),'-'),
				'<BR>JENIS : ',IFNULL(func_name(B.KD_CONT_JENIS,'CONT_JENIS'),'-')) AS 'DATA KONTAINER', 
				A.NM_ANGKUT AS 'NAMA ANGKUT', A.ID
				FROM t_permit_hdr A
				INNER JOIN t_permit_cont B ON B.ID=A.ID
				INNER JOIN reff_kode_dok_bc C ON C.ID=A.KD_DOK_INOUT AND C.KD_PERMIT='IMP'".$addsql;
		$proses = array('DETAIL' => array('POPUP',"respon/impor_kontainer/detail", '1','','md-zoom-in'));
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$arr_dok = $this->get_combobox('dok_bc','IMP');
		$this->newtable->search(array(array('A.KD_DOK_INOUT','JENIS DOKUMEN','OPTION',$arr_dok),array('A.NO_DOK_INOUT','NO. DOKUMEN'),array('A.NM_ANGKUT','NAMA ANGKUT'),array('B.NO_CONT','NOMOR KONTAINER')));
		$this->newtable->action(site_url() . "/respon/impor_kontainer");
		if($check) $this->newtable->detail(array('POPUP',"respon/impor_kontainer/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblimpor");
		$this->newtable->set_divid("divtblimpor");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			echo $tabel;
		else
			return $arrdata;
	}

	public function daftar_pemeriksa($act, $id){
		$page_title = "DAFTAR PEMERIKSA";
		$title = "DAFTAR PEMERIKSA";
		$this->newtable->breadcrumb('Dashboard', site_url(),'icon-home');
		$this->newtable->breadcrumb('Join Inspection', 'javascript:void(0)','');
		$this->newtable->breadcrumb('Daftar Pemeriksa', 'javascript:void(0)','');
		// $check = (grant()=="W")?true:false;
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		$KD_GROUP = $this->session->userdata('KD_GROUP');

		if($KD_GROUP == 'BC'){
			$addsql = " AND A.USE_AKSES = 'BC'";
		}else if($KD_GROUP == 'ADM_KAR'){
			$addsql = " AND A.USE_AKSES = 'KARANTINA'";
		}

		$SQL = "SELECT A.ID 'ID',A.USE_AKSES 'GROUP', A.NIPP 'NIPP', A.NAMA 'NAMA LENGKAP', A.NO_TELP 'KONTAK' FROM t_pemeriksa_ppk A where 1=1".$addsql;
		
		$proses = array('ENTRY'  => array('MODAL',"respon/daftar_pemeriksa/add", '0','','md-plus-circle','', 'menu'),
						'UPDATE' => array('MODAL',"respon/daftar_pemeriksa/update", '1','','md-edit','', 'list'),
						'DELETE' => array('POST',"respon/daftar_pemeriksa/delete", '1','','md-minus-circle','', 'list'));
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu(true);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('NIPP','NO. NIPP'),array('A.NAMA','NAMA PEMERIKSA')));
		$this->newtable->action(site_url() . "/respon/daftar_pemeriksa");
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("ID");
		$this->newtable->sortby("DESC");
		$this->newtable->set_divid("divdaftarpemeriksa");
		$this->newtable->set_formid("tbldaftarpemeriksa");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			echo $tabel;
		else
			return $arrdata;
	}

	public function daftar_pemeriksa_detail($act, $id){
		$func = get_instance();
        $func->load->model("m_main", "main");
        $arrdata = array();

        $SQL = "SELECT * FROM t_pemeriksa_ppk where ID = " . $this->db->escape($id);
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

	public function daftar_pemeriksa_save($act, $id){
		$func = get_instance();
        $func->load->model("m_main", "main");

        foreach($this->input->post('DATA') as $a => $b){
			if($b=="") unset($DATA[$a]);
			else $DATA[$a] = trim($b);
		}

		if(!is_numeric($DATA['NIPP'])){
			echo "MSG#ERR#Masukan NIPP Harus Angka#";
			die();
		}else if(!is_numeric($DATA['NO_TELP'])){
			echo "MSG#ERR#Masukan No Telephone Harus Angka#";
			die();
		}

		if($act=="update_save"){
			$this->db->where(array('ID' => $id));
			$this->db->update('t_pemeriksa_ppk', $DATA);

		}else if($act=="create"){
			$this->db->insert('t_pemeriksa_ppk', $DATA);
			
		}
		echo "MSG#OK#Data berhasil diproses#".$this->input->post('action');
       
        
	}

	public function daftar_pemeriksa_delete($act, $id){
		$func = get_instance();
        $func->load->model("m_main", "main");

        $this->db->where('id', $id);
		$this->db->delete('t_pemeriksa_ppk');
		$action = '/respon/daftar_pemeriksa/post';
		// var_dump(Site_url().$action);die();
		
		echo "MSG#OK#Data berhasil diproses#".site_url().$action;
       
        
	}
	
	public function ekspor_kontainer($act, $id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$page_title = "DOKUMEN IMPOR";
		$title = "";
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		$KD_GROUP = $this->session->userdata('KD_GROUP');
		$check = (grant()=="W")?true:false;
		if($KD_GROUP!="SPA"){
			$addsql .= " AND A.KD_GUDANG = ".$this->db->escape($KD_GUDANG);
		}
		$SQL = "SELECT C.NAMA AS 'JENIS DOKUMEN', CONCAT('NO. : ',IFNULL(A.NO_DOK_INOUT,'-'),'<BR>TGL. : ',IFNULL(A.TGL_DOK_INOUT,'-')) AS DOKUMEN,
				CONCAT('NO. : ',IFNULL(A.NO_DAFTAR_PABEAN,'-'),'<BR>TGL. : ',IFNULL(A.TGL_DAFTAR_PABEAN,'-')) AS 'DAFTAR PABEAN',
				CONCAT('NO. : ',IFNULL(B.NO_CONT,'-'),'<BR>UKURAN : ',IFNULL(func_name(B.KD_CONT_UKURAN,'CONT_UKURAN'),'-'),
				'<BR>JENIS : ',IFNULL(func_name(B.KD_CONT_JENIS,'CONT_JENIS'),'-')) AS 'DATA KONTAINER', 
				A.NM_ANGKUT AS 'NAMA ANGKUT', A.ID
				FROM t_permit_hdr A
				INNER JOIN t_permit_cont B ON B.ID=A.ID
				INNER JOIN reff_kode_dok_bc C ON C.ID=A.KD_DOK_INOUT AND C.KD_PERMIT='EXP'".$addsql;
		$proses = array('DETAIL' => array('POPUP',"respon/ekspor_kontainer/detail", '1','','md-zoom-in'));
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$arr_dok = $this->get_combobox('dok_bc','EXP');
		$this->newtable->search(array(array('A.KD_DOK_INOUT','JENIS DOKUMEN','OPTION',$arr_dok),array('A.NO_DOK_INOUT','NO. DOKUMEN'),array('A.NM_ANGKUT','NAMA ANGKUT'),array('B.NO_CONT','NOMOR KONTAINER')));
		$this->newtable->action(site_url() . "/respon/ekspor_kontainer");
		if($check) $this->newtable->detail(array('POPUP',"respon/ekspor_kontainer/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblekspor");
		$this->newtable->set_divid("divtblekspor");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			echo $tabel;
		else
			return $arrdata;
	}




	
}
?>