<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets2/style.css?v13">
<div class="container">

  <a href="<?php echo site_url('operation/marshallingyard'); ?>"><H4 style="color:white;"><< MENU MARSHALLING YARD</H4></a>
  <br>
  
  <br>
  <!-- <H5 style="color:white;">MARSHALLING</H5> -->
  <div class="container">
    <div class=" col-md-12 form-group">
      <label style="color:white;" for="note"><b><h4>MARSHALLING YARD:</h4></b><p></label>
        <br>
        <form  action="<?php echo site_url('operation/Insertmarshallingkontainer'); ?>" method="post">

          <label style="color:white;" for="nocont">No Kontainer</label>
          <div class="row">
            <div class=" col-sm-6">
              <input type="text" class="form-control" id="nocont" name="nocont" value="<?php echo $DataDetails->NO_CONT; ?>" required="required" readonly><br>
              <input type="hidden" class="form-control" id="spk" name="spk" value="450" required="required" readonly><br>


            </div>
          </div>

          <label style="color:white;" for="ukrcont">Ukuran</label>
          <div class="row">
            <div class=" col-sm-6">
              <input type="text" class="form-control" id="ukrcont" name="ukrcont" value="<?php echo $DataDetails->UKR_CONT; ?>" maxlength="4" readonly >
            </div>
          </div>

          <br><label style="color:white;" for="lokaw">Lokasi Awal</label>
          <div class="row">
            <div class=" col-sm-6">
              <input type="text" class="form-control" id="lokaw" name="lokaw" value="<?php echo $DataDetails->LOKASI_AWAL.'0'.$DataDetails->TIER_AWAL ; ?>" maxlength="4" readonly >
            </div>
          </div>
          <br>
          <label style="color:white;" for="lokak">Lokasi Akhir</label>
          <div class="row">
            <div class=" col-sm-6">
              <input type="text" class="form-control" id="lokak" name="lokak" value="<?php echo $DataDetails->LOKASI_AKHIR.'0'.$DataDetails->TIER_AWAL; ?>" readonly>
            </div>
          </div>
          <br>
          <label style="color:white;" for="lokak">JOB</label>
          <div class="row">
            <div class=" col-sm-6">
              <input type="text" class="form-control" id="job" name="job" value="<?php echo $DataDetails->JENIS; ?>" readonly>
            </div>
          </div>
          <br>
          <label style="color:white;" for="lokak">NOTE</label>
          <div class="row">
            <div class=" col-sm-6">
              <input type="text" class="form-control" id="note" name="note">
            </div>
          </div>

          <br><label style="color:white;" for="respon">Respon</label>
          <div class="row">
            <div class=" col-sm-6">
              <?php
              if($DataDetails->RESPON == 'NULL' || $DataDetails->RESPON ==''){
                $RESPON = "NO RESPON";
              }else{
                $RESPON = $DataDetails->RESPON;
              }
              ?>
              <input type="text" class="form-control" id="respon" name="respon" value="<?php echo $RESPON ?>" readonly>
              <br>
            </div>
          </div>
          <br>
          <br>
          <br><label style="color:white;" for="note"><b><h4>INFORMASI ALAT:</h4></b></label>
          <br>
          <br>
          <input type="hidden" class="form-control" id="idJobSlip" name="idJobSlip" value="<?php echo $DataDetails->ID_JOB_SLIP; ?>"  readonly>
          <div class="row">
            <div id="education_fields"></div>
            <div class="col-sm-3">
              <div class="form-group">
                <label style="color:white;" for="lokak">Jenis Pekerjaan</label>
                <select class="form-control" id="jenispekerjaan1" name="jenispekerjaan1">
                  <option selected value="7">LIFT OFF STAGGER - YARD</option>
                  <option value="9">LIFT ON DELIVERY</option>
                  <option value="0">Tidak Ada Kegiatan</option>
                </select>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label style="color:white;" for="lokak">Alat</label>
                <select class="form-control" id="alat1" name="alat1">

                 <option value="">---Pilih Alat---</option>
                 <?php foreach ($DropDwonAlat->result_array() as $row): ?>
                  <option value="<?php echo $row['ID']; ?>"><?php echo $row['NM_ALAT']; ?></option>
                  <?php  endforeach; ?>
                </select>
              </div>
            </div>

            <datalist id="operator1" name="operator1">
             <?php foreach ($DropDwonOperator->result_array() as $row): ?>
              <option value="<?php echo $row['ID']; ?>"><?php echo $row['NAMA']; ?></option>
              <?php endforeach; ?>
            </datalist>

            <div class="col-sm-3">
              <div class="form-group">
                <label style="color:white;" for="lokak">Operator</label><br>
                <input style="color:black;" autoComplete="on" list="operator1" name="operator1" /> 
              </div>
            </div>
            <!-- <div class="col-sm-3">
              <div class="form-group">
                <label style="color:white;" for="lokak">Intensitas Penggunaan Alat</label>
                <div class="input-group">
                  <input type="number" class="form-control" id="penggunaan1" name="penggunaan1" value="1" autocomplete="off">
                </div>
              </div>
            </div> -->
          </div>
          <div class="row">
            <div id="education_fields"></div>
            <div class="col-sm-3">
              <div class="form-group">
                <label style="color:white;" for="lokak">Jenis Pekerjaan</label>
                <select class="form-control" id="jenispekerjaan2" name="jenispekerjaan2">
                  <option selected value="6">HAULAGE - YARD</option>
                  <option value="0">Tidak Ada Kegiatan</option>
                </select>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                 <label style="color:white;" for="lokak">Truck</label>
                  <select class="form-control" id="truck1" name="truck1">

                   <option value="">---Pilih Truck---</option>
                   <?php foreach ($DropDwonTruck->result_array() as $row): ?>
                    <option value="<?php echo $row['ID_TRUCK']; ?>"><?php echo $row['NO_TRUCK']; ?></option>
                    <?php  endforeach; ?>
                  </select>
              </div>
            </div>
            <datalist id="operator2" name="operator2">
             <?php foreach ($DropDwonOperator->result_array() as $row): ?>
              <option value="<?php echo $row['ID']; ?>"><?php echo $row['NAMA']; ?></option>
              <?php  endforeach; ?>
            </datalist>

            <div class="col-sm-3">
              <div class="form-group">
                <label style="color:white;" for="lokak">Operator</label><br>
                <input style="color:black;" autoComplete="on" list="operator2" name="operator2" /> 
              </div>
            </div>
            <!-- <div class="col-sm-3">
              <div class="form-group">
                <label style="color:white;" for="lokak">Intensitas Penggunaan Alat</label>
                <div class="input-group">
                  <input type="number" class="form-control" id="penggunaan2" name="penggunaan2" value="1" autocomplete="off">
                </div>
              </div>
            </div> -->
          </div>
          <div class="row">
            <div id="education_fields"></div>
            <div class="col-sm-3">
              <div class="form-group">
                <label style="color:white;" for="lokak">Jenis Pekerjaan</label>
                <select class="form-control" id="jenispekerjaan3" name="jenispekerjaan3">
                  <option selected value="7">LIFT OF HAULAGE - YARD</option>
                  <option value="0">Tidak Ada Kegiatan</option>
                </select>
              </div>
            </div>  
            <div class="col-sm-3">
              <div class="form-group">
                <label style="color:white;" for="lokak">Alat</label>
                <select class="form-control" id="alat3" name="alat3">

                 <option value="">---Pilih Alat---</option>
                 <?php foreach ($DropDwonAlat->result_array() as $row): ?>
                  <option value="<?php echo $row['ID']; ?>"><?php echo $row['NM_ALAT']; ?></option>
                  <?php  endforeach; ?>
                </select>
              </div>
            </div>
            <datalist id="operator3" name="operator3">
             <?php foreach ($DropDwonOperator->result_array() as $row): ?>
              <option value="<?php echo $row['ID']; ?>"><?php echo $row['NAMA']; ?></option>
              <?php  endforeach; ?>
            </datalist>

            <div class="col-sm-3">
              <div class="form-group">
                <label style="color:white;" for="lokak">Operator</label><br>
                <input style="color:black;" autoComplete="on" list="operator3" name="operator3" /> 
              </div>
            </div>
            <!-- <div class="col-sm-3">
              <div class="form-group">
                <label style="color:white;" for="lokak">Intensitas Penggunaan Alat</label>
                <div class="input-group">
                  <input type="number" class="form-control" id="penggunaan3" name="penggunaan3" value="1" autocomplete="off">
                </div>
              </div>
            </div> -->


            <div class="col-sm-12">
              <div class="form-group">
                <br>
                <button type="submit"  class="btn btn-primary">Simpan</button>
              </div>
            </div> 


          </from>
          <br>
          <div class="container">

          </div>

        </div>

      </div>
    </div>
    <script>


    </script>

    <?php if ($this->session->flashdata('pesan')): ?>
      <script>
        setTimeout(function() {
          alert("<?php echo $this->session->flashdata('pesan'); ?>");
        }, 1000); // waktu delay dalam milidetik (dalam contoh ini 1 detik)
      </script>
    <?php endif; ?>
<!-- tutup foreach -->