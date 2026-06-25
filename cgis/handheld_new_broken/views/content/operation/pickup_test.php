<!-- konten -->
<style>
  #loader {
  position: absolute;
  left: 50%;
  top: 50%;
  z-index: 1;
  width: 150px;
  height: 150px;
  margin: -75px 0 0 -75px;
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid blue;
  border-right: 16px solid green;
  border-bottom: 16px solid red;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Add animation to "page content" */
.animate-bottom {
  position: relative;
  -webkit-animation-name: animatebottom;
  -webkit-animation-duration: 1s;
  animation-name: animatebottom;
  animation-duration: 1s
}

@-webkit-keyframes animatebottom {
  from { bottom:-100px; opacity:0 } 
  to { bottom:0px; opacity:1 }
}

@keyframes animatebottom { 
  from{ bottom:-100px; opacity:0 } 
  to{ bottom:0; opacity:1 }
}
</style>
<?php
  echo form_open('Operation_Behandle/search_pickup_test');
?>
<div class="container">
<a href="<?php echo site_url('Operation_Behandle/opr'); ?>">
	<H4 style="color:white;"><< MENU HANDHELD</H4>
</a>
  <br>
	<H5 style="color:white;">PICK UP</H5><br>
  <div class="form_group form_material">
    <div class="col-sm-3 col-md-3"  >
      <input style="border: 1px solid #a1a1a1;"  class="form-control" type="text" name="search_spk" placeholder=" SEARCH NO SPK" autofocus required>
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
     //echo form_open('operation/pickup');
	 if(isset($status)){
     if ($status==1) { ?>
         <div class="container">
           <div class="col-md-4 form-group">
                 <label style="color:white;" for="No_cont">NO SPK</label>
                 <input type="text" class="form-control" id="No_spk" name="nomerspk" value="<?php echo $spk; ?>" readonly><br>
                <table>
                  <tr>
                    <th>
                      <H6 style="color:white;">NO KONTAINER</H6>
                    </th>
                    <th class="col-md-1">
                      <H6 style="color:white;">UKURAN</H6>
                    </th>
					<th>
                      <H6 style="color:white;">NOMER TRUCK</H6>
                    </th>
                    <th>
                      <H6 style="color:white;">STATUS</H6>
                    </th>
                  </tr>
                  <?php for ($i=0; $i < $totale; $i++) { ?>
                    <tr>
                      <td>
                        <H6 style="color:white;"><input type="text" class="form-control" value="<?php echo $nilai[$i]['NO_CONT']; ?>" readonly></H6>
                      </td>
                      <td>
                        <H6 style="color:white;"><input type="text" class="form-control" value="<?php echo $nilai[$i]['UKR_CONT']; ?>" readonly></H6>
                      </td>
                      <td>
                        <select class="form-control" id="kond<?php echo $nilai[$i]['NO_CONT']; ?>" name="<?php echo "idflat".$i ?>" required>
                            <option required value="">NONE</option>
                            <?php
                                foreach ($kondisi->result() as $row) {
                            ?>
                              <option value="<?php echo $row->NO_TRUCK ?>" <?php if ($nilai[$i]['ID_FLAT'] == $row->NO_TRUCK) {echo 'selected';}?>> <?php echo $row->NO_TRUCK ?> </option>
                            <?php } ?>
                        </select>
                      </td>
                      <td id="fl_send_npct1"><?php

                        if ($nilai[$i]['STATUS_CONT'] == '100'&& $nilai[$i]['FL_SEND_NPCT1'] == 'N') {
                           echo '<a class="btn btn-primary sendingnpct1 '.$nilai[$i]['NO_CONT'].'" data-cont="'.$nilai[$i]['NO_CONT'].'" data-nomerspk="'.$spk.'" id="send">Send</a>';
                        }else if ($nilai[$i]['STATUS_CONT'] == '100'&& $nilai[$i]['FL_SEND_NPCT1'] == 'Y'){
                          echo '<a class="btn btn-success '.$nilai[$i]['NO_CONT'].'" style="display: inherit;">S</a><a class="btn btn-primary pik'.$nilai[$i]['NO_CONT'].'" data-cont="'.$nilai[$i]['NO_CONT'].'" data-nomerspk="'.$spk.'" id="pickupajax" style="display: inherit;">Pickup</a>';
                        }else{
                          echo '<a class="btn btn-success '.$nilai[$i]['NO_CONT'].'" style="display: inherit;">S</a><a class="btn btn-success '.$nilai[$i]['NO_CONT'].'" style="display: inherit;">P</a>';
                        }

                      ?></td>
                    </tr>
                  <?php  } ?>
                </table>
                  <br>
                 <!-- <button style=" width:150px; border: 1px solid #a1a1a1; height: 35px" id="str" type="submit"  class="btn btn-primary">PICKUP</button> -->
           </div>
         </div>
    <?php ?>
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
   <?php } } ?>
<!-- end konten -->
<div id="loader" style="display: none;"></div>

