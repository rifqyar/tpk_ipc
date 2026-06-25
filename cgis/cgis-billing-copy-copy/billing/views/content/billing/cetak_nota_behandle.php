<?php 
$mpdf = new mPDF('',    // mode - default ''
 'A4',    // format - A4, for example, default ''
 15,     // font size - default 0
 'ccourier',    // default font family
 10,    // margin_left
 10,    // margin right
 10,     // margin top
 1,    // margin bottom
 9,     // margin header
 9,     // margin footer
 'L'); 
$drawPerPage = 100;
$html .= '<body><div class="body">';
$html .= getHTML($result, $title, $result_hdr, $result_cust, $result_cont);
$html .= '</div></body>';
$mpdf->WriteHTML($html);
$mpdf->Output();

function Terbilang($x){
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

function getHTML($result, $title, $result_hdr, $result_cust, $result_cont){
	global $CONF;

	if ($result_hdr[0]["NO_NOTA_BEHANDLE"] == NULL) {
		$tr1 = "PRANOTA BEHANDLE";
	} else {
		$tr1 = "NOTA BEHANDLE";
	}

	if ($result_hdr[0]["NO_NOTA_BEHANDLE"] == NULL) {
		$tr2 = "#Perhitungan ini hanya berlaku jika pembayaran dilakukan pada hari ini";
	} else {
		$tr2 = "";
	}

	$no=1;
	for ($i=0; $i < count($result); $i++) { 
		$tr .= ' <tr>
					<td colspan="6" align="left">'.$result[$i]['TITLE'].'</td>
					<td colspan="3" align="center">'.$result[$i]['SIZE'].'</td>
					<td colspan="3" align="center">'.$result[$i]['PAKET'].'</td>
					<td colspan="3" align="center">'.$result[$i]['BOX'].'</td>
					<td colspan="4" align="center">'.number_format($result[$i]['TARIF'], 2, '.', ',').'</td>
					<td colspan="2" align="center">IDR</td>
					<td colspan="6" align="right">'.number_format($result[$i]['TOTAL'], 2, '.', ',').'</td>
				</tr>';
	}

	$Harga = $result_hdr[0]["SUBTOTAL"] + 20000;
	$PPN =  $result_hdr[0]["PPN"];
	$TOTAL= $Harga + $PPN + $result_hdr[0]['BIAYA_MATERAI'];

$ADMIN=$title;
	$html = '<table border="0" width="100%" cellpadding="0" cellspacing="0"  align="left">
				<tr>
					<td rowspan="3" colspan="4"><img src="assets/images/logo-tls.png" width="100px" style="float: left;"></td>
					<td colspan="23"><strong>PT. IPC TERMINAL PETIKEMAS</strong></td>
				</tr>
				<tr>
					<td colspan="3">Alamat</td>
					<td align="center">:</td>
					<td colspan="19">Jln. Pulau Payung No.1 Tanjung Priok</td>
				</tr>
				<tr>
					<td colspan="3">N.P.W.P</td>
					<td align="center">:</td>
					<td colspan="19">02.106.620.4-093.000</td>
				</tr>
				<tr>
					<td colspan="27" style="padding-top: 20px"></td>
				</tr>
				<tr>
					<td colspan="15"></td>
					<td colspan="4" align="right">No. Nota</td>
					<td align="center">:</td>
					<td colspan="7">'.$result_hdr[0]["NO_NOTA_BEHANDLE"].'</td>
				</tr>
				<tr>
					<td colspan="15"></td>
					<td colspan="4" align="right">No. Faktur</td>
					<td align="center">:</td>
					<td colspan="7">'.$result_hdr[0]["NO_FAKTUR"].'</td>
				</tr>
				<tr>
					<td colspan="15"></td>
					<td colspan="4" align="right">No. Request</td>
					<td align="center">:</td>
					<td colspan="7">'.$result_hdr[0]["ID_REQ"].'</td>
				</tr>
				<tr>
					<td colspan="14"></td>
					<td colspan="5" align="right">Date Of Request</td>
					<td align="center">:</td>
					<td colspan="7">'.$result_hdr[0]["TGL_REQ"].'</td>
				</tr>
				<tr>
					<td colspan="27" style="padding-top: 20px"></td>
				</tr>
				<tr>
					<td colspan="27" align="center"><strong>'.$tr1.'</strong></td>
				</tr>
				<tr>
					<td colspan="27" style="padding-top: 20px"></td>
				</tr>
				<tr>
					<td colspan="27">'.$result_cust[0]["NAMA_CUST"].'</td>
				</tr>
				<tr>
					<td colspan="27">'.$result_cust[0]["NPWP"].'</td>
				</tr>
				<tr>
					<td colspan="27">'.$result_cust[0]["ALAMAT"].'</td>
				</tr>
				<tr>
					<td colspan="27">'.$result_hdr[0]["NM_KAPAL"].'-'.$result_hdr[0]["NO_VOY"].'</td>
				</tr>
				<tr>
					<td colspan="27" style="padding-top: 20px"></td>
				</tr>
				<tr>
					<td colspan="3">No DO</td>
					<td align="center">:</td>
					<td colspan="23">'.$result_hdr[0]["NO_DO"].'</td>
				</tr>
				<tr>
					<td colspan="3">No BL</td>
					<td align="center">:</td>
					<td colspan="23">'.$result_hdr[0]["NO_BL"].'</td>
				</tr>
				<tr>
					<td colspan="4">No Document</td>
					<td align="center">:</td>
					<td colspan="9">'.$result_hdr[0]["NO_DOK"].'</td>
					<td colspan="5" align="right">Date Of Document</td>
					<td align="center">:</td>
					<td colspan="7">'.date('Y-m-d',strtotime($result_hdr[0]["TGL_DOK"])).'</td>
				</tr>
				<tr>
					<td colspan="27" style="padding-top: 20px"></td>
				</tr>
				<tr>
					<td colspan="27"><strong>'.$result_cont[0]['NO_KONTAINER'].'</strong></td>
				</tr>
				<tr>
					<td colspan="27" style="padding-top: 20px"></td>
				</tr>
				<tr>
					<td colspan="6"><b>KETERANGAN</b></td>
					<td colspan="3" align="center"><b>SIZE</b></td>
					<td colspan="3" align="center"><b>JENIS</b></td>
					<td colspan="3" align="center"><b>BOX</b></td>
					<td colspan="4" align="center"><b>TARIF</b></td>
					<td colspan="2" align="center"><b>VAL</b></td>
					<td colspan="6" align="center"><b>JUMLAH</b></td>
				</tr>
				<tr>
					<td colspan="27" align="center">-----------------------------------------------------------------------------------------</td>
				</tr>
				'.$tr.'
				<tr>
					<td colspan="27" align="center">-----------------------------------------------------------------------------------------</td>
				</tr>
				<tr>
					<td colspan="27" style="padding-top: 20px"></td>
				</tr>
				<tr>
					<td colspan="14"></td>
					<td colspan="5" align="right">Administrasi</td>
					<td align="center">:</td>
					<td colspan="6" align="right">20.000,00</td>
					<td></td>
				</tr>
				<tr>
					<td colspan="13"></td>
					<td colspan="6" align="right">Dasar Pengenaan Pajak</td>
					<td align="center">:</td>
					<td colspan="6" align="right">'.number_format($Harga, 2, '.', ',').'</td>
					<td></td>
				</tr>
				<tr>
					<td colspan="14"></td>
					<td colspan="5" align="right">Jumlah PPN</td>
					<td align="center">:</td>
					<td colspan="6" align="right">'.number_format($PPN, 2, '.', ',').'</td>
					<td></td>
				</tr>
				<tr>
					<td colspan="14"></td>
					<td colspan="5" align="right">Bea Materai</td>
					<td align="center">:</td>
					<td colspan="6" align="right">'.number_format($result_hdr[0]['BIAYA_MATERAI'], 2, '.', ',').'</td>
					<td></td>
				</tr>
				<tr>
					<td colspan="14"></td>
					<td colspan="5" align="right">Jumlah Dibayar</td>
					<td align="center">:</td>
					<td colspan="6" align="right">'.number_format($TOTAL, 2, '.', ',').'</td>
					<td></td>
				</tr>
				<tr>
					<td colspan="27" style="padding-top: 20px"></td>
				</tr>
				<tr>
					<td colspan="27">Nota sebagai faktur pajak berdasarkan Peraturan Dirjen Pajak</td>
				</tr>
				<tr>
					<td colspan="27">Per - 27/PJ/2011 tanggal 19 September 2011</td>
				</tr>
				<tr>
					<td colspan="27" style="padding-top: 20px"></td>
				</tr>
				<tr>
					<td colspan="27">#'.ucwords(Terbilang($result_hdr[0]['TOTAL_JUMLAH'])).' Rupiah'.'</td>
				</tr>
				<tr>
					<td colspan="27">'.$tr2.'</td>
				</tr>
				<tr>
					<td colspan="27" style="padding-top: 20px"></td>
				</tr>
				<tr>
					<td colspan="27">Ketentuan :</td>
				</tr>
				<tr>
					<td colspan="27">1. Pengajuan keberatan hanya dapat dilakukan dalam waktu 14 hari setelah tanggal nota</td>
				</tr>
				<tr>
					<td colspan="27">2. Terhadap nota yang diajukan keberatan harus dilunasi terlebih dahulu</td>
				</tr>
				<tr>
					<td colspan="27" style="padding-top: 20px"></td>
				</tr>
				<tr>
					<td colspan="18"></td>
					<td colspan="9" align="center">Jakarta, '. date("d M Y").'</td>
				</tr>
				<tr>
					<td colspan="18"></td>
					<td colspan="9" align="center"><strong>PT. IPC TERMINAL PERIKEMAS</strong></td>
				</tr>
				<tr>
					<td colspan="18"></td>
					<td colspan="9" align="center"><strong>Common Area</strong></td>
				</tr>
				<tr>
					<td colspan="27" style="padding-top: 20px"></td>
				</tr>
				<tr>
					<td colspan="27" style="padding-top: 20px"></td>
				</tr>
				<tr>
					<td colspan="27" style="padding-top: 20px"></td>
				</tr>
				<tr>
					<td colspan="27" style="padding-top: 20px"></td>
				</tr>
				<tr>
					<td colspan="27" style="padding-top: 20px"></td>
				</tr>
				<tr>
					<td colspan="18"></td>
					<td colspan="9" align="center"><strong>____________________________</strong></td>
				</tr>
				<tr>
					<td colspan="27" style="padding-top: 20px"></td>
				</tr>
				<tr>
					<td colspan="27" style="padding-top: 20px"></td>
				</tr>
				<tr>
					<td colspan="27" align="center"><strong><i>This document is printed by BOS – PT. IPCTPK&nbsp;&nbsp;</i>'.date("d-m-Y H:i").'<span></td>
				</tr>
				<tr>
					<td colspan="27" align="center"><strong><i>Print By :&nbsp;&nbsp;</i>'.$ADMIN.'<span></td>
				</tr>
				<tr>
					<td style="color:white;">123</td>
					<td style="color:white;">123</td>
					<td style="color:white;">123</td>
					<td style="color:white;">123</td>
					<td style="color:white;">123</td>
					<td style="color:white;">123</td>
					<td style="color:white;">123</td>
					<td style="color:white;">123</td>
					<td style="color:white;">123</td>
					<td style="color:white;">123</td>
					<td style="color:white;">123</td>
					<td style="color:white;">123</td>
					<td style="color:white;">123</td>
					<td style="color:white;">123</td>
					<td style="color:white;">123</td>
					<td style="color:white;">123</td>
					<td style="color:white;">123</td>
					<td style="color:white;">123</td>
					<td style="color:white;">123</td>
					<td style="color:white;">123</td>
					<td style="color:white;">123</td>
					<td style="color:white;">123</td>
					<td style="color:white;">123</td>
					<td style="color:white;">123</td>
					<td style="color:white;">123</td>
					<td style="color:white;">123</td>
					<td style="color:white;">123</td>
				</tr>
			</table>';
	return $html;
}
