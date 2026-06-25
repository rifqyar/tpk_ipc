<!-- konten -->
<div class="container">
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
       <label for="No_spk" >NO SPK</label>
       <input style="border-radius:10px; border: 2px solid #a1a1a1;"  class="form-control" type="text" id="No_spk" name="nomerspk" maxlength="6">
       <div class="alert-danger">
       <p><?php echo validation_errors();?></p>
     </div class="col-sm-1 col-md-1" >
       <button type="submit" class="btn btn-primary" style="border-radius:10px; border: 2px solid #a1a1a1;">Hold</button>
     </div> <?php echo form_close(); ?>
</div>
<!-- end konten -->
