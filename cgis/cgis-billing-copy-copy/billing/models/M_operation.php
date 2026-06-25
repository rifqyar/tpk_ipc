<?php

class M_operation extends CI_Model{

	public function __construct(){
		$this->load->database();
	}

	public function index(){
		$headers .= '<link rel="apple-touch-icon" href="'.base_url().'assets/images/apple-touch-icon.png">';
		#Stylesheetss
		$headers  = '<link rel="stylesheet" href="'.base_url().'assets/css/bootstrap.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/bootstrap-extend.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/site.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/jquery-ui/jquery-ui.min.css?v2.1.0">';
		#Plugins For This Page
  		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/filament-tablesaw/tablesaw.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/uikit/modals.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/jquery-wizard/jquery-wizard.min.css?v2.1.0">';
		#Plugins
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/animsition/animsition.min.css?v2.1.0">';
       	$headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/asscrollable/asScrollable.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/switchery/switchery.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/intro-js/introjs.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/slidepanel/slidePanel.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/waves/waves.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/sweetalert/sweetalert.css">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/themes/twitter.css">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/css/newtable.css">';
		$headers .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/toastr/toastr.min.css">';
        #Fonts
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/fonts/material-design/material-design.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/fonts/brand-icons/brand-icons.min.css?v2.1.0">';
        $headers .= '<link rel="stylesheet" href="'.base_url().'assets/fonts/font.css?v2.1.0">';
        #Scripts
		$headers .= '<script src="'.base_url().'assets/js/jquery.min.js"></script>';
		$headers .= '<script src="'.base_url().'assets/js/alerts.js"></script>';
        $headers .= '<script src="'.base_url().'assets/vendor/modernizr/modernizr.min.js"></script>';
        $headers .= '<script src="'.base_url().'assets/vendor/breakpoints/breakpoints.min.js"></script>';
        $headers .= '<script>Breakpoints();</script>';
		#Core
		$footers  = '<script src="'.base_url().'assets/vendor/jquery/jquery.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/vendor/jquery-ui/jquery-ui.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/vendor/bootstrap/bootstrap.js"></script>';
		$footers .= '<script src="'.base_url().'assets/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.js"></script>';
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
		$footers .= '<script src="'.base_url().'assets/vendor/formatter-js/jquery.formatter.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/vendor/jquery-wizard/jquery-wizard.min.js"></script>';
		#Scripts
  		$footers .= '<script src="'.base_url().'assets/js/core.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/js/site.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/sections/menu.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/sections/menubar.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/sections/gridmenu.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/sections/sidebar.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/js/configs/config-colors.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/components/asscrollable.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/components/animsition.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/components/slidepanel.min.js"></script>';
        $footers .= '<script src="'.base_url().'assets/js/components/switchery.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/js/newtable.js"></script>';
		$footers .= '<script src="'.base_url().'assets/js/main.js"></script>';
		$footers .= '<script src="'.base_url().'assets/vendor/sweetalert/sweetalert.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/vendor/filament-tablesaw/tablesaw.js"></script>';
		$footers .= '<script src="'.base_url().'assets/vendor/toastr/toastr.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/js/components/input-group-file.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/js/components/formatter-js.min.js"></script>';
		$footers .= '<script src="'.base_url().'assets/js/components/jquery-wizard.min.js"></script>';

		if($this->session->userdata('LOGGED')){
			if($this->content==""){
				redirect(site_url(),'refresh');
			}
			$data = array('_title_' 	  => 'BOS',
						  '_headers_' 	  => $headers,
						  '_header_' 	  => $this->load->view('content/header','',true),
						  '_menus_'		  => $this->load->view('content/menus','',true),
						  '_breadcrumbs_' => $this->load->view('content/breadcrumbs','',true),
						  '_content_' 	  => (grant()=="")?$this->load->view('content/error','',true):$this->content,
						  '_footers_' 	  => $footers,
						  '_footer_' 	  => $this->load->view('content/menus','',true));
			$this->parser->parse('index', $data);
		}else{
			redirect(base_url('index.php'),'refresh');
		}
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

	public function cek_tspkcontid($parid){//mencocokan inputan dengan ID cont di t_spk_cont
		$queryspk=$this->db->get_where('t_spk_cont', array('ID' => $parid));
		return $queryspk->row_array();
	}
	
	public function cek_alltspkcont($parid){//mencocokan inputan dengan ID cont di t_spk_cont
		$queryspk=$this->db->get_where('t_spk_cont', array('ID' => $parid));
		return $queryspk->result_array();
	}
	
	public function cek_tspk2($parid){//mencocokan inputan dengan id di t_spk
		$queryspk=$this->db->get_where('t_spk', array('ID' => $parid));
		return $queryspk->row_array();
	}

	public function cek_tspk3($parid){//mencocokan inputan dengan id di t_spk
		$SQL = "SELECT * FROM t_spk WHERE NO_SPK='$parid' AND KD_STATUS IN(100,300)";
		$queryspk = $this->db->query($SQL);
		return $queryspk->row_array();
	}
	
	public function ambilspk(){//mengambil data di behandlein untuk menghitung jumlah NO spk yg sama
		$queryspk=$this->db->get('t_op_behandlein');
		return $queryspk->result_array();
	}
	
	public function ambiltruck(){
    		$queryspk=$this->db->query('select * from reff_truck');
    		return $queryspk;
    }
	
	public function ambiltruck2($key){
		$queryspk=$this->db->query("select NO_TRUCK from reff_truck where NOT NO_TRUCK='$key' ");
		return $queryspk;
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
			$this->db->update('t_job_slip', array('KD_STATUS' => $kodenya,'STATUS' => 'WAITING' ));
	}
	
	public function updatejobslipstatus2($kodenya,$idjobslip){

			$this->db->where('ID_JOB_SLIP', $idjobslip );
			$this->db->update('t_job_slip', array('KD_STATUS' => $kodenya ));
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

	public function after_inspection($par,$parc,$pars,$seal,$lok,$iso,$tid,$lokasinya,$tiernya,$statusnya,$skc){
		if ($seal==NULL) {
			$arrdata = array(
					'ISO_CODE' => $iso,
					'LOKASI' => $lokasinya,
					'TIER' => $tiernya,
					'STATUS_CONT_COARI' => $skc,
					'STATUS_CONT' => $statusnya,
					'ID_FLAT' => $tid
				);
		}else {
			$arrdata = array(
					'ISO_CODE' => $iso,
					'ID_FLAT' => $tid,
					'LOKASI' => $lokasinya,
					'STATUS_CONT_COARI' => $skc,
					'TIER' => $tiernya,
					'STATUS_CONT' => $statusnya,
					'NO_SEAL'=> $seal
				);
		}
		
		$keyy= array(
			'NO_CONT' => $par,
			'ID' => $pars
		);
		
		$this->db->where($keyy);
		$this->db->update('t_spk_cont', $arrdata);
		
		if ($parc==1  ) {
			$arrdata2 = array(
				'KD_STATUS' => '400'
			);
			$this->db->where('ID', $pars );
			$this->db->update('t_spk', $arrdata2);
		}
		
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

	public function after_marshalling($par,$par2,$par3){//mengubah KD_STATUS menjadi 300 yaitu status sudah pick up
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
	
	public function pickoper($a,$spk){
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
		$this->load->helper('url');
		$inputan = $this->input->post('nomerspk');
		$query=$this->cek_tspk($inputan);
		$query2=$this->cek_tspkcontid($query['ID']);
		$que=$this->cek_alltspkcont($query['ID']);
		$jenisdokumen=$query['JNS_DOK'];
		$nomerdokumen=$query['NO_DOK'];
		$tanggaldokumen=$query['TGL_DOK'];
		//
		$re  =   $this->M_operation->cek_tspk3($inputan);
		$spk= $this->M_operation->searchco($re['ID']);

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
				$this->content = $this->load->view('content/operation/pickup',$data,true);
				$this->index();
			}else{
				if ($query['KD_STATUS']=='100') {
					$this->after_pickup($inputan,$query2,$arr,$spk);
					$this->db->insert('t_op_pickup',$dsimpan);
					$this->pickoper($que,$inputan,$jenisdokumen,$nomerdokumen,$tanggaldokumen);
					$data['notif']=1;
					$data['NOSPK']=$inputan;
					$this->content = $this->load->view('content/operation/pickup',$data,true);
					$this->index();
				}elseif ($query['KD_STATUS']=='300') {
					$this->after_pickup($inputan,$query2,$arr,$spk);
					$this->db->insert('t_op_pickup',$dsimpan2);
					$data['notif']=1;
					$data['NOSPK']=$inputan;
					$this->content = $this->load->view('content/operation/pickup',$data,true);
					$this->index();
				}else {
					$data['notif']=2;
					$data['NOSPK']=$inputan;
					$this->content = $this->load->view('content/operation/pickup',$data,true);
					$this->index();
				}// return $this->db->insert('t_op_pickup',$dsimpan);
			}
		}else {
			$data['notif']=3;
			$data['NOSPK']=$inputan;
			$this->content = $this->load->view('content/operation/pickup',$data,true);
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
					$this->content = $this->load->view('content/operation/hold',$data,true);
					$this->index();
				}elseif ($query['KD_STATUS']=='300') {
					$data['notif']=2;
					$data['NOSPK']=$inputan;
					$this->content = $this->load->view('content/operation/hold',$data,true);
					$this->index();
				}else {
					$data['notif']=3;
					$data['NOSPK']=$inputan;
					$this->content = $this->load->view('content/operation/hold',$data,true);
					$this->index();
				}
			}else {
				$data['notif']=4;
				$data['NOSPK']=$inputan;
				$this->content = $this->load->view('content/operation/hold',$data,true);
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
			$this->load->helper('url');
				//variabel
				$inputan2= $this->input->post('nomerkon');
				$urut=$this->ambilspk();
				$nilai=1;
				$isocode=$this->input->post('isocode');
				$noseal=$this->input->post('noseal');
				$lokas=$this->input->post('nolok');
				$lokasi=trim($lokas);
				$notid=$this->input->post('trucknya');
				$stakoncoar= $this->input->post('optradiostatus');
				 
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
					$datalokasi=strtoupper(substr($lok,0,6));
					$datatier=substr($lok,-1);
					$denahlokasi=$this->cekdenah($datalokasi,$datatier);
					$hasillokasi=$this->ceklokasiterpakai3($lok);
				$wkt=date('Y-m-d H:i:s');
				$ar=$this->db->query("SELECT * FROM t_job_slip WHERE NO_SPK='$nomerespk' AND NO_CONT='$inputan2' AND STATUS='WAITING' ")->row_array();
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
				$this->content = $this->load->view('content/operation/inspection',$data,true);
				$this->index();
			}elseif($cekval==2){*/
			if ($query['KD_STATUS']=='200') {
					if ( $query2['STATUS_CONT']=='200') {
						//proses baru
								if(substr($lok,0,3)=="CIC" || substr($lok,0,3)=="cic"){
									$varlokasi=substr($lok,0,5);
									$vartier=substr($lok,-1);
									if($hasillokasi['LOKASI']==$varlokasi){
										$data['notif']=4;
										$data['NOCONT']=$hasillokasi['NO_CONT'];
										$this->content = $this->load->view('content/operation/inspection',$data,true);
										$this->index();
									}else{
										$this->db->insert('t_op_behandlein',$dsimpan);
										
										$this->after_inspection($inputan2,$coun2,$query2['ID'],$noseal,$lokasi,$isocode,$notid,$varlokasi,$vartier,"460",$stakoncoar);
										
										
										$this->db->where($keyy);
										$this->db->update('t_operation',$dsi);
										
										$this->db->where($keyy);
										$this->db->update('t_job_slip',$stat);
										//update t_denah
										$this->db->where(array('NM_BLOK' => $varlokasi, 'LEVEL_4' =>$vartier));
										$this->db->update('t_denah_lapangan', array('USE'=>'1'));
										// 
										//$this->ubahlok2($inputan2,$varlokasi,$vartier,"460",$spid);
										$arrdata = array(
											'NO_SPK'=>$spk1,
											'OPERATOR' => $this->session->userdata('USERLOGIN'),
											'TGL_SPK'=>$tglspk,
											'JNS_DOK'=>$jnsdok,
											'NO_CONT' => $inputan2,
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
										$this->content = $this->load->view('content/operation/inspection',$data,true);
										$this->index();
									}
								}elseif(substr($lok,0,2)=="1A" || substr($lok,0,2)=="1a" || substr($lok,0,2)=="YA" ){
									if($hasillokasi['LOKASI']==$datalokasi){
										$data['notif']=4;
										$data['NOCONT']=$hasillokasi['NO_CONT'];
										$this->content = $this->load->view('content/operation/inspection',$data,true);
										$this->index();
									}else{
										if ($denahlokasi['NM_BLOK']==$datalokasi){
											$this->db->insert('t_op_behandlein',$dsimpan);
											$van2=substr($lok,0,6);
											$tie=substr($lok,-1);
											//$this->ubahlok2($inputan2,$van2,$tie,"450",$spid);
											$this->after_inspection($inputan2,$coun2,$query2['ID'],$noseal,$lokasi,$isocode,$notid,$van2,$tie,"450",$stakoncoar);
											
											$this->db->where($keyy);
											$this->db->update('t_operation',$dsi);
											$this->db->where($keyy);
											$this->db->update('t_job_slip',$stat);
											//update t_denah_lapangan
											$this->db->where(array('NM_BLOK' => $van2, 'LEVEL_4' =>$tie));
											$this->db->update('t_denah_lapangan', array('USE'=>'1'));
											
											if(isset($nogat)){
												$arrdata = array(
													'OPERATOR' => $this->session->userdata('USERLOGIN'),
													'NO_SPK'=>$spk1,
													'TGL_SPK'=>$tglspk,
													'JNS_DOK'=>$jnsdok,
													'NO_CONT' => $inputan2,
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
												$arrdata = array(
													'OPERATOR' => $this->session->userdata('USERLOGIN'),
													'NO_SPK'=>$spk1,
													'TGL_SPK'=>$tglspk,
													'NO_CONT' => $inputan2,
													'NO_GATEPASS'=>$nogat,
													'LOKASI_AWAL'=>$van2,
													'TIER_AWAL'=>$tie,
													'TGL_GATEPASS'=>$tglg,
													'KD_STATUS'=>'10',
													'STATUS'=>'WAITING'
												);
											}
											
											$this->updatejobslipstatus2("50",$idjobnya);  
											$this->db->insert('t_job_slip',$arrdata);
											
											$data['notif']=1;
											$data['NOCONT']=$inputan2;
											$this->content = $this->load->view('content/operation/inspection',$data,true);
											$this->index();
										}else{
											$data['notif']=5;
											$data['NOTIER']=$datatier;
											$data['lokasikontainer']=$lok;
											$data['nomerkontainer']=$inputan2;
											$this->content = $this->load->view('content/operation/inspection',$data,true);
											$this->index();
										}
									}  
								}elseif(substr($lok,0,2)=="1B" || substr($lok,0,2)=="1b" || substr($lok,0,2)=="YB"){
									if($hasillokasi['LOKASI']==$datalokasi){
										$data['notif']=4;
										$data['NOCONT']=$hasillokasi['NO_CONT'];
										$this->content = $this->load->view('content/operation/inspection',$data,true);
										$this->index();
									}else{
										if ($denahlokasi['NM_BLOK']==$datalokasi){
											$this->db->insert('t_op_behandlein',$dsimpan);
											$van2=substr($lok,0,6);
											$tie=substr($lok,-1);
											//$this->ubahlok2($inputan2,$van2,$tie,"450",$spid);
											$this->after_inspection($inputan2,$coun2,$query2['ID'],$noseal,$lokasi,$isocode,$notid,$van2,$tie,"450",$stakoncoar);
											
											$this->db->where($keyy);
											$this->db->update('t_operation',$dsi);
											$this->db->where($keyy);
											$this->db->update('t_job_slip',$stat);
											//update t_denah_lapangan
											
											$this->db->where(array('NM_BLOK' => $van2, 'LEVEL_4' =>$tie));
											$this->db->update('t_denah_lapangan', array('USE'=>'1'));
											
											if(isset($nogat)){
												$arrdata = array(
													'OPERATOR' => $this->session->userdata('USERLOGIN'),
													'NO_SPK'=>$spk1,
													'TGL_SPK'=>$tglspk,
													'NO_CONT' => $inputan2,
													'JNS_DOK'=>$jnsdok,
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
												$arrdata = array(
													'OPERATOR' => $this->session->userdata('USERLOGIN'),
													'NO_SPK'=>$spk1,
													'TGL_SPK'=>$tglspk,
													'NO_CONT' => $inputan2,
													'NO_GATEPASS'=>$nogat,
													'LOKASI_AWAL'=>$van2,
													'TIER_AWAL'=>$tie,
													'TGL_GATEPASS'=>$tglg,
													'KD_STATUS'=>'10',
													'STATUS'=>'WAITING'
												);
											}
											
											$this->updatejobslipstatus2("50",$idjobnya);  
											$this->db->insert('t_job_slip',$arrdata);
											$data['notif']=1;
											$data['NOCONT']=$inputan2;
											$this->content = $this->load->view('content/operation/inspection',$data,true);
											$this->index();
											
										}else{
											$data['notif']=5;
											$data['NOTIER']=$datatier;
											$data['lokasikontainer']=$lok;
											$data['nomerkontainer']=$inputan2;
											$this->content = $this->load->view('content/operation/inspection',$data,true);
											$this->index();
										}
									}
								}	
						//end proses
					}elseif ( $query2['STATUS_CONT']=='400') {
						$data['notif']=2;
						$data['NOCONT']=$inputan2;
						$this->content = $this->load->view('content/operation/inspection',$data,true);
						$this->index();
					}else {
						$data['notif']=3;
						$data['NOCONT']=$inputan2;
						$this->content = $this->load->view('content/operation/inspection',$data,true);
						$this->index();
					}
			}else {
				$data['notif']=4;
				$data['NOCONT']=$inputan2;
				$this->content = $this->load->view('content/operation/inspection',$data,true);
				$this->index();
				;
			}
				/*}elseif($cekval==3){
					$data['notif']=7;
					$data['NOCONT']=$hasillokasi['NO_CONT'];
					$this->content = $this->load->view('content/operation/inspection',$data,true);
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
			//$data = array('LOKASI' => $loka,'TIER'=>$tier,'STATUS_CONT'=>$stat);

			//$where = "NO_CONT = '$cont' AND ID = '$spid'";

			//$str = $this->db->update_string('table_name', $data, $where);
			$this->db->where(array('NO_CONT' => $cont, 'ID' => $spid));
			$this->db->update('t_spk_cont', array('LOKASI' => $loka,'TIER'=>$tier,'STATUS_CONT'=>$stat));
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
						
	/*public function set_marshalling(){
			$this->load->helper('url');
			$oopp =$this->session->userdata('USERLOGIN');
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
				$data['nilai']=$this->getalljobs();
				$this->content = $this->load->view('content/operation/marshalling',$data,true);
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
						$data['nilai']=$this->getalljobs();
						$this->content = $this->load->view('content/operation/marshalling',$data,true);
						$this->index();
					 }else{
						 $this->db->where('ID_JOB_SLIP',$inp2);
						 $this->db->update('t_job_slip', array('STATUS'=>'DONE', 'STATUS_JOB' => 'Y', 'KD_STATUS' =>50,'OPERATOR' => $oopp, 'WK_STATUS' => $wkt));
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
						// 
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
							'NO_CONT' => $nock,
							'KD_STATUS'=> '460',
							'WK_STATUS'=> date('Y-m-d H:i:s'),
							'OPERATOR'=> $this->session->userdata('USERLOGIN')
						  );
						$this->db->insert('t_operation_new',$arrmarshalling); 
						//
						$data['notif']=1;
						$data['lokasikontainer']=$this->input->post('lokak');
						$data['nomerkontainer']=$this->input->post('nocont');
						$data['jobs']=$this->input->post('jobs');
						$data['nilai']=$this->getalljobs();
						$this->content = $this->load->view('content/operation/marshalling',$data,true);
						$this->index();
					 }
				  }elseif(substr($lok,0,2)=="1A" || substr($lok,0,2)=="1a" || substr($lok,0,2)=="YA" ){
					if($hasillokasi['LOKASI']==$datalokasi){
						$data['notif']=4;
						$data['nokont']=$hasillokasi['NO_CONT'];
						$data['lokasikontainer']=$this->input->post('lokak');
						$data['nomerkontainer']=$this->input->post('nocont');
						$data['jobs']=$this->input->post('jobs');
						$data['nilai']=$this->getalljobs();
						$this->content = $this->load->view('content/operation/marshalling',$data,true);
						$this->index();
					 }else{
						if ($denahlokasi['NM_BLOK']==$datalokasi){
							$this->db->where('ID_JOB_SLIP',$inp2);
							$this->db->update('t_job_slip', array('STATUS'=>'DONE','STATUS_JOB' => 'Y','KD_STATUS' =>50,'OPERATOR' => $oopp,'WK_STATUS' => $wkt));
							//$this->db->query("UPDATE t_job_slip SET STATUS='DONE',STATUS_JOB='Y',KD_STATUS='50','OPERATOR'='$oopp', WK_STATUS='$wkt' WHERE ID_JOB_SLIP='$inp2' ");
							$van2=substr($lok,0,6);
							$tie=substr($lok,-1);
							$this->ubahlok2($inp,$van2,$tie,"450",$spid);
							//update t_denah_lapangan
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
							//
							$data['notif']=1;
							$data['lokasikontainer']=$this->input->post('lokak');
							$data['nomerkontainer']=$this->input->post('nocont');
							$data['jobs']=$this->input->post('jobs');
							$data['nilai']=$this->getalljobs();
							$this->content = $this->load->view('content/operation/marshalling',$data,true);
							$this->index();
						}else{
							$data['notif']=3;
							$data['NOTIER']=$datatier;
							$data['lokasikontainer']=$this->input->post('lokak');
							$data['nomerkontainer']=$this->input->post('nocont');
							$data['jobs']=$this->input->post('jobs');
							$data['nilai']=$this->getalljobs();
							$this->content = $this->load->view('content/operation/marshalling',$data,true);
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
						$data['nilai']=$this->getalljobs();
						$this->content = $this->load->view('content/operation/marshalling',$data,true);
						$this->index();
					 }else{
						if ($denahlokasi['NM_BLOK']==$datalokasi){
							$this->db->where('ID_JOB_SLIP',$inp2);
							$this->db->update('t_job_slip', array('STATUS'=>'DONE','STATUS_JOB' => 'Y','KD_STATUS' =>50,'OPERATOR' => $oopp,'WK_STATUS' => $wkt));
							//$this->db->query("UPDATE t_job_slip SET STATUS='DONE',STATUS_JOB='Y', KD_STATUS='50', 'OPERATOR'='$oopp', WK_STATUS='$wkt' WHERE ID_JOB_SLIP='$inp2' ");
							$van2=substr($lok,0,6);
							$tie=substr($lok,-1);
							$this->ubahlok2($inp,$van2,$tie,"450",$spid);
							//update t_denah_lapangan
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
							//
							$data['notif']=1;
							$data['lokasikontainer']=$this->input->post('lokak');
							$data['nomerkontainer']=$this->input->post('nocont');
							$data['jobs']=$this->input->post('jobs');
							$data['nilai']=$this->getalljobs();
							$this->content = $this->load->view('content/operation/marshalling',$data,true);
							$this->index();
						}else{
							$data['notif']=3;
							$data['NOTIER']=$datatier;
							$data['lokasikontainer']=$this->input->post('lokak');
							$data['nomerkontainer']=$this->input->post('nocont');
							$data['jobs']=$this->input->post('jobs');
							$data['nilai']=$this->getalljobs();
							$this->content = $this->load->view('content/operation/marshalling',$data,true);
							$this->index();
						}	
					 }  
				  }
				}	
	}*/

//=================================================================================================================================================	

	public function set_marshallingcic(){
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
			$this->content = $this->load->view('content/operation/marshallingcic',$data,true);
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
					$this->content = $this->load->view('content/operation/marshallingcic',$data,true);
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
					$this->content = $this->load->view('content/operation/marshallingcic',$data,true);
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
				$this->content = $this->load->view('content/operation/marshallingcic',$data,true);
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
						$this->content = $this->load->view('content/operation/marshallingcic',$data,true);
						$this->index();
					}else{
						$data['notif']=3;
						$data['NOTIER']=$datatier;
						$data['lokasikontainer']=$this->input->post('lokak');
						$data['nomerkontainer']=$this->input->post('nocont');
						$data['jobs']=$this->input->post('jobs');
						$data['nilai']=$this->getalljobscic();
						$this->content = $this->load->view('content/operation/marshallingcic',$data,true);
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
					$this->content = $this->load->view('content/operation/marshallingcic',$data,true);
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
						$this->content = $this->load->view('content/operation/marshallingcic',$data,true);
						$this->index();
					}else{
						$data['notif']=3;
						$data['NOTIER']=$datatier;
						$data['lokasikontainer']=$this->input->post('lokak');
						$data['nomerkontainer']=$this->input->post('nocont');
						$data['jobs']=$this->input->post('jobs');
						$data['nilai']=$this->getalljobscic();
						$this->content = $this->load->view('content/operation/marshallingcic',$data,true);
						$this->index();
					}			
				}  
			}
		}	
	}
//=================================================================================================================================================	

	public function set_marshallingyard(){
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
			$this->content = $this->load->view('content/operation/marshallingyard',$data,true);
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
					$this->content = $this->load->view('content/operation/marshallingyard',$data,true);
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
					$this->content = $this->load->view('content/operation/marshallingyard',$data,true);
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
				$this->content = $this->load->view('content/operation/marshallingyard',$data,true);
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
						$this->content = $this->load->view('content/operation/marshallingyard',$data,true);
						$this->index();
					}else{
						$data['notif']=3;
						$data['NOTIER']=$datatier;
						$data['lokasikontainer']=$this->input->post('lokak');
						$data['nomerkontainer']=$this->input->post('nocont');
						$data['jobs']=$this->input->post('jobs');
						$data['nilai']=$this->getalljobsyard();
						$this->content = $this->load->view('content/operation/marshallingyard',$data,true);
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
					$this->content = $this->load->view('content/operation/marshallingyard',$data,true);
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
						$this->content = $this->load->view('content/operation/marshallingyard',$data,true);
						$this->index();
					}else{
						$data['notif']=3;
						$data['NOTIER']=$datatier;
						$data['lokasikontainer']=$this->input->post('lokak');
						$data['nomerkontainer']=$this->input->post('nocont');
						$data['jobs']=$this->input->post('jobs');
						$data['nilai']=$this->getalljobsyard();
						$this->content = $this->load->view('content/operation/marshallingyard',$data,true);
						$this->index();
					}			
				}  
			}
		}	
	}
//=================================================================================================================================================

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
				//mengambil jenis kegiatan
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
								$this->content = $this->load->view('content/operation/realisasibi',$data,true);
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
								$this->content = $this->load->view('content/operation/realisasibi',$data,true);
								$this->index();
							}
						}else {//not ready
								$data['notif']=6;
								$data['NOCONT']=$inputan2;
								$this->content = $this->load->view('content/operation/realisasibi',$data,true);
								$this->index();
						}
				}else {
						//not found no cont
							$data['notif']=6;
							$data['NOCONT']=$inputan2;
							$this->content = $this->load->view('content/operation/realisasibi',$data,true);
							$this->index();
				}
	}

//=================================================================================================================================================

	public function ambilmarshcic($keyword){
		$SQL = "SELECT A.ID_JOB_SLIP,A.NO_CONT,C.UKR_CONT,A.LOKASI_AWAL,A.LOKASI_AKHIR,A.TIER_AWAL,A.TIER_AKHIR,A.JENIS,C.RESPON
			FROM t_job_slip A
			INNER JOIN t_spk B ON A.NO_SPK = B.NO_SPK
			INNER JOIN t_gatepass C ON A.NO_GATEPASS = C.ID
			WHERE A.NO_CONT like'%$keyword%' AND A.STATUS = 'WAITING' AND A.KD_STATUS='20' AND A.LOKASI_AKHIR IS NOT NULL AND A.LOKASI_AWAL IS NOT NULL
			AND C.FL_ACTIVE = 'Y' AND A.JENIS IN('BEHANDLE 1','BEHANDLE 2')
			GROUP BY A.NO_CONT
			ORDER BY A.WK_STATUS ASC
			LIMIT 10";
		$queryspk = $this->db->query($SQL);
		return $queryspk->result_array();
	}
//=================================================================================================================================================
	public function ambilmarshyard($keyword,$job){
		$SQL = "SELECT A.ID_JOB_SLIP,A.NO_CONT,C.UKR_CONT,A.LOKASI_AWAL,A.LOKASI_AKHIR,A.TIER_AWAL,A.TIER_AKHIR,A.JENIS
			FROM t_job_slip A
			INNER JOIN t_spk B ON A.NO_SPK = B.NO_SPK
			INNER JOIN t_gatepass C ON A.NO_GATEPASS = C.ID
			WHERE A.NO_CONT like'%$keyword%' AND A.STATUS = 'WAITING' AND A.KD_STATUS='20' AND A.LOKASI_AKHIR IS NOT NULL AND A.LOKASI_AWAL IS NOT NULL
			AND C.FL_ACTIVE = 'Y' AND A.JENIS IN('EX BEHANDLE 1','EX BEHANDLE 2')
			GROUP BY A.NO_CONT
			ORDER BY A.WK_STATUS ASC
			LIMIT 10";
		$queryspk = $this->db->query($SQL);
		return $queryspk->result_array();
	}
//=================================================================================================================================================
			
//=================================================================================================================================================
	public function getalljobscic(){
		$var='CIC';
		$SQL = "SELECT A.ID_JOB_SLIP,A.NO_CONT,C.UKR_CONT,A.LOKASI_AWAL,A.LOKASI_AKHIR,A.TIER_AWAL,A.TIER_AKHIR,A.JENIS, A.JENIS, C.RESPON
			FROM t_job_slip A
			INNER JOIN t_spk B ON A.NO_SPK = B.NO_SPK
			INNER JOIN t_gatepass C ON A.NO_GATEPASS = C.ID
			WHERE A.STATUS = 'WAITING' AND A.KD_STATUS='20' AND A.LOKASI_AKHIR IS NOT NULL AND A.LOKASI_AWAL IS NOT NULL
			AND C.FL_ACTIVE = 'Y' AND A.JENIS IN('BEHANDLE 1','BEHANDLE 2')
			GROUP BY A.NO_CONT
			ORDER BY A.WK_STATUS ASC
			";
			$queryspk = $this->db->query($SQL);
			//$queryspk=$this->db->query("select * from t_job_slip where STATUS='WAITING' AND KD_STATUS='20' AND LOKASI_AKHIR IS NOT NULL AND LOKASI_AWAL IS NOT NULL ORDER BY LOKASI_AKHIR LIMIT 10 ");
			return $queryspk->result_array();
	}
//=================================================================================================================================================
	public function getalljobsyard(){
		$var='CIC';
		$SQL = "SELECT A.ID_JOB_SLIP,A.NO_CONT,C.UKR_CONT,A.LOKASI_AWAL,A.LOKASI_AKHIR,A.TIER_AWAL,A.TIER_AKHIR,A.JENIS, A.JENIS, C.RESPON
			FROM t_job_slip A
			INNER JOIN t_spk B ON A.NO_SPK = B.NO_SPK
			INNER JOIN t_gatepass C ON A.NO_GATEPASS = C.ID
			WHERE A.STATUS = 'WAITING' AND A.KD_STATUS='20' AND A.LOKASI_AKHIR IS NOT NULL AND A.LOKASI_AWAL IS NOT NULL
			AND C.FL_ACTIVE = 'Y' AND A.JENIS IN('EX BEHANDLE 1','EX BEHANDLE 2')
			GROUP BY A.NO_CONT
			ORDER BY A.WK_STATUS ASC
			LIMIT 10";
			$queryspk = $this->db->query($SQL);
			//$queryspk=$this->db->query("select * from t_job_slip where STATUS='WAITING' AND KD_STATUS='20' AND LOKASI_AKHIR IS NOT NULL AND LOKASI_AWAL IS NOT NULL ORDER BY LOKASI_AKHIR LIMIT 10 ");
			return $queryspk->result_array();
	}
//=================================================================================================================================================
			
//=================================================================================================================================================
	public function datajumlahmarshallingcic(){
		$queryspk=$this->db->query("SELECT DISTINCT A.ID_JOB_SLIP,A.NO_CONT,A.LOKASI_AWAL,A.LOKASI_AKHIR
			FROM t_job_slip A
			INNER JOIN t_spk B ON A.NO_SPK = B.NO_SPK
			INNER JOIN t_gatepass C ON A.NO_GATEPASS = C.ID
			WHERE A.STATUS = 'WAITING' AND A.KD_STATUS='20' AND A.LOKASI_AKHIR IS NOT NULL AND A.LOKASI_AWAL IS NOT NULL
			AND C.FL_ACTIVE = 'Y' AND A.JENIS IN ('BEHANDLE 1','BEHANDLE 2')");
		return $queryspk->result_array();
	}
//=================================================================================================================================================
	public function datajumlahmarshallingyard(){
		$queryspk=$this->db->query("SELECT DISTINCT A.ID_JOB_SLIP,A.NO_CONT,A.LOKASI_AWAL,A.LOKASI_AKHIR
			FROM t_job_slip A
			INNER JOIN t_spk B ON A.NO_SPK = B.NO_SPK
			INNER JOIN t_gatepass C ON A.NO_GATEPASS = C.ID
			WHERE A.STATUS = 'WAITING' AND A.KD_STATUS='20' AND A.LOKASI_AKHIR IS NOT NULL AND A.LOKASI_AWAL IS NOT NULL
			AND C.FL_ACTIVE = 'Y' AND A.JENIS IN ('EX BEHANDLE 1','EX BEHANDLE 2')");
		return $queryspk->result_array();
	}
//=================================================================================================================================================

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

    public function searchreal($keyword){
	        $queryspk=$this->db->query("select * from t_spk_cont where NO_CONT LIKE '%$keyword%' AND STATUS_CONT IN('460')");
			return $queryspk->result_array();
    }
			
	public function searcinspect($keyword){
		$queryspk=$this->db->query("select * from t_op_delivery where NO_CONT LIKE '%$keyword%' AND WK_TRUCKIN IS NOT NULL AND WK_CHASSIS IS NOT NULL AND WK_INSPECT IS NULL");
		return $queryspk->result_array();
	}

	public function ambilkondisi(){
		$queryspk=$this->db->query('select ID,KONDISI from reff_kondisi');
		return $queryspk;
	}

	public function searchco($keyword){
		$SQL = "select * from t_spk_cont where ID='$keyword' ";
		//echo $SQL;
        $query  =   $this->db->query($SQL);
        return $query->result_array();
	}

	public function searchdeliv($keyword){
		$query= $this->db->query("select * from t_op_delivery where NO_CONT LIKE '%$keyword%'");
		return $query->result_array();
	}

	public function searchdeliv2($keyword){
		$query= $this->db->query("select * from t_gatepass where NO_CONT LIKE '%$keyword%' AND JNS_KEGIATAN='3' ");
		return $query->result_array();
	}
	
	public function searcingdelive($keyword){
		$query= $this->db->query("select A.* from t_gatepass A inner join t_spk_cont B ON A.NO_CONT=B.NO_CONT where A.NO_CONT LIKE '%$keyword%' AND A.JNS_KEGIATAN='3' AND B.STATUS_CONT !=900 ");
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
						'OPERATOR_T' => $this->session->userdata('USERLOGIN'),
						'WK_TRUCKIN' => date('Y-m-d H:i:s')
				);	
				$arr = array(
					'NO_CONT' => $inp, 
					'NO_TRUCK' => $truk,
					'NO_SPK' => $nomerspk, 
					'DAILYSECNO' => $nosec, 
					'LINE' => $this->input->post('gate'),
					'OPERATOR' => $this->session->userdata('USERLOGIN'), 
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
				$this->content = $this->load->view('content/operation/delivery',$data,true);
				$this->index();
			}else{
				$dsimpan= array(
					'GATE_O' => $this->input->post('gate'),
					'OPERATOR_G' => $this->session->userdata('USERLOGIN'),
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
					'LOKASI_END' =>$con['LOKASI'] ,
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
				$this->content = $this->load->view('content/operation/delivery',$data,true);
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
				$this->content = $this->load->view('content/operation/inspectout',$data,true);
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
				$this->content = $this->load->view('content/operation/inspectout',$data,true);
				$this->index();
			}
	}
			
	public function ubahstatusdelivery($parcont,$par2){
		$this->db->query("UPDATE t_spk_cont SET STATUS_CONT='$par2' WHERE NO_CONT='$parcont' AND STATUS_CONT NOT IN ('900')");
	}

	public function getalldelivery(){
		$SQL = $this->db->query("SELECT * FROM t_op_delivery Where WK_TRUCKIN IS NOT NULL AND WK_CHASSIS IS NULL");
		return $SQL->result_array();
	}

	public function ambilchases($keyword){
		$SQL = $this->db->query("SELECT * FROM t_op_delivery Where NO_CONT like '%$keyword%'  AND WK_CHASSIS IS NULL ");
		return $SQL->result_array();
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
		$this->content = $this->load->view('content/operation/onchases',$data,true);
		$this->index();
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
		if($datakdstatus=='100' || $datakdstatus=='000' ){
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
				$this->content = $this->load->view('content/operation/copy',$data,true);
				$this->index();
			}elseif(substr($loka,0,3)==="CIC" && substr($loklama,0,2)==="1B" || substr($loka,0,2)==="1A" && substr($loklama,0,2)==="1B" ){
				//ketika 1 b
				$data['notif']=7;
				$data['NOCONT']=$inp;
				$data['VARA']="1A";
				$data['VARB']="CIC";
				$this->content = $this->load->view('content/operation/copy',$data,true);
				$this->index();
			}elseif(substr($loka,0,2)==="1B" && substr($loklama,0,3)==="CIC" || substr($loka,0,2)==="1A" && substr($loklama,0,3)==="CIC" ){
				//ketika CIC
				$data['notif']=7;
				$data['NOCONT']=$inp;
				$data['VARA']="1A";
				$data['VARB']="1B";
				$this->content = $this->load->view('content/operation/copy',$data,true);
				$this->index();
			}else{
				$lokasiterpakai=$this->ceklokasiterpakai($loka);
				$flat=$this->getflatcopy($loka);
				if(count($flat)==0){
				$data['notif']=5;
				$data['NOCONT']=$inp;
				$this->content = $this->load->view('content/operation/copy',$data,true);
				$this->index();
				}else{
					if(count($lokasiterpakai)>0){
						$data['notif']=4;
						$data['NOCONT']=$inp;
						$this->content = $this->load->view('content/operation/copy',$data,true);
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
								$this->content = $this->load->view('content/operation/copy',$data,true);
								$this->index();
						}else{
							$data['notif']=3;
							$data['NOCONT']=$inp;
							$this->content = $this->load->view('content/operation/copy',$data,true);
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
			$this->content = $this->load->view('content/operation/copy',$data,true);
			$this->index();
		}
	}
	
	public function searchop($keyword){
		$queryspk=$this->db->query("SELECT A.*, C.NAMA, D.KETERANGAN
									FROM t_spk_cont A
									INNER JOIN t_spk B ON A.ID=B.ID
									INNER JOIN reff_kode_dok_bc C ON B.JNS_DOK=C.ID
									INNER JOIN reff_status_spk D ON A.STATUS_CONT=D.ID
									WHERE A.NO_CONT LIKE '%$keyword%' AND NOT A.STATUS_CONT='900' OR A.NO_CONT LIKE '%$keyword%' AND A.LOKASI='SAMPAH'");
		return $queryspk->result_array();
	}
			
	public function searchop2($keyword){
		$queryspk=$this->db->query("SELECT A.*, C.NAMA, D.KETERANGAN
										FROM t_spk_cont A
										INNER JOIN t_spk B ON A.ID=B.ID
										INNER JOIN reff_kode_dok_bc C ON B.JNS_DOK=C.ID
										INNER JOIN reff_status_spk D ON A.STATUS_CONT=D.ID
										WHERE A.NO_CONT LIKE '%$keyword%' AND NOT A.STATUS_CONT='900' OR A.NO_CONT LIKE '%$keyword%' AND A.LOKASI='SAMPAH'");
		return $queryspk->row_array();
	}

//end class
}
