
  <?php
    echo form_open('operation/searchdeliv');
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
    <?php if (isset($notif)): ?>
      <?php switch ($notif) {
        case 1:
          echo "<br>
          <div class= 'alert alert-primary' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
             NO CONT : $NOCONT SUCCESS TRUCK IN
          </div>";
          break;
        case 2:
          echo "<br>
          <div class='alert alert-primary' style='font-size:16px; font-family:sant-serif; font-weight:bold; '>
              NO CONT : $NOCONT SUCCESS GATE OUT
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
  echo form_close();
     echo form_open('operation/delive');
     if ($status==1) { ?>
         <div class="container">
           <div class="col-md-4 form-group">
                 <br><label for="No_cont">NO CONT</label>
                 <input type="text" class="form-control col-md-4 col-sm-4" id="Nocon" name="nomercont" value="<?php echo $kontainer; ?>" readonly>
                 <br><br><br><br>
                 <label for="No_cont">NO TRUCK</label>
                 <input type="text" class="form-control col-md-4 col-sm-4" id="Nomtr" name="nomertruck" required >
                 <br><br><br><br>
                 <button type="submit" style=" width:150px; border-radius:5px; border: 2px solid #a1a1a1; height: 35px" class="btn btn-primary" >TRUCK IN</button>
           </div>
        </div>    
<?php }elseif ($status==2) { ?>
    <div class="container">
        <div class="col-md-4 form-group">
                 <br><label for="No_cont">NO CONT</label>
                 <input type="text" class="form-control col-md-4 col-sm-4" id="Nocon" name="nomercont" value="<?php echo $kontainer; ?>" readonly><br><br><br><br>
                 <button style=" width:150px; border-radius:5px; border: 2px solid #a1a1a1; height: 35px" id="str" type="submit"  class="btn btn-primary">GATE OUT</button>  
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
                        WARNING ! NO CONT : $kontainer NOT FOUND
                     </div>";
                     break;
                   default:
                     echo "";
                     break;
                 } ?>
            <?php endif ?>
        <div class="col-md-4 form-group">
                <br><label for="No_cont">NO CONT</label>
                <input type="text" class="form-control col-md-4 col-sm-4" id="Nocon" name="nomercont" readonly>
        </div>            
     </div>
     <!-- tutup else -->
<?php } ?>    




