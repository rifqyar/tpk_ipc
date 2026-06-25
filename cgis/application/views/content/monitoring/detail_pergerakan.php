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
		<td colspan ='2' style="background-color:blue;color:#FFF"><b>PERGERAKAN</b></td>
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
			<td><?php 
			if (isset($arrdata['JNS_DOK']))  
			{
				echo $arrdata['JNS_DOK'];
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>NO DOKUMEN</td>
			<td><?php 
			if (isset($arrdata['NO_DOK']))  
			{
				echo $arrdata['NO_DOK'];
			}else{
				echo "--";
			}
			?></td>
		</tr>
		<tr>
            <td>TANGGAL DOKUMEN</td>
			<td><?php 
			if (isset($arrdata['TGL_DOK']))  
			{
				echo $arrdata['TGL_DOK'];
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
            <td>WAKTU PPK</td>
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
