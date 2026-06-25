
  <?php
    echo form_open('operation/src2');
  ?>
  <div class="container">
    <!-- No Cont &nbsp;
    <i class="icon md-search" aria-hidden="true" ></i> --><br>
    <div class="form_group form_material">
      <div class="col-sm-3 col-md-3"  >
        <input style="border-radius:10px; border: 2px solid #a1a1a1;"  class="form-control" type="text" name="search_cont" placeholder=" SEARCH NO CONT" autofocus required>
      </div>
      <div class="col-sm-1 col-md-1" >
        <button type="submit" class="btn btn-primary" style="border-radius:10px; border: 2px solid #a1a1a1;">Search</button>
        <!-- <input type="submit" class="form-control"  value="search" style="border-radius:10px; border: 2px solid #a1a1a1;"> -->
      </div>
    </div>
  </div>

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
    if ($status==2) {
    echo form_open('operation/src2a');
  ?>
  <div class="container">
    <br>
    <div class="form_group form_material">
        <div class="row">
          <div class="col-md-12">
            <div class="radio">
              <?php for ($i=0; $i <count($nilai) ; $i++) { ?>
                  <button type="submit" class="btn btn-primary" name="submitman2" value="<?php echo $nilai[$i]['NO_CONT'] ; ?>" style=" width:150px; border-radius:5px; border: 2px solid #a1a1a1; height: 35px"><?php echo $nilai[$i]['NO_CONT'] ; ?></button><br><br>
              <?php } ?>
            </div>
          </div>
        </div>
    </div>
  </div>
  <?php
    echo form_close();
    }elseif ($status==1) {
    echo form_open('operation/realisasibi');
      ?>
      <div class="container">
         <div class="col-md-4 col-sm-4 form-group">

        <?php if ($kond==0) { ?>
            <label for="No_cont">No Cont</label>
            <input type="text" class="form-control" id="No_cont" name="nomerkon" value="<?php echo $nilai[0]['NO_CONT']; ?>" readonly><br>
            <!-- <label for="No_segel">No Seal</label>
            <input type="text" class="form-control" id="No_seal" name="noseal" required ><br>
            <label for="No_segel">No Segel BC</label>
            <input type="text" class="form-control" id="No_segelbc" name="nosegelbc" ><br>
            <label for="No_segel">No Segel Karantina</label>
            <input type="text" class="form-control" id="No_segelkrt" name="nosegelkrt" ><br> -->
            <button style=" width:150px; border-radius:5px; border: 2px solid #a1a1a1; height: 35px" id="str" type="submit"  class="btn btn-primary">Mulai Pemeriksaan</button><br>
            <!-- <button style=" width:150px; border-radius:5px; border: 2px solid #a1a1a1; height: 35px" id="fin" type="submit" class="btn btn-primary" disabled >Finish Inspection</button> -->
        <?php }elseif ($kond==1) { ?>
            <label for="No_cont">No Cont</label>
            <input type="text" class="form-control" id="No_cont" name="nomerkon" value="<?php echo $nilai[0]['NO_CONT']; ?>" readonly><br>
            <label for="No_segel">No Seal</label>
            <input type="text" class="form-control" id="No_seal" name="noseal" value="<?php echo $insp['NO_SEAL'] ?>" required><br>
            <!-- <label for="No_segel">No Segel BC</label>
            <input type="text" class="form-control" id="No_segelbc" name="nosegelbc" value="<?php echo $insp['NO_SEGEL_BC'] ?>"  ><br>
            <label for="No_segel">No Segel Karantina</label>
            <input type="text" class="form-control" id="No_segelkrt" name="nosegelkrt" value="<?php echo $insp['NO_SEGEL_KRT'] ?>" ><br> -->
            <!-- <button style=" width:150px; border-radius:5px; border: 2px solid #a1a1a1; height: 35px" id="str" type="submit"  class="btn btn-primary" disabled>Start Inspection</button><br><br> -->
            <button style=" width:150px; border-radius:5px; border: 2px solid #a1a1a1; height: 35px" id="fin" type="submit" class="btn btn-primary" >Selesai Pemeriksaan</button>
         <?php }else{  ?>
        </div>
              <?php echo"<br>
              <div class= 'alert alert-danger col-sm-12' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
                 WARNING ! NO CONT : $NOCONT NOT FOUND
              </div>
              "; ?>
        <div class="container col-md-4 col-sm-4">
              <div class="form-group">
                <label for="No_cont">No Cont</label>
                <input type="text" class="form-control" id="No_cont" readonly><br>
                <!-- <label for="No_segel">No Seal</label>
                <input type="text" class="form-control" id="No_seal" name="noseal" disabled><br>
                <label for="No_segel">No Segel BC</label>
                <input type="text" class="form-control" id="No_segelbc" name="nosegelbc" disabled><br>
                <label for="No_segel">No Segel Karantina</label>
                <input type="text" class="form-control" id="No_segelkrt" name="nosegelkrt" disabled ><br>
                <button style=" width:150px; border-radius:5px; border: 2px solid #a1a1a1; height: 35px" id="str" type="submit"  class="btn btn-primary">Start Realisasi</button><br><br>
                <button style=" width:150px; border-radius:5px; border: 2px solid #a1a1a1; height: 35px" id="fin" type="submit" class="btn btn-primary">Finish Realisasi</button> -->
              </div>
        <?php } ?>
        </div>
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
    <div class="col-md-4 col-sm-4 form-group">
      <label for="No_cont">No Cont</label>
      <input type="text" class="form-control" id="No_cont" readonly><br>
      <!-- <label for="No_segel">No Seal</label>
      <input type="text" class="form-control" id="No_seal" name="noseal" disabled><br>
      <label for="No_segel">No Segel BC</label>
      <input type="text" class="form-control" id="No_segelbc" name="nosegelbc" disabled ><br>
      <label for="No_segel">No Segel Karantina</label>
      <input type="text" class="form-control" id="No_segelkrt" name="nosegelkrt" disabled ><br> -->
      <!-- <button style=" width:150px; border-radius:5px; border: 2px solid #a1a1a1; height: 35px" id="str" type="submit"  class="btn btn-primary">Start Realisasi</button><br><br>
      <button style=" width:150px; border-radius:5px; border: 2px solid #a1a1a1; height: 35px" id="fin" type="submit" class="btn btn-primary">Finish Realisasi</button> -->
    </div>
  </div>
  <!-- tutup else -->
<?php } echo form_close(); ?>
