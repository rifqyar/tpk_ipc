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

	if ($result_hdr[0]["NO_NOTA_DELIVERY"] == NULL) {
		$tr1 = "PRANOTA DELIVERY";
	} else {
		$tr1 = "NOTA DELIVERY";
	}

	if ($result_hdr[0]["NO_NOTA_DELIVERY"] == NULL) {
		$tr2 = "#Perhitungan ini hanya berlaku jika pembayaran dilakukan pada hari ini";
	} else {
		$tr2 = "";
	}

	$no=1;
	for ($i=0; $i < count($result); $i++) { 
		$tr .= ' <tr>
					<td colspan="5" align="left">'.$result[$i]['TITLE'].'</td>
					<td colspan="4" align="center">'.$result[$i]['START'].'</td>
					<td colspan="4" align="center">'.$result[$i]['END'].'</td>
					<td align="center">'.$result[$i]['SIZE'].'</td>
					<td align="center">'.$result[$i]['TYPE'].'</td>
					<td align="center">'.$result[$i]['STATUS'].'</td>
					<td align="center">'.$result[$i]['BOX'].'</td>
					<td align="center">'.$result[$i]['HARI'].'</td>
					<td colspan="4" align="center">'.number_format($result[$i]['TARIF'], 2, '.', ',').'</td>
					<td align="center">IDR</td>
					<td colspan="5" align="right">'.number_format($result[$i]['JUMLAH'], 2, '.', ',').'</td>
				</tr>';
	}

$ADMIN=$title;
	$html = '<table border="0" width="100%" cellpadding="0" cellspacing="0"  align="left">
				<tr>
					<td rowspan="3" colspan="4"><img src="assets/images/ipc_logo.png" width="100px" style="float: left;"></td>
					<td colspan="23"><strong>PT. IPC TERMINAL PETIKEMAS</strong></td>
				</tr>
				<tr>
					<td colspan="3">Alamat</td>
					<td align="center">:</td>
					<td colspan="19">Jln. Pasoso No.1 Tanjung Priok</td>
				</tr>
				<tr>
					<td colspan="3">N.P.W.P</td>
					<td align="center">:</td>
					<td colspan="19">03.276.307.0-093.000</td>
				</tr>
				<tr>
					<td colspan="27" style="padding-top: 20px"></td>
				</tr>
				<tr>
					<td colspan="15"></td>
					<td colspan="4" align="right">No. Nota</td>
					<td align="center">:</td>
					<td colspan="7">'.$result_hdr[0]["NO_NOTA_DELIVERY"].'</td>
				</tr>
				<tr>
					<td colspan="15"></td>
					<td colspan="4" align="right">No. Request</td>
					<td align="center">:</td>
					<td colspan="7">'.$result_hdr[0]["ID_REQ"].'</td>
				</tr>
				<tr>
					<td colspan="15"></td>
					<td colspan="4" align="right">Date Of Request</td>
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
					<td colspan="5">No Document</td>
					<td align="center">:</td>
					<td colspan="8">'.$result_hdr[0]["NO_DOK"].'</td>
					<td colspan="5" align="right">Date Of Stacking</td>
					<td align="center">:</td>
					<td colspan="7">'.$result_hdr[0]["TGL_STACK"].'</td>
				</tr>
				<tr>
					<td colspan="5">Date Of Document</td>
					<td align="center">:</td>
					<td colspan="8">'.date('Y-m-d',strtotime($result_hdr[0]["TGL_DOK"])).'</td>
					<td colspan="5" align="right">Date Of Delivery</td>
					<td align="center">:</td>
					<td colspan="7">'.$result_hdr[0]["EXPIRED"].'</td>
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
					<td colspan="5"><b>KETERANGAN</b></td>
					<td colspan="4" align="center"><b>START</b></td>
					<td colspan="4" align="center"><b>END</b></td>
					<td><b>SIZE</b></td>
					<td align="center"><b>TYPE</b></td>
					<td align="center"><b>STATUS</b></td>
					<td align="center"><b>BOX</b></td>
					<td align="center"><b>HARI</b></td>
					<td colspan="4" align="center"><b>TARIF</b></td>
					<td align="center"><b>VAL</b></td>
					<td colspan="5" align="center"><b>JUMLAH</b></td>
				</tr>
				<tr>
					<td colspan="27" align="center">-----------------------------------------------------------------------------------------------</td>
				</tr>
				'.$tr.'
				<tr>
					<td colspan="27" align="center">-----------------------------------------------------------------------------------------------</td>
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
					<td colspan="14"></td>
					<td colspan="5" align="right">Dasar Pengenaan Pajak</td>
					<td align="center">:</td>
					<td colspan="6" align="right">'.number_format($result_hdr[0]['SUBTOTAL'], 2, '.', ',').'</td>
					<td></td>
				</tr>
				<tr>
					<td colspan="14"></td>
					<td colspan="5" align="right">Jumlah PPN</td>
					<td align="center">:</td>
					<td colspan="6" align="right">'.number_format($result_hdr[0]['PPN'], 2, '.', ',').'</td>
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
					<td colspan="6" align="right">'.number_format($result_hdr[0]['TOTAL'], 2, '.', ',').'</td>
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
					<td colspan="27">#'.ucwords(Terbilang($result_hdr[0]['TOTAL'])).' Rupiah'.'</td>
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
					<td colspan="9" align="center"><strong>IPC Terminal Petikemas</strong></td>
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
					<td colspan="27" align="center"><strong><i>This document is printed by BOS – IPCTPK&nbsp;&nbsp;</i>'.date("d-m-Y H:i").'<span></td>
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
