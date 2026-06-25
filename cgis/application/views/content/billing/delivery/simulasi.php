<?php
	//echo "sini";die();
	//print_r($result);die();
	//print_r($result_cont[0]['NO_KONTAINER']);die();
	//echo $result_hdr[0]->;
	//echo $result[0]['START'];die();
?>
<div class="form-fieldset" style="margin: 5px 5px 5px 5px">
	<table border='0' width="100%">
    	<tr>
        	<td align="center">
            	<fieldset >
                	<div style="background-color:#fff; border:thin #00F groove">
						<table>
                <tr height="25">
                    <td COLSPAN="32" align="left"></td>
                </tr>
				<tr>
                    <td COLSPAN="32" align="left">
                    	<img src="<?php echo base_url(); ?>assets/images/ipc_logo.png" style="float: left;"><br>
                    	<div style="line-height: 30px;">　　　
                    	　	<b>PT. IPC TERMINAL PETIKEMAS</b><br>
		　　　　          		ALAMAT	: Jln. Pasoso No.1 Tanjung Priok<br>
		　　　　          		N.P.W.P.	: 03.276.307.0-093.000
                    	</div>
                    </td>
					<!--<td COLSPAN="9">
                    	<div style="line-height: 30px;;" align="center">　　　
                    	　	<b>PT. IPC TERMINAL PETIKEMAS</b><br>
		　　　　          		ALAMAT	: Jln. Pasoso No.1 Tanjung Priok<br>
		　　　　          		N.P.W.P.	: 03.276.307.0-093.000
                    	</div>
					</td>
					<td></td>
					-->
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
				<?php
					//if($list_header["NO_NOTA_DELIVERY"] != ''){
				?>
				<tr>
					<td colspan="17"></td>
					<td colspan="4" align="right">No. Nota</td>
					<td colspan="1" align="right">:</td>
					<td colspan="8" align="left">&nbsp&nbsp<?php echo $result_hdr[0]["NO_NOTA_DELIVERY"]?></td>
				</tr>
				<?php//}?>
				<tr>
					<td colspan="17"></td>
					<td colspan="4" align="right">No. Request</td>
					<td colspan="1" align="right">:</td>
					<td colspan="8" align="left">&nbsp&nbsp<?php echo $result_hdr[0]["ID_REQ"]?></td>
				</tr>

				<tr>
					<td COLSPAN="17"></td>
					<td COLSPAN="4" align="right">Tgl.Proses</td>
					<td colspan="1" align="right">:</td>
					<td COLSPAN="8" align="left">&nbsp&nbsp<?php echo date('d-m-Y');?></td>
				</tr>

                <tr height="30">
                    <td COLSPAN="32" align="left"></td>
                </tr>
				<?php /*if($list_header['NO_NOTA_DELIVERY'] != ''){
					$msg = "NOTA";
					}else{
					$msg = "PRANOTA";*/
				//}?>
				<tr>
					<td COLSPAN="11"></td>
					<td COLSPAN="14" align="left" align="center"><font size="4"><b>
					<?php
						if ($result_hdr[0]["NO_NOTA_DELIVERY"] == NULL) {
							echo "PRANOTA DELIVERY";
						} else {
							echo "NOTA DELIVERY";
						}
					?>
						</b>
					</font></td>
				</tr>
               <tr height="30">
                    <td COLSPAN="32" align="left"></td>
                </tr>
				<tr>
					<td colspan="3"></td>
					<td colspan="14" align="left"><?php echo $result_cust[0]["NAMA_CUST"]?></td>
					<td ></td>
				</tr>
				<tr>
					<td colspan="3"></td>
					<td colspan="14" align="left"><?php echo $result_cust[0]["NPWP"]?></td>
					<td ></td>
				</tr>
				<tr>
					<td colspan="3"></td>
					<td colspan="14" align="left"><?php echo $result_cust[0]["ALAMAT"]?></td>
					<td ></td>
				</tr>
				<tr>
					<td colspan="3"></td>
					<td colspan="14" align="left"><?php echo  $result_hdr[0]["NM_KAPAL"]?> - <?php echo $result_hdr[0]["NO_VOY"]?></td>
					<td ></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td colspan="3"></td>
					<td colspan="9" align="left">No DO : <?php echo  $result_hdr[0]["NO_DO"]?></td>
					<td colspan="3"></td>
					<td colspan="12" align="left"></td>
				</tr>
				<tr>
					<td colspan="3"></td>
					<td colspan="9" align="left">No BL : <?php echo  $result_hdr[0]["NO_BL"]?></td>
					<td colspan="3"></td>
					<td colspan="12" align="left"></td>
				</tr>
				<tr>
					<td colspan="3"></td>
					<td colspan="9" align="left">No Document : <?php echo $result_hdr[0]["NO_DOK"]?></td>
					<td colspan="3"></td>
					<td colspan="12" align="left">Date Of Stacking : <?php echo date('d-m-Y H:i:s',strtotime($result_hdr[0]["TGL_STACK"]))//date('d-m-Y',strtotime($result[0]["START"])) ?></td>
				</tr>
				<tr>
					<td colspan="3"></td>
					<td colspan="9" align="left">Date Of Document : <?php echo  date('d-m-Y',strtotime($result_hdr[0]["TGL_DOK"])) ?>
					<td colspan="3"></td>
					<td colspan="12" align="left">Date Of Delivery : <?php echo  date('d-m-Y',strtotime($result_hdr[0]["EXPIRED"])) ?></td>
				</tr>
				<tr>
					<td colspan="3"></td>
					<td colspan="9" align="left"></td>
					<td colspan="3"></td>
					<td colspan="12" align="left"></td>
				</tr>
				<tr>
					<td colspan="3"></td>
					<td colspan="9" align="left">No. Kontainer : <?php echo $result_cont[0]['NO_KONTAINER']?></td>
					<td colspan="3"></td>
					<td colspan="12" align="left"></td>
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
				<alt var='bg' list='#f9f9f3,#ffe'/>
				<?php
				$JMLH = count($result);
				$start = '';
				$jml = 0;
				$hari = 0;
				for($c=0;$c<$JMLH;$c++){
					if($result[$c]['JUMLAH'] > 0){
						//old
							echo $tr = '
								<tr>
									<td colspan="3"></td>
									<td colspan="5" colspan>'.$result[$c]["TITLE"].'</td>
									<td colspan>'.$result[$c]['START'].'</td>
									<td colspan>'.$result[$c]['END'].'</td>
									<td align="center">'.$result[$c]['SIZE'].'</td>
									<td align="center">'.$result[$c]['TYPE'].'</td>
									<td align="center">'.$result[$c]['STATUS'].'</td>
									<td align="center">'.$result[$c]["BOX"].'</td>
									<td align="center">'.$result[$c]["HARI"].'</td>
									<td colspan="5" align="right">'.number_format($result[$c]['TARIF'], 2, '.', ',').'</td>
									<td colspan="2" align="right">IDR</td>
									<td colspan="5" align="right">'.number_format($result[$c]['JUMLAH'], 2, '.', ',').'</td>
									<td colspan="2"></td>
								</tr>
						';
						
						
						//end
						
						//start new
						/*if($result[$c]["TITLE"]==$result[$c+1]["TITLE"]){
							$start = $result[$c]['START'];
							$jml += $result[$c]['JUMLAH'];
							$hari += $result[$c]["HARI"];
						}else{
							if($start!='')
								$start = $start;
							else
								$start = $result[$c]['START'];
							
							echo $tr = '
									<tr>
										<td colspan="3"></td>
										<td colspan="5" colspan>'.$result[$c]["TITLE"].'</td>
										<td colspan>'.$start.'</td>
										<td colspan>'.$result[$c]['END'].'</td>
										<td align="center">'.$result[$c]['SIZE'].'</td>
										<td align="center">'.$result[$c]['TYPE'].'</td>
										<td align="center">'.$result[$c]['STATUS'].'</td>
										<td align="center">'.$result[$c]["BOX"].'</td>
										<td align="center">'.($result[$c]["HARI"]+$hari).'</td>
										<td colspan="5" align="right">'.number_format($result[$c]['TARIF'], 2, '.', ',').'</td>
										<td colspan="2" align="right">IDR</td>
										<td colspan="5" align="right">'.number_format(($result[$c]['JUMLAH']+$jml), 2, '.', ',').'</td>
										<td colspan="2"></td>
									</tr>
							';
							$jml = 0;
							$hari = 0;
							$start = '';
						}*/						
						//end new
						
					}
				}
				?>
				<?php /*}
					else if($row["JENIS_BIAYA"] == 'MATERAI'){
						$biaya_materai = $row["TOTAL_TARIF"];
					}
					else if($row["JENIS_BIAYA"] == 'ADMINISTRASI'){
						$biaya_admin = $row["TOTAL_TARIF"];
					}
				}
				$ppn = ($total_biaya+$biaya_admin)/10;
				$total = $total_biaya+$biaya_admin+$ppn+$biaya_materai;*/
				?>
				</fill>

                <tr><td colspan="32">-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</td></tr>

				<tr><td></td></tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
				<!--
				<tr>
					<td colspan="18"></td>
					<td colspan="7"  align="right">Discount :</td>
                    <td colspan="7" align="right">0%</td>
				</tr>
				-->
				<tr>
					<td colspan="18"></td>
					<td colspan="7"  align="right">Administrasi :</td>
                    <td colspan="7" align="right">20.000,00<?//=number_format($result_hdr[0], 2, '.', ',')?></td>

				</tr>
				<tr>
					<td colspan="18"></td>
					<td colspan="7"  align="right">Dasar Pengenaan Pajak :</td>
                    <td colspan="7" align="right"><?php echo number_format($result_hdr[0]['SUBTOTAL'], 2, '.', ',')?></td>

				</tr>
				<tr>
					<td colspan="18"></td>
					<td colspan="7"  align="right">Jumlah PPN :</td>
                    <td colspan="7" align="right"><?php echo number_format($result_hdr[0]['PPN'], 2, '.', ',')?></td>

				</tr>
				<tr>
					<td colspan="18"></td>
					<td colspan="7"  align="right">Bea Materai :</td>
                    <td colspan="7" align="right"><?php echo number_format($result_hdr[0]['BIAYA_MATERAI'], 2, '.', ',')?></td>

				</tr>
				<tr>
					<td colspan="18"></td>
					<td colspan="7"  align="right">Jumlah Dibayar :</td>
                    <td colspan="7" align="right"><?php echo number_format($result_hdr[0]['TOTAL'], 2, '.', ',')?></td>

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
						Per - 27/PJ/2011 tanggal 19 September 2011
					</td>
				</tr>

                <tr height="25">
                    <td COLSPAN="32" align="left"></td>
                </tr>
				<tr>
					<td colspan="32">
					<?php
						function Terbilang($x)
						{
						  $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
						  if ($x < 12)
							return " " . $abil[$x];
						  elseif ($x < 20)
							return Terbilang($x - 10) . " belas";
						  elseif ($x < 100)
							return Terbilang($x / 10) . " puluh" . Terbilang($x % 10);
						  elseif ($x < 200)
							return " seratus" . Terbilang($x - 100);
						  elseif ($x < 1000)
							return Terbilang($x / 100) . " ratus" . Terbilang($x % 100);
						  elseif ($x < 2000)
							return " seribu" . Terbilang($x - 1000);
						  elseif ($x < 1000000)
							return Terbilang($x / 1000) . " ribu" . Terbilang($x % 1000);
						  elseif ($x < 1000000000)
							return Terbilang($x / 1000000) . " juta" . Terbilang($x % 1000000);
						}
					?>
						#<?php echo ucwords(Terbilang($result_hdr[0]['TOTAL'])).' Rupiah'?>
					</td>
				</tr>
				<tr>
					<td COLSPAN="32">
						<i>
							<?php
								if ($result_hdr[0]["NO_NOTA_DELIVERY"] == NULL) {
									echo "#Perhitungan ini hanya berlaku jika pembayaran dilakukan pada hari ini";
								} else {
									echo "";
								}
							?>
						</i>
					</td>
				</tr>
				<tr>
					<td colspan="32" align="right"><Br><br><Br><br><Br>
						<table border="0"cellpadding="0" cellspacing="0" align="right">
							<tr>
								<td>
									<div> <!--'.date("j F Y", strtotime($data['TGL_SPK'])).'--></div>
									<div><strong><u></strong></u></div>
									<br><br><br><br><br><br>
								</td>
								<td>
									<div>Jakarta, <?php echo date("d M Y"); ?></div>
									<div align="justify"><strong>PETUGAS BILLING COMMON GATE</strong></div>
									<br><br><br><br><br><br>
								</td>
							</tr>
							<tr>
								<td style="vertical-align:top;">
									<div><strong><u></strong></u></div>
									<div></div>
								</td>

								<td style="vertical-align:top;">
									<div><strong><u>___________________________________</strong></u></div>
									<div></div>
								</td>
							</tr>
						 </table>
					</td>
				</tr>
               </table>
				<br/>
				<br/>
               <p> <strong><i>This document is printed by BOS – IPCTPK&nbsp;&nbsp;</i><span><?php echo date("d-m-Y H:i"); ?></span></strong></p>  
			   <p><strong><i>Print By : <?php echo $this->session->userdata('NM_LENGKAP'); ?></i></strong></p>
                    </div>
                </fieldset>
            </td>
		</tr>
    </table>
	<br/>
	<br/>
 </div>
