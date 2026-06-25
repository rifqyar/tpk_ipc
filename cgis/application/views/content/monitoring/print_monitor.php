<?php
	$mpdf = new mPDF();
	$drawPerPage = 50;
	$html = getStyle();
	$html .= '<body><div class="body">';
	$html .= getHTML($result_cont, $monitor_cont,$result_utama, $title);
	$html .= '</div></body>';
	$mpdf->WriteHTML($html);
	$mpdf->Output();

	function getStyle() {
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
					#footer{
						height:50px;
						line-height:50px;
						color:#000;
						font-weight: bold;
						position:absolute;
						bottom:0px;
					}
				</style>';
			
		return $html;
	}

	function getHTML($result_cont, $monitor_cont,$result_utama, $title) {
		global $CONF;

		$JML = count($monitor_cont);
		$no=1;

		for($i=0; $i < $JML; $i++) {
			$monitor .= '
				<tr>
					<td width="5%" style="border:1px solid black;border-top:none;" align="center">'.$no++.'</td>
					<td width="10%" style="border:1px solid black;border-top:none;" align="center">'.date("d-m-Y", strtotime($monitor_cont[$i]['WAKTU_MONITOR'])).'</td>
					<td width="10%" style="border:1px solid black;border-top:none;" align="center">'.date("H:i:s", strtotime($monitor_cont[$i]['WAKTU_MONITOR'])).'</td>
					<td width="10%" style="border:1px solid black;border-top:none;" align="center">'.$monitor_cont[$i]['TEMPERATURE_MONITOR'].'</td>
				</tr>
			';
		}

		$ADMIN=$title;
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
						<th style="font-size:16px;" align="center">MONITORING KONTAINER REEFER<BR>'.$result_cont['NO_SPK'].'</th>
					</tr>
					<tr>
						<th><!--SPK No. : .$NO_SPK.--></th>
					</tr>
				</table>
				<br><br>
				<p style="text-align:right">'.date("d-m-Y H:i").'</p>
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td colspan="3">
							Dalam rangka memenuhi kebutuhan customer, berikut ini kami lampirkan data monitoring kontainer reefer :
						</td><Br><Br>
					</tr>
					<tr>
						<td>
						NO. CONTAINER
						</td>
						<td colspan="2">
						: '.$result_cont['NO_CONT'].'
						</td>

					</tr>
					<tr>
						<td>
						TEMPERATURE DEFAULT
						</td>
						<td colspan="2">
						: '.$result_utama['TEMP_CUST'].'
						</td>
					</tr>
					<tr>
						<td>
							WAKTU PLUG IN TERMINAL
						</td>
						<td colspan="2">
						: '.$result_utama['PLUG_TERMINAL'].'
						</td>
					</tr>
					
					<tr>
						<td>
						WAKTU PLUG OUT TERMINAL
						</td>
						<td colspan="2">
						: '.$result_utama['UNPLUG_TERMINAL'].'
						</td>
					</tr>

					<tr>
						<td>
					
						</td>
						<td colspan="2">
					
						</td>
					</tr>
					<tr>
						<td>
					
						</td>
						<td colspan="2">
					
						</td>
					</tr>
					<tr>
						<td>
							TEMPERATURE PLUG IN CA
						</td>
						<td colspan="2">
						: '.$result_cont['TEMPERATURE_AWAL'].'
						</td>
					</tr>
					
					<tr>
						<td>
						WAKTU PLUG IN CA
						</td>
						<td colspan="2">
						: '.$result_cont['WAKTU'].'
						</td>
					</tr>
						<tr>
						<td>
							TEMPERATURE PLUG OUT CA
						</td>
						<td colspan="2">
						: '.$result_cont['TEMPERATURE_AKHIR'].'
						</td>
					</tr>
					
					
					<tr>
						<td>
						WAKTU PLUG OUT CA
						</td>
						<td colspan="2">
						: '.$result_cont['WAKTU_END'].'
						</td>
					</tr>
				
					<tr>
						<td width="20%"><br><br></td>
						<td width="1%"></td>
						<td width="69%"></td>
					</tr>
					<tr>
						<td colspan="3">
							List detail monitoring temperature dengan data sebagai berikut :
						</td><Br><Br>
					</tr>
				</table>
				<table border="1" width="100%" cellpadding="0" cellspacing="0" style="text-align:center">
					<tr>
						<th width="5%" style="border:1px solid black">No.</th>
						<th width="10%" style="border:1px solid black">TGL. MONITORING</th>
						<th width="10%" style="border:1px solid black">JAM</th>
						<th width="10%" style="border:1px solid black">TEMPERATURE</th>
					</tr>
					'.$monitor.'
				</tr>
			 </table>';
		// $html = 'NO CONT = '.$result_cont['NO_CONT'].'';
		return $html;
	}
