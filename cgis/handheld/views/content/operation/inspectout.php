
  <?php
    echo form_open('operation/search_inspect');
  ?>
  <div class="container">
	<a href="<?php echo site_url('operation/opr'); ?>">
		<H4 style="color:white;"><< MENU HANDHELD</H4>
	</a></br>
	<H5 style="color:white;">INSPECTION OUT</H5><br>
    <div class="form_group form_material">
      <div class="col-sm-3 col-md-3"  >
        <input style="border: 1px solid #a1a1a1;"  class="form-control" type="text" name="search_cont" placeholder=" SEARCH NO CONT" autofocus required>
      </div>
      <div class="col-sm-1 col-md-1" >
        <button type="submit" class="btn btn-primary" style="border: 1px solid #a1a1a1;">SEARCH</button>
        <!-- <input type="submit" class="form-control"  value="search" style="border-radius:10px; border: 2px solid #a1a1a1;"> -->
      </div>
    </div>
  </div>
  <hr>
  
  
  
    
	<?php if (isset($notif)): ?>
      <?php switch ($notif) {
        case 1:
          echo "<br>
          <div class= 'alert alert-primary' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
             NO CONT : $NOCONT SUCCESS TRUCK IN
          </div>";
          break;
        case 2:
          echo "<br>
          <div class='alert alert-primary' style='font-size:16px; font-family:sant-serif; font-weight:bold; '>
              NO CONT : $NOCONT SUCCESS INSPECTION OUT
          </div>";
          break;
        default:
          echo "<br>
          <div class= 'alert alert-danger' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
             WARNING ! NO CONT : $NOCONT NOT FOUND
          </div>";
          break;
      } ?>
    <?php endif ?>

	<?php
	echo form_close();
	 if(isset($status)){
		if ($status==1) {     
	echo form_open('operation/searchdelivinspect');
	?>
  <div class="container">
    <br>
    <div class="form_group form_material">
        <div class="row">
          <div class="col-md-12">
            <div class="radio">
              <?php for ($i=0; $i <count($nilai) ; $i++) { ?>
                  <button type="submit" class="btn btn-primary" name="submitman2" value="<?php echo $nilai[$i]['NO_CONT'] ; ?>" style=" width:150px; border: 1px solid #a1a1a1; height: 35px"><?php echo $nilai[$i]['NO_CONT'] ; ?></button><br><br>
              <?php } ?>
            </div>
          </div>
        </div>
    </div>
  </div>
	<?php
		echo form_close();
		}elseif ($status==2) { 
	echo form_open('operation/inspectout');	
	?>
    <div class="container">
         <div class="col-md-4 form-group">
                 <br><label style="color:white;" for="No_cont">NO CONT</label>
                 <input type="text" class="form-control col-md-4 col-sm-4" id="Nocon" name="nomercont" value="<?php echo $nilai[0]['NO_CONT']; ?>" readonly><br><br><br>
				 <br><label style="color:white;" for="No_cont">UKURAN</label>
                 <input type="text" class="form-control col-md-4 col-sm-4" id="ukuran" name="ukuran" value="<?php echo $nilai[0]['UKR_CONT']; ?>" readonly><br><br><br><br>
				 <label style="color:white;" >KONDISI SEAL</label>
              <div class="row">
                <div class=" col-md-12">
                  <div class="radio" >
                    <label style="color:white;"><input type="radio" name="optradio" value="ada" checked >ADA</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <label style="color:white;"><input type="radio" name="optradio" value="tidak ada">TIDAK ADA</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <!-- <label><input type="radio" name="optradio" value="rusak">RUSAK</label> -->
                  </div>
                </div>
              </div>
			  
			  <div class="row">
                <div class=" col-md-12">
					<label style="color:white;" for="No_segel">NO SEAL</label>
					<input type="text" class="form-control" id="No_seal" name="noseal" value="<?php echo $nilai[0]['NO_SEAL']; ?>">
                </div>
              </div>
<br>
              <label style="color:white;" for="kond" >KONDISI KONTAINER</label>
              <div class="row">
                <div class=" col-md-12">
                  <select class="form-control" id="kond" name="kondisi">
                      <option value="">Pilih Kondisi Kontainer</option>
                      <?php
                          for ($i=0;$i<count($kondisi); $i++) {
                      ?>
                        <option value="<?php echo $kondisi[$i]['ID'] ?>"><?php echo $kondisi[$i]['KONDISI'] ?></option>
                      <?php } ?>
                  </select>
                </div>
              </div><br>
                 <button style=" width:150px; border: 1px solid #a1a1a1; height: 35px" id="str" type="submit"  class="btn btn-primary">INSPECTION OUT</button>  
        </div>                   
     </div>
    <?php echo form_close(); ?>
 <?php }else { ?>
     <div class="container">
            <?php if (isset($kode)): ?>
                 <?php switch ($kode) {
                   case 1:
                     echo "<br>
                     <div class= 'alert alert-danger' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
                        WARNING ! NO CONT : $kontainer NOT FOUND
                     </div>";
                     break;
                   default:
                     echo "";
                     break;
                 } ?>
            <?php endif ?>
     </div>
     <!-- tutup else -->
<?php } } ?>
