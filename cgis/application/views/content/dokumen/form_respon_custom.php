<?php 
	// print_r($arrdata);
?>

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
        <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('/display/respon_custom/respon/'.$id); ?>" method="post" autocomplete="off" onsubmit="save_post('form_data','divcustoms'); return false;" popup="1">
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
              			<td>Keterangan</td>
                        <td>Respon PKB</td>
              		</tr>
                    <?php
                        $no = 0;
                        foreach($arrdata as $value) {
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
                                      <td><?php echo $value->KETERANGAN ?></td>
                                      <td>
                                        <!--musab alfarizi nambahin kolom di respon pkb -->
                                        
                                          <select class="form-control focus" id="TYPE" name="status[<?php echo $no; $no++; ?>]">
                                              <?php 
                                                if ($value->FL_PERIKSA == 'Y' and $value->KETERANGAN == 'BEHANDLE 1') {

                                                  if ($user == 'BC' OR $user == 'SPA') {
                                                    echo '<option value="pkb_longroom" selected>PPK LONGROOM</option>
                                                    <option value="pkb_yard">PPK YARD</option>
                                                    <option value="mini_lr">PPK Mini LR</option>
                                                    <option value="no">NO PPK</option>
                                                    <option value="pkb_percepatan">PPK PERCEPATAN</option>
                                                    <option value="periksa_ulang">PERIKSA ULANG</option>
                                                    <option value="periksa_tambahan">PERIKSA TAMBAHAN</option>
                                                    <option value="nhi">NHI</option>
                                                    <option value="returnable_package">RETURNABLE PACKAGE(RP)</option>
                                                    <option value="pibk">PIBK</option>';
                                                  } else if ($user == 'PLN') {
                                                    echo '
                                                    <option value="nhi" selected>NHI</option>
                                                    <option value="returnable_package">RETURNABLE PACKAGE(RP)</option>
                                                    <option value="pibk">PIBK</option>';
                                                  } else if ($user == 'BC_CHECK') {
                                                    echo '
                                                    <option value="mini_lr">PPK Mini LR</option>
                                                    <option value="periksa_ulang">PERIKSA ULANG</option>
                                                    <option value="periksa_tambahan">PERIKSA TAMBAHAN</option>';
                                                  }
                                                } else if($value->FL_PERIKSA == 'N' and $value->KETERANGAN == 'BEHANDLE 1'){
                                                    if ($user == 'SPA') {
                                                    echo '<option value="pkb_longroom" selected>PPK LONGROOM</option>
                                                    <option value="mini_lr">PPK Mini LR</option>
                                                    <option value="pkb_yard">PPK YARD</option>
                                                    <option value="no">NO PPK</option>
                                                    <option value="pkb_percepatan">PPK PERCEPATAN</option>
                                                    <option value="periksa_ulang">PERIKSA ULANG</option>
                                                    <option value="periksa_tambahan">PERIKSA TAMBAHAN</option>
                                                    <option value="nhi">NHI</option>
                                                    <option value="returnable_package">RETURNABLE PACKAGE(RP)</option>
                                                    <option value="pibk">PIBK</option>';
                                                  }else if ($user == 'BC') {
                                                    if ($value->FL_MANUAL == 'Y') {
                                                      echo '<option value="pkb_longroom" selected>PPK LONGROOM</option>
                                                      <option value="mini_lr">PPK Mini LR</option>
                                                    <option value="pkb_yard">PPK YARD</option>
                                                    <option value="no">NO PPK</option>
                                                    <option value="pkb_percepatan">PPK PERCEPATAN</option>
                                                    <option value="periksa_ulang">PERIKSA ULANG</option>
                                                    <option value="periksa_tambahan">PERIKSA TAMBAHAN</option>
                                                    <option value="nhi">NHI</option>
                                                    <option value="returnable_package">RETURNABLE PACKAGE(RP)</option>
                                                    <option value="pibk">PIBK</option>';
                                                    }else{
                                                      echo '<option value="no">NO PPK</option>';
                                                    }
                                                  } else if ($user == 'PLN') {
                                                    echo '
                                                    <option value="nhi" selected>NHI</option>
                                                    <option value="returnable_package">RETURNABLE PACKAGE(RP)</option>
                                                    <option value="pibk">PIBK</option>';
                                                  } else if ($user == 'BC_CHECK') {
                                                    echo '
                                                    <option value="periksa_ulang">PERIKSA ULANG</option>
                                                    <option value="periksa_tambahan">PERIKSA TAMBAHAN</option>';
                                                  }
                                                } else if($value->FL_PERIKSA == 'Y' and $value->KETERANGAN == 'BEHANDLE 2'){
                                                    if ($user == 'BC' OR $user == 'SPA') {
                                                    echo '<option value="pkb_longroom" selected>PPK LONGROOM</option>
                                                    <option value="mini_lr">PPK Mini LR</option>
                                                    <option value="pkb_yard">PPK YARD</option>
                                                    ';
                                                  } else if ($user == 'PLN') {
                                                    echo '
                                                    <option value="nhi" selected>NHI</option>
                                                    <option value="returnable_package">RETURNABLE PACKAGE(RP)</option>
                                                    <option value="pibk">PIBK</option>';
                                                  } else if ($user == 'BC_CHECK') {
                                                    echo '
                                                    <option value="periksa_ulang">PERIKSA ULANG</option>
                                                    <option value="periksa_tambahan">PERIKSA TAMBAHAN</option>';
                                                  }
                                                } else if($value->FL_PERIKSA == 'N' and $value->KETERANGAN == 'BEHANDLE 2'){
                                                    if ($user == 'BC' OR $user == 'SPA') {
                                                    echo '<option value="pkb_longroom" selected>PPK LONGROOM</option>
                                                    <option value="mini_lr">PPK Mini LR</option>
                                                    <option value="pkb_yard">PPK YARD</option>
                                                    ';
                                                  } else if ($user == 'PLN') {
                                                    echo '
                                                    <option value="nhi" selected>NHI</option>
                                                    <option value="returnable_package">RETURNABLE PACKAGE(RP)</option>
                                                    <option value="pibk">PIBK</option>';
                                                  } else if ($user == 'BC_CHECK') {
                                                    echo '
                                                    <option value="periksa_ulang">PERIKSA ULANG</option>
                                                    <option value="periksa_tambahan">PERIKSA TAMBAHAN</option>';
                                                  }
                                                } else if ($user == 'SPA' OR $user == 'BC') {
                                                    echo '<option value="pkb_longroom" selected>PPK LONGROOM</option>
                                                    <option value="mini_lr">PPK Mini LR</option>
                                                    <option value="pkb_yard">PPK YARD</option>
                                                    <option value="no" selected>NO PPK</option>
                                                    <option value="pkb_percepatan">PPK PERCEPATAN</option>
                                                    <option value="periksa_ulang">PERIKSA ULANG</option>
                                                    <option value="periksa_tambahan">PERIKSA TAMBAHAN</option>
                                                    <option value="nhi">NHI</option>
                                                    <option value="returnable_package">RETURNABLE PACKAGE(RP)</option>
                                                    <option value="pibk">PIBK</option>';
                                                } else if ($user == 'BC') {
                                                  echo '<option value="no" selected>NO PPK</option>';
                                                } else if ($user == 'PLN') {
                                                  echo '<option value="nhi" selected>NHI</option>
                                                  <option value="returnable_package">RETURNABLE PACKAGE(RP)</option>
                                                  <option value="pibk">PIBK</option>';
                                                }else if ($user == 'BC_CHECK') {
                                                  echo '
                                                    <option value="no" selected>NO PPK</option>';
                                                }
                                              ?>
                                          </select>
                                      </td>
                                </tr>
                    <?php
                        }
                    ?>
                    <input type="hidden" name="action" id="action" readonly="readonly" value="<?php echo site_url('display/respon_custom/post'); ?>"/>
                </table>
              </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>