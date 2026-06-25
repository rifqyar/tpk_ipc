<?php if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class M_report_new extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}
	function penarikan()
	{
		$page_title = "REPORT PENARIKAN BEHANDLEIN";
		$title = "REPORT PENARIKAN BEHANDLEIN";
		$this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
		$this->newtable->breadcrumb('Monitoring', 'javascript:void(0)', '');
		$this->newtable->breadcrumb('PENARIKAN', 'javascript:void(0)', '');
		$check = (grant() == "W") ? true : false;

		$SQL = "SELECT distinct A.NO_SPK, B.NO_CONT AS 'KONTAINER',B.UKR_CONT AS 'SIZE', D.VESSEL as'NAMA KAPAL',
				CASE WHEN D.KD_CONT_JENIS ='F' THEN 'FL' ELSE 'MT' END AS 'STATUS', D.ISO_CODE,
				D.TIPE_CONT AS 'TIPE', D.IMO,
				Z.NAMA as 'JENIS DOKUMEN',
				A.NO_DOK as 'NO DOKUMEN',
				A.TGL_DOK as 'TGL DOKUMEN',
				A.CONSIGNEE as 'CUSTOMERS',
				E.W_PICKUP as 'PICKUP',
				B.ID_FLAT as 'TID',
				F.W_BEHANDLE as 'BEHANDLE IN',
				CASE WHEN B.STATUS_CONT IN('450','460','500','510','520','530','540','600','800','850','870','900') THEN '<span class=\"label label-warning\">ON COMMON AREA</span>' WHEN B.STATUS_CONT = '200' THEN '<span class=\"label label-warning\"style=\"background: yellow\"><font color=\"black\">ON PROCESS</font></span>' ELSE '<span class=\"label label-success\">ON TERMINAL</span>' END AS 'STATUS PENARIKAN'
				from t_spk A
				join t_spk_cont B on A.ID = B.ID
				left join t_request C on C.NO_DOK = A.NO_DOK and C.TGL_DOK = A.TGL_DOK
				left join t_request_cont D on C.ID = D.ID and D.NO_CONT = B.NO_CONT
				LEFT JOIN t_op_pickup E  ON E.NO_SPK = A.NO_SPK 
				AND E.NO_CONT = B.NO_CONT
				AND E.W_PICKUP = (
					SELECT MAX(W_PICKUP) 
					FROM t_op_pickup 
					WHERE NO_CONT = B.NO_CONT 
						AND NO_SPK = A.NO_SPK
				)
				LEFT JOIN t_op_behandlein F  ON F.NO_SPK = A.NO_SPK  AND F.NO_CONT = B.NO_CONT
				AND F.W_BEHANDLE = (
					SELECT MAX(W_BEHANDLE) 
					FROM t_op_behandlein 
					WHERE NO_CONT = B.NO_CONT 
						AND NO_SPK = A.NO_SPK
				)
				join reff_kode_dok_bc Z on Z.ID = A.JNS_DOK
				WHERE A.WK_REQ > '2024-01-01'";

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$proses = array('EXPORT EXCEL PENARIKAN - BEHANDLE IN' => array('EXCEL', "process1/excel/penarikan1/" . $act, '0', '', 'md-file-text', '', 'menu'));
		$arr_sts = array("" => "", "450" => "ON COMMON AREA", "200" => "ON PROCESS");
		$this->newtable->search(array(array('B.STATUS_CONT', 'STATUS PENARIKAN', 'OPTION', $arr_sts), array('F.W_BEHANDLE', 'TANGGAL BEHANDLE IN', 'DATETIMERANGE'), array('E.W_PICKUP', 'WAKTU PICKUP', 'DATETIMERANGE')));
		$this->newtable->action(site_url() . "/report_new/penarikan");
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens();
		$this->newtable->keys(array("NO SPK"));
		$this->newtable->cidb($this->db);
		$this->newtable->groupby();
		$this->newtable->orderby("F.W_BEHANDLE DESC");
		$this->newtable->sortby("");
		$this->newtable->set_formid("tblmonitoringpenarikan");
		$this->newtable->set_divid("divmonitoringpenarikan");
		$this->newtable->rowcount(1000);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if ($this->input->post("ajax") || $act == "post")
			return $tabel;
		else
			return $arrdata;
	}


}
?>