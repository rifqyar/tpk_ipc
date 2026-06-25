<?php defined('BASEPATH') or exit('No direct script access allowed');

class Apibehandle extends CI_Controller
{
	public $content;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_home');
	}
	public function getdata(){
		$data = json_decode(file_get_contents('php://input'), true);
		header('Content-Type: application/json');
		$key = 'bXRp8cd1dd4afdff53aa86e959e2db0486d2';
		$start = $data['startdate'];
		$end = $data['enddate'];

		if($data["key"] == $key){
			$q = $this->db->query("SELECT distinct 
				tg2.NO_CONT as 'NO_CONT',
				tob.W_BEHANDLE as 'WK_BEHANDLE_IN',
				rkdb.NAMA,
				tg2.NO_DOK,
				tg2.TGL_DOK,
				toi.START_INSP as 'MULAI_PEMERIKSAAN',
				toi.FINISH_INSP as 'SELESAI_PEMERIKSAAN',
				tod.WK_TRUCKIN as 'LIFT_OFF_DELIVERY',
				tg.JNS_DOK as 'JENIS_DOK_PENGELUARAN',
				tg.NO_DOK as 'NO_DOK_PENGELUARAN',
				tg.TGL_DOK as 'TGL_DOK_PENGELUARAN',
				tod.WK_GATEOUT as 'TGL_GATEOUT',
				tg.NAMA_CUST,
				tg.NPWP as 'NPWP_CUST',
				rbh.TOTAL_JUMLAH as 'NILAI_INVOICE_BEHANDLE',
				rdh.TOTAL as 'NILAI_INVOICE_DELIVERY'
				from t_gatepass tg2
				join t_spk ts on tg2.NO_DOK = ts.NO_DOK and ts.TGL_DOK = tg2.TGL_DOK
				join t_op_behandlein tob on ts.NO_SPK = tob.NO_SPK and tg2.NO_CONT = tob.NO_CONT
				join t_op_inspection toi on toi.NO_CONT = tg2.NO_CONT and toi.NO_SPK = ts.NO_SPK 
				join t_op_delivery tod on tod.NO_CONT = tg2.NO_CONT and tod.NO_SPK = ts.NO_SPK 
				join t_gatepass tg on tg.NO_CONT = tg2.NO_CONT and tg.NO_SPK = ts.NO_SPK
				join reff_kode_dok_bc rkdb on ts.JNS_DOK = rkdb.ID
				join req_behandle_hdr rbh on rbh.NO_DOK = ts.NO_DOK and rbh.TGL_DOK = ts.TGL_DOK
				join req_delivery_hdr rdh on rdh.NO_DOK = tg.NO_DOK and rdh.TGL_DOK = tg.TGL_DOK
				where tod.WK_GATEOUT between '$start' and '$end' and tg.JNS_KEGIATAN = '3'");
			echo json_encode($q->result());
		} else {
			echo 'invalid key';
		}
	}
	public function getdatadev(){
		$data = json_decode(file_get_contents('php://input'), true);
		header('Content-Type: application/json');
		$key = 'bXRp8cd1dd4afdff53aa86e959e2db0486d2';
		$start = $data['startdate'];
		$end = $data['enddate'];

		if($data["key"] == $key){
			$q = $this->db->query("SELECT distinct 
				tg2.NO_CONT as 'NO_CONT',
				tob.W_BEHANDLE as 'WK_BEHANDLE_IN',
				rkdb.NAMA,
				tg2.NO_DOK,
				tg2.TGL_DOK,
				toi.START_INSP as 'MULAI_PEMERIKSAAN',
				toi.FINISH_INSP as 'SELESAI_PEMERIKSAAN',
				tod.WK_TRUCKIN as 'LIFT_OFF_DELIVERY',
				tg.JNS_DOK as 'JENIS_DOK_PENGELUARAN',
				tg.NO_DOK as 'NO_DOK_PENGELUARAN',
				tg.TGL_DOK as 'TGL_DOK_PENGELUARAN',
				tod.WK_GATEOUT as 'TGL_GATEOUT',
				tg.NAMA_CUST,
				tg.NPWP as 'NPWP_CUST',
				rbh.TOTAL_JUMLAH as 'NILAI_INVOICE_BEHANDLE',
				rdh.TOTAL as 'NILAI_INVOICE_DELIVERY'
				from t_gatepass tg2
				join t_spk ts on tg2.NO_DOK = ts.NO_DOK and ts.TGL_DOK = tg2.TGL_DOK
				join t_op_behandlein tob on ts.NO_SPK = tob.NO_SPK and tg2.NO_CONT = tob.NO_CONT
				join t_op_inspection toi on toi.NO_CONT = tg2.NO_CONT and toi.NO_SPK = ts.NO_SPK 
				join t_op_delivery tod on tod.NO_CONT = tg2.NO_CONT and tod.NO_SPK = ts.NO_SPK 
				join t_gatepass tg on tg.NO_CONT = tg2.NO_CONT and tg.NO_SPK = ts.NO_SPK
				join reff_kode_dok_bc rkdb on ts.JNS_DOK = rkdb.ID
				join req_behandle_hdr rbh on rbh.NO_DOK = ts.NO_DOK and rbh.TGL_DOK = ts.TGL_DOK
				join req_delivery_hdr rdh on rdh.NO_DOK = tg.NO_DOK and rdh.TGL_DOK = tg.TGL_DOK
				where tod.WK_GATEOUT between '$start' and '$end' and tg.JNS_KEGIATAN = '3'");
			echo json_encode($q->result());
		} else {
			echo 'invalid key';
		}
	}
}