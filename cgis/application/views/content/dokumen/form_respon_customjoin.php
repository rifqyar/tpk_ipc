<?php 
	// print_r($arrdata);
?>
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css"> -->
<div class="panel">
  <div class="ribbon ribbon-clip ribbon-primary">
    <span class="ribbon-inner">
    <i class="icon md-navigation margin-0" aria-hidden="true"></i> <?php echo $title; ?>
    </span>
  </div>
  <button type="submit" class="btn btn-sm btn-primary navbar-right navbar-btn waves-effect waves-light" onclick="save_post('form_data','tblkapallist'); return false;">
  	<i class="icon md-badge-check"></i> SAVE
  </button>
  <div class="panel-body container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('/display/ppkjoininspection/respon/'.$id); ?>" method="post" autocomplete="off" onsubmit="save_post('form_data','divcustoms'); return false;" popup="1">
        <input type="hidden" name="usergroup" value="<?php echo $user;?>">
        <input type="hidden" name="noaju" value="<?php echo $dok[1];?>">
        <input type="hidden" name="dok_bc" value="<?php echo $dok[4];?>">
        <input type="hidden" name="tgl_bc" value="<?php echo $dok[5];?>">
        <input type="hidden" name="dok_kr" value="<?php echo $dok[2];?>">
        <input type="hidden" name="tgl_kr" value="<?php echo $dok[3];?>">
        <div class="panel-body container-fluid">
            <div class="row">
              <div class="form-group form-material">
                <div class="col-sm-9">
                  <input type="hidden" name="DATA[ID]" id="ID" mandatory="no" class="form-control" value="<?php echo $id; ?>">
                  <div class="hint">ID</div>
                </div>
              </div>
              <div>
              	<label class="col-sm-3 control-label">LIST KONTAINER</label>
              	<table class="table">
              		<tr>
              			<td>
              				<!-- <input type="checkbox" name="ceklis">&nbsp;&nbsp;&nbsp;All -->
              			</td>
              			<td>No. Kontainer</td>
              			<td>Ukuran</td>
                        <td>Lokasi</td>
                        <td>Periksa</td>
                        <td>Respon PKB</td>
              		</tr>
                    <?php
                        $no = 0;
                        $sel = '';
                        foreach($arrdata as $value) {
                          if ($value->respon_karantina !== '') {
                              $sel = $value->respon_karantina;
                          }else if ($value->respon_beacukai !== ''){
                              $sel = $value->respon_beacukai;
                          }else{
                              $sel = '';
                          }
                    ?>
                                <tr>
                                      <td><input type="checkbox" name="ceklis[<?php echo $no; ?>]" value="<?php echo $value->NO_CONT; ?>" checked></td>
                                      <td><?php echo $value->NO_CONT ?></td>
                                      <td><?php echo $value->SIZE ?></td>
                                      <td><?php echo $value->LOKASI ?></td>
                                      <td><?php 
                                          if ($value->FL_PERIKSA == "Y") {
                                              echo "<span class='label label-success'>Yes</span>";
                                          } else {
                                              echo "<span class='label label-danger'>No</span>";
                                          }
                                      ?></td>
                                      <td>
                                          <select class="form-control focus" id="TYPE" name="status[<?php echo $no; $no++; ?>]">
                                              <?php 
                                                if ($value->FL_PERIKSA == 'Y') {
                                                  if ($user == 'BC' OR $user == 'SPA' OR $user == 'ADM_KAR') {
                                              ?>
                                                    <option value="NO PPK">NO PPK</option>
                                                    <option value="PPK LONGROOM" <?php if($value->respon_karantina == 'PPK LONGROOM'){echo 'selected';}?>>PPK LONGROOM</option>
                                                    <option value="PPK YARD" <?php if($value->respon_karantina == 'PPK YARD'){echo 'selected';}?>>PPK YARD</option>
                                                    <option value="PPK PERCEPATAN" <?php if($value->respon_karantina == 'PPK PERCEPATAN'){echo 'selected';}?>>PPK PERCEPATAN</option>
                                                    <option value="PERIKSA ULANG" <?php if($value->respon_karantina == 'PERIKSA ULANG'){echo 'selected';}?>>PERIKSA ULANG</option>
                                                    <option value="PERIKSA TAMBAHAN" <?php if($value->respon_karantina == 'PERIKSA TAMBAHAN'){echo 'selected';}?>>PERIKSA TAMBAHAN</option>
                                                    <option value="NHI" <?php if($value->respon_karantina == 'NHI'){echo 'selected';}?>>NHI</option>
                                                    <option value="RETURNABLE PACKAGE(RP)" <?php if($value->respon_karantina == 'RETURNABLE PACKAGE(RP)'){echo 'selected';}?>>RETURNABLE PACKAGE(RP)</option>
                                                    <option value="PIBK" <?php if($value->respon_karantina == 'PIBK'){echo 'selected';}?>>PIBK</option>
                                                <?php
                                                  } else if ($user == 'PLN') {
                                                ?>
                                                    <option value="NHI" selected>NHI</option>
                                                    <option value="RETURNABLE PACKAGE(RP)">RETURNABLE PACKAGE(RP)</option>
                                                    <option value="PIBK">PIBK</option>
                                                <?php
                                                  } else if ($user == 'BC_CHECK') {
                                                ?>
                                                    <option value="PERIKSA ULANG">PERIKSA ULANG</option>
                                                    <option value="PERIKSA TAMBAHAN">PERIKSA TAMBAHAN</option>
                                                <?php
                                                  }
                                                } else if ($user == 'SPA' OR $user == 'BC'  OR $user == 'ADM_KAR') {
                                                ?>
                                                    <option value="NO PPK">NO PPK</option>
                                                    <option value="PPK LONGROOM" <?php if($value->respon_karantina == 'PPK LONGROOM'){echo 'selected';}?>>PPK LONGROOM</option>
                                                    <option value="PPK YARD" <?php if($value->respon_karantina == 'PPK YARD'){echo 'selected';}?>>PPK YARD</option>
                                                    <option value="PPK PERCEPATAN" <?php if($value->respon_karantina == 'PPK PERCEPATAN'){echo 'selected';}?>>PPK PERCEPATAN</option>
                                                    <option value="PERIKSA ULANG" <?php if($value->respon_karantina == 'PERIKSA ULANG'){echo 'selected';}?>>PERIKSA ULANG</option>
                                                    <option value="PERIKSA TAMBAHAN" <?php if($value->respon_karantina == 'PERIKSA TAMBAHAN'){echo 'selected';}?>>PERIKSA TAMBAHAN</option>
                                                    <option value="NHI" <?php if($value->respon_karantina == 'NHI'){echo 'selected';}?>>NHI</option>
                                                    <option value="RETURNABLE PACKAGE(RP)" <?php if($value->respon_karantina == 'RETURNABLE PACKAGE(RP)'){echo 'selected';}?>>RETURNABLE PACKAGE(RP)</option>
                                                    <option value="PIBK" <?php if($value->respon_karantina == 'PIBK'){echo 'selected';}?>>PIBK</option>
                                                <?php
                                                } else if ($user == 'PLN') {
                                                ?>
                                                  <option value="NHI" selected>NHI</option>
                                                  <option value="RETURNABLE PACKAGE(RP)">RETURNABLE PACKAGE(RP)</option>
                                                  <option value="PIBK">PIBK</option>
                                                <?php
                                                }else if ($user == 'BC_CHECK') {
                                                  ?>
                                                    <option value="NO PPK" selected>NO PPK</option>
                                                  <?php
                                                }
                                              ?>
                                          </select>
                                      </td>
                                </tr>
                                <tr>
                                  <!-- <td colspan="8">asdasdasd</td> -->
                                </tr>
                    <?php
                        }
                    ?>
                    <input type="hidden" name="action" id="action" readonly="readonly" value="<?php echo site_url('display/ppkjoininspection/post'); ?>"/>
                </table>
              </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<!-- <div class="modal fade" id="modalsetpemeriksa" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Daftar Pemeriksa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <table id="datatablepemeriksa" class="table-bordered" style="width:100%">
        <thead>
            <tr>
                <th></th>
                <th>NIP</th>
                <th>Nama</th>
                <th>No Telephone</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td>1111</td>
                <td>System Architect</td>
                <td>0989</td>
            </tr>
            <tr>
                <td></td>
                <td>asdasd</td>
                <td>System Architect</td>
                <td>0956756789</td>
            </tr>
            <tr>
                <td></td>
                <td>1111</td>
                <td>System Arcasdasdct</td>
                <td>2343245</td>
            </tr>
    </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary savepemeriksamodal">Save changes</button>
      </div>
    </div>
  </div>
</div> -->
<!-- <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script> -->
<script>
  // $(document).ready(function(){
  //   var table = $('#datatablepemeriksa').DataTable( {
  //       columnDefs: [ {
  //           className: 'select-checkbox',
  //           targets:   0
  //       } ],
  //       select: {
  //           style:    'multi'
  //       }
  //     } );

  //   $('.btnsetpemeriksa').on('click',function(){
  //     $('#modalsetpemeriksa').modal('show');
  //   });
    
  //   $('#modalsetpemeriksa').on('hidden.bs.modal', function () {
      
  //     //table.fnDestroy();
  //   });

  //   $('.savepemeriksamodal').on('click',function(){
  //       //console.log(table.rows( { selected: true } ).data());
  //       //$('#datatablepemeriksa').dataTable().fnDestroy();
  //       //$('#datatablepemeriksa').DataTable().fnDestroy();
  //   });
  // });
</script>