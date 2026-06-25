<?php
  echo form_open('operation/search_behandle');
?>
<div class="container">
<a href="<?php echo site_url('operation/opr'); ?>">
	<H4 style="color:white;"><< MENU HANDHELD</H4>
</a>
  <br>
	<H5 style="color:white;">BEHANDLE IN</H5><br>
  <div class="form_group form_material">
    <div class="col-sm-3 col-md-3"  >
      <input style=" border: 1px solid #a1a1a1;"  class="form-control" type="text" name="search_cont" placeholder=" SEARCH NO CONT" autofocus required>
    </div>
    <div class="col-sm-1 col-md-1" >
      <button type="submit" class="btn btn-primary" style="border: 1px solid #a1a1a1;">SEARCH</button>
    </div>
  </div>
</div>
<hr>
<?php
  echo form_close();
?>

<div class="container">
      <?php if (isset($notif)): ?>
        <?php switch ($notif) {
          case 1:
           echo "
           <br>
           <div class= 'alert alert-primary' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
              NO CONT : $NOCONT SUCCESS BEHANDLE IN
           </div>";
           break;
        case 2:
           echo "
           <br>
           <div class= 'alert alert-danger' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
              NO CONT : $NOCONT NOT FOUND
           </div>";
           break;
        case 3:
           echo "
           <br>
           <div class= 'alert alert-danger' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
              NO CONT : $NOCONT NOT FOUND
           </div>";
           break;
        case 4:
          echo "<br>
          <div class= 'alert alert-danger' style='font-size:14px; font-family:sant-serif; font-weight:bold; ' >
             LOKASI SUDAH DIGUNAKAN
          </div>";
            break;
        case 5:
          echo "<br>
          <div class= 'alert alert-danger' style='font-size:14px; font-family:sant-serif; font-weight:bold; ' >
             NO TIER : $NOTIER TIDAK TERDAFTAR.
          </div>";
            break;
        case 6:
          echo "<br>
          <div class= 'alert alert-danger' style='font-size:14px; font-family:sant-serif; font-weight:bold; ' >
             GATEPASS BEHANDLE TIDAK DITEMUKAN
          </div>";
            break;
        case 7:
          echo "<br>
          <div class= 'alert alert-danger' style='font-size:14px; font-family:sant-serif; font-weight:bold; ' >
             LOKASI TIDAK SESUAI
          </div>";
            break;
        case 8:
          echo "<br>
          <div class= 'alert alert-danger' style='font-size:14px; font-family:sant-serif; font-weight:bold; ' >
             STATUS SPK TIDAK SAMA DENGAN PICKUP
          </div>";
        break;
        default:
            echo "
            <br>
            <div class= 'alert alert-danger' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
               NO CONT : $NOCONT NOT FOUND
            </div>";
            break;
        } ?>
      <?php endif ?>
</div>
  <?php
  if(isset($status)){
    if ($status==2) {
    echo form_open('operation/search_behandlein');
  ?>
  <div class="container">
    <br>
    <div class="form_group form_material">
        <div class="row">
          <div class="col-md-12">
            <div class="radio">
				<?php
				  foreach ($nilai->result() as $row) {
				?>
				<button type="submit" class="btn btn-primary" name="submitman2" value="<?php echo $row->NO_CONT;?>" 
				style=" width:150px; border: 1px solid #a1a1a1; height: 35px"><?php echo $row->NO_CONT; ?></button><br><br>
				<?php } ?>
            </div>
          </div>
        </div>
    </div>
  </div>

  <?php
  echo form_close();
    }elseif ($status==1) {
     echo form_open('operation/behandlein');
      // foreach ($nilai as $nilai2) {
  ?>
     <div class="container">
        <div class=" col-md-4 form-group">
              <label style="color:white;" for="No_cont">NO CONT</label>
              <div class="row">
                <div class=" col-md-12">
                  <a href=""></a><input type="text" class="form-control" id="No_cont" name="nomerkon" value="<?php echo $nilai['NO_CONT']; ?>" required="required" readonly><br>
                </div>
              </div>

              <label style="color:white;" for="Iso_code">ISO CODE</label>
              <div class="row">
                <div class=" col-md-12">
                  <input type="text" class="form-control" id="Iso_code" name="isocode" maxlength="4" required >
                </div>
              </div>

                <br><label style="color:white;">KONDISI SEAL</label>
              <div class="row">
                <div class=" col-md-12">
                  <div class="radio" >
                    <label style="color:white;"><input type="radio" name="optradio" value="ada" checked >ADA</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <label style="color:white;"><input type="radio" name="optradio" value="tidak ada">TIDAK ADA</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <!-- <label><input type="radio" name="optradio" value="rusak">RUSAK</label> -->
                  </div>
                </div>
              </div>

              <label style="color:white;" for="No_segel">NO SEAL</label>
              <div class="row">
                <div class=" col-md-12">
              <input type="text" class="form-control" id="No_seal" name="noseal" required>
                </div>
              </div>

              <br><label style="color:white;" for="kond">KONDISI KONTAINER</label>
              <div class="row">
                <div class=" col-md-12">
                  <select class="form-control" id="kond" name="kondisi" required>
                      <option value="">KONDISI KONTAINER</option>
                      <?php
                          foreach ($kondisi->result() as $row) {
                      ?>
                        <option value="<?php echo $row->ID ?>"><?php echo $row->KONDISI ?></option>
                      <?php } ?>
                  </select>
                </div>
              </div>
			  
			  <br><label style="color:white;" for="trucknya">TID</label>
              <div class="row">
                <div class=" col-md-12">
                  <select class="form-control" id="trucknya" name="trucknya" required>
                      <option value="<?php echo $nilai['ID_FLAT']; ?>"><?php echo $nilai['ID_FLAT']; ?></option>
						<?php
							foreach ($truck->result() as $rownya) {
						?>
							<option value="<?php echo $rownya->NO_TRUCK ?>"><?php echo $rownya->NO_TRUCK?></option>
						<?php } ?>
                  </select>
                </div>
              </div>

              <br><label style="color:white;" for="lok_awal">LOKASI</label>
              <div class="row">
                <div class=" col-md-12">
                  <input type="text" class=" form-control" id="nolok" name="nolok" value="<?php $loknya=trim($nilai['LOKASI']); echo $loknya;?>" required="required">
                </div>
              </div>
			  
			  <br><label style="color:white;">STATUS KONTAINER</label>
              <div class="row">
                <div class=" col-md-12">
                  <div class="radio" >
                    <label style="color:white;"><input type="radio" name="optradiostatus" value="FL" checked >FULL</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <label style="color:white;"><input type="radio" name="optradiostatus" value="M">EMPTY</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <!-- <label><input type="radio" name="optradio" value="rusak">RUSAK</label> -->
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <br><button type="submit" class="btn btn-primary" style="border: 1px solid #a1a1a1;">BEHANDLE IN</button>
                </div>
              </div>
        </div>
      </div>
  <?php
}else { ?>
  <br>
  <div class="container">
    <?php if (isset($kode)): ?>
      <?php switch ($kode) {
        case 1:
          echo "<br>
          <div class= 'alert alert-danger' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
             WARNING ! NO CONT : $nilai NOT FOUND
          </div>";
          break;
        default:
          echo "";
          break;
      } ?>
    <?php endif ?>
    
  </div>
<!-- tutup else -->
<?php } }
echo form_close();
?>
