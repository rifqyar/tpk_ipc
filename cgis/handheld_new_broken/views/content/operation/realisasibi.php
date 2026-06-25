
  <?php
    echo form_open('operation/search_realis');
  ?>
  <div class="container">
<a href="<?php echo site_url('operation/opr'); ?>">
	<H4 style="color:white;"><< MENU HANDHELD</H4>
</a>
  <br>
	<H5 style="color:white;">PEMERIKSAAN BEHANDLE</H5><br>
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
          <div class= 'alert alert-primary' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
             NO CONT : $NOCONT MULAI PEMERIKSAAN
          </div>";
          break;
        case 2:
          echo "<br>
          <div class='alert alert-primary' style='font-size:16px; font-family:sant-serif; font-weight:bold; '>
              NO CONT : $NOCONT SELESAI PEMERIKSAAN
          </div>";
          break;
        case 5:
          echo "<br>
          <div class= 'alert alert-danger' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
             WARNING ! NO CONT : $NOCONT STATUS TIDAK DI CIC
          </div>";
          break;
        case 6:
          echo "<br>
          <div class= 'alert alert-danger' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
             WARNING ! NO CONT : $NOCONT NOT FOUND
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
    echo form_open('operation/search_realisasi');
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
    echo form_open('operation/realisasi');
      ?>
      <div class="container">
         <div class="col-md-4 col-sm-4 form-group">

        <?php 
		if ($kond==0) { ?>
            <label for="No_cont" style="color:white;">NO CONTAINER</label>
            <input type="text" class="form-control" id="No_cont" name="nomerkon" value="<?php echo $nilai[0]['NO_CONT']; ?>" readonly><br>
            <!-- <label for="No_segel">No Seal</label>
            <input type="text" class="form-control" id="No_seal" name="noseal" required ><br>
            <label for="No_segel">No Segel BC</label>
            <input type="text" class="form-control" id="No_segelbc" name="nosegelbc" ><br>
            <label for="No_segel">No Segel Karantina</label>
            <input type="text" class="form-control" id="No_segelkrt" name="nosegelkrt" ><br> -->
            <button style="width:150px; border: 1px solid #a1a1a1; height: 35px; margin: 50px 0;" id="str" type="submit"  class="btn btn-primary">MULAI PERIKSA</button><br>
            <!-- <button style=" width:150px; border-radius:5px; border: 2px solid #a1a1a1; height: 35px" id="fin" type="submit" class="btn btn-primary" disabled >Finish Inspection</button> -->
        <?php }elseif ($kond==1) { ?>
             <label for="No_cont" style="color:white;">NO KONTAINER</label>
            <input type="text" class="form-control" id="No_cont" name="nomerkon" value="<?php echo $nilai[0]['NO_CONT']; ?>" readonly><br>
            <label for="No_segel" style="color:white;">NO SEAL</label>
            <input type="text" class="form-control" id="No_seal" name="noseal" value="<?php echo $insp['NO_SEAL'] ?>" required><br>
            <input type="hidden" class="form-control" id="idJobSlip" name="idJobSlip" value="<?php echo $nilai[0]['ID_JOB_SLIP']; ?>"  readonly>
            <input type="hidden" class="form-control" id="nospk" name="nospk" value="<?php echo $nilai[0]['NO_SPK']; ?>"  readonly>
            <input type="hidden" class="form-control" id="tipecont" name="tipecont" value="<?php echo $nilai[0]['TIPE_CONT']; ?>"  readonly>
            <label for="alat" style="color:white;">Data Alat</label>
            <select class="form-control" id="alat" name="alat">
            <option value="">---Pilih Alat---</option>
            <?php foreach ($DropDwonAlat->result_array() as $row): ?>
              <option value="<?php echo $row['ID']; ?>"><?php echo $row['NM_ALAT']; ?></option>
              <?php echo form_close(); endforeach; ?>
            </select>
            <br>
            <datalist id="operator" name="operator">
              <?php foreach ($DropDwonOperator->result_array() as $row): ?>
                <option value="<?php echo $row['ID']; ?>"><?php echo $row['NAMA']; ?></option>
                <?php echo form_close(); endforeach; ?>
              </datalist>
            <label for="listopr" style="color:white;">Operator</label> <br>
            <input  autoComplete="on" list="operator" name="operator" />
            
            <br>
            <br>
            <?php
                if ($join) {
                  echo '<div class="alert alert-warning" role="alert" style="color:#000000;">
                  Dokumen Ini adalah dokumen join inspection dengan No Aju '.$join->LNSW_NOAJU.', ketika klik finish akan langsung membuat kartu behandle dan siap periksa, sehinggan bisa di lanjutkan ke mulai periksa behandle berikutnya
                </div>';
                echo '<input type="hidden" name="join" value="1">';
                }else{
                  echo '<input type="hidden" name="join" value="0">';
                }
            ?>
            
            <button style=" width:200px; border: 1px solid #a1a1a1; height: 35px" id="fin" type="submit" class="btn btn-primary" >SELESAI PEMERIKSAAN</button>
         <?php }else{  ?>
        </div>
              <?php echo"<br>
              <div class= 'alert alert-danger col-sm-12' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
                 WARNING ! NO CONT : $NOCONT NOT FOUND
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
