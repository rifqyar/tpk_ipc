<!-- konten -->
<div class="container">
<a href="<?php echo site_url('operation/opr'); ?>">
	<H4 style="color:white;"><< MENU HANDHELD</H4>
</a>
  <br>
	<H5 style="color:white;">HOLD</H5><br>
      <?php if (isset($notif)): ?>
        <?php switch ($notif) {
          case 1:
          echo "<br>
          <div class= 'alert alert-primary' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
             NO SPK : $NOSPK SUCCESS HOLD
          </div>";
           break;
         case 2:
         echo "<br>
         <div class= 'alert alert-danger' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
            WARNING !  NO SPK : $NOSPK NOT FOUND
         </div>";
           break;
         case 3:
         echo "<br>
         <div class= 'alert alert-danger' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
              WARNING !  NO SPK : $NOSPK NOT FOUND
         </div>";
           break;
          default:
          echo "<br>
          <div class= 'alert alert-danger' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
               WARNING !  NO SPK : $NOSPK NOT FOUND
          </div>";
            break;
        } ?>
      <?php endif ?>
   <?php
      echo form_open('operation/hold');
   ?>
     <div class="col-sm-3 col-md-3" ">
       <label for="No_spk" style="color:white;" >NO SPK</label>
       <input style=" border: 1px solid #a1a1a1;"  class="form-control" type="text" id="No_spk" name="nomerspk" maxlength="6">
       <div class="alert-danger">
       <p><?php echo validation_errors();?></p>
     </div class="col-sm-1 col-md-1" >
       <button type="submit" class="btn btn-primary" style="border: 1px solid #a1a1a1;">HOLD</button>
     </div>
 <?php echo form_close(); ?>
</div>
<hr>
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
                          <select class="form-control" id="warna" name="warna" required aria-required="true" readonly>
                            <option value="<?php echo $nilai2['WARNA']; ?>"><?php echo $nilai2['WARNA']; ?>
						                </option>
                          </select>
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
</div>    
<!-- end konten -->
