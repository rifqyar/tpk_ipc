<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_laporan extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	public function manageservice($act, $id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$title = "REPORT MANAGE SERVICE ".strtoupper($act);
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		$KD_GROUP = $this->session->userdata('KD_GROUP');
		$this->newtable->breadcrumb('Dashboard', site_url(),'icon-home');
		$this->newtable->breadcrumb('Report', 'javascript:void(0)','');
		$this->newtable->breadcrumb('Manage Service', 'javascript:void(0)','');
		$this->newtable->breadcrumb(strtoupper($act), 'javascript:void(0)','');
		$check = (grant()=="W")?true:false;
		$addsql = "";
			$SQL = "SELECT B.NO_CONT AS 'NO CONTAINER', F.NAMA AS 'JENIS',A.NO_DOK AS 'NO DOKUMEN',DATE_FORMAT(A.TGL_DOK,'%d/%m/%Y') AS 'TANGGAL DOKUMEN',A.NO_SPK AS 'NO SPK', DATE_FORMAT(A.TGL_SPK,'%d/%m/%Y') AS 'TANGGAL SPK', '-' AS 'GATE OUT TERMINAL', DATE_FORMAT(C.W_BEHANDLE,'%d/%m/%Y %h:%i:%S') AS 'GATE IN BEHANDLE', DATE_FORMAT(D.WK_START,'%d/%m/%Y %h:%i:%S') AS 'WK MULAI PERIKSA',
				DATE_FORMAT(D.WK_FINISH,'%d/%m/%Y %h:%i:%S') AS 'WK SELESAI PERIKSA', E.NO_DOK_INOUT AS 'NO SPPB', DATE_FORMAT(E.TGL_DOK_INOUT,'%d/%m/%Y') AS 'TGL SPPB', DATE_FORMAT(D.WK_GATEOUT,'%d-%m-%Y %h:%i:%S') AS 'WK BEHANDLE OUT'
				FROM t_spk A 
				LEFT JOIN t_spk_cont B ON A.ID = B.ID
				LEFT JOIN t_op_behandlein C ON A.NO_SPK = C.NO_SPK AND B.NO_CONT = C.NO_CONT
				LEFT JOIN t_operation D ON A.NO_SPK = D.NO_SPK AND B.NO_CONT = D.NO_CONT
				LEFT JOIN t_permit_hdr E ON A.NO_DOK = E.NO_DAFTAR_PABEAN AND E.KD_DOK_INOUT = 1
				LEFT JOIN reff_kode_dok_bc F ON A.JNS_DOK = F.ID
				WHERE A.TGL_DOK IS NOT NULL";
				// -- //WHERE A.TGL_DOK BETWEEN '2017-06-13' AND '2017-07-12'
				// -- WHERE MONTH(A.TGL_DOK) = MONTH(CURRENT_DATE())";
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		//$proses = array('EXPORT EXCEL 1' => array('EXCEL', "process/excel/behandle/".$act, '0','','md-file-text','','menu'));
		$proses = array('EXPORT EXCEL 1' => array('EXCEL', "process1/excel/manage/".$act, '0','','md-file-text','','menu'));
		$this->newtable->search(array(array('B.NO_CONT','NO CONTAINER'),array('A.TGL_DOK','TANGGAL DOKUMEN','DATERANGE')));
		//$this->newtable->search(array(array('B.NO_CONT','NO. CONTAINER'),array('D.W_BEHANDLE','TANGGAL BEHANDLE','DATETIMERANGE')));
		$this->newtable->action(site_url() . "/laporan/manages/".$act);
		//$this->newtable->action(site_url() . "/report/behandle/".$act);
		//if($check) $this->newtable->detail(array('POPUP',"dokumen/bc11/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array('ID'));
		$this->newtable->keys(array("B.NO_CONT"));
		$this->newtable->validasi(array());
		$this->newtable->cidb($this->db);
		$this->newtable->orderby("A.TGL_DOK");
		$this->newtable->groupby(array("B.NO_CONT"));
		$this->newtable->sortby("ASC");
		$this->newtable->set_formid("tblreport");
		$this->newtable->set_divid("divtblreport");
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


	function process($type, $act, $id){//print_r($type.$act);die();
        $func = get_instance();
        $func->load->model("m_main", "main", true);
        $success = 0;
        $error = 0;
        $USERLOGIN = $this->session->userdata('USERLOGIN');
        $KD_TPS = $this->session->userdata('KD_TPS');
        $KD_GUDANG = $this->session->userdata('KD_GUDANG');
        if($type == "excel"){
			if($act=="manage"){
		$no_kon = $this->input->post('form[0]');
		$tgl_nota = $this->input->post('form[1]');
		$tgl_nota_start = $tgl_nota[0];
		$tgl_nota_end = $tgl_nota[1];
		$no_kon1 = $no_kon[0];
		$addsql = "";
		//print_r($this->input->post('form'));die();
		if($tgl_nota_start!="" and $tgl_nota_end !=""){
			$addsql .= " AND A.TGL_DOK BETWEEN '$tgl_nota_start' AND '$tgl_nota_end'";
		}else if($tgl_nota_start != ""){
			$addsql .= " AND A.TGL_DOK >= '$tgl_nota_start'";
		}else if($tgl_nota_end != ""){
			$addsql .= " AND A.TGL_DOK <= '$tgl_nota_end'";
		}else{
			// $addsql .= "GROUP BY B.NO_CONT limit 2000";
		}
		$SQL = "SELECT B.NO_CONT, F.NAMA ,A.NO_DOK,DATE_FORMAT(A.TGL_DOK,'%d/%m/%Y') AS TGL_DOK,A.NO_SPK, DATE_FORMAT(A.TGL_SPK,'%d/%m/%Y') AS TGL_SPK, '-' AS 'GATE OUT TERMINAL', DATE_FORMAT(C.W_BEHANDLE,'%d/%m/%Y %h:%i:%S') AS 'GATE IN BEHANDLE', DATE_FORMAT(D.WK_START,'%d/%m/%Y %h:%i:%S') AS 'WK MULAI PERIKSA',
			DATE_FORMAT(D.WK_FINISH,'%d/%m/%Y %h:%i:%S') AS 'WK SELESAI PERIKSA', E.NO_DOK_INOUT AS 'NO. SPPB', DATE_FORMAT(E.TGL_DOK_INOUT,'%d/%m/%Y') AS 'TGL. SPPB', DATE_FORMAT(D.WK_GATEOUT,'%d-%m-%Y %h:%i:%S') AS 'WK BEHANDLE OUT'
			FROM t_spk A 
			LEFT JOIN t_spk_cont B ON A.ID = B.ID
			LEFT JOIN t_op_behandlein C ON A.NO_SPK = C.NO_SPK AND B.NO_CONT = C.NO_CONT
			LEFT JOIN t_operation D ON A.NO_SPK = D.NO_SPK AND B.NO_CONT = D.NO_CONT
			LEFT JOIN t_permit_hdr E ON A.NO_DOK = E.NO_DAFTAR_PABEAN AND E.KD_DOK_INOUT = 1
			LEFT JOIN reff_kode_dok_bc F ON A.JNS_DOK = F.ID 
			WHERE A.TGL_DOK IS NOT NULL".$addsql;
				
				$result = $func->main->get_result($SQL);
				$this->load->library('newphpexcel');
				$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(11);
				$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
				$this->newphpexcel->setActiveSheetIndex(0);
				$styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
				$this->newphpexcel->getDefaultStyle()->applyFromArray($styleArray);
				$this->newphpexcel->set_bold(array('A2'));
				$this->newphpexcel->mergecell(array(array('A2','F3')), FALSE);//

				$this->newphpexcel->getActiveSheet(0)->getStyle('A2:F3')->getFont('Calibri')->setSize(14);
				$this->newphpexcel->getActiveSheet()->getRowDimension('4')->setRowHeight(32);
				//$this->newphpexcel->getActiveSheetIndex()->setCellValue('A2',"LAPORAN REKAPITULASI PEMERIKSAAN FISIK");
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A2','Laporan Rekapitulasi Pemeriksaan Fisik Periode '.$tgl_nota_start.'&'.$tgl_nota_end.'');
				$this->newphpexcel->width(array(array('A',5),array('B',13),array('C',37),array('D',29),array('E',11),array('F',12),array('G',10),array('H',9),array('I',18),array('J',18),array('K',18),array('L',18),array('M',18),array('N',10)));
				//$this->newphpexcel->setheight(array(array('A',30),array('B',30),array('C',30),array('D',30),array('E',30),array('F',30),array('G',30),array('H',30),array('I',30),array('J',30),array('K',30),array('L',30),array('M',30),array('N',30)));
				
				$this->newphpexcel->setActiveSheetIndex(0)
					->setCellValue('A4','No')
					->setCellValue('B4','No Kontainer')
					->setCellValue('C4','Jenis Dokumen')
					->setCellValue('D4','No Dokumen')
					->setCellValue('E4','Tgl Dokumen')
					->setCellValue('F4','No SPK')
					->setCellValue('G4','Tgl SPK')
					->setCellValue('H4','Gate Out Terminal')
					->setCellValue('I4','Gate In Behandle')
					->setCellValue('J4','WK Mulai Periksa')
					->setCellValue('K4','WK Selesai Periksa')
					->setCellValue('L4','No SPPB')
					->setCellValue('M4','Tgl SPPB')
					->setCellValue('N4','Gate Out Behandle');
				$this->newphpexcel->getActiveSheet()->freezePane('A5');
				$this->newphpexcel->getActiveSheet()->getStyle('A4:N4')->getAlignment()->setWrapText(true);
				$this->newphpexcel->getActiveSheet()->getStyle('A2:N4')->applyFromArray(
				 array(
				 'font' => array(
				 'bold' => true
				 ),
				 'alignment' => array(
				 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				 ),
				 )
				);
				$this->newphpexcel->headings(array('A4','B4','C4','D4','E4','F4','G4','H4','I4','J4','K4','L4','M4','N4'));
				$this->newphpexcel->set_wrap(array('B','C','D','E','F','G','H','I','J','K','L','M','N'));
				$no = 1;
				$rec = 5;
				if($result){
					foreach($SQL->result_array() as $row){
						$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
						->setCellValueExplicit('B'.$rec,$row["NO_CONT"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('C'.$rec,$row["NAMA"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('D'.$rec,$row["NO_DOK"])
						->setCellValueExplicit('E'.$rec,$row["TGL_DOK"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('F'.$rec,$row["NO_SPK"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValue('G'.$rec,$row["TGL_SPK"])
						->setCellValueExplicit('H'.$rec,$row["GATE OUT TERMINAL"],PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValue('I'.$rec,$row["GATE IN BEHANDLE"])
						->setCellValue('J'.$rec,$row["WK MULAI PERIKSA"])
						->setCellValue('K'.$rec,$row["WK SELESAI PERIKSA"])
						->setCellValue('L'.$rec,$row["NO. SPPB"])
						->setCellValue('M'.$rec,$row["TGL. SPPB"])
						->setCellValue('N'.$rec,$row["WK BEHANDLE OUT"]);
						
						$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec));
						$rec++;
						$no++;	
					}
				}else{
					$this->newphpexcel->getActiveSheet()->mergeCells('A6:X6');
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A6','DATA TIDAK DITEMUKAN');
					$this->newphpexcel->set_detilstyle(array('A6'));
				}
				ob_clean();

				$file = "MANAGESERVICE_" . $tgl_nota_start . "&" . $tgl_nota_end . ".xls";
				header("Content-type: application/x-msdownload");
				header("Content-Disposition: attachment;filename=$file");
				header("Cache-Control: max-age=0");
				header("Pragma: no-cache");
				header("Expires: 0");
				$objWriter = PHPExcel_IOFactory::createWriter($this->newphpexcel, 'Excel5');
				$objWriter->save('php://output');
				exit();		
			}
		}
	}
}