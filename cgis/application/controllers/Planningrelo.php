<?php defined('BASEPATH') or exit('No direct script access allowed');

class Planningrelo extends CI_Controller
{
	public $content;

	public function __construct()
	{
		parent::__construct();
		$this->load->model("m_planning");
	}

	public function index()
	{
		$headers .= '<link rel="apple-touch-icon" href="' . base_url() . 'assets/images/apple-touch-icon.png">';
		#Stylesheetss
		$headers = '<link rel="stylesheet" href="' . base_url() . 'assets/css/bootstrap.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/css/bootstrap-extend.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/css/site.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/jquery-ui/jquery-ui.min.css?v2.1.0">';
		#Plugins For This Page
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/filament-tablesaw/tablesaw.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/uikit/modals.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/jquery-wizard/jquery-wizard.min.css?v2.1.0">';
		#Plugins
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/animsition/animsition.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/asscrollable/asScrollable.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/switchery/switchery.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/intro-js/introjs.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/slidepanel/slidePanel.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/waves/waves.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/sweetalert/sweetalert.css">';
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/themes/twitter.css">';
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/css/newtable.css">';
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/vendor/toastr/toastr.min.css">';
		#Fonts
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/fonts/material-design/material-design.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/fonts/brand-icons/brand-icons.min.css?v2.1.0">';
		$headers .= '<link rel="stylesheet" href="' . base_url() . 'assets/fonts/font.css?v2.1.0">';
		#Scripts
		$headers .= '<script src="' . base_url() . 'assets/js/jquery.min.js"></script>';
		$headers .= '<script src="' . base_url() . 'assets/js/alerts.js"></script>';
		$headers .= '<script src="' . base_url() . 'assets/vendor/modernizr/modernizr.min.js"></script>';
		$headers .= '<script src="' . base_url() . 'assets/vendor/breakpoints/breakpoints.min.js"></script>';
		$headers .= '<script>Breakpoints();</script>';
		#Core
		$footers = '<script src="' . base_url() . 'assets/vendor/jquery/jquery.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/vendor/jquery-ui/jquery-ui.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/vendor/bootstrap/bootstrap.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/vendor/animsition/animsition.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/vendor/asscroll/jquery-asScroll.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/vendor/mousewheel/jquery.mousewheel.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/vendor/asscrollable/jquery.asScrollable.all.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/vendor/ashoverscroll/jquery-asHoverScroll.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/vendor/waves/waves.min.js"></script>';
		#Plugins
		$footers .= '<script src="' . base_url() . 'assets/vendor/switchery/switchery.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/vendor/intro-js/intro.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/vendor/screenfull/screenfull.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/vendor/slidepanel/jquery-slidePanel.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/vendor/formatter-js/jquery.formatter.min.js"></script>';
		#Scripts
		$footers .= '<script src="' . base_url() . 'assets/js/core.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/js/site.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/js/sections/menu.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/js/sections/menubar.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/js/sections/gridmenu.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/js/sections/sidebar.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/js/configs/config-colors.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/js/components/asscrollable.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/js/components/animsition.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/js/components/slidepanel.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/js/components/switchery.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/js/newtable.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/js/main.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/vendor/sweetalert/sweetalert.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/vendor/filament-tablesaw/tablesaw.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/vendor/toastr/toastr.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/js/components/input-group-file.min.js"></script>';
		$footers .= '<script src="' . base_url() . 'assets/js/components/formatter-js.min.js"></script>';

		if ($this->session->userdata('LOGGED')) {
			if ($this->content == "") {
				redirect(site_url(), 'refresh');
			}
			$data = array(
				'_title_' => 'BOS',
				'_headers_' => $headers,
				'_header_' => $this->load->view('content/header', '', true),
				'_menus_' => $this->load->view('content/menus', '', true),
				'_breadcrumbs_' => $this->load->view('content/breadcrumbs', '', true),
				'_content_' => (grant() == "") ? $this->load->view('content/error', '', true) : $this->content,
				'_footers_' => $footers,
				'_footer_' => $this->load->view('content/menus', '', true)
			);
			$this->parser->parse('index', $data);
		} else {
			redirect(base_url('index.php'), 'refresh');
		}
	}

	public function spk_relokasi()
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}

		// Load the model
		$this->load->model('SpkRelokasiModel');

		// Fetch header data
		$data['headers'] = $this->SpkRelokasiModel->get_all_headers();

		// Pass the header data to the view
		$this->content = $this->load->view('content/spk_relokasi/index', $data, true);
		$this->index();
	}

	public function add_relo() {
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
	
		// Load the model
		$this->load->model('SpkRelokasiModel');
	
		// Check if form is submitted
		if ($this->input->post('submit')) {
			$selected_data = $this->input->post('selected_data');
			if (!empty($selected_data)) {
				// Process selected data
				// You can process $selected_data array as needed (e.g., save to DB)
				// For now, let's just display them as JSON
				echo json_encode($selected_data);
				return;
			}
		}
	
		// Fetch query data
		$data['headers'] = $this->SpkRelokasiModel->get_query_data();
	
		// Pass the data to the view
		$this->content = $this->load->view('content/spk_relokasi/addrelokasi', $data, true);
		$this->index();
	}
	

	public function spk_relokasi_detail($id_spk)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}

		// Load the model
		$this->load->model('SpkRelokasiModel');

		// Fetch header and container data
		$data['header'] = $this->SpkRelokasiModel->get_header_by_id($id_spk); // Optional if you need header data
		$data['containers'] = $this->SpkRelokasiModel->get_containers_by_spk($id_spk);

		// Pass the data to the view
		$this->content = $this->load->view('content/spk_relokasi/detail', $data, true);
		$this->index();
	}

	public function spk_relokasi_add()
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}

		// Initialize the search result as an empty array
		$data['permit_records'] = array();

		// Check if 'no_dok_inout' parameter is present in the GET request
		$no_dok_inout = $this->input->get('no_dok_inout');
		if ($no_dok_inout) {
			// Load the model
			$this->load->model('SpkRelokasiModel');

			// Fetch the records matching the no_dok_inout value
			$data['permit_records'] = $this->SpkRelokasiModel->get_permits_by_no_dok($no_dok_inout);
		}

		// Load the add form view with search results
		$this->content = $this->load->view('content/spk_relokasi/add', $data, true);
		$this->index();
	}

	// Method to fetch permit details by NO_DOK_INOUT
	public function spk_relokasi_search_permit()
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}

		// Get the search input
		$no_dok_inout = $this->input->get('no_dok_inout');
		$this->load->model('SpkRelokasiModel');

		// Fetch permit data based on the search input
		$permit = $this->SpkRelokasiModel->get_permit_by_no_dok($no_dok_inout);

		// Load the add form view with the permit data
		$data['permit_record'] = $permit;
		$this->content = $this->load->view('content/spk_relokasi/add', $data, true);
		$this->index();
	}

	public function spk_relokasi_fill_form()
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}

		// Capture the GET parameters
		$permit_id = $this->input->get('id');
		$no_dok_inout = $this->input->get('no_dok_inout');
		$tgl_dok = $this->input->get('tgl_dok');

		// Load the model
		$this->load->model('SpkRelokasiModel');

		// Fetch the permit record by ID
		$permit_record = $this->SpkRelokasiModel->get_permit_by_id($permit_id);

		// Fetch container data related to the permit ID from t_permit_cont
		$containers = $this->SpkRelokasiModel->get_containers_by_permit_id($permit_id);

		// Pass the permit record and container data to the add view
		$data['permit_record'] = $permit_record;
		$data['containers'] = $containers;
		$this->content = $this->load->view('content/spk_relokasi/fill_add', $data, true);
		$this->index();
	}
	public function spk_relokasi_store()
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}

		// Capture the posted data
		$no_spk = $this->input->post('no_spk');
		$tgl_spk = $this->input->post('tgl_spk'); // Format: d-m-Y
		$no_dok = $this->input->post('no_dok');
		$jns_dok = $this->input->post('jns_dok');
		$tgl_dok = $this->input->post('tgl_dok'); // Format: d-m-Y
		$containers = $this->input->post('containers');

		// Convert the date format from d-m-Y to Y-m-d for database insertion
		$tgl_spk_db = date('Y-m-d', strtotime($tgl_spk));
		$tgl_dok_db = date('Y-m-d', strtotime($tgl_dok));

		// Data to be inserted into t_spk_relocation_hdr
		$hdr_data = array(
			'NO_SPK' => $no_spk,
			'TGL_SPK' => $tgl_spk_db,
			'JENIS_DOK' => $jns_dok,
			'NO_DOK' => $no_dok,
			'TGL_DOK' => $tgl_dok_db,
		);

		// Insert into t_spk_relocation_hdr
		$this->db->insert('t_spk_relocation_hdr', $hdr_data);
		$insert_id = $this->db->insert_id(); // Get the inserted ID for the header

		// Check if header insert was successful and there are containers to insert
		if ($insert_id && !empty($containers)) {
			// Prepare data for t_spk_relocation_cont
			$cont_data = array();
			foreach ($containers as $container) {
				$cont_data[] = array(
					'ID_SPK' => $insert_id, // Reference to the header ID
					'NO_CONT' => $container,
				);
			}


			// Insert multiple rows into t_spk_relocation_cont
			$this->db->insert_batch('t_spk_relocation_cont', $cont_data);
		}

		// Optionally, redirect or display a success message
		redirect('planningrelo/spk_relokasi'); // Redirect back to the listing page, for example
	}

	public function create_gatepass($id_container)
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}
	
		// Load the required model
		$this->load->model('SpkRelokasiModel');
	
		// Fetch container details by ID
		$container = $this->SpkRelokasiModel->get_container_by_id($id_container);
	
		// Check if container exists
		if (empty($container)) {
			show_404(); // Display error if container not found
			return;
		}
	
		// Check if PERMIT_CONT is empty or null
		if (empty($container['PERMIT_CONT'])) {
			echo "<script>alert('NOMOR KONTAINER BELUM TERBIT PENGELUARANNYA'); window.location.href = '" . site_url('planningrelo/spk_relokasi_detail/' . $container['ID_SPK']) . "';</script>";
			return;
		}
	
		// Get the gatepass date from the form submission
		$gatepass_date = $this->input->post('gatepass_date');
	
		// Check if the date is valid
		if (empty($gatepass_date)) {
			// Handle the error (e.g., show a validation message)
			echo "<script>alert('Gatepass date is required.'); window.location.href = '" . site_url('planningrelo/spk_relokasi_detail/' . $container['ID_SPK']) . "';</script>";
			return;
		}
	
		// Prepare data for the insert
		$data = array(
			'JNS_DOK' => $container['PERMIT_DOK_NAME'],
			'NO_DOK' => $container['PERMIT_DOK_RELEASE'],
			'TGL_DOK' => $container['TGL_DOK'],
			'STATUS' => 'WAITING', // Hardcoded value
			'JNS_KEGIATAN' => '3', // Hardcoded value
			'NO_CONT' => $container['NO_CONT'],
			'UKR_CONT' => $container['SIZE'],
			'NPWP' => $container['NPWP'],
			'NAMA_CUST' => $container['PERMIT_CONSIGNEE'],
			'NM_KAPAL' => $container['NM_KAPAL'],
			'NO_VOY' => $container['VOYAGE'],
			'EXPIRED_DATE' => $gatepass_date,
		);
	
		// Insert data into T_GATEPASS_DEV table
		$this->db->insert('t_gatepass', $data);
	
		// Optional: Check if the insert was successful
		if ($this->db->affected_rows() > 0) {
			// Success alert and redirect
			echo "<script>alert('Gatepass created successfully.'); window.location.href = '" . site_url('planningrelo/spk_relokasi_detail/' . $container['ID_SPK']) . "';</script>";
		} else {
			// Failure alert and redirect
			echo "<script>alert('Failed to create gatepass.'); window.location.href = '" . site_url('planningrelo/spk_relokasi_detail/' . $container['ID_SPK']) . "';</script>";
		}
	}
	

	public function search_by_nodok()
	{
		if (!$this->session->userdata('LOGGED')) {
			$this->index();
			return;
		}

		$no_dok = $this->input->post('no_dok');

		$this->load->model('SpkRelokasiModel');
		$results = $this->SpkRelokasiModel->search_by_nodok($no_dok);

		echo json_encode($results);
	}

	public function update_container()
	{
		$id = $this->input->post('id');

		// Load the model
		$this->load->model('SpkRelokasiModel');

		// Get the SPK by container ID
		$id_spk = $this->SpkRelokasiModel->get_spk_by_container_id($id);

		// Handle case where no SPK is found
		if ($id_spk === null) {
			echo "No SPK found for the given container ID.";
			return; // Use return instead of exit for better control flow
		}

		echo "ID_SPK: " . $id_spk . "<br>";

		// Prepare data array for the update
		$data = array(
			'NO_CONT' => $this->input->post('no_cont'),
			'SIZE' => $this->input->post('ukr_cont'),
			'TYPE' => $this->input->post('tipe_cont'),
			'ISOCODE' => $this->input->post('iso_code'),
			'NPWP' => $this->input->post('npwp'), // Fixed the typo
			'CONSIGNEE' => $this->input->post('nama_cust'),
			'NM_KAPAL' => $this->input->post('vessel'),
			'VOYAGE' => $this->input->post('voy_in'),
			'BRUTO' => $this->input->post('bruto'),
			'NO_BC11' => $this->input->post('no_bc11'),
			'TGL_BC11' => $this->input->post('tgl_dok'),
		);


		// Retrieve SPK data by ID_SPK
		$spk_data = $this->SpkRelokasiModel->get_spk_by_id($id_spk);

		// Handle case where no SPK data is found
		if ($spk_data === null) {
			echo "No SPK data found for the given ID_SPK.";
			return; // Again, use return for better flow control
		}

		$gatepass_data = array(
			'JNS_DOK' => $spk_data->JENIS_DOK,   // Dynamic from $spk_data
			'NO_DOK' => $spk_data->NO_DOK,      // Dynamic from $spk_data
			'TGL_DOK' => $spk_data->TGL_DOK,     // Dynamic from $spk_data
			'STATUS' => 'WAITING',              // Hardcoded
			'JNS_KEGIATAN' => '3',                    // Hardcoded
			'NO_CONT' => $this->input->post('no_cont'),  // From form input
			'UKR_CONT' => $this->input->post('ukr_cont'), // From form input
			'NPWP' => '021066204093000',      // Hardcoded
			'NAMA_CUST' => 'MULTI TERMINAL INDONESIA', // Hardcoded
			'NM_KAPAL' => $this->input->post('vessel'),  // From form input
			'NO_VOY' => $this->input->post('voy_in'),  // From form input
			'BRUTO' => $this->input->post('bruto'),   // From form input
		);

		// Debugging output
		echo '<pre>';
		print_r($spk_data); // Debug SPK data
		print_r($id);       // Debug container ID
		print_r($data);     // Debug data to be updated
		print_r($gatepass_data);
		echo '</pre>';

		// Optionally remove or comment out the following line once debugging is done
		// exit;

		// Update the container
		$update_status = $this->SpkRelokasiModel->update_container($id, $data);
		$insert_status = $this->SpkRelokasiModel->insert_gatepass($gatepass_data);

		// Redirect or show error based on the update status
		if ($update_status) {
			redirect('planningrelo/spk_relokasi_detail/'.$id_spk);
		} else {
			show_error('An error occurred, please try again later.', 500);
		}
	}
	public function post_selected_data() {
		// Check if any data was posted
		if ($this->input->post('selected_data')) {
			// Get the selected data
			$selected_data = $this->input->post('selected_data');
			
			// Query the latest ID from t_spk_relocation_hdr
			$this->db->select('id');
			$this->db->from('t_spk_relocation_hdr');
			$this->db->order_by('id', 'DESC');
			$this->db->limit(1);
			$query = $this->db->get();
			
			// Check if any row is returned and get the latest ID
			if ($query->num_rows() > 0) {
				$latest_id = $query->row()->id;
			} else {
				$latest_id = 0; // Set 0 if no record is found, so the new ID will be 1
			}
			
			// Add 1 to the latest ID and create the new ID
			$new_id = $latest_id + 1;
			$id_spk = 'SPK_RELO/' . $new_id;
			
			// Insert into t_spk_relocation_hdr
			$data_hdr = array(
				'NO_SPK' => $id_spk,
				'TGL_SPK' => date('Y-m-d H:i:s') // Current datetime
			);
			$this->db->insert('t_spk_relocation_hdr', $data_hdr);
	
			// Get the auto-incremented ID after insertion into t_spk_relocation_hdr
			$inserted_id_spk = $this->db->insert_id();
			
			// Insert into t_spk_relocation_cont for each selected data
			foreach ($selected_data as $data) {
				// Decode the JSON string to get the individual fields
				$data = json_decode($data, true);
	
				// Prepare data for the container table
				$data_cont = array(
					'ID_SPK' => $inserted_id_spk,  // Use the inserted ID from hdr
					'NO_CONT' => $data['NO_CONT'],
					'SIZE' => $data['UKR_CONT'],
					'TYPE' => $data['TIPE_CONT'],
					'ISOCODE' => null,
					'NPWP' => $data['NPWP'],
					'CONSIGNEE' => $data['CONSIGNEE'],
					'NM_KAPAL' => $data['VESSEL'],
					'VOYAGE' => $data['VOY_IN'],
					'BRUTO' => $data['BRUTO'],
					'NO_BC11' => $data['NO_BC11'],
					'TGL_BC11' => $data['TGL_BC11'],
					'NO_DOK_PERIKSA' => $data['NO_DAFTAR_PABEAN'],
					'TGL_DOK_PERIKSA' => $data['TGL_DAFTAR_PABEAN'],
					'STATUS' => null,
					'NO_POS_BC11' => $data['NO_POS_BC11'],
					'TGL_POS_BC11' => null,
					'NO_BL_AWB' => $data['NO_BL_AWB'],
					'TGL_BL_AWB' => $data['TGL_BL_AWB']
				);
	
				// Insert each record into t_spk_relocation_cont
				$this->db->insert('t_spk_relocation_cont', $data_cont);
			}
	
			// Display the generated ID and posted data for testing
			echo '<pre>';
			echo 'Generated ID SPK: ' . $id_spk;
			print_r($selected_data);
			echo '</pre>';
		} else {
			echo "No data selected.";
		}
	}
	public function search_document() {
		$this->load->model('SpkRelokasiModel');
		$no_dok_inout = $this->input->post('no_dok_input');
	
		// Call the model function to search the document
		$result = $this->SpkRelokasiModel->get_documents_by_no_dok($no_dok_inout); // Change to get_documents_by_no_dok
	
		if ($result) {
			echo json_encode(array('status' => 'success', 'data' => $result)); // Return multiple records
		} else {
			echo json_encode(array('status' => 'error', 'message' => 'Document not found'));
		}
	}	
	public function update_document() {
		$no_spk = $this->input->post('no_spk');
		$no_dok = $this->input->post('no_dok');
		$tgl_dok = $this->input->post('tgl_dok');
	
		$this->load->model('SpkRelokasiModel');
		
		// Update the document in the database
		$result = $this->SpkRelokasiModel->update_document($no_spk, $no_dok, $tgl_dok);
	
		if ($result) {
			echo json_encode(array('status' => 'success', 'message' => 'Document updated successfully.'));
		} else {
			echo json_encode(array('status' => 'error', 'message' => 'Failed to update document.'));
		}
	}
	
	
}
