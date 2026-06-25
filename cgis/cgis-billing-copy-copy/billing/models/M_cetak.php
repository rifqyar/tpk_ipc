<?php

class M_cetak extends CI_Model{

	public function __construct(){
		$this->load->database();
	}


	public function get_datacms($nocont){
		$query=$this->db->query("SELECT ID, NO_CONT, NO_TRUCK, DAILYSECNO, OPERATOR, STATUS, WEIGHT, YARDPOST,ISO_CODE,LINE, DATE_FORMAT(WK_TRUCKIN,'%d-%m-%Y %H:%i') AS 'TGL' FROM t_cms WHERE NO_CONT='$nocont' AND WK_TRUCKIN IS NOT NULL")->row_array();
		return $query;
	}


	public function list_cms($act, $id){
		$page_title = 'C M S';
		$title = "C M S";
		$check = (grant()=="W")?true:false;
		$SQL = "SELECT ID, NO_CONT, NO_TRUCK, DAILYSECNO, OPERATOR, STATUS, WEIGHT, YARDPOST,ISO_CODE,WK_TRUCKIN FROM t_cms
				 ";
		$proses = array(
						'CETAK CMS' => array('PRINT',"cetak/cms/print_cms", '1','','md-print','','list')
						);
						/*'UPLOAD' => array('ADD',site_url()."/coarri/discharge/upload", '','','md-attachment'));*/
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu(false);
		$this->newtable->show_search(true);

		$this->newtable->search(array(array('NO_CONT','NO. KONTAINER')));
		$this->newtable->action(site_url() . "/cetak/cms");
		//if($check) $this->newtable->detail(array('GET',site_url()."/planning/".$act."/".$act."_detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("NO_CONT"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("ID");
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblcms");
		$this->newtable->set_divid("divtblcms");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			echo $tabel;
		else
			return $arrdata;
	}

	public function eir($act, $id){
			$page_title = 'E I R';
			$title = "E I R";
			$check = (grant()=="W")?true:false;
			$SQL = "SELECT ID,NO_CONT AS 'NO KONTAINER',ISO_CODE AS 'ISO CODE', NM_KAPAL AS 'VESSEL FULL NAME', NM_EIR AS 'CONTAINER OPERATOR', POD, BRUTO, STATUS FROM t_eir ";

			$proses = array(
							'CETAK EIR' => array('PRINT',"cetak/eir/cetak_eir", '1','','md-print','','list')
							);
							/*'UPLOAD' => array('ADD',site_url()."/coarri/discharge/upload", '','','md-attachment'));*/
			$this->newtable->multiple_search(true);
			$this->newtable->show_chk(false);
			$this->newtable->show_menu($check);
			$this->newtable->show_search(true);
			$this->newtable->search(array(array('NO_CONT','NAMA KONTAINER')));
			$this->newtable->action(site_url() . "/cetak/eir");
			$this->newtable->tipe_proses('button');
			$this->newtable->hiddens(array("ID"));
			$this->newtable->keys(array("NO KONTAINER"));
			$this->newtable->cidb($this->db);
			$this->newtable->orderby("ID");
			$this->newtable->sortby("DESC");
			$this->newtable->set_formid("tblcustomer");
			$this->newtable->set_divid("divcustomer");
			$this->newtable->rowcount(10);
			$this->newtable->clear();
			$this->newtable->menu($proses);
			$tabel .= $this->newtable->generate($SQL);
			$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
			if($this->input->post("ajax")||$act == "post")
				echo $tabel;
			else
				return $arrdata;

			}
	
		public function get_eir($ID)
		{
			$query=$this->db->query("SELECT A.NO_CONT, B.WK_GATEOUT, A.DAMAGE, B.NO_SEAL, C.KONDISI, D.ISO_CODE, E.ID_FLAT, G.NAMA_CUST AS TRUCK_COMPANY, F.NO_TRUCK, F.LINE 
									FROM t_eir A 
									INNER JOIN t_op_delivery B ON B.NO_CONT = A.NO_CONT
									INNER JOIN reff_kondisi C ON B.KONDISI_CONT = C.ID 
									INNER JOIN t_cocostscont D ON D.NO_CONT = A.NO_CONT
									LEFT JOIN t_spk_cont E ON A.NO_CONT = E.NO_CONT
									INNER JOIN t_cms F ON F.NO_CONT = A.NO_CONT
									INNER JOIN t_gatepass G ON G.NO_CONT = A.NO_CONT AND G.JNS_KEGIATAN ='3'
									WHERE A.NO_CONT = '$ID'")->row_array();
			return $query;
		}


//end class
}
