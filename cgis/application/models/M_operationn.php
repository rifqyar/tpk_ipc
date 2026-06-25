<?php

class M_operationn extends CI_Model{

	public function __construct(){
		$this->load->database();
	}

	public function index(){
		$headers  = '<link rel="apple-touch-icon" href="'.base_url().'assets/images/apple-touch-icon.png">';
		$headers .= '<link rel="shortcut icon" href="'.base_url().'assets/images/favicon.ico">';
		#Stylesheets
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/bootstrap.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/bootstrap-extend.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/site.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/slide-unlock.css">';
        #Plugins
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/animsition/animsition.min.css?v2.1.0">';
       	$headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/asscrollable/asScrollable.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/switchery/switchery.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/intro-js/introjs.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/slidepanel/slidePanel.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/flag-icon-css/flag-icon.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/waves/waves.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/sweetalert/sweetalert.css">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/themes/twitter.css">';
      	#Page
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/pages/login.min.css?v2.1.0">';
        #Fonts
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/fonts/material-design/material-design.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/fonts/brand-icons/brand-icons.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/fonts/font.css?v2.1.0">';
        #Scripts
        $headers .= '<script src="'.base_url().'assets/vendor/modernizr/modernizr.min.js"></script>';
        $headers .= '<script src="'.base_url().'assets/vendor/breakpoints/breakpoints.min.js"></script>';
        $headers .= '<script>Breakpoints();</script>';
		#Core
		$footers  = '<script src="'.base_url().'assets/vendor/jquery/jquery.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/vendor/bootstrap/bootstrap.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/vendor/animsition/animsition.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/vendor/asscroll/jquery-asScroll.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/vendor/mousewheel/jquery.mousewheel.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/vendor/asscrollable/jquery.asScrollable.all.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/vendor/ashoverscroll/jquery-asHoverScroll.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/vendor/waves/waves.min.js"></script>';
		#Plugins
		$footers .= '<script src="'.base_url().'assets/vendor/switchery/switchery.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/vendor/intro-js/intro.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/vendor/screenfull/screenfull.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/vendor/slidepanel/jquery-slidePanel.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/vendor/alertify-js/alertify.js"></script>';
		#Plugins For This Page
		$footers .= '<script src="'.base_url().'assets/vendor/jquery-placeholder/jquery.placeholder.min.js"></script>';
		#Scripts
		$footers .= '<script src="'.base_url().'assets/js/core.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/js/site.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/sections/menu.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/sections/menubar.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/sections/gridmenu.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/sections/sidebar.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/js/configs/config-colors.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/configs/config-tour.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/components/asscrollable.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/components/animsition.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/components/slidepanel.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/components/switchery.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/components/tabs.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/components/jquery-placeholder.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/components/material.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/vendor/sweetalert/sweetalert.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/js/main.js"></script>';
		$footers .= '<script src="'.base_url().'assets/js/jquery.slideunlock.js"></script>';
		/*if($this->session->userdata('LOGGED')){
			redirect(base_url().'application.php');
		}else{*/
			if($this->content==""){
				$this->content = $this->load->view('content/dashboard/index','',true);
			}
			$data = array('_title_' => 'BOS',
						  '_headers_' => $headers,
						  '_footers_' => $footers,
						  '_content_' => $this->content);
			$this->parser->parse('index', $data);
		//}

	}

	public function cek_tspk($par){//mencocokan inputan dengan no spk di t_spk
		$queryspk=$this->db->get_where('t_spk', array('NO_SPK' => $par));
		return $queryspk->row_array();
	}

	public function cek_tspkcont($par){//mencocokan inputan dengan NO cont di t_spk_cont
		$queryspk=$this->db->get_where('t_spk_cont', array('NO_CONT' => $par,'STATUS_CONT'=>'200'));
		return $queryspk->row_array();
	}

	public function cek_tspkcontst($par){//mencocokan inputan dengan NO cont di t_spk_cont
		$queryspk=$this->db->get_where('t_spk_cont', array('NO_CONT' => $par, 'STATUS_CONT'=>'460'));
		return $queryspk->row_array();
	}
	
	public function cek_tspkcontst2($par){//mencocokan inputan dengan NO cont di t_spk_cont
		$queryspk=$this->db->query("select * from t_spk_cont where NO_CONT='$par' AND STATUS_CONT IN (450,800,850,870)");
		return $queryspk->row_array();
	}

	public function cek_tspkcontid($parid){//mencocokan inputan dengan NO cont di t_spk_cont
		$queryspk=$this->db->get_where('t_spk_cont', array('ID' => $parid));
		return $queryspk->row_array();
	}
	
	public function cek_alltspkcont($parid){//mencocokan inputan dengan NO cont di t_spk_cont
		$queryspk=$this->db->get_where('t_spk_cont', array('ID' => $parid));
		return $queryspk->result_array();
	}

	public function cek_tspk2($parid){//mencocokan inputan dengan id di t_spk
		$queryspk=$this->db->get_where('t_spk', array('ID' => $parid));
		return $queryspk->row_array();
	}

	public function cek_tspk3($parid, $parid2){//mencocokan inputan dengan id di t_spk
		$queryspk=$this->db->query("SELECT distinct a.* from t_spk a JOIN t_spk_cont b ON a.ID = b.ID WHERE a.NO_SPK = '$parid' AND b.STATUS_CONT IN (000,100,300)");
		return $queryspk->row_array();
	}


	public function cek_tspk4($parid, $parid2){//mencocokan inputan dengan id di t_op_reefer
		$queryspk=$this->db->query("SELECT distinct a.*, b.STATUS_CONT as STATUS_CONT from t_op_reefer a left join 
		(select ts.NO_SPK, tsc.NO_CONT, tsc.STATUS_CONT from t_spk_cont tsc join t_spk ts on tsc.ID = ts.ID ) b on b.NO_SPK = a.NO_SPK and b.NO_CONT = a.NO_CONT WHERE a.NO_SPK = '$parid' and a.WAKTU is not null and a.WAKTU_END is not null and a.FL_UNPLUG in ('Y','N') and b.STATUS_CONT not in (100,200,900,950)");
		return $queryspk->row_array();
	}
	
	public function ambilspk(){//mengambil data di behandlein untuk menghitung jumlah NO spk yg sama
		$queryspk=$this->db->get('t_op_behandlein');
		return $queryspk->result_array();
	}
	
	public function ambiljumspk($id){//mengambil data di behandlein untuk menghitung jumlah NO spk yg sama
		$queryspk=$this->db->get_where('t_spk_cont', array('STATUS_CONT'=>'200','ID'=>$id));
		return $queryspk->result_array();
	}
	
	public function ambiljumspkreal($id){//mengambil data di behandlein untuk menghitung jumlah NO spk yg sama
		$queryspk=$this->db->query("select * from t_spk_cont where ID='$id' AND STATUS_CONT IN ('460')");
		return $queryspk->result_array();
	}

	public function after_pickup($par,$par2,$par3,$par4){//mengubah KD_STATUS menjadi 200 yaitu status sudah pick up
		
		$arrdata = array(
				'KD_STATUS' => '200'
			);

		for ($i=0; $i < count($par4); $i++) { 
			$idnya=$par2['ID'];
			$connn=$par4[$i]['NO_CONT'];
			$flat=$par3[$i];
			if ($par2['STATUS_CONT']=='000' || $par2['STATUS_CONT']=='300' ) {
				$arrdata2 = array(
					'STATUS_CONT' => '200',
					'ID_FLAT' => $flat
				);
				$this->db->where(array('ID'=>$idnya,'NO_CONT'=>$connn));
				$this->db->update('t_spk_cont',$arrdata2);
			}	
			
			$this->updatejobslipstatus("30",$par,$par4[$i]['NO_CONT']);
		}

		$this->db->where('NO_SPK', $par );
		return $this->db->update('t_spk', $arrdata);
	}
	
	public function updatejobslipstatus($kodenya,$nomerspknya,$nomerkontainer){
			$this->db->where(array('NO_SPK' => $nomerspknya, 'NO_CONT' => $nomerkontainer ));
			$this->db->update('t_job_slip', array('KD_STATUS' => $kodenya, 'STATUS' => 'WAITING'));
	}
	
	// PERUBAHAN TGL 2 JULI 2018
	public function updatejobslipstatus2($kodenya,$idjobslip){
			$this->db->where('ID_JOB_SLIP', $idjobslip );
			$this->db->update('t_job_slip', array('KD_STATUS' => $kodenya, 'STATUS' => 'DONE'));
	}

	public function after_hold($par,$par2){//mengubah KD_STATUS menjadi 300 yaitu status sudah pick up
		$arrdata = array(
				'KD_STATUS' => '300'
			);
		if ($par2['STATUS_CONT']==200  ) {
			$arrdata2 = array(
				'STATUS_CONT' => '300'
			);
			$this->db->where('ID', $par2['ID'] );
			$this->db->update('t_spk_cont', $arrdata2);
		}

		$this->db->where('NO_SPK', $par );
		return $this->db->update('t_spk', $arrdata);
	}

	public function after_inspection($par,$parc,$pars,$seal,$lok,$iso,$tid,$skc){
		if ($seal==NULL) {
			$arrdata = array(
					'ISO_CODE' => $iso,
					'STATUS_CONT_COARI' => $skc,
					'ID_FLAT' => $tid
				);
		}else {
			$arrdata = array(
					'ISO_CODE' => $iso,
					'ID_FLAT' => $tid,
					'STATUS_CONT_COARI' => $skc,
					'NO_SEAL'=> $seal
				);
		}
		$keyy= array(
			'NO_CONT' => $par,
			'ID' => $pars
		);
		if ($parc==1) {
			$arrdata2 = array(
				'KD_STATUS' => '400'
			);
			$this->db->where('ID', $pars );
			$this->db->update('t_spk', $arrdata2);
		}
			
		$this->db->where($keyy);
		return $this->db->update('t_spk_cont', $arrdata);
	}

	public function after_realisasi($par,$parc,$pars,$seal){//mengubah KD_STATUS menjadi 300 yaitu status sudah pick up
		$arrdata = array(
				'STATUS_CONT' => '500',
				'NO_SEAL'=>$seal
			);

			if ($parc==1  ) {
				$arrdata2 = array(
					'KD_STATUS' => '500'
				);
				$this->db->where('ID', $pars );
				$this->db->update('t_spk', $arrdata2);
			}
		$this->db->where('NO_CONT', $par );
		return $this->db->update('t_spk_cont', $arrdata);
	}

	public function after_marshalling($par,$par2,$par3){
		$arrdata = array(
				'ROOM' => $par2,
				'LOKASI' => $par3
			);
		$this->db->where('NO_CONT', $par );
		return $this->db->update('t_spk_cont', $arrdata);
	}

	public function statusnya($inp){
		$queryspk=$this->db->query("select * from t_op_inspection where NO_CONT='$inp' AND STATUS='WAITING'");
		return $queryspk->row_array();
	}

	public function pickoper($a,$spk,$jd,$nd,$td){
		for ($i=0; $i <count($a) ; $i++) { 

			$dsimpan= array(
				'NO_SPK' => $spk,
				'NO_CONT' => $a[$i]['NO_CONT'],
				'JNS_DOK' => $jd,
				'NO_DOK' => $nd,
				'TGL_DOK' => $td,
				'WK_PICKUP' => date('Y-m-d H:i:s')
			     ); 
			$this->db->insert('t_operation',$dsimpan);
		}
	}

	public function set_pickup(){
		$NO_SPK = $this->input->post('nomerspk');

		$SQL_SPK_CONT = $this->db->query("SELECT A.*, B.* FROM t_spk A INNER JOIN t_spk_cont B ON A.ID = B.ID WHERE A.NO_SPK='".$NO_SPK."'")->result_array();

		if ($SQL_SPK_CONT[0]['NO_SPK'] == $NO_SPK) {
			$STATUS_CONT = 0;
			for ($i=0; $i < count($SQL_SPK_CONT); $i++) {
				/* UNTUK COMBOBOX ID_FLAT */
				$idflat = "idflat".$i; 
				$ARR_ID_FLAT = $this->input->post($idflat);
				$ID_FLAT[$i] = $ARR_ID_FLAT;
				/* CEK KONDISI STATUS CONTAINER*/
				if ($SQL_SPK_CONT[$i]['STATUS_CONT'] == '900') {
					$STATUS_CONT ++;
				}
			}
			if ($STATUS_CONT == 0) {
				if($SQL_SPK_CONT[0]['STATUS_CONT'] == '100'){
					/* UPDATE SPK */
					$this->db->where(array('NO_SPK' => $NO_SPK));
					$this->db->update('t_spk', array('KD_STATUS' => '200'));

					$pickup = array(
						'OPERATOR' => $this->session->userdata('USERLOGIN'), 
						'NO_SPK' => $NO_SPK,
						'JNS_PICK' => 'S',
						'W_PICKUP' => date('Y-m-d H:i:s')
					);
					$this->db->insert('t_op_pickup',$pickup);

					/* UPDATE SPK CONTAINER */
					for ($c=0; $c < count($SQL_SPK_CONT); $c++) {
						$this->db->where(array('ID' => $SQL_SPK_CONT[$c]['ID'], 'NO_CONT' => $SQL_SPK_CONT[$c]['NO_CONT']));
						$this->db->update('t_spk_cont', array('STATUS_CONT' => '200', 'ID_FLAT' => $ID_FLAT[$c]));
						
						/* UPDATE JOBSLIP */
						$this->db->where(array('NO_SPK' => $NO_SPK, 'NO_CONT' => $SQL_SPK_CONT[$c]['NO_CONT']));
						$this->db->update('t_job_slip', array('KD_STATUS' => '30','STATUS' => 'WAITING' ));

						/* INSERT TO OPERATION */
						$operation = array(
							'NO_SPK' => $NO_SPK,
							'NO_CONT' => $SQL_SPK_CONT[$c]['NO_CONT'],
							'JNS_DOK' => $SQL_SPK_CONT[$c]['JNS_DOK'],
							'NO_DOK' => $SQL_SPK_CONT[$c]['NO_DOK'],
							'TGL_DOK' => $SQL_SPK_CONT[$c]['TGL_DOK'],
							'WK_PICKUP' => date('Y-m-d H:i:s')
						     ); 
						$this->db->insert('t_operation', $operation);

						$SQLReport = $this->db->query("SELECT * FROM report_behandle WHERE NO_CONT='".$SQL_SPK_CONT[$c]['NO_CONT']."' AND REQ_NO_DOK='".$SQL_SPK_CONT[$c]['NO_DOK']."' AND RB1_NO_SPK = '".$SQL_SPK_CONT[$c]['NO_SPK']."' ORDER BY ID DESC")->result_array();
						if (count($SQLReport) > 0) {
							$updateReport = array(
								'NO_CONT' 		=> $SQL_SPK_CONT[$c]['NO_CONT'],
								'PRN_PICKUP' 	=> date('Y-m-d H:i:s'),
								'PRN_TID' 		=> $ID_FLAT[$c]							
							);
							$this->db->where(array('ID' => $SQLReport[0]['ID'], 'NO_CONT' => $SQL_SPK_CONT[$c]['NO_CONT']));
							$this->db->update('report_behandle', $updateReport);
						}
					}
					$data['notif']=1;
					$data['NOSPK']=$NO_SPK;
					$this->content = $this->load->view('content/dashboard/pickup',$data,true);
					$this->index();
				}else if($SQL_SPK_CONT[0]['STATUS_CONT'] == '300'){
					/* UPDATE SPK */
					$this->db->where(array('NO_SPK' => $NO_SPK));
					$this->db->update('t_spk', array('KD_STATUS' => '200'));

					$pickup = array(
						'OPERATOR' => $this->session->userdata('USERLOGIN'), 
						'NO_SPK' => $NO_SPK,
						'JNS_PICK' => 'S',
						'W_PICKUP' => date('Y-m-d H:i:s')
					);
					$this->db->insert('t_op_pickup',$pickup);

					/* UPDATE SPK CONTAINER */
					for ($c=0; $c < count($SQL_SPK_CONT); $c++) {
						$this->db->where(array('ID' => $SQL_SPK_CONT[$c]['ID'], 'NO_CONT' => $SQL_SPK_CONT[$c]['NO_CONT']));
						$this->db->update('t_spk_cont', array('STATUS_CONT' => '200', 'ID_FLAT' => $ID_FLAT));
						
						/* UPDATE JOBSLIP */
						$this->db->where(array('NO_SPK' => $NO_SPK, 'NO_CONT' => $SQL_SPK_CONT[$c]['NO_CONT']));
						$this->db->update('t_job_slip', array('KD_STATUS' => '30','STATUS' => 'WAITING' ));
					}
					$data['notif']=1;
					$data['NOSPK']=$NO_SPK;
					$this->content = $this->load->view('content/dashboard/pickup',$data,true);
					$this->index();
				}else if($SQL_SPK_CONT[0]['STATUS_CONT'] == '000'){
					$data['notif'] = 3;
					$data['NOSPK'] = $NO_SPK;
					$this->content = $this->load->view('content/dashboard/pickup',$data,true);
					$this->index();
				}else{
					$data['notif'] = 2;
					$data['NOSPK'] = $NO_SPK;
					$this->content = $this->load->view('content/dashboard/pickup',$data,true);
					$this->index();
				}
			}else{
				$data['notif'] = 4;
				$data['NOSPK'] = $NO_SPK;
				$this->content = $this->load->view('content/dashboard/pickup',$data,true);
				$this->index();
			}

		}else{
			$data['notif'] = 2;
			$data['NOSPK'] = $NO_SPK;
			$this->content = $this->load->view('content/dashboard/pickup',$data,true);
			$this->index();
		}
	}

	public function set_pickup_old(){
		$this->load->helper('url');
		$inputan = $this->input->post('nomerspk');
		$query=$this->cek_tspk($inputan);
		$query2=$this->cek_tspkcontid($query['ID']);
		$que=$this->cek_alltspkcont($query['ID']);
		$jenisdokumen=$query['JNS_DOK'];
		$nomerdokumen=$query['NO_DOK'];
		$tanggaldokumen=$query['TGL_DOK'];

		//
		$re  =   $this->M_operationn->cek_tspk3($inputan);
		$spk= $this->M_operationn->searchco($re['ID']);

		for ($i=0; $i < count($spk) ; $i++) {
			$da="kon".$i; 
			$asem = $this->input->post($da);
			$arr[$i]=$asem;
		}
		
		$filterkontainer=0;
		for ($a=0; $a < count($que) ; $a++) {
			if($que[$a]['STATUS_CONT']=='900'){
				$filterkontainer=1;
			}
		}

		//print_r($arr); die();
	
			$dsimpan= array(
				'OPERATOR' => $this->session->userdata('USERLOGIN'), 
				'NO_SPK' => $inputan,
				'JNS_PICK' => 'S',
				'W_PICKUP' => date('Y-m-d H:i:s')
			);
			$dsimpan2= array(
				'NO_SPK' => $inputan,
				'OPERATOR' => $this->session->userdata('USERLOGIN'), 
				'JNS_PICK' => 'H',
				'W_PICKUP' => date('Y-m-d H:i:s')
			);
		if ($query['NO_SPK'] == $inputan) {
			if($filterkontainer==1){
				$data['notif']=4;
				$data['NOSPK']=$inputan;
				$this->content = $this->load->view('content/dashboard/pickup',$data,true);
				$this->index();
			}else{
				if ($query['KD_STATUS']=='100') {
					$this->after_pickup($inputan,$query2,$arr,$spk);
					$this->db->insert('t_op_pickup',$dsimpan);
					$this->pickoper($que,$inputan,$jenisdokumen,$nomerdokumen,$tanggaldokumen);
					$data['notif']=1;
					$data['NOSPK']=$inputan;
					$this->content = $this->load->view('content/dashboard/pickup',$data,true);
					$this->index();
				}elseif ($query['KD_STATUS']=='300') {
					$this->after_pickup($inputan,$query2,$arr,$spk);
					$this->db->insert('t_op_pickup',$dsimpan2);
					$data['notif']=1;
					$data['NOSPK']=$inputan;
					$this->content = $this->load->view('content/dashboard/pickup',$data,true);
					$this->index();
				}else {
					$data['notif']=2;
					$data['NOSPK']=$inputan;
					$this->content = $this->load->view('content/dashboard/pickup',$data,true);
					$this->index();
				}// return $this->db->insert('t_op_pickup',$dsimpan);
			}
		}else {
			//butuh alert ipk tidak terdaftar di t_spk
			$data['notif']=3;
			$data['NOSPK']=$inputan;
			$this->content = $this->load->view('content/dashboard/pickup',$data,true);
			$this->index();
		}
	}
	
	public function set_hold(){
				$this->load->helper('url');
				$ss=date('y');	
				$inputan = "ITPK-".$ss."/".$this->input->post('nomerspk');
				$query=$this->cek_tspk($inputan);
				$query2=$this->cek_tspkcontid($query['ID']);
					$dsimpan= array(
						'NO_SPK' => $inputan,
						'OPERATOR' => $this->session->userdata('USERLOGIN'),
						'W_HOLD' => date('Y-m-d H:i:s')
					);

				if ($query['NO_SPK'] == $inputan) {
					if ($query['KD_STATUS']=='200') {
						$this->after_hold($inputan,$query2);
						$this->db->insert('t_op_hold',$dsimpan);
						$data['notif']=1;
						$data['NOSPK']=$inputan;
						$this->content = $this->load->view('content/dashboard/hold',$data,true);
						$this->index();
					}elseif ($query['KD_STATUS']=='300') {
						$data['notif']=2;
						$data['NOSPK']=$inputan;
						$this->content = $this->load->view('content/dashboard/hold',$data,true);
						$this->index();
					}else {
						$data['notif']=3;
						$data['NOSPK']=$inputan;
						$this->content = $this->load->view('content/dashboard/hold',$data,true);
						$this->index();
					}
				}else {
					$data['notif']=4;
					$data['NOSPK']=$inputan;
					$this->content = $this->load->view('content/dashboard/hold',$data,true);
					$this->index();
				}
	}
		
	public function cek_notgl_gatepass($nomer,$tanggal,$lokasi){
		if($nomer == NULL && $tanggal == NULL){
			if(substr($lokasi,0,3)=="CIC" || substr($lokasi,0,3)=="cic" ){
				return $notifikasi=1;
			}else{
				return $notifikasi=2;
			}
		}else{
			if(substr($lokasi,0,3)=="CIC" ||substr($lokasi,0,3)=="cic" ){
				return $notifikasi=2;
			}else{
				return $notifikasi=3;
			}
		}
	}

	public function set_inspection(){
		$noCont 	= $this->input->post('nomerkon');
		$isoCode 	= $this->input->post('isocode');
		$noSeal 	= $this->input->post('noseal');
		$lokasi 	= $this->input->post('nolok');
		$noTid		= $this->input->post('trucknya');
		$stakoncoar	= $this->input->post('optradiostatus');
		$TrukIn 	= $this->input->post('kondisi');
		$konSeal 	= $this->input->post('optradio');
		$cekJumlah  = strlen($lokasi);
		
		if ($cekJumlah > 8) {
			$nmBlok = strtoupper(substr($lokasi,0,7));
			$nmTier = strtoupper(substr($lokasi,-1));
		}else{
			$nmBlok = strtoupper(substr($lokasi,0,6));
			$nmTier = strtoupper(substr($lokasi,-1));
		}

		$SQL_SPK	= $this->db->query("SELECT A.*, B.* FROM t_spk_cont A INNER JOIN t_spk B ON A.ID = B.ID WHERE A.NO_CONT ='".$noCont."' AND A.STATUS_CONT ='200' ORDER BY A.ID DESC LIMIT 1")->row_array();

		$SQL_DENAH 	= $this->db->query("SELECT CONCAT(NM_BLOK,'0',LEVEL_4) AS 'DENAH' FROM t_denah_lapangan WHERE NM_BLOK = '".$nmBlok."' AND LEVEL_4 = '".$nmTier."' ")->row_array();

		$SQL_SPK_LOK = $this->db->query("SELECT NO_CONT, CONCAT(LOKASI,'0',TIER) AS 'LOKASI',STATUS_CONT FROM t_spk_cont where LOKASI = '".$nmBlok."' AND TIER = '".$nmTier."' AND STATUS_CONT IN('450','460','510','530')")->row_array();

		if($SQL_SPK['STATUS_CONT'] == '200'){
			if(substr($lokasi,0,2)=="1B" || substr($lokasi,0,2)=="1b" || substr($lokasi,0,2)=="YB"){
				if($SQL_SPK_LOK['LOKASI'] != $lokasi){
					if ($SQL_DENAH['DENAH'] == $lokasi) {
						/* INSERT TO OP BEHANDLE IN */
						$dataBin = array(
							'NO_SPK' 		=> $SQL_SPK['NO_SPK'],
							'OPERATOR' 		=> $this->session->userdata('USERLOGIN'),
							'NO_CONT' 		=> $noCont,
							'KONDISI_CONT' 	=> $TrukIn,
							'KONDISI_SEAL' 	=> $konSeal,
							'NO_SEAL' 		=> $noSeal,
							'ROOM'			=> $lokasi,
							'ISO_CODE' 		=> $isoCode,
							'W_BEHANDLE' 	=> date('Y-m-d H:i:s'),
						);
						$this->db->insert('t_op_behandlein',$dataBin);
						/* AFTER INSPECTION */
						$dataAfInspection = array(
							'ISO_CODE' 			=> $isoCode,
							'ID_FLAT' 			=> $noTid,
							'LOKASI' 			=> $nmBlok,
							'TIER' 				=> $nmTier,
							'STATUS_CONT_COARI' => $stakoncoar,
							'STATUS_CONT' 		=> '450',
							'NO_SEAL'			=> $noSeal
						);
						$this->db->where(array('NO_CONT' => $noCont, 'ID' => $SQL_SPK['ID']));
						$this->db->update('t_spk_cont', $dataAfInspection);

						$this->db->where(array('ID' => $SQL_SPK['ID'], 'NO_SPK' => $SQL_SPK['NO_SPK']));
						$this->db->update('t_spk', array('KD_STATUS' => '400'));

						$this->db->where(array('NO_CONT' => $noCont, 'NO_SPK' => $SQL_SPK['NO_SPK']));
						$this->db->update('t_operation', array('WK_IN' => date('Y-m-d H:i:s')));

						/* CEK GATEPASS */
						$SQL_GATEPASS = $this->db->query("SELECT * FROM t_gatepass WHERE NO_CONT = '".$noCont."' AND NO_DOK = '".$SQL_SPK['NO_DOK']."' AND STATUS = 'WAITING' AND JNS_KEGIATAN ='1' ORDER BY ID DESC LIMIT 1")->result_array();
						
						/* UPDATE JOB SLIP STATUS DONE */
						$cekJobSlip = $this->db->query("SELECT * FROM t_job_slip WHERE NO_SPK = '".$SQL_SPK['NO_SPK']."' AND NO_CONT = '".$noCont."' AND NO_DOK = '".$SQL_SPK['NO_DOK']."' AND STATUS = 'WAITING' ORDER BY ID_JOB_SLIP DESC LIMIT 1")->row_array();

						$this->db->where(array('NO_CONT' => $noCont, 'NO_SPK' => $SQL_SPK['NO_SPK'], 'NO_DOK' => $SQL_SPK['NO_DOK'], 'ID_JOB_SLIP' => $cekJobSlip['ID_JOB_SLIP']));
						$this->db->update('t_job_slip', array('NO_DOK' => $SQL_SPK['NO_DOK'], 'NO_GATEPASS' => $SQL_GATEPASS[0]['ID'], 'TGL_GATEPASS' => $SQL_GATEPASS[0]['WK_REK'], 'STATUS' => 'DONE',  'KD_STATUS' => '50', 'WK_STATUS' => date('Y-m-d H:i:s'), 'OPERATOR' => $this->session->userdata('USERLOGIN'), 'STATUS_JOB' => 'Y'));

						if(count($SQL_GATEPASS) > 0){
							$arrdata = array(
								'OPERATOR' 		=> $this->session->userdata('USERLOGIN'),
								'NO_SPK'		=> $SQL_SPK['NO_SPK'],
								'TGL_SPK'		=> $SQL_SPK['TGL_SPK'],
								'NO_CONT' 		=> $noCont,
								'NO_DOK'		=> $SQL_GATEPASS[0]['NO_DOK'],
								'JNS_DOK'		=> $SQL_GATEPASS[0]['JNS_DOK'],
								'NO_GATEPASS'	=> $SQL_GATEPASS[0]['ID'],
								'LOKASI_AWAL'	=> $nmBlok,
								'JNS_JOB_SLIP'	=> 'MARSHALLING',
								'JENIS'			=> 'BEHANDLE 1',
								'TIER_AWAL'		=> $nmTier,
								'TGL_GATEPASS'	=> $SQL_GATEPASS[0]['WK_REK'],
								'KD_STATUS'		=> '20',
								'STATUS'		=> 'WAITING',
								'WK_STATUS'		=> date('Y-m-d H:i:s'),
								'OPERATOR'		=> $this->session->userdata('USERLOGIN')
							);
							$this->db->insert('t_job_slip',$arrdata);
						}

						$SQLReport = $this->db->query("SELECT * FROM report_behandle WHERE NO_CONT='".$noCont."' AND RB1_NO_SPK = '".$SQL_SPK['NO_SPK']."' ORDER BY ID DESC")->result_array();
						if (count($SQLReport) > 0) {
							$updateReport = array(
								'NO_CONT' 		=> $noCont,
								'PRN_BEHANDLE_IN' 	=> date('Y-m-d H:i:s'),
								'PRN_KONDISI_CONT' 	=> $TrukIn,					
								'PRN_NO_SEAL' 		=> $noSeal,						
								'PRN_ISO_CODE' 		=> $isoCode,						
								'PRN_LOKASI' 		=> $nmBlok.'0'.$nmTier				
							);
							$this->db->where(array('ID' => $SQLReport[0]['ID'], 'NO_CONT' => $noCont, 'REQ_NO_DOK' => $SQL_GATEPASS[0]['NO_DOK']));
							$this->db->update('report_behandle', $updateReport);
						}

						$data['notif'] = 1; /* BERHASIL INSERT */
						$data['NOCONT']= $noCont;
						$this->content = $this->load->view('content/dashboard/inspection',$data,true);
						$this->index();
					}
				}else{
					$data['notif']  = 4; /* LOKASI TELAH DIGUNAKAN */
					$data['NOCONT'] = $noCont;
					$this->content  = $this->load->view('content/dashboard/inspection',$data,true);
					$this->index();
				}
			}else{
				$data['notif']  = 7; /* LOKASI TIDAK SESUAI */
				$data['NOCONT'] = $noCont;
				$this->content  = $this->load->view('content/dashboard/inspection',$data,true);
				$this->index();
			}
		}else{
			$data['notif']  = 2; /* KONTAINER NOT FOUND */
			$data['NOCONT'] = $noCont;
			$this->content  = $this->load->view('content/dashboard/inspection',$data,true);
			$this->index();
		}
	}

	public function set_inspection_old(){
		$this->load->helper('url');
		//variabel
		$inputan2= $this->input->post('nomerkon');
		$urut=$this->ambilspk();
		$nilai=1;
		$isocode=$this->input->post('isocode');
		$noseal=$this->input->post('noseal');
		$stakoncoar= $this->input->post('optradiostatus');
		$lokas=$this->input->post('nolok');
		$lokasi=trim($lokas);
		$notid=$this->input->post('trucknya');
		 
		$query2=$this->cek_tspkcont($inputan2);
		$query=$this->cek_tspk2($query2['ID']);
		$counn=$this->ambiljumspk($query2['ID']);
		$coun2=count($counn);
		if (isset($urut)) {
			foreach ($urut as $data) {
				if ($data['NO_SPK'] == $query['NO_SPK']) {
					$nilai=$nilai+1;
				}
			}
		}
			$nomerespk=$query['NO_SPK'];
			$lok=$lokasi;
			echo "$lok";
			$datalokasi=strtoupper(substr($lok,0,6));
			$datatier=substr($lok,-1);
			$denahlokasi=$this->cekdenah($datalokasi,$datatier);
			$hasillokasi=$this->ceklokasiterpakai3($lok);
			$wkt=date('Y-m-d H:i:s');
			$ar=$this->db->query("SELECT * FROM t_job_slip WHERE NO_SPK='$nomerespk' AND NO_CONT='$inputan2' AND STATUS='WAITING'")->row_array();
			$gatepess=$this->db->query("SELECT * FROM t_gatepass WHERE NO_CONT='$inputan2' AND STATUS='WAITING' AND JNS_KEGIATAN='1' ")->row_array();
			$spk1=$query['NO_SPK'];
			$ar23=$this->db->query("SELECT * FROM t_spk WHERE NO_SPK='$spk1'")->row_array();
			$spid=$ar23['ID'];
			$tglspk=$ar['TGL_SPK'];
			$jnsdok=$ar['JNS_DOK'];
			$nock=$ar['NO_CONT'];
			$nogat=$gatepess['ID'];
			$lokasiaw=$ar['LOKASI_AKHIR'];
			$tieraw=$ar['TIER_AKHIR'];
			$tglg=$gatepess['WK_REK'];	
			$idjobnya=$ar['ID_JOB_SLIP'];
		
		//cek validasi
		$cekval=$this->cek_notgl_gatepass($nogat,$tglg,$lokasi);  	
		if ($noseal==NULL) {
			$dsimpan= array(
				'NO_SPK' => $query['NO_SPK'],
				'OPERATOR' => $this->session->userdata('USERLOGIN'),
				'NO_CONT' => $inputan2,
				'KONDISI_CONT' => $this->input->post('kondisi'),
				'KONDISI_SEAL' => $this->input->post('optradio'),
				'ISO_CODE' => $this->input->post('isocode'),
				'ROOM'=>$this->input->post('nolok'),
				'W_BEHANDLE' => date('Y-m-d H:i:s'),
				'URUTAN_SPK' => $nilai
			);
		}else {
			$dsimpan= array(
				'NO_SPK' => $query['NO_SPK'],
				'OPERATOR' => $this->session->userdata('USERLOGIN'),
				'NO_CONT' => $inputan2,
				'KONDISI_CONT' => $this->input->post('kondisi'),
				'KONDISI_SEAL' => $this->input->post('optradio'),
				'NO_SEAL' => $noseal,
				'ROOM'=>$this->input->post('nolok'),
				'ISO_CODE' => $this->input->post('isocode'),
				'W_BEHANDLE' => date('Y-m-d H:i:s'),
				'URUTAN_SPK' => $nilai
			);
		}
		$dsi= array(
				'WK_IN' => date('Y-m-d H:i:s')
			);
		$keyy= array(
				'NO_CONT' => $inputan2,
				'NO_SPK' => $query['NO_SPK']
			);
		$stat= array(
				'STATUS' => 'DONE',
				'KD_STATUS' => '50'
			);	
		//proses dengan validasi
		/*if($cekval==1){
			$data['notif']=6;
			$data['NOCONT']=$hasillokasi['NO_CONT'];
			$this->content = $this->load->view('content/dashboard/inspection',$data,true);
			$this->index();
		}elseif($cekval==2){*/
			//if (($query['KD_STATUS']=='200')||($query['KD_STATUS']=='400')) {
					if ( $query2['STATUS_CONT']=='200') {
						//proses baru
								if(substr($lok,0,3)=="CIC" || substr($lok,0,3)=="cic"){
									$varlokasi=substr($lok,0,5);
									$vartier=substr($lok,-1);
									if($hasillokasi['LOKASI']==$varlokasi){
										$data['notif']=4;
										$data['NOCONT']=$hasillokasi['NO_CONT'];
										$this->content = $this->load->view('content/dashboard/inspection',$data,true);
										$this->index();
									}else{
										$this->after_inspection($inputan2,$coun2,$query2['ID'],$noseal,$lokasi,$isocode,$notid,$stakoncoar);
										$this->db->insert('t_op_behandlein',$dsimpan);
										$this->db->where($keyy);
										$this->db->update('t_operation',$dsi);
										$this->db->where($keyy);
										$this->db->update('t_job_slip',$stat);
										//update t_denah
										$this->db->where(array('NM_BLOK' => $varlokasi, 'LEVEL_4' =>$vartier));
										$this->db->update('t_denah_lapangan', array('USE'=>'1'));
										// 
										$this->ubahlok2($inputan2,$varlokasi,$vartier,"460",$spid);
										$arrdata = array(
											'NO_SPK'=>$spk1,
											'OPERATOR' => $this->session->userdata('USERLOGIN'),
											'TGL_SPK'=>$tglspk,
											'JNS_DOK'=>$jnsdok,
											'NO_CONT'=>$inputan2,
											'NO_GATEPASS'=>$nogat,
											'LOKASI_AWAL'=>$lokasiaw,
											'TIER_AWAL'=>$tieraw,
											'TGL_GATEPASS'=>$tglg,
											'KD_STATUS'=>'00',
											'STATUS'=>'WAITING'
										  );
										$this->updatejobslipstatus2("50",$idjobnya);  
										$this->db->insert('t_job_slip',$arrdata); 
										$data['notif']=1;
										$data['NOCONT']=$inputan2;
										$this->content = $this->load->view('content/dashboard/inspection',$data,true);
										$this->index();
									}
								}elseif(substr($lok,0,2)=="1A" || substr($lok,0,2)=="1a" || substr($lok,0,2)=="YA" || substr($lok,0,2)=="ya"){
									if($hasillokasi['LOKASI']==$datalokasi){
										$data['notif']=4;
										$data['NOCONT']=$hasillokasi['NO_CONT'];
										$this->content = $this->load->view('content/dashboard/inspection',$data,true);
										$this->index();
									}else{
										if ($denahlokasi['NM_BLOK']==$datalokasi){
											$van2=substr($lok,0,6);
											$tie=substr($lok,-1);
											$this->ubahlok2($inputan2,$van2,$tie,"450",$spid);
											$this->after_inspection($inputan2,$coun2,$query2['ID'],$noseal,$lokasi,$isocode,$notid,$stakoncoar);
											$this->db->insert('t_op_behandlein',$dsimpan);
											$this->db->where($keyy);
											$this->db->update('t_operation',$dsi);
											$this->db->where($keyy);
											$this->db->update('t_job_slip',$stat);
											//update t_denah_lapangan
											$this->db->where(array('NM_BLOK' => $van2, 'LEVEL_4' =>$tie));
											$this->db->update('t_denah_lapangan', array('USE'=>'1'));
											
											if(isset($nogat)){
												$arrdatan = array(
													'OPERATOR' => $this->session->userdata('USERLOGIN'),
													'NO_SPK'=>$spk1,
													'TGL_SPK'=>$tglspk,
													'JNS_DOK'=>$jnsdok,
													'NO_CONT'=>$inputan2,
													'NO_GATEPASS'=>$nogat,
													'LOKASI_AWAL'=>$van2,
													'JNS_JOB_SLIP'=>'MARSHALLING',
													'JENIS'=>'BEHANDLE 1',
													'TIER_AWAL'=>$tie,
													'TGL_GATEPASS'=>$tglg,
													'KD_STATUS'=>'10',
													'STATUS'=>'WAITING'
												);
											}else{
												$arrdatan = array(
													'OPERATOR' => $this->session->userdata('USERLOGIN'),
													'NO_SPK'=>$spk1,
													'TGL_SPK'=>$tglspk,
													'NO_CONT'=>$inputan2,
													'NO_GATEPASS'=>$nogat,
													'LOKASI_AWAL'=>$van2,
													'TIER_AWAL'=>$tie,
													'TGL_GATEPASS'=>$tglg,
													'KD_STATUS'=>'10',
													'STATUS'=>'WAITING'
												);
											}
											
											$this->updatejobslipstatus2("50",$idjobnya);  
											$this->db->insert('t_job_slip',$arrdatan);
											
											$data['notif']=1;
											$data['NOCONT']=$inputan2;
											$this->content = $this->load->view('content/dashboard/inspection',$data,true);
											$this->index();
										}else{
											$data['notif']=5;
											$data['NOTIER']=$datatier;
											$data['lokasikontainer']=$lok;
											$data['nomerkontainer']=$inputan2;
											$this->content = $this->load->view('content/dashboard/inspection',$data,true);
											$this->index();
										}
									}  
								}elseif(substr($lok,0,2)=="1B" || substr($lok,0,2)=="1b" || substr($lok,0,2)=="YB" || substr($lok,0,2)=="yb"){
									if($hasillokasi['LOKASI']==$datalokasi){
										$data['notif']=4;
										$data['NOCONT']=$hasillokasi['NO_CONT'];
										$this->content = $this->load->view('content/dashboard/inspection',$data,true);
										$this->index();
									}else{
										if ($denahlokasi['NM_BLOK']==$datalokasi){
											$van2=substr($lok,0,6);
											$tie=substr($lok,-1);
											$this->ubahlok2($inputan2,$van2,$tie,"450",$spid);
											$this->after_inspection($inputan2,$coun2,$query2['ID'],$noseal,$lokasi,$isocode,$notid,$stakoncoar);
											$this->db->insert('t_op_behandlein',$dsimpan);
											$this->db->where($keyy);
											$this->db->update('t_operation',$dsi);
											$this->db->where($keyy);
											$this->db->update('t_job_slip',$stat);
											//update t_denah_lapangan
											
											$this->db->where(array('NM_BLOK' => $van2, 'LEVEL_4' =>$tie));
											$this->db->update('t_denah_lapangan', array('USE'=>'1'));
											
											if(isset($nogat)){
												$arrdatane = array(
													'OPERATOR' => $this->session->userdata('USERLOGIN'),
													'NO_SPK'=>$spk1,
													'TGL_SPK'=>$tglspk,
													'JNS_DOK'=>$jnsdok,
													'NO_CONT'=>$inputan2,
													'NO_GATEPASS'=>$nogat,
													'LOKASI_AWAL'=>$van2,
													'JNS_JOB_SLIP'=>'MARSHALLING',
													'JENIS'=>'BEHANDLE 1',
													'TIER_AWAL'=>$tie,
													'TGL_GATEPASS'=>$tglg,
													'KD_STATUS'=>'10',
													'STATUS'=>'WAITING'
												);
											}else{
												$arrdatane = array(
													'OPERATOR' => $this->session->userdata('USERLOGIN'),
													'NO_SPK'=>$spk1,
													'TGL_SPK'=>$tglspk,
													'NO_CONT'=>$inputan2,
													'NO_GATEPASS'=>$nogat,
													'LOKASI_AWAL'=>$van2,
													'TIER_AWAL'=>$tie,
													'TGL_GATEPASS'=>$tglg,
													'KD_STATUS'=>'10',
													'STATUS'=>'WAITING'
												);
											}
											
											$this->updatejobslipstatus2("50",$idjobnya);  
											$this->db->insert('t_job_slip',$arrdatane);
											$data['notif']=1;
											$data['NOCONT']=$inputan2;
											$this->content = $this->load->view('content/dashboard/inspection',$data,true);
											$this->index();
											
										}else{
											$data['notif']=5;
											$data['NOTIER']=$datatier;
											$data['lokasikontainer']=$lok;
											$data['nomerkontainer']=$inputan2;
											$this->content = $this->load->view('content/dashboard/inspection',$data,true);
											$this->index();
										}
									}
								}	
						//end proses
					}elseif ( $query2['STATUS_CONT']=='400') {
						$data['notif']=2;
						$data['NOCONT']=$inputan2;
						$this->content = $this->load->view('content/dashboard/inspection',$data,true);
						$this->index();
					}else {
						$data['notif']=3;
						$data['NOCONT']=$inputan2;
						$this->content = $this->load->view('content/dashboard/inspection',$data,true);
						$this->index();
					}
			// }else {
			// 	$data['notif']=4;
			// 	$data['NOCONT']=$inputan2;
			// 	$this->content = $this->load->view('content/dashboard/inspection',$data,true);
			// 	$this->index();
			// 	;
			// }
		/*}elseif($cekval==3){
			$data['notif']=7;
			$data['NOCONT']=$hasillokasi['NO_CONT'];
			$this->content = $this->load->view('content/dashboard/inspection',$data,true);
			$this->index();
		}*/		
		//end proses					
	}

	public function ubahstatus($lok,$spk,$contt){
		
		$this->db->query("UPDATE t_job_slip SET LOKASI_AKHIR='$lok' WHERE NO_CONT='$contt' AND NO_SPK='$spk' ");
	}

	public function ubahlok($cont,$loka,$stat,$spid){
		$this->db->where(array('NO_CONT' => $cont, 'ID' => $spid));
		$this->db->update('t_spk_cont', array('LOKASI' => $loka,'STATUS_CONT'=>$stat));
	}
				
	public function ubahlok2($cont,$loka,$tier,$stat,$spid){
		$lokabaru=strtoupper($loka);
		$tierbaru=strtoupper($tier);
		$this->db->where(array('NO_CONT' => $cont, 'ID' => $spid));
		$this->db->update('t_spk_cont', array('LOKASI' => $lokabaru,'TIER'=>$tierbaru,'STATUS_CONT'=>$stat));
	}

	public function cekdenah($bloke,$tiere){
		$queryspk=$this->db->query("select NM_BLOK,LEVEL_4 from t_denah_lapangan where NM_BLOK='$bloke' AND LEVEL_4='$tiere' ");
		return $queryspk->row_array();
	}
				
	public function ceklokasiterpakai($temp){
		$tempat=strtoupper($temp);
		if(substr($tempat,0,3)=="CIC"){
			$bloke=substr($tempat,0,5);
			$tiere=substr($tempat,-1);
			$queryspk=$this->db->query("select NO_CONT,LOKASI,TIER,STATUS_CONT from t_spk_cont where LOKASI='$bloke' AND TIER='$tiere' AND STATUS_CONT IN('450','460','510','530') ");
		}else{
			$bloke=substr($tempat,0,6);
			$tiere=substr($tempat,-1);
			$queryspk=$this->db->query("select NO_CONT,LOKASI,TIER,STATUS_CONT from t_spk_cont where LOKASI='$bloke' AND TIER='$tiere' AND STATUS_CONT IN('450','460','510','530') ");
		}
		return $queryspk->row_array();
	}
				
	public function ceklokasiterpakai3($temp){
		$tempat=strtoupper($temp);
		if(substr($tempat,0,3)=="CIC"){
			$bloke=substr($tempat,0,5);
			$tiere=substr($tempat,-1);
			$queryspk=$this->db->query("select NO_CONT,LOKASI,TIER,STATUS_CONT from t_spk_cont where LOKASI='$bloke' AND TIER='$tiere' AND STATUS_CONT IN('450','460') ");
		}else{
			$bloke=substr($tempat,0,6);
			$tiere=substr($tempat,-1);
			$queryspk=$this->db->query("select NO_CONT,LOKASI,TIER,STATUS_CONT from t_spk_cont where LOKASI='$bloke' AND TIER='$tiere' AND STATUS_CONT IN('450','460') ");
		}
		return $queryspk->row_array();
	}
				
	public function ceklokasiterpakai2($temp){
		$tempat=strtoupper($temp);
		if(substr($tempat,0,3)=="CIC"){
			$bloke=substr($tempat,0,5);
			$tiere=substr($tempat,-1);
			$queryspk=$this->db->query("select * from t_denah_lapangan where NM_BLOK='$bloke' AND LEVEL_4='$tiere'");
		}else{
			$bloke=substr($tempat,0,6);
			$tiere=substr($tempat,-1);
			$queryspk=$this->db->query("select * from t_denah_lapangan where NM_BLOK='$bloke' AND LEVEL_4='$tiere'");
		}
		return $queryspk->row_array();
	}

	public function set_marshalling_cic(){
		$ID_JOB 	  = $this->input->post('jobs');
		$NO_CONT 	  = $this->input->post('nocont');
		$UKR_CONT 	  = $this->input->post('ukrcont');
		$LOK_AKHIR 	  = $this->input->post('lokak');
		$JNS_KEGIATAN = $this->input->post('job');
		$PKB_RESPON   = $this->input->post('respon');
		$NOTE   = $this->input->post('note');

		$NM_BLOCK = strtoupper(substr($LOK_AKHIR,0,5));
		$NM_TIER = strtoupper(substr($LOK_AKHIR,-1));

		$SQL_JOBSLIP = $this->db->query("SELECT * FROM t_job_slip WHERE ID_JOB_SLIP = '".$ID_JOB."' AND NO_CONT = '".$NO_CONT."' ORDER BY ID_JOB_SLIP DESC LIMIT 1")->row_array();

		$SQL_DENAH 	 = $this->db->query("SELECT CONCAT(NM_BLOK,'0',LEVEL_4) AS 'DENAH' FROM t_denah_lapangan WHERE NM_BLOK = '".$NM_BLOCK."' AND LEVEL_4 = '".$NM_TIER."' ")->row_array();

		$SQL_SPK_LOK = $this->db->query("SELECT NO_CONT, CONCAT(LOKASI,'0',TIER) AS 'LOKASI',STATUS_CONT FROM t_spk_cont where LOKASI = '".$NM_BLOCK."' AND TIER = '".$NM_TIER."' AND STATUS_CONT IN('450','460','510','530')")->row_array();

		if ($SQL_DENAH['DENAH'] == $LOK_AKHIR) {
			if($SQL_SPK_LOK['LOKASI'] != $LOK_AKHIR){
				if($PKB_RESPON != 'NO RESPON'){
					/* UPDATE JOB OLD MENJADI DONE */
					$this->db->where('ID_JOB_SLIP', $ID_JOB);
					$this->db->update('t_job_slip', array('STATUS'=>'DONE', 'STATUS_JOB' => 'Y','NOTE' => $NOTE, 'KD_STATUS' =>'50', 'OPERATOR' => $this->session->userdata('USERLOGIN'), 'WK_STATUS' => date('Y-m-d H:i:s')));

					/* UPDATE SPK */
					$SQL = $this->db->query("SELECT * FROM t_spk WHERE NO_SPK = '".$SQL_JOBSLIP['NO_SPK']."' ORDER BY ID DESC LIMIT 1")->row_array();

					$this->db->where(array('NO_CONT' => $NO_CONT, 'ID' => $SQL['ID']));
					$this->db->update('t_spk_cont', array('LOKASI' => $NM_BLOCK,'TIER '=> $NM_TIER,'STATUS_CONT' => '460'));

					/* INSERT INTO JOBSLIP DAN MASIH AMBIGU */
					$arrJob = array(
								'NO_SPK'	   	=> $SQL_JOBSLIP['NO_SPK'],
								'TGL_SPK'	   	=> $SQL_JOBSLIP['TGL_SPK'],
								'JNS_DOK' 	   	=> $SQL_JOBSLIP['JNS_DOK'],
								'NO_DOK' 	   	=> $SQL_JOBSLIP['NO_DOK'],
								'NO_CONT'	   	=> $NO_CONT,
								'NO_GATEPASS'  	=> $SQL_JOBSLIP['NO_GATEPASS'],
								'TGL_GATEPASS' 	=> $SQL_JOBSLIP['TGL_GATEPASS'],
								'LOKASI_AWAL'	=> $NM_BLOCK,
								'TIER_AWAL'		=> $NM_TIER,
								'STATUS'		=> 'WAITING',
								'KD_STATUS'		=> '20',
								'NOTE'			=> $NOTE,
								'WK_STATUS'		=> date('Y-m-d H:i:s'),
								'OPERATOR' 		=> $this->session->userdata('USERLOGIN')
					);
					$this->db->insert('t_job_slip',$arrJob); 
					/* INSERT TO t_operation  */
					$arrData = array(
								'ID_SPK'=>$SQL['ID'],
								'NO_CONT'=> $NO_CONT,
								'KD_STATUS'=> '460',
								'WK_STATUS'=> date('Y-m-d H:i:s'),
								'OPERATOR'=> $this->session->userdata('USERLOGIN')
					);
					$this->db->insert('t_operation_new',$arrData);

					if ($JNS_KEGIATAN == 'BEHANDLE 1') {
						$SQLReport = $this->db->query("SELECT * FROM report_behandle WHERE NO_CONT='".$NO_CONT."' AND REQ_NO_DOK='".$SQL_JOBSLIP['NO_DOK']."' AND RB1_NO_SPK = '".$SQL_JOBSLIP['NO_SPK']."' ORDER BY ID DESC")->result_array();
						if (count($SQLReport) > 0) {
							$updateReport = array(
								'NO_CONT' 			=> $NO_CONT,
								'PB1_MARSHALLING_B1'=> date('Y-m-d H:i:s'),
								'PB1_LOKASI_CIC' 	=> $NM_BLOCK.'0'.$NM_TIER		
							);
							$this->db->where(array('ID' => $SQLReport[0]['ID'], 'NO_CONT' => $NO_CONT, 'REQ_NO_DOK' => $SQL_JOBSLIP['NO_DOK']));
							$this->db->update('report_behandle', $updateReport);
						}
					}else{
						$SQLReport = $this->db->query("SELECT * FROM report_behandle WHERE NO_CONT='".$NO_CONT."' AND REQ_NO_DOK='".$SQL_JOBSLIP['NO_DOK']."' AND RB1_NO_SPK = '".$SQL_JOBSLIP['NO_SPK']."' ORDER BY ID DESC")->result_array();
						if (count($SQLReport) > 0) {
							$updateReport = array(
								'NO_CONT' 			=> $NO_CONT,
								'PB2_MARSHALLING_B2'=> date('Y-m-d H:i:s'),
								'PB2_LOKASI_CIC' 	=> $NM_BLOCK.'0'.$NM_TIER		
							);
							$this->db->where(array('ID' => $SQLReport[0]['ID'], 'NO_CONT' => $NO_CONT, 'REQ_NO_DOK' => $SQL_JOBSLIP['NO_DOK']));
							$this->db->update('report_behandle', $updateReport);
						}
					}

					$data['notif']=1;
					$data['lokasikontainer']=$LOK_AKHIR;
					$data['nomerkontainer']=$NO_CONT;
					$data['jobs']=$ID_JOB;
					$data['nilai']=$this->getalljobscic();
					$this->content = $this->load->view('content/dashboard/marshallingcic',$data,true);
					$this->index();
				}else{
					$data['notif']	= 2;
					$data['nokont']	= $NO_CONT;
					$data['nilai']	= $this->getalljobscic();
					$this->content  = $this->load->view('content/dashboard/marshallingcic',$data,true);
					$this->index();
				}
			}else{
				$data['notif']	= 4;
				$data['nokont']	= $SQL_SPK_LOK['NO_CONT'];
				$data['nilai']	= $this->getalljobscic();
				$this->content  = $this->load->view('content/dashboard/marshallingcic',$data,true);
				$this->index();
			}
		}else{
			$data['notif'] = 3;
			$data['nilai']	= $this->getalljobscic();
			$this->content = $this->load->view('content/dashboard/marshallingcic',$data,true);
			$this->index();
		}
	}

	public function set_marshallingcic_old(){
		$this->load->helper('url');
		$oopp=$this->session->userdata('USERLOGIN');
		$inp=$this->input->post('nocont');
		$inp2=$this->input->post('jobs');
		$lokasi=$this->input->post('lokak');
		$lok=trim($lokasi);
		$datalokasi=strtoupper(substr($lok,0,6));
		$datatier=substr($lok,-1);
		$denahlokasi=$this->cekdenah($datalokasi,$datatier);
		$hasillokasi=$this->ceklokasiterpakai($lok);
		$lokasiterpakai=$this->ceklokasiterpakai2($lok);
		$lokawal=$this->input->post('lokaw');
		$lokaw=trim($lokawal);
		$wkt=date('Y-m-d H:i:s');
		$ar=$this->db->query("SELECT * FROM t_job_slip WHERE ID_JOB_SLIP='$inp2'")->row_array();
		//echo $inp2."<br>".$inp;die();
		$spk1=$ar['NO_SPK'];
		$ar23=$this->db->query("SELECT * FROM t_spk WHERE NO_SPK='$spk1'")->row_array();
		$spid=$ar23['ID'];
		$tglspk=$ar['TGL_SPK'];
		$nock=$ar['NO_CONT'];
		$nogat=$ar['NO_GATEPASS'];
		$jenisjob2=$ar['JENIS'];
		$lokasiaw=$ar['LOKASI_AKHIR'];
		$tieraw=$ar['TIER_AKHIR'];
		$tglg=$ar['TGL_GATEPASS'];
		if(count($lokasiterpakai)==0){
			$data['notif']=3;
			$data['NOTIER']=$datatier;
			$data['lokasikontainer']=$this->input->post('lokak');
			$data['nomerkontainer']=$this->input->post('nocont');
			$data['jobs']=$this->input->post('jobs');
			$data['nilai']=$this->getalljobscic();
			$this->content = $this->load->view('content/dashboard/marshallingcic',$data,true);
			$this->index();
		}else{
			if(substr($lok,0,3)=="CIC" || substr($lok,0,3)=="cic"){
				$varlokasi=substr($lok,0,5);
				$vartier=substr($lok,-1);
				if($hasillokasi['LOKASI']==$varlokasi){
					$data['notif']=4;
					$data['nokont']=$hasillokasi['NO_CONT'];
					$data['lokasikontainer']=$this->input->post('lokak');
					$data['nomerkontainer']=$this->input->post('nocont');
					$data['jobs']=$this->input->post('jobs');
					$data['nilai']=$this->getalljobscic();
					$this->content = $this->load->view('content/dashboard/marshallingcic',$data,true);
					$this->index();
				}else{
					$this->db->where('ID_JOB_SLIP',$inp2);
					$this->db->update('t_job_slip', array('STATUS'=>'DONE', 'STATUS_JOB' => 'Y', 'KD_STATUS' =>50, 'OPERATOR' => $oopp, 'WK_STATUS' => $wkt));
					//$this->db->query("UPDATE t_job_slip SET STATUS='DONE',STATUS_JOB='Y', KD_STATUS='50','OPERATOR'='$oopp', WK_STATUS='$wkt' WHERE ID_JOB_SLIP='$inp2' ");
					//update t_denah
					if(substr($lokaw,0,3)==="CIC" || substr($lokaw,0,3)==="cic"){
						$varlokasi2=substr($lokaw,0,5);
						$vartier2=substr($lokaw,-1);
						$this->db->where(array('NM_BLOK' => $varlokasi2, 'LEVEL_4' =>$vartier2));
						$this->db->update('t_denah_lapangan', array('USE'=>'0'));
					}else{
						$van3=substr($lokaw,0,6);
						$tierr=substr($lokaw,-1);
						$this->db->where(array('NM_BLOK' => $van3, 'LEVEL_4' =>$tierr));
						$this->db->update('t_denah_lapangan', array('USE'=>'0'));
					}
					$this->db->where(array('NM_BLOK' => $varlokasi, 'LEVEL_4' =>$vartier));
					$this->db->update('t_denah_lapangan', array('USE'=>'1'));
					$this->ubahlok2($inp,$varlokasi,$vartier,"460",$spid);
					$arrdata = array(
								'NO_SPK'=>$spk1,
								'OPERATOR' => $this->session->userdata('USERLOGIN'),
								'TGL_SPK'=>$tglspk,
								'NO_CONT'=>$nock,
								'NO_GATEPASS'=>$nogat,
								'LOKASI_AWAL'=>$lokasiaw,
								'TIER_AWAL'=>$tieraw,
								'TGL_GATEPASS'=>$tglg,
								'STATUS'=>'WAITING'
					);
					$this->db->insert('t_job_slip',$arrdata); 
					//insert ke t_operation ketika submit ke cic
					$arrmarshalling = array(
								'ID_SPK'=>$spid,
								'NO_CONT'=> $nock,
								'KD_STATUS'=> '460',
								'WK_STATUS'=> date('Y-m-d H:i:s'),
								'OPERATOR'=> $this->session->userdata('USERLOGIN')
					);
					$this->db->insert('t_operation_new',$arrmarshalling); 
					$data['notif']=1;
					$data['lokasikontainer']=$this->input->post('lokak');
					$data['nomerkontainer']=$this->input->post('nocont');
					$data['jobs']=$this->input->post('jobs');
					$data['nilai']=$this->getalljobscic();
					$this->content = $this->load->view('content/dashboard/marshallingcic',$data,true);
					$this->index();
				}
			}else if(substr($lok,0,2)=="1A" || substr($lok,0,2)=="1a" || substr($lok,0,2)=="YA"){
				if($hasillokasi['LOKASI']==$datalokasi){
				$data['notif']=4;
				$data['nokont']=$hasillokasi['NO_CONT'];
				$data['lokasikontainer']=$this->input->post('lokak');
				$data['nomerkontainer']=$this->input->post('nocont');
				$data['jobs']=$this->input->post('jobs');
				$data['nilai']=$this->getalljobscic();
				$this->content = $this->load->view('content/dashboard/marshallingcic',$data,true);
				$this->index();
				}else{
					if ($denahlokasi['NM_BLOK']==$datalokasi){
						$this->db->where('ID_JOB_SLIP',$inp2);
						$this->db->update('t_job_slip', array('STATUS'=>'DONE','STATUS_JOB' => 'Y','KD_STATUS' =>50,'OPERATOR' => $oopp,'WK_STATUS' => $wkt));
						//$this->db->query("UPDATE t_job_slip SET STATUS='DONE',STATUS_JOB='Y',KD_STATUS='50', 'OPERATOR'='$oopp', WK_STATUS='$wkt' WHERE ID_JOB_SLIP='$inp2' ");
						$van2=substr($lok,0,6);
						$tie=substr($lok,-1);
						$this->ubahlok2($inp,$van2,$tie,"450",$spid);
						//update t_denah_lapangan
						if(substr($lokaw,0,3)==="CIC" || substr($lokaw,0,3)==="cic" ){
							$varlokasi2=substr($lokaw,0,5);
							$vartier2=substr($lokaw,-1);
							$this->db->where(array('NM_BLOK' => $varlokasi2, 'LEVEL_4' =>$vartier2));
							$this->db->update('t_denah_lapangan', array('USE'=>'0'));
						}else{
							$van3=substr($lokaw,0,6);
							$tierr=substr($lokaw,-1);
							$this->db->where(array('NM_BLOK' => $van3, 'LEVEL_4' =>$tierr));
							$this->db->update('t_denah_lapangan', array('USE'=>'0'));
						}
						$this->db->where(array('NM_BLOK' => $van2, 'LEVEL_4' =>$tie));
						$this->db->update('t_denah_lapangan', array('USE'=>'1'));
						$arrdata = array(
									'OPERATOR' => $this->session->userdata('USERLOGIN'),
									'NO_SPK'=>$spk1,
									'TGL_SPK'=>$tglspk,
									'NO_CONT'=>$nock,
									'LOKASI_AWAL'=>$van2,
									'TIER_AWAL'=>$tie,
									'STATUS'=>'WAITING'
						);
						$this->db->insert('t_job_slip',$arrdata);
						//update set status gatepass jadi done
						if($jenisjob2=='EX BEHANDLE 1' || $jenisjob2=='EX BEHANDLE 2'){
							$this->db->where('ID',$nogat);
							$this->db->update('t_gatepass', array('STATUS'=>'DONE'));
						}	
						$data['notif']=1;
						$data['lokasikontainer']=$this->input->post('lokak');
						$data['nomerkontainer']=$this->input->post('nocont');
						$data['jobs']=$this->input->post('jobs');
						$data['nilai']=$this->getalljobscic();
						$this->content = $this->load->view('content/dashboard/marshallingcic',$data,true);
						$this->index();
					}else{
						$data['notif']=3;
						$data['NOTIER']=$datatier;
						$data['lokasikontainer']=$this->input->post('lokak');
						$data['nomerkontainer']=$this->input->post('nocont');
						$data['jobs']=$this->input->post('jobs');
						$data['nilai']=$this->getalljobscic();
						$this->content = $this->load->view('content/dashboard/marshallingcic',$data,true);
						$this->index();
					}
				}  
			}else{
				if($hasillokasi['LOKASI']==$datalokasi){
					$data['notif']=4;
					$data['nokont']=$hasillokasi['NO_CONT'];
					$data['lokasikontainer']=$this->input->post('lokak');
					$data['nomerkontainer']=$this->input->post('nocont');
					$data['jobs']=$this->input->post('jobs');
					$data['nilai']=$this->getalljobscic();
					$this->content = $this->load->view('content/dashboard/marshallingcic',$data,true);
					$this->index();
				}else{
					if ($denahlokasi['NM_BLOK']==$datalokasi){
						$this->db->where('ID_JOB_SLIP',$inp2);
						$this->db->update('t_job_slip', array('STATUS'=>'DONE','STATUS_JOB' => 'Y','KD_STATUS' =>50,'OPERATOR' => $oopp,'WK_STATUS' => $wkt));
						//$this->db->query("UPDATE t_job_slip SET STATUS='DONE',STATUS_JOB='Y', KD_STATUS='50','OPERATOR'='$oopp', WK_STATUS='$wkt' WHERE ID_JOB_SLIP='$inp2' ");
						$van2=substr($lok,0,6);
						$tie=substr($lok,-1);
						$this->ubahlok2($inp,$van2,$tie,"450",$spid);
						//update t_denah_lapangan
						if(substr($lokaw,0,3)==="CIC" || substr($lokaw,0,3)==="cic" ){
							$varlokasi2=substr($lokaw,0,5);
							$vartier2=substr($lokaw,-1);
							$this->db->where(array('NM_BLOK' => $varlokasi2, 'LEVEL_4' =>$vartier2));
							$this->db->update('t_denah_lapangan', array('USE'=>'0'));
						}else{
							$van3=substr($lokaw,0,6);
							$tierr=substr($lokaw,-1);
							$this->db->where(array('NM_BLOK' => $van3, 'LEVEL_4' =>$tierr));
							$this->db->update('t_denah_lapangan', array('USE'=>'0'));
						}
						$this->db->where(array('NM_BLOK' => $van2, 'LEVEL_4' =>$tie));
						$this->db->update('t_denah_lapangan', array('USE'=>'1'));
						$arrdata = array(
									'OPERATOR' => $this->session->userdata('USERLOGIN'),
									'NO_SPK'=>$spk1,
									'TGL_SPK'=>$tglspk,
									'NO_CONT'=>$nock,
									'NO_GATEPASS'=>$nogat,
									'LOKASI_AWAL'=>$van2,
									'TIER_AWAL'=>$tie,
									'TGL_GATEPASS'=>$tglg,
									'STATUS'=>'WAITING'
						);
						$this->db->insert('t_job_slip',$arrdata);
						//update set status gatepass jadi done
						if($jenisjob2=='EX BEHANDLE 1' || $jenisjob2=='EX BEHANDLE 2'){
							$this->db->where('ID',$nogat);
							$this->db->update('t_gatepass', array('STATUS'=>'DONE'));
						}	
						$data['notif']=1;
						$data['lokasikontainer']=$this->input->post('lokak');
						$data['nomerkontainer']=$this->input->post('nocont');
						$data['jobs']=$this->input->post('jobs');
						$data['nilai']=$this->getalljobscic();
						$this->content = $this->load->view('content/dashboard/marshallingcic',$data,true);
						$this->index();
					}else{
						$data['notif']=3;
						$data['NOTIER']=$datatier;
						$data['lokasikontainer']=$this->input->post('lokak');
						$data['nomerkontainer']=$this->input->post('nocont');
						$data['jobs']=$this->input->post('jobs');
						$data['nilai']=$this->getalljobscic();
						$this->content = $this->load->view('content/dashboard/marshallingcic',$data,true);
						$this->index();
					}			
				}  
			}
		}	
	}

	public function set_marshalling_yard(){
		$ID_JOB 	  = $this->input->post('jobs');
		$NO_CONT 	  = $this->input->post('nocont');
		$UKR_CONT 	  = $this->input->post('ukrcont');
		$LOK_AKHIR 	  = $this->input->post('lokak');
		$JNS_KEGIATAN = $this->input->post('job');
		$cekJumlah  = strlen($LOK_AKHIR);
		
		if ($cekJumlah > 8) {
			$NM_BLOCK = strtoupper(substr($LOK_AKHIR,0,7));
			$NM_TIER = strtoupper(substr($LOK_AKHIR,-1));
		}else{
			$NM_BLOCK = strtoupper(substr($LOK_AKHIR,0,6));
			$NM_TIER = strtoupper(substr($LOK_AKHIR,-1));
		};

		$SQL_JOBSLIP = $this->db->query("SELECT * FROM t_job_slip WHERE ID_JOB_SLIP = '".$ID_JOB."' AND NO_CONT = '".$NO_CONT."' ORDER BY ID_JOB_SLIP DESC LIMIT 1")->row_array();

		$SQL_DENAH 	 = $this->db->query("SELECT CONCAT(NM_BLOK,'0',LEVEL_4) AS 'DENAH' FROM t_denah_lapangan WHERE NM_BLOK = '".$NM_BLOCK."' AND LEVEL_4 = '".$NM_TIER."' ")->row_array();

		$SQL_SPK_LOK = $this->db->query("SELECT NO_CONT, CONCAT(LOKASI,'0',TIER) AS 'LOKASI',STATUS_CONT FROM t_spk_cont where LOKASI = '".$NM_BLOCK."' AND TIER = '".$NM_TIER."' AND STATUS_CONT IN('450','460','510','530')")->row_array();

		$SQL_PEMERIKSAAN = $this->db->query("SELECT * FROM t_op_inspection WHERE NO_CONT = '".$NO_CONT."' AND NO_SPK='".$SQL_JOBSLIP['NO_SPK']."' ORDER BY ID DESC LIMIT 1")->row_array();

		if ($SQL_DENAH['DENAH'] == $LOK_AKHIR) {
			if($SQL_SPK_LOK['LOKASI'] != $LOK_AKHIR){
				if($SQL_PEMERIKSAAN['STATUS'] == 'DONE'){
					/* UPDATE JOB OLD MENJADI DONE */
					$this->db->where('ID_JOB_SLIP', $ID_JOB);
					$this->db->update('t_job_slip', array('STATUS'=>'DONE', 'STATUS_JOB' => 'Y', 'KD_STATUS' =>'50', 'OPERATOR' => $this->session->userdata('USERLOGIN'), 'WK_STATUS' => date('Y-m-d H:i:s')));

					/* UPDATE SPK */
					$SQL = $this->db->query("SELECT * FROM t_spk WHERE NO_SPK = '".$SQL_JOBSLIP['NO_SPK']."' ORDER BY ID DESC LIMIT 1")->row_array();

					$this->db->where(array('NO_CONT' => $NO_CONT, 'ID' => $SQL['ID']));
					$this->db->update('t_spk_cont', array('LOKASI' => $NM_BLOCK,'TIER '=> $NM_TIER,'STATUS_CONT' => '450'));

					$this->db->where(array('NO_CONT' => $NO_CONT, 'ID' => $SQL_JOBSLIP['NO_GATEPASS']));
					$this->db->update('t_gatepass', array('STATUS'=>'DONE'));

					/* INSERT INTO JOBSLIP DAN MASIH AMBIGU */
					$arrJob = array(
						'NO_SPK'	   	=> $SQL_JOBSLIP['NO_SPK'],
						'TGL_SPK'	   	=> $SQL_JOBSLIP['TGL_SPK'],
						'JNS_DOK' 	   	=> $SQL_JOBSLIP['JNS_DOK'],
						'NO_DOK' 	   	=> $SQL_JOBSLIP['NO_DOK'],
						'NO_CONT'	   	=> $NO_CONT,
						'NO_GATEPASS'  	=> $SQL_JOBSLIP['NO_GATEPASS'],
						'TGL_GATEPASS' 	=> $SQL_JOBSLIP['TGL_GATEPASS'],
						'LOKASI_AWAL'	=> $NM_BLOCK,
						'TIER_AWAL'		=> $NM_TIER,
						'STATUS'		=> 'WAITING',
						'KD_STATUS'		=> '20',
						'WK_STATUS'		=> date('Y-m-d H:i:s'),
						'OPERATOR' 		=> $this->session->userdata('USERLOGIN')
					);
					$this->db->insert('t_job_slip',$arrJob); 

					if ($JNS_KEGIATAN == 'BEHANDLE 1') {
						$SQLReport = $this->db->query("SELECT * FROM report_behandle WHERE NO_CONT='".$NO_CONT."' AND REQ_NO_DOK='".$SQL_JOBSLIP['NO_DOK']."' AND RB1_NO_SPK = '".$SQL_JOBSLIP['NO_SPK']."' ORDER BY ID DESC")->result_array();
						if (count($SQLReport) > 0) {
							$updateReport = array(
								'NO_CONT' 			=> $NO_CONT,
								'PB1_MARSHALLING_B1'=> date('Y-m-d H:i:s'),
								'PB1_LOKASI_AFTER' 	=> $NM_BLOCK.'0'.$NM_TIER		
							);
							$this->db->where(array('ID' => $SQLReport[0]['ID'], 'NO_CONT' => $NO_CONT, 'REQ_NO_DOK' => $SQL_JOBSLIP['NO_DOK']));
							$this->db->update('report_behandle', $updateReport);
						}
					}else{
						$SQLReport = $this->db->query("SELECT * FROM report_behandle WHERE NO_CONT='".$NO_CONT."' AND REQ_NO_DOK='".$SQL_JOBSLIP['NO_DOK']."' AND RB1_NO_SPK = '".$SQL_JOBSLIP['NO_SPK']."' ORDER BY ID DESC")->result_array();
						if (count($SQLReport) > 0) {
							$updateReport = array(
								'NO_CONT' 			=> $NO_CONT,
								'PB2_MARSHALLING_EX_B2'=> date('Y-m-d H:i:s'),
								'PB2_LOKASI_AFTER' 	=> $NM_BLOCK.'0'.$NM_TIER		
							);
							$this->db->where(array('ID' => $SQLReport[0]['ID'], 'NO_CONT' => $NO_CONT, 'REQ_NO_DOK' => $SQL_JOBSLIP['NO_DOK']));
							$this->db->update('report_behandle', $updateReport);
						}
					}

					$data['notif']=1;
					$data['lokasikontainer']=$LOK_AKHIR;
					$data['nomerkontainer']=$NO_CONT;
					$data['jobs']=$ID_JOB;
					$data['nilai']=$this->getalljobsyard();
					$this->content = $this->load->view('content/dashboard/marshallingyard',$data,true);
					$this->index();
				}else{
					$data['notif']	= 5;
					$data['nokont']	= $NO_CONT;
					$data['nilai'] = $this->getalljobsyard();
					$this->content  = $this->load->view('content/dashboard/marshallingyard',$data,true);
					$this->index();
				}
			}else{
				$data['notif']	= 4;
				$data['nokont']	= $SQL_SPK_LOK['NO_CONT'];
				$data['nilai'] = $this->getalljobsyard();
				$this->content  = $this->load->view('content/dashboard/marshallingyard',$data,true);
				$this->index();
			}
		}else{
			$data['notif'] = 3;
			$data['nilai'] = $this->getalljobsyard();
			$this->content = $this->load->view('content/dashboard/marshallingyard',$data,true);
			$this->index();
		}
	}

	public function set_marshallingyard_old(){
		$this->load->helper('url');
		$oopp=$this->session->userdata('USERLOGIN');
		$inp=$this->input->post('nocont');
		$inp2=$this->input->post('jobs');
		$lokasi=$this->input->post('lokak');
		$lok=trim($lokasi);
		$datalokasi=strtoupper(substr($lok,0,6));
		$datatier=substr($lok,-1);
		$denahlokasi=$this->cekdenah($datalokasi,$datatier);
		$hasillokasi=$this->ceklokasiterpakai($lok);
		$lokasiterpakai=$this->ceklokasiterpakai2($lok);
		$lokawal=$this->input->post('lokaw');
		$lokaw=trim($lokawal);
		$wkt=date('Y-m-d H:i:s');
		$ar=$this->db->query("SELECT * FROM t_job_slip WHERE ID_JOB_SLIP='$inp2'")->row_array();
		//echo $inp2."<br>".$inp;die();
		$spk1=$ar['NO_SPK'];
		$ar23=$this->db->query("SELECT * FROM t_spk WHERE NO_SPK='$spk1'")->row_array();
		$spid=$ar23['ID'];
		$tglspk=$ar['TGL_SPK'];
		$nock=$ar['NO_CONT'];
		$nogat=$ar['NO_GATEPASS'];
		$jenisjob2=$ar['JENIS'];
		$lokasiaw=$ar['LOKASI_AKHIR'];
		$tieraw=$ar['TIER_AKHIR'];
		$tglg=$ar['TGL_GATEPASS'];
		if(count($lokasiterpakai)==0){
			$data['notif']=3;
			$data['NOTIER']=$datatier;
			$data['lokasikontainer']=$this->input->post('lokak');
			$data['nomerkontainer']=$this->input->post('nocont');
			$data['jobs']=$this->input->post('jobs');
			$data['nilai']=$this->getalljobsyard();
			$this->content = $this->load->view('content/dashboard/marshallingyard',$data,true);
			$this->index();
		}else{
			if(substr($lok,0,3)=="CIC" || substr($lok,0,3)=="cic"){
				$varlokasi=substr($lok,0,5);
				$vartier=substr($lok,-1);
				if($hasillokasi['LOKASI']==$varlokasi){
					$data['notif']=4;
					$data['nokont']=$hasillokasi['NO_CONT'];
					$data['lokasikontainer']=$this->input->post('lokak');
					$data['nomerkontainer']=$this->input->post('nocont');
					$data['jobs']=$this->input->post('jobs');
					$data['nilai']=$this->getalljobsyard();
					$this->content = $this->load->view('content/dashboard/marshallingyard',$data,true);
					$this->index();
				}else{
					$this->db->where('ID_JOB_SLIP',$inp2);
					$this->db->update('t_job_slip', array('STATUS'=>'DONE', 'STATUS_JOB' => 'Y', 'KD_STATUS' =>50, 'OPERATOR' => $oopp, 'WK_STATUS' => $wkt));
					//$this->db->query("UPDATE t_job_slip SET STATUS='DONE',STATUS_JOB='Y', KD_STATUS='50','OPERATOR'='$oopp', WK_STATUS='$wkt' WHERE ID_JOB_SLIP='$inp2' ");
					//update t_denah
					if(substr($lokaw,0,3)==="CIC" || substr($lokaw,0,3)==="cic"){
						$varlokasi2=substr($lokaw,0,5);
						$vartier2=substr($lokaw,-1);
						$this->db->where(array('NM_BLOK' => $varlokasi2, 'LEVEL_4' =>$vartier2));
						$this->db->update('t_denah_lapangan', array('USE'=>'0'));
					}else{
						$van3=substr($lokaw,0,6);
						$tierr=substr($lokaw,-1);
						$this->db->where(array('NM_BLOK' => $van3, 'LEVEL_4' =>$tierr));
						$this->db->update('t_denah_lapangan', array('USE'=>'0'));
					}
					$this->db->where(array('NM_BLOK' => $varlokasi, 'LEVEL_4' =>$vartier));
					$this->db->update('t_denah_lapangan', array('USE'=>'1'));
					$this->ubahlok2($inp,$varlokasi,$vartier,"460",$spid);
					$arrdata = array(
								'NO_SPK'=>$spk1,
								'OPERATOR' => $this->session->userdata('USERLOGIN'),
								'TGL_SPK'=>$tglspk,
								'NO_CONT'=>$nock,
								'NO_GATEPASS'=>$nogat,
								'LOKASI_AWAL'=>$lokasiaw,
								'TIER_AWAL'=>$tieraw,
								'TGL_GATEPASS'=>$tglg,
								'STATUS'=>'WAITING'
					);
					$this->db->insert('t_job_slip',$arrdata); 
					//insert ke t_operation ketika submit ke cic
					$arrmarshalling = array(
								'ID_SPK'=>$spid,
								'NO_CONT'=> $nock,
								'KD_STATUS'=> '460',
								'WK_STATUS'=> date('Y-m-d H:i:s'),
								'OPERATOR'=> $this->session->userdata('USERLOGIN')
					);
					$this->db->insert('t_operation_new',$arrmarshalling); 
					$data['notif']=1;
					$data['lokasikontainer']=$this->input->post('lokak');
					$data['nomerkontainer']=$this->input->post('nocont');
					$data['jobs']=$this->input->post('jobs');
					$data['nilai']=$this->getalljobsyard();
					$this->content = $this->load->view('content/dashboard/marshallingyard',$data,true);
					$this->index();
				}
			}else if(substr($lok,0,2)=="1A" || substr($lok,0,2)=="1a" || substr($lok,0,2)=="YA"){
				if($hasillokasi['LOKASI']==$datalokasi){
				$data['notif']=4;
				$data['nokont']=$hasillokasi['NO_CONT'];
				$data['lokasikontainer']=$this->input->post('lokak');
				$data['nomerkontainer']=$this->input->post('nocont');
				$data['jobs']=$this->input->post('jobs');
				$data['nilai']=$this->getalljobsyard();
				$this->content = $this->load->view('content/dashboard/marshallingyard',$data,true);
				$this->index();
				}else{
					if ($denahlokasi['NM_BLOK']==$datalokasi){
						$this->db->where('ID_JOB_SLIP',$inp2);
						$this->db->update('t_job_slip', array('STATUS'=>'DONE','STATUS_JOB' => 'Y','KD_STATUS' =>50,'OPERATOR' => $oopp,'WK_STATUS' => $wkt));
						//$this->db->query("UPDATE t_job_slip SET STATUS='DONE',STATUS_JOB='Y',KD_STATUS='50', 'OPERATOR'='$oopp', WK_STATUS='$wkt' WHERE ID_JOB_SLIP='$inp2' ");
						$van2=substr($lok,0,6);
						$tie=substr($lok,-1);
						$this->ubahlok2($inp,$van2,$tie,"450",$spid);
						//update t_denah_lapangan
						if(substr($lokaw,0,3)==="CIC" || substr($lokaw,0,3)==="cic" ){
							$varlokasi2=substr($lokaw,0,5);
							$vartier2=substr($lokaw,-1);
							$this->db->where(array('NM_BLOK' => $varlokasi2, 'LEVEL_4' =>$vartier2));
							$this->db->update('t_denah_lapangan', array('USE'=>'0'));
						}else{
							$van3=substr($lokaw,0,6);
							$tierr=substr($lokaw,-1);
							$this->db->where(array('NM_BLOK' => $van3, 'LEVEL_4' =>$tierr));
							$this->db->update('t_denah_lapangan', array('USE'=>'0'));
						}
						$this->db->where(array('NM_BLOK' => $van2, 'LEVEL_4' =>$tie));
						$this->db->update('t_denah_lapangan', array('USE'=>'1'));
						$arrdata = array(
									'OPERATOR' => $this->session->userdata('USERLOGIN'),
									'NO_SPK'=>$spk1,
									'TGL_SPK'=>$tglspk,
									'NO_CONT'=>$nock,
									'LOKASI_AWAL'=>$van2,
									'TIER_AWAL'=>$tie,
									'STATUS'=>'WAITING'
						);
						$this->db->insert('t_job_slip',$arrdata);
						//update set status gatepass jadi done
						if($jenisjob2=='EX BEHANDLE 1' || $jenisjob2=='EX BEHANDLE 2'){
							$this->db->where('ID',$nogat);
							$this->db->update('t_gatepass', array('STATUS'=>'DONE'));
						}	
						$data['notif']=1;
						$data['lokasikontainer']=$this->input->post('lokak');
						$data['nomerkontainer']=$this->input->post('nocont');
						$data['jobs']=$this->input->post('jobs');
						$data['nilai']=$this->getalljobsyard();
						$this->content = $this->load->view('content/dashboard/marshallingyard',$data,true);
						$this->index();
					}else{
						$data['notif']=3;
						$data['NOTIER']=$datatier;
						$data['lokasikontainer']=$this->input->post('lokak');
						$data['nomerkontainer']=$this->input->post('nocont');
						$data['jobs']=$this->input->post('jobs');
						$data['nilai']=$this->getalljobsyard();
						$this->content = $this->load->view('content/dashboard/marshallingyard',$data,true);
						$this->index();
					}
				}  
			}else{
				if($hasillokasi['LOKASI']==$datalokasi){
					$data['notif']=4;
					$data['nokont']=$hasillokasi['NO_CONT'];
					$data['lokasikontainer']=$this->input->post('lokak');
					$data['nomerkontainer']=$this->input->post('nocont');
					$data['jobs']=$this->input->post('jobs');
					$data['nilai']=$this->getalljobsyard();
					$this->content = $this->load->view('content/dashboard/marshallingyard',$data,true);
					$this->index();
				}else{
					if ($denahlokasi['NM_BLOK']==$datalokasi){
						$this->db->where('ID_JOB_SLIP',$inp2);
						$this->db->update('t_job_slip', array('STATUS'=>'DONE','STATUS_JOB' => 'Y','KD_STATUS' =>50,'OPERATOR' => $oopp,'WK_STATUS' => $wkt));
						//$this->db->query("UPDATE t_job_slip SET STATUS='DONE',STATUS_JOB='Y', KD_STATUS='50','OPERATOR'='$oopp', WK_STATUS='$wkt' WHERE ID_JOB_SLIP='$inp2' ");
						$van2=substr($lok,0,6);
						$tie=substr($lok,-1);
						$this->ubahlok2($inp,$van2,$tie,"450",$spid);
						//update t_denah_lapangan
						if(substr($lokaw,0,3)==="CIC" || substr($lokaw,0,3)==="cic" ){
							$varlokasi2=substr($lokaw,0,5);
							$vartier2=substr($lokaw,-1);
							$this->db->where(array('NM_BLOK' => $varlokasi2, 'LEVEL_4' =>$vartier2));
							$this->db->update('t_denah_lapangan', array('USE'=>'0'));
						}else{
							$van3=substr($lokaw,0,6);
							$tierr=substr($lokaw,-1);
							$this->db->where(array('NM_BLOK' => $van3, 'LEVEL_4' =>$tierr));
							$this->db->update('t_denah_lapangan', array('USE'=>'0'));
						}
						$this->db->where(array('NM_BLOK' => $van2, 'LEVEL_4' =>$tie));
						$this->db->update('t_denah_lapangan', array('USE'=>'1'));
						$arrdata = array(
									'OPERATOR' => $this->session->userdata('USERLOGIN'),
									'NO_SPK'=>$spk1,
									'TGL_SPK'=>$tglspk,
									'NO_CONT'=>$nock,
									'NO_GATEPASS'=>$nogat,
									'LOKASI_AWAL'=>$van2,
									'TIER_AWAL'=>$tie,
									'TGL_GATEPASS'=>$tglg,
									'STATUS'=>'WAITING'
						);
						$this->db->insert('t_job_slip',$arrdata);
						//update set status gatepass jadi done
						if($jenisjob2=='EX BEHANDLE 1' || $jenisjob2=='EX BEHANDLE 2'){
							$this->db->where('ID',$nogat);
							$this->db->update('t_gatepass', array('STATUS'=>'DONE'));
						}	
						$data['notif']=1;
						$data['lokasikontainer']=$this->input->post('lokak');
						$data['nomerkontainer']=$this->input->post('nocont');
						$data['jobs']=$this->input->post('jobs');
						$data['nilai']=$this->getalljobsyard();
						$this->content = $this->load->view('content/dashboard/marshallingyard',$data,true);
						$this->index();
					}else{
						$data['notif']=3;
						$data['NOTIER']=$datatier;
						$data['lokasikontainer']=$this->input->post('lokak');
						$data['nomerkontainer']=$this->input->post('nocont');
						$data['jobs']=$this->input->post('jobs');
						$data['nilai']=$this->getalljobsyard();
						$this->content = $this->load->view('content/dashboard/marshallingyard',$data,true);
						$this->index();
					}			
				}  
			}
		}	
	}

	public function set_pemeriksaan(){
		$NO_CONT = $this->input->post('nomerkon');
		$NO_SEAL = $this->input->post('noseal');
		$JOIN = $this->input->post('join');

		$SQL_SPK_CONT    = $this->db->query("SELECT A.*, B.* FROM t_spk_cont A INNER JOIN t_spk B ON A.ID = B.ID WHERE A.NO_CONT ='".$NO_CONT."' AND A.STATUS_CONT = '460' ORDER BY A.ID DESC")->row_array();

		$SQL_PEMERIKSAAN = $this->db->query("SELECT * FROM t_op_inspection WHERE NO_CONT = '".$NO_CONT."' AND STATUS = 'WAITING' ORDER BY ID DESC LIMIT 1")->result_array();

		$SQL_KODE_DOK	 = $this->db->query("SELECT * FROM reff_kode_dok_bc WHERE ID='".$SQL_SPK_CONT['JNS_DOK']."'")->row_array();
		
		$SQL_JOBSLIP = $this->db->query("SELECT * FROM t_job_slip WHERE NO_CONT = '".$NO_CONT."' AND NO_SPK = '".$SQL_SPK_CONT['NO_SPK']."' ORDER BY ID_JOB_SLIP DESC LIMIT 1")->row_array();

		$SQL_GATEPASS 	 = $this->db->query("SELECT * FROM t_gatepass WHERE NO_CONT ='".$NO_CONT."' AND NO_DOK = '".$SQL_JOBSLIP['NO_DOK']."' AND JNS_KEGIATAN IN('1','2') ORDER BY ID DESC LIMIT 1")->row_array();


		if($SQL_SPK_CONT['NO_CONT'] == $NO_CONT){
			if($SQL_SPK_CONT['STATUS_CONT'] == '460'){
				if(count($SQL_PEMERIKSAAN) == 0){
					/* START INSPECTION */
					$startinsp= array(
						'NO_CONT' 		 => $NO_CONT,
						'OPERATOR_START' => $this->session->userdata('USERLOGIN'),
						'LOKASI' 		 => $SQL_SPK_CONT['LOKASI'].'0'.$SQL_SPK_CONT['TIER'],
						'JNS_KEGIATAN' 	 => $SQL_GATEPASS['JNS_KEGIATAN'],
						'NO_DOK' 		 => $SQL_GATEPASS['NO_DOK'],
						'JNS_DOK' 		 => $SQL_GATEPASS['JNS_DOK'],
						'TGL_DOK' 		 => $SQL_GATEPASS['TGL_DOK'],
						'NO_SPK' 		 => $SQL_SPK_CONT['NO_SPK'],
						'START_INSP' 	 => date('Y-m-d H:i:s')
					);
					$this->db->insert('t_op_inspection',$startinsp);

					/* UPDATE TABEL OPERATION */
					$this->db->where(array('NO_CONT' => $NO_CONT, 'NO_SPK' =>  $SQL_SPK_CONT['NO_SPK']));
					$this->db->update('t_operation',array('WK_START' => date('Y-m-d H:i:s')));

					if ($SQL_GATEPASS['JNS_KEGIATAN'] == '1') {
						$SQLReport = $this->db->query("SELECT * FROM report_behandle WHERE NO_CONT='".$NO_CONT."' AND RB1_NO_SPK = '".$SQL_SPK_CONT['NO_SPK']."' ORDER BY ID DESC")->result_array();
						if (count($SQLReport) > 0) {
							$updateReport = array(
								'NO_CONT' 			=> $NO_CONT,
								'PB1_START_PERIKSA'=> date('Y-m-d H:i:s')
							);
							$this->db->where(array('ID' => $SQLReport[0]['ID'], 'NO_CONT' => $NO_CONT, 'RB1_NO_SPK' => $SQL_SPK_CONT['NO_SPK']));
							$this->db->update('report_behandle', $updateReport);
						}
					}else{
						$SQLReport = $this->db->query("SELECT * FROM report_behandle WHERE NO_CONT='".$NO_CONT."' AND RB1_NO_SPK = '".$SQL_SPK_CONT['NO_SPK']."' ORDER BY ID DESC")->result_array();
						if (count($SQLReport) > 0) {
							$updateReport = array(
								'NO_CONT' 			=> $NO_CONT,
								'PB2_START_PERIKSA'=> date('Y-m-d H:i:s')
							);
							$this->db->where(array('ID' => $SQLReport[0]['ID'], 'NO_CONT' => $NO_CONT, 'RB1_NO_SPK' => $SQL_SPK_CONT['NO_SPK']));
							$this->db->update('report_behandle', $updateReport);
						}
					}

					$data['notif']	= 1;
					$data['NOCONT']	= $NO_CONT;
					$this->content 	= $this->load->view('content/dashboard/realisasibi',$data,true);
					$this->index();
				}else{
					/* FINISH INSPECTION */
					$finishinsp= array(
						'NO_SEAL' 			=> $NO_SEAL,
						'OPERATOR_FINISH' 	=> $this->session->userdata('USERLOGIN'),
						'STATUS' 			=> 'DONE',
						'FINISH_INSP' 		=> date('Y-m-d H:i:s')
					);

					$this->db->where(array('NO_CONT' => $NO_CONT, 'NO_SPK' => $SQL_SPK_CONT['NO_SPK'], 'STATUS' => 'WAITING'));
					$this->db->update('t_op_inspection',$finishinsp);	

					/* UPDATE TABEL OPERATION */
					$this->db->where(array('NO_CONT' => $NO_CONT, 'NO_SPK' =>  $SQL_SPK_CONT['NO_SPK']));
					$this->db->update('t_operation',array('NO_SEAL' => $NO_SEAL,'WK_FINISH' => date('Y-m-d H:i:s')));

					/* UPDATE TABEL SPK & SPK CONT */
					if ($JOIN == 0) {
						$this->db->where(array('NO_CONT' => $NO_CONT, 'ID' =>  $SQL_SPK_CONT['ID']));
						$this->db->update('t_spk_cont',array('NO_SEAL' => $NO_SEAL,'STATUS_CONT' => '500'));
						$this->db->where(array('ID' =>  $SQL_SPK_CONT['ID'], 'NO_SPK' =>$SQL_SPK_CONT['NO_SPK']));
						$this->db->update('t_spk',array('KD_STATUS' => '500'));
					}
					/* UPDATE JOB SLIP */
					if($SQL_GATEPASS['JNS_KEGIATAN'] == '1'){
						$dataJobslip= array(
							'JNS_JOB_SLIP' => 'MARSHALLING',
							'JENIS' => 'EX BEHANDLE 1',
							'JNS_DOK'=> $SQL_GATEPASS['JNS_DOK'],
							'KD_STATUS' => '20'
						);	
					}else if($SQL_GATEPASS['JNS_KEGIATAN'] == '2'){
						$dataJobslip= array(
							'JNS_JOB_SLIP' => 'MARSHALLING',
							'JENIS' => 'EX BEHANDLE 2',
							'JNS_DOK'=> $SQL_GATEPASS['JNS_DOK'],
							'KD_STATUS' => '20'
						);	
					}
					$this->db->where(array('NO_CONT' => $NO_CONT, 'NO_SPK' => $SQL_SPK_CONT['NO_SPK'], 'ID_JOB_SLIP' => $SQL_JOBSLIP['ID_JOB_SLIP'], 'STATUS' => 'WAITING'));
					$this->db->update('t_job_slip', $dataJobslip);

					if ($SQL_GATEPASS['JNS_KEGIATAN'] == '1') {
						$SQLReport = $this->db->query("SELECT * FROM report_behandle WHERE NO_CONT='".$NO_CONT."' AND RB1_NO_SPK = '".$SQL_SPK_CONT['NO_SPK']."' ORDER BY ID DESC")->result_array();
						if (count($SQLReport) > 0) {
							$updateReport = array(
								'NO_CONT' 			=> $NO_CONT,
								'PB2_FINISH_PERIKSA'=> date('Y-m-d H:i:s'),
								'PB2_NEW_NO_SEAL'=> $NO_SEAL
							);
							$this->db->where(array('ID' => $SQLReport[0]['ID'], 'NO_CONT' => $NO_CONT, 'RB1_NO_SPK' => $SQL_SPK_CONT['NO_SPK']));
							$this->db->update('report_behandle', $updateReport);
						}
					}else{
						$SQLReport = $this->db->query("SELECT * FROM report_behandle WHERE NO_CONT='".$NO_CONT."' AND RB1_NO_SPK = '".$SQL_SPK_CONT['NO_SPK']."' ORDER BY ID DESC")->result_array();
						if (count($SQLReport) > 0) {
							$updateReport = array(
								'NO_CONT' 			=> $NO_CONT,
								'PB2_FINISH_PERIKSA'=> date('Y-m-d H:i:s'),
								'PB2_NEW_NO_SEAL'=> $NO_SEAL
							);
							$this->db->where(array('ID' => $SQLReport[0]['ID'], 'NO_CONT' => $NO_CONT, 'RB1_NO_SPK' => $SQL_SPK_CONT['NO_SPK']));
							$this->db->update('report_behandle', $updateReport);
						}
					}

					if ($JOIN == 1) {
						$userlg = $this->session->userdata('USERLOGIN');
						$lokawal1 = $SQL_JOBSLIP['LOKASI_AWAL'];
						$posawal1 = $SQL_JOBSLIP['TIER_AWAL'];
						$dokb1 = $SQL_GATEPASS['NO_DOK'];
						$datejob1 = $SQL_JOBSLIP['TGL_SPK'];
						$datedump = date('Y-m-d H:i:s');
						$no_spk = $SQL_SPK_CONT['NO_SPK'];
						$this->db->query("UPDATE `t_job_slip` SET `LOKASI_AKHIR`='1AJOIN', `TIER_AKHIR`='1', `STATUS`='DONE', `KD_STATUS`='50', `STATUS_JOB`='Y' WHERE no_dok = '$dokb1' and no_cont = '$NO_CONT' and status = 'WAITING' ");
						$this->db->query("UPDATE `t_gatepass` SET `STATUS`='DONE' WHERE no_dok = '$dokb1' and no_cont = '$NO_CONT' and status = 'WAITING' ");
						
						//$gatepas_dulu = $this->db->query("");
						$dok_b2 = $this->db->query("SELECT bb.* FROM (
							SELECT a.ID_IJIN,a.NO_RESPON,a.TG_RESPON,b.NO_CONT,a.LNSW_NOAJU FROM t_ppk_hdr a JOIN t_ppk_cont b ON a.ID_IJIN = b.ID_IJIN WHERE a.LNSW_KD_RESPON = '005') aa
						JOIN (
							SELECT a.ID,a.NO_DAFTAR_PABEAN,a.TGL_DAFTAR_PABEAN,b.NO_CONT,a.LNSW_NOAJU FROM t_permit_hdr a JOIN t_permit_cont b ON a.ID = b.ID WHERE a.LNSW_KD_RESPON = '005') bb
						ON aa.lnsw_noaju = bb.lnsw_noaju AND aa.NO_CONT = bb.NO_CONT
						JOIN (
							SELECT a.kd_req,a.response_req,a.no_dok,a.tgl_dok,b.NO_CONT from t_request a JOIN t_request_cont b ON a.id = b.id) cc ON aa.NO_RESPON = cc.no_dok AND aa.TG_RESPON = cc.tgl_dok AND aa.NO_CONT = cc.NO_CONT
						WHERE aa.no_cont = '$NO_CONT' AND aa.NO_RESPON = '$dokb1'")->row();

						$data = array(
							'NO_CONT' => $NO_CONT,
							'NO_DOK' => $dok_b2->NO_DAFTAR_PABEAN,
							'JNS_DOK' => 'SPJM',
							'NM_KAPAL' => $SQL_GATEPASS['NM_KAPAL'],
							'TGL_DOK' => $dok_b2->TGL_DAFTAR_PABEAN,
							'NAMA_CUST' => $SQL_GATEPASS['NAMA_CUST'],
							'NO_VOY' => $SQL_GATEPASS['NO_VOY'],
							'NPWP' => $SQL_GATEPASS['NPWP'],
							'UKR_CONT' => $SQL_GATEPASS['UKR_CONT'],
							'RESPON' => $SQL_GATEPASS['RESPON'],
							'WK_RESPON' => $SQL_GATEPASS['WK_RESPON']
						);

						$this->buatb2join($data,$dokb1);
						$idjobslip2 = $this->db->query("SELECT ID from t_gatepass where no_dok = '$dok_b2->NO_DAFTAR_PABEAN' and tgl_dok = '$dok_b2->TGL_DAFTAR_PABEAN' and status = 'WAITING'")->row();
						$this->db->query("INSERT INTO `t_job_slip` (`JNS_JOB_SLIP`, `JENIS`, `NO_SPK`, `TGL_SPK`, `JNS_DOK`, `NO_DOK`, `NO_CONT`, `NO_GATEPASS`, `TGL_GATEPASS`, `LOKASI_AWAL`, `TIER_AWAL`, `LOKASI_AKHIR`, `TIER_AKHIR`, `STATUS`, `KD_STATUS`, `NOTE`, `WK_STATUS`, `OPERATOR`, `STATUS_JOB`) VALUES ('MARSHALING', 'BEHANDLE 2', '$no_spk', '$datejob1', 'SPPMP', '$dok_b2->NO_DAFTAR_PABEAN', '$NO_CONT', '$idjobslip2->ID', '$dok_b2->TGL_DAFTAR_PABEAN', '1AJOIN', '1', '$lokawal1', '$posawal1', 'DONE', '50', NULL, '$datedump', '$userlg', 'Y')");
						$this->db->query("INSERT INTO `t_job_slip` (`JNS_JOB_SLIP`, `JENIS`, `NO_SPK`, `TGL_SPK`, `JNS_DOK`, `NO_DOK`, `NO_CONT`, `NO_GATEPASS`, `TGL_GATEPASS`, `LOKASI_AWAL`, `TIER_AWAL`, `LOKASI_AKHIR`, `TIER_AKHIR`, `STATUS`, `KD_STATUS`, `NOTE`, `WK_STATUS`, `OPERATOR`, `STATUS_JOB`) VALUES (NULL, NULL, '$no_spk', '$datejob1', 'SPPMP', '$dok_b2->NO_DAFTAR_PABEAN', '$NO_CONT', '$idjobslip2->ID', '$dok_b2->TGL_DAFTAR_PABEAN', '$lokawal1', '$posawal1', NULL, NULL, 'WAITING', '20', NULL, '$datedump', '$userlg', 'N')");
					}
					$data['notif']	= 2;
					$data['NOCONT']	= $NO_CONT;
					$this->content 	= $this->load->view('content/dashboard/realisasibi',$data,true);
					$this->index();
				}
			}else{
				$data['notif']  = 5;
				$data['NOCONT'] = $NO_CONT;
				$this->content  = $this->load->view('content/dashboard/realisasibi',$data,true);
				$this->index();
			}
		}else{
			$data['notif']  = 6;
			$data['NOCONT'] = $NO_CONT;
			$this->content  = $this->load->view('content/dashboard/realisasibi',$data,true);
			$this->index();
		}
	}
	public function buatb2join($DATA,$DOK1)
	{
		$SQLGATEPASS = $this->db->query("SELECT * FROM t_gatepass WHERE NO_CONT ='".$DATA['NO_CONT']."' AND NO_DOK LIKE '%".$DATA['NO_DOK']."%' AND JNS_KEGIATAN ='2' ORDER BY ID DESC LIMIT 1")->result_array();
		//$SQLSPK 	 = $this->db->query("SELECT A.*, B.* FROM t_spk A INNER JOIN t_spk_cont B ON A.ID = B.ID WHERE B.NO_CONT ='".$DATA['NO_CONT']."' AND B.STATUS_CONT ='450' ORDER BY A.ID DESC LIMIT 1")->result_array();

		$SQL_JOBSLIP = $this->db->query("SELECT * FROM t_job_slip WHERE NO_CONT ='".$DATA['NO_CONT']."' AND JNS_JOB_SLIP IS NULL AND JENIS IS NULL AND LOKASI_AKHIR IS NULL AND STATUS ='WAITING' ORDER BY ID_JOB_SLIP DESC LIMIT 1")->result_array();

		if(count($SQLGATEPASS) == 0){
			if (true) {
				$DOK1 = $this->input->post('DOK');
				$this->db->where(array('NO_DOK' => $DOK1,'JNS_KEGIATAN' => '1','NO_CONT' => $DATA['NO_CONT']));
				$this->db->update('t_gatepass', array('FL_USE' => 'Y'));

				/* INSERT GATEPASS NEW */
				$gatepass['NO_DOK'] 		= trim($DATA['NO_DOK']);
				$gatepass['JNS_DOK'] 		= $DATA['JNS_DOK'];
				$gatepass['NO_CONT'] 		= $DATA['NO_CONT'];
				$gatepass['NM_KAPAL'] 		= $DATA['NM_KAPAL'];
				$gatepass['TGL_DOK'] 		= date('Y-m-d',strtotime($DATA['TGL_DOK']));
				$gatepass['NAMA_CUST'] 		= $DATA['NAMA_CUST'];
				$gatepass['NO_VOY'] 		= $DATA['NO_VOY'];
				$gatepass['NPWP'] 			= $DATA['NPWP'];
				$gatepass['JNS_KEGIATAN'] 	= '2';
				$gatepass['UKR_CONT'] 		= $DATA['UKR_CONT'];
				$gatepass['WK_REK'] 		= date('Y-m-d H:i:s');
				$gatepass['FL_USE'] 		= 'N';
				$gatepass['FL_ACTIVE'] 		= 'Y';
				$gatepass['RESPON'] 		= $DATA['RESPON'];
				$gatepass['WK_RESPON'] 		= $DATA['WK_RESPON'];
				$this->db->insert('t_gatepass', $gatepass);
				$idGatepass = $this->db->insert_id();

				$SQLReport = $this->db->query("SELECT * FROM report_behandle WHERE NO_CONT='".$DATA['NO_CONT']."' AND REQ_NO_DOK='".$DOK1."' ORDER BY ID DESC")->result_array();
				if (count($SQLReport) > 0) {
					$updateReport = array(
						'NO_CONT' 		=> $DATA['NO_CONT'],
						'RB2_JNS_DOK' 	=> $DATA['JNS_DOK'],
						'RB2_NO_DOK' 	=> $DATA['NO_DOK'],
						'RB2_TGL_DOK' 	=> $DATA['TGL_DOK'],
						'RB2_GATEPASS_B2' => date('Y-m-d H:i:s')
					);
					$this->db->where(array('ID' => $SQLReport[0]['ID'], 'NO_CONT' => $DATA['NO_CONT'], 'REQ_NO_DOK' => $DATA['NO_DOK']));
					$this->db->update('report_behandle', $updateReport);
				}
			}
		}else{
			$message = "GATEPASS SUDAH ADA";
			echo "MSG#ERR#".$message."#";
		}
	}

	public function set_realisasibi(){
		$this->load->helper('url');
		//variabel
		$inputan2= $this->input->post('nomerkon');
		$datseal= $this->input->post('noseal');
		$query2=$this->cek_tspkcontst($inputan2);
		$querysql=$this->statusnya($inputan2);
		$kodedok='';
		$edd=$query2['ID'];
		$query3=$this->cek_tspk2($query2['ID']);
		$spkk=$query3['NO_SPK'];
		$counn=$this->ambiljumspkreal($query2['ID']);
		$coun2=count($counn);
		//  echo $coun2;die();
			$dok=$this->db->query("SELECT ID FROM t_op_inspection WHERE NO_CONT='$inputan2' AND NO_SPK='$spkk'")->result_array();
				if (count($dok)==0) {
					$vardok=$this->db->query("SELECT NO_DOK, JNS_DOK, TGL_DOK FROM t_spk WHERE ID='$edd' AND NO_SPK='$spkk' ")->row_array();
					if($vardok['JNS_DOK']=='83'){
						$kodedok="SPPMP";
					}elseif($vardok['JNS_DOK']=='19'){
						$kodedok="SPJM";
					}elseif($vardok['JNS_DOK']=='81'){
						$kodedok="NHI";
					}elseif($vardok['JNS_DOK']=='82'){
						$kodedok="NOTA";
					}
				}else{
					$nogatepass=$this->db->query("SELECT NO_GATEPASS FROM t_job_slip WHERE NO_CONT='$inputan2' AND STATUS='WAITING'")->row_array();
					$kunci=$nogatepass['NO_GATEPASS'];
					$vardok=$this->db->query("SELECT NO_DOK, JNS_DOK, TGL_DOK FROM t_gatepass WHERE ID='$kunci'")->row_array();
					$kodedok=$vardok['JNS_DOK'];
				}
				//print_r($vardok); die();
			//mengambil jenis kegiatan
				//$idgatepass = $nogatepass['NO_GATEPASS'];
				$ano = $vardok['NO_DOK'];
				$ajns = $kodedok;
				$atgl = $vardok['TGL_DOK'];
				$datakegiatan=$this->db->query("SELECT JNS_KEGIATAN FROM t_gatepass WHERE NO_CONT='$inputan2' AND JNS_DOK LIKE'%$ajns%' AND NO_DOK='$ano' AND TGL_DOK='$atgl' AND JNS_KEGIATAN IS NOT NULL")->row_array();
			//print_r($datakegiatan); die();	
		$dsi= array(
				'WK_START' => date('Y-m-d H:i:s')
			);
		$dsi2= array(
				'NO_SEAL' => $datseal,
				'WK_FINISH' => date('Y-m-d H:i:s')
			);
		$keyy= array(
				'NO_CONT' => $inputan2,
				'NO_SPK' => $spkk
			);
		$key2= array(
				'STATUS' => 'WAITING',
				'NO_CONT' => $inputan2
			);	
		$noseal=$this->input->post('noseal');
		if ($query2['NO_CONT'] == $inputan2 ) {
			if ( $query2['STATUS_CONT']=='460') {
				//save
					if ($querysql['START_INSP']==NULL) {//ketika start
						$dsimpan= array(
							'NO_CONT' => $inputan2,
							'OPERATOR_START' => $this->session->userdata('USERLOGIN'),
							'LOKASI' => $query2['LOKASI'].'0'.$query2['TIER'],
							'JNS_KEGIATAN' => $datakegiatan['JNS_KEGIATAN'],
							'NO_DOK' => $vardok['NO_DOK'],
							'JNS_DOK' => $kodedok,
							'TGL_DOK' => $vardok['TGL_DOK'],
							'NO_SPK' => $spkk,
							'START_INSP' => date('Y-m-d H:i:s')
						);
						$this->db->insert('t_op_inspection',$dsimpan);
						$this->db->where($keyy);
						$this->db->update('t_operation',$dsi);
						$data['notif']=1;
						$data['NOCONT']=$inputan2;
						$this->content = $this->load->view('content/dashboard/realisasibi',$data,true);
						$this->index();
					}else {//ketika finish
							$dsimpan2= array(
								'NO_SEAL' => $this->input->post('noseal'),
								'OPERATOR_FINISH' => $this->session->userdata('USERLOGIN'),
								'STATUS' =>'DONE',
								'FINISH_INSP' => date('Y-m-d H:i:s')
							);

							if ($datakegiatan['JNS_KEGIATAN']=='1') {
								$dataubahjobslip= array(
									'JNS_JOB_SLIP' => 'MARSHALLING',
									'JENIS' => 'EX BEHANDLE 1',
									'JNS_DOK'=> $ajns,
									'KD_STATUS' => '20'
								);									
							}elseif ($datakegiatan['JNS_KEGIATAN']=='2') {
								$dataubahjobslip= array(
									'JNS_JOB_SLIP' => 'MARSHALLING',
									'JENIS' => 'EX BEHANDLE 2',
									'JNS_DOK'=> $ajns,
									'KD_STATUS' => '20'
								);									
							}else{
								$dataubahjobslip= array(
									'JNS_JOB_SLIP' => 'MARSHALLING'
								);									
							}
							
							$this->db->where(array('NO_CONT' => $inputan2, 'STATUS' => 'WAITING', 'NO_SPK' => $spkk));
							$this->db->update('t_job_slip', $dataubahjobslip );
							
							$this->after_realisasi($inputan2,$coun2,$query2['ID'],$noseal);
							
							$this->db->where($keyy);
							$this->db->update('t_operation',$dsi2);
							
							$this->db->where($key2);
							$this->db->update('t_op_inspection',$dsimpan2);									
							
						$data['notif']=2;
						$data['NOCONT']=$inputan2;
						$this->content = $this->load->view('content/dashboard/realisasibi',$data,true);
						$this->index();
					}
				}else {//not ready
						$data['notif']=6;
						$data['NOCONT']=$inputan2;
						$this->content = $this->load->view('content/dashboard/realisasibi',$data,true);
						$this->index();
				}
		}else {
				//not found no cont
					$data['notif']=6;
					$data['NOCONT']=$inputan2;
					$this->content = $this->load->view('content/dashboard/realisasibi',$data,true);
					$this->index();
		}
	}

	public function ambilmarshcic($keyword){
		$SQL = "SELECT DISTINCT A.ID_JOB_SLIP,A.NO_CONT,C.UKR_CONT,A.LOKASI_AWAL,A.LOKASI_AKHIR,A.TIER_AWAL,A.TIER_AKHIR,A.JENIS,D.RESPON
				FROM t_job_slip A
				INNER JOIN t_spk B ON A.NO_SPK = B.NO_SPK
				INNER JOIN t_spk_cont C ON B.ID = C.ID
				INNER JOIN t_gatepass D ON A.NO_GATEPASS = D.ID
				WHERE A.NO_CONT like'%$keyword%' AND A.STATUS = 'WAITING' AND A.KD_STATUS='20' AND A.LOKASI_AKHIR LIKE 'CIC%'
				AND C.STATUS_CONT != 900 AND D.FL_ACTIVE = 'Y' AND A.JENIS IN('BEHANDLE 1','BEHANDLE 2')
				GROUP BY A.NO_CONT
				ORDER BY A.ID_JOB_SLIP DESC";
		$queryspk = $this->db->query($SQL);
		return $queryspk->result_array();
	}

	public function ambilmarshyard($keyword){
		$SQL = "SELECT DISTINCT A.ID_JOB_SLIP,A.NO_CONT,C.UKR_CONT,A.LOKASI_AWAL,A.LOKASI_AKHIR,A.TIER_AWAL,A.TIER_AKHIR,A.JENIS
			FROM t_job_slip A
			INNER JOIN t_spk B ON A.NO_SPK = B.NO_SPK
			INNER JOIN t_gatepass C ON A.NO_GATEPASS = C.ID
			WHERE A.NO_CONT like'%$keyword%' AND A.STATUS = 'WAITING' AND A.KD_STATUS='20' AND A.LOKASI_AKHIR LIKE '1A%'
			AND C.FL_ACTIVE = 'Y' AND A.JENIS IN('EX BEHANDLE 1','EX BEHANDLE 2')
			GROUP BY A.NO_CONT
			ORDER BY A.ID_JOB_SLIP DESC";
		$queryspk = $this->db->query($SQL);
		return $queryspk->result_array();
	}
	
	public function getalljobscic(){
		$var='CIC';
		$SQL = "SELECT DISTINCT A.ID_JOB_SLIP,A.NO_CONT,C.UKR_CONT,A.LOKASI_AWAL,A.LOKASI_AKHIR,A.TIER_AWAL,A.TIER_AKHIR,A.JENIS,D.RESPON,E.LNSW_NOAJU
		FROM t_job_slip A
		INNER JOIN t_spk B ON A.NO_SPK = B.NO_SPK
		INNER JOIN t_spk_cont C ON B.ID = C.ID
		INNER JOIN t_gatepass D ON A.NO_GATEPASS = D.ID
		LEFT JOIN (SELECT * FROM t_ppk_hdr WHERE LNSW_KD_RESPON = '005') E ON D.NO_DOK = E.NO_RESPON AND D.TGL_DOK = E.TG_RESPON
		WHERE A.STATUS = 'WAITING' AND A.KD_STATUS='20' AND A.LOKASI_AKHIR LIKE 'CIC%'
			AND C.STATUS_CONT != 900 AND D.FL_ACTIVE = 'Y' AND A.JENIS IN('BEHANDLE 1','BEHANDLE 2')
		GROUP BY A.NO_CONT
		ORDER BY A.ID_JOB_SLIP DESC";
			$queryspk = $this->db->query($SQL);
			//$queryspk=$this->db->query("select * from t_job_slip where STATUS='WAITING' AND KD_STATUS='20' AND LOKASI_AKHIR IS NOT NULL AND LOKASI_AWAL IS NOT NULL ORDER BY LOKASI_AKHIR LIMIT 10 ");
			return $queryspk->result_array();
	}

	public function getalljobsyard(){
		$var='CIC';
		$SQL = "SELECT DISTINCT A.ID_JOB_SLIP,A.NO_CONT,C.UKR_CONT,A.LOKASI_AWAL,A.LOKASI_AKHIR,A.TIER_AWAL,A.TIER_AKHIR,A.JENIS
			FROM t_job_slip A
			INNER JOIN t_spk B ON A.NO_SPK = B.NO_SPK
			INNER JOIN t_gatepass C ON A.NO_GATEPASS = C.ID
			WHERE A.STATUS = 'WAITING' AND A.KD_STATUS='20' AND A.LOKASI_AKHIR LIKE '1A%'
			AND C.FL_ACTIVE = 'Y' AND A.JENIS IN('EX BEHANDLE 1','EX BEHANDLE 2')
			GROUP BY A.NO_CONT
			ORDER BY A.ID_JOB_SLIP DESC";
			$queryspk = $this->db->query($SQL);
			//$queryspk=$this->db->query("select * from t_job_slip where STATUS='WAITING' AND KD_STATUS='20' AND LOKASI_AKHIR IS NOT NULL AND LOKASI_AWAL IS NOT NULL ORDER BY LOKASI_AKHIR LIMIT 10 ");
			return $queryspk->result_array();
	}	

	public function datajumlahmarshallingcic(){
		$queryspk=$this->db->query("SELECT DISTINCT A.ID_JOB_SLIP,A.NO_CONT,A.LOKASI_AWAL,A.LOKASI_AKHIR
			FROM t_job_slip A
			INNER JOIN t_spk B ON A.NO_SPK = B.NO_SPK
			INNER JOIN t_spk_cont C ON B.ID = C.ID
			INNER JOIN t_gatepass D ON A.NO_GATEPASS = D.ID
			WHERE A.STATUS = 'WAITING' AND A.KD_STATUS='20' AND A.LOKASI_AKHIR LIKE 'CIC%'
			AND C.STATUS_CONT != 900 AND D.FL_ACTIVE = 'Y' AND A.JENIS IN ('BEHANDLE 1','BEHANDLE 2') GROUP BY A.NO_CONT
			ORDER BY A.ID_JOB_SLIP DESC");
		return $queryspk->result_array();
	}

	public function datajumlahmarshallingyard(){
		$queryspk=$this->db->query("SELECT DISTINCT A.ID_JOB_SLIP,A.NO_CONT,A.LOKASI_AWAL,A.LOKASI_AKHIR
			FROM t_job_slip A
			INNER JOIN t_spk B ON A.NO_SPK = B.NO_SPK
			INNER JOIN t_gatepass C ON A.NO_GATEPASS = C.ID
			WHERE A.STATUS = 'WAITING' AND A.KD_STATUS='20' AND A.LOKASI_AKHIR LIKE '1A%'
			AND C.FL_ACTIVE = 'Y' AND A.JENIS IN ('EX BEHANDLE 1','EX BEHANDLE 2') GROUP BY A.NO_CONT
			ORDER BY A.ID_JOB_SLIP DESC");
		return $queryspk->result_array();
	}
		
	public function search2($maxid){
		$queryspk=$this->db->get_where('t_op_marshalling', array('ID' => $maxid ));
		return $queryspk->row_array();
	}

	public function search($keyword){
	    $queryspk=$this->db->query("SELECT ID, NO_CONT, UKR_CONT, 
									CASE WHEN LEFT(LOKASI,3) = 'CIC' THEN CONCAT(LOKASI,'0',TIER) ELSE CONCAT(LOKASI,'0',TIER) END AS 'LOKASI', TIER, ROOM, STATUS_CONT, NO_SEAL, ISO_CODE, ID_FLAT, FL_GATEPASS
									FROM t_spk_cont
									WHERE NO_CONT LIKE '%$keyword%' AND STATUS_CONT IN (200)");
		return $queryspk->row_array();
	}
			
	public function searchb22($keyword){
        $queryspk=$this->db->query("select * from t_spk_cont where NO_CONT LIKE '%$keyword%' AND STATUS_CONT='200'");
		return $queryspk;
	}
			
	public function searchop($id){
        $queryspk=$this->db->query("SELECT * FROM t_spk_cont WHERE STATUS_CONT NOT IN('000','100','200') AND NO_CONT LIKE '%$id%' ORDER BY ID DESC LIMIT 1");
		return $queryspk->result_array();
	}
			
	public function searchop2($id){
       $queryspk=$this->db->query("SELECT A.*, C.NAMA, D.KETERANGAN
									FROM t_spk_cont A
									INNER JOIN t_spk B ON A.ID=B.ID
									INNER JOIN reff_kode_dok_bc C ON B.JNS_DOK=C.ID
									INNER JOIN reff_status_spk D ON A.STATUS_CONT=D.ID
									WHERE A.NO_CONT LIKE '%$id%' AND A.STATUS_CONT NOT IN('000','100','200') ORDER BY A.ID DESC");
		return $queryspk->row_array();
	}
			
	public function searchreal($keyword){
        $queryspk=$this->db->query("select * FROM t_spk_cont WHERE NO_CONT LIKE UPPER('%$keyword%') AND STATUS_CONT IN('460') ORDER BY ID DESC LIMIT 1");
		return $queryspk->result_array();
        /*$queryspk=$this->db->query("select * from t_spk_cont where NO_CONT LIKE '%$keyword%' AND STATUS_CONT  IN('460','510','530')");
		return $queryspk->row_array();*/
	}
			
	public function searchreal2($keyword){
        $queryspk=$this->db->query("select * from t_spk_cont where NO_CONT LIKE '%$keyword%' AND STATUS_CONT='460' ORDER BY ID DESC LIMIT 1");
		return $queryspk;
	}

	public function ambilkondisi(){
		$queryspk=$this->db->query('select ID,KONDISI from reff_kondisi');
		return $queryspk;
	}

	public function searchco($keyword){
        $query  =   $this->db->query("select * from t_spk_cont where ID='$keyword' ");
        return $query->result_array();
	}

	public function searchcon($keyword){
        $query  =   $this->db->query("select * from t_op_reefer where ID='$keyword' ");
        return $query->result_array();
	}

	public function searchdeliv($keyword){
		$query= $this->db->query("select * from t_op_delivery where NO_CONT LIKE '%$keyword%' AND WK_GATEOUT IS NULL ");
		return $query->result_array();
	}

	public function searchdeliv2($keyword){
		$query= $this->db->query("select * from t_gatepass where NO_CONT LIKE '%$keyword%' AND JNS_KEGIATAN='3' ");
		return $query->result_array();
	}
	
	public function hitungcms(){
		$data=$this->db->query("SELECT NO_CONT FROM t_cms");
		return $data->result_array();
	}

	public function set_delivery(){
				$this->load->helper('url');
				$inp=$this->input->post('nomercont');
				$query2=$this->cek_tspkcontst2($inp);
				$query3=$this->cek_tspk2($query2['ID']);
				$truk=$this->input->post('nomertruck');
				$con=$this->db->query("SELECT LOKASI, TIER,UKR_CONT, NO_SEAL FROM t_spk_cont WHERE NO_CONT='$inp' ")->row_array();
				$con2=$this->db->query("SELECT JNS_CONT,ISO_CODE,BRUTO FROM t_cocostscont WHERE NO_CONT='$inp'")->row_array();
				//Tambahan
				$con3=$this->db->query("SELECT W_BEHANDLE FROM t_op_behandlein WHERE NO_CONT='$inp'")->row_array();
				$con4=$this->db->query("SELECT START_INSP FROM t_op_inspection WHERE NO_CONT='$inp'")->row_array();
				$dsc=count($this->hitungcms());
				// echo $this->session->userdata('USERLOGIN');die();
				$sno=$dsc+1;
				if ($sno<10) {
					$nosec="CMS0000".$sno;
				}elseif ($sno >= 10 && $sno < 100 ) {
					$nosec="CMS000".$sno;
				}elseif ($sno >= 100 && $sno < 1000 ) {
					$nosec="CMS00".$sno;
				}elseif ($sno >= 1000 && $sno < 10000 ) {
					$nosec="CMS0".$sno;
				}else{
					$nosec="CMS".$sno;
				}
				 // echo "No cms adalah ".$con['NO_CONT'];die();
				// print_r($con);die();
				$dsi= array(
						'WK_TRUCKIN' => date('Y-m-d H:i:s')
					);
				$dsi2= array(
						'WK_GATEOUT' => date('Y-m-d H:i:s')
					);
				$nomerspk=$query3['NO_SPK'];
				$keyy= array(
						'NO_CONT' => $inp,
						'NO_SPK' => $nomerspk
					);

				if (isset($truk)) {
					//insert truckin
					$dsimpan= array(
							'NO_CONT' => $inp,
							'NO_TRUCK' => $truk,
							'GATE_T' => $this->input->post('gate'),
							'LOKASI' =>$con['LOKASI'],
							'TIER' =>$con['TIER'],
							'UKR_CONT'=>$con['UKR_CONT'],
							'NO_SPK' => $nomerspk,							
							// 'OPERATOR_T' => $this->session->userdata('USERLOGIN'),
							'WK_TRUCKIN' => date('Y-m-d H:i:s')
					);	
					$arr = array(
						'NO_CONT' => $inp, 
						'NO_TRUCK' => $truk,
						'NO_SPK' => $nomerspk, 
						'DAILYSECNO' => $nosec, 
						'LINE' => $this->input->post('gate'),
						// 'OPERATOR' => $this->session->userdata('USERLOGIN'), 
						'STATUS' => $con2['JNS_CONT'],
						'ISO_CODE' => $con2['ISO_CODE'],
						'WEIGHT' => $con2['BRUTO'], 
						'YARDPOST' =>$con['LOKASI'], 
						'WK_TRUCKIN' => date('Y-m-d H:i')
						);
					$this->db->insert('t_cms',$arr);
					$this->ubahstatusdelivery($inp,'800');
					$this->db->insert('t_op_delivery',$dsimpan);

					$this->db->where($keyy);
					$this->db->update('t_operation',$dsi);
					$data['notif']=1;
					$data['NOCONT']=$inp;
					$this->content = $this->load->view('content/dashboard/delivery',$data,true);
					$this->index();
				}else{
					$dsimpan= array(
						'GATE_O' => $this->input->post('gate'),
						// 'OPERATOR_G' => $this->session->userdata('USERLOGIN'),
						'WK_GATEOUT' => date('Y-m-d H:i:s')
					);
					
					//update t_denah
					$this->db->where(array('NM_BLOK' => $con['LOKASI'], 'LEVEL_4' =>$con['TIER']));
					$this->db->update('t_denah_lapangan', array('USE'=>'0'));
					//

					$arr = array(
						'NO_CONT' => $inp,
						'NM_EIR' => $this->session->userdata('USERLOGIN'),
						'STATUS' => $con2['JNS_CONT'],
						'FLAT' => $truk,
						'ISO_CODE' => $con2['ISO_CODE'],
						'BRUTO' => $con2['BRUTO'],
						'LOKASI_END' =>$con['LOKASI'].'0'.$con['TIER'],
						'WK_GATEOUT' => date('Y-m-d H:i'),
						'WK_BEHANDLEIN' => $con3['W_BEHANDLE'],
						'WK_START' => $con4['START_INSP']
					);

					$this->db->insert('t_eir',$arr);
					
					$this->ubahstatusdelivery($inp,'900');
					$this->db->where('NO_CONT', $inp );
					$this->db->update('t_op_delivery',$dsimpan);

					$this->db->where($keyy);
					$this->db->update('t_operation',$dsi2);
					//delete t_job_slip
					$this->db->delete('t_job_slip', array('NO_CONT'=>$inp,'STATUS'=>'WAITING','JNS_JOB_SLIP'=>NULL ));
					
					$this->db->where(array('NO_CONT' => $inp, 'ID' =>$query2['ID']));
					$this->db->update('t_spk_cont', array('LOKASI' => NULL, 'TIER'=>NULL));
					
					$data['notif']=2;
					$data['NOCONT']=$inp;
					$this->content = $this->load->view('content/dashboard/delivery',$data,true);
					$this->index();
				}
	}

	public function set_inspect(){
				$this->load->helper('url');
				$inp=$this->input->post('nomercont');
				$query2=$this->cek_tspkcontst2($inp);
				// print_r($query2);die();
				$query3=$this->cek_tspk2($query2['ID']);
				$truk=$this->input->post('nomertruck');
				$con=$this->db->query("SELECT LOKASI, TIER, NO_SEAL FROM t_spk_cont WHERE NO_CONT='$inp' ")->row_array();
				$con2=$this->db->query("SELECT JNS_CONT,ISO_CODE,BRUTO FROM t_cocostscont WHERE NO_CONT='$inp'")->row_array();
				//Tambahan
				$con3=$this->db->query("SELECT W_BEHANDLE FROM t_op_behandlein WHERE NO_CONT='$inp'")->row_array();
				$con4=$this->db->query("SELECT START_INSP FROM t_op_inspection WHERE NO_CONT='$inp'")->row_array();
				
				$keyy= array(
						'NO_CONT' => $inp,
						'NO_SPK' => $query3['NO_SPK']
					);
					
				$dsi2= array(
						'WK_INSPECTOUT' => date('Y-m-d H:i:s')
					);	

				if (isset($truk)) {
					$data['notif']=0;
					$data['NOCONT']=$inp;
					$this->content = $this->load->view('content/dashboard/inspectout',$data,true);
					$this->index();
				}else{
					
					$this->db->where($keyy);
					$this->db->update('t_operation',$dsi2);
					
					$dsimpan= array(
						'KONDISI_CONT' => $this->input->post('kondisi'),
						'KONDISI_SEAL' => $this->input->post('optradio'),
						'OPERATOR_I' => $this->session->userdata('USERLOGIN'),
						'NO_SEAL' => $this->input->post('noseal'),
						'WK_INSPECT' => date('Y-m-d H:i:s')
					);
					$this->ubahstatusdelivery($inp,'870');
					$this->db->where('NO_CONT', $inp );
					$this->db->update('t_op_delivery',$dsimpan);

					
					$data['notif']=2;
					$data['NOCONT']=$inp;
					$this->content = $this->load->view('content/dashboard/inspectout',$data,true);
					$this->index();
				}
	}
	
	public function ubahstatusdelivery($parcont,$par2){
		$this->db->query("UPDATE t_spk_cont SET STATUS_CONT='$par2' WHERE NO_CONT='$parcont' AND STATUS_CONT NOT IN ('900') ");
		}

	public function getalldelivery(){
		$SQL = $this->db->query("SELECT * FROM t_op_delivery Where WK_TRUCKIN IS NOT NULL AND WK_CHASSIS IS NULL");
		return $SQL->result_array();
	}
	
	public function getflatcopy($lokasi){
		if(substr($lokasi,0,3)==="CIC"){
			$lokas=substr($lokasi,0,5);
			$ter=substr($lokasi,-1);
			$SQL = $this->db->query("SELECT * FROM t_denah_lapangan WHERE NM_BLOK = '$lokas' AND LEVEL_4 = '$ter' ");
			return $SQL->row_array();
		}else{
			$lokas=substr($lokasi,0,6);
			$ter=substr($lokasi,-1);
			$SQL = $this->db->query("SELECT * FROM t_denah_lapangan WHERE NM_BLOK = '$lokas' AND LEVEL_4 = '$ter' ");
			return $SQL->row_array();
		}
	}

	public function set_copy(){
		$NO_CONT	 = $this->input->post('nomerkon');
		$STATUS_BLOK = $this->input->post('mySelect');
		$LOKASI_BARU = $this->input->post('lokbar');
		$LOASI_LAMA	 = $this->input->post('nolok');
		$STATUS_CONT = $this->input->post('status_cont');

		$SQL_REFF = $this->db->query("SELECT * FROM reff_status_spk WHERE KETERANGAN = '".$STATUS_CONT."' ORDER BY ID DESC LIMIT 1")->row_array();

		if ($SQL_REFF['ID'] == '460' || $SQL_REFF['ID'] == '520') {
			$NM_BLOCK = strtoupper(substr($LOKASI_BARU,0,5));
			$NM_TIER = strtoupper(substr($LOKASI_BARU,-1));
		}else{
			$cekJumlah  = strlen($LOKASI_BARU);
			if ($cekJumlah > 8) {
				$NM_BLOCK = strtoupper(substr($LOKASI_BARU,0,7));
				$NM_TIER = strtoupper(substr($LOKASI_BARU,-1));
			}else{
				$NM_BLOCK = strtoupper(substr($LOKASI_BARU,0,6));
				$NM_TIER = strtoupper(substr($LOKASI_BARU,-1));
			}
		}

		$SQL_SPK_CONT = $this->db->query("SELECT * FROM t_spk_cont WHERE NO_CONT='".$NO_CONT."' AND STATUS_CONT ='".$SQL_REFF['ID']."' ORDER BY ID DESC LIMIT 1")->result_array();

		$SQL_DENAH 	 = $this->db->query("SELECT CONCAT(NM_BLOK,'0',LEVEL_4) AS 'DENAH' FROM t_denah_lapangan HAVING DENAH ='".$LOKASI_BARU."' ")->row_array();

		$SQL_SPK_LOK = $this->db->query("SELECT NO_CONT, CONCAT(LOKASI,'0',TIER) AS 'LOKASI',STATUS_CONT FROM t_spk_cont HAVING LOKASI ='".$LOKASI_BARU."' AND STATUS_CONT IN('450','460','510','530') ORDER BY ID DESC")->row_array();

		if ($STATUS_BLOK == 'dua') {
			$this->db->where(array('NO_CONT' => $NO_CONT, 'STATUS_CONT' => $SQL_SPK_CONT[0]['STATUS_CONT']));
			$this->db->update('t_spk_cont', array('LOKASI' => 'SAMPAH', 'TIER' => NULL, 'STATUS_CONT' => '900'));
			$data['notif']=1;
			$data['NOCONT']=$NO_CONT;
			$this->content = $this->load->view('content/dashboard/copy',$data,true);
			$this->index();
		}else{
			if ($SQL_DENAH['DENAH'] == $LOKASI_BARU) {
					if($SQL_SPK_LOK['LOKASI'] != $LOKASI_BARU){
						if($SQL_SPK_CONT[0]['STATUS_CONT'] == '460'){
							if(substr($LOASI_LAMA,0,3) == "CIC" && substr($LOKASI_BARU,0,2) == "1B" || substr($LOASI_LAMA,0,3) == "CIC" && substr($LOKASI_BARU,0,2) == "1A"){
								$data['notif']	= 7;
								$data['NOCONT']	= $NO_CONT;
								$data['VARA']	= $LOASI_LAMA;
								$data['VARB']	= $LOKASI_BARU;
								$this->content 	= $this->load->view('content/dashboard/copy',$data,true);
								$this->index();
							}else{
								$this->db->where(array('NO_CONT' => $NO_CONT, 'STATUS_CONT' => $SQL_SPK_CONT[0]['STATUS_CONT']));
								$this->db->update('t_spk_cont', array('LOKASI' => $NM_BLOCK, 'TIER' => $NM_TIER, 'STATUS_CONT' => '460', 'OPERATOR' => $this->session->userdata('USERLOGIN')));
								
								/* UBAH DATA PADA JOB SLIP */
								$SQL_CEK_SPK = $this->db->query("SELECT * FROM t_spk WHERE ID = '".$SQL_SPK_CONT[0]['ID']."'")->result_array();
								$SQL_CEK_JOB = $this->db->query("SELECT * FROM t_job_slip WHERE NO_CONT ='".$NO_CONT."' AND NO_SPK = '".$SQL_CEK_SPK[0]['NO_SPK']."' AND LOKASI_AKHIR LIKE 'CIC%' ORDER BY ID_JOB_SLIP DESC LIMIT 1")->result_array();

								$this->db->where(array('NO_CONT' => $NO_CONT, 'NO_SPK' => $SQL_CEK_JOB[0]['NO_SPK'], 'ID_JOB_SLIP' => $SQL_CEK_JOB[0]['ID_JOB_SLIP']));
								$this->db->update('t_job_slip', array('LOKASI_AKHIR' => $NM_BLOCK, 'TIER_AKHIR' => $NM_TIER, 'OPERATOR' => $this->session->userdata('USERLOGIN')));

								/* MESSAGE DATA BERHASIL SUCCESS */
								$data['notif']=1;
								$data['NOCONT']=$NO_CONT;
								$this->content = $this->load->view('content/dashboard/copy',$data,true);
								$this->index();
							}
						}else if($SQL_SPK_CONT[0]['STATUS_CONT'] == '510' || $SQL_SPK_CONT[0]['STATUS_CONT'] == '530'){
							if(substr($LOASI_LAMA,0,2) == "1B" && substr($LOKASI_BARU,0,3) == "CIC" || substr($LOASI_LAMA,0,2) == "1A" && substr($LOKASI_BARU,0,3) == "CIC" || substr($LOASI_LAMA,0,2) == "1A" && substr($LOKASI_BARU,0,2) == "1B"){
								$data['notif']	= 7;
								$data['NOCONT']	= $NO_CONT;
								$data['VARA']	= $LOASI_LAMA;
								$data['VARB']	= $LOKASI_BARU;
								$this->content 	= $this->load->view('content/dashboard/copy',$data,true);
								$this->index();
							}else{
								if($SQL_SPK_CONT[0]['STATUS_CONT'] == '510'){
									$this->db->where(array('NO_CONT' => $NO_CONT, 'STATUS_CONT' => $SQL_SPK_CONT[0]['STATUS_CONT']));
									$this->db->update('t_spk_cont', array('LOKASI' => $NM_BLOCK, 'TIER' => $NM_TIER, 'STATUS_CONT' => '510', 'OPERATOR' => $this->session->userdata('USERLOGIN')));
									
									/* UBAH DATA PADA JOB SLIP */
									$SQL_CEK_SPK = $this->db->query("SELECT * FROM t_spk WHERE ID = '".$SQL_SPK_CONT[0]['ID']."'")->result_array();
									$SQL_CEK_JOB = $this->db->query("SELECT * FROM t_job_slip WHERE NO_CONT ='".$NO_CONT."' AND NO_SPK = '".$SQL_CEK_SPK[0]['NO_SPK']."' AND LOKASI_AWAL LIKE '1B%' ORDER BY ID_JOB_SLIP DESC LIMIT 1")->result_array();

									$this->db->where(array('NO_CONT' => $NO_CONT, 'NO_SPK' => $SQL_CEK_JOB[0]['NO_SPK'], 'ID_JOB_SLIP' => $SQL_CEK_JOB[0]['ID_JOB_SLIP']));
									$this->db->update('t_job_slip', array('LOKASI_AWAL' => $NM_BLOCK, 'TIER_AWAL' => $NM_TIER, 'OPERATOR' => $this->session->userdata('USERLOGIN')));

									$this->db->where(array('NO_CONT' => $NO_CONT, 'NO_SPK' => $SQL_CEK_SPK[0]['NO_SPK']));
									$this->db->update('t_op_behandlein', array('ROOM' => $NM_BLOCK.'0'.$NM_TIER));

									/* MESSAGE DATA BERHASIL SUCCESS */
									$data['notif']=1;
									$data['NOCONT']=$NO_CONT;
									$this->content = $this->load->view('content/dashboard/copy',$data,true);
									$this->index();
								}else if($SQL_SPK_CONT[0]['STATUS_CONT'] == '530'){
									$this->db->where(array('NO_CONT' => $NO_CONT, 'STATUS_CONT' => $SQL_SPK_CONT[0]['STATUS_CONT']));
									$this->db->update('t_spk_cont', array('LOKASI' => $NM_BLOCK, 'TIER' => $NM_TIER, 'STATUS_CONT' => '530', 'OPERATOR' => $this->session->userdata('USERLOGIN')));
									
									/* UBAH DATA PADA JOB SLIP */
									$SQL_CEK_SPK = $this->db->query("SELECT * FROM t_spk WHERE ID = '".$SQL_SPK_CONT[0]['ID']."'")->result_array();
									$SQL_CEK_JOB = $this->db->query("SELECT * FROM t_job_slip WHERE NO_CONT ='".$NO_CONT."' AND NO_SPK = '".$SQL_CEK_SPK[0]['NO_SPK']."' AND LOKASI_AKHIR LIKE '1A%' AND STATUS='DONE' ORDER BY ID_JOB_SLIP DESC LIMIT 1")->result_array();

									$this->db->where(array('NO_CONT' => $NO_CONT, 'NO_SPK' => $SQL_CEK_JOB[0]['NO_SPK'], 'ID_JOB_SLIP' => $SQL_CEK_JOB[0]['ID_JOB_SLIP']));
									$this->db->update('t_job_slip', array('LOKASI_AKHIR' => $NM_BLOCK, 'TIER_AKHIR' => $NM_TIER, 'OPERATOR' => $this->session->userdata('USERLOGIN')));

									/* MESSAGE DATA BERHASIL SUCCESS */
									$data['notif']=1;
									$data['NOCONT']=$NO_CONT;
									$this->content = $this->load->view('content/dashboard/copy',$data,true);
									$this->index();
								}
							}
						}else if($SQL_SPK_CONT[0]['STATUS_CONT'] == '520' || $SQL_SPK_CONT[0]['STATUS_CONT'] == '540'){
							if(substr($LOASI_LAMA,0,2) == "1B" && substr($LOKASI_BARU,0,3) == "CIC" || substr($LOASI_LAMA,0,2) == "1A" && substr($LOKASI_BARU,0,3) == "CIC" || substr($LOASI_LAMA,0,2) == "1B" && substr($LOKASI_BARU,0,2) == "1A" || substr($LOASI_LAMA,0,2) == "1A" && substr($LOKASI_BARU,0,2) == "1B"){
								$data['notif']	= 7;
								$data['NOCONT']	= $NO_CONT;
								$data['VARA']	= $LOASI_LAMA;
								$data['VARB']	= $LOKASI_BARU;
								$this->content 	= $this->load->view('content/dashboard/copy',$data,true);
								$this->index();
							}else{
								if($SQL_SPK_CONT[0]['STATUS_CONT'] == '520'){
									$this->db->where(array('NO_CONT' => $NO_CONT, 'STATUS_CONT' => $SQL_SPK_CONT[0]['STATUS_CONT']));
									$this->db->update('t_spk_cont', array('LOKASI' => $NM_BLOCK, 'TIER' => $NM_TIER, 'STATUS_CONT' => '520', 'OPERATOR' => $this->session->userdata('USERLOGIN')));
									
									/* UBAH DATA PADA JOB SLIP */
									$SQL_CEK_SPK = $this->db->query("SELECT * FROM t_spk WHERE ID = '".$SQL_SPK_CONT[0]['ID']."'")->result_array();
									$SQL_CEK_JOB = $this->db->query("SELECT * FROM t_job_slip WHERE NO_CONT ='".$NO_CONT."' AND NO_SPK = '".$SQL_CEK_SPK[0]['NO_SPK']."' AND LOKASI_AKHIR LIKE 'CIC%' AND STATUS = 'DONE' ORDER BY ID_JOB_SLIP DESC LIMIT 1")->result_array();

									$this->db->where(array('NO_CONT' => $NO_CONT, 'NO_SPK' => $SQL_CEK_JOB[0]['NO_SPK'], 'ID_JOB_SLIP' => $SQL_CEK_JOB[0]['ID_JOB_SLIP']));
									$this->db->update('t_job_slip', array('LOKASI_AKHIR' => $NM_BLOCK, 'TIER_AKHIR' => $NM_TIER, 'OPERATOR' => $this->session->userdata('USERLOGIN')));

									/* MESSAGE DATA BERHASIL SUCCESS */
									$data['notif']=1;
									$data['NOCONT']=$NO_CONT;
									$this->content = $this->load->view('content/dashboard/copy',$data,true);
									$this->index();
								}else if($SQL_SPK_CONT[0]['STATUS_CONT'] == '540'){
									$this->db->where(array('NO_CONT' => $NO_CONT, 'STATUS_CONT' => $SQL_SPK_CONT[0]['STATUS_CONT']));
									$this->db->update('t_spk_cont', array('LOKASI' => $NM_BLOCK, 'TIER' => $NM_TIER, 'STATUS_CONT' => '540', 'OPERATOR' => $this->session->userdata('USERLOGIN')));
									
									/* UBAH DATA PADA JOB SLIP */
									$SQL_CEK_SPK = $this->db->query("SELECT * FROM t_spk WHERE ID = '".$SQL_SPK_CONT[0]['ID']."'")->result_array();
									$SQL_CEK_JOB = $this->db->query("SELECT * FROM t_job_slip WHERE NO_CONT ='".$NO_CONT."' AND NO_SPK = '".$SQL_CEK_SPK[0]['NO_SPK']."' AND LOKASI_AKHIR LIKE '1A%' AND STATUS='DONE' ORDER BY ID_JOB_SLIP DESC LIMIT 1")->result_array();

									$this->db->where(array('NO_CONT' => $NO_CONT, 'NO_SPK' => $SQL_CEK_JOB[0]['NO_SPK'], 'ID_JOB_SLIP' => $SQL_CEK_JOB[0]['ID_JOB_SLIP']));
									$this->db->update('t_job_slip', array('LOKASI_AKHIR' => $NM_BLOCK, 'TIER_AKHIR' => $NM_TIER, 'OPERATOR' => $this->session->userdata('USERLOGIN')));

									/* MESSAGE DATA BERHASIL SUCCESS */
									$data['notif']=1;
									$data['NOCONT']=$NO_CONT;
									$this->content = $this->load->view('content/dashboard/copy',$data,true);
									$this->index();
								}
							}
						}else if($SQL_SPK_CONT[0]['STATUS_CONT'] == '450'){
							if(substr($LOASI_LAMA,0,2) == "1B" && substr($LOKASI_BARU,0,3) == "CIC" || substr($LOASI_LAMA,0,2) == "1A" && substr($LOKASI_BARU,0,3) == "CIC" || substr($LOASI_LAMA,0,2) == "1A" && substr($LOKASI_BARU,0,3) == "1B"){
								$data['notif']	= 7;
								$data['NOCONT']	= $NO_CONT;
								$data['VARA']	= $LOASI_LAMA;
								$data['VARB']	= $LOKASI_BARU;
								$this->content 	= $this->load->view('content/dashboard/copy',$data,true);
								$this->index();
							}else{
								$this->db->where(array('NO_CONT' => $NO_CONT, 'STATUS_CONT' => $SQL_SPK_CONT[0]['STATUS_CONT']));
								$this->db->update('t_spk_cont', array('LOKASI' => $NM_BLOCK, 'TIER' => $NM_TIER, 'STATUS_CONT' => '450', 'OPERATOR' => $this->session->userdata('USERLOGIN')));
								
								/* UBAH DATA PADA JOB SLIP */
								$SQL_CEK_SPK = $this->db->query("SELECT * FROM t_spk WHERE ID = '".$SQL_SPK_CONT[0]['ID']."'")->result_array();
								if (substr($LOKASI_BARU,0,3) == "1B") {
									$SQL_CEK_JOB = $this->db->query("SELECT * FROM t_job_slip WHERE NO_CONT ='".$NO_CONT."' AND NO_SPK = '".$SQL_CEK_SPK[0]['NO_SPK']."' AND LOKASI_AWAL LIKE '1B%' ORDER BY ID_JOB_SLIP DESC LIMIT 1")->result_array();
									$this->db->where(array('NO_CONT' => $NO_CONT, 'NO_SPK' => $SQL_CEK_SPK[0]['NO_SPK'], 'ID_JOB_SLIP' => $SQL_CEK_JOB[0]['ID_JOB_SLIP']));
									$this->db->update('t_job_slip', array('LOKASI_AWAL' => $NM_BLOCK, 'TIER_AWAL' => $NM_TIER, 'OPERATOR' => $this->session->userdata('USERLOGIN')));
								}else{
									$SQL_CEK_JOB = $this->db->query("SELECT * FROM t_job_slip WHERE NO_CONT ='".$NO_CONT."' AND NO_SPK = '".$SQL_CEK_SPK[0]['NO_SPK']."' AND LOKASI_AWAL LIKE 'CIC%' ORDER BY ID_JOB_SLIP DESC LIMIT 1")->result_array();
									$this->db->where(array('NO_CONT' => $NO_CONT, 'NO_SPK' => $SQL_CEK_SPK[0]['NO_SPK'], 'ID_JOB_SLIP' => $SQL_CEK_JOB[0]['ID_JOB_SLIP']));
									$this->db->update('t_job_slip', array('LOKASI_AKHIR' => $NM_BLOCK, 'TIER_AKHIR' => $NM_TIER, 'OPERATOR' => $this->session->userdata('USERLOGIN')));
								}
								// print_r($this->db->last_query());
								/* MESSAGE DATA BERHASIL SUCCESS */
								$data['notif']=1;
								$data['NOCONT']=$NO_CONT;
								$this->content = $this->load->view('content/dashboard/copy',$data,true);
								$this->index();

							}
						}else if($SQL_SPK_CONT[0]['STATUS_CONT'] == '900'){
								$this->db->where(array('NO_CONT' => $NO_CONT, 'STATUS_CONT' => $SQL_SPK_CONT[0]['STATUS_CONT']));
								$this->db->update('t_spk_cont', array('LOKASI' => $NM_BLOCK, 'TIER' => $NM_TIER, 'STATUS_CONT' => '450', 'OPERATOR' => $this->session->userdata('USERLOGIN')));
								
								/* MESSAGE DATA BERHASIL SUCCESS */
								$data['notif']=1;
								$data['NOCONT']=$NO_CONT;
								$this->content = $this->load->view('content/dashboard/copy',$data,true);
								$this->index();
						}
					}else{
						$data['notif']  = 4;
						$data['NOCONT'] = $SQL_SPK_LOK['NO_CONT'];
						$this->content 	= $this->load->view('content/dashboard/copy',$data,true);
						$this->index();
					}
			}else{
				$data['notif']  = 5;
				$data['NOCONT'] = $NO_CONT;
				$this->content 	= $this->load->view('content/dashboard/copy',$data,true);
				$this->index();
			}
		}
	}
	
	public function set_copy_old(){
			$this->load->helper('url');
			$inp=$this->input->post('nomerkon');
			$statusblok=$this->input->post('mySelect');
			$lokna=$this->input->post('lokbar');
			$loklam=$this->input->post('nolok');
			$loka=trim(strtoupper($lokna));
			$loklama=trim(strtoupper($loklam));
			$queryspk=$this->db->get_where('t_spk_cont', array('NO_CONT' => $inp,'LOKASI'=>$loklam));
			$dataspk=$queryspk->row_array();
			$dataid=$dataspk['ID'];
			$queryspk2=$this->db->get_where('t_spk', array('ID' =>$dataid));
			$datacont=$queryspk2->row_array();
			$datakdstatus=$datacont['KD_STATUS'];
			if($datakdstatus=='100' || $datakdstatus=='000'){
				$s1="000";
				$s2="000";
			}elseif($datakdstatus=='200'){
				$s1="200";
				$s2="200";
			}else{
				$s1="460";
				$s2="450";
			}				
			
			if($statusblok=="satu"){
				if(substr($loka,0,3)==="CIC" && substr($loklama,0,2)==="1A" || substr($loka,0,2)==="1B" && substr($loklama,0,2)==="1A"  ){
					//ketika 1 a
					$data['notif']=7;
					$data['NOCONT']=$inp;
					$data['VARA']="1B";
					$data['VARB']="CIC";
					$data['NOCONT']=$inp;
					$this->content = $this->load->view('content/dashboard/copy',$data,true);
					$this->index();
				}elseif(substr($loka,0,3)==="CIC" && substr($loklama,0,2)==="1B" || substr($loka,0,2)==="1A" && substr($loklama,0,2)==="1B" ){
					//ketika 1 b
					$data['notif']=7;
					$data['NOCONT']=$inp;
					$data['VARA']="1A";
					$data['VARB']="CIC";
					$this->content = $this->load->view('content/dashboard/copy',$data,true);
					$this->index();
				}elseif(substr($loka,0,2)==="1B" && substr($loklama,0,3)==="CIC" || substr($loka,0,2)==="1A" && substr($loklama,0,3)==="CIC" ){
					//ketika CIC
					$data['notif']=7;
					$data['NOCONT']=$inp;
					$data['VARA']="1A";
					$data['VARB']="1B";
					$this->content = $this->load->view('content/dashboard/copy',$data,true);
					$this->index();
				}else{
						$lokasiterpakai=$this->ceklokasiterpakai($loka);
						$flat=$this->getflatcopy($loka);
					if(count($flat)==0){
					$data['notif']=5;
					$data['NOCONT']=$inp;
					$this->content = $this->load->view('content/dashboard/copy',$data,true);
					$this->index();
					}else{
						if(count($lokasiterpakai)>0){
							$data['notif']=4;
							$data['NOCONT']=$inp;
							$this->content = $this->load->view('content/dashboard/copy',$data,true);
							$this->index();
						}else{
							
								if($flat['USE']==0){
									if(substr($loka,0,3)==="CIC" || substr($loka,0,3)==="cic" ){
										//update t_denah
												if(substr($loklama,0,3)==="CIC" || substr($loklama,0,3)==="cic"){
													$varlokasi2=substr($loklama,0,5);
													$vartier2=substr($loklama,-1);
													$this->db->where(array('NM_BLOK' => $varlokasi2, 'LEVEL_4' =>$vartier2));
													$this->db->update('t_denah_lapangan', array('USE'=>'0'));
												}elseif(substr($loklama,0,2)==="1A" || substr($loklama,0,2)=== "1B" || substr($loklama,0,2)=="YA" || substr($loklama,0,2)=="YB"){
													$van3=substr($loklama,0,6);
													$tierr=substr($loklama,-1);
													$this->db->where(array('NM_BLOK' => $van3, 'LEVEL_4' =>$tierr));
													$this->db->update('t_denah_lapangan', array('USE'=>'0'));
												}
										$varlok=substr($loka,0,5);
										$vartie=substr($loka,-1);		
										$this->db->where(array('NM_BLOK' => $varlok, 'LEVEL_4' =>$vartie));
										$this->db->update('t_denah_lapangan', array('USE'=>'1'));
										//update t_spk_cont
										$this->db->where(array('NO_CONT' => $inp));
										$this->db->update('t_spk_cont', array('LOKASI' => $varlok,'TIER'=>$vartie));
										//update job slip
										$this->db->where(array('NO_CONT' => $inp, 'STATUS' =>'WAITING'));
										$this->db->update('t_job_slip', array('LOKASI_AWAL' => $varlok,'TIER_AWAL' => $vartie));
									}else{
										$van2=substr($loka,0,6);
										$tie=substr($loka,-1);
										//update t_denah
												if(substr($loklama,0,3)==="CIC" || substr($loklama,0,3)==="cic"){
													$varlokasi2=substr($loklama,0,5);
													$vartier2=substr($loklama,-1);
													$this->db->where(array('NM_BLOK' => $varlokasi2, 'LEVEL_4' =>$vartier2));
													$this->db->update('t_denah_lapangan', array('USE'=>'0'));
												}elseif(substr($loklama,0,2)==="1A" || substr($loklama,0,2)=== "1B" || substr($loklama,0,2)=="YA" || substr($loklama,0,2)=="YB"){
													$van3=substr($loklama,0,6);
													$tierr=substr($loklama,-1);
													
													$this->db->where(array('NM_BLOK' => $van3, 'LEVEL_4' =>$tierr));
													$this->db->update('t_denah_lapangan', array('USE'=>'0'));
												}
												
										$this->db->where(array('NM_BLOK' => $van2, 'LEVEL_4' =>$tie));
										$this->db->update('t_denah_lapangan', array('USE'=>'1'));
											//update t_spk_cont
										$this->db->where(array('NO_CONT' => $inp));
										$this->db->update('t_spk_cont', array('LOKASI' => $van2,'TIER'=>$tie));
											//update job slip
										$this->db->where(array('NO_CONT' => $inp, 'STATUS' =>'WAITING'));
										$this->db->update('t_job_slip', array('LOKASI_AWAL' => $van2,'TIER_AWAL' => $tie));
										//
									}
										$data['notif']=1;
										$data['NOCONT']=$inp;
										$this->content = $this->load->view('content/dashboard/copy',$data,true);
										$this->index();
								}else{
									$data['notif']=3;
									$data['NOCONT']=$inp;
									$this->content = $this->load->view('content/dashboard/copy',$data,true);
									$this->index();
								}
						}
					}
				}
			}else{
				//update tspk cont lokasi sampah dan status delivery 
				$this->db->where(array('NO_CONT' => $inp));
				$this->db->update('t_spk_cont', array('LOKASI' =>"SAMPAH", 'TIER'=>NULL,'STATUS_CONT'=>'900'));
				
				//update  fl use denah lapangan lokasi awal jadi 0
				if(substr($loklama,0,3)==="CIC" || substr($loklama,0,3)==="cic"){
					$varlokasi2=substr($loklama,0,5);
					$vartier2=substr($loklama,-1);
					$this->db->where(array('NM_BLOK' => $varlokasi2, 'LEVEL_4' =>$vartier2));
					$this->db->update('t_denah_lapangan', array('USE'=>'0'));
				}elseif(substr($loklama,0,2)==="1A" || substr($loklama,0,2)=== "1B" || substr($loklama,0,2)=="YA" || substr($loklama,0,2)=="YB"){
					$van3=substr($loklama,0,6);
					$tierr=substr($loklama,-1);
					$this->db->where(array('NM_BLOK' => $van3, 'LEVEL_4' =>$tierr));
					$this->db->update('t_denah_lapangan', array('USE'=>'0'));
				}
				//update status jobslip jadi done
				$this->db->where(array('NO_CONT' => $inp, 'STATUS' =>'WAITING'));
				$this->db->update('t_job_slip', array('STATUS' => 'DONE','KD_STATUS' => '50'));
				
				$data['notif']=6;
				$data['NOCONT']=$inp;
				$this->content = $this->load->view('content/dashboard/copy',$data,true);
				$this->index();
			}	
	}

	public function ambilchases($keyword){
		$SQL = $this->db->query("SELECT * FROM t_op_delivery Where NO_CONT like'%$keyword%'  AND WK_CHASSIS IS NULL ");
		return $SQL->result_array();
	}
	
	public function ambiltruck(){
		$queryspk=$this->db->query('select * from reff_truck');
		return $queryspk;
	}

	public function ambiltruck2($key){
		$queryspk=$this->db->query("select NO_TRUCK from reff_truck where NOT NO_TRUCK='$key' ");
		return $queryspk;
	}

	public function set_onchases(){
		$this->load->helper('url');
		$inp=$this->input->post('nomercont');
		$inp2=$this->input->post('nomerspk');
		$arrdata = array(
				'OPERATOR_O' => $this->session->userdata('USERLOGIN'),
				'WK_CHASSIS' => date('Y-m-d H:i:s')
			);
		$dsi= array(
				'WK_CHASSIS' => date('Y-m-d H:i:s')
			);
		$keyy= array(
				'NO_CONT' => $inp,
				'NO_SPK' => $inp2
			);

		$this->ubahstatusdelivery($inp,'850');
		$this->db->where('NO_CONT', $inp );
		$this->db->update('t_op_delivery',$arrdata);

		$this->db->where($keyy);
		$this->db->update('t_operation',$dsi);
		$data['notif']=1;
		$data['jobs']=$this->input->post('jobs');
		$data['nilai']=$this->getalldelivery();
		$this->content = $this->load->view('content/dashboard/onchases',$data,true);
		$this->index();
	}

	public function searcinspect($keyword){
		$queryspk=$this->db->query("select * from t_op_delivery where NO_CONT LIKE '%$keyword%' AND WK_TRUCKIN IS NOT NULL AND WK_CHASSIS IS NOT NULL AND WK_INSPECT IS NULL");
		return $queryspk->result_array();
	}
	
	public function searcingdelive($keyword){
		$query= $this->db->query("select A.* from t_gatepass A inner join t_spk_cont B ON A.NO_CONT=B.NO_CONT where A.NO_CONT LIKE '%$keyword%' AND A.JNS_KEGIATAN='3' AND B.STATUS_CONT !=900 ");
		return $query->result_array();
	}

	public function set_plug() {
		$NO_CONT = $this->input->post('nomerkon');
		$TEMPERATURE = $this->input->post('temperature');
		$W_PLUGIN = $this->input->post('w_plugin');
		$NOTE = $this->input->post('note');
		
		$SQL_PEMERIKSAAN = $this->db->query("SELECT * FROM t_op_reefer WHERE NO_CONT='".$NO_CONT."' AND waktu IS NOT NULL AND fl_unplug = 'N' ORDER BY ID ASC LIMIT 1")->row_array();

		$SQL_SPK_CONT = $this->db->query("SELECT A.*, B.* FROM t_spk_cont A INNER JOIN t_spk B ON A.ID = B.ID WHERE A.NO_CONT ='".$NO_CONT."' ORDER BY A.ID DESC limit 1")->row_array();

		if ($SQL_SPK_CONT['NO_CONT'] == $NO_CONT) {
			if ($SQL_PEMERIKSAAN == 0 || $SQL_PEMERIKSAAN == NULL) {
				$startplug = array(
					'NO_SPK' => $SQL_SPK_CONT['NO_SPK'],
					'NO_CONT' => $NO_CONT,
					'WAKTU' => date("Y-m-d H:i:s"),
					'WAKTU_MONITOR' => date("Y-m-d H:i:s"),
					'TEMPERATURE_AWAL' => $TEMPERATURE,
					'TEMPERATURE_MONITOR' => $TEMPERATURE,
					'FL_PLUG' => 'Y',
					'FL_MONITOR' => 'Y',
					'NOTE' => $NOTE,
					'OPERATOR_START' => $this->session->userdata('USERLOGIN'),
					'OPERATOR_MONITOR' => $this->session->userdata('USERLOGIN'),
					'WK_REKAM' => date("Y-m-d H:i:s")
				);
				$this->db->where(array('NO_CONT' => $NO_CONT));
				$this->db->insert('t_op_reefer', $startplug);
	
				$data['notif']	= 1;
				$data['NOCONT']	= $NO_CONT;
				$this->content 	= $this->load->view('content/dashboard/plugin',$data,true);
				$this->index();
			} else {
				$finishplug = array(
					'WAKTU_END' => date('Y-m-d H:i:s'),
					'FL_UNPLUG' => 'Y',
					'NOTE' => $NOTE,
					'TEMPERATURE_AKHIR' => $TEMPERATURE,
					'OPERATOR_END' => $this->session->userdata('USERLOGIN')
				);
	
				$this->db->where(array('NO_CONT' => $NO_CONT, 'NO_SPK' => $SQL_SPK_CONT['NO_SPK']))->limit(1)->order_by('id',"ASC");
				$this->db->update('t_op_reefer', $finishplug);
	
				$data['notif']	= 2;
				$data['NOCONT']	= $NO_CONT;
				$this->content 	= $this->load->view('content/dashboard/plugin',$data,true);
				$this->index();
			}
		}else{
			$data['notif']  = 6;
			$data['NOCONT'] = $NO_CONT;
			$this->content  = $this->load->view('content/dashboard/plugin',$data,true);
			$this->index();
		}
	}

	public function set_monitoring() {
		$NO_CONT = $this->input->post('nomerkon');
		$TEMPERATURE = $this->input->post('temperature');
		$W_PLUGIN = $this->input->post('w_plugin');
		$NOTE = $this->input->post('note');

		$SQL_PEMERIKSAAN = $this->db->query("SELECT * FROM t_op_reefer WHERE NO_CONT='".$NO_CONT."' ORDER BY ID DESC LIMIT 1")->row_array();

		$SQL_SPK_CONT = $this->db->query("SELECT A.*, B.* FROM t_spk_cont A INNER JOIN t_spk B ON A.ID = B.ID WHERE A.NO_CONT ='".$NO_CONT."' ORDER BY A.ID DESC")->row_array();

		if ($SQL_SPK_CONT['NO_CONT'] == $NO_CONT) {
			if ($W_PLUGIN != NULL) {
				$startplug = array(
					'NO_SPK' => $SQL_SPK_CONT['NO_SPK'],
					'NO_CONT' => $NO_CONT,
					'WAKTU_MONITOR' => date("Y-m-d H:i:s"),
					'TEMPERATURE_MONITOR' => $TEMPERATURE,
					'FL_MONITOR' => 'Y',
					'NOTE' => $NOTE,
					'OPERATOR_MONITOR' => $this->session->userdata('USERLOGIN'),
					'WK_REKAM' => date("Y-m-d H:i:s")
				);
				$this->db->where(array('NO_CONT' => $NO_CONT));
				$this->db->insert('t_op_reefer', $startplug);
	
				$data['notif']	= 7;
				$data['NOCONT']	= $NO_CONT;
				$this->content 	= $this->load->view('content/dashboard/monitor_reefer',$data,true);
				$this->index();
			} else {
				$data['notif']	= 5;
				$data['NOCONT']	= $NO_CONT;
				$this->content 	= $this->load->view('content/dashboard/monitor_reefer',$data,true);
				$this->index();
			}
		}else{
			$data['notif']  = 6;
			$data['NOCONT'] = $NO_CONT;
			$this->content  = $this->load->view('content/dashboard/monitor_reefer',$data,true);
			$this->index();
		}
	}

	public function searchreefer($keyword) {
		// $queryspk=$this->db->query("SELECT B.NO_CONT, D.TEMP_CUST AS 'SUHU_CUST', D.TEMP_TERMINAL AS 'SUHU_TERMINAL' FROM t_spk A INNER JOIN t_spk_cont B ON A.ID = B.ID INNER JOIN t_request C ON A.NO_DOK = C.NO_DOK INNER JOIN t_request_cont D ON B.NO_CONT = D.NO_CONT AND C.ID = D.ID LEFT JOIN t_op_reefer E ON B.NO_CONT = E.NO_CONT AND A.NO_SPK = E.NO_SPK WHERE D.FL_REEFER='Y' AND D.TEMP_CUST IS NOT NULL AND B.NO_CONT LIKE '%$keyword%' ORDER BY A.ID DESC LIMIT 1");
		$queryspk=$this->db->query("SELECT B.NO_CONT, D.TEMP_CUST AS 'SUHU_CUST', D.TEMP_TERMINAL AS 'SUHU_TERMINAL' FROM t_spk A INNER JOIN t_spk_cont B ON A.ID = B.ID INNER JOIN t_request C ON A.NO_DOK = C.NO_DOK INNER JOIN t_request_cont D ON B.NO_CONT = D.NO_CONT AND C.ID = D.ID LEFT JOIN t_op_reefer E ON B.NO_CONT = E.NO_CONT AND A.NO_SPK = E.NO_SPK WHERE D.TEMP_CUST IS NOT NULL AND B.NO_CONT LIKE '%$keyword%' AND B.STATUS_CONT != '900' ORDER BY A.ID DESC LIMIT 1");
		return $queryspk->result_array();
	}

	public function checked($check) {
		$query = $this->db->query("SELECT * FROM t_op_reefer WHERE NO_CONT='".$check."' AND waktu IS NOT NULL AND fl_unplug = 'N' ORDER BY ID ASC LIMIT 1");
		return $query->result_array();
	}

	public function temp_akhir($check) {
		$query = $this->db->query("SELECT * FROM t_op_reefer WHERE NO_CONT='$check' AND TEMPERATURE_MONITOR IS NOT NULL AND FL_MONITOR='Y' ORDER BY ID DESC LIMIT 1");
		return $query->result_array();
	}

	public function searchmonitorreefer($keyword) {
		$queryspk=$this->db->query("SELECT * FROM t_op_reefer WHERE WAKTU IS NOT NULL AND NO_CONT LIKE '%$keyword%' ORDER BY ID ASC LIMIT 1");
		return $queryspk->result_array();
	}

	public function serchmonitor($keyword) {
		$queryspk=$this->db->query("SELECT * FROM t_op_reefer WHERE WAKTU IS NOT NULL AND NO_CONT LIKE '%$keyword%' AND WAKTU_END IS NULL ORDER BY ID ASC LIMIT 1");
		return $queryspk->row_array();
	}

	public function temprev($keyword) {
		$queryspk=$this->db->query("SELECT TEMPERATURE_MONITOR FROM t_op_reefer WHERE WAKTU_MONITOR IS NOT NULL AND NO_CONT LIKE '%$keyword%' AND WAKTU_END IS NULL AND FL_MONITOR = 'Y' ORDER BY ID DESC LIMIT 1");
		return $queryspk->row_array();
	}
//end class
}
