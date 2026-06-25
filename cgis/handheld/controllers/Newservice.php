<?php defined('BASEPATH') or exit('No direct script access allowed');

class Newservice extends CI_Controller
{
    public $content;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_home');
    }
    public function contlocation(){
    	header('Content-Type: application/xml');
    	$dataPOST = trim(file_get_contents('php://input'));
    	$xmlData = simplexml_load_string($dataPOST);
    	// $xml = simplexml_load_string($raw_post);
    	// echo $xml;
    	// $test = $xmlData->container;
    	// var_dump($test);
    	echo "<response>";
    	foreach ($xmlData->container as $contdata){
    		$container = $contdata;
    		    	$q = $this->db->query("SELECT distinct tg.NO_CONT, tg.UKR_CONT, trc.KD_CONT_JENIS, trc.ISO_CODE, tsc.LOKASI, trc.VESSEL, trc.CALL_SIGN, trc.VOY_IN, 
			CASE WHEN trc.TIPE_CONT ='RFR' THEN 'Y' ELSE 'N' END AS 'RFR', trc.FL_DG, trc.FL_OOG, rb.PRN_BEHANDLE_IN as 'BEHANDLEIN', trc.DISCHARGE,
			CASE WHEN tg2.STATUS ='WAITING' THEN 'ACTIVE' ELSE 'INACTIVE' END AS 'GATEPASS'
			from t_gatepass tg 
			join t_request tr on tg.NO_DOK = tr.NO_DOK and tg.TGL_DOK = tr.TGL_DOK 
			join t_request_cont trc on tr.ID = trc.ID
			join t_spk ts on tg.NO_DOK = ts.NO_DOK and tg.TGL_DOK = ts.TGL_DOK 
			join t_spk_cont tsc on ts.ID = tsc.ID
			join report_behandle rb on tg.NO_CONT = rb.NO_CONT and tg.NO_CONT = rb.NO_CONT
			left join t_gatepass tg2 on ts.NO_SPK = tg2.NO_SPK and tg.NO_CONT = tg2.NO_CONT
			where tg.NO_CONT = '$container'
			order by tg.ID desc limit 1");
        // var_dump($q);die();
        foreach ($q->result() as $key => $value1) {
        	$xml = '<container>
						<direction>OUT</direction>
						<cont_no>'.$value1->NO_CONT.'</cont_no>
						<cont_size>'.$value1->UKR_CONT.'</cont_size>
						<full_empty>'.$value1->KD_CONT_JENIS.'</full_empty>
						<isocode>'.$value1->ISO_CODE.'</isocode>
						<location>'.$value1->LOKASI.'</location>
						<vessel_name>'.$value1->VESSEL.'</vessel_name>
						<call_sign>'.$value1->CALL_SIGN.'</call_sign>
						<voyage>'.$value1->VOY_IN.'</voyage>
						<reefer>'.$value1->RFR.'</reefer>
						<imdg>'.$value1->FL_DG.'</imdg>
						<oog>'.$value1->FL_OOG.'</oog>
						<in_time>'.$value1->NO_CONT.'</in_time>
						<stacking_time>'.date_format(new DateTime($value1->BEHANDLEIN), 'YmdHis').'</stacking_time>
						<gatepass>'.$value1->GATEPASS.'</gatepass>
					</container>';
	        $xmlrespon = simplexml_load_string($xml);
	        echo $xml;
	        }
    	}
    	echo "</response>";
    }
    public function contlocation1(){
		header('Content-Type: application/xml');
    	$container = $this->input->post('CONTAINER');
    	$q = $this->db->query("SELECT distinct tg.NO_CONT, tg.UKR_CONT, trc.KD_CONT_JENIS, trc.ISO_CODE, tsc.LOKASI, trc.VESSEL, trc.CALL_SIGN, trc.VOY_IN, 
			CASE WHEN trc.TIPE_CONT ='RFR' THEN 'Y' ELSE 'N' END AS 'RFR', trc.FL_DG, trc.FL_OOG, rb.PRN_BEHANDLE_IN as 'BEHANDLEIN', trc.DISCHARGE,
			CASE WHEN tg2.STATUS ='WAITING' THEN 'ACTIVE' ELSE 'INACTIVE' END AS 'GATEPASS'
			from t_gatepass tg 
			join t_request tr on tg.NO_DOK = tr.NO_DOK and tg.TGL_DOK = tr.TGL_DOK 
			join t_request_cont trc on tr.ID = trc.ID
			join t_spk ts on tg.NO_DOK = ts.NO_DOK and tg.TGL_DOK = ts.TGL_DOK 
			join t_spk_cont tsc on ts.ID = tsc.ID
			join report_behandle rb on tg.NO_CONT = rb.NO_CONT and tg.NO_CONT = rb.NO_CONT
			left join t_gatepass tg2 on ts.NO_SPK = tg2.NO_SPK and tg.NO_CONT = tg2.NO_CONT
			where tg.NO_CONT = '$container'
			order by tg.ID desc limit 1");
        // var_dump($q);die();
        $nocon11 = "";
        foreach ($q->result() as $key => $value1) {
        	$xml = '<response>
        				<container>
							<direction>OUT</direction>
							<cont_no>'.$value1->NO_CONT.'</cont_no>
							<cont_size>'.$value1->UKR_CONT.'</cont_size>
							<full_empty>'.$value1->KD_CONT_JENIS.'</full_empty>
							<isocode>'.$value1->ISO_CODE.'</isocode>
							<location>'.$value1->LOKASI.'</location>
							<vessel_name>'.$value1->VESSEL.'</vessel_name>
							<call_sign>'.$value1->CALL_SIGN.'</call_sign>
							<voyage>'.$value1->VOY_IN.'</voyage>
							<reefer>'.$value1->RFR.'</reefer>
							<imdg>'.$value1->FL_DG.'</imdg>
							<oog>'.$value1->FL_OOG.'</oog>
							<in_time>'.$value1->NO_CONT.'</in_time>
							<stacking_time>'.date_format(new DateTime($value1->BEHANDLEIN), 'YmdHis').'</stacking_time>
							<gatepass>'.$value1->GATEPASS.'</gatepass>
						</container>
					</response>';
        $xmlrespon = simplexml_load_string($xml);
        echo $xml;
        }
    }
}