<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//print_r($result);die();
//echo "sini";die();
//echo $title;
//echo $result[0]['TOTAL_M4'];die();
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
					body {
						height: 25%;
						}

						#wrap {
						min-height: 25%;
						}

						#main {
						overflow:auto;
						padding-bottom:25px; /* this needs to be bigger than footer height*/
						}

						.footer {
						position: relative;
						margin-top: -25px; /* negative value of footer height */
						height: 25px;
						clear:both;
						padding-top:10px;
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
	/*$JMLH = count($result);
	//print_r($JMLH);die();
	$NO_SPK = $result['NO_SPK'];
	for($c=0;$c<$JMLH;$c++){
		//$NO_SPK .= $result[$c]['NO_SPK'];
		$tr .=`` '

				<tr>
					<td width="5%" style="border:1px solid black;border-top:none;" align="center">'.$result[$c]['NO_SPK']."<br>".date("d-m-Y", strtotime($result[$c]['TGL_SPK'])).'</td>
					<td width="30%" style="border:1px solid black;border-top:none;">'.$result[$c]['JENIS DOKUMEN']."<BR>".$result[$c]['NO_DOK']."<BR>".$result[$c]['TGL_SPK'].'</td>
					<td width="30%" style="border:1px solid black;border-top:none;">'.$result[$c]['NO_CONT'].'</td>
				</tr>
		';
	}*/

        //print_r($datafcl);die();
	$html = '
		<div id="wrap">
		<div id="main" class="container clear-top" style="margin: 2px 2px 2px 2px">
		<table width="100%">
				<tr>
					<td align="center" colspan="5"><H4>REPRINT<br><font size="1">EQUIPMENT INTERCHANGE RECEIPT</font></H4></td>
				</tr>
				<tr>
					<td style="width:5%"></td>
				</tr>
				<tr>
					<td align="left"><font size="2">Container No.</font></td>
					<td>:</td>
					<td colspan="6"></td>
				</tr>
				<tr>
					<td align="left"><font size="2">Size/Type</font></td>
					<td >:</td>
					<td colspan="6"></td>
				</tr>
				<tr>
					<td align="left"><font size="2">Vessel Full Name</font></td>
					<td >:</td>
					<td colspan="6"></td>
				</tr>
				<tr>
					<td align="left"><font size="2">ETD(DD/MM/YYYYY)</font></td>
					<td >:</td>
					<td colspan="6"></td>
				</tr>
				<tr>
					<td align="left"><font size="2">Container Operation</font></td>
					<td >:</td>
					<td colspan="6"></td>
				</tr>
				<tr>
					<td align="left"><font size="2">Booking No.</font></td>
					<td >:</td>
					<td colspan="6"></td>
				</tr>
				<tr>
					<td align="left"><font size="2">POD</font></td>
					<td >:</td>
					<td colspan="6"></td>
				</tr>
				<tr>
					<td align="left"><font size="2">SP Handling</font></td>
					<td >:</td>
					<td colspan="6"></td>
				</tr>
				<tr>
					<td align="left"><font size="2">Cross Weight (KG)</font></td>
					<td >:</td>
					<td colspan="6"></td>
				</tr>
				<tr>
					<td align="left"><font size="2">Class (XX, II)</font></td>
					<td >:</td>
					<td colspan="6"></td>
				</tr>
				<tr>
					<td align="left"><font size="2">Full/Empty (F/M)</font></td>
					<td >:</td>
					<td colspan="6"></td>
				</tr>
				<tr>
					<td align="left"><font size="2">Container Type</font></td>
					<td >:</td>
					<td colspan="6"></td>
				</tr>
				<tr>
					<td align="left"><font size="2">DG Label</font></td>
					<td >:</td>
					<td colspan="6"></td>
				</tr>
				<tr>
					<td align="left"><font size="2">DG Code</font></td>
					<td >:</td>
					<td colspan="6"></td>
				</tr>
				<tr>
					<td align="left"><font size="2">Temperature</font></td>
					<td >:</td>
					<td colspan="6"></td>
				</tr>
				<tr>
					<td align="left"><font size="2">Shipper</font></td>
					<td >:</td>
					<td colspan="6"></td>
				</tr>
				<tr>
					<td align="left"><font size="2">Customes Doc.</font></td>
					<td >:</td>
					<td colspan="6"></td>
				</tr>
				<tr>
					<td align="left"><font size="2">Tag No.</font></td>
					<td >:</td>
					<td colspan="6"></td>
				</tr>
				<tr>
					<td align="left"><font size="2">Police No.</font></td>
					<td >:</td>
					<td colspan="6"></td>
				</tr>
				<tr>
					<td align="left"><font size="2">Trucking</font></td>
					<td >:</td>
					<td colspan="6"></td>
				</tr>
				<tr>
					<td align="left"><font size="2">Seal No.</font></td>
					<td >:</td>
					<td colspan="6"></td>
				</tr>
				<tr>
					<td align="left"><font size="2">Lock Stack</font></td>
					<td >:</td>
					<td colspan="6"></td>
				</tr>
				<tr>
					<td align="left"><font size="2">IN</font></td>
					<td >:</td>
					<td colspan="6"></td>
				</tr>
				<tr>
					<td align="left"><font size="2">OUT</font></td>
					<td >:</td>
					<td colspan="6"></td>
				</tr>
				<tr>
					<td align="left"><font size="2">Inspection</font></td>
					<td >:</td>
					<td colspan="6"></td>
				</tr>
				<tr>
					<td align="left"><font size="2">Remarks</font></td>
					<td >:</td>
					<td colspan="6"></td>
				</tr>
				<tr>
					<td align="left"><font size="2">Inspector</font></td>
					<td >:</td>
					<td colspan="6"></td>
				</tr>		
		</table>
			</div>			
			 <footer class="footer">
				<p>
					<font size="3"><i>This document is generated by CGIS - IPCTPK</i>
				</p>
			 </footer>';
	return $html;
	//}
}
