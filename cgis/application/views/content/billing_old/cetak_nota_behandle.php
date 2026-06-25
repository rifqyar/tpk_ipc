<?php
	$BA = $this->db->query("SELECT TARIF AS 'Tarif' FROM m_tarif WHERE JENIS_BIAYA = 'ADMINISTRASI'")->row()->Tarif;

	$Harga = $result_hdr[0]["SUBTOTAL"] + $BA;
	$PPN = $Harga * 0.1;
	$TOTAL= $Harga + $PPN + $result_hdr[0]['BIAYA_MATERAI'];

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
					//if($list_header["NO_NOTA_BEHANDLE"] != ''){
				?>
				<tr>
					<td colspan="17"></td>
					<td colspan="4" align="right">No. Nota</td>
					<td colspan="1" align="right">:</td>
					<td colspan="8" align="left">&nbsp&nbsp<?php echo $result_hdr[0]["NO_NOTA_BEHANDLE"]?></td>
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
					<td COLSPAN="8" align="left">&nbsp&nbsp<?php echo  date('d-m-Y');?></td>
				</tr>

                <tr height="30">
                    <td COLSPAN="32" align="left"></td>
                </tr>
				<?php /*if($list_header['NO_NOTA_BEHANDLE'] != ''){
					$msg = "NOTA";
					}else{
					$msg = "PRANOTA";*/
				//}?>
				<tr>
					<td COLSPAN="11"></td>
					<td COLSPAN="14" align="left" align="center"><font size="4"><b>
					<?php
						if ($result_hdr[0]["NO_NOTA_BEHANDLE"] == NULL) {
							echo "PRANOTA BEHANDLE";
						} else {
							echo "NOTA BEHANDLE";
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
					<td colspan="14" align="left"><?php echo $result_hdr[0]["NAMA_CUST"]?></td>
					<td ></td>
				</tr>
				<tr>
					<td colspan="3"></td>
					<td colspan="14" align="left"><?php echo $result_hdr[0]["NPWP"]?></td>
					<td ></td>
				</tr>
				<tr>
					<td colspan="3"></td>
					<td colspan="14" align="left"><?php echo $result_hdr[0]["ALAMAT"]?></td>
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
				<!-- TGL 21 Maret 2017 Req : Mas Novanda
				<tr>
					<td colspan="3"></td>
					<td colspan="9" align="left">No DO : <?php echo  $result_hdr[0]["NO_DO"]?></td>
					<td colspan="3"></td>
					<td colspan="12" align="left"></td>
				</tr>
				<tr>
					<td colspan="3"></td>
					<td colspan="9" align="left">No BL : <?php echo $result_hdr[0]["NO_BL"]?></td>
					<td colspan="3"></td>
					<td colspan="12" align="left"></td>
				</tr>
				-->
				<tr>
					<td colspan="3"></td>
					<td colspan="9" align="left">No Document : <?php echo $result_hdr[0]["NO_DOK"]?></td>
					<td colspan="3"></td>
					<td colspan="12" align="left"><?php //echo $result[0]['START']?></td>
				</tr>
				<tr>

					<td colspan="3"></td>
					<td colspan="9" align="left">Date Of Document : <?php echo date('d-m-Y',strtotime($result_hdr[0]["TGL_DOK"])) ?></td>
					<td colspan="3"></td>
					<td colspan="12" align="left"> <?php //echo date('d-m-Y',strtotime($result_hdr[0]["EXPIRED"])) ?></td>
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
					<td align="center" width="40"><b>SIZE</b></td>
					<td align="center" width="80" colspan="3"><b>JENIS</b></td>
					<td align="center" width="40"><b>BOX</b></td>
					<td colspan="5" width="120" align="right"><b>TARIF</b></td>
					<td align="center" width="40"></td>
					<td align="center" width="80"></td>

					<td colspan="2" width="40" align="right"><b>VAL</b></td>
					<td align="center" width="40"></td>
					<td colspan="5" align="right" width="80"><b>JUMLAH</b></td>
					<td colspan="2"></td>
				</tr>
				<tr><td colspan="32">-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</td></tr>

				<fill src="row_detail" var="rows">
				<alt var='bg' list='#f9f9f3,#ffe'/>
				<?php
				$JMLH = count($result);
				for($c=0;$c<$JMLH;$c++){
					echo $tr = '
							<tr>
								<td colspan="3"></td>
								<td colspan="5" colspan>'.$result[$c]["TITLE"].'</td>

								<td align="center">'.$result[$c]['SIZE'].'</td>
								<td align="center" colspan="3">'.$result[$c]['PAKET'].'</td>
								<td align="center">'.$result[$c]["BOX"].'</td>
								<td colspan="5" align="right">'.number_format($result[$c]['TARIF'], 2, '.', ',').'</td>
								<td align="center" width="40"></td>
								<td align="center" width="80"></td>

								<td colspan="2" align="right">IDR</td>
								<td align="center" width="40"></td>
								<td colspan="5" align="right">'.number_format($result[$c]['TOTAL'], 2, '.', ',').'</td>
								<td colspan="2"></td>
							</tr>
					';
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

				<tr>
					<td colspan="18"></td>
					<td colspan="7"  align="right"></td>
                    <td colspan="7" align="right"></td>
				</tr>
				<tr>
					<td colspan="18"></td>
					<td colspan="7"  align="right">Administrasi :</td>
                    <td colspan="7" align="right">20.000,00<?//=number_format($result_hdr[0], 2, '.', ',')?></td>

				</tr>
				<tr>
					<td colspan="18"></td>
					<td colspan="7"  align="right">Dasar Pengenaan Pajak :</td>
                    <td colspan="7" align="right"><?php echo number_format($Harga, 2, '.', ',')?></td>
				</tr>
				<tr>
					<td colspan="18"></td>
					<td colspan="7"  align="right">Jumlah PPN :</td>
                    <td colspan="7" align="right"><?php echo number_format($PPN, 2, '.', ',')?></td>

				</tr>
				<tr>
					<td colspan="18"></td>
					<td colspan="7"  align="right">Bea Materai :</td>
                    <td colspan="7" align="right"><?php echo number_format($result_hdr[0]['BIAYA_MATERAI'], 2, '.', ',')?></td>

				</tr>
				<tr>
					<td colspan="18"></td>
					<td colspan="7"  align="right">Jumlah Dibayar :</td>
                    <td colspan="7" align="right"><?php echo number_format($TOTAL, 2, '.', ',')?></td>

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
						#<?php echo ucwords(Terbilang($result_hdr[0]['TOTAL_JUMLAH'])).' Rupiah'?>
					</td>
				</tr>
				<tr>
					<td COLSPAN="32">
						<i>
							<?php
								if ($result_hdr[0]["NO_NOTA_BEHANDLE"] == NULL) {
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
				<div style="text-align: left">
				<p>
					<i>&nbsp;&nbsp;This document is printed by BOS - IPCTPK &nbsp;&nbsp;&nbsp;</i><span><?php echo date("d-m-Y H:i"); ?></span>
				</p>
				<p><strong><i>Print By : <?php echo $this->session->userdata('NM_LENGKAP'); ?></i></strong></p>
        </div>
                </fieldset>
            </td>
		</tr>
    </table>
	<br/>
	<br/>
 </div>
