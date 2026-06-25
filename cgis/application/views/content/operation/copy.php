<?php
  echo form_open('operation/search_copy');
?>
<div class="container">
<br>
  <div class="form_group form_material">
    <div class="col-sm-3 col-md-3"  >
      <input style="border: 1px solid #a1a1a1;"  class="form-control" type="text" name="search_cont" placeholder=" SEARCH NO CONT" autofocus required>
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
              KONTAINER : $NOCONT SUCCESS COPYYARD
           </div>";
           break;
         case 2:
           echo "
           <br>
           <div class= 'alert alert-danger' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
              KONTAINER : $NOCONT NOT FOUND
           </div>";
           break;
         case 3:
           echo "
           <br>
           <div class= 'alert alert-danger' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
               TIER SUDAH DIGUNAKAN
           </div>";
           break;
		 case 4:
           echo "
           <br>
           <div class= 'alert alert-danger' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
              LOKASI SUDAH DIGUNAKAN
           </div>";
           break;
		 case 5:
           echo "
           <br>
           <div class= 'alert alert-danger' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
              LOKASI TIDAK TERDAFTAR
           </div>";
           break;
		 case 6:
           echo "
           <br>
           <div class= 'alert alert-primary' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
             KONTAINER : $NOCONT BERHASIL DIPINDAHKAN KE BLOK SAMPAH
           </div>";
           break;
		 case 7:
           echo "
           <br>
           <div class= 'alert alert-danger' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
               KONTAINER : $NOCONT TIDAK DAPAT DIPINDAHKAN KE LOKASI $VARA ATAU $VARB
           </div>";
           break;  
          default:
            echo "
            <br>
            <div class= 'alert alert-danger' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
               KONTAINER : $NOCONT NOT FOUND
            </div>";
            break;
        } ?>
      <?php endif ?>
</div>
  <?php
  if(isset($status)){
    if ($status==2) {
    echo form_open('operation/search_copyard');
  ?>
  <div class="container">
    <br>
    <div class="form_group form_material">
        <div class="row">
          <div class="col-md-12">
            <div class="radio">
             <?php for ($i=0; $i <count($nilai) ; $i++) { ?>
                  <button type="submit" class="btn btn-primary" name="submitman" value="<?php echo $nilai[$i]['NO_CONT'] ; ?>" style=" width:150px; border: 1px solid #a1a1a1; height: 35px"><?php echo $nilai[$i]['NO_CONT'] ; ?></button><br><br>
              <?php } ?>
            </div>
          </div>
        </div>
    </div>
  </div>

  <?php
  echo form_close();
    }elseif ($status==1) {
     echo form_open('operation/copy');
  ?>
      <div class="container">
        <div class=" col-md-4 form-group">
              <label for="No_cont" >NO CONT</label>
              <div class="row">
                <div class=" col-md-12">
                  <input type="text" class="form-control" id="No_cont" name="nomerkon" value="<?php echo $nilai['NO_CONT']; ?> " readonly><br>
                </div>
              </div>
			  
			   <label for="ukr_cont" >UKURAN CONT</label>
              <div class="row">
                <div class=" col-md-12">
                  <input type="text" class="form-control" id="ukr_cont" name="ukurankon" value="<?php echo $nilai['UKR_CONT']; ?> " readonly><br>
                </div>
              </div>
			  
			  <label for="jns_dok" >JENIS DOKUMEN</label>
              <div class="row">
                <div class=" col-md-12">
                  <input type="text" class="form-control" id="jns_dok" name="jns_dok" value="<?php echo $nilai['NAMA']; ?> " readonly><br>
                </div>
              </div>
			  
			  <label for="status_cont" >STATUS CONT</label>
              <div class="row">
                <div class=" col-md-12">
                  <input type="text" class="form-control" id="status_cont" name="status_cont" value="<?php echo $nilai['KETERANGAN']; ?> " readonly><br>
                </div>
              </div>

              <label for="nolok" >LOKASI</label>
              <div class="row">
                <div class=" col-md-12">
                  <input type="text" class=" form-control" id="nolok" name="nolok" value="<?php 
				  if($nilai['LOKASI']=='SAMPAH'){
					  echo $nilai['LOKASI'];
				  }else{
					  echo $nilai['LOKASI'].'0'.$nilai['TIER']; 
				  }
				  ?> " readonly>
                </div>
              </div>
			  
			  <br><label for="lokbar" >ACTION BLOK</label>
              <div class="row">
                <div class=" col-md-12">
					<select class="form-control" id="mySelect" name="mySelect" onchange="myFunction()">
						<option value="satu">BLOK LAPANGAN
						<option value="dua">BLOK SAMPAH
					</select>
                </div>
              </div>
			  
			  <br><label for="lokbar" >LOKASI BARU</label>
              <div class="row">
                <div class=" col-md-12">
                  <input type="text" class=" form-control" id="lokbar" name="lokbar" required>
                </div>
              </div>
						   <div class="row">
							<div class="col-md-12">
							  <br><button type="submit" class="btn btn-primary" style="border: 1px solid #a1a1a1;">COPYARD</button>
							</div>
						  </div>
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
        case 2:
          echo "<br>
          <div class= 'alert alert-danger' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
             WARNING ! NO CONT : $nilai TIDAK DAPAT DIPINDAHKAN KARENA STATUS SPK ANNOUNCE
          </div>";
          break;
        case 3:
          echo "<br>
          <div class= 'alert alert-danger' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
             WARNING ! NO CONT : $nilai TIDAK DAPAT DIPINDAHKAN KARENA STATUS SPK PICKUP
          </div>";
          break;
        case 4:
          echo "<br>
          <div class= 'alert alert-danger' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
             WARNING ! NO CONT : $nilai TIDAK DAPAT DIPINDAHKAN KARENA STATUS HOLD
          </div>";
          break;
        case 5:
          echo "<br>
          <div class= 'alert alert-danger' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
             WARNING ! NO CONT : $nilai TIDAK DAPAT DIPINDAHKAN KARENA STATUS BEHANDLE IN
          </div>";
          break;
		    case 6:
          echo "<br>
          <div class= 'alert alert-danger' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
             WARNING ! LOKASI TELAH DIGUNAKAN OLEH NO CONT : $NOCONT
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

<script>
function myFunction() {
    var x = document.getElementById("mySelect").value;
	if(x=="dua"){
		var y= document.getElementById("lokbar");
		y.value="SAMPAH";
		y.disabled="true";
	}else{
		var y= document.getElementById("lokbar");
		y.value="";
		y.disabled="";
	}
    
}
</script>
