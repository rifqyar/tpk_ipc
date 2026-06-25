<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
		
	class Online extends CI_Controller {
	
		public function __construct()
		{
			parent::__construct();
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
			$headers .= '<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.ui/1.8.10/jquery-ui.min.js"></script>';
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
			$footers .= '<script src="'.base_url().'assets/js/reload.js"></script>';
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
				$this->parser->parse('online', $data);
			}else{
				redirect(base_url('index.php'),'refresh');
			}
		}


		public function monitorOrderOnline($act, $id) {
			if (!$this->session->userdata('LOGGED')){
				$this->index();
				return;
			}
			
			$id = ($id!="")?$id:$this->input->post('id');

			if($act == "add_data"){
				$data['id'] = $id;
				//echo $data['id'];die();
				$data['arrdata']= $this->db->query("SELECT ID, ID_DOKUMEN, NO_DOK, TGL_DOK, TYPE_DOK,  NOTE, FL_STATUS FROM list_dokumens WHERE ID = '".$id."'")->row(); 
				//echo $data['arrdata'];die();
				echo $this->content = $this->load->view('content/dokumen/form_proses',$data);
			}else if($act == "add_data_tolak"){
				$data['id'] = $id;
				//echo $data['id'];die();
				$data['arrdata']= $this->db->query("SELECT ID, ID_DOKUMEN, NO_DOK, TGL_DOK, TYPE_DOK,  NOTE, FL_STATUS FROM list_dokumens WHERE ID = '".$id."'")->row(); 
				//echo $data['arrdata'];die();
				echo $this->content = $this->load->view('content/dokumen/form_tolak',$data);
			}else if($act == "print"){
				$data['id'] = $id;
				//echo $data['id'];die();
				$data['arrdata']= $this->db->query("SELECT ID, ID_DOKUMEN, NO_DOK, TGL_DOK, TYPE_DOK,  NOTE, FL_STATUS, FILE_DOK FROM list_dokumens WHERE ID = '".$id."'")->row(); 
				$data['test'] = explode("#",$data['arrdata']->FILE_DOK);

				// var_dump($data);die();
				// $arrid = explode("~",$id);
				// $id = $arrid;die();

				echo $this->content = $this->load->view('content/dokumen/list_dokumen',$data);
			}else {
				$this->load->model("m_display");
				$arrdata = $this->m_display->getresponrequestonline($act, $id);
				$data = $this->load->view('content/newtable', $arrdata, true);
				if($this->input->post("ajax")||$act=="post"){
					echo $arrdata;
				}else{
					$this->content = $data;
					$this->index();
				}	
			}
		}
		

		public function prosesonline()
		{
			$id = $_GET['id'];
			
			$fl_status = $this->input->post('FL_STATUS');
			$note = $this->input->post('NOTE');
			$id_dokumen = $this->input->post('ID_DOKUMEN');
			 //echo "$fl_status";die();

			try {
			
			$list_dokumen = $this->db->query("SELECT * FROM tpk_ipc.list_dokumens  WHERE ID = $id")->num_rows();

			if($list_dokumen != 0 ){
			$url ="http://10.1.6.177/api/prosesdokumen";
			$postData = array('id' => $id_dokumen,'fl_status' => 'Y','note' => $note);
			
			$data = http_build_query($postData);
		
			$curl = curl_init();
			curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => $data,
			));

			$response = curl_exec($curl);

			if (!curl_errno($curl)) {
				  $info = curl_getinfo($curl);
				  echo "Connection Success , This is Url : ", $info['url'], "\r\n";
				}else{
				  echo "Connection Failed =".curl_error($curl);
			  }
			curl_close($curl);
			// var_dump($response);die();
			$json = json_encode($response);
				if (preg_match("/success/i", $json)) {
					$this->db->query("UPDATE tpk_ipc.list_dokumens SET  NOTE ='$note', FL_STATUS ='Y' WHERE ID=$id");
					echo "MSG#OK#Data berhasil diproses#";
				}else if (preg_match("/data tidak di temukan/i", $json)) {
					$this->db->delete('tpk_ipc.list_dokumens', array('ID' => $id));
					echo "MSG#ERR#Data tidak di temukan#";
				}
			//var_dump($json);die();
			}else {
				echo "MSG#ERR#Data tidak bisa di Prosess#";
			}
			
			} catch (\Throwable $th) {
				echo "MSG#ERR#Data tidak bisa di Prosess#";
			}

		}


		public function prosesonlinetolak()
		{
			$id = $_GET['id'];
			
			$fl_status = $this->input->post('FL_STATUS');
			$note = $this->input->post('NOTE');
			$id_dokumen = $this->input->post('ID_DOKUMEN');
			//echo "$fl_status";die();

			try {
			
			$list_dokumen = $this->db->query("SELECT * FROM tpk_ipc.list_dokumens  WHERE ID = $id")->num_rows();
			
			if($list_dokumen != 0 ){
			$url ="http://10.1.6.177/api/prosesdokumen";
			$postData = array('id' => $id_dokumen,'fl_status' => 'X','note' => $note);
			
			$data = http_build_query($postData);
			// var_dump($data);die();
			$curl = curl_init();
			curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => $data,
			));

			$response = curl_exec($curl);

			if (!curl_errno($curl)) {
				  $info = curl_getinfo($curl);
				  echo "Connection Success , This is Url : ", $info['url'], "\r\n";
				}else{
				  echo "Connection Failed =".curl_error($curl);
			  }
			curl_close($curl);
			// echo($response);die();
			$json = json_encode($response);
				if (preg_match("/success/i", $json)) {
					$this->db->query("UPDATE tpk_ipc.list_dokumens SET  NOTE ='$note', FL_STATUS ='X' WHERE ID=$id"); 
					echo "MSG#OK#Data berhasil diproses#";
				}else if (preg_match("/data tidak di temukan/i", $json)) {
					$this->db->delete('tpk_ipc.list_dokumens', array('ID' => $id));
					echo "MSG#ERR#Data tidak di temukan#";
				}
			//var_dump($json);die();
			}else {
				echo "MSG#ERR#Data tidak bisa di Prosess#";
			}
			
			} catch (\Throwable $th) {
				echo "MSG#ERR#Data tidak bisa di Prosess#";
			}

		}


	
				
		public function monitorOrderOnlinee($act, $id) {
			if (!$this->session->userdata('LOGGED')){
				$this->index();
				return;
			}
			
			$id = ($id!="")?$id:$this->input->post('id');

			if($act == "add_data"){
				$data['id'] = $id;
				//echo $data['id'];die();
				$data['arrdata']= $this->db->query("SELECT ID, ID_BEHANDLE2, NO_DOK, TGL_DOK, TIPE, NOTE, FL_STATUS FROM behandle2s WHERE ID = '".$id."'")->row(); 
				//echo $data['arrdata'];die();
				echo $this->content = $this->load->view('content/dokumen/form_proses2',$data);
			} else if($act == "add_data_tolak"){
				$data['id'] = $id;
				//echo $data['id'];die();
				$data['arrdata']= $this->db->query("SELECT ID, ID_BEHANDLE2, NO_DOK, TGL_DOK, TIPE, NOTE, FL_STATUS FROM behandle2s WHERE ID = '".$id."'")->row(); 
				//echo $data['arrdata'];die();
				echo $this->content = $this->load->view('content/dokumen/form_tolak2',$data);
			}else if($act == "print"){
				$data['id'] = $id;
				//echo $data['id'];die();
				$data['arrdata']= $this->db->query("SELECT ID, ID_BEHANDLE2, NO_DOK, TGL_DOK, TIPE,  NOTE, FL_STATUS, FILE_DOK FROM behandle2s WHERE ID = '".$id."'")->row(); 
				$data['test'] = explode("#",$data['arrdata']->FILE_DOK);

				//var_dump($data);die();
				// $arrid = explode("~",$id);
				// $id = $arrid;die();

				echo $this->content = $this->load->view('content/dokumen/list_behandle2',$data);
			}  else {
				$this->load->model("m_display");
				$arrdata = $this->m_display->getresponrequestonlinee($act, $id);
				$data = $this->load->view('content/newtable', $arrdata, true);
				if($this->input->post("ajax")||$act=="post"){
					echo $arrdata;
				}else{
					$this->content = $data;
					$this->index();
				}	
			}
		}


		public function prosesonlinee()
		{
			$id = $_GET['id'];
			$fl_status = $this->input->post('FL_STATUS');
			$note = $this->input->post('NOTE');
			$id_behandle = $this->input->post('ID_BEHANDLE2');
			//echo "$id_behandle";die();

			try {
			
			$list_dokumen = $this->db->query("SELECT * FROM tpk_ipc.behandle2s  WHERE ID = $id")->num_rows();

			if($list_dokumen != 0 ){

			$url ="http://10.1.6.177/api/prosesbehandle2";

			$postData = array('id' => $id_behandle,'fl_status' => 'Y','note' => $note);
			
			$data = http_build_query($postData);
		
			$curl = curl_init();
			curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => $data,
			));

			$response = curl_exec($curl);

			if (!curl_errno($curl)) {
				  $info = curl_getinfo($curl);
				  echo "Connection Success , This is Url : ", $info['url'], "\r\n";
				}else{
				  echo "Connection Failed =".curl_error($curl);
			  }
			curl_close($curl);
			// var_dump($response);die();
			$json = json_encode($response);
				if (preg_match("/success/i", $json)) {
					$this->db->query("UPDATE tpk_ipc.behandle2s SET NOTE='$note', FL_STATUS ='Y' WHERE ID=$id");
					echo "MSG#OK#Data berhasil diproses#";
				}else if (preg_match("/data tidak di temukan/i", $json)) {
					$this->db->delete('tpk_ipc.behandle2s', array('ID' => $id));
					echo "MSG#ERR#Data tidak di temukan#";
				}
			//var_dump($json);die();
			}else {
				echo "MSG#ERR#Data tidak bisa di Prosess#";
			}
			
			} catch (\Throwable $th) {
				echo "MSG#ERR#Data tidak bisa di Prosess#";
			}

		}

		public function prosesonlineetolak()
		{
			$id = $_GET['id'];
			$fl_status = $this->input->post('FL_STATUS');
			$note = $this->input->post('NOTE');
			$id_behandle = $this->input->post('ID_BEHANDLE2');
			//echo "$id_behandle";die();

			try {
			
			$list_dokumen = $this->db->query("SELECT * FROM tpk_ipc.behandle2s  WHERE ID = $id")->num_rows();

			if($list_dokumen != 0 ){

			$url ="http://10.1.6.177/api/prosesbehandle2";

			$postData = array('id' => $id_behandle,'fl_status' => 'X','note' => $note);
			
			$data = http_build_query($postData);
		
			$curl = curl_init();
			curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => $data,
			));

			$response = curl_exec($curl);

			if (!curl_errno($curl)) {
				  $info = curl_getinfo($curl);
				  echo "Connection Success , This is Url : ", $info['url'], "\r\n";
				}else{
				  echo "Connection Failed =".curl_error($curl);
			  }
			curl_close($curl);
			// var_dump($response);die();
			$json = json_encode($response);
				if (preg_match("/success/i", $json)) {
					$this->db->query("UPDATE tpk_ipc.behandle2s SET NOTE='$note', FL_STATUS ='X' WHERE ID=$id");
					echo "MSG#OK#Data berhasil diproses#";
				}else if (preg_match("/data tidak di temukan/i", $json)) {
					$this->db->delete('tpk_ipc.behandle2s', array('ID' => $id));
					echo "MSG#ERR#Data tidak di temukan#";
				}
			//var_dump($json);die();
			}else {
				echo "MSG#ERR#Data tidak bisa di Prosess#";
			}
			
			} catch (\Throwable $th) {
				echo "MSG#ERR#Data tidak bisa di Prosess#";
			}

		}


		public function monitoring($act, $id) {
			if (!$this->session->userdata('LOGGED')){
				$this->index();
				return;
			}
			
			$id = ($id!="")?$id:$this->input->post('id');

			if($act == "print"){
				$data['id'] = $id;
				//echo $data['id'];die();
				$data['arrdata']= $this->db->query("SELECT ID, ID_DOKUMEN, NO_DOK, TGL_DOK, TYPE_DOK,  NOTE, FL_STATUS, FILE_DOK FROM list_dokumens WHERE ID = '".$id."'")->row(); 
				$data['test'] = explode("#",$data['arrdata']->FILE_DOK);

				// var_dump($data);die();
				// $arrid = explode("~",$id);
				// $id = $arrid;die();

				echo $this->content = $this->load->view('content/dokumen/list_dokumen',$data);
			} else {
				$this->load->model("m_display");
				$arrdata = $this->m_display->monitoringresponrequestonlinee($act, $id);
				$data = $this->load->view('content/newtable', $arrdata, true);
				if($this->input->post("ajax")||$act=="post"){
					echo $arrdata;
				}else{
					$this->content = $data;
					$this->index();
				}
			}	
		}

        public function getAlerts(){
            $query = $this->db->query("SELECT ID, ID_DOKUMEN, NO_DOK, TGL_DOK, TYPE_DOK,  NOTE, FL_STATUS FROM list_dokumens WHERE FL_STATUS = 'N'"); 
            $result = $query->result();

            //var_dump($result);die();
            $data = json_encode($result);

            $response = array(
                'status' => 'success',
                'message' => $data
            );
            $this->output
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($response));
        }


    }