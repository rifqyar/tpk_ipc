
 
<div class="form-fieldset" style="margin: 5px 5px 5px 5px">
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
				<?php
					//if($list_header["NO_NOTA_DELIVERY"] != ''){
				?>
				<tr>
					<td colspan="17"></td>
					<td colspan="4" align="right">No. Nota</td>
					<td colspan="1" align="right">:</td>
					<td colspan="8" align="left">&nbsp&nbsp<?//=$list_header["NO_NOTA_DELIVERY"]?></td>
				</tr>
				<?php//}?>
				<tr>
					<td colspan="17"></td>
					<td colspan="4" align="right">No. Request</td>
					<td colspan="1" align="right">:</td>
					<td colspan="8" align="left">&nbsp&nbsp<?//=$list_header["ID_REQ"]?></td>
				</tr>
				
				<tr>
					<td COLSPAN="17"></td>
					<td COLSPAN="4" align="right">Tgl.Proses</td>
					<td colspan="1" align="right">:</td>
					<td COLSPAN="8" align="left">&nbsp&nbsp<?//=$list_header["TANGGAL_REQ"]?></td>
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
					<td COLSPAN="17"></td>
					<td COLSPAN="15" align="left"><font size="2"><b><?//=$msg?> DELIVERY</b></font></td>
				</tr>
               <tr height="30">
                    <td COLSPAN="32" align="left"></td>
                </tr>
				<tr>
					<td colspan="3"></td>
					<td colspan="14" align="left"><?//=$list_header["NAMA"]?></td>
					<td ></td>
				</tr> 
				<tr>
					<td colspan="3"></td>
					<td colspan="14" align="left"><?//=$list_header["NO_NPWP"]?></td>
					<td ></td>
				</tr>
				<tr>
					<td colspan="3"></td>
					<td colspan="14" align="left"><?//=$list_header["ALAMAT"]?></td>
					<td ></td>
				</tr>
				
				<tr>
					<td colspan="3"></td>
					<td colspan="14" align="left"><?//=$list_header["NAMA_KAPAL"]?> - <?//=$list_header["VOY_IN"]?>/<?//=$list_header["VOY_OUT"]?></td>
					<td ></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td colspan="3"></td>
					<td colspan="9" align="left">No DO : <?//=$list_header["NO_DO"]?></td>
					<td colspan="3"></td>
					<td colspan="12" align="left"></td>
				</tr> 
				<tr>
					<td colspan="3"></td>
					<td colspan="9" align="left">No BL : <?//=$list_header["NO_BL"]?></td>
					<td colspan="3"></td>
					<td colspan="12" align="left"></td>
				</tr> 
				<tr>
					<td colspan="3"></td>
					<td colspan="9" align="left">No Document : <?//=$list_header["NO_DOC"]?></td>
					<td colspan="3"></td>
					<td colspan="12" align="left">Date Of Stacking : <?//=$list_header["TANGGAL_BONGKAR"]?></td>
				</tr> 
				<tr>
					<td colspan="3"></td>
					<td colspan="9" align="left">Date Of Document : <?//=$list_header["TANGGAL"]?></td>
					<td colspan="3"></td>
					<td colspan="12" align="left">Date Of Delivery : <?//=$list_header["TANGGAL_DELIVERY"]?></td>
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
				/*$biaya_materai = 0;
				$biaya_admin = 0;
				$total_biaya = 0;
				$ppn = 0;
				$total = 0;
				foreach ($list_detail as $row) { 
					if($row["JENIS_BIAYA"] != 'ADMINISTRASI' AND $row["JENIS_BIAYA"] != 'MATERAI'){
						$total_biaya += $row["TOTAL_TARIF"];*/
				?>
				<tr>
					<td colspan="3"></td>
					<td colspan="5" colspan><?//=$row["JENIS_BIAYA"]?></td>
					<td colspan><?//=$row["TANGGAL_AWAL"]?></td>
					<td colspan><?//=$row["TANGGAL_AKHIR"]?></td>
					<td align="center"><?//=$row["SIZE_CONT"]?></td>
					<td align="center"><?//=$row["TYPE_CONT"]?></td>
					<td align="center"><?//=$row["STATUS_CONT"]?></td>
					<td align="center"><?//=$row["JUMLAH_CONT"]?></td>
					<td align="center"><?//=$row["TERHITUNG_HARI"]?></td>
					<td colspan="5" align="right"><?//=number_format($row["TARIF_DASAR"], 2, '.', ',')?></td>
					<td colspan="2" align="right">IDR</td>
					<td colspan="5" align="right"><?//=number_format($row["TOTAL_TARIF"], 2, '.', ',')?></td>
					<td colspan="2"></td>
				</tr>
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
					<td colspan="7"  align="right">Discount :</td>
                    <td colspan="7" align="right"><?//=number_format(0, 2, '.', ',')?></td>
				</tr>
				<tr>
					<td colspan="18"></td>
					<td colspan="7"  align="right">Administrasi :</td>
                    <td colspan="7" align="right"><?//=number_format($biaya_admin, 2, '.', ',')?></td>
					
				</tr>
				<tr>
					<td colspan="18"></td>
					<td colspan="7"  align="right">Dasar Pengenaan Pajak :</td>
                    <td colspan="7" align="right"><?//=number_format($total_biaya+$biaya_admin, 2, '.', ',')?></td>
					
				</tr>
				<tr>
					<td colspan="18"></td>
					<td colspan="7"  align="right">Jumlah PPN :</td>
                    <td colspan="7" align="right"><?//=number_format($ppn, 2, '.', ',')?></td>
					
				</tr>
				<tr>
					<td colspan="18"></td>
					<td colspan="7"  align="right">Bea Materai :</td>
                    <td colspan="7" align="right"><?//=number_format($biaya_materai, 2, '.', ',')?></td>
					
				</tr>
				<tr>
					<td colspan="18"></td>
					<td colspan="7"  align="right">Jumlah Dibayar :</td>
                    <td colspan="7" align="right"><?//=number_format($total, 2, '.', ',')?></td>
					
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
						/*function Terbilang($x)
						{
						  $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
						  if ($x < 12)
							return " " . $abil[$x];
						  elseif ($x < 20)
							return Terbilang($x - 10) . "belas";
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
						}*/
					?>
						#<?//=ucwords(Terbilang($total)).' Rupiah'?>
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
 </div>