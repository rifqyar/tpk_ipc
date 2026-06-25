<?php
  echo form_open('operation/src');
?>
<div class="container">
<a href="<?php echo site_url('operation/opr'); ?>">
	<H4 style="color:white;"><< MENU HANDHELD</H4>
</a>
  <br>
	<H5 style="color:white;">MARSHALLING</H5><br>
  <div class="form_group form_material">
    <div class="col-sm-4" >
      <input style="border-radius:10px; border: 2px solid #a1a1a1;"  class="form-control" type="text" name="search_js" placeholder=" SEARCH NO JOB SLIP" autofocus required>
    </div>
    <div class="col-sm-2" >
      <button type="submit" class="btn btn-primary" style="border-radius:10px; border: 2px solid #a1a1a1;">Search</button>
    </div>
  </div>
</div>

<?php if (isset($notif)): ?>
  <?php switch ($notif) {
		case 1:
    echo "<br>
    <div class= 'alert alert-primary' style='font-size:14px; font-family:sant-serif; font-weight:bold; ' >
       SUCCESS MARSHALLING NO CONT : $nomerkontainer TO $lokasikontainer 
    </div>";
      break;
	   case 3:
    echo "<br>
    <div class= 'alert alert-danger' style='font-size:14px; font-family:sant-serif; font-weight:bold; ' >
       LOKASI TIDAK ADA DALAM DENAH
    </div>";
      break;
	    case 4:
    echo "<br>
    <div class= 'alert alert-danger' style='font-size:14px; font-family:sant-serif; font-weight:bold; ' >
       LOKASI SUDAH DIGUNAKAN OLEH KONTAINER : $nokont
    </div>";
      break;
	    case 5:
    echo "<br>
    <div class= 'alert alert-danger' style='font-size:14px; font-family:sant-serif; font-weight:bold; ' >
       HARAP MEMINDAHKAN KONTAINER DIATASNYA TERLEBIH DAHULU
    </div>";
      break;  
    default:
    echo "<br>
    <div class= 'alert alert-danger' style='font-size:14px; font-family:sant-serif; font-weight:bold; ' >
       NO JOB SLIP NOT FOUND
    </div>";
  } ?>
<?php endif ?>
<?php
  echo form_close();
  
if(isset($status)){
  if ($status==1) { ?>
      <div class="container">
              <div class="row">
                  <div class="form-group form-material"><br><br>
                     <table class="table" >
                       <tr>
                         <th style="width:50px"><H6 style="color:white;">NO JOB SLIP</H6></th>
                         <th style="width:200px"><H6 style="color:white;">NO KONTAINER</H6></th>
						 <th style="width:50px"><H6 style="color:white;">UKURAN</H6></th>
                         <th style="width:200px"><H6 style="color:white;">LOKASI AWAL</H6></th>
                         <th style="width:200px"><H6 style="color:white;">LOKASI AKHIR</H6></th>
                         <th style="width:50px"><H6 style="color:white;">PROSES</H6></th>
                       </tr>
                       <?php
                       for ($i=0; $i<count($nilai); $i++){ 
					   echo form_open('operation/marshalling');
					   if(substr($nilai[$i]['LOKASI_AWAL'],0,3)=='CIC'){
							$lok=$nilai[$i]['LOKASI_AWAL']."0".$nilai[$i]['TIER_AWAL']; 
						}else{
							$lok=$nilai[$i]['LOKASI_AWAL']."0".$nilai[$i]['TIER_AWAL']; 
						}
						if(substr($nilai[$i]['LOKASI_AKHIR'],0,3)=='CIC'){
							$lok2=$nilai[$i]['LOKASI_AKHIR']."0".$nilai[$i]['TIER_AKHIR']; 
						}else{
							$lok2=$nilai[$i]['LOKASI_AKHIR']."0".$nilai[$i]['TIER_AKHIR']; 
						}
					   ?>
                       <tr>
                        <td><H6 style="background-color:white;"><input type="text" size="3" class="form-control" id="jobs" name="jobs" value="<?php echo $nilai[$i]['ID_JOB_SLIP']; ?>" readonly ></H6></td>
                        <td><H6 style="background-color:white;"><input type="text" size="12" class="form-control" id="nocont" name="nocont" value="<?php echo $nilai[$i]['NO_CONT']; ?>" readonly ></H6></td>
						<td><H6 style="background-color:white;"><input type="text" size="12" class="form-control" id="ukrcont" name="ukrcont" value="<?php echo $nilai[$i]['UKR_CONT']; ?>" readonly ></H6></td>
                        <td><H6 style="background-color:white;"><input type="text" size="8" class="form-control" id="lokaw" name="lokaw" value="<?php echo $lok; ?>" readonly ></H6></td>
                        <td><H6 style="background-color:white;"><input type="text" size="8" class="form-control" id="lokak" name="lokak" value="<?php echo $lok2; ?>" ></H6></td>
                        <td><H6 style="color:white;">
                          <button id="str" type="submit" class="btn btn-primary"><b style="font-size:50%">SUBMIT</b></button></H6>
                        </td>
                      </tr>
                       <?php
						echo form_close();
					   } ?>
                    </table>
                 </div>
              </div>
        </div>
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
					<thead>
						<tr>
                         <th style="width:50px"><H6 style="color:white;">NO JOB SLIP</H6></th>
                         <th style="width:200px"><H6 style="color:white;">NO KONTAINER</H6></th>
						 <th style="width:50px"><H6 style="color:white;">UKURAN</H6></th>
                         <th style="width:200px"><H6 style="color:white;">LOKASI AWAL</H6></th>
                         <th style="width:200px"><H6 style="color:white;">LOKASI AKHIR</H6></th>
                         <th style="width:50px"><H6 style="color:white;">PROSES</H6></th>
                       </tr>
					</thead>
					<tbody>
                       <?php
                       for ($i=0; $i<count($nilai); $i++){ 
					   echo form_open('operation/marshalling');
						if(substr($nilai[$i]['LOKASI_AWAL'],0,3)=='CIC'){
							$lok=$nilai[$i]['LOKASI_AWAL']."0".$nilai[$i]['TIER_AWAL']; 
						}else{
							$lok=$nilai[$i]['LOKASI_AWAL']."0".$nilai[$i]['TIER_AWAL']; 
						}
						if(substr($nilai[$i]['LOKASI_AKHIR'],0,3)=='CIC'){
							$lok2=$nilai[$i]['LOKASI_AKHIR']."0".$nilai[$i]['TIER_AKHIR']; 
						}else{
							$lok2=$nilai[$i]['LOKASI_AKHIR']."0".$nilai[$i]['TIER_AKHIR']; 
						}
					   ?>
                       <tr>
                        <td><H6 style="background-color:white;"><input type="text" size="3" class="form-control" id="jobs" name="jobs" value="<?php echo $nilai[$i]['ID_JOB_SLIP']; ?>" readonly ></H6></td>
                        <td><H6 style="background-color:white;"><input type="text" size="12" class="form-control" id="nocont" name="nocont" value="<?php echo $nilai[$i]['NO_CONT']; ?>" readonly ></H6></td>
						<td><H6 style="background-color:white;"><input type="text" size="12" class="form-control" id="ukrcont" name="ukrcont" value="<?php echo $nilai[$i]['UKR_CONT']; ?>" readonly ></H6></td>
                        <td><H6 style="background-color:white;"><input type="text" size="8" class="form-control" id="lokaw" name="lokaw" value="<?php echo $lok; ?>" readonly ></H6></td>
                        <td><H6 style="background-color:white;"><input type="text" size="8" class="form-control" id="lokak" name="lokak" value="<?php echo $lok2; ?>" ></H6></td>
                        <td><H6 style="color:white;">
                          <button id="str" type="submit" class="btn btn-primary"><b style="font-size:50%">SUBMIT</b></button></H6>
                        </td>
                      </tr>
					   <?php 
					   echo form_close();
					   } ?>
					</tbody>
                 </table>
              </div>
     </div>
<!-- tutup else -->
<?php } 

?>
