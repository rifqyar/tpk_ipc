<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//print_r($result);die();
//echo "sini";die();
//echo $title;
//echo $sql->NO_SPK;die();
//echo $userLogin;die();
$mpdf = new mPDF();
$drawPerPage = 50;
$html = getStyle();
$html .= '<body><div class="body">';
$html .= getHTML($result, $title);
$html .= '</div></body>';
$mpdf->WriteHTML($html);
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
//
// function table($data=10,$row=2){
// 	$html = "";
//
// 	$rows = ceil($data/$row);
// 	for($a=0; $a<$rows; $a++){
//
// 	}
// 	$html .= "<table>";
// 	$html .= "<tr>";
// 	$html .= "<td>1111</td>";
// 	$html .= "<td>222</td>";
// 	$html .= "</tr>";
// 	$html .= "</table>";
// }
        //print_r($datafcl);die();
		//print_r($title);die();
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
					<th align="right" style="width:5px;" ><img width="20%" src="assets/images/ipc_logo.png"></th>
					<th style="font-size:16px;" align="center">SURAT PERINTAH KERJA (SPK)<BR>PENARIKAN KONTAINER<BR>'.$result[0]['NO_SPK'].'</th>
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
			 </table><br><br><Br><br><br><br><Br><br><br><br><Br><br><br><br><Br><br><br><br><Br>
				
			 <div style="footer">
				
					<table>
						<tr>
							<td>
								<i>This document is printed by BOS - IPCTPK &nbsp;&nbsp; </i>'.date("d-m-Y H:i").'
							</td>
							<td>
								printed by '.$ADMIN.'
							</td>
						</tr>
					</table>
				
			 </div>';
	return $html;
	//}
}
