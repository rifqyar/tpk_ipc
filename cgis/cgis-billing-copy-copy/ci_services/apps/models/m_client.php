<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_client extends CI_Model{

	function create_xml_coco($aprf,$method){
		$func =&get_instance();
		$func->load->model("m_main","main", true);
		$V_STR_DATA = "";
		$array_coco = array('CoCoCont_Tes','CoCoKms_Tes','CoarriCodeco_Container','CoarriCodeco_Kemasan');
		if(!in_array($method,$array_coco)){
			echo "Check method";
			exit();
		}
		$SQL = "SELECT LOWER(A.NM_TABLE) AS NM_TABLE, A.FIELD1, A.VALUE1, A.FIELD2, A.VALUE2, A.FIELD3, A.VALUE3, 
				C.KD_ORG_SENDER, C.KD_ORG_RECEIVER, A.ID
				FROM app_komunikasi A INNER JOIN app_setting B ON A.KD_SETTING = B.ID
				INNER JOIN app_setting C ON A.KD_SETTING = C.ID
				WHERE A.KD_STATUS = '100'
				AND B.KD_APRF = ".$this->db->escape($aprf);
		$result = $func->main->get_result($SQL);
		if($result){
			foreach($SQL->result_array() as $row => $value){
				$arrdata[] = $value;
			}
			$KD_DOK = NULL;
			switch($aprf){
				#discharge [impor]
				case in_array($aprf,array('SENTDISCHBC','SENTDISCHDJP')) 			: $KD_DOK = '1'; break; 
				#loading [ekspor]
				case in_array($aprf,array('SENTLOADBC','SENTLOADDJP')) 				: $KD_DOK = '2'; break;
				#gate out lini 1 [impor]
				case in_array($aprf,array('SENTCODOUTBC','SENTCODOUTDJP'))			: $KD_DOK = '3'; break;
				#gate in lini 1 [ekspor]
				case in_array($aprf,array('SENTCODINBC','SENTCODINDJP'))			: $KD_DOK = '4'; break;
				#gate in lini 2 [impor]
				case in_array($aprf,array('SENTGATEINIMPBC','SENTGATEINIMPDJP'))	: $KD_DOK = '5'; break;
				#gate out lini 2 [impor]
				case in_array($aprf,array('SENTGATEOUTIMPBC','SENTGATEOUTIMPDJP'))	: $KD_DOK = '6'; break;
				#gate in lini 2 [ekspor]
				case in_array($aprf,array('SENTGATEINEXPBC','SENTGATEINEXPDJP'))	: $KD_DOK = '7'; break;
				#gate out lini 2 [ekspor]
				case in_array($aprf,array('SENTGATEOUTEXPBC','SENTGATEOUTEXPDJP'))	: $KD_DOK = '8'; break;
			}
			$aprf_in  = array('SENTDISCHBC','SENTDISCHDJP','SENTDISCHSHL','SENTCODINBC','SENTCODINDJP','SENTCODINSHL','SENTGATEINIMPBC',
							  'SENTGATEINIMPDJP','SENTGATEINIMPSHL','SENTGATEINEXPBC','SENTGATEINEXPDJP','SENTGATEINEXPSHL');
			$aprf_out = array('SENTLOADBC','SENTLOADDJP','SENTLOADSHL','SENTCODOUTBC','SENTCODOUTDJP','SENTCODOUTSHL','SENTGATEOUTIMPBC',
							  'SENTGATEOUTIMPDJP','SENTGATEOUTIMPBC','SENTGATEOUTEXPBC','SENTGATEOUTEXPDJP','SENTGATEOUTEXPSHL');
			if(count($arrdata) > 0){
				foreach($arrdata as $data){
					if($data['FIELD1'] != "") $ADD_SQL .= " AND A.".$data['FIELD1']." = ".$this->db->escape($data['VALUE1']);
					if($data['FIELD2'] != "") $ADD_SQL .= " AND A.".$data['FIELD2']." = ".$this->db->escape($data['VALUE2']);
					if($data['FIELD3'] != "") $ADD_SQL .= " AND A.".$data['FIELD3']." = ".$this->db->escape($data['VALUE3']);
					switch($data['NM_TABLE']){
						case "t_cocostscont" : 
						$SQL = "SELECT A.ID, A.NO_CONT, A.KD_CONT_UKURAN, A.KD_CONT_JENIS, A.KD_CONT_TIPE, A.KD_ISO_CODE, A.BRUTO, 
								A.NO_SEGEL, A.NO_BL_AWB, DATE_FORMAT(A.TGL_BL_AWB,'%Y%m%d') AS TGL_BL_AWB, A.NO_MASTER_BL_AWB, 
								DATE_FORMAT(A.TGL_MASTER_BL_AWB,'%Y%m%d') AS TGL_MASTER_BL_AWB, A.NO_POS_BC11, A.KD_ORG_CONSIGNEE, 
								A.KD_TIMBUN_KAPAL, A.KD_TIMBUN, A.KD_PEL_MUAT, A.KD_PEL_TRANSIT, A.KD_PEL_BONGKAR, A.KD_DOK_IN, A.NO_DOK_IN, 
								DATE_FORMAT(A.TGL_DOK_IN,'%Y%m%d') AS TGL_DOK_IN, DATE_FORMAT(A.WK_IN,'%Y%m%d%H%i%s') AS WK_IN, 
								A.KD_CONT_STATUS_IN, A.KD_SARANA_ANGKUT_IN, A.NO_POL_IN, A.KD_DOK_OUT, A.NO_DOK_OUT, A.KD_KANTOR_PABEAN,
								DATE_FORMAT(A.TGL_DOK_OUT,'%Y%m%d') AS TGL_DOK_OUT, DATE_FORMAT(A.WK_OUT,'%Y%m%d%H%i%s') AS WK_OUT,
								A.KD_CONT_STATUS_OUT, A.KD_SARANA_ANGKUT_OUT, A.NO_POL_OUT, A.KD_TPS_TUJUAN, A.KD_GUDANG_TUJUAN,
								A.NO_DAFTAR_PABEAN, DATE_FORMAT(A.TGL_DAFTAR_PABEAN,'%Y%m%d') AS TGL_DAFTAR_PABEAN, A.NO_SEGEL_BC, 
								DATE_FORMAT(A.TGL_SEGEL_BC,'%Y%m%d') AS TGL_SEGEL_BC, A.NO_IJIN_TPS, 
								DATE_FORMAT(A.TGL_IJIN_TPS,'%Y%m%d') AS TGL_IJIN_TPS, DATE_FORMAT(A.WK_REKAM,'%Y%m%d%H%i%s') AS WK_REKAM, 
								B.KD_ASAL_BRG, B.KD_TPS, B.KD_GUDANG, B.KD_KAPAL, B.NO_VOY_FLIGHT, 
								DATE_FORMAT(B.TGL_TIBA,'%Y%m%d') AS TGL_TIBA, B.KD_PEL_MUAT AS KD_PEL_MUAT_HEADER, 
								B.KD_PEL_TRANSIT AS KD_PEL_TRANSIT_HEADER, B.KD_PEL_BONGKAR AS KD_PEL_BONGKAR_HEADER, B.NO_BC11, 
								DATE_FORMAT(B.TGL_BC11,'%Y%m%d') AS TGL_BC11, C.NAMA AS NM_ANGKUT, C.CALL_SIGN, D.NPWP, D.NAMA, 
								E.KD_KPBC, B.NM_ANGKUT 
								FROM t_cocostscont A 
								INNER JOIN t_cocostshdr B ON A.ID = B.ID 
								LEFT JOIN reff_kapal C ON B.KD_KAPAL = C.ID 
								LEFT JOIN t_organisasi D ON A.KD_ORG_CONSIGNEE = D.ID AND D.KD_TIPE_ORGANISASI = 'CONS' 
								INNER JOIN reff_tps E ON B.KD_TPS = E.KD_TPS 
								WHERE ".$ADD_SQL;
						break; 
						case "t_cocostskms" : 
						$SQL = "SELECT A.ID, A.SERI, A.KD_KEMASAN, A.JUMLAH, A.ID_CONT_ASAL, A.NO_CONT_ASAL, A.BRUTO, A.NO_SEGEL, A.NO_BL_AWB,
								DATE_FORMAT(A.TGL_BL_AWB,'%Y%m%d') AS TGL_BL_AWB, A.NO_MASTER_BL_AWB, A.KD_KANTOR_PABEAN,
								DATE_FORMAT(A.TGL_MASTER_BL_AWB,'%Y%m%d') AS TGL_MASTER_BL_AWB, A.NO_POS_BC11, A.KD_ORG_CONSIGNEE, 
								A.KD_TIMBUN_KAPAL, A.KD_TIMBUN, A.KD_PEL_MUAT, A.KD_PEL_TRANSIT, A.KD_PEL_BONGKAR, A.KD_DOK_IN, A.NO_DOK_IN, 
								DATE_FORMAT(A.TGL_DOK_IN,'%Y%m%d') AS TGL_DOK_IN, DATE_FORMAT(A.WK_IN,'%Y%m%d%H%i%s') AS WK_IN, 
								A.KD_CONT_STATUS_IN, A.KD_SARANA_ANGKUT_IN, A.NO_POL_IN, A.KD_DOK_OUT, A.NO_DOK_OUT, 
								DATE_FORMAT(A.TGL_DOK_OUT,'%Y%m%d') AS TGL_DOK_OUT, DATE_FORMAT(A.WK_OUT,'%Y%m%d%H%i%s') AS WK_OUT, 
								A.KD_CONT_STATUS_OUT, A.KD_SARANA_ANGKUT_OUT, A.NO_POL_OUT, A.KD_TPS_TUJUAN, A.KD_GUDANG_TUJUAN, 
								A.NO_DAFTAR_PABEAN, DATE_FORMAT(A.TGL_DAFTAR_PABEAN,'%Y%m%d') AS TGL_DAFTAR_PABEAN, A.NO_SEGEL_BC,
								DATE_FORMAT(A.TGL_SEGEL_BC,'%Y%m%d') AS TGL_SEGEL_BC, A.NO_IJIN_TPS, 
								DATE_FORMAT(A.TGL_IJIN_TPS,'%Y%m%d') AS TGL_IJIN_TPS, DATE_FORMAT(A.WK_REKAM,'%Y%m%d%H%i%s') AS WK_REKAM, 
								B.KD_ASAL_BRG, B.KD_TPS, B.KD_GUDANG, B.KD_KAPAL, B.NO_VOY_FLIGHT, DATE_FORMAT(B.TGL_TIBA,'%Y%m%d') AS TGL_TIBA, 
								B.KD_PEL_MUAT AS KD_PEL_MUAT_HEADER, B.KD_PEL_TRANSIT AS KD_PEL_TRANSIT_HEADER, 
								B.KD_PEL_BONGKAR AS KD_PEL_BONGKAR_HEADER, B.NO_BC11, DATE_FORMAT(B.TGL_BC11,'%Y%m%d') AS TGL_BC11, 
								C.NAMA AS NM_ANGKUT, C.CALL_SIGN, D.NPWP, D.NAMA, E.KD_KPBC, B.NM_ANGKUT 
								FROM t_cocostskms A 
								INNER JOIN t_cocostshdr B ON A.ID = B.ID 
								LEFT JOIN reff_kapal C ON B.KD_KAPAL = C.ID 
								LEFT JOIN t_organisasi D ON A.KD_ORG_CONSIGNEE = D.ID 
								AND D.KD_TIPE_ORGANISASI = 'CONS' 
								INNER JOIN reff_tps E ON B.KD_TPS = E.KD_TPS 
								WHERE ".$ADD_SQL;
						break;
					}
					$exec = $func->main->get_result($SQL);
					if($exec){
						foreach($SQL->result_array() as $row => $value){
							$arr_data = $value;
						}
						$V_REF_NUMBER = $arr_data['KD_TPS'].date('ymd').str_pad($data['ID'],6,0,STR_PAD_LEFT);
						if(in_array($aprf,$aprf_in)){
							$V_KD_DOK_INOUT 		  = $arr_data['KD_DOK_IN'];
							$V_NO_DOK_INOUT 		  = $arr_data['NO_DOK_IN'];
							$V_TGL_DOK_INOUT 		  = $arr_data['TGL_DOK_IN'];
							$V_WK_INOUT 			  = $arr_data['WK_IN'];
							$V_KD_SARANA_ANGKUT_INOUT = $arr_data['KD_SARANA_ANGKUT_IN'];
							$V_NO_POL_INOUT 		  = $arr_data['NO_POL_IN'];
							if($arr_data['KD_CONT_STATUS_IN']=="MTY") $V_FL_CONT_KOSONG_INOUT = '1';
							else $V_FL_CONT_KOSONG_INOUT = '2';
						}else if(in_array($aprf,$aprf_out)){
							$V_KD_DOK_INOUT 		  = $arr_data['KD_DOK_OUT'];
							$V_NO_DOK_INOUT 		  = $arr_data['NO_DOK_OUT'];
							$V_TGL_DOK_INOUT 		  = $arr_data['TGL_DOK_OUT'];
							$V_WK_INOUT 			  = $arr_data['WK_OUT'];
							$V_KD_SARANA_ANGKUT_INOUT = $arr_data['KD_SARANA_ANGKUT_OUT'];
							$V_NO_POL_INOUT 		  = $arr_data['NO_POL_OUT'];
							if($arr_data['KD_CONT_STATUS_OUT']=="MTY") $V_FL_CONT_KOSONG_INOUT = '1';
							else $V_FL_CONT_KOSONG_INOUT = '2';
						}
						$V_STR_DATA .= '<?xml version="1.0" encoding="utf-8"?>';
						switch($data['NM_TABLE']){
							case "t_cocostscont" :
								$V_METHOD 	 = $method;
								$V_STR_DATA .= '<DOCUMENT xmlns="cococont.xsd">';
								$V_STR_DATA .= '<COCOCONT>';
								$V_STR_DATA .= '<HEADER>';
								$V_STR_DATA .= '<KD_DOK>'.emptystr($KD_DOK).'</KD_DOK>';
								$V_STR_DATA .= '<KD_TPS>'.emptystr($arr_data['KD_TPS']).'</KD_TPS>';
								$V_STR_DATA .= '<NM_ANGKUT>'.emptystr($arr_data['NM_ANGKUT']).'</NM_ANGKUT>';
								$V_STR_DATA .= '<NO_VOY_FLIGHT>'.emptystr($arr_data['NO_VOY_FLIGHT']).'</NO_VOY_FLIGHT>';
								$V_STR_DATA .= '<CALL_SIGN>'.emptystr($arr_data['CALL_SIGN']).'</CALL_SIGN>';
								$V_STR_DATA .= '<TGL_TIBA>'.emptystr($arr_data['TGL_TIBA']).'</TGL_TIBA>';
								$V_STR_DATA .= '<KD_GUDANG>'.emptystr($arr_data['KD_GUDANG']).'</KD_GUDANG>';
								$V_STR_DATA .= '<REF_NUMBER>'.emptystr($V_REF_NUMBER).'</REF_NUMBER>';
								$V_STR_DATA .= '</HEADER>';
								$V_STR_DATA .= '<DETIL>';
								$V_STR_DATA .= '<CONT>';
								$V_STR_DATA .= '<NO_CONT>'.emptystr($arr_data['NO_CONT']).'</NO_CONT>';
								$V_STR_DATA .= '<UK_CONT>'.emptystr($arr_data['KD_CONT_UKURAN']).'</UK_CONT>';
								$V_STR_DATA .= '<NO_SEGEL>'.emptystr($arr_data['NO_SEGEL']).'</NO_SEGEL>';
								$V_STR_DATA .= '<JNS_CONT>'.emptystr($arr_data['KD_CONT_JENIS']).'</JNS_CONT>';
								$V_STR_DATA .= '<NO_BL_AWB>'.emptystr($arr_data['NO_BL_AWB']).'</NO_BL_AWB>';
								$V_STR_DATA .= '<TGL_BL_AWB>'.emptystr($arr_data['TGL_BL_AWB']).'</TGL_BL_AWB>';
								$V_STR_DATA .= '<NO_MASTER_BL_AWB>'.emptystr($arr_data['NO_MASTER_BL_AWB']).'</NO_MASTER_BL_AWB>';
								$V_STR_DATA .= '<TGL_MASTER_BL_AWB>'.emptystr($arr_data['TGL_MASTER_BL_AWB']).'</TGL_MASTER_BL_AWB>';
								$V_STR_DATA .= '<ID_CONSIGNEE>'.emptystr($arr_data['KD_ORG_CONSIGNEE']).'</ID_CONSIGNEE>';
								$V_STR_DATA .= '<CONSIGNEE>'.emptystr($arr_data['NAMA']).'</CONSIGNEE>';
								$V_STR_DATA .= '<BRUTO>'.emptystr($arr_data['BRUTO']).'</BRUTO>';
								$V_STR_DATA .= '<NO_BC11>'.emptystr($arr_data['NO_BC11']).'</NO_BC11>';
								$V_STR_DATA .= '<TGL_BC11>'.emptystr($arr_data['TGL_BC11']).'</TGL_BC11>';
								$V_STR_DATA .= '<NO_POS_BC11>'.emptystr($arr_data['NO_POS_BC11']).'</NO_POS_BC11>';
								$V_STR_DATA .= '<KD_TIMBUN>'.emptystr($arr_data['KD_TIMBUN']).'</KD_TIMBUN>';
								$V_STR_DATA .= '<KD_DOK_INOUT>'.emptystr($V_KD_DOK_INOUT).'</KD_DOK_INOUT>';
								$V_STR_DATA .= '<NO_DOK_INOUT>'.emptystr($V_NO_DOK_INOUT).'</NO_DOK_INOUT>';
								$V_STR_DATA .= '<TGL_DOK_INOUT>'.emptystr($V_TGL_DOK_INOUT).'</TGL_DOK_INOUT>';
								$V_STR_DATA .= '<WK_INOUT>'.emptystr($V_WK_INOUT).'</WK_INOUT>';
								$V_STR_DATA .= '<KD_SAR_ANGKUT_INOUT>'.emptystr($V_KD_SARANA_ANGKUT_INOUT).'</KD_SAR_ANGKUT_INOUT>';
								$V_STR_DATA .= '<NO_POL>'.emptystr($V_NO_POL_INOUT).'</NO_POL>';
								$V_STR_DATA .= '<FL_CONT_KOSONG>'.emptystr($V_FL_CONT_KOSONG_INOUT).'</FL_CONT_KOSONG>';
								$V_STR_DATA .= '<ISO_CODE>'.emptystr($arr_data['KD_ISO_CODE']).'</ISO_CODE>';
								$V_STR_DATA .= '<PEL_MUAT>'.emptystr($arr_data['KD_PEL_MUAT']).'</PEL_MUAT>';
								$V_STR_DATA .= '<PEL_TRANSIT>'.emptystr($arr_data['KD_PEL_TRANSIT']).'</PEL_TRANSIT>';
								$V_STR_DATA .= '<PEL_BONGKAR>'.emptystr($arr_data['KD_PEL_BONGKAR']).'</PEL_BONGKAR>';
								$V_STR_DATA .= '<GUDANG_TUJUAN>'.emptystr($arr_data['KD_GUDANG_TUJUAN']).'</GUDANG_TUJUAN>';
								$V_STR_DATA .= '<KODE_KANTOR>'.emptystr($arr_data['KD_KANTOR_PABEAN']).'</KODE_KANTOR>';
								$V_STR_DATA .= '<NO_DAFTAR_PABEAN>'.emptystr($arr_data['NO_DAFTAR_PABEAN']).'</NO_DAFTAR_PABEAN>';
								$V_STR_DATA .= '<TGL_DAFTAR_PABEAN>'.emptystr($arr_data['TGL_DAFTAR_PABEAN']).'</TGL_DAFTAR_PABEAN>';
								$V_STR_DATA .= '<NO_SEGEL_BC>'.emptystr($arr_data['NO_SEGEL_BC']).'</NO_SEGEL_BC>';
								$V_STR_DATA .= '<TGL_SEGEL_BC>'.emptystr($arr_data['TGL_SEGEL_BC']).'</TGL_SEGEL_BC>';
								$V_STR_DATA .= '<NO_IJIN_TPS>'.emptystr($arr_data['NO_IJIN_TPS']).'</NO_IJIN_TPS>';
								$V_STR_DATA .= '<TGL_IJIN_TPS>'.emptystr($arr_data['TGL_IJIN_TPS']).'</TGL_IJIN_TPS>';
								$V_STR_DATA .= '</CONT>';
								$V_STR_DATA .= '</DETIL>';
								$V_STR_DATA .= '</COCOCONT>';
								$V_STR_DATA .= '</DOCUMENT>';
							break;
							case "t_cocostskms" :
								$V_METHOD 	 = $method;
								$V_STR_DATA .= '<DOCUMENT xmlns="cocokms.xsd">';
								$V_STR_DATA .= '<COCOKMS>';
								$V_STR_DATA .= '<HEADER>';
								$V_STR_DATA .= '<KD_DOK>'.emptystr($KD_DOK).'</KD_DOK>';
								$V_STR_DATA .= '<KD_TPS>'.emptystr($arr_data['KD_TPS']).'</KD_TPS>';
								$V_STR_DATA .= '<NM_ANGKUT>'.emptystr($arr_data['NM_ANGKUT']).'</NM_ANGKUT>';
								$V_STR_DATA .= '<NO_VOY_FLIGHT>'.emptystr($arr_data['NO_VOY_FLIGHT']).'</NO_VOY_FLIGHT>';
								$V_STR_DATA .= '<CALL_SIGN>'.emptystr($arr_data['CALL_SIGN']).'</CALL_SIGN>';
								$V_STR_DATA .= '<TGL_TIBA>'.emptystr($arr_data['TGL_TIBA']).'</TGL_TIBA>';
								$V_STR_DATA .= '<KD_GUDANG>'.emptystr($arr_data['KD_GUDANG']).'</KD_GUDANG>';
								$V_STR_DATA .= '<REF_NUMBER>'.emptystr($V_REF_NUMBER).'</REF_NUMBER>';
								$V_STR_DATA .= '</HEADER>';
								$V_STR_DATA .= '<DETIL>';
								$V_STR_DATA .= '<KMS>';
								$V_STR_DATA .= '<NO_BL_AWB>'.emptystr($arr_data['NO_BL_AWB']).'</NO_BL_AWB>';
								$V_STR_DATA .= '<TGL_BL_AWB>'.emptystr($arr_data['TGL_BL_AWB']).'</TGL_BL_AWB>';
								$V_STR_DATA .= '<NO_MASTER_BL_AWB>'.emptystr($arr_data['NO_MASTER_BL_AWB']).'</NO_MASTER_BL_AWB>';
								$V_STR_DATA .= '<TGL_MASTER_BL_AWB>'.emptystr($arr_data['TGL_MASTER_BL_AWB']).'</TGL_MASTER_BL_AWB>';
								$V_STR_DATA .= '<ID_CONSIGNEE>'.emptystr($arr_data['KD_ORG_CONSIGNEE']).'</ID_CONSIGNEE>';
								$V_STR_DATA .= '<CONSIGNEE>'.emptystr($arr_data['NAMA']).'</CONSIGNEE>';
								$V_STR_DATA .= '<BRUTO>'.emptystr($arr_data['BRUTO']).'</BRUTO>';
								$V_STR_DATA .= '<NO_BC11>'.emptystr($arr_data['NO_BC11']).'</NO_BC11>';
								$V_STR_DATA .= '<TGL_BC11>'.emptystr($arr_data['TGL_BC11']).'</TGL_BC11>';
								$V_STR_DATA .= '<NO_POS_BC11>'.emptystr($arr_data['NO_POS_BC11']).'</NO_POS_BC11>';
								$V_STR_DATA .= '<CONT_ASAL>'.emptystr($arr_data['NO_CONT_ASAL']).'</CONT_ASAL>';
								$V_STR_DATA .= '<SERI_KEMAS>'.emptystr($arr_data['SERI']).'</SERI_KEMAS>';
								$V_STR_DATA .= '<KD_KEMAS>'.emptystr($arr_data['KD_KEMASAN']).'</KD_KEMAS>';
								$V_STR_DATA .= '<JML_KEMAS>'.emptystr($arr_data['JUMLAH']).'</JML_KEMAS>';
								$V_STR_DATA .= '<KD_TIMBUN>'.emptystr($arr_data['KD_TIMBUN']).'</KD_TIMBUN>';
								$V_STR_DATA .= '<KD_DOK_INOUT>'.emptystr($V_KD_DOK_INOUT).'</KD_DOK_INOUT>';
								$V_STR_DATA .= '<NO_DOK_INOUT>'.emptystr($V_NO_DOK_INOUT).'</NO_DOK_INOUT>';
								$V_STR_DATA .= '<TGL_DOK_INOUT>'.emptystr($V_TGL_DOK_INOUT).'</TGL_DOK_INOUT>';
								$V_STR_DATA .= '<WK_INOUT>'.emptystr($V_WK_INOUT).'</WK_INOUT>';
								$V_STR_DATA .= '<KD_SAR_ANGKUT_INOUT>'.emptystr($V_KD_SARANA_ANGKUT_INOUT).'</KD_SAR_ANGKUT_INOUT>';
								$V_STR_DATA .= '<NO_POL>'.emptystr($V_NO_POL_INOUT).'</NO_POL>';
								$V_STR_DATA .= '<PEL_MUAT>'.emptystr($arr_data['KD_PEL_MUAT']).'</PEL_MUAT>';
								$V_STR_DATA .= '<PEL_TRANSIT>'.emptystr($arr_data['KD_PEL_TRANSIT']).'</PEL_TRANSIT>';
								$V_STR_DATA .= '<PEL_BONGKAR>'.emptystr($arr_data['KD_PEL_BONGKAR']).'</PEL_BONGKAR>';
								$V_STR_DATA .= '<GUDANG_TUJUAN>'.emptystr($arr_data['KD_GUDANG_TUJUAN']).'</GUDANG_TUJUAN>';
								$V_STR_DATA .= '<KODE_KANTOR>'.emptystr($arr_data['KD_KANTOR_PABEAN']).'</KODE_KANTOR>';
								$V_STR_DATA .= '<NO_DAFTAR_PABEAN>'.emptystr($arr_data['NO_DAFTAR_PABEAN']).'</NO_DAFTAR_PABEAN>';
								$V_STR_DATA .= '<TGL_DAFTAR_PABEAN>'.emptystr($arr_data['TGL_DAFTAR_PABEAN']).'</TGL_DAFTAR_PABEAN>';
								$V_STR_DATA .= '<NO_SEGEL_BC>'.emptystr($arr_data['NO_SEGEL_BC']).'</NO_SEGEL_BC>';
								$V_STR_DATA .= '<TGL_SEGEL_BC>'.emptystr($arr_data['TGL_SEGEL_BC']).'</TGL_SEGEL_BC>';
								$V_STR_DATA .= '<NO_IJIN_TPS>'.emptystr($arr_data['NO_IJIN_TPS']).'</NO_IJIN_TPS>';
								$V_STR_DATA .= '<TGL_IJIN_TPS>'.emptystr($arr_data['TGL_IJIN_TPS']).'</TGL_IJIN_TPS>';
								$V_STR_DATA .= '</KMS>';
								$V_STR_DATA .= '</DETIL>';
								$V_STR_DATA .= '</COCOKMS>';
								$V_STR_DATA .= '</DOCUMENT>';	
							break;
						}
						$coco['SNRF']  	  			= $V_REF_NUMBER;
						$coco['KD_APRF']  			= $aprf;
						$coco['KD_ORG_SENDER']  	= $data['KD_ORG_SENDER'];
						$coco['KD_ORG_RECEIVER']	= $data['KD_ORG_RECEIVER'];
						$coco['STR_DATA']  			= $V_STR_DATA;
						$coco['METHOD']  			= $V_METHOD;
						$coco['TGL_STATUS']  		= date('Y-m-d H:i:s');
						$coco['KETERANGAN']  		= NULL;
						$result = $this->db->insert('postbox',$coco);
						if($result){
							echo "Success, Create xml berhasil<br>";
							$UPDATE = array('ID' => $data['ID'],
											'KD_STATUS'	 => '200',
											'TGL_STATUS' => date('Y-m-d H:i:s'));
							$this->db->where(array('ID' => $data['ID']));
							$this->db->update('app_komunikasi', $UPDATE);
						}else{
							echo "Error, Data gagal diproses<br>";
						}
					}
				}
			}else{
				echo "Error, Create xml gagal diproses";
			}
		}else{
			echo "Tidak terdapat data";
		}
	}
	
	function create_xml_plp($aprf,$method){
		$func =&get_instance();
		$func->load->model("m_main","main", true);
		$error = 0;
		$V_STR_DATA = "";
		$array_plp = array('UploadMohonPLP','UploadBatalPLP');
		if(!in_array($method,$array_plp)){
			echo "Check method";
			exit();
		}
		if($aprf=="SENTAJUPLP"){
			$SQL = "SELECT A.ID, A.KD_COCOSTSHDR, A.TIPE_DATA, A.KD_KPBC, A.NO_SURAT, DATE_FORMAT(A.TGL_SURAT,'%Y%m%d') AS TGL_SURAT,
					A.KD_TPS_ASAL, A.KD_GUDANG_ASAL, A.YOR_ASAL, A.KD_TPS_TUJUAN, A.KD_GUDANG_TUJUAN, A.YOR_TUJUAN, A.KD_KAPAL, 
					D.NAMA AS NM_KAPAL, D.CALL_SIGN, A.NM_ANGKUT, A.NO_VOY_FLIGHT, DATE_FORMAT(A.TGL_TIBA,'%Y%m%d') AS TGL_TIBA, A.NO_BC11,
					DATE_FORMAT(A.TGL_BC11,'%Y%m%d') AS TGL_BC11, A.NM_PEMOHON, A.KD_ALASAN_PLP, A.REF_NUMBER, B.ID AS KD_ORG_SENDER, 
					C.KD_ORG_RECEIVER
					FROM t_request_plp_hdr A INNER JOIN t_organisasi B ON A.KD_TPS_ASAL = B.KD_TPS
					INNER JOIN app_setting C ON B.ID = C.KD_ORG_SENDER AND C.KD_APRF = 'SENTAJUPLP'
					INNER JOIN reff_kapal D ON D.ID=A.KD_KAPAL
					WHERE A.KD_STATUS = '200'";
			$result = $func->main->get_result($SQL);
			if($result){
				foreach($SQL->result_array() as $row => $value){
					$arrdata[] = $value;
				}
				if(count($arrdata) > 0){
					foreach($arrdata as $data){
						$V_REF_NUMBER = $data['KD_TPS_ASAL'].date('ymd').str_pad($data['ID'],6,0,STR_PAD_LEFT);
						$V_STR_DATA  = '<?xml version="1.0" encoding="UTF-8"?>';
						$V_STR_DATA .= '<DOCUMENT xmlns="loadplp.xsd">';
						$V_STR_DATA .= '<LOADPLP>';
						$V_STR_DATA .= '<HEADER>';
						$V_STR_DATA .= '<KD_KANTOR>'.emptystr($data['KD_KPBC']).'</KD_KANTOR>';
						$V_STR_DATA .= '<TIPE_DATA>'.emptystr($data['TIPE_DATA']).'</TIPE_DATA>';
						$V_STR_DATA .= '<KD_TPS_ASAL>'.emptystr($data['KD_TPS_ASAL']).'</KD_TPS_ASAL>';
						$V_STR_DATA .= '<REF_NUMBER>'.emptystr($V_REF_NUMBER).'</REF_NUMBER>';
						$V_STR_DATA .= '<NO_SURAT>'.emptystr($data['NO_SURAT']).'</NO_SURAT>';
						$V_STR_DATA .= '<TGL_SURAT>'.emptystr($data['TGL_SURAT']).'</TGL_SURAT>';
						$V_STR_DATA .= '<GUDANG_ASAL>'.emptystr($data['KD_GUDANG_ASAL']).'</GUDANG_ASAL>';
						$V_STR_DATA .= '<KD_TPS_TUJUAN>'.emptystr($data['KD_TPS_TUJUAN']).'</KD_TPS_TUJUAN>';
						$V_STR_DATA .= '<GUDANG_TUJUAN>'.emptystr($data['KD_GUDANG_TUJUAN']).'</GUDANG_TUJUAN>';
						$V_STR_DATA .= '<KD_ALASAN_PLP>'.emptystr($data['KD_ALASAN_PLP']).'</KD_ALASAN_PLP>';
						$V_STR_DATA .= '<YOR_ASAL>'.emptystr($data['YOR_ASAL']).'</YOR_ASAL>';
						$V_STR_DATA .= '<YOR_TUJUAN>'.emptystr($data['YOR_TUJUAN']).'</YOR_TUJUAN>';
						$V_STR_DATA .= '<CALL_SIGN>'.emptystr($data['CALL_SIGN']).'</CALL_SIGN>';
						$V_STR_DATA .= '<NM_ANGKUT>'.emptystr($data['NM_KAPAL']).'</NM_ANGKUT>';
						$V_STR_DATA .= '<NO_VOY_FLIGHT>'.emptystr($data['NO_VOY_FLIGHT']).'</NO_VOY_FLIGHT>';
						$V_STR_DATA .= '<TGL_TIBA>'.emptystr($data['TGL_TIBA']).'</TGL_TIBA>';
						$V_STR_DATA .= '<NO_BC11>'.emptystr($data['NO_BC11']).'</NO_BC11>';
						$V_STR_DATA .= '<TGL_BC11>'.emptystr($data['TGL_BC11']).'</TGL_BC11>';
						$V_STR_DATA .= '<NM_PEMOHON>'.emptystr($data['NM_PEMOHON']).'</NM_PEMOHON>';
						$V_STR_DATA .= '</HEADER>';
						
						$SQL = "SELECT 'CONT' AS JENIS, A.NO_CONT, A.KD_CONT_UKURAN, NULL AS NO_BL_AWB, NULL AS TGL_BL_AWB 
								FROM t_request_plp_cont A
								WHERE A.ID = ".$this->db->escape($data['ID'])."
								UNION ALL 
								SELECT 'KMS' AS JENIS, B.KD_KEMASAN AS NO_CONT, B.JML_KMS AS KD_CONT_UKURAN, B.NO_BL_AWB, 
								DATE_FORMAT(B.TGL_BL_AWB,'%Y%m%d') AS TGL_BL_AWB 
								FROM t_request_plp_kms B
								WHERE B.ID = ".$this->db->escape($data['ID']);
						$exec = $func->main->get_result($SQL);
						if($exec){
							foreach($SQL->result_array() as $row => $value){
								$arrdtl[] = $value;
							}
							if(!empty($arrdtl)){
								$V_STR_DATA .= '<DETIL>';
								foreach($arrdtl as $dtl){
									switch($dtl['JENIS']){
										case "CONT" : 
										$V_STR_DATA .= '<CONT>';
										$V_STR_DATA .= '<NO_CONT>'.emptystr($dtl['NO_CONT']).'</NO_CONT>';
										$V_STR_DATA .= '<UK_CONT>'.emptystr($dtl['KD_CONT_UKURAN']).'</UK_CONT>';
										$V_STR_DATA .= '</CONT>';
										break;
										case "KMS"	:
										$V_STR_DATA .= '<KMS>';
										$V_STR_DATA .= '<JNS_KMS>'.emptystr($dtl['NO_CONT']).'</JNS_KMS>';
										$V_STR_DATA .= '<JML_KMS>'.emptystr($dtl['KD_CONT_UKURAN']).'</JML_KMS>';
										$V_STR_DATA .= '<NO_BL_AWB>'.emptystr($dtl['NO_BL_AWB']).'</NO_BL_AWB>';
										$V_STR_DATA .= '<TGL_BL_AWB>'.emptystr($dtl['TGL_BL_AWB']).'</TGL_BL_AWB>';
										$V_STR_DATA .= '</KMS>';
										break;
									}
								}
								$V_STR_DATA .= '</DETIL>';
							}else{
								$error += 1;
							}
						}else{
							$error += 1;
						}
						$V_STR_DATA .= '</LOADPLP>';
						$V_STR_DATA .= '</DOCUMENT>';
						if($error==0){
							$plp['SNRF']  	  		= $V_REF_NUMBER;
							$plp['KD_APRF']  		= $aprf;
							$plp['KD_ORG_SENDER']  	= $data['KD_ORG_SENDER'];
							$plp['KD_ORG_RECEIVER']	= $data['KD_ORG_RECEIVER'];
							$plp['STR_DATA']  		= $V_STR_DATA;
							$plp['TGL_STATUS']  	= date('Y-m-d H:i:s');
							$plp['KETERANGAN']  	= NULL;
							$result = $this->db->insert('postbox',$plp);
							if($result){
								$UPDATE = array('REF_NUMBER' => $V_REF_NUMBER,
												'KD_STATUS'	 => '300',
												'TGL_STATUS' => date('Y-m-d H:i:s'));
								$this->db->where(array('ID' => $data['ID']));
								$res = $this->db->update('t_request_plp_hdr', $UPDATE);
								if($res){
									echo "Success, Create xml pengajuan plp berhasil";	
								}
							}else{
								echo "Error, Data gagal diproses<br>";
							}
						}else{
							echo "Error, Create xml pengajuan plp gagal<BR>";
						}
					}
				}
			}
		}else if($aprf=="SENTBTLPLP"){
			$SQL = "SELECT A.ID, A.KD_RESPON_PLP_ASAL, A.KD_KPBC, A.KD_TPS, B.REF_NUMBER, A.NO_SURAT, 
					DATE_FORMAT(A.TGL_SURAT,'%Y%m%d') AS TGL_SURAT, B.NO_PLP,  DATE_FORMAT(B.TGL_PLP,'%Y%m%d') AS TGL_PLP, A.ALASAN, C.NO_BC11, 
					DATE_FORMAT(C.TGL_BC11,'%Y%m%d') AS TGL_BC11, A.NM_PEMOHON, D.ID AS KD_ORG_SENDER, E.KD_ORG_RECEIVER
					FROM t_request_batal_plp_hdr A
					INNER JOIN t_respon_plp_asal_hdr B ON B.ID=A.KD_RESPON_PLP_ASAL
					INNER JOIN t_request_plp_hdr C ON C.REF_NUMBER=B.REF_NUMBER
					INNER JOIN t_organisasi D ON D.KD_TPS=A.KD_TPS
					INNER JOIN app_setting E ON E.KD_ORG_SENDER = D.ID AND E.KD_APRF = 'SENTBTLPLP'
					WHERE A.KD_STATUS = '200'";
			$result = $func->main->get_result($SQL);
			if($result){
				foreach($SQL->result_array() as $row => $value){
					$arrdata[] = $value;
				}
				if(count($arrdata) > 0){
					foreach($arrdata as $data){
						$V_REF_NUMBER = $data['KD_TPS'].date('ymd').str_pad($data['ID'],6,0,STR_PAD_LEFT);
						$V_STR_DATA .= '<?xml version="1.0" encoding="UTF-8"?>';
						$V_STR_DATA .= '<DOCUMENT xmlns="loadbatalplp.xsd">';
						$V_STR_DATA .= '<BATALPLP>';
						$V_STR_DATA .= '<HEADER>';
						$V_STR_DATA .= '<KD_KANTOR>'.emptystr($data['KD_KPBC']).'</KD_KANTOR>';
						$V_STR_DATA .= '<TIPE_DATA>'.emptystr($data['TIPE_DATA']).'</TIPE_DATA>';
						$V_STR_DATA .= '<KD_TPS>'.emptystr($data['KD_TPS']).'</KD_TPS>';
						$V_STR_DATA .= '<REF_NUMBER>'.emptystr($V_REF_NUMBER).'</REF_NUMBER>';
						$V_STR_DATA .= '<NO_SURAT>'.emptystr($data['NO_SURAT']).'</NO_SURAT>';
						$V_STR_DATA .= '<TGL_SURAT>'.emptystr($data['TGL_SURAT']).'</TGL_SURAT>';
						$V_STR_DATA .= '<NO_PLP>'.emptystr($data['NO_PLP']).'</NO_PLP>';
						$V_STR_DATA .= '<TGL_PLP>'.emptystr($data['TGL_PLP']).'</TGL_PLP>';
						$V_STR_DATA .= '<ALASAN>'.emptystr($data['ALASAN']).'</ALASAN>';
						$V_STR_DATA .= '<NO_BC11>'.emptystr($data['NO_BC11']).'</NO_BC11>';
						$V_STR_DATA .= '<TGL_BC11>'.emptystr($data['TGL_BC11']).'</TGL_BC11>';
						$V_STR_DATA .= '<NM_PEMOHON>'.emptystr($data['NM_PEMOHON']).'</NM_PEMOHON>';
						$V_STR_DATA .= '</HEADER>';
						
						$SQL = "SELECT 'CONT' AS JENIS, A.NO_CONT, A.KD_CONT_UKURAN, NULL AS NO_BL_AWB, NULL AS TGL_BL_AWB
								FROM t_request_batal_plp_cont A
								WHERE A.ID = ".$this->db->escape($data['ID'])."
								UNION ALL 
								SELECT 'KMS' AS JENIS, B.KD_KEMASAN AS NO_CONT, B.JML_KMS AS KD_CONT_UKURAN, B.NO_BL_AWB,
								DATE_FORMAT(B.TGL_BL_AWB,'%Y%m%d') AS TGL_BL_AWB 
								FROM t_request_batal_plp_kms B
								WHERE B.ID = ".$this->db->escape($data['ID']);
						$exec = $func->main->get_result($SQL);
						if($exec){
							foreach($SQL->result_array() as $row => $value){
								$arrdtl[] = $value;
							}
							$V_STR_DATA .= '<DETIL>';
							foreach($arrdtl as $dtl){
								switch($dtl['JENIS']){
									case "CONT" : 
									$V_STR_DATA .= '<CONT>';
									$V_STR_DATA .= '<NO_CONT>'.emptystr($dtl['NO_CONT']).'</NO_CONT>';
									$V_STR_DATA .= '<UK_CONT>'.emptystr($dtl['KD_CONT_UKURAN']).'</UK_CONT>';
									$V_STR_DATA .= '</CONT>';
									break;
									case "KMS"	:
									$V_STR_DATA .= '<KMS>';
									$V_STR_DATA .= '<JNS_KMS>'.emptystr($dtl['NO_CONT']).'</JNS_KMS>';
									$V_STR_DATA .= '<JML_KMS>'.emptystr($dtl['KD_CONT_UKURAN']).'</JML_KMS>';
									$V_STR_DATA .= '<NO_BL_AWB>'.emptystr($dtl['NO_BL_AWB']).'</NO_BL_AWB>';
									$V_STR_DATA .= '<TGL_BL_AWB>'.emptystr($dtl['TGL_BL_AWB']).'</TGL_BL_AWB>';
									$V_STR_DATA .= '</KMS>';
									break;
								}
							}
							$V_STR_DATA .= '</DETIL>';
						}else{
							$error += 1;
						}
						$V_STR_DATA .= '</BATALPLP>';
						$V_STR_DATA .= '</DOCUMENT>';
						if($error==0){
							$plp['SNRF']  	  		= $V_REF_NUMBER;
							$plp['KD_APRF']  		= $aprf;
							$plp['KD_ORG_SENDER']  	= $data['KD_ORG_SENDER'];
							$plp['KD_ORG_RECEIVER']	= $data['KD_ORG_RECEIVER'];
							$plp['STR_DATA']  		= $V_STR_DATA;
							$plp['METHOD']  		= $V_STR_DATA;
							$plp['TGL_STATUS']  	= date('Y-m-d H:i:s');
							$plp['KETERANGAN']  	= NULL;
							$result = $this->db->insert('postbox',$plp);
							if($result){
								$UPDATE = array('REF_NUMBER' => $V_REF_NUMBER,
												'KD_STATUS'	 => '300',
												'TGL_STATUS' => date('Y-m-d H:i:s'));
								$this->db->where(array('ID' => $data['ID']));
								$res = $this->db->update('t_request_batal_plp_hdr', $UPDATE);
								if($res){
									echo "Success, Create xml pembatalan plp berhasil";	
								}
							}else{
								echo "Error, Data gagal diproses";
							}
						}else{
							echo "Error, Create xml pembatalan plp gagal";
						}
					}
				}
			}
		}else{
			echo "Silahkan setting komunikasi data";
		}
	}
	
	function send_coco($aprf,$method){
		$func =&get_instance();
		$func->load->model("m_main","main", true);
		$this->load->library('Nusoap');
		$client = new nusoap_client(WSDL,true);
		if(SET_PROXY) $client->setHTTPProxy(PROXYHOST,PROXYPORT);
		$error  = $client->getError();
		if($error){
			echo '<h2>Constructor error</h2>'.$error;
			exit();
		}
		$array_coco = array('CoCoCont_Tes','CoCoKms_Tes','CoarriCodeco_Container','CoarriCodeco_Kemasan');
		if(!in_array($method,$array_coco)){
			echo "Check method";
			exit();
		}
		$filename = DIR_EXE.$method.'.txt';
		$check_file = check_file($filename);
		if(!$check_file){
			create_file($filename);
			$SQL = "SELECT A.ID, A.STR_DATA, B.USERNAME_TPSONLINE_BC, B.PASSWORD_TPSONLINE_BC, A.METHOD
					FROM postbox A 
					INNER JOIN t_organisasi B ON A.KD_ORG_SENDER = B.ID
					WHERE A.KD_APRF = ".$this->db->escape(trim($aprf))."
					AND A.METHOD = ".$this->db->escape(trim($method))."
					AND B.USERNAME_TPSONLINE_BC IS NOT NULL
					AND B.PASSWORD_TPSONLINE_BC IS NOT NULL
					AND A.KD_STATUS = '100'
					LIMIT 0,20";
    		$exec = $func->main->get_result($SQL);
			if($exec){
				foreach($SQL->result_array() as $row => $value){
					$arrdata[] = $value;
				}
				if(!empty($arrdata)){
					foreach($arrdata as $data){
						$ID = $data['ID'];
						$STR_DATA = $data['STR_DATA'];
						$USERNAME = 'TES';#$data['USERNAME_TPSONLINE_BC'];
						$PASSWORD = '1234';#$data['PASSWORD_TPSONLINE_BC'];
						$param  = array( 'Username'=>$USERNAME, 'Password'=>$PASSWORD, 'fStream'=>$STR_DATA);
						$response = $client->call($method,$param);
						if($response!=""){
							$return = $response[$data['METHOD'].'Result'];
							$pos = strpos(strtolower($return), 'berhasil');
							if($pos !== false){
								$KD_STATUS = '200';
								echo "Success<br>";
							}else{
								$KD_STATUS = '300';
								echo "Failed<br>";
							}	
						}else{
							$return = "";
							$KD_STATUS = '300';
							echo "Failed<br>";
						}
						$UPDATE = array('KD_STATUS'	 => $KD_STATUS,
										'TGL_STATUS' => date('Y-m-d H:i:s'),
										'KETERANGAN' => $return);
						$this->db->where(array('ID'  => $data['ID']));
						$res = $this->db->update('postbox', $UPDATE);
					}
				}else{
					echo "Failed<br>";
				}
			}else{
				echo "No records found";
			}
			remove_file($filename);
		}else{
			echo "Scheduler is running";
		}
	}
	
	function send_plp(){
		
	}
}