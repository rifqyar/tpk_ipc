<div class="panel">
  <div class="ribbon ribbon-clip ribbon-primary">
    <span class="ribbon-inner">
    <i class="icon md-account-add margin-0" aria-hidden="true"></i> <?php echo $title; ?>
    </span>
  </div>
  <button type="submit" class="btn btn-sm btn-primary navbar-right navbar-btn waves-effect waves-light" onclick="save_post('form_data','divuser'); return false;">
    <i class="icon md-badge-check"></i> SAVE
  </button>
  <div class="panel-body container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('execute/process/'.$action.'/user/'.$id); ?>" method="post" autocomplete="off" onsubmit="save_post('form_data','divuser'); return false;" popup="1">
          <div class="panel-body container-fluid">
            <div class="row">
              <div class="form-group form-material">
                <div class="col-sm-9">
                  <input type="hidden" name="DATA[ID]" id="ID" mandatory="no" class="form-control" value="<?php echo trim($arrdata['ID']); ?>">
                  <div class="hint">ID</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">USERNAME</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[USER_NAME]" id="USER_NAME" mandatory="yes" class="form-control" placeholder="USERNAME" value="<?php echo trim($arrdata['USER_NAME']); ?>">
                  <div class="hint">NAMA KAPAL</div>
                </div>
              </div>
			  <div class="form-group form-material">
                <label class="col-sm-3 control-label">PASSWORD</label>
                <div class="col-sm-9">
                  <input type="password" name="DATA[PASS]" id="PASS" mandatory="no" class="form-control" placeholder="PASSWORD" maxlength="8" value="<?php echo trim($arrdata['PASS']); ?>">
                </div>
                  <div class="hint">PASSWORD</div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NAMA <?php //print_r($arr_group)?></label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NAMA]" id="NAMA" mandatory="yes" class="form-control" placeholder="NAMA" value="<?php echo $arrdata['NAMA']; ?>">
                  <div class="hint">NAMA</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">E-MAIL </label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[EMAIL]" id="MAIL" mandatory="no" class="form-control" placeholder="E-MAIL" value="<?php echo trim($arrdata['EMAIL']); ?>">
                  
                  <div class="hint">E-MAIL</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">KODE GROUP</label>
                <div class="col-sm-6">
                <?php echo form_dropdown('DATA[KD_GROUP]', $arr_group, $arrdata['KD_GROUP'], 'id="KD_GROUP"  wajib="yes" class="form-control input-sm select-chosen" onchange="tes();"'); ?>
                    <!--<select class="form-control " id="product" name="DATA[KD_GROUP]" onchange="proses()" required="">
                      <option value="ADM">ADMIN</option>
                      <option value="ADMTPFT">ADMIN TPFT</option>
                      <option value="SPA">SPA</option>
                      <option value="USR">USER</option>
                      <option value="USRTPFT">USER TPFT</option>
                    </select>-->
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">STATUS</label>
                <div class="col-sm-6">
                  <select class="form-control" id="product" name="DATA[STATUS]" onchange="proses()" required="">
                      <option value="ACTIVE">ACTIVE</option>
                      <option value="INACTIVE">INACTIVE</option>
                    </select>
                </div>
              </div>
              
            </div>
          </div>
          <input type="hidden" name="action" id="action" readonly="readonly" value="<?php echo site_url('usermanage/user/post'); ?>"/>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
$(function(){
  datetime('datetime');
  /*autocomplete('NM_KAPAL','/popup/autocomplete/mst_kapal/nama',function(event, ui){
    $('#KD_KAPAL').val(ui.item.KD_KAPAL);
  });
  autocomplete('KD_PEL_MUAT','/popup/autocomplete/mst_port/kode',function(event, ui){
    $('#PELABUHAN_MUAT').val(ui.item.NAMA);
  });
  autocomplete('PELABUHAN_MUAT','/popup/autocomplete/mst_port/nama',function(event, ui){
    $('#KD_PEL_MUAT').val(ui.item.KODE);
  });
  autocomplete('KD_PEL_TRANSIT','/popup/autocomplete/mst_port/kode',function(event, ui){
    $('#PELABUHAN_TRANSIT').val(ui.item.NAMA);
  });
  autocomplete('PELABUHAN_TRANSIT','/popup/autocomplete/mst_port/nama',function(event, ui){
    $('#KD_PEL_TRANSIT').val(ui.item.KODE);
  });
  autocomplete('KD_PEL_BONGKAR','/popup/autocomplete/mst_port/kode',function(event, ui){
    $('#PELABUHAN_BONGKAR').val(ui.item.NAMA);
  });
  autocomplete('PELABUHAN_BONGKAR','/popup/autocomplete/mst_port/nama',function(event, ui){
    $('#KD_PEL_BONGKAR').val(ui.item.KODE);
  });*/
});
</script>