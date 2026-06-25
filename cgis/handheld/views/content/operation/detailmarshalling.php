<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets2/style.css?v13">
<div class="container">
  
  <a href="<?php echo site_url('operation/marshallingkontainer'); ?>"><H4 style="color:white;"><< MENU MARSHALLING KONTAINER</H4></a>
  <br>
  
  <br>
  <!-- <H5 style="color:white;">MARSHALLING</H5> -->
  <div class=" col-md-12 form-group">
    <label style="color:white;" for="note"><b><h4>MARSHALLING KONTAINER:</h4></b><p></label>
      <br>
      <form  action="<?php echo site_url('operation/Insertmarshallingkontainer'); ?>" method="post">
      
      <label style="color:white;" for="nocont">No Kontainer</label>
      <div class="row">
        <div class=" col-sm-6">
          <input type="text" class="form-control" id="nocont" name="nocont" value="<?php echo $DataDetails->NO_CONT; ?>" required="required" readonly><br>
          

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
        <div class=" col-md-6">
          <input type="text" class="form-control" id="lokaw" name="lokaw" value="<?php echo $DataDetails->LOKASI_AWAL.'0'.$DataDetails->TIER_AWAL ; ?>" maxlength="4" readonly >
        </div>
      </div>
      <br>
      <label style="color:white;" for="lokak">Lokasi Akhir</label>
      <div class="row">
        <div class=" col-md-6">
          <input type="text" class="form-control" id="lokak" name="lokak" value="<?php echo $DataDetails->LOKASI_AKHIR.'0'.$DataDetails->TIER_AWAL; ?>" readonly>
        </div>
      </div>
      <br>
      <label style="color:white;" for="lokak">JOB</label>
      <div class="row">
        <div class=" col-md-6">
          <input type="text" class="form-control" id="job" name="job" value="<?php echo $DataDetails->JENIS; ?>" readonly>
        </div>
      </div>
      <br>
      <label style="color:white;" for="lokak">NOTE</label>
      <div class="row">
        <div class=" col-md-6">
          <input type="text" class="form-control" id="note" name="note">
        </div>
      </div>

      <br><label style="color:white;" for="respon">Respon</label>
      <div class="row">
        <div class=" col-md-6">
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
       <label style="color:white;" for="lokak">Status SPK</label>
              <div class="row">
                <div class=" col-sm-6">
            
                  <select class="form-control" name="statusspk">
                      <option value="450">STACKING YARD</option>
                      <option value="460">STACKING CIC</option>
                </select>
                </div>
              </div>
       
      <br>
      <br>
      <br><label style="color:white;" for="note"><b><h4>TAMBAH ALAT:</h4></b></label>
      <br>
      <br>
        <input type="hidden" class="form-control" id="idJobSlip" name="idJobSlip" value="<?php echo $DataDetails->ID_JOB_SLIP; ?>"  readonly>
        <div class="row">
          <div id="education_fields"></div>
          <div class="col-sm-4">
            <div class="form-group">
              <label style="color:white;" for="lokak">Jenis Pekerjaan</label>
              <select class="form-control" id="jenispekerjaan" name="jenispekerjaan[]">

                <option value="">---Pilih Jenis Pekerjaan---</option>
                <?php foreach ($DropDwonJspk->result_array() as $row): ?>
                  <option value="<?php echo $row['ID']; ?>"><?php echo $row['JENIS_PEKERJAAN']; ?></option>
                  <?php echo form_close(); endforeach; ?>
                </select>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label style="color:white;" for="lokak">Alat</label>
                <select class="form-control" id="alat" name="alat[]">

                  <option value="">---Pilih Alat---</option>
                  <?php foreach ($DropDwonAlat->result_array() as $row): ?>
                    <option value="<?php echo $row['ID']; ?>"><?php echo $row['NM_ALAT']; ?></option>
                    <?php echo form_close(); endforeach; ?>
                  </select>
                </div>
              </div>

              <div class="col-sm-4">
                <div class="form-group">
                  <label style="color:white;" for="lokak">Operator</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="operator" name="operator[]" placeholder="Operator" autocomplete="off">
                    <div class="input-group-btn">
                      <button class="btn btn-success" type="button"  onclick="education_fields();"> <span class="glyphicon glyphicon-plus" aria-hidden="true" required="required"></span> </button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="clear"></div>
            </div>
          </div>
          
          <div class="col-sm-12">
            <div class="form-group">
              <button type="submit"  class="btn btn-primary">Simpan</button>
            </div>
          </div> 

        </from>
        <br>
        <div class="container">
          
        </div>
            <!-- <form  action="<?php echo site_url('operation/marshallingkontainer'); ?>" method="post">
                <div id="education_fields"></div>
                <div class="col-sm-3 nopadding">
                    <div class="form-group">
                      <input type="text" class="form-control" id="Schoolname" name="Schoolname[]" value="" placeholder="School name">
                    </div>
                </div>
                <div class="col-sm-3 nopadding">
                  <div class="form-group">
                    <input type="text" class="form-control" id="Major" name="Major[]" value="" placeholder="Major">
                  </div>
                </div>
                <div class="col-sm-3 nopadding">
                  <div class="form-group">
                    <input type="text" class="form-control" id="Degree" name="Degree[]" value="" placeholder="Degree">
                  </div>
                </div>

                <div class="col-sm-3 nopadding">
                  <div class="form-group">
                    <div class="input-group">
                      <select class="form-control" id="educationDate" name="educationDate[]">

                        <option value="">Date</option>
                        <option value="2015">2015</option>
                        <option value="2016">2016</option>
                        <option value="2017">2017</option>
                        <option value="2018">2018</option>
                      </select>
                      <div class="input-group-btn">
                        <button class="btn btn-success" type="button"  onclick="education_fields();"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> </button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="clear"></div>
              </div>
              <button class="primary" type="submit">djamal </button>
            </from> -->
          </div>
    <!-- <br><label style="color:white;" for="Note">Jenis Pekerjaan</label>
      <div class=" col-md-12">
                  <input type="text" class=" form-control" id="nolok" name="nolok" value="<?php $NOTE;   ?>" readonly>
                </div> -->
                <!--  <select name="color" id="color"><option value ="">-- Chose a color --</option><option value ="red">Red</option><option value ="green">Green</option> -->
                 
                </div>
              </div>
              <script>

                    $(document).ready(function(){
                  //$("#job").mouseover(function(){
                    var x = $("#lokak").val();                      
            let length = x.substring(0,3);
            //alert(x);
            //alert($('#statusspk :selected').val());

            if( length == 'CIC' ){
              //$('#statusspk').attr('disable'.'true');
              //alert($('#statusspk').val());
              //$("#statusspk :selected").val('450');
              document.getElementById('statusspk').value='460';
              //$("#statusspk option:selected").attr('disabled','disabled');

              //$('#statusspk :selected').val() == '460'; 
              document.getElementById('statusspk').disabled=true;          
  
            } else {
              document.getElementById('statusspk').value='450';
              document.getElementById('statusspk').disabled=true; 
            }
            
                  //});
                  })
                  
                
                var room = 1;
                function education_fields() {

                  var selectJspk = document.getElementById("jenispekerjaan");
                  var myArray = <?php echo json_encode($DropDwonJspk->result_array()); ?>;
                  var selectJspk = '<option value="">---Pilih Jenis Pekerjaan---</option>';
                  for (var i = 0; i < myArray.length; i++) {
                    selectJspk += '<option value="' + myArray[i].ID + '">' + myArray[i].JENIS_PEKERJAAN + '</option>';
                  }


                  var selectElem = document.getElementById("alat");
                  var myArray = <?php echo json_encode($DropDwonAlat->result_array()); ?>;
                  var selectElem = '<option value="">---Pilih Alat---</option>';
                  for (var i = 0; i < myArray.length; i++) {
                    selectElem += '<option value="' + myArray[i].ID + '">' + myArray[i].NM_ALAT + '</option>';
                  }
                  room++;
                  var objTo = document.getElementById('education_fields')
                  var divtest = document.createElement("div");
                  divtest.setAttribute("class", "form-group removeclass"+room);
                  var rdiv = 'removeclass'+room;
                  divtest.innerHTML = '<div class="col-sm-4"><div class="form-group"> <select class="form-control" id="jenispekerjaan" name="jenispekerjaan[]">'+selectJspk+' </select></div></div><div class="col-sm-4"><div class="form-group">  <select class="form-control" id="alat" name="alat[]">'+selectElem+' </select></div></div><div class="col-sm-4 "><div class="form-group"><div class="input-group"> <input type="text" class="form-control" id="operator" name="operator[]"  placeholder="Operator" autocomplete="off"><div class="input-group-btn"> <button class="btn btn-danger" type="button" onclick="remove_education_fields('+ room +');"> <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> </button></div></div></div></div><div class="clear"></div>';
                  
                  objTo.appendChild(divtest)
                }
                function remove_education_fields(rid) {
                  $('.removeclass'+rid).remove();
                }

                let formSelectState = ["jenispekerjaan", "alat", "operator"];

        $("select").each(function (index, item) {
          $(this).change(function () {
            formSelectState[index] = $(this).val();
          });
        });

        $("button").click(function () {
          const counts = {};
          formSelectState.forEach(function (item, index) {
            if (counts[formSelectState[index]]) {
              counts[formSelectState[index]] += 1;
            } else {
              counts[formSelectState[index]] = 1;
            }
          });
          const dupl = Object.values(counts).filter(x => x != 1);
          if(dupl.length > 0){
            // eksekusi jika duplikat
            alert('ups, ada yang duplikat.');
          }
        });

// $(document).ready(function(){
//   var i=1;
//   $('#add').click(function(){
//     i++;
//     $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
//   });
                
//   $(document).on('click', '.btn_remove', function(){
//     var button_id = $(this).attr("id"); 
//     $('#row'+button_id+'').remove();
//   });
                
  // $('#submit').click(function(){    
  //   //alert("ok");
  //   $.ajax({
  //     url:"<?php echo site_url("/operation/marshallingkontainer"); ?>",
  //     method:"POST"
  //     // data:$('#add_name').serialize(),
  //     // success:function()
  //     // {
  //     //   alert("sucess");
  //     //   //$('#add_name')[0].reset();
  //     // }
  //   });
  // });
                
// });
              </script>

              <?php if ($this->session->flashdata('pesan')): ?>
                <script>
                  setTimeout(function() {
                    alert("<?php echo $this->session->flashdata('pesan'); ?>");
        }, 1000); // waktu delay dalam milidetik (dalam contoh ini 1 detik)
      </script>
    <?php endif; ?>
<!-- tutup foreach -->