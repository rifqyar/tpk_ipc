<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_act extends CI_Model{
	
	function get_access($username,$password){
		$SQL = "SELECT A.USERLOGIN, A.PASSWORD
				FROM tm_user A
				INNER JOIN tm_organization B ON B.ID=A.ORGANIZATION_CODE
				WHERE A.STATUS_CODE = 'ACTIVE'
				AND A.USERLOGIN = ".$this->db->escape($username)."
				AND A.PASSWORD = ".$this->db->escape(md5($password));
		$exec = $this->db->query($SQL);
		if($exec->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	
	function create_log($table,$arrdata=array()){
		$arrdata['STATUS_DATE'] = date('Y-m-d H:i:s');
		$this->db->insert($table,$arrdata);
	}
	
	function get_data($act,$data){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$arrdata = array();
		switch ($act){
			case "KAPAL"	 :
				$SQL = "SELECT ID FROM tm_ship
						WHERE NAME = ".$this->db->escape(trim(strtoupper($data)));
				$result = $func->main->get_result($SQL);
				if($result){
					foreach($SQL->result_array() as $row => $value){
						$arrdata = $value;
					}
					$data = $arrdata['ID'];
				}else{
					$arrdata = array('NAME' => trim(strtoupper($data)));
					$this->db->insert('tm_ship', $arrdata);
					$data = $this->db->insert_id();
				}
				return $data;
			break;
			case "TX_DOCUMENT_HDR"	 :
				$SQL = "SELECT ID FROM tx_document_hdr
						WHERE REF_NUMBER = ".$this->db->escape(trim(strtoupper($data)));
				$result = $func->main->get_result($SQL);
				if($result){
					foreach($SQL->result_array() as $row => $value){
						$arrdata = $value;
					}
					$data = $arrdata['ID'];
				}else{
					$data = false;
				}
				return $data;
			break;
			case "TX_DOCUMENT_CONT"	 :
				$SQL = "SELECT NO_CONT FROM tx_document_cont
						WHERE NO_CONT = ".$this->db->escape(trim(strtoupper($data)));
				$result = $func->main->get_result($SQL);
				if($result){
					foreach($SQL->result_array() as $row => $value){
						$arrdata = $value;
					}
					$data = $arrdata['NO_CONT'];
				}else{
					$data = false;
				}
				return $data;
			break;
		}
	}
	
	function sendTest($username,$password){
		$result = $this->get_access($username,$password);
		if($result){
			$message = "Success, Welcome";
		}else{
			$message = "failed, user not found";
		}
		return $message;
	}
	
	function sendDocumentSP2MP($username,$password,$xml){
		$result = $this->get_access($username,$password);
		if($result){
			$erorr   = 0;
			$res     = simplexml_load_string($xml);
			$json    = json_encode($res);
			$arrxml  = json_decode($json,TRUE);
			$process_by		= $username;
			$date_now	= date('Y-m-d H:i:s');
			$arrheader   = $arrxml["SP2MP"]['HEADER'];
			$arrdetail   = $arrxml["SP2MP"]['DETAIL']['CONT_DATA'];
			$count_header = count($arrheader);
			$count_detail = count($arrdetail);
			if($count_header==0){
				$kode_return = "01";
				$keterangan  = "Erorr, document not valid";
			}else{
				if(strtoupper($arrheader['KODE_GUDANG'])!="TER3"){
					$kode_return = "01";
					$keterangan  = "Erorr, warehouse code not valid";
				}else{
					$arr_data["DOC_CODE"]  		= '13001';
					$arr_data["DOC_NAME"]  		= 'SP2MP';
					$arr_data["NO_LICENSE"]  	= $arrheader['NO_SP2MP'];
					$arr_data["DATE_LICENSE"]  	= $arrheader['TGL_SP2MP'];
					$arr_data["SHIP_CODE"]  	= $this->get_data('KAPAL',$arrheader['NAMA_KAPAL']);
					$arr_data["SHIP_NAME"]  	= $arrheader['NAMA_KAPAL'];
					$arr_data["NO_VOY_FLIGHT"]  = $arrheader['VOYAGE'];
					$arr_data["WAREHOUSE_CODE"] = $arrheader['KODE_GUDANG'];
					$arr_data["REF_NUMBER"]  	= $arrheader['REF_NUMBER'];
					$id_hdr = $this->get_data('TX_DOCUMENT_HDR',$arr_data["REF_NUMBER"]);
					if($id_hdr){
						$arr_data["STATUS_CODE"]  	= '200';
						$arr_data["UPDATE_BY"]  	= $process_by;
						$arr_data["UPDATE_DATE"]  	= $date_now;
						if(array_key_exists('SP2MP', $arrxml)){
							if(array_key_exists(0, $arrdetail)){
								$this->db->where(array('ID' => $id_hdr));
								$result = $this->db->update('tx_document_hdr',$arr_data);
								if($result){
									for($a=0; $a<count($arrdetail); $a++){
										$id_cont = $this->get_data('TX_DOCUMENT_CONT',$arrdetail[$a]['NO_CONT']);
										if(!$id_cont){
											$arr_detail["ID"]             = $id_hdr;
											$arr_detail["NO_CONT"]        = $arrdetail[$a]['NO_CONT'];
											$arr_detail["SIZE_CONT_CODE"] = $arrdetail[$a]['SIZE_CONT'];
											$this->db->insert('tx_document_cont',$arr_detail);
										}
									}	
								}
							}else{
								$this->db->where(array('ID' => $id_hdr));
								$result = $this->db->update('tx_document_hdr',$arr_data);
								if($result){
									$id_cont = $this->get_data('TX_DOCUMENT_CONT',$arrdetail['NO_CONT']);
									if(!$id_cont){
										$arr_detail["ID"]             = $id_hdr;
										$arr_detail["NO_CONT"]        = $arrdetail['NO_CONT'];
										$arr_detail["SIZE_CONT_CODE"] = $arrdetail['SIZE_CONT'];
										$this->db->insert('tx_document_cont',$arr_detail);
									}
								}
							}
							$kode_return    = "00";
							$keterangan		= "Success";
						}else{
							$kode_return = "01";
							$keterangan  = "Erorr, can't insert detail";
						}
					}else{
						$arr_data["STATUS_CODE"]  	= '100';
						$arr_data["CREATE_BY"]  	= $process_by;
						$arr_data["CREATE_DATE"]  	= $date_now;
						if(array_key_exists('SP2MP', $arrxml)){
							if(array_key_exists(0, $arrdetail)){
								$result = $this->db->insert('tx_document_hdr',$arr_data);
								$id_hdr = $this->db->insert_id();
								for($a=0; $a<count($arrdetail); $a++){
									$arr_detail["ID"]             = $id_hdr;
									$arr_detail["NO_CONT"]        = $arrdetail[$a]['NO_CONT'];
									$arr_detail["SIZE_CONT_CODE"] = $arrdetail[$a]['SIZE_CONT'];
									$this->db->insert('tx_document_cont',$arr_detail);
								}
							}else{
								$result = $this->db->insert('tx_document_hdr',$arr_data);
								$id_hdr = $this->db->insert_id();
								$arr_detail["ID"]             = $id_hdr;
								$arr_detail["NO_CONT"]        = $arrdetail['NO_CONT'];
								$arr_detail["SIZE_CONT_CODE"] = $arrdetail['SIZE_CONT'];
								$this->db->insert('tx_document_cont',$arr_detail);
							}
							$kode_return    = "00";
							$keterangan		= "Success";
						}else{
							$kode_return = "01";
							$keterangan  = "Erorr, can't insert detail";
						}
					}
				}	
			}
		}else{
			$kode_return = "01";
			$keterangan  = "Erorr, user not found";
		}
		$return = "<return>
						<kode>".$kode_return."</kode>
						<keterangan>".$keterangan."</keterangan>
				   </return>";
		return $return;
	}
	
	function sendFinishQuarantine($username,$password,$xml){
		$result = $this->get_access($username,$password);
		if($result){
			$erorr   = 0;
			$res     = simplexml_load_string($xml);
			$json    = json_encode($res);
			$arrxml  = json_decode($json,TRUE);
			$process_by		= $username;
			$date_now	= date('Y-m-d H:i:s');
			$arrheader   = $arrxml["FINISH_QUARANTINE"]['HEADER'];
			$arrdetail   = $arrxml["FINISH_QUARANTINE"]['DETAIL']['CONT_DATA'];
			$count_header = count($arrheader);
			$count_detail = count($arrdetail);
			if($count_header==0){
				$kode_return = "01";
				$keterangan  = "Erorr, document not valid";
			}else{
				if(strtoupper($arrheader['KODE_GUDANG'])!="TER3"){
					$kode_return = "01";
					$keterangan  = "Erorr, warehouse code not valid";
				}else{
					$arr_data["DOC_CODE"]  		= '13002';
					$arr_data["DOC_NAME"]  		= 'SQ';
					$arr_data["SHIP_CODE"]  	= $this->get_data('KAPAL',$arrheader['NAMA_KAPAL']);
					$arr_data["SHIP_NAME"]  	= $arrheader['NAMA_KAPAL'];
					$arr_data["NO_VOY_FLIGHT"]  = $arrheader['VOYAGE'];
					$arr_data["WAREHOUSE_CODE"] = $arrheader['KODE_GUDANG'];
					$arr_data["REF_NUMBER"]  	= $arrheader['REF_NUMBER'];
					$id_hdr = $this->get_data('TX_DOCUMENT_HDR',$arr_data["REF_NUMBER"]);
					if($id_hdr){
						$arr_data["STATUS_CODE"]  	= '200';
						$arr_data["UPDATE_BY"]  	= $process_by;
						$arr_data["UPDATE_DATE"]  	= $date_now;
						if(array_key_exists('FINISH_QUARANTINE', $arrxml)){
							if(array_key_exists(0, $arrdetail)){
								$this->db->where(array('ID' => $id_hdr));
								$result = $this->db->update('tx_document_hdr',$arr_data);
								if($result){
									for($a=0; $a<count($arrdetail); $a++){
										$id_cont = $this->get_data('TX_DOCUMENT_CONT',$arrdetail[$a]['NO_CONT']);
										if(!$id_cont){
											$arr_detail["ID"]             = $id_hdr;
											$arr_detail["NO_CONT"]        = $arrdetail[$a]['NO_CONT'];
											$arr_detail["SIZE_CONT_CODE"] = $arrdetail[$a]['SIZE_CONT'];
											$this->db->insert('tx_document_cont',$arr_detail);
										}
									}	
								}
							}else{
								$this->db->where(array('ID' => $id_hdr));
								$result = $this->db->update('tx_document_hdr',$arr_data);
								if($result){
									$id_cont = $this->get_data('TX_DOCUMENT_CONT',$arrdetail['NO_CONT']);
									if(!$id_cont){
										$arr_detail["ID"]             = $id_hdr;
										$arr_detail["NO_CONT"]        = $arrdetail['NO_CONT'];
										$arr_detail["SIZE_CONT_CODE"] = $arrdetail['SIZE_CONT'];
										$this->db->insert('tx_document_cont',$arr_detail);
									}
								}
							}
							$kode_return    = "00";
							$keterangan		= "Success";
						}else{
							$kode_return = "01";
							$keterangan  = "Erorr, can't insert detail";
						}
					}else{
						$arr_data["STATUS_CODE"]  	= '100';
						$arr_data["CREATE_BY"]  	= $process_by;
						$arr_data["CREATE_DATE"]  	= $date_now;
						if(array_key_exists('FINISH_QUARANTINE', $arrxml)){
							if(array_key_exists(0, $arrdetail)){
								$result = $this->db->insert('tx_document_hdr',$arr_data);
								$id_hdr = $this->db->insert_id();
								for($a=0; $a<count($arrdetail); $a++){
									$arr_detail["ID"]             = $id_hdr;
									$arr_detail["NO_CONT"]        = $arrdetail[$a]['NO_CONT'];
									$arr_detail["SIZE_CONT_CODE"] = $arrdetail[$a]['SIZE_CONT'];
									$this->db->insert('tx_document_cont',$arr_detail);
								}
							}else{
								$result = $this->db->insert('tx_document_hdr',$arr_data);
								$id_hdr = $this->db->insert_id();
								$arr_detail["ID"]             = $id_hdr;
								$arr_detail["NO_CONT"]        = $arrdetail['NO_CONT'];
								$arr_detail["SIZE_CONT_CODE"] = $arrdetail['SIZE_CONT'];
								$this->db->insert('tx_document_cont',$arr_detail);
							}
							$kode_return    = "00";
							$keterangan		= "Success";
						}else{
							$kode_return = "01";
							$keterangan  = "Erorr, can't insert detail";
						}
					}
				}	
			}
		}else{
			$kode_return = "01";
			$keterangan  = "Erorr, user not found";
		}
		$return = "<return>
						<kode>".$kode_return."</kode>
						<keterangan>".$keterangan."</keterangan>
				   </return>";
		return $return;
	}
}
?>