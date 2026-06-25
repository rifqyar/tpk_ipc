<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_home extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	function signin($uid_, $pwd_, $adm=FALSE){

		$query = "SELECT A.ID AS USERID, A.USER_NAME AS USERLOGIN,A.NPWP AS NPWP, A.PASS AS PASSWORD, A.NAMA AS NM_LENGKAP, A.NOTELP, A.EMAIL,
				  A.KD_GROUP, A.KD_GA, A.KD_TPS, A.KD_GUDANG, A.STATUS, B.NAMA AS NM_GROUP, C.NAMA_GUDANG AS NM_GUDANG, D.NAMA AS NAMA_TPS,
				  A.LAST_LOGIN, A.WK_REKAM, ADDDATE(A.WK_REKAM, INTERVAL 3 MONTH) AS NEXT_3_MONTH, NOW() AS WK_NOW
				  FROM reff_user A
				  INNER JOIN reff_group B ON B.ID = A.KD_GROUP
				  LEFT JOIN reff_gudang C ON C.KD_GUDANG = A.KD_GUDANG
				  LEFT JOIN reff_tps D ON D.ID=A.KD_TPS
				  WHERE A.USER_NAME = ".$this->db->escape($uid_)." AND A.PASS = ".$this->db->escape($pwd_);
		$data = $this->db->query($query);
		if($data->num_rows() > 0){
			$rs = $data->row();
			if($rs->STATUS != 'ACTIVE'){
				return -1;
			}else{
				$sql = "SELECT A.WK_REKAM, ADDDATE(A.WK_REKAM, INTERVAL 3 MONTH) AS NEXT_3_MONTH, NOW() AS WK_NOW
						FROM reff_user A
						WHERE DATE(NOW()) <= ADDDATE(DATE(A.WK_REKAM), INTERVAL 3 MONTH)
						AND A.USER_NAME = ".$this->db->escape($uid_)." AND A.PASS = ".$this->db->escape($pwd_);
				$result = $this->db->query($sql);
				if($result->num_rows() > 0){
					foreach($data->result_array() as $row){
						$datses['LOGGED'] = true;
						$datses['IP'] = $_SERVER['REMOTE_ADDR'];
						$datses['USERLOGIN'] = $uid_;
						$datses['PASSWORD'] = $pwd_;
						$datses['ID'] = $row['USERID'];
						$datses['NM_LENGKAP'] = $row['NM_LENGKAP'];
						$datses['NPWP'] = $row['NPWP'];
						$datses['NOTELP'] = $row['NOTELP'];
						$datses['KD_GROUP'] = $row['KD_GROUP'];
						$datses['KD_GUDANG'] = $row['KD_GUDANG'];
						$datses['KD_TPS'] = $row['KD_TPS'];
						$datses['STATUS'] = $row['STATUS'];
						$datses['EMAIL'] = $row['EMAIL'];
						$datses['NM_GROUP'] = $row['NM_GROUP'];
						$datses['NM_GUDANG'] = $row['NM_GUDANG'];
						$datses['NM_TPS'] = $row['NAMA_TPS'];
						$datses['LAST_LOGIN'] = $row['LAST_LOGIN'];
					}
					$this->last_login($rs->USERID);
					$this->session->set_userdata($datses);
					return 1;
				}else{
					foreach($data->result_array() as $row){
						$datses['LOGGED'] = false;
						$datses['IP'] = $_SERVER['REMOTE_ADDR'];
						$datses['USERLOGIN'] = $uid_;
						$datses['PASSWORD'] = $pwd_;
						$datses['ID'] = $row['USERID'];
						$datses['NM_LENGKAP'] = $row['NM_LENGKAP'];
						$datses['NOTELP'] = $row['NOTELP'];
						$datses['NPWP'] = $row['NPWP'];
						$datses['KD_GROUP'] = $row['KD_GROUP'];
						$datses['KD_GUDANG'] = $row['KD_GUDANG'];
						$datses['KD_TPS'] = $row['KD_TPS'];
						$datses['STATUS'] = $row['STATUS'];
						$datses['EMAIL'] = $row['EMAIL'];
						$datses['NM_GROUP'] = $row['NM_GROUP'];
						$datses['NM_GUDANG'] = $row['NM_GUDANG'];
						$datses['NM_TPS'] = $row['NAMA_TPS'];
						$datses['LAST_LOGIN'] = $row['LAST_LOGIN'];
					}
					$this->session->set_userdata($datses);
					return 2;
				}
			}
		}else{
			return 0;
		}
	}

	function last_login($ID){
		$data = array('LAST_LOGIN' => date('Y-m-d H:i:s'));
		$this->db->where('ID', $ID);
		$this->db->update('reff_user', $data);
	}

	function execute($type, $act){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$success = 0;
		$error = 0;
		$message = "";
		$USERLOGIN = $this->session->userdata('USERLOGIN');
		if($type=="update"){
			if($act=="password"){
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") $DATA[$a] = NULL;
					else $DATA[$a] = $b;
				}

				$query = "SELECT A.ID AS USERID
						  FROM reff_user A
						  WHERE A.USER_NAME = ".$this->db->escape($USERLOGIN)." AND A.PASS = ".$this->db->escape(md5($DATA['PASS_OLD']));

				$data = $this->db->query($query);
				if($data->num_rows() > 0){
					$rs = $data->row();
					if($DATA['PASS_NEW']==$DATA['PASS_CONFIRM']){
						$ARRDATA['PASS'] = md5($DATA['PASS_NEW']);
						$ARRDATA['WK_REKAM'] = date('Y-m-d H:i:s');
						$this->db->where(array('ID' => $rs->USERID));
						$exec = $this->db->update('reff_user', $ARRDATA);
						if($exec){
							$this->last_login($rs->USERID);
							$datses['LOGGED'] = true;
							$this->session->set_userdata($datses);
							$func->main->get_log('update','app_user');
							$message = "1|Data berhasil diproses|".base_url().'application.php';
						}
					}else{
						$error += 1;
						$message .= "0|Data gagal diproses, Konfirmasi password tidak sesuai";
					}
				}else{
					$error += 1;
					$message .= "0|Data gagal diproses, Password lama tidak sesuai";
				}
				$arrayReturn['returnData']= $message;
				echo json_encode($arrayReturn);
			}
		}
	}
}
?>
