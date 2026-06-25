
  <?php
    echo form_open('operation/list_reefer');
  ?>
  <div class="container">
<a href="<?php echo site_url('operation/opr'); ?>">
	<H4 style="color:white;"><< MENU HANDHELD</H4>
</a>
  <br>
	<H5 style="color:white;">MONITORING REEFER</H5><br>
    <!-- No Cont &nbsp;
    <i class="icon md-search" aria-hidden="true" ></i> --><br>
    <div class="form_group form_material">
      <div class="col-sm-3 col-md-3"  >
        <input style=" border: 1px solid #a1a1a1;"  class="form-control" type="text" name="search_cont" placeholder=" SEARCH NO CONT" autofocus required>
      </div>
      <div class="col-sm-1 col-md-1" >
        <button type="submit" class="btn btn-primary" style="border: 1px solid #a1a1a1;">SEARCH</button>
        <!-- <input type="submit" class="form-control"  value="search" style="border-radius:10px; border: 2px solid #a1a1a1;"> -->
      </div>
    </div>
  </div>
  <hr>

    <?php 
	echo form_close();
	if (isset($notif)): ?>
      <?php switch ($notif) {
        case 1:
          echo "<br>
          <div class= 'alert alert-success' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
             NO CONT : $NOCONT PLUGIN KONTAINER
          </div>";
          break;
        case 2:
          echo "<br>
          <div class='alert alert-primary' style='font-size:16px; font-family:sant-serif; font-weight:bold; '>
              NO CONT : $NOCONT UNPLUGIN KONTAINER
          </div>";
          break;
        case 5:
          echo "<br>
          <div class= 'alert alert-danger' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
             WARNING ! NO CONT : $NOCONT KONTAINER SUDAH UNPLUGIN
          </div>";
          break;
        case 6:
          echo "<br>
          <div class= 'alert alert-danger' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
             WARNING ! NO CONT : $NOCONT NOT FOUND
          </div>";
          break;
        case 7:
          echo "<br>
          <div class= 'alert alert-success' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
             WARNING ! NO CONT : $NOCONT MONITORING BERHASIL
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
if(isset($status)){
    if ($status==2) {
    echo form_open('operation/monitoring_reefer');
  ?>
  <div class="container">
    <br>
    <div class="form_group form_material">
        <div class="row">
          <div class="col-md-12">
            <div class="radio">
				<?php
				  for ($i=0; $i <count($nilai) ; $i++) {
				?>
				<button type="submit" class="btn btn-primary" name="submitman2" value="<?php echo $nilai[$i]['NO_CONT']; ?>"
				style=" width:150px; border: 1px solid #a1a1a1; height: 35px"><?php echo $nilai[$i]['NO_CONT'] ; ?></button><br><br>
			  <?php } ?>
            </div>
          </div>
        </div>
    </div>
  </div>

  <?php
	echo form_close();
    }elseif ($status==1) {
    echo form_open('operation/monitor_reefer');
      ?>
      <div class="container">
         <div class="col-md-4 col-sm-4 form-group">

        <?php 
		if ($kond==1) { ?>
            <label for="No_cont" style="color:white;">NO CONTAINER</label>
            <input type="text" class="form-control" id="No_cont" name="nomerkon" value="<?php echo $nilai['NO_CONT']; ?>" readonly><br>
            <label for="temperature" style="color:white;">TEMPERATURE SEBELUMNYA</label>
            <input type="text" class="form-control" value="<?php echo $temprev['TEMPERATURE_MONITOR'] ?>" readonly><br>
            <label for="temperature" style="color:white;">TEMPERATURE SAAT INI</label>
            <input type="text" class="form-control" id="temperature" name="temperature"><br>
            <input type="hidden" id="w_plugin" name="w_plugin" value="<?php echo $nilai['WAKTU']; ?>" readonly>
            <label for="note" style="color:white;">CATATAN</label>
            <textarea rows="8" style="width: 100%" name="note" id="note"></textarea>
            <!-- <label for="No_segel">No Seal</label>
            <input type="text" class="form-control" id="No_seal" name="noseal" required ><br>
            <label for="No_segel">No Segel BC</label>
            <input type="text" class="form-control" id="No_segelbc" name="nosegelbc" ><br>
            <label for="No_segel">No Segel Karantina</label>
            <input type="text" class="form-control" id="No_segelkrt" name="nosegelkrt" ><br> -->
            <button style="width:150px; border: 1px solid #a1a1a1; height: 35px; margin: 50px 0;" id="str" type="submit"  class="btn btn-primary">MONITORING</button><br>
            <!-- <button style=" width:150px; border-radius:5px; border: 2px solid #a1a1a1; height: 35px" id="fin" type="submit" class="btn btn-primary" disabled >Finish Inspection</button> -->
         <?php }else {  ?>
        </div>
              <?php echo"<br>
              <div class= 'alert alert-danger col-sm-12' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
                WARNING ! NO CONT : $NOCONT SUDAH UNPLUGIN
              </div>
              "; ?>
        <?php } ?>
      </div>
    <?php
	
  }else { ?>
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
<?php } } echo form_close(); ?>
