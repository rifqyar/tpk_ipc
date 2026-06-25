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
	/*$JMLH = count($result);
	//print_r($JMLH);die();
	$NO_SPK = $result['NO_SPK'];
	for($c=0;$c<$JMLH;$c++){
		//$NO_SPK .= $result[$c]['NO_SPK'];
		$tr .= '
			
				<tr>
					<td width="5%" style="border:1px solid black;border-top:none;" align="center">'.$result[$c]['NO_SPK']."<br>".date("d-m-Y", strtotime($result[$c]['TGL_SPK'])).'</td>
					<td width="30%" style="border:1px solid black;border-top:none;">'.$result[$c]['JENIS DOKUMEN']."<BR>".$result[$c]['NO_DOK']."<BR>".$result[$c]['TGL_SPK'].'</td>
					<td width="30%" style="border:1px solid black;border-top:none;">'.$result[$c]['NO_CONT'].'</td>
				</tr>
		';
	}*/
	
        //print_r($datafcl);die();
	$html = '<div class="form-fieldset" style="margin: 5px 5px 5px 5px">
	<table border=0 width="100%">
    	<tr>
        	<td align="center">
            	<fieldset >
                	<div style="background-color:#fff; border:thin #00F groove">
						<table>
                <tr height="25">
                    <td COLSPAN="32" align="left"></td>
                </tr>
						<tr>
                    <td COLSPAN="32" align="left"><b>IPC TPK</b></td>
                </tr>
                <tr>
                    <td COLSPAN="32" align="left"><b></b></td>
                </tr>
                <tr height="25">
                    <td COLSPAN="32" align="left"></td>
                </tr>
				<tr>
					<td colspan="26"></td>
					<td colspan="5" align="right"><b></b></td>
				</tr>
				<tr><td></td></tr>
				<tr>
					<td colspan="17"></td>
					<td colspan="4" align="right">No. Nota</td>
					<td colspan="1" align="right">:</td>
					<td colspan="8" align="left"></td>
				</tr>
				<tr>
					<td colspan="17"></td>
					<td colspan="4" align="right">No. Request</td>
					<td colspan="1" align="right">:</td>
					<td colspan="8" align="left"><td>
				</tr>
				
				<tr>
					<td COLSPAN="17"></td>
					<td COLSPAN="4" align="right">Tgl.Proses</td>
					<td colspan="1" align="right">:</td>
					<td COLSPAN="8" align="left"></td>
				</tr>

                <tr height="30">
                    <td COLSPAN="32" align="left"></td>
                </tr>
				<tr>
					<td COLSPAN="17"></td>
					<td COLSPAN="15" align="left"><font size="2"><b> DELIVERY</b></font></td>
				</tr>
               <tr height="30">
                    <td COLSPAN="32" align="left"></td>
                </tr>
				<tr>
					<td colspan="3"></td>
					<td colspan="14" align="left"></td>
					<td ></td>
				</tr> 
				<tr>
					<td colspan="3"></td>
					<td colspan="14" align="left"></td>
					<td ></td>
				</tr>
				<tr>
					<td colspan="3"></td>
					<td colspan="14" align="left"></td>
					<td ></td>
				</tr>
				
				<tr>
					<td colspan="3"></td>
					<td colspan="14" align="left"></td>
					<td ></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td colspan="3"></td>
					<td colspan="9" align="left">No DO : </td>
					<td colspan="3"></td>
					<td colspan="12" align="left"></td>
				</tr> 
				<tr>
					<td colspan="3"></td>
					<td colspan="9" align="left">No BL : </td>
					<td colspan="3"></td>
					<td colspan="12" align="left"></td>
				</tr> 
				<tr>
					<td colspan="3"></td>
					<td colspan="9" align="left">No Document : '.$result[0]['NO_DOK'].'</td>
					<td colspan="3"></td>
					<td colspan="12" align="left">Date Of Stacking : </td>
				</tr> 
				<tr>
					<td colspan="3"></td>
					<td colspan="9" align="left">Date Of Document : </td>
					<td colspan="3"></td>
					<td colspan="12" align="left">Date Of Delivery : </td>
				</tr> 		
               <tr height="30">
                    <td COLSPAN="32" align="left"></td>
                </tr>
				<tr>
					<td colspan="3"></td>
					<td colspan="5" width="180"><b>KETERANGAN</b></td>
					<td align="center" width="100"><b>START</b></td>
					<td align="center" width="100"><b>END</b></td>
					<td align="center" width="40"><b>SIZE</b></td>
					<td align="center" width="40"><b>TYPE</b></td>
					<td align="center" width="40"><b>STATUS</b></td>
					<td align="center" width="40"><b>BOX</b></td>
					<td align="center" width="40"><b>HARI</b></td>
					<td colspan="5" width="120" align="right"><b>TARIF</b></td>
					<td colspan="2" width="40" align="right"><b>VAL</b></td>
					<td colspan="5" align="right" width="80"><b>JUMLAH</b></td>
					<td colspan="2"></td>
				</tr>
				<tr><td colspan="32">-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</td></tr>

				<fill src="row_detail" var="rows">
				<alt var=\'bg\' list=\'#f9f9f3,#ffe\'>
				<tr>
					<td colspan="0">PENUMPAKAN MASA 1</td>
					<td colspan="0">'.$result[0]['M1_START_DATE'].'</td>
					<td colspan>'.$result[0]['M1_END_DATE'].'</td>
					<td colspan>'.$result[0]['UKR_CONT'].'</td>
					<td align="center">'.$result[0]['ISO_CODE'].'</td>
					<td align="center">'.$result[0]['STATUS'].'</td>
					<td align="center"></td>
					<td align="center"></td>
					<td align="center"></td>
					<td colspan="5" align="right">'.$result[0]['CHARGE'].'</td>
					<td colspan="2" align="right">IDR</td>
					<td colspan="5" align="right">'.$result[0]['TOTAL_M4'].'</td>
					<td colspan="2"></td>
				</tr>
				</fill>
	
                <tr><td colspan="32">-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</td></tr>

				<tr><td></td></tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
				
				<tr>
					<td colspan="18"></td>
					<td colspan="7"  align="right">Discount : 0%</td>
                    <td colspan="7" align="right"></td>
				</tr>
				<tr>
					<td colspan="18"></td>
					<td colspan="7"  align="right">Administrasi : 20.000</td>
                    <td colspan="7" align="right"></td>
					
				</tr>
				<tr>
					<td colspan="18"></td>
					<td colspan="7"  align="right">Dasar Pengenaan Pajak :</td>
                    <td colspan="7" align="right"></td>
					
				</tr>
				<tr>
					<td colspan="18"></td>
					<td colspan="7"  align="right">Jumlah PPN :</td>
                    <td colspan="7" align="right"></td>
					
				</tr>
				<tr>
					<td colspan="18"></td>
					<td colspan="7"  align="right">Bea Materai :</td>
                    <td colspan="7" align="right"></td>
					
				</tr>
				<tr>
					<td colspan="18"></td>
					<td colspan="7"  align="right">Jumlah Dibayar :</td>
                    <td colspan="7" align="right"></td>
					
				</tr>
				<tr height="25">
                    <td COLSPAN="32" align="left"></td>
                </tr>
                <tr height="25">
                    <td COLSPAN="32" align="left"></td>
                </tr>
                <tr>
					<td colspan="32">
						Nota sebagai faktur pajak berdasarkan Peraturan Dirjen Pajak
					</td>
				</tr>
				<tr>
					<td colspan="32">
						Per - 27/PJ/2016 tanggal 1 Desember 2016
					</td>
				</tr>
				
                <tr height="25">
                    <td COLSPAN="32" align="left"></td>
                </tr>
				<tr>
					<td colspan="32">Rupiah
					</td>
				</tr>
               
						</table>
	<br/>
	<br/>
                    </div>
                </fieldset>
            </td>
		</tr>
    </table>
	<br/>
	<br/>
 </div>';
	return $html;
	//}
}