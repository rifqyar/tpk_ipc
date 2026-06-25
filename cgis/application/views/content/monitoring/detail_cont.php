<!DOCTYPE html>
<html>
<head>

</head>
<style>
      .wtd{
            width: 31%;
      }
</style>
<body>

<div class="container">
  <div class="table-responsive">
  <table class="table">
      <?php foreach ($result_cont as $key => $value) {

      ?>
	  <tr>
		<td colspan ='2' style="background-color:blue;color:#FFF"><b>BEHANDLE 1</b></td>
		<td style="background-color:blue;color:#FFF">OPERATOR</td>
      </tr>
	  <!--BEHANDLE 1-->
		<tr>
            <td  class="wtd">NO KONTAINER</td>
			<td><?php 
			if (isset($value->KONTAINER))  
			{
				echo $value->KONTAINER;
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($value->KONTAINER))  
			{
				echo strtoupper("B O S");
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>CLASS</td>
            <td>I</td>
			<td><?php 
			if (isset($value->KONTAINER))  
			{
				echo strtoupper("B O S");
			}else{
				echo strtoupper("B O S");
			}
			?></td>
		</tr>
		<tr>
            <td>KODE KAPAL</td>
            <td>
            	<?php echo $value->CALL_SIGN; ?>
            </td>
			<td><?php 
			if (isset($value->CALL_SIGN))  
			{
				echo strtoupper("B O S");
			}else{
				echo strtoupper("B O S");
			}
			?></td>
		</tr>
		<tr>
            <td>NAMA KAPAL</td>
			<td><?php 
			if (isset($value->NM_KAPAL))  
			{
				echo $value->NM_KAPAL;
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($value->CALL_SIGN))  
			{
				echo strtoupper("B O S");
			}else{
				echo strtoupper("B O S");
			}
			?></td>
		</tr>
		<tr>
            <td>VOYAGE</td>
			<td><?php 
			if (isset($value->NO_VOY))  
			{
				echo $value->NO_VOY;
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($value->CALL_SIGN))  
			{
				echo strtoupper("B O S");
			}else{
				echo strtoupper("B O S");
			}
			?></td>
		</tr>
		<tr>
            <td>STATUS</td>
            <td>
            	<?php
            		if ($value->JNS_CONT == "F") {
            		 	echo "FULL"; 
            		 } else{
            		 	echo "EMPTY"; 
            		 }
            		
            	?>
            </td>
			<td><?php 
			if (isset($value->CALL_SIGN))  
			{
				echo strtoupper("B O S");
			}else{
				echo strtoupper("B O S");
			}
			?></td>
		</tr>
		<tr>
            <td>SIZE</td>
			<td><?php 
			if (isset($value->UKR_CONT))  
			{
				echo $value->UKR_CONT;
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($value->UKR_CONT))  
			{
				echo strtoupper("B O S");
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>ISO CODE</td>
			<td><?php 
			if (isset($value->ISO_CODE))  
			{
				echo $value->ISO_CODE;
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($value->ISO_CODE))  
			{
				echo strtoupper("B O S");
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>TYPE</td>
			<td><?php 
			if (isset($value->KD_CONT_TIPE))  
			{
				echo $value->KD_CONT_TIPE;
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($value->KD_CONT_TIPE))  
			{
				echo strtoupper("B O S");
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>IMO CODE</td>
			<td><?php 
			if (isset($value->IMO))  
			{
				echo $value->IMO;
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($value->IMO))  
			{
				echo strtoupper("B O S");
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>ARRIVAL</td>
            <td>
            	<?php echo $value->TGL_TIBA; ?>
            </td>
			<td><?php 
			if (isset($value->TGL_TIBA))  
			{
				echo strtoupper("B O S");
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>STACKING</td>
            <td>
            	<?php echo $value->WK_IN; ?>
            </td>
			<td><?php 
			if (isset($value->WK_IN))  
			{
				echo strtoupper("B O S");
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>JENIS DOKUMEN</td>
			<td><?php 
			if (isset($value->NAMA))  
			{
				echo $value->NAMA;
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($value->NAMA))  
			{
				echo strtoupper("B O S");
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>NO DOKUMEN</td>
			<td><?php 
			if (isset($value->DOKUMEN))  
			{
				echo $value->DOKUMEN;
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($value->DOKUMEN))  
			{
				echo strtoupper("B O S");
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>TANGGAL DOKUMEN</td>
			<td><?php 
			if (isset($value->TANGGAL))  
			{
				echo $value->TANGGAL;
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($value->TANGGAL))  
			{
				echo strtoupper("B O S");
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>CUSTOMER NAME</td>
			<td><?php 
			if (isset($value->CONSIGNEE))  
			{
				echo $value->CONSIGNEE;
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($value->CONSIGNEE))  
			{
				echo strtoupper("B O S");
			}else{
				echo "--";
			}
			?></td>
		</tr>
	  <tr>

		<td colspan ='3' style="background-color:blue;color:#FFF"><b>REQUEST BEHANDLE 1</b></td>
      </tr>
	   <!--REQUEST BEHANDLE 1-->
		<tr>
            <td>REQUEST GATE PASS</td>
            <td><?php 
			if (isset($reqbehandle1New['WK_SEND']))  
			{
				echo $reqbehandle1New['WK_SEND'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($reqbehandle1New['WK_SEND']))  
			{
				echo strtoupper($terbitspk['NAMA']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>APPROVED GATE PASS</td>
            <td><?php 
			if (isset($reqbehandle1New['WK_FINISH']))  
			{
				echo $reqbehandle1New['WK_FINISH'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($reqbehandle1New['WK_FINISH']))  
			{
				echo strtoupper($reqbehandle1New['OPERATOR']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>NO SPK</td>
			<td><?php 
			if (isset($reqbehandle1New['NO_SPK']))  
			{
				echo $reqbehandle1New['NO_SPK'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($terbitspk['NAMA']))  
			{
				echo strtoupper($terbitspk['NAMA']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>TERBIT SPK</td>            
			<td><?php 
			if (isset($reqbehandle1New['WK_REQ']))  
			{
				echo $reqbehandle1New['WK_REQ'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($terbitspk['NAMA']))  
			{
				echo strtoupper($terbitspk['NAMA']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>GATE PASS BEHANDLE 1</td>
			<td><?php 
			if (isset($rbehandle1['GATEPASSBEHANDLE1']))  
			{
				echo $rbehandle1['GATEPASSBEHANDLE1'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($rbehandle1['NAMA']))  
			{
				echo strtoupper($rbehandle1['NAMA']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
	  <tr>
		<td colspan ='3' style="background-color:blue;color:#FFF"><b>PENARIKAN</b></td>
      </tr>
	   <!--PENARIKAN-->
		<tr>
            <td>PICK UP</td>
			<td><?php 
			if (isset($penarikan['pickup']))  
			{
				echo $penarikan['pickup'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($penarikan['oper']))  
			{
				echo strtoupper($penarikan['oper']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>TID</td>
			<td><?php 
			if (isset($penarikan['tid']))  
			{
				echo $penarikan['tid'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($penarikan['oper']))  
			{
				echo strtoupper($penarikan['oper']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>GATE IN TERMINAL</td>
			<td><?php 
			if (isset($penarikan['WK_TERMINAL_IN']))  
			{
				echo $penarikan['WK_TERMINAL_IN'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($penarikan['WK_TERMINAL_IN']))  
			{
				echo strtoupper("B O S");
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>GATE OUT TERMINAL</td>
			<td><?php 
			if (isset($penarikan['WK_TERMINAL_OUT']))  
			{
				echo $penarikan['WK_TERMINAL_OUT'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($penarikan['WK_TERMINAL_OUT']))  
			{
				echo strtoupper("B O S");
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>BEHANDLE IN</td>
			<td><?php 
			if (isset($penarikan['behandlein']))  
			{
				echo $penarikan['behandlein'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($penarikan['OPERATOR']))  
			{
				echo strtoupper($penarikan['OPERATOR']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>KONDISI KONTAINER</td>
			<td><?php 
			if (isset($penarikan['KONDISI']))  
			{
				echo $penarikan['KONDISI'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($penarikan['OPERATOR']))  
			{
				echo strtoupper($penarikan['OPERATOR']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>NO SEAL</td>
			<td><?php 
			if (isset($penarikan['NO_SEAL']))  
			{
				echo $penarikan['NO_SEAL'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($penarikan['OPERATOR']))  
			{
				echo strtoupper($penarikan['OPERATOR']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
				<tr>
            <td>ISO CODE</td>
			<td><?php 
			if (isset($penarikan['ISO_CODE']))  
			{
				echo $penarikan['ISO_CODE'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($penarikan['OPERATOR']))  
			{
				echo strtoupper($penarikan['OPERATOR']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>LOKASI</td>
			<td><?php 
			if (isset($penarikan['ROOM']))  
			{
				echo $penarikan['ROOM'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($penarikan['OPERATOR']))  
			{
				echo strtoupper($penarikan['OPERATOR']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
	  <tr>
		<td colspan ='3' style="background-color:blue;color:#FFF"><b>PEMERIKSAAN BEHANDLE 1</b></td>
      </tr>
	   <!--PEMERIKSAAN BEHANDLE 1-->
		<tr>
            <td>MARSHALLING BEHANDLE 1</td>
            <td>
				<?php echo $pemeriksaan_behandle1[0]->WK_STATUS; ?>
			</td>
			<td><?php 
			if (isset($pemeriksaan_behandle1[0]->OPERATOR))  
			{
				echo strtoupper($pemeriksaan_behandle1[0]->OPERATOR);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>LOKASI</td>
			<td><?php 
			if (isset($pemeriksaan_behandle1[0]->LOKASI_AKHIR))  
			{
				echo $pemeriksaan_behandle1[0]->LOKASI_AKHIR;
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($pemeriksaan_behandle1[0]->OPERATOR))  
			{
				echo strtoupper($pemeriksaan_behandle1[0]->OPERATOR);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>START PERIKSA</td>
			<td><?php 
			if (isset($pembehandle1['START_INSP']))  
			{
				echo $pembehandle1['START_INSP'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($pembehandle1['OPERATOR_START']))  
			{
				echo strtoupper($pembehandle1['OPERATOR_START']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>SELESAI PERIKSA</td>
			<td><?php 
			if (isset($pembehandle1['FINISH_INSP']))  
			{
				echo $pembehandle1['FINISH_INSP'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($pembehandle1['OPERATOR_FINISH']))  
			{
				echo strtoupper($pembehandle1['OPERATOR_FINISH']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>NEW SEAL NUMBER</td>
			<td><?php 
			if (isset($pembehandle1['NO_SEAL']))  
			{
				echo $pembehandle1['NO_SEAL'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($pembehandle1['OPERATOR_FINISH']))  
			{
				echo strtoupper($pembehandle1['OPERATOR_FINISH']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>MARSHALLING EX BEHANDLE 1</td>
            <td>
				<?php echo $m_exb1[0]->WK_STATUS; ?>
			</td>
			<td><?php 
			if (isset($m_exb1[0]->OPERATOR))  
			{
				echo strtoupper($m_exb1[0]->OPERATOR);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>LOKASI</td>
			<td><?php
			
			echo $m_exb1[0]->LOKASI_AKHIR."0".$m_exb1[0]->TIER_AKHIR;
			#belum dimunculin
			/*if (isset($pembehandle1['LOK']))  
			{
				echo $pembehandle1['LOK'].''.$pembehandle1['TIER'];
			}else{
				echo "--";
			}*/
			?></td>
			<td><?php 
			if (isset($m_exb1[0]->OPERATOR))  
			{
				echo strtoupper($m_exb1[0]->OPERATOR);
			}else{
				echo "--";
			}
			?></td>
		</tr>
	  <tr>
		<td colspan ='3' style="background-color:blue;color:#FFF"><b>REQUEST BEHANDLE 2</b></td>
      </tr>
	  <!--REQUEST BEHANDLE 2-->
		<tr>
            <td>JENIS DOKUMEN</td>
			<td><?php 
			if (isset($rbehandle2['JNS_DOK']))  
			{
				echo $rbehandle2['JNS_DOK'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($rbehandle2['JNS_DOK']))  
			{
				echo strtoupper($get_terbitbehandle2['NAMA']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>NO DOKUMEN</td>
			<td><?php 
			if (isset($rbehandle2['NO_DOK']))  
			{
				echo $rbehandle2['NO_DOK'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($rbehandle2['NO_DOK']))  
			{
				echo strtoupper($get_terbitbehandle2['NAMA']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>TANGGAL DOKUMEN</td>            
			<td><?php 
			if (isset($rbehandle2['TGL_DOK']))  
			{
				echo $rbehandle2['TGL_DOK'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($rbehandle2['TGL_DOK']))  
			{
				echo strtoupper($get_terbitbehandle2['NAMA']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>GATE PASS BEHANDLE 2</td>
			<td>
			<?php 
			if (isset($rbehandle2['WK_REK']))  
			{
				echo $rbehandle2['WK_REK'];
			}else{
				echo "--";
			}
			?>
			</td>
			<td><?php 
			if (isset($rbehandle2['WK_REK']))  
			{
				echo strtoupper($get_terbitbehandle2['NAMA']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
	  <tr>
		<td colspan ='3' style="background-color:blue;color:#FFF"><b>PEMERIKSAAN BEHANDLE 2</b></td>
      </tr>
	   <!--PEMERIKSAAN BEHANDLE 2-->
		<tr>
            <td>MARSHALLING BEHANDLE 2</td>
            <td>
			<?php echo $m_behandle2[0]->WK_STATUS; ?>
			</td>
			<td><?php 
			if (isset($m_behandle2[0]->OPERATOR))  
			{
				echo strtoupper($m_behandle2[0]->OPERATOR);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>LOKASI</td>
			<td><?php 
			if (isset($m_behandle2[0]->LOKASI_AKHIR))  
			{
				echo $m_behandle2[0]->LOKASI_AKHIR."0".$m_behandle2[0]->TIER_AKHIR;
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($m_behandle2[0]->OPERATOR))  
			{
				echo strtoupper($m_behandle2[0]->OPERATOR);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>START PERIKSA</td>
			<td><?php 
			if (isset($pembehandle2['START_INSP']))  
			{
				echo $pembehandle2['START_INSP'];
			}else{
				echo "-";
			}
			?></td>
			<td><?php 
			if (isset($pembehandle2['OPERATOR_FINISH']))  
			{
				echo strtoupper($pembehandle2['OPERATOR_FINISH']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>SELESAI PERIKSA</td>            
			<td><?php 
			if (isset($pembehandle2['FINISH_INSP']))  
			{
				echo $pembehandle2['FINISH_INSP'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($pembehandle2['OPERATOR_FINISH']))  
			{
				echo strtoupper($pembehandle2['OPERATOR_FINISH']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>NEW SEAL NUMBER</td>
			<td><?php 
			if (isset($pembehandle2['NO_SEAL']))  
			{
				echo $pembehandle2['NO_SEAL'];
			}else{
				echo "-";
			}
			?></td>
			<td><?php 
			if (isset($pembehandle2['OPERATOR_FINISH']))  
			{
				echo strtoupper($pembehandle2['OPERATOR_FINISH']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>MARSHALLING EX BEHANDLE 2</td>
            <td><?php 
				echo $m_exb2[0]->WK_STATUS; 
			?></td>
			<td><?php 
			if (isset($m_exb2[0]->OPERATOR))  
			{
				echo strtoupper($m_exb2[0]->OPERATOR);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>LOKASI</td>            
			<td>
			<?php 
			if (isset($m_exb2[0]->LOKASI_AKHIR))  
			{
				echo $m_exb2[0]->LOKASI_AKHIR."0".$m_exb2[0]->TIER_AKHIR;
			}else{
				echo "--";
			}
			/*if (isset($pembehandle2['LOKASI']))  
			{
				echo $pembehandle2['LOKASI'];
			}else{
				echo "--";
			}*/
			?></td>
			<td><?php 
			if (isset($m_exb2[0]->OPERATOR))  
			{
				echo strtoupper($m_exb2[0]->OPERATOR);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
			<td colspan ='3' style="background-color:blue;color:#FFF"><b>BILLING BEHANDLE 1</b></td>
		</tr>
	   <!--REQUEST BEHANDLE-->
		<tr>
            <td>JENIS DOKUMEN</td>
			<td><?php 
			if (isset($bill_behandle1['NAMA']))  
			{
				echo $bill_behandle1['NAMA'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($bill_behandle1['NAMA']))  
			{
				echo strtoupper($bill_behandle1['OPERATOR']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>NO DOKUMEN</td>
			<td><?php 
			if (isset($bill_behandle1['NO_DOK']))  
			{
				echo $bill_behandle1['NO_DOK'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($bill_behandle1['NO_DOK']))  
			{
				echo strtoupper($bill_behandle1['OPERATOR']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>TANGGAL DOKUMEN</td>
			<td><?php 
			if (isset($bill_behandle1['TGL_DOK']))  
			{
				echo $bill_behandle1['TGL_DOK'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($bill_behandle1['TGL_DOK']))  
			{
				echo strtoupper($bill_behandle1['OPERATOR']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>NO REQUEST</td>
			<td><?php 
			if (isset($bill_behandle1['ID_REQ']))  
			{
				echo $bill_behandle1['ID_REQ'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($bill_behandle1['ID_REQ']))  
			{
				echo strtoupper($bill_behandle1['OPERATOR']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>TANGGAL REQUEST</td>
			<td><?php 
			if (isset($bill_behandle1['TGL_REQ']))  
			{
				echo $bill_behandle1['TGL_REQ'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($bill_behandle1['TGL_REQ']))  
			{
				echo strtoupper($bill_behandle1['OPERATOR']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>CUSTOMER NAME</td>
			<td><?php 
			if (isset($bill_behandle1['NAMA_CUST']))  
			{
				echo $bill_behandle1['NAMA_CUST'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($bill_behandle1['NAMA_CUST']))  
			{
				echo strtoupper($bill_behandle1['OPERATOR']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
			<td colspan ='3' style="background-color:blue;color:#FFF"><b>BILLING BEHANDLE 2</b></td>
		</tr>
	   <!--REQUEST BEHANDLE 2-->
		<tr>
            <td>JENIS DOKUMEN</td>
			<td><?php  //echo $bill_behandle2['JNS_DOK'];
			if (isset($bill_behandle2['JNS_DOK']))  
			{
				echo $bill_behandle2['JNS_DOK'];
			}else{
				echo "-";
			}
			?></td>
			<td><?php 
			if (isset($bill_behandle2['JNS_DOK']))  
			{
				echo strtoupper($bill_behandle2['OPERATOR']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>NO DOKUMEN</td>
			<td><?php 
			if (isset($bill_behandle2['NO_DOK']))  
			{
				echo $bill_behandle2['NO_DOK'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($bill_behandle2['NO_DOK']))  
			{
				echo strtoupper($bill_behandle2['OPERATOR']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>TANGGAL DOKUMEN</td>
			<td><?php 
			if (isset($bill_behandle2['TGL_DOK']))  
			{
				echo $bill_behandle2['TGL_DOK'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($bill_behandle2['TGL_DOK']))  
			{
				echo strtoupper($bill_behandle2['OPERATOR']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>NO REQUEST</td>
			<td><?php 
			if (isset($bill_behandle2['ID_REQ']))  
			{
				echo $bill_behandle2['ID_REQ'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($bill_behandle2['ID_REQ']))  
			{
				echo strtoupper($bill_behandle2['OPERATOR']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>TANGGAL REQUEST</td>
			<td><?php 
			if (isset($bill_behandle2['TGL_REQ']))  
			{
				echo $bill_behandle2['TGL_REQ'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($bill_behandle2['TGL_REQ']))  
			{
				echo strtoupper($bill_behandle2['OPERATOR']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>CUSTOMER NAME</td>
			<td><?php 
			if (isset($bill_behandle2['NAMA_CUST']))  
			{
				echo $bill_behandle2['NAMA_CUST'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($bill_behandle2['NAMA_CUST']))  
			{
				echo strtoupper($bill_behandle2['OPERATOR']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
			<td colspan ='3' style="background-color:blue;color:#FFF"><b>REQUEST BILLING DELIVERY</b></td>
		</tr>
	   <!--REQUEST DELIVERY-->
		<tr>
            <td>JENIS DOKUMEN</td>
			<td><?php 
			if (isset($reqdelivery['JNS_DOK']))  
			{
				echo $reqdelivery['JNS_DOK'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($reqdelivery['JNS_DOK']))  
			{
				echo strtoupper($reqdelivery['OPERATOR']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>NO DOKUMEN</td>
			<td><?php 
			if (isset($reqdelivery['NO_DOK']))  
			{
				echo $reqdelivery['NO_DOK'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($reqdelivery['NO_DOK']))  
			{
				echo strtoupper($reqdelivery['OPERATOR']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>TANGGAL DOKUMEN</td>
			<td><?php 
			if (isset($reqdelivery['TGL_DOK']))  
			{
				echo $reqdelivery['TGL_DOK'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($reqdelivery['TGL_DOK']))  
			{
				echo strtoupper($reqdelivery['OPERATOR']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>NO REQUEST</td>
			<td><?php 
			if (isset($reqdelivery['ID_REQ']))  
			{
				echo $reqdelivery['ID_REQ'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($reqdelivery['ID_REQ']))  
			{
				echo strtoupper($reqdelivery['OPERATOR']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>TANGGAL REQUEST</td>
			<td><?php 
			if (isset($reqdelivery['TGL_REQ']))  
			{
				echo $reqdelivery['TGL_REQ'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($reqdelivery['TGL_REQ']))  
			{
				echo strtoupper($reqdelivery['OPERATOR']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>PAID THROUGH</td>            
			<td><?php 
			if (isset($reqdelivery['EXPIRED']))  
			{
				echo $reqdelivery['EXPIRED'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($reqdelivery['EXPIRED']))  
			{
				echo strtoupper($reqdelivery['OPERATOR']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>CUSTOMER NAME</td>
			<td><?php 
			if (isset($reqdelivery['NAMA_CUST']))  
			{
				echo $reqdelivery['NAMA_CUST'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($reqdelivery['NAMA_CUST']))  
			{
				echo strtoupper($reqdelivery['OPERATOR']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
			<td colspan ='3' style="background-color:blue;color:#FFF"><b>REQUEST BILLING DELIVERY EXTENTION</b></td>
		</tr>
		<!--REQUEST DELIVERY EX 1-->
		<tr>
            <td>NO REQUEST</td>
			<td><?php 
			if (isset($delivext['ID_REQ']))  
			{
				echo $delivext['ID_REQ'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($delivext['ID_REQ']))  
			{
				echo strtoupper($delivext['OPERATOR']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>TANGGAL REQUEST</td>
			<td><?php 
			if (isset($delivext['TGL_REQ']))  
			{
				echo $delivext['TGL_REQ'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($delivext['TGL_REQ']))  
			{
				echo strtoupper($delivext['OPERATOR']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>PAID THROUGH</td>
			<td><?php 
			if (isset($delivext['EXPIRED']))  
			{
				echo $delivext['EXPIRED'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($delivext['EXPIRED']))  
			{
				echo strtoupper($delivext['OPERATOR']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
	  <tr>
		<td colspan ='3' style="background-color:blue;color:#FFF"><b>DELIVERY</b></td>
      </tr>
	   <!-- DELIVERY-->
		<tr>
            <td>TRUCK IN + CETAK CMS</td>
            <td><?php 
			if (isset($delivery['WK_TRUCKIN']))  
			{
				echo $delivery['WK_TRUCKIN'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($delivery['OPERATOR_T']))  
			{
				echo strtoupper($delivery['OPERATOR_T']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>ON CHASSIS</td>
			<td><?php 
			if (isset($delivery['WK_CHASSIS']))  
			{
				echo $delivery['WK_CHASSIS'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($delivery['OPERATOR_O']))  
			{
				echo strtoupper($delivery['OPERATOR_O']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>NO SEAL</td>
			<td><?php 
			if (isset($delivery['NO_SEAL']))  
			{
				echo $delivery['NO_SEAL'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($delivery['OPERATOR_I']))  
			{
				echo strtoupper($delivery['OPERATOR_I']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>KONDISI KONTAINER</td>
			<td><?php 
			if (isset($delivery['KONDISI']))  
			{
				echo $delivery['KONDISI'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($delivery['OPERATOR_I']))  
			{
				echo strtoupper($delivery['OPERATOR_I']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>INSPECTION OUT</td>
			<td><?php 
			if (isset($delivery['WK_INSPECT']))  
			{
				echo $delivery['WK_INSPECT'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($delivery['OPERATOR_I']))  
			{
				echo strtoupper($delivery['OPERATOR_I']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>TRUCK OUT + CETAK EIR</td>
			<td><?php 
			if (isset($delivery['WK_GATEOUT']))  
			{
				echo $delivery['WK_GATEOUT'];
			}else{
				echo "--";
			}
			?></td>
			<td><?php 
			if (isset($delivery['OPERATOR_G']))  
			{
				echo strtoupper($delivery['OPERATOR_G']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>KETERANGAN</td>
			<td><?php 
			if (isset($delivery['WK_GATEOUT']))  
			{
				echo "GATEPASS";
			}else{
				echo "PROSES BEHANDLE";
			}
			?></td>
			<td><?php 
			if (isset($delivery['OPERATOR_G']))  
			{
				echo strtoupper($delivery['OPERATOR_G']);
			}else{
				echo "--";
			}
			?></td>
		</tr>
		
      <?php } ?>
    </tbody>
  </table>
  </div>
</div>

</body>
</html>
