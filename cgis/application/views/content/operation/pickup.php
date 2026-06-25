<!-- konten -->
<?php
  echo form_open('operation/search_pickup');
?>
<div class="container">
  <br>
  <div class="form_group form_material">
    <div class="col-sm-3 col-md-3"  >
      <input style="border: 1px solid #a1a1a1;"  class="form-control" type="text" name="search_spk" placeholder=" SEARCH NO SPK" autofocus required>
    </div>
    <div class="col-sm-1 col-md-1" >
      <button type="submit" class="btn btn-primary" style="border: 1px solid #a1a1a1;">SEARCH</button>
    </div>
  </div>
</div>
<HR>
<?php
  echo form_close();
?>
     <?php if (isset($notif)): ?>
       <?php switch ($notif) {
         case 1:
           echo "<br>
           <div class= 'alert alert-primary' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
              NO SPK : $NOSPK SUCCESS PICK UP
           </div>";
           break;
         case 2://already
           echo "<br>
           <div class= 'alert alert-danger' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
              WARNING ! NO SPK : $NOSPK NOT FOUND
           </div>";
           break;
         case 3://already
           echo "<br>
           <div class= 'alert alert-danger' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
              WARNING ! NO SPK : $NOSPK BELUM ANNCOUNCE
           </div>";
           break;
		      case 4://already
           echo "<br>
           <div class= 'alert alert-danger' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
              WARNING ! NO SPK : $NOSPK , TERDAPAT KONTAINER DI BLOK SAMPAH
           </div>";
           break;  
         default:
           echo "<br>
           <div class= 'alert alert-danger' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
              WARNING ! NO SPK : $NOSPK NOT FOUND
           </div>";
           break;
       } ?>
     <?php endif ?>

	 
	 
	 
	 
	 
     <?php
     echo form_open('operation/pickup');
	 if(isset($status)){
     if ($status==1) { ?>
         <div class="container">
           <div class="col-md-4 form-group">
                 <label for="No_cont">NO SPK</label>
                 <input type="text" class="form-control" id="No_spk" name="nomerspk" value="<?php echo $spk; ?>" readonly><br>
                <table>
                  <tr>
                    <th>
                      NO KONTAINER
                    </th>
                    <th class="col-md-1">
                      UKURAN
                    </th>
					<th>
                      NOMER TRUCK
                    </th>
                  </tr>
                  <?php for ($i=0; $i < $totale; $i++) { ?>
                    <tr>
                      <td>
                        <H6><input type="text" class="form-control" value="<?php echo $nilai[$i]['NO_CONT']; ?>" readonly></H6>
                      </td>
                      <td>
                        <H6><input type="text" class="form-control" value="<?php echo $nilai[$i]['UKR_CONT']; ?>" readonly></H6>
                      </td>
                      <td>
                        <select class="form-control" id="kond" name="<?php echo "idflat".$i ?>" required>
                            <option required value="">NONE</option>
                            <?php
                                foreach ($kondisi->result() as $row) {
                            ?>
                              <option value="<?php echo $row->NO_TRUCK ?>"> <?php echo $row->NO_TRUCK ?> </option>
                            <?php } ?>
                        </select>
                      </td>
                    </tr>
                  <?php  } ?>
                </table>
                  <br>
                 <button style=" width:150px; border: 1px solid #a1a1a1; height: 35px" id="str" type="submit"  class="btn btn-primary">PICKUP</button>
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
                WARNING ! $spk NOT FOUND
             </div>";
             break;
           default:
             echo "";
             break;
         } ?>
       <?php endif ?>
     </div>
     <!-- tutup else -->
<?php } }?>
<!-- end konten -->
