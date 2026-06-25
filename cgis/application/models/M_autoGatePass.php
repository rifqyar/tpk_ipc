<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class M_autoGatePass extends CI_Model {

		public function __construct(){
			parent::__construct();

		}
		public function list_reqGatePass($act, $id){
			$func = get_instance();
        	$func->load->model("m_main", "main", true);
			$page_title = 'REQUEST GATE PASS';
			$title = "REQUEST GATE PASS";

			$check = (grant()=="W")?true:false;
				
				$SQLTEMP1 = "SELECT DISTINCT 
						CONCAT('NO : ',(A.NO_DOK),'<BR>TGL : ', (DATE_FORMAT(B.TGL_DOK,'%d-%m-%Y'))) AS 'DOKUMEN',
						B.KD_REQ AS 'STATUS',
						B.ID AS 'ID',
						B.RESPONSE_REQ AS 'RESPONSE',
						DATE_FORMAT(B.WK_REKAM, '%d-%m-%Y %H:%i:%s') AS 'DOKUMEN MASUK',
						CASE 
							WHEN B.KD_REQ = 'DRAFT' THEN '<span class=\"label label-danger\">DRAFT</span>'
							WHEN B.KD_REQ = 'QUEUED' THEN '<span class=\"label label-warning\">QUEUED</span>'
							WHEN B.KD_REQ = 'SENT' THEN '<span class=\"label label-success\">SENT</span>'
							WHEN B.KD_REQ = 'APPROVED' THEN '<span class=\"label label-primary\">APPROVED</span>'
							WHEN B.KD_REQ = 'INQUIRY' THEN '<span class=\"label label-success\">INQUIRY</span>'
							ELSE B.RESPONSE_REQ
						END AS 'STATUS_REQUEST',
						C.NO_SPK,
						D.NO_SPK AS 'SPK_BEHANDLE_IN'
					FROM 
						t_rekon_dokumen_npct1 A
						LEFT JOIN t_request B 
							ON A.NO_DOK = B.NO_DOK AND A.TGL_DOK = B.TGL_DOK
						LEFT JOIN t_spk C 
							ON B.NO_DOK = C.NO_DOK AND B.TGL_DOK = C.TGL_DOK
						LEFT JOIN t_op_behandlein D 
							ON C.NO_SPK = D.NO_SPK
					WHERE 
						D.NO_SPK IS NULL
					";
// AND D.TIPE_CONT != 'RFR'
			$SQLTEMP2 = "SELECT DISTINCT 
						CONCAT('NO : ',(A.NO_DOK),'<BR>TGL : ', (DATE_FORMAT(B.TGL_DOK,'%d-%m-%Y'))) AS 'DOKUMEN',
						B.KD_REQ AS 'STATUS',
						B.ID AS 'ID',
						B.RESPONSE_REQ AS 'RESPONSE',
						DATE_FORMAT(B.WK_REKAM, '%d-%m-%Y %H:%i:%s') AS 'DOKUMEN MASUK',
						CASE 
							WHEN B.KD_REQ = 'DRAFT' THEN '<span class=\"label label-danger\">DRAFT</span>'
							WHEN B.KD_REQ = 'QUEUED' THEN '<span class=\"label label-warning\">QUEUED</span>'
							WHEN B.KD_REQ = 'SENT' THEN '<span class=\"label label-success\">SENT</span>'
							WHEN B.KD_REQ = 'APPROVED' THEN '<span class=\"label label-primary\">APPROVED</span>'
							WHEN B.KD_REQ = 'INQUIRY' THEN '<span class=\"label label-success\">INQUIRY</span>'
							ELSE B.RESPONSE_REQ
						END AS 'STATUS_REQUEST',
						C.NO_SPK,
						D.NO_SPK AS 'SPK_BEHANDLE_IN'
					FROM 
						t_rekon_dokumen_npct1 A
						LEFT JOIN t_request B 
							ON A.NO_DOK = B.NO_DOK AND A.TGL_DOK = B.TGL_DOK
						LEFT JOIN t_spk C 
							ON B.NO_DOK = C.NO_DOK AND B.TGL_DOK = C.TGL_DOK
						LEFT JOIN t_op_behandlein D 
							ON C.NO_SPK = D.NO_SPK
					WHERE 
						D.NO_SPK IS NULL";// AND D.TIPE_CONT != 'RFR'
			$SQLTEMP3 = "SELECT DISTINCT 
						CONCAT('NO : ',(A.NO_DOK),'<BR>TGL : ', (DATE_FORMAT(B.TGL_DOK,'%d-%m-%Y'))) AS 'DOKUMEN',
						B.KD_REQ AS 'STATUS',
						B.ID AS 'ID',
						B.RESPONSE_REQ AS 'RESPONSE',
						DATE_FORMAT(B.WK_REKAM, '%d-%m-%Y %H:%i:%s') AS 'DOKUMEN MASUK',
						CASE 
							WHEN B.KD_REQ = 'DRAFT' THEN '<span class=\"label label-danger\">DRAFT</span>'
							WHEN B.KD_REQ = 'QUEUED' THEN '<span class=\"label label-warning\">QUEUED</span>'
							WHEN B.KD_REQ = 'SENT' THEN '<span class=\"label label-success\">SENT</span>'
							WHEN B.KD_REQ = 'APPROVED' THEN '<span class=\"label label-primary\">APPROVED</span>'
							WHEN B.KD_REQ = 'INQUIRY' THEN '<span class=\"label label-success\">INQUIRY</span>'
							ELSE B.RESPONSE_REQ
						END AS 'STATUS_REQUEST',
						C.NO_SPK,
						D.NO_SPK AS 'SPK_BEHANDLE_IN'
					FROM 
						t_rekon_dokumen_npct1 A
						LEFT JOIN t_request B 
							ON A.NO_DOK = B.NO_DOK AND A.TGL_DOK = B.TGL_DOK
						LEFT JOIN t_spk C 
							ON B.NO_DOK = C.NO_DOK AND B.TGL_DOK = C.TGL_DOK
						LEFT JOIN t_op_behandlein D 
							ON C.NO_SPK = D.NO_SPK
					WHERE 
						D.NO_SPK IS NULL";// AND D.TIPE_CONT != 'RFR'

			if ($_POST['ajax'] == 1) {
				if ($_POST['page'] == 1) {
					$dat = "";
					$p_khusus = "";
					foreach ($_POST['form'] as $key => $value) {
						if ($value[0] != "") {
							$dat = $value[0];
							if ($key < 4) {
								$p_khusus = "ada";
							}
						}
					}
					if ($dat == "") {
						$SQL = $SQLTEMP1;
					}else {
						if ($p_khusus == "") {
							$SQL = $SQLTEMP2;
						}else {
							$SQL = $SQLTEMP3;
						}
					}
				}else{
					$SQL = $SQLTEMP1;
				}
			}else {
				$SQL = $SQLTEMP1;
			}
			
			$proses = array('SEND MAIL'  => array('MODAL',"RequestGatePass/gatepassBc/add_paidThrough_karantina", '1','','md-email','','list'),
							'PRINT EXCEL'  => array('EXCEL', "proces/excel/gatepassBc", '0','','md-file-text','','menu'));

			$this->newtable->multiple_search(true);
			$this->newtable->show_chk(false);
			$this->newtable->show_menu($check);
			$this->newtable->show_search(true);
			$arr_sts2 = array(""=>"","DRAFT"=>"DRAFT","QUEUED" => "QUEUED", "SENT" => "SENT", "APPROVED" => "APPROVED", "REJECTED" => "REJECTED", "ERROR" => "ERROR", "INQUIRY" => "INQUIRY", "BYPASS" => "BYPASS");
			$this->newtable->search(array(array('A.NO_CONT','NO. KONTAINER'),array('A.NO_DOK','NO. DOKUMEN'),array('B.KD_REQ','STATUS PENGIRIMAN','OPTION',$arr_sts2)));
			$this->newtable->action(site_url() . "/AutoGatePass/gatepassNPCT");
			if($check) $this->newtable->detail(array('POPUP',"AutoGatePass/gatepassNPCT/gate_pass_request_detail"));
			$this->newtable->tipe_proses('button');
			$this->newtable->hiddens(array("ID","NO_CONT","STATUS_PENGIRIMAN", "STATUS","TANGGAL","SPK_BEHANDLE_IN"));
			$this->newtable->keys(array("ID"));
			$this->newtable->cidb($this->db);
			$this->newtable->orderby("A.TGL_DOK DESC"); 
			$this->newtable->sortby("");
			$this->newtable->groupby();
			$this->newtable->set_formid("tblrequestgatepassBc");
			$this->newtable->set_divid("divtblrequestgatepassBC");
			$this->newtable->rowcount(35);
			$this->newtable->clear();
			$this->newtable->menu($proses);
			$tabel .= $this->newtable->generate($SQL);
			$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
			if($this->input->post("ajax")||$act == "post")
				echo $tabel;
			else
				return $arrdata;
		}

		public function get_data($act, $id, $store){
			$func = get_instance();
        	$func->load->model("m_main", "main");
        	if ($act == 'gate_pass_request_detail') {
				$getJnsDok = "SELECT JNS_DOK FROM t_request WHERE id = '$id'";
				$restultDok = $this->db->query($getJnsDok)->result_array();
				$jns_dokumen = $restultDok[0]['JNS_DOK'];
				if($jns_dokumen == 83){
					$SQL = "SELECT B.*, E.NAMA, A.CONSIGNEE, '83' AS KD_DOK, G.ISO_CODE AS 'ISO_CODE_DETAIL'
					FROM t_request A
					LEFT JOIN t_request_cont B ON B.ID = A.ID
					LEFT JOIN t_ppk_hdr C ON A.NO_DOK = C.NO_RESPON
					LEFT JOIN t_ppk_cont D ON C.ID_IJIN = D.ID_IJIN
					LEFT JOIN reff_status_cont E ON E.ID = D.KD_STATUS
					LEFT JOIN t_lic_hdr F ON C.NO_RESPON = F.NO_IJIN
					LEFT JOIN t_cocostscont G ON B.NO_CONT = G.NO_CONT
					WHERE A.id = '$id'
					GROUP BY B.NO_CONT
					ORDER BY B.FLAG_FINISH_PRINT = 'Y' ASC";
				} else {
					$SQL = "SELECT B.*, E.NAMA, A.CONSIGNEE, C.KD_DOK_INOUT AS KD_DOK, G.ISO_CODE AS 'ISO_CODE_DETAIL',D.FL_PERIKSA
							FROM t_request A
							LEFT JOIN t_request_cont B ON B.ID = A.ID
							LEFT JOIN t_permit_hdr C ON A.NO_DOK = C.NO_DAFTAR_PABEAN AND C.KD_DOK_INOUT = A.JNS_DOK
							LEFT JOIN t_permit_cont D ON C.ID = D.ID AND B.NO_CONT = D.NO_CONT
							LEFT JOIN reff_status_cont E ON E.ID = D.KD_STATUS
							LEFT JOIN t_cocostscont G ON B.NO_CONT = G.NO_CONT
							WHERE A.id = '$id'
							GROUP BY B.NO_CONT
							ORDER BY B.FLAG_FINISH_PRINT = 'Y' ASC";
				}
				//echo $SQL;
				$result = $this->db->query($SQL);
				return $result->result();
			}else if ($act == 'gate_pass_request_detailjoin') {
				$getJnsDok = "SELECT JNS_DOK FROM t_request WHERE id = '$id'";
				$restultDok = $this->db->query($getJnsDok)->result_array();
				$jns_dokumen = $restultDok[0]['JNS_DOK'];
				if($jns_dokumen == 83){
					$SQL = "SELECT B.*, E.NAMA, A.CONSIGNEE, '83' AS KD_DOK, G.ISO_CODE AS 'ISO_CODE_DETAIL',FL_LNSW_PERIKSA as 'FL_PERIKSA'
					FROM t_request A
					LEFT JOIN t_request_cont B ON B.ID = A.ID
					LEFT JOIN t_ppk_hdr C ON A.NO_DOK = C.NO_RESPON
					LEFT JOIN t_ppk_cont D ON C.ID_IJIN = D.ID_IJIN
					LEFT JOIN reff_status_cont E ON E.ID = D.KD_STATUS
					LEFT JOIN t_lic_hdr F ON C.NO_RESPON = F.NO_IJIN
					LEFT JOIN t_cocostscont G ON B.NO_CONT = G.NO_CONT
					WHERE A.id = '$id'
					GROUP BY B.NO_CONT
					ORDER BY B.FLAG_FINISH_PRINT = 'Y' ASC";
				} else {
					$SQL = "SELECT B.*, E.NAMA, A.CONSIGNEE, C.KD_DOK_INOUT AS KD_DOK, G.ISO_CODE AS 'ISO_CODE_DETAIL',D.FL_PERIKSA
							FROM t_request A
							LEFT JOIN t_request_cont B ON B.ID = A.ID
							LEFT JOIN t_permit_hdr C ON A.NO_DOK = C.NO_DAFTAR_PABEAN AND C.KD_DOK_INOUT = A.JNS_DOK
							LEFT JOIN t_permit_cont D ON C.ID = D.ID AND B.NO_CONT = D.NO_CONT
							LEFT JOIN reff_status_cont E ON E.ID = D.KD_STATUS
							LEFT JOIN t_cocostscont G ON B.NO_CONT = G.NO_CONT
							WHERE A.id = '$id'
							GROUP BY B.NO_CONT
							ORDER BY B.FLAG_FINISH_PRINT = 'Y' ASC";
				}
				//echo $SQL;
				$result = $this->db->query($SQL);
				return $result->result();
        	}
		}

	}
?>