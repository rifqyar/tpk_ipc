<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_codeco extends CI_Model {
	
	public function __construct(){
		parent::__construct();
	}
	
	public function gateout($act, $id){
		$page_title = "GATE OUT";
		$title = "";
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		$KD_GROUP = $this->session->userdata('KD_GROUP');
		$this->newtable->breadcrumb('Dashboard', site_url(),'icon-home');
		$this->newtable->breadcrumb('Pergerakan Barang', 'javascript:void(0)','');
		$this->newtable->breadcrumb('Barang Impor', 'javascript:void(0)','');
		$this->newtable->breadcrumb('Gate Out', 'javascript:void(0)','');
		$check = (grant()=="W")?true:false;
		if($KD_GROUP!="SPA"){
			$addsql .= " AND A.KD_TPS = ".$this->db->escape($KD_TPS)." AND A.KD_GUDANG = ".$this->db->escape($KD_GUDANG);
		}
		$SQL = "SELECT CONCAT(C.NAMA,'<BR>[',A.NM_ANGKUT,']') AS 'NAMA ANGKUT', 
				A.NO_VOY_FLIGHT AS 'NO. VOYAGE/FLIGHT', 
				DATE_FORMAT(A.TGL_TIBA,'%d-%m-%Y') AS 'TGL. TIBA', A.NO_BC11 AS 'NO. BC11',
				DATE_FORMAT(A.TGL_BC11,'%d-%m-%Y') AS 'TGL. BC11', A.WK_REKAM AS 'WAKTU REKAM',
				CONCAT('<span class=\"label label-danger\">JUMLAH : ',(
									SELECT COUNT(X.ID) FROM t_cocostscont X WHERE X.ID = A.ID),
				'</span><BR><span class=\"label label-info\">DISCHARGE : ',(
									SELECT COUNT(X.ID) FROM t_cocostscont X 
									WHERE X.WK_IN IS NOT NULL 
									AND X.WK_OUT IS NULL 
									AND X.ID = A.ID),
				'</span><BR><span class=\"label label-success\">GATE OUT : ',(SELECT COUNT(X.ID) 
								 	FROM t_cocostscont X 
									WHERE X.WK_IN IS NOT NULL 
									AND X.WK_OUT IS NOT NULL 
									AND X.ID = A.ID),'<span>') AS 'KONTAINER',
				CONCAT('<span class=\"label label-danger\">JUMLAH : ',(
									SELECT COUNT(Y.ID) FROM t_cocostskms Y WHERE Y.ID = A.ID),
				'</span><BR><span class=\"label label-info\">DISCHARGE : ',(
									SELECT COUNT(Y.ID) FROM t_cocostskms Y 
									WHERE Y.WK_IN IS NOT NULL 
									AND Y.WK_OUT IS NULL 
									AND Y.ID = A.ID),
				'</span><BR><span class=\"label label-success\">GATE OUT : ',(
									SELECT COUNT(Y.ID) FROM t_cocostskms Y 
									WHERE Y.WK_IN IS NOT NULL 
									AND Y.WK_OUT IS NOT NULL 
									AND Y.ID = A.ID),'<span>') AS 'KEMASAN',
				A.ID
				FROM t_cocostshdr A 
				LEFT JOIN reff_gudang B ON A.KD_TPS = B.KD_TPS AND A.KD_GUDANG = B.KD_GUDANG 
				LEFT JOIN reff_kapal C ON A.KD_KAPAL = C.ID
				WHERE A.KD_ASAL_BRG = '1'".$addsql;
		$proses = array('DETAIL' => array('GET',site_url()."/codeco/gateout/detail", '1','','md-zoom-in'),
						'UPLOAD' => array('ADD',site_url()."/codeco/gateout/upload", '','','md-attachment'));
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_BC11','NO. BC11'),array('C.NAMA','NAMA ANGKUT')));
		$this->newtable->action(site_url() . "/codeco/gateout");
		if($check) $this->newtable->detail(array('GET',site_url()."/codeco/gateout/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(6);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblkapal");
		$this->newtable->set_divid("divtblkapal");
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
	
	public function gateout_kontainer($act,$id){
		$page_title = "GATE OUT - KONTAINER";
		$title = "";
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		$check = (grant()=="W")?true:false;
		$SQL = "SELECT A.ID, A.NO_CONT AS 'NOMOR KONTAINER', CONCAT('UKURAN : ',func_name(IFNULL(A.KD_CONT_UKURAN,'-'),'CONT_UKURAN'),
				'<BR>JENIS : ',func_name(IFNULL(A.KD_CONT_JENIS,'-'),'CONT_JENIS'),'<BR>TIPE : ',func_name(IFNULL(A.KD_CONT_TIPE,'-'),'CONT_TIPE'))
				AS 'KETERANGAN KONTAINER',
				CONCAT('NO. ',IFNULL(NO_MASTER_BL_AWB,'-'),'<BR>TGL. ',IFNULL(DATE_FORMAT(A.TGL_MASTER_BL_AWB,'%d-%m-%Y'),'-')) AS 'MASTER BL/AWB',
				CONCAT('NO. ',IFNULL(NO_BL_AWB,'-'),'<BR>TGL. ',IFNULL(DATE_FORMAT(A.TGL_BL_AWB,'%d-%m-%Y'),'-')) AS 'BL/AWB', A.BRUTO,
				DATE_FORMAT(IFNULL(A.WK_IN,'-'),'%d-%m-%Y %H:%i:%s') AS 'DISCHARGE',
				DATE_FORMAT(IFNULL(A.WK_OUT,'-'),'%d-%m-%Y %H:%i:%s') AS 'GATE OUT', 
				DATE_FORMAT(IFNULL(A.WK_REKAM,'-'),'%d-%m-%Y %H:%i:%s') AS 'WAKTU REKAM',
				'CODECO/GATEOUT_KONTAINER' AS POST
				FROM t_cocostscont A
				WHERE A.WK_IN IS NOT NULL AND A.ID = ".$this->db->escape($id);
		$proses = array('GATE OUT' => array('MODAL',"codeco/gateout_kontainer/update", '1','','md-redo','','1'));
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->multiple_search(true);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_CONT', 'NOMOR KONTAINER')));
		$this->newtable->action(site_url() . "/codeco/gateout_kontainer/".$act."/".$id);
		if($check) $this->newtable->detail(array('POPUP',"codeco/gateout_kontainer/detail-kontainer"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID",'POST'));
		$this->newtable->keys(array("ID","NOMOR KONTAINER",'POST'));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(9);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblkontainer");
		$this->newtable->set_divid("divtblkontainer");
		$this->newtable->rowcount('10');
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
		if($this->input->post("ajax")||$act=="post")
			echo $tabel;
		else
			return $arrdata;
	}
	
	public function gateout_kemasan($act,$id){
		$page_title = "GATE OUT - KEMASAN";
		$title = "";
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		$check = (grant()=="W")?true:false;
		if($KD_GROUP!="SPA"){
			$addsql .= " AND B.KD_TPS = ".$this->db->escape($KD_TPS)." AND B.KD_GUDANG = ".$this->db->escape($KD_GUDANG);
		}
		$SQL = "SELECT CONCAT('JUMLAH : ',A.JUMLAH,'<BR>BRUTO : ',A.BRUTO,'<BR>',
				func_name(A.KD_KEMASAN,'KEMASAN'),' [',A.KD_KEMASAN,']') AS KEMASAN,
				CONCAT('NO. ',IFNULL(NO_MASTER_BL_AWB,'-'),'<BR>TGL. ',IFNULL(DATE_FORMAT(A.TGL_MASTER_BL_AWB,'%d-%m-%Y'),'-')) AS 'MASTER BL/AWB',
				CONCAT('NO. ',IFNULL(NO_BL_AWB,'-'),'<BR>TGL. ',IFNULL(DATE_FORMAT(A.TGL_BL_AWB,'%d-%m-%Y'),'-')) AS 'BL/AWB',
				A.NO_POS_BC11 AS 'POS BC11', C.NAMA AS CONISGNEE,
				DATE_FORMAT(IFNULL(A.WK_IN,'-'),'%d-%m-%Y %H:%i:%s') AS 'DISCHARGE',
				DATE_FORMAT(IFNULL(A.WK_OUT,'-'),'%d-%m-%Y %H:%i:%s') AS 'GATE OUT',
				A.WK_REKAM AS 'WAKTU REKAM', A.ID, A.SERI, 'CODECO/GATEOUT_KEMASAN' AS POST
				FROM t_cocostskms A
				INNER JOIN t_cocostshdr B ON B.ID=A.ID
				LEFT JOIN t_organisasi C ON C.ID=A.KD_ORG_CONSIGNEE
				WHERE A.WK_IN IS NOT NULL AND A.ID = ".$this->db->escape($id).$addsql;
		$proses = array('UPDATE' => array('MODAL',"codeco/gateout_kemasan/update", '1','','md-redo','','1'));
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->multiple_search(true);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_MASTER_BL_AWB', 'MASTER BL/AWB'),array('A.NO_BL_AWB', 'BL/AWB')));
		$this->newtable->action(site_url() . "/codeco/gateout_kemasan/".$act."/".$id);
		if($check) $this->newtable->detail(array('POPUP',"codeco/gateout_kemasan/detail-kemasan"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID","SERI","POST"));
		$this->newtable->keys(array("ID","SERI","POST"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(10);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblkemasan");
		$this->newtable->set_divid("divtblkemasan");
		$this->newtable->rowcount('10');
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
		if($this->input->post("ajax")||$act=="post")
			echo $tabel;
		else
			return $arrdata;
	}
	
	public function gatein($act, $id){
		$page_title = "GATE IN";
		$title = "";
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		$KD_GROUP = $this->session->userdata('KD_GROUP');
		$this->newtable->breadcrumb('Dashboard', site_url(),'icon-home');
		$this->newtable->breadcrumb('Pergerakan Barang', 'javascript:void(0)','');
		$this->newtable->breadcrumb('Barang Ekspor', 'javascript:void(0)','');
		$this->newtable->breadcrumb('Gate In', 'javascript:void(0)','');
		$check = (grant()=="W")?true:false;
		if($KD_GROUP!="SPA"){
			$addsql .= " AND A.KD_TPS = ".$this->db->escape($KD_TPS)." AND A.KD_GUDANG = ".$this->db->escape($KD_GUDANG);
		}
		$SQL = "SELECT CONCAT(C.NAMA,'<BR>[',A.NM_ANGKUT,']') AS 'NAMA ANGKUT', 
				A.NO_VOY_FLIGHT AS 'NO. VOYAGE/FLIGHT', 
				DATE_FORMAT(A.TGL_TIBA,'%d-%m-%Y') AS 'TGL. TIBA', A.NO_BC11 AS 'NO. BC11',
				DATE_FORMAT(A.TGL_BC11,'%d-%m-%Y') AS 'TGL. BC11', A.WK_REKAM AS 'WAKTU REKAM',
				CONCAT('<span class=\"label label-danger\">JUMLAH : ',(
									SELECT COUNT(X.ID) FROM t_cocostscont X WHERE X.ID = A.ID),
				'</span><BR><span class=\"label label-info\">GATE IN : ',(
									SELECT COUNT(X.ID) FROM t_cocostscont X 
									WHERE X.WK_IN IS NOT NULL 
									AND X.WK_OUT IS NULL 
									AND X.ID = A.ID),
				'</span><BR><span class=\"label label-success\">LOADING : ',(SELECT COUNT(X.ID) 
								 	FROM t_cocostscont X 
									WHERE X.WK_IN IS NOT NULL 
									AND X.WK_OUT IS NOT NULL 
									AND X.ID = A.ID),'<span>') AS 'KONTAINER',
				CONCAT('<span class=\"label label-danger\">JUMLAH : ',(
									SELECT COUNT(Y.ID) FROM t_cocostskms Y WHERE Y.ID = A.ID),
				'</span><BR><span class=\"label label-info\">GATE IN : ',(
									SELECT COUNT(Y.ID) FROM t_cocostskms Y 
									WHERE Y.WK_IN IS NOT NULL 
									AND Y.WK_OUT IS NULL 
									AND Y.ID = A.ID),
				'</span><BR><span class=\"label label-success\">LOADING : ',(
									SELECT COUNT(Y.ID) FROM t_cocostskms Y 
									WHERE Y.WK_IN IS NOT NULL 
									AND Y.WK_OUT IS NOT NULL 
									AND Y.ID = A.ID),'<span>') AS 'KEMASAN',
				A.ID
				FROM t_cocostshdr A 
				LEFT JOIN reff_gudang B ON A.KD_TPS = B.KD_TPS AND A.KD_GUDANG = B.KD_GUDANG 
				LEFT JOIN reff_kapal C ON A.KD_KAPAL = C.ID
				WHERE A.KD_ASAL_BRG = '3'".$addsql;
		$proses = array('ENTRY'  => array('MODAL',"codeco/gatein/add", '0','','md-plus-circle'),
						'UPDATE' => array('MODAL',"codeco/gatein/update", '1','','md-edit'),
						'DETAIL' => array('GET',site_url()."/codeco/gatein/detail", '1','','md-zoom-in'),
						'UPLOAD' => array('ADD',site_url()."/codeco/gatein/upload", '','','md-attachment'));
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_BC11','NO. BC11'),array('C.NAMA','NAMA ANGKUT')));
		$this->newtable->action(site_url() . "/codeco/gatein");
		if($check) $this->newtable->detail(array('GET',site_url()."/codeco/gatein/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(6);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblkapal");
		$this->newtable->set_divid("divtblkapal");
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
	
	public function gatein_kontainer($act,$id){
		$page_title = "GATE IN - KONTAINER";
		$title = "";
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		$check = (grant()=="W")?true:false;
		$SQL = "SELECT A.ID, A.NO_CONT AS 'NOMOR KONTAINER', CONCAT('UKURAN : ',func_name(IFNULL(A.KD_CONT_UKURAN,'-'),'CONT_UKURAN'),
				'<BR>JENIS : ',func_name(IFNULL(A.KD_CONT_JENIS,'-'),'CONT_JENIS'),'<BR>TIPE : ',func_name(IFNULL(A.KD_CONT_TIPE,'-'),'CONT_TIPE'))
				AS 'KETERANGAN KONTAINER',
				CONCAT('NO. ',IFNULL(NO_MASTER_BL_AWB,'-'),'<BR>TGL. ',IFNULL(DATE_FORMAT(A.TGL_MASTER_BL_AWB,'%d-%m-%Y'),'-')) AS 'MASTER BL/AWB',
				CONCAT('NO. ',IFNULL(NO_BL_AWB,'-'),'<BR>TGL. ',IFNULL(DATE_FORMAT(A.TGL_BL_AWB,'%d-%m-%Y'),'-')) AS 'BL/AWB', A.BRUTO,
				DATE_FORMAT(IFNULL(A.WK_IN,'-'),'%d-%m-%Y %H:%i:%s') AS 'GATE IN', 
				DATE_FORMAT(IFNULL(A.WK_REKAM,'-'),'%d-%m-%Y %H:%i:%s') AS 'WAKTU REKAM',
				'CODECO/GATEIN_KONTAINER' AS POST
				FROM t_cocostscont A
				WHERE A.ID = ".$this->db->escape($id);
		$proses = array('ENTRY' => array('MODAL',"codeco/gatein_kontainer/add/".$id, '0','','md-plus-circle','','1'),
						'UPDATE' => array('MODAL',"codeco/gatein_kontainer/update", '1','','md-edit','','1'),
						'DELETE' => array('DELETE',"execute/process/delete/kontainer", 'ALL','','md-close-circle','','1'));
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->multiple_search(true);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_CONT', 'NOMOR KONTAINER')));
		$this->newtable->action(site_url() . "/codeco/gatein_kontainer/".$act."/".$id);
		if($check) $this->newtable->detail(array('POPUP',"codeco/gatein_kontainer/detail-kontainer"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID",'POST'));
		$this->newtable->keys(array("ID","NOMOR KONTAINER",'POST'));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(8);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblkontainer");
		$this->newtable->set_divid("divtblkontainer");
		$this->newtable->rowcount('10');
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
		if($this->input->post("ajax")||$act=="post")
			echo $tabel;
		else
			return $arrdata;
	}
	
	public function gatein_kemasan($act,$id){
		$page_title = "GATE IN - KEMASAN";
		$title = "";
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		$check = (grant()=="W")?true:false;
		if($KD_GROUP!="SPA"){
			$addsql .= " AND B.KD_TPS = ".$this->db->escape($KD_TPS)." AND B.KD_GUDANG = ".$this->db->escape($KD_GUDANG);
		}
		$SQL = "SELECT CONCAT('JUMLAH : ',A.JUMLAH,'<BR>BRUTO : ',A.BRUTO,'<BR>',
				func_name(A.KD_KEMASAN,'KEMASAN'),' [',A.KD_KEMASAN,']') AS KEMASAN,
				CONCAT('NO. ',IFNULL(NO_MASTER_BL_AWB,'-'),'<BR>TGL. ',IFNULL(DATE_FORMAT(A.TGL_MASTER_BL_AWB,'%d-%m-%Y'),'-')) AS 'MASTER BL/AWB',
				CONCAT('NO. ',IFNULL(NO_BL_AWB,'-'),'<BR>TGL. ',IFNULL(DATE_FORMAT(A.TGL_BL_AWB,'%d-%m-%Y'),'-')) AS 'BL/AWB',
				A.NO_POS_BC11 AS 'NO. POS BC11', C.NAMA AS CONISGNEE, 
				DATE_FORMAT(IFNULL(A.WK_IN,'-'),'%d-%m-%Y %H:%i:%s') AS 'GATE IN', A.WK_REKAM AS 'TANGGAL REKAM', A.ID, A.SERI,
				'CODECO/GATEIN_KEMASAN' AS POST
				FROM t_cocostskms A
				INNER JOIN t_cocostshdr B ON B.ID=A.ID
				LEFT JOIN t_organisasi C ON C.ID=A.KD_ORG_CONSIGNEE
				WHERE A.ID = ".$this->db->escape($id).$addsql;
		$proses = array('ENTRY' => array('MODAL',"codeco/gatein_kemasan/add/".$id, '0','','md-plus-circle','','1'),
						'UPDATE' => array('MODAL',"codeco/gatein_kemasan/update", '1','','md-edit','','1'),
						'DELETE' => array('DELETE',"execute/process/delete/kemasan/".$id, 'ALL','','md-close-circle','','1'));
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->multiple_search(true);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_MASTER_BL_AWB', 'MASTER BL/AWB'),array('A.NO_BL_AWB', 'BL/AWB')));
		$this->newtable->action(site_url() . "/codeco/gatein_kemasan/".$act."/".$id);
		if($check) $this->newtable->detail(array('POPUP',"codeco/gatein_kemasan/detail-kemasan"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID","SERI","POST"));
		$this->newtable->keys(array("ID","SERI","POST"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(9);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblkemasan");
		$this->newtable->set_divid("divtblkemasan");
		$this->newtable->rowcount('10');
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
		if($this->input->post("ajax")||$act=="post")
			echo $tabel;
		else
			return $arrdata;
	}
}
?>