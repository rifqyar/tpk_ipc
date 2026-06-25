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
        <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('/display/ppkjoininspection/respon2/'.$id); ?>" method="post" autocomplete="off" onsubmit="save_post('form_data','divcustoms'); return false;" popup="1">
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
                        <td>Set Pemeriksa</td>
                        <td>Jadwal Pemeriksa</td>
              		</tr>
                    <?php
                        $no = 0;
                        $sel = '';
                        foreach($arrdata as $k => $value) {
                          if ($value->respon_karantina !== '') {
                              $sel = $value->respon_karantina;
                          }else if ($value->respon_beacukai !== ''){
                              $sel = $value->respon_beacukai;
                          }else{
                              $sel = '';
                          }
                    ?>
                                <tr>
                                      <td><input type="checkbox" name="ceklis[<?php echo $k; ?>]" value="<?php echo $value->NO_CONT; ?>" checked></td>
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
                                      <td><input type="text" id="pemeriksakarantina<?php echo $k; ?>" class="form-control" placeholder="Nama Pemeriksa" value="<?php echo $value->NAMA ?>">
                                          <input type="hidden" name="pemeriksa[<?php echo $k; ?>]" id="setpemeriksa<?php echo $k; ?>" value="<?php echo $value->id_pemeriksa ?>"></td>
                                      <td><input type="text" name="jadwal[<?php echo $k; ?>]" mandatory="yes" class="form-control datetime" placeholder="Waktu Pemeriksaan" value="<?php echo $value->jadwal ?>"></td>
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
<script>
  datetime('datetime');
  autocomplete('pemeriksakarantina0','/popup/autocomplete/t_pemeriksa_ppk_kr',function(event, ui){    
    $('#setpemeriksa0').val(ui.item.id);
  });
  autocomplete('pemeriksakarantina1','/popup/autocomplete/t_pemeriksa_ppk_kr',function(event, ui){    
    $('#setpemeriksa1').val(ui.item.id);
  });
  autocomplete('pemeriksakarantina2','/popup/autocomplete/t_pemeriksa_ppk_kr',function(event, ui){    
    $('#setpemeriksa2').val(ui.item.id);
  });
  autocomplete('pemeriksakarantina3','/popup/autocomplete/t_pemeriksa_ppk_kr',function(event, ui){    
    $('#setpemeriksa3').val(ui.item.id);
  });
  autocomplete('pemeriksakarantina4','/popup/autocomplete/t_pemeriksa_ppk_kr',function(event, ui){    
    $('#setpemeriksa4').val(ui.item.id);
  });
  autocomplete('pemeriksakarantina5','/popup/autocomplete/t_pemeriksa_ppk_kr',function(event, ui){    
    $('#setpemeriksa5').val(ui.item.id);
  });
  autocomplete('pemeriksakarantina6','/popup/autocomplete/t_pemeriksa_ppk_kr',function(event, ui){    
    $('#setpemeriksa6').val(ui.item.id);
  });
  autocomplete('pemeriksakarantina7','/popup/autocomplete/t_pemeriksa_ppk_kr',function(event, ui){    
    $('#setpemeriksa7').val(ui.item.id);
  });
  autocomplete('pemeriksakarantina8','/popup/autocomplete/t_pemeriksa_ppk_kr',function(event, ui){    
    $('#setpemeriksa8').val(ui.item.id);
  });
  autocomplete('pemeriksakarantina9','/popup/autocomplete/t_pemeriksa_ppk_kr',function(event, ui){    
    $('#setpemeriksa9').val(ui.item.id);
  });
  autocomplete('pemeriksakarantina10','/popup/autocomplete/t_pemeriksa_ppk_kr',function(event, ui){    
    $('#setpemeriksa10').val(ui.item.id);
  });
  

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