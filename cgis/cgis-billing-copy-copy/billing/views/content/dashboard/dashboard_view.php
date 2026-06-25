<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Dashboard</title>
	<script type="text/javascript" src="'.base_url().'assets/js/jquery.dataTables.js"></script>
	<link rel="stylesheet" type="text/css" href="'.base_url().'assets/css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="'.base_url().'assets/css/dataTables.bootstrap.css">
</head>
<body>
	<div class="">
	  	<?php
			date_default_timezone_set("Asia/Jakarta");

			function datediff($tgl1, $tgl2){
				$tgl1 = strtotime($tgl1);
				$tgl2 = strtotime($tgl2);
				$diff_secs = abs($tgl1 - $tgl2);
				$base_year = min(date("Y", $tgl1), date("Y", $tgl2));
				$diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
				return array( "years" => date("Y", $diff) - $base_year, "months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1, "months" => date("n", $diff) - 1, "days_total" => floor($diff_secs / (3600 * 24)), "days" => date("j", $diff) - 1, "hours_total" => floor($diff_secs / 3600), "hours" => date("G", $diff), "minutes_total" => floor($diff_secs / 60), "minutes" => (int) date("i", $diff), "seconds_total" => $diff_secs, "seconds" => (int) date("s", $diff) );
			}
			/*$tgl1 = '2017-05-29 14:39:03';
			$tgl2 = date("Y-m-d H:i:s");
			$a = datediff($tgl1, $tgl2);
			echo 'tanggal 1 = '.$tgl1; echo '<br>';
			echo 'tanggal 2 = '.$tgl2; echo '<br>';
			echo 'Selisih = '.$a['years'].' tahun '.$a['months'].' bulan '.$a['days'].' hari '.$a['hours'].' jam '.$a['minutes'].' menit '.$a['seconds'].' detik';
			$result = $a['hours'].' jam '.$a['minutes'].' menit '.$a['seconds'].' detik';*/
		?>
		<br><br>
		<div>
			<!-- <input type="checkbox" value="ALL">&nbsp;ALL&nbsp;&nbsp;&nbsp;
			<input type="checkbox" value="PU">&nbsp;PU&nbsp;&nbsp;&nbsp;
			<input type="checkbox" value="GIT">&nbsp;GIT&nbsp;&nbsp;&nbsp;
			<input type="checkbox" value="GOT">&nbsp;GOT&nbsp;&nbsp;&nbsp;
			<input type="checkbox" value="MB1">&nbsp;MB1&nbsp;&nbsp;&nbsp;
			<input type="checkbox" value="MB2">&nbsp;MB2&nbsp;&nbsp;&nbsp;
			<input type="checkbox" value="MEB1">&nbsp;MEB1&nbsp;&nbsp;&nbsp;
			<input type="checkbox" value="MEB2">&nbsp;MEB2&nbsp;&nbsp;&nbsp;
			<input type="checkbox" value="INS">&nbsp;INS&nbsp;&nbsp;&nbsp;
			<input type="checkbox" value="TI">&nbsp;TI&nbsp;&nbsp;&nbsp;
			<input type="checkbox" value="TO">&nbsp;TO&nbsp;&nbsp;&nbsp;
			<button type="submit" class="btn btn-primary btn-sm">Search</button> -->
			<form action="<?php echo site_url('/dashboard/filter'); ?>" method="post">
				<div id="wrapper">
					<input type="checkbox" name="all" id="all" /> <label for='all'>All</label>
					<input type="checkbox" name="selected[]" id="box_1" value="200" /> <label for="box_1">PU</label>
					<input type="checkbox" name="selected[]" id="box_2" value="GIT" /> <label for="box_2">GIT</label>
					<input type="checkbox" name="selected[]" id="box_3" value="GOT" /> <label for="box_3">GOT</label>
					<input type="checkbox" name="selected[]" id="box_4" value="MB1" /> <label for="box_4">MB1</label>
					<input type="checkbox" name="selected[]" id="box_5" value="MB2" /> <label for="box_1">MB2</label>
					<input type="checkbox" name="selected[]" id="box_6" value="MEB1" /> <label for="box_2">MEB1</label>
					<input type="checkbox" name="selected[]" id="box_7" value="MEB2" /> <label for="box_3">MEB2</label>
					<input type="checkbox" name="selected[]" id="box_8" value="450" /> <label for="box_4">INS</label>
					<input type="checkbox" name="selected[]" id="box_9" value="800" /> <label for="box_4">TI</label>
					<input type="checkbox" name="selected[]" id="box_10" value="900" /> <label for="box_2">TO</label>
					<input type="submit" name="cek" value="Search">
					<!-- <button type="submit" class="btn btn-primary btn-sm">Search</button> -->
				</div>
			</form>
		</div>
		<div></div><br>
		<table border="1" cellspacing="0" width="100%" id="myTable">
			<tr>
				<th>Nomor</th>
				<th>No. kontainer</th>
				<th>No. SPK</th>
				<th>CLASS</th>
				<th>NAMA KAPAL</th>
				<th>Voyage</th>
				<th>Status</th>
				<th>Size</th>
				<th>Jenis Dokumen</th>
				<th>Job</th>
				<th>TID</th>
				<th>Lokasi Awal</th>
				<th>Lokasi Akhir</th>
				<th>Waktu Insp</th>
				<th>Durasi</th>
				<th>Nama Customer</th>
				<th>Remark</th>
			</tr>
			<?php 
			$cekRows = count($dash);
			if ($cekRows > 0) {
				$no = 0;
				foreach($dash as $value){ 
					$no++;
			?>
			<tr>
				<td><?php echo $no; ?></td>
				<td><?php echo $value->NO_KONTAINER; ?></td>
				<td><?php echo $value->NO_SPK; ?></td>
				<td><?php //echo $value['NO. KONTAINER'] ?></td>
				<td><?php echo $value->VESSEL_NAME; ?></td>
				<td><?php echo $value->VOYAGE; ?></td>
				<td><?php //echo "EMPTY";//echo $value->NO. SPK; ?></td>
				<td><?php echo $value->SIZE; ?></td>
				<td><?php echo $value->DOKUMEN; ?></td>
				<td><?php echo $value->JOB; ?></td>
				<td><?php //$value->LOKASI_AWAL; ?></td>
				<td><?php echo $value->LOKASI_AWAL; ?></td>
				<td><?php echo $value->LOKASI_AKHIR; ?></td>
				<td><?php echo $value->START_INSP; ?></td>
				<td>
					<?php 
						if ($value->START_INSP != '') {
							$tgl1 = $value->START_INSP;//'2017-05-29 14:39:03';
							$tgl2 = date("Y-m-d H:i:s");
							$a = datediff($tgl1, $tgl2);
							$result = $a['days'].' hari '.$a['hours'].' jam '.$a['minutes'].' menit ';//.$a['seconds'].' detik';
							echo $result;
						}
					?>
				</td>
				<td><?php //echo $value->NO. SPK; ?></td>
				<td><?php echo $value->REMARK; ?></td>
			</tr>
			<?php 
				} //else for
			} else { //else if
				echo "<td colspan='16' align='center'><span><h3 class='text-danger'><b>DATA TIDAK DITEMUKAN</b></h3></span></td>";
			}
			?>
		</table>
		<br/>
		<?php 
			echo $this->pagination->create_links();
		?>
	  </div>
</body>
</html>
<script>
	$(document).ready(function(){
		$('input[name="all"],input[name="title"]').bind('click', function(){
			var status = $(this).is(':checked');
			$('input[type="checkbox"]').attr('checked', status);
		});
	});
	
	$(document).ready(function(){
		$('#myTable').dataTable();
	});
	
</script>