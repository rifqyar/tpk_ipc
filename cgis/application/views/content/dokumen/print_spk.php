<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//print_r($result);die();
//echo "sini";die();
//echo $title;
//echo $sql->NO_SPK;die();
//echo $userLogin;die();
$mpdf = new mPDF();
$mpdf->SetAutoPageBreak(true, 10);
$drawPerPage = 50;
$html = getStyle();
$html = getStyle2();
$html = '<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td></td>
							<TH></TH>
		<td width="20px" style="border:0px solid black;"><!--.$title.--></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
			   </table>
			   <table border="0" width="100%" cellpadding="0" cellspacing="0">
					<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<th align="right" style="width:5px;" ><img width="20%" src="assets/images/Logomti.png"></th>
		<th style="font-size:16px;" align="center">SURAT PERINTAH KERJA (SPK)<BR>PENARIKAN KONTAINER<BR>'.$result[0]['NO_SPK'].'</th>
	</tr>
	<tr>
		<th><!--SPK No. : .$NO_SPK.--></th>
	</tr>
 </table>';
	$mpdf->SetHTMLHeader($html);
	$html='
			<table>
				<tr>
					<td>
						<i style="float:left;">This document is printed by BOS - PT. MTI &nbsp;&nbsp; </i>'.date("d-m-Y H:i").'
					</td>
					<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
					<td>
						printed by '.$title.'
					</td>
				</tr>
			</table>
	';

	//$html = '<span><i>This document is printed by BOS - PT. MTI &nbsp;&nbsp; </i>'.date("d-m-Y H:i").'</span><span style="float:right;">'.$title.'</span>';
$mpdf->SetHTMLFooter($html);
$html .= '<body><div class="body">';
$html .= getHTML($result, $title);
$html .= '</div>
</body>';
//$mpdf->WriteHTML();
$mpdf->WriteHTML($html);
// Add new page
$mpdf->AddPage();

// Generate HTML content for second page
$htmlContent2 = '<body><div class="body">';
$htmlContent2 .= getHTML2($result, $title);
$htmlContent2 .= '</div></body>';

// Add second page
$mpdf->WriteHTML($htmlContent2);
$mpdf->Output();

function getStyle(){
	$html = '<style type="text/css">
					body{
						font:12px Tahoma;
					}
					div.body{
						padding:20px;
						padding-top:5px;
					}
					table{
						border-collapse:collapse;
						border-spacing:0;
						width:100%;
					}
				</style>';
	return $html;

}
//print_r($datafcl);die();
function getHTML($result,$title){
	//print_r($datafcl);die();
	global $CONF;
	//foreach($result as $data){
		//var_dump($data);die();

	//print_r($arrdataMail);die();
	$JMLH = count($result);
	//print_r($JMLH);die();

	$NO_SPK = $result['NO_SPK'];
	//$userLogin = $this->session->userdata('USERLOGIN');
	//return $userLogin;
	$no=1;
	for($c=0;$c<$JMLH;$c++){
		//$NO_SPK .= $result[$c]['NO_SPK'];
		$tr1 .='
			<tr>
				<td width="5%" style="border:1px solid black;border-top:none;" align="center">'.$no++.'</td>
				<td width="10%" style="border:1px solid black;border-top:none;" align="center">'.$result[$c]['NO_CONT'].'</td>
				<td width="10%" style="border:1px solid black;border-top:none;" align="center">'.$result[$c]['UKR_CONT'].'</td>
			</tr>
			';
	}

	$lnsw = '';
	if ($result[0]['LNSW_NOAJU'] != '') {
		$lnsw = '<tr>
			<td>Join Inspection</td>
			<td colspan="2">: '.$result[0]['LNSW_NOAJU'].' / '.$result[0]['LNSW_TGLAJU'].'</td>
		</tr>';
	}
		$ADMIN=$title;
	
	$html = '
			
			 <style>
				
				#footer{
					height:50px;
					line-height:50px;
					color:#000;
					font-weight: bold;
					position:absolute;
					bottom:0px;
				}
				.tblee {
					height: 170px;
				}
			</style><br><br>
			 <table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td></td>
                                        <TH></TH>
					<td width="20px" style="border:0px solid black;"><!--.$title.--></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
                           </table>
                           <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<th align="right" style="width:5px;" ></th>
					<th style="font-size:16px;" align="center"></th>
				</tr>
				<tr>
					<th><!--SPK No. : .$NO_SPK.--></th>
				</tr>
			 </table>
			 <br><br>
			 <table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td colspan="3">
						Dalam rangka memenuhi keperluan pemeriksaan, <BR>
						Maka dengan ini menunjuk Operator Behandle untuk melaksanakan pekerjaan pengambilan container <BR>
						dengan data sebagai berikut :
					</td><Br><Br>
				</tr>
				'.$lnsw.'
				<tr>
					<td>
					Jenis Dokumen
					</td>
					<td colspan="2">
					: '.$result[0]['JENIS_DOKUMEN'].'
					</td>
				</tr>
				<tr>
					<td>
					No. / Tgl Dokumen
					</td>
					<td colspan="2">
					: '.$result[0]['NO_DOK'].' / '.$result[0]['TGL_SPK'].'
					</td>
				</tr>
				<tr>
					<td width="20%"><br><br></td>
					<td width="1%"></td>
					<td width="69%"></td>
				</tr>

			 </table>
			 <table border="0" width="100%" cellpadding="0" cellspacing="0">
						<tr>
							<th width="5%" style="border:1px solid black">No.</th>
							<th width="10%" style="border:1px solid black">NOMOR KONTAINER</th>
							<th width="10%" style="border:1px solid black">UKURAN KONTAINER</th>
						</tr>
						'.$tr1.'
					 </table>
					</td>
				</tr>
			 </table><br>
			 <div style="text-align:justify;">
				Surat perintah ini diserahkan kepada yang bersangkutan untuk dapat dilaksanakan sebagaimana <BR>
				mestinya dan dengan penuh tanggung jawab.
			 </div>
			 <br>
			 <table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="70%"><br>
						<div> <!--'.date("j F Y", strtotime($data['TGL_SPK'])).'--></div><br>
						<div><strong><u>OPERATOR BEHANDLE</strong></u></div>
						<br><br><br><br><br><br>
					</td>
					<td width="30%">
						<div>Jakarta, '.date('d M Y').'</div><br>
						<div><strong><u>PETUGAS COMMON GATE</strong></u></div>
						<br><br><br><br><br><br>
					</td>
				</tr>
				<tr>
					<td style="vertical-align:top;">
						<div><strong><u>____________________________</strong></u></div>
						<div></div>
					</td>

					<td style="vertical-align:top;">
						<div><strong><u>____________________________</strong></u></div>
						<div></div>
					</td>
				</tr>
			 </table>
			
			
			 <setevenpageheader value="text on page 2" />
			 <setoddpageheader value="text on page 2" />
			 ';
	return $html;
	//}
	 
}

function getStyle2(){
	
	$htmlContent2 = '<style type="text/css">
					body{
						font:12px Tahoma;
					}
					div.body{
						padding:20px;
						padding-top:5px;
					}
					table{
						border-collapse:collapse;
						border-spacing:0;
						width:100%;
					}
					barcode {
						padding: 2.5mm;
						margin: 0;
						width: 50px;
						vertical-align: top;
						color: #000044;
					}
					.barcodecell {
						text-align: center;
						vertical-align: middle;
					}
				</style>';
	return $htmlContent2;
}

function getHTML2($result,$title){
	//print_r($datafcl);die();
	global $CONF;
	//foreach($result as $data){
		//var_dump($data);die();

	//print_r($arrdataMail);die();
	$JMLH = count($result);
	//print_r($JMLH);die();

	$NO_SPK = $result['NO_SPK'];
	//$userLogin = $this->session->userdata('USERLOGIN');
	//return $userLogin;
	$no=1;
	for($c=0;$c<$JMLH;$c++){
		//$NO_SPK .= $result[$c]['NO_SPK'];
		$tr11 .='
			<tr>
				<td width="5%" style="border:1px solid black;border-top:none;" align="center">'.$no++.'</td>
				<td width="10%" style="border:1px solid black;border-top:none;" align="center">'.$result[$c]['NO_CONT'].'</td>
				<td width="10%" style="border:1px solid black;border-top:none;" align="center">'.$result[$c]['UKR_CONT'].'</td>
				<td width="5%" style="border:1px solid black;border-top:none;" align="center">
					
					<div class="barcodecell"><barcode code="'.$result[$c]['NO_CONT'].'" size="0.5" w="50" type="EAN128A" class="barcode" /></div>
				</td>
			</tr>
			';
	}

	$lnsw = '';
	if ($result[0]['LNSW_NOAJU'] != '') {
		$lnsw = '<tr>
			<td>Join Inspection</td>
			<td colspan="2">: '.$result[0]['LNSW_NOAJU'].' / '.$result[0]['LNSW_TGLAJU'].'</td>
		</tr>';
	}
		$ADMIN=$title;
	


	
	$htmlContent2 = '
			
			 <style>
			 .center {
				margin-left: auto;
				margin-right: auto;
			  }
				#footer{
					height:50px;
					line-height:50px;
					color:#000;
					font-weight: bold;
					position:absolute;
					bottom:0px;
				}
				.tblee {
					height: 170px;
				}
			</style><br><br>
			 <table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td></td>
                                        <TH></TH>
					<td width="20px" style="border:0px solid black;"><!--.$title.--></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
                           </table>
                           <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<th align="right" style="width:5px;" ></th>
					<th style="font-size:16px;" align="center"></th>
				</tr>
				<tr>
					<th><!--SPK No. : .$NO_SPK.--></th>
				</tr>
			 </table>
			 <br><br>
			 <table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td colspan="3">
						
					</td><Br><Br>
				</tr>
				

			 </table>
			 <table border="0" width="50%" cellpadding="0" class="center" cellspacing="0">
						<tr>
							<th width="5%" style="border:1px solid black">No.</th>
							<th width="10%" style="border:1px solid black">NOMOR KONTAINER</th>
							<th width="10%" style="border:1px solid black">UKURAN KONTAINER</th>
							<th width="10%" style="border:1px solid black">BARCODE</th>
						</tr>
						'.$tr11.'
					 </table>
					</td>
				</tr>
			 </table><br>
			 <div style="text-align:justify;">
				
			 </div>
			 <br>
			 
			
			 
			 ';
	return $htmlContent2;

}

// Add new page
