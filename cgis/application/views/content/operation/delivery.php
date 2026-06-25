
  <?php
    echo form_open('operation/search_delivery');
  ?>
  <div class="container">
    <!-- No Cont &nbsp;
    <i class="icon md-search" aria-hidden="true" ></i> --><br>
    <div class="form_group form_material">
      <div class="col-sm-3 col-md-3"  >
        <input style="border: 1px solid #a1a1a1;"  class="form-control" type="text" name="search_cont2" placeholder=" SEARCH NO CONT" autofocus required>
      </div>
      <div class="col-sm-1 col-md-1" >
        <button type="submit" class="btn btn-primary" style=" border:1px solid #a1a1a1;">SEARCH</button>
        <!-- <input type="submit" class="form-control"  value="search" style="border-radius:10px; border: 2px solid #a1a1a1;"> -->
      </div>
    </div>
  </div>
  <HR>
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
	 if(isset($status)){
		if ($status==5) {     
	echo form_open('operation/searchdelivery');
	?>
	  <div class="container">
		<br>
		<div class="form_group form_material">
			<div class="row">
			  <div class="col-md-12">
				<div class="radio">
				  <?php for ($i=0; $i <count($nilai) ; $i++) { ?>
					  <button type="submit" class="btn btn-primary" name="submitman2" value="<?php echo $nilai[$i]['NO_CONT'] ; ?>" style=" width:150px; border: 1px solid #a1a1a1; height: 35px"><?php echo $nilai[$i]['NO_CONT'] ; ?></button><br><br>
				  <?php } ?>
				</div>
			  </div>
			</div>
		</div>
	  </div>
	<?php
	echo form_close();
    }elseif ($status==1) { 
	echo form_open('operation/delivery');
	?>
         <div class="container">
           <div class="col-md-4 form-group">
                 <br><label for="No_cont">NO CONT</label>
                 <input type="text" class="form-control col-md-4 col-sm-4" id="Nocon" name="nomercont" value="<?php echo  $kontainer; ?>" readonly>
                 <br><br><br>
				 <br><label for="No_cont">UKURAN</label>
                 <input type="text" class="form-control col-md-4 col-sm-4" id="ukuran" name="ukuran" value="<?php echo $ukurane; ?>" readonly><br><br><br>
                  <br><label for="No_cont">NO TRUCK</label>
                 <input type="text" class="form-control col-md-4 col-sm-4" id="Nomtr" name="nomertruck" required ><br><br><br>
				  <br><label for="kond" >GATE</label>
					<div class="row">
						<div class=" col-md-12">
						  <select class="form-control" id="gate" name="gate">
							<option value="GATE 1">GATE 1</option>
							<option value="GATE 2">GATE 2</option>
							<option value="GATE 3">GATE 3</option>
							<option value="GATE 4">GATE 4</option>
							<option value="GATE 5">GATE 5</option>
							<option value="GATE 6">GATE 6</option>
						  </select>
						</div>
					</div>
                 <br><br>
                 <button type="submit" style=" width:150px; border: 1px solid #a1a1a1; height: 35px" class="btn btn-primary" >TRUCK IN</button>
           </div>
        </div>
<?php }elseif ($status==2) { 
echo form_open('operation/delivery');
?>
    <div class="container">
        <div class="col-md-4 form-group">
                 <br><label for="No_cont">NO CONT</label>
                 <input type="text" class="form-control col-md-4 col-sm-4" id="Nocon" name="nomercont" value="<?php echo  $kontainer; ?>" readonly><br><br><br><br>
				
              <label for="kond" >GATE</label>
              <div class="row">
                <div class=" col-md-12">
                  <select class="form-control" id="gate" name="gate">
                      <option value="GATE 1">GATE 1</option>
                      <option value="GATE 2">GATE 2</option>
					  <option value="GATE 3">GATE 3</option>
					  <option value="GATE 4">GATE 4</option>
					  <option value="TIDAK BOLEH GATE OUT">TIDAK BOLEH GATE OUT</option>
                  </select>
                </div>
              </div><br>
                 <button style=" width:150px; border: 1px solid #a1a1a1; height: 35px" id="str" type="submit"  class="btn btn-primary">GATE OUT</button>  
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
        
     </div>
     <!-- tutup else -->
<?php } } ?>
