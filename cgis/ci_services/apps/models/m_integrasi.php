<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_integrasi extends CI_Model{
	
	function respon_plp(){
		$func =&get_instance();
		$func->load->model("m_main","main", true);
		$SQL = "SELECT LOWER(A.NM_TABLE) AS NM_TABLE, A.FIELD1, A.VALUE1, A.FIELD2, A.VALUE2, A.FIELD3, A.VALUE3, A.ID
				FROM app_komunikasi A
				WHERE A.KD_STATUS = '100'
				AND A.NM_TABLE = 'respon_plp'
				LIMIT 20";
		$result = $func->main->get_result($SQL);
		if($result){
			foreach($SQL->result_array() as $row => $value){
				$arrdata[] = $value;
			}
			foreach($arrdata as $app_data){
				if($app_data['FIELD1'] != "") $ADD_SQL .= " AND ".$app_data['FIELD1']." = ".$this->db->escape($app_data['VALUE1']);
				if($app_data['FIELD2'] != "") $ADD_SQL .= " AND ".$app_data['FIELD2']." = ".$this->db->escape($app_data['VALUE2']);
				if($app_data['FIELD3'] != "") $ADD_SQL .= " AND ".$app_data['FIELD3']." = ".$this->db->escape($app_data['VALUE3']);
				$SQL = "SELECT RESPONID AS ID, KD_KANTOR, KD_TPS_ASAL, GUDANG_TUJUAN, KD_TPS, NO_PLP, TGL_PLP, NAMA_KAPAL AS NM_ANGKUT, 
						NO_VOYAGE AS NO_VOY_FLIGHT, CALL_SIGN, TGL_TIBA, NO_BC11, TGL_BC11, NO_SURAT, TGL_SURAT 
						FROM t_plp
						WHERE 1=1".$ADD_SQL;
				$exec = $this->db->query($SQL);
				if($exec->num_rows() > 0){
					$wms_db = $this->load->database('wms',TRUE);
					$array_data = $exec->result_array();
					foreach($array_data as $data){
						$ID = $data['ID'];
						unset($data['ID']);
						$SQL_DTL = "SELECT RESPONID, NO_CONT, UK_CONT, JNS_CONT, NO_POS_BC11, CONSIGNEE, NO_BL_AWB, TGL_BL_AWB
									FROM t_plp_cont WHERE RESPONID = ".$this->db->escape($ID);
						$result = $this->db->query($SQL_DTL);
						if($result->num_rows() > 0){
							$filename = DIR_EXE.'respon_plp.txt';
							$check_file = check_file($filename);
							if(!$check_file){
								create_file($filename);
								list($COUNT,$ID_PLP) = $this->get_data('responplp_hdr',array($data['NO_PLP'],$data['TGL_PLP']));
								if($COUNT > 0){
									unset($data['ID']);
									$wms_db->where(array('ID' => $ID_PLP));
									$ex = $wms_db->update('t_respon_plp_tujuan_hdr',$data);
									$NEW_ID = $ID_PLP;
									echo "SUCCESS UPDATE, NO. PLP : ".$data['NO_PLP']."[".$result->num_rows()."]<BR>";
								}else{
									$ex = $wms_db->insert('t_respon_plp_tujuan_hdr',$data);
									$NEW_ID = $wms_db->insert_id();	
									echo "SUCCESS INSERT, NO. PLP : ".$data['NO_PLP']."[".$result->num_rows()."]<BR>";
								}
								$arr_detail = $result->result_array();
								foreach($arr_detail as $dtl){
									$CONT_DTL = $dtl['NO_CONT'];
									list($COUNT_DTL,$ID_RESPON,$CONT_RESPON) = $this->get_data('responplp_cont',array($ID_PLP,$CONT_DTL));
									if($COUNT_DTL > 0){
										unset($dtl['RESPONID']);
										unset($dtl['NO_CONT']);
										$wms_db->where(array('KD_RESPON_PLP_TUJUAN' => $ID_RESPON, 'NO_CONT' => $CONT_RESPON));
										$wms_db->update('t_respon_plp_tujuan_cont',$dtl);
									}else{
										unset($dtl['RESPONID']);
										$dtl['KD_RESPON_PLP_TUJUAN'] = $NEW_ID;
										$wms_db->insert('t_respon_plp_tujuan_cont',$dtl);	
									}
								}
								if($ex){
									$this->db->where(array('ID' => $app_data['ID']));
									$this->db->update('app_komunikasi',array('KD_STATUS' => '200'));
								}
								remove_file($filename);
							}else{
								echo "APPLICATION IS RUNNING"; exit();
							}
							
						}else{
							echo "EMPTY DETAIL CONTAINER, NO. PLP ".$data['NO_PLP']."<BR>";
						}
						$this->db->where(array('RESPONID' => $ID));
						$this->db->update('t_plp',array('FL_WMS' => 'Y'));
					}
					$wms_db->close();
				}else{
					echo "NO RECORDS FOUND"; exit();
				}
			}
		}else{
			echo "NO RECORDS FOUND"; exit();
		}
	}
	
	function codeco_cont(){
		$func =&get_instance();
		$func->load->model("m_main","main", true);
		$SQL = "SELECT LOWER(A.NM_TABLE) AS NM_TABLE, A.FIELD1, A.VALUE1, A.FIELD2, A.VALUE2, A.FIELD3, A.VALUE3, A.ID
				FROM app_komunikasi A
				WHERE A.KD_STATUS = '100'
				AND A.NM_TABLE = 'cocostscont'
				LIMIT 20";
		$result = $func->main->get_result($SQL);
		if($result){
			foreach($SQL->result_array() as $row => $value){
				$arrdata[] = $value;
			}
			foreach($arrdata as $app_data){
				if($app_data['FIELD1'] != "") $ADD_SQL .= " AND B.".$app_data['FIELD1']." = ".$this->db->escape($app_data['VALUE1']);
				if($app_data['FIELD2'] != "") $ADD_SQL .= " AND B.".$app_data['FIELD2']." = ".$this->db->escape($app_data['VALUE2']);
				if($app_data['FIELD3'] != "") $ADD_SQL .= " AND B.".$app_data['FIELD3']." = ".$this->db->escape($app_data['VALUE3']);
				$SQL = "SELECT A.ID, A.KD_DOK, A.KD_TPS, A.NM_ANGKUT, A.NO_VOY_FLIGHT, A.CALL_SIGN, A.TGL_TIBA, A.KD_GUDANG,
						B.NO_CONT, B.UK_CONT, B.NO_SEGEL, B.JNS_CONT, B.NO_BL_AWB, B.TGL_BL_AWB, B.NO_MASTER_BL_AWB, B.TGL_MASTER_BL_AWB, 
						B.ID_CONSIGNEE, B.CONSIGNEE, B.BRUTO, B.NO_BC11, B.TGL_BC11, B.NO_POS_BC11, B.KD_TIMBUN, B.KD_DOK_IN, B.NO_DOK_IN,
						B.TGL_DOK_IN, B.WK_IN, B.KD_SAR_ANGKUT_IN, B.NO_POL_IN, B.KD_DOK_OUT, B.NO_DOK_OUT, B.TGL_DOK_OUT, B.WK_OUT,
						B.KD_SAR_ANGKUT_OUT, B.NO_POL_OUT, B.FL_CONT_KOSONG, B.ISO_CODE, B.PEL_MUAT, B.PEL_TRANSIT, B.PEL_BONGKAR, 
						B.GUDANG_TUJUAN, B.KODE_KANTOR_IN, B.NO_DAFTAR_PABEAN_IN, B.TGL_DAFTAR_PABEAN_IN, B.NO_SEGEL_BC_IN, B.TGL_SEGEL_BC_IN, 
						B.NO_IJIN_TPS_IN, B.TGL_IJIN_TPS_IN, B.FLAG, B.REF_NUMBER, B.KODE_KANTOR_OUT, B.NO_DAFTAR_PABEAN_OUT, 
						B.TGL_DAFTAR_PABEAN_OUT, B.NO_SEGEL_BC_OUT, B.TGL_SEGEL_BC_OUT, B.NO_IJIN_TPS_OUT, B.TGL_IJIN_TPS_OUT, 
						B.WK_INSERT
						FROM cocostshdr A
						INNER JOIN cocostscont B ON B.ID=A.ID
						WHERE 1=1".$ADD_SQL;
				$exec = $this->db->query($SQL);
				if($exec->num_rows() > 0){
					$filename = DIR_EXE.'codeco_cont.txt';
					$check_file = check_file($filename);
					if(!$check_file){
						create_file($filename);
						$wms_db = $this->load->database('wms',TRUE);
						$array_data = $exec->result_array();
						foreach($array_data as $data){
							$ID = $data['ID'];
							$KD_DOK = $data['KD_DOK'];
							$KD_TPS = $data['KD_TPS'];
							$KD_GUDANG = $data['KD_GUDANG'];
							$NM_ANGKUT = trim($data['NM_ANGKUT']);
							$NO_VOY_FLIGHT = trim($data['NO_VOY_FLIGHT']);
							$CALL_SIGN = trim($data['CALL_SIGN']);
							$TGL_TIBA = trim($data['TGL_TIBA']);
							$GETID = $this->get_data('cocostshdr',array($KD_TPS,$KD_GUDANG,$NM_ANGKUT,$NO_VOY_FLIGHT,$CALL_SIGN,$TGL_TIBA));
							$next = false;
							if($GETID == ""){
								$array_hdr = array('KD_DOK' => $KD_DOK,
												   'KD_TPS' => $KD_TPS,
												   'NM_ANGKUT' => $NM_ANGKUT,
												   'NO_VOY_FLIGHT' => $NO_VOY_FLIGHT,
												   'CALL_SIGN' => $CALL_SIGN,
												   'TGL_TIBA' => $TGL_TIBA,
												   'KD_GUDANG' => $KD_GUDANG,
												   'TGL_REKAM' => date('Y-m-d H:i:s'));
								$wms_db->insert('cocostshdr',$array_hdr);
								$NEW_ID = $wms_db->insert_id();
								$next = true;
							}else{
								$NEW_ID = $GETID;
								$next = true;
							}
							if($next){
								list($COUNT, $ID_CONT, $NO_CONT) = $this->get_data('cocostscont',array($NEW_ID,$data['NO_CONT']));
								$array_cont = array('ID' => $NEW_ID,
													'NO_CONT' => $data['NO_CONT'],
													'UK_CONT' => $data['UK_CONT'],
													'JNS_CONT' => $data['JNS_CONT'], 
													'FL_CONT_KOSONG' => $data['FL_CONT_KOSONG'], 
													'ISO_CODE' => $data['ISO_CODE'], 
													'NO_SEGEL' => $data['NO_SEGEL'], 
													'NO_BL_AWB' => $data['NO_BL_AWB'], 
													'TGL_BL_AWB' => $data['TGL_BL_AWB'], 
													'NO_MASTER_BL_AWB' => $data['NO_MASTER_BL_AWB'], 
													'TGL_MASTER_BL_AWB' => $data['TGL_MASTER_BL_AWB'], 
													'ID_CONSIGNEE' => $data['ID_CONSIGNEE'], 
													'CONSIGNEE' => $data['CONSIGNEE'], 
													'BRUTO' => $data['BRUTO'], 
													'NO_BC11' => $data['NO_BC11'], 
													'TGL_BC11' => $data['TGL_BC11'], 
													'NO_POS_BC11' => $data['NO_POS_BC11'], 
													'KD_TIMBUN' => NULL, 
													'KD_SAR_ANGKUT_IN' => $data['KD_SAR_ANGKUT_IN'], 
													'NO_POL_IN' => $data['NO_POL_IN'], 
													'KD_DOK_IN' => $data['KD_DOK_IN'], 
													'NO_DOK_IN' => $data['NO_DOK_IN'], 
													'TGL_DOK_IN' => $data['TGL_DOK_IN'], 
													'WK_IN' => $data['WK_IN'], 
													'KD_SAR_ANGKUT_OUT' => $data['KD_SAR_ANGKUT_OUT'], 
													'NO_POL_OUT' => $data['NO_POL_OUT'], 
													'KD_DOK_OUT' => $data['KD_DOK_OUT'], 
													'NO_DOK_OUT' => $data['NO_DOK_OUT'], 
													'TGL_DOK_OUT' => $data['TGL_DOK_OUT'], 
													'WK_OUT' => $data['WK_OUT'], 
													'PEL_MUAT' => $data['PEL_MUAT'], 
													'PEL_TRANSIT' => $data['PEL_TRANSIT'], 
													'PEL_BONGKAR' => $data['PEL_BONGKAR'],
													'KODE_KANTOR_IN' => $data['KODE_KANTOR_IN'], 
													'NO_DAFTAR_PABEAN_IN' => $data['NO_DAFTAR_PABEAN_IN'], 
													'TGL_DAFTAR_PABEAN_IN' => $data['TGL_DAFTAR_PABEAN_IN'], 
													'NO_SEGEL_BC_IN' => $data['NO_SEGEL_BC_IN'], 
													'TGL_SEGEL_BC_IN' => $data['TGL_SEGEL_BC_IN'], 
													'NO_IJIN_TPS_IN' => $data['NO_IJIN_TPS_IN'], 
													'TGL_IJIN_TPS_IN' => $data['TGL_IJIN_TPS_IN'], 
													'KODE_KANTOR_OUT' => $data['KODE_KANTOR_OUT'], 
													'NO_DAFTAR_PABEAN_OUT' => $data['NO_DAFTAR_PABEAN_OUT'], 
													'TGL_DAFTAR_PABEAN_OUT' => $data['TGL_DAFTAR_PABEAN_OUT'], 
													'NO_SEGEL_BC_OUT' => $data['NO_SEGEL_BC_OUT'], 
													'TGL_SEGEL_BC_OUT' => $data['TGL_SEGEL_BC_OUT'], 
													'NO_IJIN_TPS_OUT' => $data['NO_IJIN_TPS_OUT'], 
													'TGL_IJIN_TPS_OUT' => $data['TGL_IJIN_TPS_OUT'], 
													'TGL_REKAM' => date('Y-m-d H:i:s'));
								if($COUNT > 0){
									unset($array_cont['ID']);
									unset($array_cont['NO_CONT']);
									$wms_db->where(array('ID' => $ID_CONT, 'NO_CONT' => $NO_CONT));
									$ex = $wms_db->update('cocostscont',$array_cont);
									echo "SUCCESS UPDATE, NO. CONT ".$NEW_ID." - ".$data['NO_CONT']."<BR>";
								}else{
									$ex = $wms_db->insert('cocostscont',$array_cont);
									echo "SUCCESS INSERT, NO. CONT ".$NEW_ID." - ".$data['NO_CONT']."<BR>";
								}
								if($ex){
									$this->db->where(array('ID' => $app_data['ID']));
									$this->db->update('app_komunikasi',array('KD_STATUS' => '200'));
								}
							}
						}
						$wms_db->close();
						remove_file($filename);
					}else{
						echo "APPLICATION IS RUNNING"; exit();
					}
				}else{
					echo "NO RECORDS FOUND"; exit();
				}
			}
		}else{
			echo "NO RECORDS FOUND"; exit();
		}
	}
	
	function codeco_kms(){
		$func =&get_instance();
		$func->load->model("m_main","main", true);
		$SQL = "SELECT LOWER(A.NM_TABLE) AS NM_TABLE, A.FIELD1, A.VALUE1, A.FIELD2, A.VALUE2, A.FIELD3, A.VALUE3, A.ID
				FROM app_komunikasi A
				WHERE A.KD_STATUS = '100'
				AND A.NM_TABLE = 'cocostskms'
				LIMIT 20";
		$result = $func->main->get_result($SQL);
		if($result){
			foreach($SQL->result_array() as $row => $value){
				$arrdata[] = $value;
			}
			foreach($arrdata as $app_data){
				if($app_data['FIELD1'] != "") $ADD_SQL .= " AND B.".$app_data['FIELD1']." = ".$this->db->escape($app_data['VALUE1']);
				if($app_data['FIELD2'] != "") $ADD_SQL .= " AND B.".$app_data['FIELD2']." = ".$this->db->escape($app_data['VALUE2']);
				if($app_data['FIELD3'] != "") $ADD_SQL .= " AND B.".$app_data['FIELD3']." = ".$this->db->escape($app_data['VALUE3']);
				$SQL = "SELECT A.ID, A.KD_DOK, A.KD_TPS, A.NM_ANGKUT, A.NO_VOY_FLIGHT, A.CALL_SIGN, A.TGL_TIBA, A.KD_GUDANG,
						B.NO_BL_AWB, B.TGL_BL_AWB, B.NO_MASTER_BL_AWB, B.TGL_MASTER_BL_AWB, B.ID_CONSIGNEE, B.CONSIGNEE, B.BRUTO, B.NO_BC11, 
						B.TGL_BC11, B.NO_POS_BC11, B.CONT_ASAL, B.SERI_KEMAS, B.KD_KEMAS, B.JML_KEMAS, B.KD_TIMBUN, B.KD_DOK_IN, B.NO_DOK_IN, 
						B.TGL_DOK_IN, B.WK_IN, B.KD_SAR_ANGKUT_IN, B.NO_POL_IN, B.KD_DOK_OUT, B.NO_DOK_OUT, B.TGL_DOK_OUT, B.WK_OUT,
						B.KD_SAR_ANGKUT_OUT, B.NO_POL_OUT, B.FL_CONT_KOSONG, B.ISO_CODE, B.PEL_MUAT, B.PEL_TRANSIT, B.PEL_BONGKAR, 
						B.GUDANG_TUJUAN, B.KODE_KANTOR_IN, B.NO_DAFTAR_PABEAN_IN, B.TGL_DAFTAR_PABEAN_IN, B.NO_SEGEL_BC_IN, B.TGL_SEGEL_BC_IN, 
						B.NO_IJIN_TPS_IN, B.TGL_IJIN_TPS_IN, B.FLAG, B.REF_NUMBER, B.KODE_KANTOR_OUT, B.NO_DAFTAR_PABEAN_OUT, 
						B.TGL_DAFTAR_PABEAN_OUT, B.NO_SEGEL_BC_OUT, B.TGL_SEGEL_BC_OUT, B.NO_IJIN_TPS_OUT, B.TGL_IJIN_TPS_OUT, B.WK_INSERT
						FROM cocostshdr A
						INNER JOIN cocostskms B ON B.ID=A.ID
						WHERE 1=1".$ADD_SQL;
				$exec = $this->db->query($SQL);
				if($exec->num_rows() > 0){
					$filename = DIR_EXE.'codeco_kms.txt';
					$check_file = check_file($filename);
					if(!$check_file){
						#create_file($filename);
						$wms_db = $this->load->database('wms',TRUE);
						$array_data = $exec->result_array();
						foreach($array_data as $data){
							$ID = $data['ID'];
							$KD_DOK = $data['KD_DOK'];
							$KD_TPS = $data['KD_TPS'];
							$KD_GUDANG = $data['KD_GUDANG'];
							$NM_ANGKUT = trim($data['NM_ANGKUT']);
							$NO_VOY_FLIGHT = trim($data['NO_VOY_FLIGHT']);
							$CALL_SIGN = trim($data['CALL_SIGN']);
							$TGL_TIBA = trim($data['TGL_TIBA']);
							$GETID = $this->get_data('cocostshdr',array($KD_TPS,$KD_GUDANG,$NM_ANGKUT,$NO_VOY_FLIGHT,$CALL_SIGN,$TGL_TIBA));
							$next = false;
							if($GETID == ""){
								$array_hdr = array('KD_DOK' => $KD_DOK,
												   'KD_TPS' => $KD_TPS,
												   'NM_ANGKUT' => $NM_ANGKUT,
												   'NO_VOY_FLIGHT' => $NO_VOY_FLIGHT,
												   'CALL_SIGN' => $CALL_SIGN,
												   'TGL_TIBA' => $TGL_TIBA,
												   'KD_GUDANG' => $KD_GUDANG,
												   'TGL_REKAM' => date('Y-m-d H:i:s'));
								$wms_db->insert('cocostshdr',$array_hdr);
								$NEW_ID = $wms_db->insert_id();
								$next = true;
							}else{
								$NEW_ID = $GETID;
								$next = true;
							}
							if($next){
								list($COUNT, $ID_KMS, $NO_BL_AWB) = $this->get_data('cocostskms',array($NEW_ID,$data['NO_BL_AWB']));
								$array_kms = array('ID' => $NEW_ID,
												   'SERI_KEMAS' => $this->set_seri('cocostskms',$NEW_ID),
												   'KD_KEMAS' => $data['KD_KEMAS'],
												   'JML_KEMAS' => $data['JML_KEMAS'], 
												   'CONT_ASAL' => $data['CONT_ASAL'],
												   'NO_BL_AWB' => $data['NO_BL_AWB'],
												   'TGL_BL_AWB' => $data['TGL_BL_AWB'],
												   'NO_MASTER_BL_AWB' => $data['NO_MASTER_BL_AWB'],
												   'TGL_MASTER_BL_AWB' => $data['TGL_MASTER_BL_AWB'],
												   'ID_CONSIGNEE' => $data['ID_CONSIGNEE'],
												   'CONSIGNEE' => $data['CONSIGNEE'],
												   'BRUTO' => $data['BRUTO'],
												   'NO_BC11' => $data['NO_BC11'],
												   'TGL_BC11' => $data['TGL_BC11'],
												   'NO_POS_BC11' => $data['NO_POS_BC11'],
												   'KD_TIMBUN' => $data['KD_TIMBUN'],
												   'KD_SAR_ANGKUT_IN' => $data['KD_SAR_ANGKUT_IN'],
												   'NO_POL_IN' => $data['NO_POL_IN'],
												   'KD_DOK_IN' => $data['KD_DOK_IN'],
												   'NO_DOK_IN' => $data['NO_DOK_IN'],
												   'TGL_DOK_IN' => $data['TGL_DOK_IN'],
												   'WK_IN' => $data['WK_IN'],
												   'KD_SAR_ANGKUT_OUT' => $data['KD_SAR_ANGKUT_OUT'],
												   'NO_POL_OUT' => $data['NO_POL_OUT'],
												   'KD_DOK_OUT' => $data['KD_DOK_OUT'],
												   'NO_DOK_OUT' => $data['NO_DOK_OUT'],
												   'TGL_DOK_OUT' => $data['TGL_DOK_OUT'],
												   'WK_OUT' => $data['WK_OUT'],
												   'PEL_MUAT' => $data['PEL_MUAT'],
												   'PEL_TRANSIT' => $data['PEL_TRANSIT'],
												   'PEL_BONGKAR' => $data['PEL_BONGKAR'],
												   'GUDANG_TUJUAN' => $data['GUDANG_TUJUAN'],
												   'KODE_KANTOR_IN' => $data['KODE_KANTOR_IN'],
												   'NO_DAFTAR_PABEAN_IN' => $data['NO_DAFTAR_PABEAN_IN'],
												   'TGL_DAFTAR_PABEAN_IN' => $data['TGL_DAFTAR_PABEAN_IN'],
												   'NO_SEGEL_BC_IN' => $data['NO_SEGEL_BC_IN'],
												   'TGL_SEGEL_BC_IN' => $data['TGL_SEGEL_BC_IN'],
												   'NO_IJIN_TPS_IN' => $data['NO_IJIN_TPS_IN'],
												   'TGL_IJIN_TPS_IN' => $data['TGL_IJIN_TPS_IN'],
												   'KODE_KANTOR_OUT' => $data['KODE_KANTOR_OUT'],
												   'NO_DAFTAR_PABEAN_OUT' => $data['NO_DAFTAR_PABEAN_OUT'], 
												   'TGL_DAFTAR_PABEAN_OUT' => $data['TGL_DAFTAR_PABEAN_OUT'],
												   'NO_SEGEL_BC_OUT' => $data['NO_SEGEL_BC_OUT'],
												   'TGL_SEGEL_BC_OUT' => $data['TGL_SEGEL_BC_OUT'],
												   'NO_IJIN_TPS_OUT' => $data['NO_IJIN_TPS_OUT'],
												   'TGL_IJIN_TPS_OUT' => $data['TGL_IJIN_TPS_OUT'],
												   'TGL_REKAM' => date('Y-m-d H:i:s'));
								if($COUNT > 0){
									unset($array_kms['ID']);
									unset($array_kms['NO_BL_AWB']);
									$wms_db->where(array('ID' => $ID_KMS, 'NO_BL_AWB' => $NO_BL_AWB));
									$ex = $wms_db->update('cocostskms',$array_kms);
									echo "SUCCESS UPDATE, NO. BL/AWB ".$NEW_ID." - ".$data['NO_BL_AWB']."<BR>";
								}else{
									$ex = $wms_db->insert('cocostskms',$array_kms);
									echo "SUCCESS INSERT, NO. BL/AWB ".$NEW_ID." - ".$data['NO_BL_AWB']."<BR>";
								}
								if($ex){
									$this->db->where(array('ID' => $app_data['ID']));
									$this->db->update('app_komunikasi',array('KD_STATUS' => '200'));
								}
							}
						}
						$wms_db->close();
						remove_file($filename);
					}else{
						echo "APPLICATION IS RUNNING"; exit();
					}
				}else{
					echo "NO RECORDS FOUND"; exit();
				}
			}
		}else{
			echo "NO. RECORDS FOUND";
		}
	}
	
	function set_seri($table,$id){
		$wms_db = $this->load->database('wms',TRUE);
		$SQL = "SELECT IFNULL(MAX(SERI_KEMAS)+1,1) AS SERI 
				FROM $table 
				WHERE ID = ".$this->db->escape($id);
		$result = $wms_db->query($SQL);
		if($result->num_rows() > 0){
			$seri = $result->row()->SERI;
		}
		return $seri;
	}
	
	function get_data($act,$data=array()){
		$wms_db = $this->load->database('wms',TRUE);
		if($act=="cocostshdr"){
			$SQL = "SELECT ID
					FROM cocostshdr 
					WHERE KD_TPS = ".$this->db->escape($data[0])."
					AND KD_GUDANG = ".$this->db->escape($data[1])."
					AND NM_ANGKUT = ".$this->db->escape($data[2])."
					AND NO_VOY_FLIGHT =".$this->db->escape($data[3])."
					AND CALL_SIGN =".$this->db->escape($data[4])."
					AND TGL_TIBA =".$this->db->escape($data[5]);
			$result = $wms_db->query($SQL);
			if($result->num_rows() > 0){
				$data = $result->row_array();
				$ID_HDR = $data['ID'];
			}else{
				$ID_HDR = "";
			}
			return $ID_HDR;
		}else if($act=="cocostscont"){
			$SQL = "SELECT ID, NO_CONT
					FROM cocostscont 
					WHERE ID = ".$this->db->escape($data[0])."
					AND NO_CONT = ".$this->db->escape($data[1]);
			$result = $wms_db->query($SQL);
			if($result->num_rows() > 0){
				$data = $result->row_array();
				$arrReturn = array($result->num_rows(),$data['ID'],$data['NO_CONT']);
			}else{
				$arrReturn = array(0,'','');
			}
			return $arrReturn;
		}else if($act=="cocostskms"){
			$SQL = "SELECT ID, NO_BL_AWB
					FROM cocostskms 
					WHERE ID = ".$this->db->escape($data[0])."
					AND NO_BL_AWB = ".$this->db->escape($data[1]);
			$result = $wms_db->query($SQL);
			if($result->num_rows() > 0){
				$data = $result->row_array();
				$arrReturn = array($result->num_rows(),$data['ID'],$data['NO_BL_AWB']);
			}else{
				$arrReturn = array(0,'','');
			}
			return $arrReturn;
		}else if($act=="responplp_hdr"){
			$SQL = "SELECT ID
					FROM t_respon_plp_tujuan_hdr 
					WHERE NO_PLP = ".trim($this->db->escape($data[0]))."
					AND TGL_PLP = ".trim($this->db->escape($data[1]))."
					ORDER BY TGL_PLP DESC LIMIT 1";
			$result = $wms_db->query($SQL);
			if($result->num_rows() > 0){
				$data = $result->row_array();
				$arrReturn = array($result->num_rows(),$data['ID']);
			}else{
				$arrReturn = array(0,'');
			}
			return $arrReturn;
		}else if($act=="responplp_cont"){
			$SQL = "SELECT KD_RESPON_PLP_TUJUAN AS ID, NO_CONT
					FROM t_respon_plp_tujuan_cont 
					WHERE KD_RESPON_PLP_TUJUAN = ".trim($this->db->escape($data[0]))."
					AND NO_CONT = ".trim($this->db->escape($data[1]));
			$result = $wms_db->query($SQL);
			if($result->num_rows() > 0){
				$data = $result->row_array();
				$arrReturn = array($result->num_rows(),$data['ID'],$data['NO_CONT']);
			}else{
				$arrReturn = array(0,'','');
			}
			return $arrReturn;
		}
		$wms_db->close();
	}
}
?>