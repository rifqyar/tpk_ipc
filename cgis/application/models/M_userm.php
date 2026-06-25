<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_userm extends CI_Model {

	public function __construct(){
		parent::__construct();

	}

	function get_data($act, $id) {
        $func = get_instance();
        $func->load->model("m_main", "main");
        $arrdata = array();
		if ($act == "user") {
            $SQL = "SELECT A.ID, A.KD_ORGANISASI ,B.NAMA AS NAMA_ORGANISASI,  A.USERLOGIN ,A.PASSWORD ,A.NM_LENGKAP ,A.HANDPHONE,
                    A.EMAIL, A.KD_GROUP ,C.NAMA AS NAMA_GROUP, A.KD_TPS , A.KD_GUDANG, D.NAMA_GUDANG ,A.KD_STATUS, A.KETERANGAN, A.PATH
                    FROM app_user A
                    LEFT JOIN t_organisasi B ON B.ID = A.KD_ORGANISASI
                    LEFT JOIN app_group C ON C.ID = A.KD_GROUP
                    LEFT JOIN reff_gudang D ON D.KD_GUDANG = A.KD_GUDANG
                    WHERE A.ID = " . $this->db->escape($id);
            $result = $func->main->get_result($SQL);
            if ($result) {
                foreach ($SQL->result_array() as $row => $value) {
                    $arrdata = $value;
                }
                return $arrdata;
            } else {
                redirect(site_url(), 'refresh');
            }
        } else if ($act == "access_menu"){
			if($this->session->userdata('KD_GROUP')=="SPA"){
				$SQL = "SELECT B.ID, B.ID_PARENT, B.JUDUL_MENU, B.URL, B.URUTAN, B.TIPE, B.TARGET,
						B.ACTION, B.CLS_ICON AS ICON, C.KD_MENU AS MENU_ACT, C.HAK_AKSES AS AKSES_ACT
						FROM reff_menu B
						LEFT JOIN (SELECT KD_MENU, HAK_AKSES FROM reff_group_menu WHERE KD_GROUP = '".$id."') C ON C.KD_MENU=B.ID
						ORDER BY B.ID_PARENT, B.URUTAN ASC";
			}else{
				$SQL = "SELECT B.ID, B.ID_PARENT, B.JUDUL_MENU, B.URL, B.URUTAN, B.TIPE, B.TARGET,
						B.ACTION, B.CLS_ICON AS ICON, C.KD_MENU AS MENU_ACT, C.HAK_AKSES AS AKSES_ACT
						FROM reff_group_menu A
						INNER JOIN reff_menu B ON A.KD_MENU = B.ID
						LEFT JOIN (SELECT KD_MENU, HAK_AKSES FROM reff_group_menu WHERE KD_GROUP = '".$id."') C ON C.KD_MENU=B.ID
						WHERE A.KD_GROUP = '" .$this->session->userdata('KD_GROUP')."'
						ORDER BY B.ID_PARENT, B.URUTAN ASC";
			}//echo $SQL;die();
			$result = $this->db->query($SQL);
			if($result->num_rows() > 0){
				foreach($result->result_array() as $row){
					if($row['ID_PARENT'] == "") $parent_id = 0;
					else $parent_id = $row['ID_PARENT'];
					$data[$parent_id][] = array("ID" => $row['ID'],
												"ID_PARENT"	 => $row['ID_PARENT'],
												"JUDUL_MENU" => $row['JUDUL_MENU'],
												"URL"	 	 => $row['URL'],
												"URUTAN" 	 => $row['URUTAN'],
												"TIPE"	 	 => $row['TIPE'],
												"TARGET"	 => $row['TARGET'],
												"ACTION"	 => $row['ACTION'],
												"ICON"	 	 => $row['ICON'],
												"MENU_ACT"	 => $row['MENU_ACT'],
												"AKSES_ACT"	 => $row['AKSES_ACT']
												);
				}
				$data = $this->draw_menu($data);
			}
			return $data;
		}else if ($act == "group") {
            $SQL = "SELECT ID, NAMA FROM reff_group WHERE ID = " . $this->db->escape($id);
            $result = $func->main->get_result($SQL);
            if ($result) {
                foreach ($SQL->result_array() as $row => $value) {
                    $arrdata = $value;
                }
                return $arrdata;
            } else {
                redirect(site_url(), 'refresh');
            }
        } else if ($act == "menu") {
            $SQL = "SELECT A.ID, A.ID_PARENT , A.JUDUL_MENU , A.URL , A.URL_CI , A.URUTAN, A.TIPE , A.TARGET , A.ACTION, A.CLS_ICON
                    FROM app_menu A WHERE A.ID = " . $this->db->escape($id);
            $result = $func->main->get_result($SQL);
            if ($result) {
                foreach ($SQL->result_array() as $row => $value) {
                    $arrdata = $value;
                }
                return $arrdata;
            } else {
                redirect(site_url(), 'refresh');
            }
        } else if ($act == "profile") {
            $SQL = "SELECT A.*
                    FROM t_organisasi A WHERE A.ID = " . $this->db->escape($id);
            $result = $func->main->get_result($SQL);
            if ($result) {
                foreach ($SQL->result_array() as $row => $value) {
                    $arrdata = $value;
                }
                return $arrdata;
            } else {
                redirect(site_url(), 'refresh');
            }
        } else if ($act == "user_profile") {
            $SQL = "SELECT A.* FROM reff_user A WHERE A.ID = " . $this->db->escape($id);
            $result = $func->main->get_result($SQL);
            if ($result) {
                foreach ($SQL->result_array() as $row => $value) {
                    $arrdata = $value;
                }
                return $arrdata;
            } else {
                redirect(site_url(), 'refresh');
            }
        } else if ($act == "organisasi") {
            $SQL = "SELECT A.ID, A.KD_KAPAL, A.NPWP, A.NAMA, A.ALAMAT, A.NOTELP, A.NOFAX, A.EMAIL, A.KD_TIPE_ORGANISASI, A.KD_TPS
                    FROM t_organisasi A
                    INNER JOIN reff_tipe_organisasi B ON B.ID = A.KD_TIPE_ORGANISASI
                    WHERE A.ID = " . $this->db->escape($id);
            $result = $func->main->get_result($SQL);
            if ($result) {
                foreach ($SQL->result_array() as $row => $value) {
                    $arrdata = $value;
                }
                return $arrdata;
            } else {
                redirect(site_url(), 'refresh');
            }
        }

    }

	function execute($type, $act, $id) {
        $func = get_instance();
        $func->load->model("m_main", "main", true);
        $success = 0;
        $error = 0;
        $USERLOGIN = $this->session->userdata('USERLOGIN');
        $KD_TPS = $this->session->userdata('KD_TPS');
        $KD_GUDANG = $this->session->userdata('KD_GUDANG');
        if($type == "save"){
			if($act == "user"){
				foreach ($this->input->post('DATA') as $a => $b){
					if($b=="") $DATA[$a] = NULL;
					else $DATA[$a] = trim(strtoupper($b));
				}
				$SQL = "SELECT USERLOGIN
						FROM app_user
						WHERE USERLOGIN = ".$this->db->escape($DATA['USERLOGIN']);
				$result = $func->main->get_result($SQL);
				if($result){
					$error += 1;
					$message = "Data gagal diproses, sudah terdapat data";
				}else{
					if($_FILES['FOTO']['name']!=""){
						$folder_path = date("Ymd");
						$uploads_dir = './assets/images/foto/'.$folder_path;
						if (!is_dir($uploads_dir))
							mkdir($uploads_dir);
						$uploads_dir .= "/";
						$orig_name = $_FILES['FOTO']['name'];
						$change_name = date("His").".".pathinfo($orig_name, PATHINFO_EXTENSION);
						$path = 'assets/images/foto/'.$folder_path."/".$change_name;
						ini_set('upload_max_filesize', '5M');
						$allowed = array('gif','png','jpg');
						$config['remove_spaces'] = TRUE;
						$config['upload_path'] = $uploads_dir;
						$config['file_name'] = $change_name;
						$this->load->library('upload', $config);
						if(!$this->upload->do_upload("FOTO")){
							$error += 1;
							$message = "Error, ".$this->upload->display_errors();
						}else{
							$myfile = fopen($uploads_dir . "/index.php", "w");
							$text = "<?php if(!defined('BASEPATH'))exit('Directory access is forbidden.'); ?>";
							fwrite($myfile, $text);
							fclose($myfile);
						}
						if(!in_array(pathinfo($orig_name, PATHINFO_EXTENSION),$allowed)){
							$DATA['PATH'] = $path;
						}
					}
					$DATA['PASSWORD'] = md5($DATA['PASSWORD']);
					$this->db->insert('app_user', $DATA);
				}
				if($error==0){
					$func->main->get_log("add", "app_user");
					echo "MSG#OK#Data berhasil diproses#".site_url()."/management/user/post";
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}else if ($act == "privilege") {
				$KD_GROUP = $this->input->post('KD_GROUP');
				$KD_MENU = $this->input->post('KD_MENU');
				$HAK_AKSES = $this->input->post('HAK_AKSES');
				$SQL = "";
				if(count($KD_MENU) > 0){
					for($a = 0; $a<count($KD_MENU); $a++){
						$SQL .= "(".$this->db->escape($KD_GROUP).", ".$this->db->escape($KD_MENU[$a]).", ".$this->db->escape($HAK_AKSES[$a])."),";
					}
					$SQL = "INSERT INTO reff_group_menu (KD_GROUP, KD_MENU, HAK_AKSES) VALUES ".substr($SQL,0,-1);
					if(!$this->db->simple_query($SQL)){
						$error += 1;
						$message = "Data gagal diproses";
					}
				}
                if ($error==0) {
                    //$func->main->get_log("add", "app_user_menu");
                    echo "MSG#OK#Data berhasil diproses#" . site_url() . "/usermanage/privil/post";
                } else {
                    echo "MSG#ERR#".$message."#";
                }
            }else if ($act == "group") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        $DATA[$a] = NULL;
                    else
                        $DATA[$a] = $b;
                }
                $result = $this->db->insert('reff_group', $DATA);
                if ($result) {
                    //$func->main->get_log("save", "app_group");
                    echo "MSG#OK#Data berhasil diproses#" . site_url() . "/usermanage/group/post";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "menu") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        $DATA[$a] = NULL;
                    else
                        $DATA[$a] = $b;
                }
                $result = $this->db->insert('app_menu', $DATA);
                if ($result) {
                    $func->main->get_log("save", "app_menu");
                    echo "MSG#OK#Data berhasil diproses#" . site_url() . "/management/menu/post";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "organisasi") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        $DATA[$a] = NULL;
                    else
                        $DATA[$a] = $b;
                }
                $result = $this->db->insert('t_organisasi', $DATA);
                if ($result) {
                    $func->main->get_log("save", "t_organisasi");
                    echo "MSG#OK#Data berhasil diproses#" . site_url() . "/management/organisasi/post";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            }
        } else if ($type == "update") {
			if ($act == "user") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if($b=="") $DATA[$a] = NULL;
                    else $DATA[$a] = trim(strtoupper($b));
                }
				if($_FILES['FOTO']['name']!=""){
					$folder_path = date("Ymd");
					$uploads_dir = './assets/images/foto/'.$folder_path;
					if (!is_dir($uploads_dir))
						mkdir($uploads_dir);
					$uploads_dir .= "/";
					$orig_name = $_FILES['FOTO']['name'];
					$ext = pathinfo($orig_name, PATHINFO_EXTENSION);
					$change_name = date("His").".".$ext;
					$path = 'assets/images/foto/'.$folder_path."/".$change_name;
					ini_set('upload_max_filesize', '5M');
					$allowed = array('gif','png','jpg','jpeg');
					$config['remove_spaces'] = TRUE;
					$config['upload_path'] = $uploads_dir;
					$config['file_name'] = $change_name;
					$this->load->library('upload', $config);
					if(in_array($ext,$allowed)){
						if(!$this->upload->do_upload("FOTO")){
							$error += 1;
							$message = "Error, ".$this->upload->display_errors();
						}else{
							unlink($this->input->post('PATH'));
							$myfile = fopen($uploads_dir . "/index.php", "w");
							$text = "<?php if(!defined('BASEPATH'))exit('Directory access is forbidden.'); ?>";
							fwrite($myfile, $text);
							fclose($myfile);
						}
						$DATA['PATH'] = $path;
					}
				}
				unset($DATA['USERLOGIN']);
                if($DATA['PASSWORD'] == "") unset($DATA['PASSWORD']);
                else $DATA['PASSWORD'] = md5($DATA['PASSWORD']);
                $this->db->where(array('ID' => $id));
                $result = $this->db->update('app_user', $DATA);
                if ($result) {
                    $func->main->get_log("update", "app_user");
                    echo "MSG#OK#Data berhasil diproses#".site_url()."/management/user/post";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "privilege") {
                $KD_GROUP = $this->input->post('KD_GROUP');
				$KD_MENU = $this->input->post('KD_MENU');
				$HAK_AKSES = $this->input->post('HAK_AKSES');
				$SQL = "";
				if(count($KD_MENU) > 0){
					$result = $this->db->delete('reff_group_menu', array('KD_GROUP' => $KD_GROUP));
					if($result){
						for($a = 0; $a<count($KD_MENU); $a++){
							$SQL .= "(".$this->db->escape($KD_GROUP).", ".$this->db->escape($KD_MENU[$a]).", ".$this->db->escape($HAK_AKSES[$a])."),";
						}
						$SQL = "INSERT INTO reff_group_menu (KD_GROUP, KD_MENU, HAK_AKSES) VALUES ".substr($SQL,0,-1);
						if(!$this->db->simple_query($SQL)){
							$error += 1;
							$message = "Data gagal diproses";
						}
					}
				}
                if ($error==0) {
                    //$func->main->get_log("add", "app_user_menu");
                    echo "MSG#OK#Data berhasil diproses#" . site_url() . "/usermanage/privil/post";
                } else {
                    echo "MSG#ERR#".$message."#";
                }
            } else if ($act == "group") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        $DATA[$a] = NULL;
                    else
                        $DATA[$a] = $b;
                }
                $this->db->where(array('ID' => $id));
                $result = $this->db->update('reff_group', $DATA);
                if ($result) {
                    //$func->main->get_log("update", "app_group");
                    echo "MSG#OK#Data berhasil diproses#" . site_url() . "/usermanage/group/post";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "menu") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        $DATA[$a] = NULL;
                    else
                        $DATA[$a] = $b;
                }
                $this->db->where(array('ID' => $id));
                $result = $this->db->update('app_menu', $DATA);
                if ($result) {
                    $func->main->get_log("update", "app_menu");
                    echo "MSG#OK#Data berhasil diproses#" . site_url() . "/management/menu/post";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "organisasi") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        $DATA[$a] = NULL;
                    else
                        $DATA[$a] = $b;
                }
                $this->db->where(array('ID' => $id));
                $result = $this->db->update('t_organisasi', $DATA);
                if ($result) {
                    $func->main->get_log("update", "t_organisasi");
                    echo "MSG#OK#Data berhasil diproses#" . site_url() . "/management/organisasi/post";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "reset_password") {
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        $DATA[$a] = NULL;
                    else
                        $DATA[$a] = strtoupper($b);
                }
                $query = "SELECT A.ID AS USERID
						  FROM app_user A
						  INNER JOIN t_organisasi B ON A.KD_ORGANISASI = B.ID
						  INNER JOIN app_group C ON A.KD_GROUP = C.ID
						  LEFT JOIN reff_gudang D ON A.KD_GUDANG = D.KD_GUDANG
						  LEFT JOIN reff_tps E ON E.KD_TPS=A.KD_TPS
						  WHERE A.USERLOGIN = " . $this->db->escape($USERLOGIN) . " AND A.PASSWORD = " . $this->db->escape(md5($DATA['PASS_OLD']));
                $data = $this->db->query($query);
                if ($data->num_rows() > 0) {
                    $rs = $data->row();
                    if ($DATA['PASS_NEW'] == $DATA['PASS_CONFIRM']) {
                        $ARRDATA['PASSWORD'] = md5($DATA['PASS_NEW']);
                        $ARRDATA['WK_REKAM'] = date('Y-m-d H:i:s');
                        $this->db->where(array('ID' => $rs->USERID));
                        $this->db->update('app_user', $ARRDATA);
                    } else {
                        $error += 1;
                        $message .= "Data gagal diproses, Konfirmasi password tidak sesuai";
                    }
                } else {
                    $error += 1;
                    $message .= "Data gagal diproses, Password lama tidak sesuai";
                }
                if ($error == 0) {
                    $func->main->get_log("update", "app_user");
                    $this->session->sess_destroy();
                    echo "MSG#OK#Data berhasil diproses#" . base_url();
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "user_profile") {
                $ID_USR = $this->session->userdata('ID');
                $ID_ORG = $this->session->userdata('KD_ORGANISASI');
                foreach ($this->input->post('DATA') as $a => $b) {
                    if ($b == "")
                        $DATA[$a] = NULL;
                    else
                        $DATA[$a] = strtoupper($b);
                }
                $this->db->where(array('ID' => $ID_ORG));
                $exec_profile = $this->db->update('t_organisasi', $DATA);
                if (!$exec_profile) {
                    $error += 1;
                    $message .= "Data gagal diproses, Periksa data profile";
                }
                foreach ($this->input->post('USER') as $a => $b) {
                    if ($b == "")
                        $USER[$a] = NULL;
                    else
                        $USER[$a] = strtoupper($b);
                }
                $this->db->where(array('ID' => $ID_USR));
                $exec_user = $this->db->update('app_user', $USER);
                if (!$exec_user) {
                    $error += 1;
                    $message .= "Data gagal diproses, Periksa data user";
                }
                if ($error == 0) {
                    $func->main->get_log("update", "t_organisasi,app_user");
                    $this->session->sess_destroy();
                    echo "MSG#OK#Data berhasil diproses#" . base_url();
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            }
        } else if ($type == "delete") {
			if ($act=="user"){
                foreach ($this->input->post('tb_chktbldata') as $chkitem) {
                    $arrchk = explode("~", $chkitem);
                    $ID = $arrchk[0];
                    $result = $this->db->delete('app_user', array('ID' => $ID));
                    if (!$result) {
                        $error += 1;
                        $message .= "Data gagal diproses";
                    }
                }
                if ($error==0) {
                    $func->main->get_log("delete", "app_user");
                    echo "MSG#OK#Data berhasil diproses#".site_url()."/management/user/post";
                } else {
                    echo "MSG#ERR#".$message."#";
                }
			} else if ($act == "privilege") {
                foreach ($this->input->post('tb_chktbldata') as $chkitem) {
                    $arrchk = explode("~", $chkitem);
                    $ID_USR = $arrchk[0];
                    $ID_MENU = $arrchk[1];
                    $result = $this->db->delete('reff_group_menu', array('KD_GROUP' => $ID_USR));
                    if (!$result) {
                        $error += 1;
                        $message .= "Data gagal diproses";
                    }
                }
                if ($error == 0) {
                    //$func->main->get_log("delete", "app_user_menu");
                    echo "MSG#OK#Data berhasil diproses#".site_url()."/management/privilege/post#";
                } else {
                    echo "MSG#ERR#".$message."#";
                }
            } else if ($act == "group") {
                foreach ($this->input->post('tb_chktblgrp') as $chkitem) {
                    $arrchk = explode("~", $chkitem);
                    $ID = $arrchk[0];
                    $result = $this->db->delete('reff_group', array('ID' => $ID));
                    if (!$result) {
                        $error += 1;
                        $message .= "Could not be processed data";
                    }
                }
                if ($error == 0) {
                    //$func->main->get_log("delete", "app_group");
                    echo "MSG#OK#Successfully to be processed#" . site_url() . "/usermanage/group/post#";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "menu") {
                foreach ($this->input->post('tb_chktblmenu') as $chkitem) {
                    $arrchk = explode("~", $chkitem);
                    $ID = $arrchk[0];
                    $result = $this->db->delete('app_menu', array('ID' => $ID));
                    if (!$result) {
                        $error += 1;
                        $message .= "Could not be processed data";
                    }
                }
                if ($error == 0) {
                    $func->main->get_log("delete", "app_menu");
                    echo "MSG#OK#Successfully to be processed#" . site_url() . "/management/menu/post#";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            } else if ($act == "organisasi") {
                foreach ($this->input->post('tb_chktblorganisasi') as $chkitem) {
                    $arrchk = explode("~", $chkitem);
                    $ID = $arrchk[0];
                    $result = $this->db->delete('t_organisasi', array('ID' => $ID));
                    if (!$result) {
                        $error += 1;
                        $message .= "Could not be processed data";
                    }
                }
                if ($error == 0) {
                    $func->main->get_log("delete", "t_organisasi");
                    echo "MSG#OK#Successfully to be processed#" . site_url() . "/management/organisasi/post#";
                } else {
                    echo "MSG#ERR#" . $message . "#";
                }
            }
        }
    }

	function draw_menu($data,$parent=0){
		$html = "";
		$child = "";
		if($data[$parent]!=0){
			$html .= '<ol style="margin:0.5em 0em 0em -2.5em">';
			for($c=0; $c<count($data[$parent]); $c++){
				$checked = ($data[$parent][$c]['MENU_ACT']!="")?"checked":"";
				$W = ($data[$parent][$c]['AKSES_ACT']=="W")?"selected":"";
				$R = ($data[$parent][$c]['AKSES_ACT']=="R")?"selected":"";
				$child = $this->draw_menu($data, $data[$parent][$c]['ID']);
				$html .= "<li>".strtoupper($data[$parent][$c]["JUDUL_MENU"]);
				$html .= '<div class="form-group">';
				$html .= '<div class="input-group">';
				$html .= '<span class="input-group-addon">';
				$html .= '<span class="checkbox-custom checkbox-primary">';
				$html .= '<input type="checkbox" name="KD_MENU[]" '.$checked.' id="KD_MENU_'.$data[$parent][$c]["ID"].'" value="'.$data[$parent][$c]["ID"].'">';
				$html .= '<label for="HAK_AKSES_'.$data[$parent][$c]["ID"].'"></label>';
				$html .= '</span>';
				$html .= '</span>';
				$html .= '<select class="form-control" name="HAK_AKSES[]" checked id="HAK_AKSES_'.$data[$parent][$c]["ID"].'">';
				$html .= '<option value="W" '.$W.'>W</option>';
				$html .= '<option value="R" '.$R.'>R</option>';
				$html .= '</select>';
				$html .= '</div>';
				$html .= '</div>';

				if($child){
					$html .= '<ol>'.$child.'</ol>';
				}
				$html .= '</li>';
			}
			$html .= '</ol>';
			return $html;
		}
	}

	public function user($act, $id){
		$page_title = "USER";
		$title = "USER";
		$this->newtable->breadcrumb('Dashboard', site_url(),'icon-home');
		$this->newtable->breadcrumb('Management', 'javascript:void(0)','');
		$this->newtable->breadcrumb('USER', 'javascript:void(0)','');
		$check = (grant()=="W")?true:false;
		if($KD_GROUP!="SPA"){
			///$addsql .= " AND A.KD_TPS = ".$this->db->escape($KD_TPS)." AND A.KD_GUDANG = ".$this->db->escape($KD_GUDANG);
		}
		$SQL = "SELECT ID,USER_NAME AS 'USERNAME', NAMA AS 'NAMA USER', EMAIL AS 'E-MAIL',KD_GROUP AS 'KODE GROUP', STATUS, LAST_LOGIN AS 'LAST LOGIN' FROM reff_user";

		$proses = array('ENTRY'  => array('MODAL',"usermanage/user/add", '0','','md-plus-circle','', 'menu'),
						'UPDATE' => array('MODAL',"usermanage/user/update", '1','','md-edit','', 'list'),
						'DELETE'  => array('DELETE',"execute/process/delete/user", '1','','md-close-circle','', 'menu'));

		$this->newtable->multiple_search(true);
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('USER_NAME','USERNAME'),array('NAMA','NAMA PENGGUNA'),array('EMAIL','E-MAIL')));
		$this->newtable->action(site_url() . "/usermanage/user");
		//if($check) $this->newtable->detail(array('DRILLDOWN',site_url()."/coarri/discharge/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("ID");
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tbluser");
		$this->newtable->set_divid("divuser");
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

	function privil($act, $id) {
        $func = get_instance();
        $this->load->library('newtable');
        $this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
        $this->newtable->breadcrumb('Management', 'javascript:void(0)', '');
        $this->newtable->breadcrumb('Privilege', 'javascript:void(0)', '');
		$check = (grant()=="W")?true:false;
       	$page_title = "PRIVILEGE";
		$title = "PRIVILEGE";
		$KD_GROUP = $this->session->userdata('KD_GROUP');
        //$KD_ORGANISASI = $this->session->userdata('KD_ORGANISASI');
        if($KD_GROUP != "SPA"){

			$addsql = " AND B.KD_GROUP = 'USR'";
        }
        $SQL = "SELECT A.KD_GROUP, GROUP_CONCAT('[',C.JUDUL_MENU,'] ',IFNULL(C.URL,''),
				'&nbsp;<span class=\"label label-primary\">[ ',A.HAK_AKSES,' ]</span><BR>' ORDER BY C.URUTAN SEPARATOR '') AS URL
				FROM reff_group_menu A

                INNER JOIN reff_menu C ON C.ID = A.KD_MENU
				WHERE 1=1".$addsql." GROUP BY A.KD_GROUP"; //echo $SQL;die();
		$proses = array('ADD' => array('MODAL', "usermanage/privil/add", '0', '', 'md-plus-circle','','menu'),
						'EDIT' => array('MODAL', "usermanage/privil/update", '1', '', 'md-edit','','menu'),
						'DELETE' => array('DELETE', "usermanage/execute/delete/privilege", 'ALL', '', 'md-close-circle','','menu'));
        $this->newtable->search(array(array('C.JUDUL_MENU', 'JUDUL MENU')));
        $this->newtable->action(site_url() . "/usermanage/privil");
        $this->newtable->hiddens(array(""));
        $this->newtable->keys(array("KD_GROUP"));
        $this->newtable->multiple_search(true);
        $this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->tipe_proses('button');
        $this->newtable->show_search(true);
        $this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby('ASC');
        $this->newtable->set_formid("tbldata");
        $this->newtable->set_divid("divtbldata");
        $this->newtable->rowcount(10);
        $this->newtable->clear();
        $this->newtable->menu($proses);
        $tabel .= $this->newtable->generate($SQL);
        $arrdata = array("title" => $title, "page_title" => $page_title, "content" => $tabel);
        if ($this->input->post("ajax") || $act == "post")
            return $tabel;
        else
            return $arrdata;
    }

//BARU CAH
    function group($act, $id) {
        $func = get_instance();
        $this->load->library('newtable');
        $this->newtable->breadcrumb('Dashboard', site_url(), 'icon-home');
        $this->newtable->breadcrumb('Management', 'javascript:void(0)', '');
        $this->newtable->breadcrumb('Group', 'javascript:void(0)', '');
        $check = (grant()=="W")?true:false;
        $page_title = "GROUP";
				$title = "GROUP";
        $KD_GROUP = $this->session->userdata('KD_GROUP');
        //$KD_ORGANISASI = $this->session->userdata('KD_ORGANISASI');
        if($KD_GROUP != "SPA"){

            $addsql = " AND B.KD_GROUP = 'USR'";
        }
        $SQL = "SELECT ID, NAMA FROM reff_group";

        $proses = array('ADD' => array('MODAL', "usermanage/group/add", '0', '', 'md-plus-circle','','menu'),
                        'EDIT' => array('MODAL', "usermanage/group/update", '1', '', 'md-edit','','list'));
                        //'DELETE' => array('DELETE', "usermanage/execute/delete/group", 'ALL', '', 'md-close-circle','','menu')
        $this->newtable->search(array(array('ID', 'ID')));
        $this->newtable->action(site_url() . "/usermanage/group");
        $this->newtable->hiddens(array(""));
        $this->newtable->keys(array("ID"));
        $this->newtable->multiple_search(true);
        $this->newtable->show_chk(true);
        $this->newtable->show_menu($check);
        $this->newtable->tipe_proses('button');
        $this->newtable->show_search(true);
        $this->newtable->cidb($this->db);
        $this->newtable->orderby(1);
        $this->newtable->sortby('ASC');
        $this->newtable->set_formid("tblgrp");
        $this->newtable->set_divid("divgroup");
        $this->newtable->rowcount(10);
        $this->newtable->clear();
        $this->newtable->menu($proses);
        $tabel .= $this->newtable->generate($SQL);
        $arrdata = array("title" => $title, "page_title" => $page_title, "content" => $tabel);
        if ($this->input->post("ajax") || $act == "post")
            return $tabel;
        else
            return $arrdata;
    }


	public function ambilidparent(){
		$queryspk=$this->db->query("SELECT DISTINCT ID_PARENT FROM reff_menu WHERE ID_PARENT IS NOT NULL ");
		return $queryspk->result_array();
	}

	public function detaildata($data){
		$juml=count($data);
		for ($a=0; $a <$juml ; $a++) {
			$ang=$data[$a]['ID_PARENT'];

			$queryspk=$this->db->query("SELECT * FROM reff_menu WHERE ID_PARENT ='$ang' AND TIPE='M';")->row();
			print_r($queryspk);die();
			// $arr[$a]=$queryspk;
		}
	}




}

?>
