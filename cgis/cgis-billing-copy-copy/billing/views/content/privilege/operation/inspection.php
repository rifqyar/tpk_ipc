
<?php
  echo form_open('operation/searchb');
?>
<div class="container">
  <br>
  <div class="form_group form_material">
    <div class="col-sm-3 col-md-3"  >
      <input style="border-radius:10px; border: 2px solid #a1a1a1;"  class="form-control" type="text" name="search_cont" placeholder=" SEARCH NO CONT" autofocus required>
    </div>
    <div class="col-sm-1 col-md-1" >
      <button type="submit" class="btn btn-primary" style="border-radius:10px; border: 2px solid #a1a1a1;">Search</button>
    </div>
  </div>
</div>
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
    if ($status==2) {
    echo form_open('operation/searchb2');
  ?>
  <div class="container">
    <br>
    <div class="form_group form_material">
        <div class="row">
          <div class="col-md-12">
            <div class="radio">
              <?php for ($i=0; $i <count($nilai) ; $i++) { ?>
                  <button type="submit" class="btn btn-primary" name="submitman" value="<?php echo $nilai[$i]['NO_CONT'] ; ?>" style=" width:150px; border-radius:5px; border: 2px solid #a1a1a1; height: 35px"><?php echo $nilai[$i]['NO_CONT'] ; ?></button><br><br>
              <?php } ?>
            </div>
          </div>
        </div>
    </div>
  </div>
  <?php
    echo form_close();
    }elseif ($status==1) {
     echo form_open('operation/inspection');
      
      // foreach ($nilai as $nilai2) {
  ?>
      <div class="container">
        <div class=" col-md-4 form-group">
              <label for="No_cont">No Cont</label>
              <div class="row">
                <div class=" col-md-12">
                  <a href=""></a><input type="text" class="form-control" id="No_cont" name="nomerkon" value="<?php echo $nilai[0]['NO_CONT']; ?> " readonly><br>
                </div>
              </div>

              <label for="Iso_code">ISO CODE</label>
              <div class="row">
                <div class=" col-md-12">
                  <input type="text" class="form-control" id="Iso_code" name="isocode" maxlength="4" >
                </div>
              </div>

                <br><label>Kondisi Seal</label>
              <div class="row">
                <div class=" col-md-12">
                  <div class="radio" >
                    <label><input type="radio" name="optradio" value="ada" checked >ADA</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <label><input type="radio" name="optradio" value="tidak ada">TIDAK ADA</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <!-- <label><input type="radio" name="optradio" value="rusak">RUSAK</label> -->
                  </div>
                </div>
              </div>

              <label for="No_segel">No Seal</label>
              <div class="row">
                <div class=" col-md-12">
              <input type="text" class="form-control" id="No_seal" name="noseal" >
                </div>
              </div>

              <br><label for="kond">Kondisi Kontainer</label>
              <div class="row">
                <div class=" col-md-12">
                  <select class="form-control" id="kond" name="kondisi">
                      <option value="">Pilih Kondisi Kontainer</option>
                      <?php
                          foreach ($kondisi->result() as $row) {
                      ?>
                        <option value="<?php echo $row->ID ?>"><?php echo $row->KONDISI ?></option>
                      <?php } ?>
                  </select>
                </div>
              </div>

              <br><label for="lok_awal">Lokasi</label>
              <div class="row">
               <!--  <div class=" col-md-8">
                  <input type="text" class=" form-control" id="lokasi" name="lokasi" value="<?php echo $nilai2['ROOM']; ?> " readonly>
                </div> -->
                <div class=" col-md-12">
                  <input type="text" class=" form-control" id="nolok" name="nolok" value="<?php echo $nilai[0]['LOKASI']; ?> ">
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <br><button type="submit" class="btn btn-primary" style="border-radius:5px; border: 2px solid #a1a1a1;">Submit</button>
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
    <div class=" col-md-4 form-group">
          <label for="No_cont">No Cont</label>
          <div class="row">
            <div class=" col-md-12">
            <input type="text" class="form-control" id="No_cont" name="nomerkon" readonly>
            </div>
          </div>
    </div>
  </div>
<!-- tutup else -->
<?php }
echo form_close();
?>
