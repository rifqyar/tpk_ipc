<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets2/style.css?v13">
<?php
echo form_open('operation/search_behandle_new');
?>
<div class="container">
  <a href="<?php echo site_url('operation/opr'); ?>">
   <H4 style="color:white;"><< MENU HANDHELD</H4>
 </a>
 <br>
 <H5 style="color:white;">BEHANDLE IN</H5><br>
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
    echo form_open('operation/search_behandlein_new');
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
     echo form_open('operation/behandlein_new');
      // foreach ($nilai as $nilai2) {
     ?>
     <div class="container">
      <div class=" col-md-12 form-group">
        <label style="color:white;" for="No_cont">NO CONT</label>
        <div class="row">
          <div class=" col-sm-5">
            <input type="hidden" class="form-control" id="id_request" name="id_request" value="<?php echo $nilai['ID_REQUEST']; ?>">
            <a href=""></a><input type="text" class="form-control" id="No_cont" name="nomerkon" value="<?php echo $nilai['NO_CONT']; ?>" required="required" readonly><br>
          </div>
        </div>
        <label style="color:white;" for="No_cont">NO SPK</label>
        <div class="row">
          <div class=" col-sm-5">
            <a href=""></a><input type="text" class="form-control" id="nospk" name="nospk" value="<?php echo $nilai['NO_SPK']; ?>" required="required" readonly><br>
          </div>
        </div>
        <label style="color:white;" for="Iso_code">ISO CODE</label>
        <div class="row">
          <div class=" col-sm-5">
            <input type="text" class="form-control" id="Iso_code" name="isocode" maxlength="4" required >
          </div>
        </div>
        <br>
        <label style="color:white;">KONDISI SEAL</label>
        <div class="row">
          <div class=" col-md-12">
            <div class="radio" >
              <label style="color:white;"><input type="radio" name="optradio" value="ada" checked >ADA</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <label style="color:white;"><input type="radio" name="optradio" value="tidak ada">TIDAK ADA</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <!-- <label><input type="radio" name="optradio" value="rusak">RUSAK</label> -->
            </div>
          </div>
        </div>
        <label style="color:white;" for="No_segel">NO SEAL</label>
        <div class="row">
          <div class=" col-sm-5">
            <input type="text" class="form-control" id="No_seal" name="noseal" required>
          </div>
        </div>
        <br>
        <label style="color:white;" for="kond">KONDISI KONTAINER</label>
        <div class="row">
          <div class=" col-sm-5">
            <select class="form-control" id="kond" name="kondisi" required>
              <option value="">KONDISI KONTAINER</option>
              <?php
              foreach ($kondisi->result() as $row) {
                ?>
                <option value="<?php echo $row->ID ?>"><?php echo $row->KONDISI ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <br>
        <label style="color:white;" for="trucknya">TID</label>
        <div class="row">
          <div class=" col-sm-5">
            <select class="form-control" id="trucknya" name="trucknya" required>
              <option value="<?php echo $nilai['ID_FLAT']; ?>"><?php echo $nilai['ID_FLAT']; ?></option>
              <?php
              foreach ($truck->result() as $rownya) {
                ?>
                <option value="<?php echo $rownya->NO_TRUCK ?>"><?php echo $rownya->NO_TRUCK?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <br>
        <label style="color:white;" for="lok_awal">LOKASI</label>
        <div class="row">
          <div class=" col-sm-5">
            <input type="text" class=" form-control" id="nolok" name="nolok" value="<?php $loknya=trim($nilai['LOKASI']); echo $loknya;?>" required="required">
          </div>
        </div>
        <br>
        <label style="color:white;">STATUS KONTAINER</label>
        <div class="row">
          <div class=" col-md-12">
            <div class="radio" >
              <label style="color:white;"><input type="radio" name="optradiostatus" value='{ "key1": "FL", "key2": "F"}' checked >FULL</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <label style="color:white;"><input type="radio" name="optradiostatus" value='{ "key1": "M", "key2": "E"}'>EMPTY</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <!-- <label><input type="radio" name="optradio" value="rusak">RUSAK</label> -->
            </div>
          </div>
        </div>
        <br>
        <label style="color:white;" for="trucknya">UKURAN</label>
        <div class="row">
          <div class=" col-sm-5">
            <select class="form-control" id="ukuran" name="ukuran" required aria-required="true">
              <option value="<?php echo $nilai['UKR_CONT']; ?>">
                <?php echo $nilai['UKR_CONT']; ?>
              </option> 
              <option value="20">20</option>
              <option value="40">40</option>
              <option value="45" >45</option>
            </select>
          </div>
        </div>
        <br>
        <label style="color:white;" for="trucknya">TYPE CONTAINER</label>
        <div class="row">
          <div class=" col-sm-5">
            <select class="form-control" id="tipe" name="tipe" required aria-required="true">
              <option value="<?php echo $nilai['TIPE_CONT']; ?>">
                <?php echo $nilai['TIPE_CONT']; ?>
              </option>
              <option value="DRY">DRY</option>
              <option value="HQ">HQ</option>
              <option value="OVD" >OVD</option>
              <option value="TNK">TNK</option>
              <option value="OT">OT</option>
              <option value="RFR">RFR</option>
            </select>
          </div>
        </div>
        <br>
        <label style="color:white;" for="trucknya">LABEL</label>
        <div class="row">
          <div class=" col-sm-5">
            <select class="form-control" id="test" name="test">
              <?php 
              if ($nilai['FL_DG'] == 'Y') {
                $slctd = 'selected';
              }else {
                $slctd = '-';
              }
              if ($nilai['IMO'] != '') {
                echo "	<option value='DG' ".$slctd.">DG</option>
                <option value=''>NON DG</option>
                <option value='DGNL'>DG NON LABEL</option>";
              }else{
                echo "	<option value=''>NON DG</option>
                <option value='DG' ".$slctd.">DG</option>
                <option value='DGNL'>DG NON LABEL</option>";
              }
              ?>
            </select> 
          </div>
        </div>
        <br>
        <br><label style="color:white;" for="note"><b><h4>INFORMASI ALAT:</h4></b></label>
        <br>
        <br>
        <input type="hidden" class="form-control" id="nocont" name="nocont" value="<?php echo $nilai['NO_CONT']; ?>"  readonly>
        <input type="hidden" class="form-control" id="idJobSlip" name="idJobSlip" value="<?php echo $DataDetails->ID_JOB_SLIP; ?>"  readonly>
        <input type="hidden" class="form-control" id="idbehandlein" name="idbehandlein" value="<?php echo $DataDetails->ID_BEHANDLE_IN; ?>"  readonly>
        <div class="row">
         <div class="col-sm-3">
          <div class="form-group">
            <label style="color:white;" for="lokak">Jenis Pekerjaan</label>
            <select class="form-control" id="jenisPekerjaan" name="jenisPekerjaan">  
             <option selected value="1">LIFT OFF YARD - PRE</option>
             <option value="0">Tidak Ada Kegiatan</option>
           </select>
         </div>
         <div>
         </div>

       </div>

       <!-- ALAT -->
       <div class="col-sm-3">
        <div class="form-group">
          <label style="color:white;" for="lokak">Alat</label>
          <select class="form-control" id="alat" name="alat">

            <option value="">---Pilih Alat---</option>
            <?php foreach ($DropDwonAlat->result_array() as $row): ?>
              <option value="<?php echo $row['ID']; ?>"><?php echo $row['NM_ALAT']; ?></option>
              <?php echo form_close(); endforeach; ?>
            </select>
          </div>
        </div>

        <datalist id="operator" name="operator">
         <?php foreach ($DropDwonOperator->result_array() as $row): ?>
          <option value="<?php echo $row['ID']; ?>"><?php echo $row['NAMA']; ?></option>
          <?php echo form_close(); endforeach; ?>
        </datalist>

        <div class="col-sm-3">
          <div class="form-group">
            <label style="color:white;" for="lokak">Operator</label><br>
            <input  autoComplete="on" list="operator" name="operator" /> 
          </div>
        </div>
        <!-- <div class="col-sm-3">
          <div class="form-group">
            <label style="color:white;" for="lokak">Intensitas Penggunaan Alat</label>
            <div class="input-group">
              <input type="text" class="form-control" id="penggunaan1" name="penggunaan1" value="1" autocomplete="off">
            </div>
          </div>
        </div> -->
      </div>
      <!-- ALAT END -->

    </div>
    <div class="col-sm-12">
      <div class="form-group">
        <button type="submit"  class="btn btn-primary">Simpan</button>
      </div>
    </div> 

    <br>
    <div class="container">

    </div>


    <?php if ($this->session->flashdata('pesan')): ?>
      <script>
        setTimeout(function() {
          alert("<?php echo $this->session->flashdata('pesan'); ?>");
        }, 1000); // waktu delay dalam milidetik (dalam contoh ini 1 detik)
      </script>
    <?php endif; ?>
    <!-- tutup foreach -->
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
  