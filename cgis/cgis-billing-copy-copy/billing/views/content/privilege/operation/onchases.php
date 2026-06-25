<?php
  echo form_open('operation/srcchases');
?>
<div class="container">
  <div class="form_group form_material">
    <div class="col-sm-4" >
      <input style="border-radius:10px; border: 2px solid #a1a1a1;"  class="form-control" type="text" name="search_ch" placeholder=" SEARCH NO NO CONT" autofocus required>
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
       ON CHASSES SUCCESS 
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
  echo form_open('operation/chases');
  if ($status==1) { ?>
      <div class="container">
      <br>
             <div class="table-responsive">          
                <table class="table">
                  <thead>
                    <tr>
                     <th>NO KONTAINER</th>
                     <th>NO TRUCK</th>
                     <th>PROSES</th>
                   </tr>
                  </thead>
                  <tbody>
                   <?php
                     foreach ($nilai as $nilai2) { ?>
                     <tr>
                      <td><input type="text" class="form-control" id="nomercont" name="nomercont" value="<?php echo $nilai2['NO_CONT']; ?>" readonly ></td>
                      <td><input type="text" class="form-control" id="notruck" name="notruck" value="<?php echo $nilai2['NO_TRUCK']; ?>" readonly ></td>
                      <td>
                        <button id="str" type="submit"  class="btn btn-primary">SUBMIT</button>
                      </td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
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
                     <th>NO KONTAINER</th>
                     <th>NO TRUCK</th>
                     <th>PROSES</th>
                   </tr>
                  </thead>
                  <tbody>
                   <?php
                     foreach ($nilai as $nilai2) { ?>
                     <tr>
                      <td><input type="text" class="form-control" id="nomercont" name="nomercont" value="<?php echo $nilai2['NO_CONT']; ?>" readonly ></td>
                      <td><input type="text" class="form-control" id="notruck" name="notruck" value="<?php echo $nilai2['NO_TRUCK']; ?>" readonly ></td>
                      <td>
                        <button id="str" type="submit"  class="btn btn-primary">SUBMIT</button>
                      </td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
     </div>
<!-- tutup else -->
<?php }
echo form_close();
?>
 