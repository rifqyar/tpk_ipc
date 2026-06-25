<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_billing extends CI_Model {

	public function __construct(){
		parent::__construct();

	}

	function get_data($act, $id) {
        $func = get_instance();
        $func->load->model("m_main", "main");
        $arrdata = array();
		if ($act == "history_behandle") {
			//print_r($id);die();
			$SQL = "SELECT COUNT(ID_HANDLE) AS JML, B.NAMA, A.ID_HANDLE, A.USER_PRINTS, A.TYPE_RPT
					FROM hist_print A
					LEFT JOIN reff_user B ON A.USER_PRINTS = B.ID
					where A.ID_HANDLE = '".$id."' AND TYPE_RPT = 'nota_behandle'
					GROUP BY USER_PRINTS
					";
            $result = $this->db->query($SQL);//echo $SQL;die();
            return $result->result_array();
        }else if ($act == "history_delivery"){
            //print_r($id);die();
			$arrid = explode('~',$id);
			$id = $arrid[0];
			$SQL = "SELECT COUNT(ID_HANDLE) AS JML, B.NAMA, A.ID_HANDLE, A.USER_PRINTS, A.TYPE_RPT
					FROM hist_print A
					LEFT JOIN reff_user B ON A.USER_PRINTS = B.ID
					where A.ID_HANDLE = '".$id."' AND TYPE_RPT = 'nota_del'
					GROUP BY USER_PRINTS
					";
            $result = $this->db->query($SQL);//echo $SQL;die();
            return $result->result_array();
        }else if ($act == "history_ext") {
        	$SQL = "SELECT COUNT(ID_HANDLE) AS JML, B.NAMA, A.ID_HANDLE, A.USER_PRINTS, A.TYPE_RPT
					FROM hist_print A
					LEFT JOIN reff_user B ON A.USER_PRINTS = B.ID
					where A.ID_HANDLE = '".$id."' AND TYPE_RPT = 'nota_ext'
					GROUP BY USER_PRINTS
					";
            $result = $this->db->query($SQL);//echo $SQL;die();
            return $result->result_array();
        }

    }

	public function behandle($act, $id){
		$page_title = 'BILLING BEHANDLE';
		$title = "BILLING BEHANDLE";
		$this->newtable->breadcrumb('Billing', 'javascript:void(0)','');
		$this->newtable->breadcrumb('Behandle', 'javascript:void(0)','');
		$check = (grant()=="W")?true:false;
		/*$SQL = "SELECT ID_REQ AS 'NO REQUEST',TGL_REQ AS 'TGL REQUEST', NO_DOK AS 'NO. DOKUMEN',
				CASE WHEN NO_NOTA_BEHANDLE = '' THEN '-' ELSE NO_NOTA_BEHANDLE END AS 'NO. NOTA BEHANDLE', 
				CONCAT('<span class=\"label label-info\">Rp. ',FORMAT(TOTAL_JUMLAH,0),'</span>') AS 'TOTAL' FROM req_behandle_hdr";*/

		$SQL = "SELECT A.ID_REQ AS 'NO REQUEST',CONCAT(A.NAMA_CUST,'<BR>',A.NPWP) AS 'CUSTOMER',A.TGL_REQ AS 'TGL REQUEST', 
				A.NO_DOK AS 'NO. DOKUMEN',B.NM_KAPAL AS 'NAMA KAPAL', IFNULL(A.NO_NOTA_BEHANDLE, NULL) AS 'NO. NOTA BEHANDLE', 
				CONCAT('<span class=\"label label-info\">Rp. ', FORMAT(A.TOTAL_JUMLAH,0),'</span>') AS 'TOTAL'
				FROM req_behandle_hdr A
				INNER JOIN t_gatepass B ON B.NO_DOK = A.NO_DOK AND B.JNS_KEGIATAN IS NOT NULL";

		$proses = array('ENTRY'  => array('MODAL',"billing/behandle/add", '','','md-plus-circle','', 'menu'),
		'CETAK'  => array('PRINT',"billing/cetak_nota_behandle", '0','','md-print','','list'),
		'CONFIRM' => array('MODAL',"billing/behandle/confirm", '1','','md-confirmation-number','', 'list'),
		'HISTORY' => array('MODAL',"billing/behandle/history", '1', '', 'md-watch','','list'),
		'UPDATE' => array('MODAL',"billing/behandle/update", '1','NOT-NULL','md-edit','','list'));
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('ID_REQ','ID REQUEST'),array('A.NO_DOK','NO. DOKUMEN'),array('NO_NOTA_BEHANDLE','NO. NOTA'),array('NAMA_CUST','CUSTOMER'),array('NM_KAPAL','NAMA KAPAL')));
		$this->newtable->action(site_url() . "/billing/behandle");
		//if($check) $this->newtable->detail(array('POPUP',"billing/behandle/behandle_detail"));
		$this->newtable->tipe_proses('button');
		//$this->newtable->hiddens(array("ID REQUEST"));
		$this->newtable->keys(array("NO REQUEST","NO. DOKUMEN","NO. NOTA BEHANDLE",));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(3);
		$this->newtable->groupby(array("A.ID_REQ"));
		$this->newtable->sortby("DESC");
		$this->newtable->validasi(array("NO. NOTA BEHANDLE"));
		$this->newtable->rowcount(10);
		$this->newtable->set_formid("tblbehandle");
		$this->newtable->set_divid("divtblbehandle");
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			echo $tabel;
		else
			return $arrdata;
	}

	public function tbehandle1($act, $id){
			$page_title = 'Behandle';
			$title = "";
			//$this->newtable->breadcrumb('Planning', site_url(),'icon-home');
			$this->newtable->breadcrumb('Billing', 'javascript:void(0)','');
			$this->newtable->breadcrumb('Behandle', 'javascript:void(0)','');
			$check = (grant()=="W")?true:false;
			$SQL = "SELECT DISTINCT A.ID, A.NO_SPK AS 'NO. SPK', A.TGL_SPK AS 'TANGGAL SPK', CASE WHEN A.JNS_DOK = 19 THEN 'SPJM' ELSE 'SPPMP' END AS 'JENIS DOKUMEN', A.NO_DOK AS 'NO. DOKUMEN', A.TGL_DOK AS 'TANGGAL DOKUMEN' -- ,B.NO_CONT
					FROM t_spk A
					INNER JOIN t_spk_cont B ON A.ID = B.ID
					WHERE FL_BIL IS NULL";
			$this->newtable->multiple_search(true);
			$this->newtable->show_chk(false);
			$this->newtable->show_menu($check);
			$this->newtable->show_search(true);
			$this->newtable->search(array(array('JNS_DOK','JENIS DOKUMEN'),array('NO_DOK','NO. DOKUMEN'),array('B.NO_CONT','NO. KONTAINER')));
			$this->newtable->action(site_url() . "/billing/tbehandle1/post");
			#if($check) 
				$this->newtable->detail(array('POPUP',"billing/behandle/behandle1_detail"));
			$this->newtable->tipe_proses('button');
			$this->newtable->hiddens(array("ID"));
			$this->newtable->keys(array("ID"));
			$this->newtable->cidb($this->db);
			$this->newtable->set_formid("tblbehandle1");
			$this->newtable->set_divid("divtblbehandle1");
			$this->newtable->orderby(1);
			$this->newtable->sortby("ASC");
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

	public function tbehandle2($act, $id){
				$page_title = 'Behandle';
				$title = "";
				//$this->newtable->breadcrumb('Planning', site_url(),'icon-home');
				$this->newtable->breadcrumb('Billing', 'javascript:void(0)','');
				$this->newtable->breadcrumb('Behandle', 'javascript:void(0)','');
				$check = (grant()=="W")?true:false;
				$SQL = "SELECT ID, JNS_DOK AS 'JENIS DOKUMEN', NO_DOK AS 'NO. DOKUMEN', TGL_DOK AS 'TANGGAL DOKUMEN', NO_CONT AS 'NO. KONTAINER', UKR_CONT AS 'UKR_CONT' FROM t_gatepass WHERE JNS_KEGIATAN = 2 AND FL_USE = 'N'";

				// $proses = array('CETAK'  => array('POST',"planning/execute/save/request", '0','','md-print','','menu'));

				$this->newtable->multiple_search(true);
				$this->newtable->show_chk(false);
				$this->newtable->show_menu($check);
				$this->newtable->show_search(true);
				$this->newtable->search(array(array('JNS_DOK','JENIS DOKUMEN'),array('NO_DOK','NO. DOKUMEN'),array('NO_CONT','NO. KONTAINER')));
				$this->newtable->action(site_url() . "/billing/tbehandle2/post");
				//if($check) 
				$this->newtable->detail(array('POPUP',"billing/behandle/behandle2_detail"));
				$this->newtable->tipe_proses('button');
				$this->newtable->hiddens(array("ID"));
				$this->newtable->keys(array("ID"));
				$this->newtable->cidb($this->db);
				$this->newtable->set_formid("tblbehandle2");
				$this->newtable->set_divid("divtblbehandle2");
				$this->newtable->orderby(1);
				$this->newtable->sortby("ASC");
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

	public function billing_detail($act, $id){
		$id = ($id!="")?$id:$this->input->post('id');
		$SQL = $this->db->query("SELECT DISTINCT A.ID, A.NO_SPK,
		A.TGL_SPK, A.JNS_DOK, A.NO_DOK, A.TGL_DOK,
		B.NO_CONT, B.UKR_CONT, C.SIZE, C.KET, C.TARIF
		FROM t_spk A
		INNER JOIN t_spk_cont B
		ON A.ID = B.ID
		INNER JOIN m_tarif C
		ON B.UKR_CONT = C.SIZE
		WHERE A.iD = '$id' AND C.KET='1'");
		return $SQL->result_array();
	}

	public function delivery($act, $id){
		$page_title = 'BILLING DELIVERY';
		$title ="BILLING DELIVERY";
		$this->newtable->breadcrumb('Billing', 'javascript:void(0)','');
		$this->newtable->breadcrumb('Delivery', 'javascript:void(0)','');
		$check =(grant()=="W")?true:false;
		
		/*$SQL = "SELECT CONCAT(A.ID_REQ,'<BR>',A.TGL_REQ) AS 'REQUEST', CONCAT(B.NAMA_CUST,'<BR>',A.NPWP) AS 'CUSTOMER',A.ID_REQ_OLD, CONCAT(A.NO_DOK,'<BR>',A.TGL_DOK) AS 'DOKUMEN',A.ID_REQ AS 'NO REQUEST', A.NO_DOK AS 'NO. DOKUMEN',NM_KAPAL AS 'NAMA KAPAL', A.NO_NOTA_DELIVERY AS 'NO. NOTA DELIVERY', CASE WHEN A.NO_NOTA_DELIVERY > 0 && A.TGL_NOTA > 0 THEN CONCAT(IFNULL(A.NO_NOTA_DELIVERY, NULL),'<BR>', DATE_FORMAT(A.TGL_NOTA, '%d-%m-%Y')) ELSE '' END AS 'NOTA', CONCAT('<span class=\"label label-info\">Rp. ', FORMAT(A.TOTAL,0),'</span>') AS 'TOTAL'
				FROM req_delivery_hdr A
				INNER JOIN m_pelanggan B ON
				REPLACE(
				REPLACE(A.NPWP,'.',''),'-','') =
				REPLACE(
				REPLACE(B.NPWP,'.',''),'-','')/
				WHERE A.ID_REQ_OLD IS NULL";*/
		
		$SQL = "SELECT CONCAT(A.ID_REQ,'<BR>',A.TGL_REQ) AS 'REQUEST', CONCAT(B.CONSIGNEE,'<BR>',A.NPWP) AS 'CUSTOMER',A.ID_REQ_OLD, CONCAT(A.NO_DOK,'<BR>',A.TGL_DOK) AS 'DOKUMEN',A.ID_REQ AS 'NO REQUEST', A.NO_DOK AS 'NO. DOKUMEN',NM_KAPAL AS 'NAMA KAPAL', A.NO_NOTA_DELIVERY AS 'NO. NOTA DELIVERY', CASE WHEN A.NO_NOTA_DELIVERY > 0 && A.TGL_NOTA > 0 THEN CONCAT(IFNULL(A.NO_NOTA_DELIVERY, NULL),'<BR>', DATE_FORMAT(A.TGL_NOTA, '%d-%m-%Y')) ELSE '' END AS 'NOTA', CONCAT('<span class=\"label label-info\">Rp. ', FORMAT(A.TOTAL,0),'</span>') AS 'TOTAL'
				FROM req_delivery_hdr A
				INNER JOIN t_permit_hdr B ON A.NO_DOK = B.NO_DOK_INOUT
				WHERE A.ID_REQ_OLD IS NULL";

		 $proses = array('ENTRY'  => array('MODAL',"billing/delivery/add", '0','','md-plus-circle','', 'menu'),
						'CETAK' => array('PRINT',"billing/cetak_nota_del", '1','','md-print','', 'list'),
						'CONFIRM' => array('MODAL',"billing/delivery/confirm", '1','','md-confirmation-number','', 'list'),
						'HISTORY' => array('MODAL',"billing/delivery/history", '1', '', 'md-watch','','list'),
						'UPDATE' => array('MODAL',"billing/delivery/update", '1','NOT-NULL','md-edit','','list'),
						'DELETE'  => array('DELETE',"billing/delivery/hapus", 'all','','md-close-circle','', 'menu'));
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(true);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('ID_REQ','ID REQUEST'),array('NO_DOK','NO. DOKUMEN'),array('B.CONSIGNEE','CUSTOMER'),array('NM_KAPAL','NAMA KAPAL')));
		$this->newtable->action(site_url() . "/billing/delivery");
		//if($check) $this->newtable->detail(array('POPUP',"billing/behandle/behandle_detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID_REQ_OLD","NO REQUEST","NO. DOKUMEN","NO. NOTA DELIVERY"));
		$this->newtable->keys(array("NO REQUEST","NO. DOKUMEN","NO. NOTA DELIVERY"));
		$this->newtable->validasi(array("NO. NOTA DELIVERY"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->groupby(array("A.ID_REQ"));
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tbldelivery");
		$this->newtable->set_divid("divtbldelivery");
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

	public function delivery_add($act, $id){
		$page_title = 'Delivery';
		$title ="";
		//$this->newtable->breadcrumb('Planning', site_url(),'icon-home');
		$this->newtable->breadcrumb('Billing', 'javascript:void(0)','');
		$this->newtable->breadcrumb('Delivery', 'javascript:void(0)','');
		$check =(grant()=="W")?true:false;
		$SQL = "SELECT A.ID,  A.NO_DOK_INOUT AS 'NO. DOKUMEN', A.TGL_DOK_INOUT AS 'TGL PIB', A.ID_CONSIGNEE AS 'NPWP IMPORTIR', A.CONSIGNEE AS 'NAMA IMPORTIR', A.NO_BC11 AS 'NO BC 11', A.TGL_BC11 AS 'TGL. BC 11' 
				FROM t_permit_hdr A
				INNER JOIN t_permit_cont B ON A.ID = B.ID
				INNER JOIN t_op_inspection C ON B.NO_CONT = C.NO_CONT
				WHERE A.KD_DOK_INOUT  IN('1','5','80','82','14','13','86')
				AND C.STATUS = 'DONE'";
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu(false);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_DOK_INOUT','NO. DOKUMEN'),array('A.TGL_DOK_INOUT','TGL. DOKUMEN'),));
		$this->newtable->action(site_url()."/billing/delivery/add");
		if($check) $this->newtable->detail(array('POPUP',"billing/delivery/save_delivery"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("A.ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(2);
		$this->newtable->sortby("DESC");
		$this->newtable->groupby(array("A.NO_DOK_INOUT"));
		$this->newtable->set_formid("tbldeliveryadd");
		$this->newtable->set_divid("divtbldeliveryadd");
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

	public function delivery_ext_add($act, $id){
		//$page_title = 'BILLING DELIVERY EXTENTION';
		$title ='DELIVERY EXT';
		//$this->newtable->breadcrumb('Planning', site_url(),'icon-home');
		$this->newtable->breadcrumb('Billing', 'javascript:void(0)','');
		$this->newtable->breadcrumb('Delivery', 'javascript:void(0)','');
		$check =(grant()=="W")?true:false;
		$SQL = "SELECT DISTINCT A.ID_REQ AS 'ID', A.TGL_REQ AS 'TANGGGAL',B.NAMA_CUST AS 'CUSTOMER', A.NM_KAPAL AS 'NAMA KAPAL',A.JNS_DOK AS 'JENIS DOKUMEN', A.NO_DOK AS 'NO DOK', A.TGL_DOK AS 'TGL DOK', A.NO_NOTA_DELIVERY FROM req_delivery_hdr A 
				LEFT JOIN m_pelanggan B ON A.NPWP = B.NPWP
				WHERE A.NO_NOTA_DELIVERY > 0";
		
		// $SQL = "SELECT ID_REQ AS 'ID', TGL_REQ,NM_KAPAL,JNS_DOK, NO_DOK, TGL_DOK FROM req_delivery_hdr WHERE NO_NOTA_DELIVERY > 0";

		 /*$proses = array('ENTRY'  => array('MODAL',"billing/delivery/add", '0','','md-plus-circle','', 'menu'),
						'CETAK' => array('MODAL',"billing/delivery/cetak", '1','','md-print','', 'menu'));*/
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.ID_REQ','ID REQUEST'),array('A.NO_DOK','NO. DOKUMEN'),array('B.NAMA_CUST','NAMA CUSTOMER')));
		$this->newtable->action(site_url() . "/billing/delivery_ext/add");
		if($check) $this->newtable->detail(array('POPUP',"billing/delivery_ext/save_delivery"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("ASC");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $title, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			echo $tabel;
		else
			return $arrdata;
	}

	public function delivery_ext($act, $id){
		$page_title = 'Delivery';
		$title ='BILLING DELIVERY EXT';
		$this->newtable->breadcrumb('Billing', 'javascript:void(0)','');
		$this->newtable->breadcrumb('Delivery Extend', 'javascript:void(0)','');
		$check =(grant()=="W")?true:false;

		$SQL = "SELECT CONCAT(A.ID_REQ,'<BR>',A.TGL_REQ) AS 'REQUEST',CONCAT(B.NAMA_CUST,'<BR>',A.NPWP) AS 'CUSTOMER',A.ID_REQ_OLD,
		CONCAT(A.NO_DOK,'<BR>',A.TGL_DOK) AS 'DOKUMEN',A.ID_REQ AS 'NO REQUEST', A.NO_DOK AS 'NO. DOKUMEN', A.NO_NOTA_DELIVERY AS 'NO. NOTA DELIVERY', 
		CONCAT(IFNULL(A.NO_NOTA_DELIVERY,NULL),'<BR>',DATE_FORMAT(A.TGL_NOTA, '%d-%m-%Y')) AS 'NOTA', CONCAT('<span class=\"label label-info\">Rp. ',FORMAT(A.TOTAL,0),'</span>') AS 'TOTAL'
		FROM req_delivery_hdr A JOIN m_pelanggan B ON A.NPWP = B.NPWP WHERE A.ID_REQ_OLD IS NOT NULL";

		// $SQL = "SELECT ID_REQ AS 'ID_REQ', JNS_DOK
		// AS 'JENIS DOKUMEN', NO_DOK AS 'NO. DOKUMEN', NPWP AS 'NO_NPWP' ,TOTAL AS
		// 'TOTAL' FROM req_delivery_hdr WHERE ID_REQ_OLD IS NOT NULL";

		$proses = array('ENTRY'  => array('MODAL',"billing/delivery_ext/add", '0','','md-plus-circle','', 'menu'),
						'CETAK' => array('PRINT',"billing/cetak_nota_ext", '1','','md-print','', 'list'),
						'CONFIRM' => array('MODAL',"billing/delivery_ext/confirm", '1','','md-confirmation-number','', 'list'),
						'HISTORY' => array('MODAL',"billing/delivery_ext/history", '1', '', 'md-watch','','list'),
						'UPDATE' => array('MODAL',"billing/delivery_ext/update", '1','NOT-NULL','md-edit','','list'));

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('ID_REQ','ID REQUEST'),array('NO_DOK','NO. DOKUMEN'),array('B.NAMA_CUST','NAMA CUSTOMER')));
		$this->newtable->action(site_url() . "/billing/delivery_ext");
		//if($check) $this->newtable->detail(array('POPUP',"billing/behandle/behandle_detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID_REQ_OLD","NO REQUEST","NO. DOKUMEN","NO. NOTA DELIVERY"));
		$this->newtable->keys(array("NO REQUEST"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tbldeliveryext");
		$this->newtable->set_divid("divtbldeliveryext");
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

	function execute($type, $act, $id) {
        $func = get_instance();
        $func->load->model("m_main", "main", true);
        $success = 0;
        $error = 0;
        if($type == "save"){
			if($act == "delivery"){
				echo "Save delivery";die();
			}
		}else if($type == "hapus"){
			if($act == "delivery"){
				$exparr = explode('~',$id);
				$id_req = $exparr[0];
				$no_dok = $exparr[1];
				$result = $this->db->delete('req_delivery_dtl', array('ID_REQ' => $id_req));
				$this->db->delete('req_delivery_hdr', array('ID_REQ' => $id_req));

				$this->db->where('NO_DOK_INOUT',$no_dok);
				$this->db->update('t_permit_hdr',array('KD_STATUS_BIL' => NULL));
				print_r($this->db->last_query());

				if (!$result) {
                    $error += 1;
                    $message .= "Data gagal diproses";
                }

                if ($error==0) {
                    echo "MSG#OK#Data berhasil diproses#".site_url()."/billing/delivery/post";
                } else {
                    echo "MSG#ERR#".$message."#";
                }
			}
		}
	}

	public function getSrch($keyword){
		$SQL = $this->db->query("SELECT *
								FROM t_permit_hdr
								WHERE NO_DOK_INOUT
								LIKE '$keyword%' ");
		return $SQL->result_array();
	}

	public function simulasi_dok_sppb($act, $id, $key){
		//echo "Dal";die();
		$page_title = 'SIMULASI';
		$title ="";
		//$this->newtable->breadcrumb('Planning', site_url(),'icon-home');
		$this->newtable->breadcrumb('SIMULASI', 'javascript:void(0)','');
		$this->newtable->breadcrumb('Billing', 'javascript:void(0)','');
		$check =(grant()=="W")?true:false;
		//$SQL = "SELECT ID,  NO_DOK_INOUT AS 'NO. DOKUMEN', TGL_DOK_INOUT AS 'TGL PIB', ID_CONSIGNEE AS 'NPWP IMPORTIR', CONSIGNEE AS 'NAMA IMPORTIR', NO_BC11 AS 'NO BC 11', TGL_BC11 AS 'TGL. BC 11' FROM t_permit_hdr WHERE KD_DOK_INOUT = 1 AND KD_STATUS_BIL IS NULL";
		$SQL = "SELECT ID,  NO_DOK_INOUT AS 'NO. DOKUMEN', TGL_DOK_INOUT AS 'TGL PIB', ID_CONSIGNEE AS 'NPWP IMPORTIR', CONSIGNEE AS 'NAMA IMPORTIR', NO_BC11 AS 'NO BC 11', TGL_BC11 AS 'TGL. BC 11'
				FROM t_permit_hdr
				WHERE KD_DOK_INOUT = 1
				AND KD_STATUS_BIL IS NULL
				AND NO_DOK_INOUT = '$key' ";
		 /*$proses = array('ENTRY'  => array('MODAL',"billing/delivery/add", '0','','md-plus-circle','', 'menu'),
						'CETAK' => array('MODAL',"billing/delivery/cetak", '1','','md-print','', 'menu'));*/
		$this->newtable->multiple_search(false);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu(false);
		$this->newtable->show_search(false);
		$this->newtable->search(array(array('NO_DOK_INOUT','NO. DOKUMEN'),array('TGL_DAFTAR_PABEAN','TGL. PIB'),));
		$this->newtable->action(site_url()."/customer/simulasi_billing");
		if($check) $this->newtable->detail(array('POPUP',"customer/simulasi_billing/add"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(2);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblsimulasi");
		$this->newtable->set_divid("divtblsimulasi");
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
