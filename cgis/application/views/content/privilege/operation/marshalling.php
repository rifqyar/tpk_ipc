<?php
  echo form_open('operation/src');
?>
<div class="container">
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
       SUCCESS MARSHALLING
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
  echo form_open('operation/marshalling');
  if ($status==1) { ?>
      <div class="container">
              <div class="row">
                  <div class="form-group form-material"><br><br>
                     <table class="table">
                       <tr>
                         <th>NO JOB SLIP</th>
                         <th>NO KONTAINER</th>
                         <th>LOKASI AWAL</th>
                         <th>LOKASI AKHIR</th>
                         <th>PROSES</th>
                       </tr>
                       <?php
                       foreach ($nilai as $nilai2): ?>
                       <tr>
                        <td><input type="text" class="form-control" id="jobs" name="jobs" value="<?php echo $nilai2['ID_JOB_SLIP']; ?>" readonly ></td>
                        <td><input type="text" class="form-control" id="nocont" name="nocont" value="<?php echo $nilai2['NO_CONT']; ?>" readonly ></td>
                        <td><input type="text" class="form-control" id="lokaw" name="lokaw" value="<?php echo $nilai2['LOKASI_AWAL']; ?>" readonly ></td>
                        <td><input type="text" class="form-control" id="lokak" name="lokak" value="<?php echo $nilai2['LOKASI_AKHIR']; ?>" ></td>
                        <td>
                          <button id="str" type="submit"  class="btn btn-primary">SUBMIT</button>
                        </td>
                      </tr>
                       <?php endforeach; ?>
                    </table>
                 </div>
              </div>
        </div>
      </div>
  <?php
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
                      <th>NO JOB SLIP</th>
                      <th>NO KONTAINER</th>
                      <th>LOKASI AWAL</th>
                      <th>LOKASI AKHIR</th>
                      <th>PROSES</th>
                    </tr>
                     <?php
                     foreach ($nilai as $nilai2): ?>
                     <tr>
                      <td><input type="text" class="form-control" id="jobs" name="jobs" value="<?php echo $nilai2['ID_JOB_SLIP']; ?>" readonly ></td>
                      <td><input type="text" class="form-control" id="nocont" name="nocont" value="<?php echo $nilai2['NO_CONT']; ?>" readonly ></td>
                      <td><input type="text" class="form-control" id="lokaw" name="lokaw" value="<?php echo $nilai2['LOKASI_AWAL'] ; ?>" readonly ></td>
                      <td><input type="text" class="form-control" id="lokak" name="lokak" value="<?php echo $nilai2['LOKASI_AKHIR']; ?>"  ></td>
                      <td>
                        <button  id="str" type="submit"  class="btn btn-primary">SUBMIT</button>
                      </td>
                    </tr>
                     <?php endforeach; ?>
                 </table>
              </div>
     </div>
<!-- tutup else -->
<?php }
echo form_close();
?>
