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
	  <tr>
		<td colspan ='2' style="background-color:blue;color:#FFF"><b>PERGERAKAN JOIN INSPECTION</b></td>
      </tr>
	  <!--BEHANDLE 1-->
		<tr>
            <td  class="wtd">NO KONTAINER</td>
			<td><?php 
			if (isset($arrdata['NO_CONT']))  
			{
				echo $arrdata['NO_CONT'];
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>SIZE</td>
			<td><?php 
			if (isset($arrdata['UKR_CONT']))  
			{
				echo $arrdata['UKR_CONT'];
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>JENIS DOKUMEN</td>
			<td>JOIN INSPECTION</td>
		</tr>
		<tr>
            <td>NO AJU</td>
			<td><?php 
			if (isset($arrdata['LNSW_NOAJU']))  
			{
				echo $arrdata['LNSW_NOAJU'];
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>TANGGAL AJU</td>
			<td><?php 
			if (isset($arrdata['LNSW_TGLAJU']))  
			{
				echo $arrdata['LNSW_TGLAJU'];
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>JENIS DOKUMEN</td>
			<td>KARANTINA</td>
		</tr>
		<tr>
            <td>NO DOKUMEN</td>
			<td><?php 
			if (isset($arrdata['NO_RESPON']))  
			{
				echo $arrdata['NO_RESPON'];
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>TANGGAL DOKUMEN</td>
			<td><?php 
			if (isset($arrdata['TG_RESPON']))  
			{
				echo $arrdata['TG_RESPON'];
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>JENIS DOKUMEN</td>
			<td>BEA CUKAI</td>
		</tr>
		<tr>
            <td>NO DOKUMEN</td>
			<td><?php 
			if (isset($arrdata['NO_DAFTAR_PABEAN']))  
			{
				echo $arrdata['NO_DAFTAR_PABEAN'];
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>TANGGAL DOKUMEN</td>
			<td><?php 
			if (isset($arrdata['TGL_DAFTAR_PABEAN']))  
			{
				echo $arrdata['TGL_DAFTAR_PABEAN'];
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>CUSTOMER NAME</td>
			<td><?php 
			if (isset($arrdata['NAMA_CUST']))  
			{
				echo $arrdata['NAMA_CUST'];
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>REQUEST GATEPASS</td>
			<td><?php 
			if (isset($arrdata['WK_REK']))  
			{
				echo $arrdata['WK_REK'];
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>WAKTU RESPON</td>
			<td><?php 
			if (isset($arrdata['WK_RESPON']))  
			{
				echo $arrdata['WK_RESPON'];
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>CATATAN</td>
			<td><?php 
			if (isset($arrdata['NOTE']))  
			{
				echo $arrdata['NOTE'];
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>WAKTU SIAP PERIKSA</td>
			<td><?php 
			if (isset($arrdata['WK_STATUS']))  
			{
				echo $arrdata['WK_STATUS'];
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>WAKTU START PERIKSA</td>
			<td><?php 
			if (isset($arrdata['START_INSP']))  
			{
				echo $arrdata['START_INSP'];
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>WAKTU SELESAI PERIKSA</td>
			<td><?php 
			if (isset($arrdata['FINISH_INSP']))  
			{
				echo $arrdata['FINISH_INSP'];
			}else{
				echo "--";
			}
			?></td>
		</tr>
    </tbody>
  </table>
  </div>
</div>

</body>
</html>
