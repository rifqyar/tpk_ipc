<?php
  echo form_open('operation/srccic');
?>
<div class="container">
  <div class="form_group form_material">
    <div class="col-sm-4" >
      <input style="border-radius:10px; border: 2px solid #a1a1a1;"  class="form-control" type="text" name="search_js" placeholder=" SEARCH NO JOB SLIP" autofocus required>
    </div>
    <div class="col-sm-3" >
      <button type="submit" class="btn btn-primary" style="border-radius:10px; border: 2px solid #a1a1a1;">Search</button>
	  <a href="<?php echo site_url('operation/marshallingcic') ?>" class="btn btn-danger" style="border-radius:10px; border: 2px solid #a1a1a1;">Refresh</a>
    </div>
  </div>
</div>


<?php if (isset($notif)): ?>
	<?php switch ($notif) {
		case 1:
			echo"<br>
				<div class= 'alert alert-primary' style='font-size:14px; font-family:sant-serif; font-weight:bold; ' >
				SUCCESS MARSHALLING NO CONT : $nomerkontainer TO $lokasikontainer 
				</div>";
			break;
		case 3:
			echo"<br>
				<div class= 'alert alert-danger' style='font-size:14px; font-family:sant-serif; font-weight:bold; ' >
				LOKASI TIDAK TERDAFTAR PADA LAPANGAN
				</div>";
		break;
		case 4:
			echo"<br>
				<div class= 'alert alert-danger' style='font-size:14px; font-family:sant-serif; font-weight:bold; ' >
				LOKASI SUDAH DIGUNAKAN OLEH KONTAINER : $nokont
				</div>";
		break;
		default:
			echo"<br>
				<div class= 'alert alert-danger' style='font-size:14px; font-family:sant-serif; font-weight:bold; ' >
				NO JOB SLIP NOT FOUND
				</div>";
	} ?>
<?php endif ?>
<?php
	echo form_close();
	if(isset($status)){ 
		if ($status==1) { ?>
			<div class="form-group form-material">
				<table class="table col-xs-6"><BR>
					<tr>
						<th>NO</th>
						<th>NO JOB SLIP</th>
						<th>NO KONTAINER</th>
						<th>UKURAN</th>
						<th>LOKASI AWAL</th>
						<th>LOKASI AKHIR</th>
						<th>JOB</th>
						<th>RESPON</th>
						<th>PROSES</th>
					</tr>
					<?php
						$no=0;
						foreach ($nilai as $nilai2): 
							echo form_open('operation/marshallingcic');
							if(substr($nilai2['LOKASI_AWAL'],0,3)=='CIC'){
								$lok=$nilai2['LOKASI_AWAL']."0".$nilai2['TIER_AWAL']; 
							}else{
								$lok=$nilai2['LOKASI_AWAL']."0".$nilai2['TIER_AWAL']; 
							}
							if(substr($nilai2['LOKASI_AKHIR'],0,3)=='CIC'){
								$lok2=$nilai2['LOKASI_AKHIR']."0".$nilai2['TIER_AKHIR']; 
							}else{
								$lok2=$nilai2['LOKASI_AKHIR']."0".$nilai2['TIER_AKHIR']; 
							}
							if($nilai2['RESPON']=='NULL' || $nilai2['RESPON']==''){
								$RESPON = "NO RESPON";
							}else{
								$RESPON = $nilai2['RESPON'];
							}
						$no++;
					?>
					<tr>
						<td><input type="text" class="form-control" id="no" name="no" value="<?php echo $no; ?>" readonly ></td>
						<td><input type="text" class="form-control" id="jobs" name="jobs" value="<?php echo $nilai2['ID_JOB_SLIP']; ?>" readonly ></td>
						<td><input type="text" class="form-control" id="nocont" name="nocont" value="<?php echo $nilai2['NO_CONT']; ?>" readonly ></td>
						<td><input type="text" class="form-control" id="ukrcont" name="ukrcont" value="<?php echo $nilai2['UKR_CONT']; ?>" readonly ></td>
						<td><input type="text" class="form-control" id="lokaw" name="lokaw" value="<?php echo $lok; ?>" readonly ></td>
						<td><input type="text" class="form-control" id="lokak" name="lokak" value="<?php echo $lok2; ?>" ></td>
						<td><input type="text" class="form-control" id="job" name="job" value="<?php echo $nilai2['JENIS']; ?>" readonly ></td>
						<td><input type="text" class="form-control" id="respon" name="respon" value="<?php echo $RESPON; ?>" readonly ></td>
						<td>
							<button id="str" type="submit"  class="btn btn-danger">SUBMIT</button>
						</td>
					</tr>
					<?php 
						echo form_close();
						endforeach; 
					?>
				</table>
			</div>
		<?php }
}else { ?>
<br>
	<div class="container-fluid">
<?php if (isset($kode)): ?>
	<?php switch ($kode) {
		case 1:
			echo "<br>
				<div class= 'alert alert-danger' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
				WARNING ! NO JOB SLIP : $jobs NOT FOUND
				</div>";
			break;
		default:
			echo "";
		break;
	} ?>
<?php endif ?>
		<div class="form-group form-material">
			<table class="table col-xs-6">
				<tr>
					<th>NO</th>
					<th>NO JOB SLIP</th>
					<th>NO KONTAINER</th>
					<th>UKURAN</th>
					<th>LOKASI AWAL</th>
					<th>LOKASI AKHIR</th>
					<th>JOB</th>
					<th>RESPON</th>
					<th>PROSES</th>
				</tr>
				<?php
					$no=0;
					foreach ($nilai as $nilai2): 
						echo form_open('operation/marshallingcic');
						if(substr($nilai2['LOKASI_AWAL'],0,3)=='CIC'){
							$lok=$nilai2['LOKASI_AWAL']."0".$nilai2['TIER_AWAL']; 
						}else{
							$lok=$nilai2['LOKASI_AWAL']."0".$nilai2['TIER_AWAL']; 
						}
						if(substr($nilai2['LOKASI_AKHIR'],0,3)=='CIC'){
							$lok2=trim($nilai2['LOKASI_AKHIR'])."0".$nilai2['TIER_AKHIR']; 
						}else{
							$lok2=trim($nilai2['LOKASI_AKHIR'])."0".$nilai2['TIER_AKHIR']; 
						}
						if($nilai2['RESPON']=='NULL' || $nilai2['RESPON']==''){
							$RESPON = "NO RESPON";
						}else{
							$RESPON = $nilai2['RESPON'];
						}
					$no++;
				?>
				<tr>
					<td><input type="text" class="form-control" id="no" name="no" value="<?php echo $no; ?>" readonly ></td>
					<td><input type="text" class="form-control" id="jobs" name="jobs" value="<?php echo $nilai2['ID_JOB_SLIP']; ?>" readonly ></td>
					<td><input type="text" class="form-control" id="nocont" name="nocont" value="<?php echo $nilai2['NO_CONT']; ?>" readonly ></td>
					<td><input type="text" class="form-control" id="ukrcont" name="ukrcont" value="<?php echo $nilai2['UKR_CONT']; ?>" readonly ></td>
					<td><input type="text" class="form-control" id="lokaw" name="lokaw" value="<?php echo $lok; ?>" readonly ></td>
					<td><input type="text" class="form-control" id="lokak" name="lokak" value="<?php echo $lok2; ?>" ></td>
					<td><input type="text" class="form-control" id="job" name="job" value="<?php echo $nilai2['JENIS']; ?>" readonly ></td>
					<td><input type="text" class="form-control" id="respon" name="respon" value="<?php echo $RESPON; ?>" readonly ></td>
					<td> 
						<button id="str" type="submit" style="border-radius:10px; border: 2px solid #a1a1a1;" class="btn btn-danger">SUBMIT</button>
					</td>
				</tr>
				<?php 
					echo form_close();
					endforeach; 
				?>
			</table>
		</div>
	</div>
<!-- tutup else -->
<?php }

?>
