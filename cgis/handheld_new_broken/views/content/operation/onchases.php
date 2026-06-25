<?php
  echo form_open('operation/search_chases');
?>
<div class="container">
<a href="<?php echo site_url('operation/opr'); ?>">
	<H4 style="color:white;"><< MENU HANDHELD</H4>
</a>
  <br>
	<H5 style="color:white;">ON CHASSIS</H5><br>
  <div class="form_group form_material">
    <div class="col-sm-4" >
      <input style="border: 1px solid #a1a1a1;"  class="form-control" type="text" name="search_ch" placeholder=" SEARCH NO NO CONT" autofocus required>
    </div>
    <div class="col-sm-2" >
      <button type="submit" class="btn btn-primary" style="border: 1px solid #a1a1a1;">SEARCH</button>
    </div>
  </div>
</div>
<hr>





<?php if (isset($notif)): ?>
  <?php switch ($notif) {
    case 1:
    echo "<br>
    <div class= 'alert alert-primary' style='font-size:14px; font-family:sant-serif; font-weight:bold; ' >
       ON CHASSIS SUCCESS
    </div>";
      break;
    case 2:
    echo "<br>
    <div class= 'alert alert-danger' style='font-size:14px; font-family:sant-serif; font-weight:bold; ' >
        WARNING ! NO CONT NOT FOUND
    </div>";
      break;
    default:
    echo "<br>
    <div class= 'alert alert-danger' style='font-size:14px; font-family:sant-serif; font-weight:bold; ' >
       WARNING ! NO CONT NOT FOUND
    </div>";
  } ?>
<?php endif ?>
<?php
  echo form_close();
 if(isset($status)){
  if ($status==1) { ?>
      <div class="container">
      <br>
             <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                     <th style="color:white;">NO KONTAINER</th>
                     <th style="color:white;">UKURAN</th>
                     <th style="color:white;">NO TRUCK</th>
					 <th style="color:white;">LOKASI</th>
                     <th style="color:white;">PROSES</th>
                   </tr>
                  </thead>
                  <tbody>
                   <?php
                     foreach ($nilai as $nilai2) { 
					 echo form_open('operation/chases');
						 if(substr($nilai2['LOKASI'],0,3)=='CIC'){
							$lok=$nilai2['LOKASI'];
						 }else{
							$lok=$nilai2['LOKASI']."0".$nilai2['TIER']; 
						 }
					 ?>
                     <tr>
					  <td>
					  <input type="hidden" class="form-control" id="nomerspk" name="nomerspk" value="<?php echo $nilai2['NO_SPK']; ?>" readonly >
                      <input type="text" class="form-control" id="nomercont" name="nomercont" value="<?php echo $nilai2['NO_CONT']; ?>" readonly >
					  </td>
					  <td><input type="text" class="form-control" id="ukuran" name="ukuran" value="<?php echo $nilai2['UKR_CONT']; ?>" readonly ></td>					  
                      <td><input type="text" class="form-control" id="notruck" name="notruck" value="<?php echo $nilai2['NO_TRUCK']; ?>" readonly ></td>
					  <td><input type="text" class="form-control" id="lokasi" name="lokasi" value="<?php echo $lok; ?>" readonly ></td>
                      <td>
                        <button id="str" type="submit"  class="btn btn-primary">ON CHASSES</button>
                      </td>
                    </tr>
                    <?php 
					echo form_close();
					} ?>
                  </tbody>
                </table>
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
             WARNING ! NO CONT : $NOCONT NOT FOUND
          </div>";
          break;
        default:
          echo "";
          break;
      } ?>
    <?php endif ?>
    <br>
               <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
						<th style="color:white;">NO KONTAINER</th>
						<th style="color:white;">UKURAN</th>
						<th style="color:white;">NO TRUCK</th>
						<th style="color:white;">LOKASI</th>
						<th style="color:white;">PROSES</th>
                   </tr>
                  </thead>
                  <tbody>
                   <?php
                     foreach ($nilai as $nilai2) { 
					 echo form_open('operation/chases');
						 if(substr($nilai2['LOKASI'],0,3)=='CIC'){
							$lok=$nilai2['LOKASI'];
						 }else{
							$lok=$nilai2['LOKASI']."0".$nilai2['TIER']; 
						 }
					 ?>
                     <tr>
                      <td>
					  <input type="hidden" class="form-control" id="nomerspk" name="nomerspk" value="<?php echo $nilai2['NO_SPK']; ?>" readonly >
					  <input type="text" class="form-control" id="nomercont" name="nomercont" value="<?php echo $nilai2['NO_CONT']; ?>" readonly >
					  </td>
					  <td><input type="text" class="form-control" id="ukuran" name="ukuran" value="<?php echo $nilai2['UKR_CONT']; ?>" readonly ></td>
					  <td><input type="text" class="form-control" id="notruck" name="notruck" value="<?php echo $nilai2['NO_TRUCK']; ?>" readonly ></td>
                      <td><input type="text" class="form-control" id="lokasi" name="lokasi" value="<?php echo $lok; ?>" readonly ></td>
                      <td>
                        <button id="str" type="submit"  class="btn btn-primary">ON CHASSES</button>
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
