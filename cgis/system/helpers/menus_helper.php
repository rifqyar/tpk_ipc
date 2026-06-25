<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('menu_content')){
	function menu_content(){
		$content = "";
		$data = array();
		$ci =& get_instance();
		$ci->load->database();
		$KD_USER = $ci->session->userdata('ID');
		$KD_GROUP = $ci->session->userdata('KD_GROUP');
		$segs_1 = $ci->uri->segment(1);
		$segs_2 = $ci->uri->segment(2);
		if($segs_2!="") $segs = trim($segs_1."/".$segs_2);
		elseif($segs_1!="") $segs = trim($segs_1);
		if($ci->session->userdata('KD_GROUP')=="SPA"){
			$SQL = "SELECT B.ID, IFNULL(B.ID_PARENT,0) AS ID_PARENT, B.JUDUL_MENU, B.URL, B.URUTAN, B.TIPE, B.TARGET, 
					B.ACTION, B.CLS_ICON AS ICON
					FROM reff_menu B
					WHERE B.ID NOT IN ('16','59','154','163')
					ORDER BY B.ID_PARENT, B.URUTAN ASC"; 
		}else{
			$SQL = "SELECT B.ID, IFNULL(B.ID_PARENT,0) AS ID_PARENT, B.JUDUL_MENU, B.URL, B.URUTAN, B.TIPE, B.TARGET, 
					B.ACTION, B.CLS_ICON AS ICON
					FROM reff_group_menu A 
					INNER JOIN reff_menu B ON A.KD_MENU = B.ID
					WHERE B.ID NOT IN ('16','59','154') AND A.KD_GROUP = ".$ci->db->escape($KD_GROUP)."  
					ORDER BY B.ID_PARENT, B.URUTAN ASC"; 	
		}
		$result = $ci->db->query($SQL);
		if($result->num_rows() > 0){
			/*$SQLJob = "SELECT COUNT(ID_JOB_SLIP) AS TOTAL 
					   FROM t_job_slip 
					   WHERE STATUS='WAITING' 							
					   AND LOKASI_AKHIR IS NULL 
					   AND NO_SPK IS NOT NULL 
					   AND JNS_JOB_SLIP IS NOT NULL";*/
			$SQLJob = "SELECT COUNT(A.ID_JOB_SLIP) AS TOTAL
			FROM t_job_slip A
			WHERE A.STATUS='WAITING' AND A.LOKASI_AKHIR IS NULL AND A.NO_SPK IS NOT NULL AND A.JNS_JOB_SLIP IS NOT NULL";
			$resultJob = $ci->db->query($SQLJob);
			$countJob = $resultJob->row();

			$SQLJob1 ="SELECT COUNT(A.ID ) AS TOTAL1
			FROM list_dokumens A
			WHERE DATE(A.TGL_DOK ) >= DATE_ADD(NOW(), interval - 2 MONTH) AND A.FL_STATUS='N' ";

			$resultJob1 = $ci->db->query($SQLJob1);
			$countJob1 = $resultJob1->row();


			$SQLJob2 ="SELECT COUNT(A.ID ) AS TOTAL2
			FROM behandle2s A
			WHERE DATE(A.TGL_DOK ) >= DATE_ADD(NOW(), interval - 2 MONTH) AND A.FL_STATUS='N' ";

			$resultJob2= $ci->db->query($SQLJob2);
			$countJob2 = $resultJob2->row();

	
			
			foreach($result->result_array() as $row){
				if($row['ID_PARENT'] == "")
					$parent_id = 0;
				else
					$parent_id = $row['ID_PARENT'];
				$data[$parent_id][] = array("ID" => $row['ID'],
											"ID_PARENT"	 => $row['ID_PARENT'],
											"JUDUL_MENU" => $row['JUDUL_MENU'],
											"URL"	 	 => $row['URL'],
											"URUTAN" 	 => $row['URUTAN'],	
											"TIPE"	 	 => $row['TIPE'],
											"TARGET"	 => $row['TARGET'],
											"ACTION"	 => $row['ACTION'],
											"ICON"	 	 => $row['ICON'],
											"TOTALJOB"	 => $countJob->TOTAL,
											"TOTALJOB1"  => $countJob1->TOTAL1,
											"TOTALJOB2"  => $countJob2->TOTAL2
											);	
			}
			$content .= get_menu($data,$segs,$parent=0);
		}else{
			$content = "";
		}
		return $content;
	}
}

if(!function_exists('get_menu')){
	function get_menu($data=array(),$segs,&$parent){
		$ci =& get_instance();
		$ci->load->database();
		static $i = 1;
		$tab = str_repeat("\t\t", $i);
		if ($data[$parent]){
			$html = '';
			if ($parent==0){
				$html = "\n$tab<ul class=\"site-menu\"><li class='site-menu-category'>MENU</li>";
			}else{
				$html = "\n$tab<ul class=\"site-menu-sub\">";
			}
			$i++;
			for ($c = 0; $c < count($data[$parent]); $c++) {
				$child = get_menu($data, $segs, $data[$parent][$c]['ID']);
				if ($data[$parent][$c]["TIPE"] == "F"){
					$href = 'javascript:void(0)';
					$class = 'site-menu-item has-sub';
					$arrow = "<span class='site-menu-arrow'></span>";
					$ID_PARENT = array();
					$ID_PARENT = get_active('PARENT',$segs);
					if(in_array($data[$parent][$c]["ID"], $ID_PARENT)){
						$active = 'active open';
					}else{
						$active = '';
					}
				}else{
					$href = site_url($data[$parent][$c]["URL"]);
					$class = 'site-menu-item';
					$arrow = "";
					$ID = get_active('ID',$segs);
					if($ID == $data[$parent][$c]["ID"]){
						$active = 'active';
					}else{
						$active = '';
					}
				}
				$data[$parent][$c]["ICON"] = $data[$parent][$c]["ICON"] == "" ? "":$data[$parent][$c]["ICON"];
				if ($data[$parent][$c]["ID"] == '11') {
					$totaljob = '&nbsp;&nbsp;&nbsp;<span class="label label-primary">'.$data[$parent][$c]["TOTALJOB"].'</span>';
				}else if ($data[$parent][$c]["ID"] == '152') {
					$totaljob = '&nbsp;&nbsp;<span class="label label-primary">'.$data[$parent][$c]["TOTALJOB1"].'</span>';
				}else if ($data[$parent][$c]["ID"] == '153') {
					$totaljob = '&nbsp;&nbsp;<span class="label label-primary">'.$data[$parent][$c]["TOTALJOB2"].'</span>';
				}else{
					$totaljob = '';
				}

				if($data[$parent][$c]["JUDUL_MENU"] == 'Gate Pass SPJM'){
					$html .= '<li class="'.$class.' '.$active.'" >
								<a href="'.$href.'" class="animsition-link" style="color: red;" >
									<i class="site-menu-icon '.$data[$parent][$c]["ICON"].'" aria-hidden="true"></i>
									<span class="site-menu-title">'.$data[$parent][$c]["JUDUL_MENU"].$totaljob.'</span>
									'.$arrow.'
								</a>';
				}else if($data[$parent][$c]["JUDUL_MENU"] == 'Gate Pass SPPMP'){
				$html .= '<li class="'.$class.' '.$active.'" >
							<a href="'.$href.'" class="animsition-link" style="color: #228B22;" >
								<i class="site-menu-icon '.$data[$parent][$c]["ICON"].'" aria-hidden="true"></i>
								<span class="site-menu-title">'.$data[$parent][$c]["JUDUL_MENU"].$totaljob.'</span>
								'.$arrow.'
							</a>';
				}else if($data[$parent][$c]["JUDUL_MENU"] == 'Gate Pass JOIN INSP'){
					$html .= '<li class="'.$class.' '.$active.'" >
								<a href="'.$href.'" class="animsition-link" style="color: #FF0000;" >
									<i class="site-menu-icon '.$data[$parent][$c]["ICON"].'" aria-hidden="true"></i>
									<span class="site-menu-title">'.$data[$parent][$c]["JUDUL_MENU"].$totaljob.'</span>
									'.$arrow.'
								</a>';
				}else if($data[$parent][$c]["JUDUL_MENU"] == 'Req Layanan Online'){
					$html .= '<li class="'.$class.' '.$active.'" >
								<a href="'.$href.'" class="animsition-link" style="color: blue;" >
									<i class="site-menu-icon '.$data[$parent][$c]["ICON"].'" aria-hidden="true"></i>
									<span class="site-menu-title">'.$data[$parent][$c]["JUDUL_MENU"].$totaljob.'</span>
									'.$arrow.'
								</a>';
				}else if($data[$parent][$c]["JUDUL_MENU"] == 'Req Layanan Online 2'){
					$html .= '<li class="'.$class.' '.$active.'" >
								<a href="'.$href.'" class="animsition-link" style="color: green;" >
									<i class="site-menu-icon '.$data[$parent][$c]["ICON"].'" aria-hidden="true"></i>
									<span class="site-menu-title">'.$data[$parent][$c]["JUDUL_MENU"].$totaljob.'</span>
									'.$arrow.'
								</a>';
				}else if($data[$parent][$c]["JUDUL_MENU"] == 'History Layanan Online'){
					$html .= '<li class="'.$class.' '.$active.'" >
								<a href="'.$href.'" class="animsition-link" style="color: blue;" >
									<i class="site-menu-icon '.$data[$parent][$c]["ICON"].'" aria-hidden="true"></i>
									<span class="site-menu-title">'.$data[$parent][$c]["JUDUL_MENU"].$totaljob.'</span>
									'.$arrow.'
								</a>';
				}else{
				$html .= '<li class="'.$class.' '.$active.'">
							<a href="'.$href.'" class="animsition-link">
								<i class="site-menu-icon '.$data[$parent][$c]["ICON"].'" aria-hidden="true"></i>
								<span class="site-menu-title">'.$data[$parent][$c]["JUDUL_MENU"].$totaljob.'</span>
								'.$arrow.'
							</a>';
				
				}

				if ($child){
					$i--;
					$html .= $child;
					$html .= "\n\t$tab";
				}
				$html .= '</li>';
			}
			$html .= "\n$tab</ul>";
			return $html;
		} else {
			$html = "";
			return false;
		}
	}
}

if(!function_exists('get_active')){
	function get_active($type,$segs){
		$ci =& get_instance();
		$ci->load->database();
		$arrdata = array();
		switch($type){
			case 'ID'	  :
				$SQL = "SELECT IFNULL(ID,0) AS ID 
						FROM reff_menu WHERE UPPER(URL) = ".$ci->db->escape($segs);
				$result = $ci->db->query($SQL);
				$arrdata = $result->row()->ID;
			break;
			case 'PARENT' :
				$SQL = "SELECT IFNULL(ID,0) AS ID 
						FROM reff_menu WHERE UPPER(URL) = ".$ci->db->escape($segs);
				$result = $ci->db->query($SQL);
				$ID = $result->row()->ID;
				if($ID!=0){
					$QUERY = "SELECT func_active('".$ID."') AS active";
					$exec = $ci->db->query($QUERY);
					$ID_PARENT = $exec->row()->active;
					if($ID_PARENT!=""){
						$arrdata = explode(',',$ID_PARENT);
					}
				}
			break;
		}
		return $arrdata;
	}
}
