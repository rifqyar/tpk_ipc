<?php
  echo form_open('operation/search_hold_new');
?>
<div class="container">
<a href="<?php echo site_url('operation/opr'); ?>">
	<H4 style="color:white;"><< MENU HANDHELD</H4>
</a>
  <br>
	<H5 style="color:white;">HOLD</H5><br>
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
    echo form_open('operation/search_hold');
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
        echo form_open('operation/hold_cont');
      // foreach ($nilai as $nilai2) {
  ?>
  <div class="container-fluid">
          <div class="table-responsive">
              <table class="table">
                    <thead>
                      <tr>
                        <th style="color:white;">NO SPK</th>
                        <th style="color:white;">NO CONTAINER</th>
                        <th style="color:white;">NO DOKUMEN</th>
                        <th style="color:white;">TANGGAL DOKUMEN</th>
                        <th style="color:white;">JENIS DOKUMEN</th>
                        <th style="color:white;">KETERANGAN</th>
                        <th style="color:white;">JENIS SEGEL</th>
                      </tr>
                    </thead>
                  <tbody>
   
                      <tr>
                      <td>
                        <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $nilai['ID']; ?>" >

                        <input type="text" class="form-control" id="nospk" name="nospk" value="<?php echo $nilai['NO_SPK']; ?>" readonly >
                        </td>
                        <td>
                        <input type="text" class="form-control" id="nomercont" name="nomercont" value="<?php echo $nilai['NO_CONT']; ?>" readonly >
                        </td>
                        <td>
                        <input type="text" class="form-control" id="nodok" name="nodok" value="<?php echo $nilai['NO_DOK']; ?>" readonly >
                        </td>
                        <td>
                        <input type="text" class="form-control" id="tgldok" name="tgldok" value="<?php echo $nilai['TGL_DOK']; ?>" readonly >
                        </td>
                        <td>
                        <input type="text" class="form-control" id="jnsdok" name="jnsdok" value="<?php echo $nilai['JNS_DOK']; ?>" readonly >
                        </td>
                        <td>
                        <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?php echo $nilai['KETERANGAN']; ?>" readonly >
                        </td>
                        <td>
                          <select class="form-control" id="warna" name="warna" required aria-required="true" readonly>
                            <option value="<?php echo $nilai['WARNA']; ?>"><?php echo $nilai['WARNA']; ?>
						                </option>
                          </select>
                        </td>
                        <td>
                          <button id="str" type="submit"  class="btn btn-primary">Tombol Hold</button>
                        </td>
                      </tr>
                  </tbody>
                </table>
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


<div class="container-fluid">
          <div class="table-responsive">
              <table class="table">
                    <thead>
                      <tr>
                        <th style="color:white;">NO SPK</th>
                        <th style="color:white;">NO CONTAINER</th>
                        <th style="color:white;">NO DOKUMEN</th>
                        <th style="color:white;">TANGGAL DOKUMEN</th>
                        <th style="color:white;">JENIS DOKUMEN</th>
                        <th style="color:white;">KETERANGAN</th>
                        <th style="color:white;">JENIS SEGEL</th>
                      </tr>
                    </thead>
                  <tbody>
                    <?php
                      foreach ($nilai as $nilai2) { 
                      echo form_open('operation/release');
                    ?>
                      <tr>
                      <td>
                        <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $nilai2['ID']; ?>" >

                        <input type="text" class="form-control" id="nospk" name="nospk" value="<?php echo $nilai2['NO_SPK']; ?>" readonly >
                        </td>
                        <td>
                        <input type="text" class="form-control" id="nomercont" name="nomercont" value="<?php echo $nilai2['NO_CONT']; ?>" readonly >
                        </td>
                        <td>
                        <input type="text" class="form-control" id="nodok" name="nodok" value="<?php echo $nilai2['NO_DOK']; ?>" readonly >
                        </td>
                        <td>
                        <input type="text" class="form-control" id="tgldok" name="tgldok" value="<?php echo $nilai2['TGL_DOK']; ?>" readonly >
                        </td>
                        <td>
                        <input type="text" class="form-control" id="jnsdok" name="jnsdok" value="<?php echo $nilai2['JNS_DOK']; ?>" readonly >
                        </td>
                        <td>
                        <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?php echo $nilai2['KETERANGAN']; ?>" readonly >
                        </td>
                        <td>
                        <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?php echo $nilai2['WARNA']; ?>" readonly >
                        </td>
                        <td>
                          <button id="str" type="submit"  class="btn btn-primary">Tombol Release</button>
                        </td>
                      </tr>
                      <?php 
                      echo form_close();
                      } ?>
                  </tbody>
                </table>
          </div>
     </div>