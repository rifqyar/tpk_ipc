<?php
echo form_open('operation/search_reexport');
?>
<div class="container">
  <a href="<?php echo site_url('operation/opr'); ?>">
    <H4 style="color:white;">
      << MENU HANDHELD</H4>
  </a>
  <br>
  <H5 style="color:white;">STRIPPING & STUFFING</H5><br>
  <div class="form_group form_material">
    <div class="col-sm-3 col-md-3">
      <input style=" border: 1px solid #a1a1a1;" class="form-control" type="text" name="search_cont" placeholder=" SEARCH NO CONT" autofocus required>
    </div>
    <div class="col-sm-1 col-md-1">
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
              NO CONT : $NOCONT SUCCESS STRIPPING STUFFING
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
              GAGAL MULAI STRIPPING & STUFFING, ADA DATA YANG TIDAK LENGKAP
           </div>";
        break;
      case 4:
        echo "
           <br>
           <div class= 'alert alert-danger' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
              GAGAL MULAI STRIPPING & STUFFING, SUDAH ADA DATA UNTUK CONTAINER TERSEBUT
           </div>";
        break;
      case 5:
        echo "
           <br>
           <div class= 'alert alert-success' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
              BERHASIL END OPERATION STRIPPING & STUFFING
           </div>";
        break;
      case 6:
        echo "
           <br>
           <div class= 'alert alert-success' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
              BERHASIL START OPERATION STRIPPING & STUFFING
           </div>";
        break;
      case 9:
        echo "
           <br>
           <div class= 'alert alert-danger' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
              GAGAL STRIPPING & STUFFING, HARAP HUBUNGI TIM IT
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
if (isset($status)) {
  if ($status == 2) {
    echo form_open('operation/detail_reexport');
?>
    <div class="container">
      <br>
      <div class="form_group form_material">
        <div class="row">
          <div class="col-md-12">
            <div class="radio">
              <?php
              foreach ($nilai as $row) {
              ?>
                <button type="submit" class="btn btn-primary" name="submitman2" value="<?php echo $row->NO_CONT; ?>"
                  style=" width:auto; border: 1px solid #a1a1a1; height: 35px">No. Dok : <?php echo $row->NO_DOK; ?> | <?= $row->NO_CONT ?></button><br><br>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php
    echo form_close();
  } elseif ($status == 1) {
    echo form_open('operation/do_stripstuff');
    foreach ($nilai as $nilai2) {
    ?>
      <div class="container">
        <div class=" col-md-4 form-group">
          <label style="color:white;" for="No_cont">NO CONT BARU</label>
          <div class="row">
            <div class=" col-md-12">
              <a href=""></a><input type="text" class="form-control" id="No_cont" name="nomerkon" value="<?php echo $nilai2->NO_CONT; ?>" required="required" readonly><br>
            </div>
          </div>
          
          <label style="color:white;" for="No_cont">NO DOKUMEN BARU</label>
          <div class="row">
            <div class=" col-md-12">
              <a href=""></a><input type="text" class="form-control" id="No_cont" name="no_dok" value="<?php echo $nilai2->NO_DOK; ?>" required="required" readonly><br>
            </div>
          </div>
          
          <label style="color:white;" for="No_cont">NO CONT LAMA</label>
          <div class="row">
            <div class=" col-md-12">
              <a href=""></a><input type="text" class="form-control" id="No_cont" name="no_cont_lama" value="<?php echo $nilai2->NO_CONT_LAMA; ?>" required="required" readonly><br>
            </div>
          </div>
          
          <label style="color:white;" for="No_cont">NO DOKUMEN LAMA</label>
          <div class="row">
            <div class=" col-md-12">
              <a href=""></a><input type="text" class="form-control" id="No_cont" name="no_dok_lama" value="<?php echo $nilai2->NO_DOK_LAMA; ?>" required="required" readonly><br>
            </div>
          </div>
          
          <?php if($nilai2->WK_START_STRIPSTUF != null) { ?>
          <label style="color:white;" for="start_strip_stuff">START STRIP STUFF</label>
          <div class="row">
            <div class=" col-md-12">
              <a href=""></a><input type="text" class="form-control" id="start_strip_stuff" name="op_start" value="<?php echo $nilai2->WK_START_STRIPSTUF; ?>" required="required" readonly><br>
            </div>
          </div>
          <?php } ?>

          <div class="row">
            <div class="col-md-12">
              <?php if($nilai2->WK_START_STRIPSTUF == null) { ?>
              <br><button type="submit" class="btn btn-primary" style="border: 1px solid #a1a1a1;">MULAI STRIPPING & STUFFING</button>
              <?php } else { ?>
              <br><button type="submit" class="btn btn-primary" style="border: 1px solid #a1a1a1;">END STRIPPING & STUFFING</button>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>
    <!-- tutup else -->
<?php }
}
echo form_close();
?>