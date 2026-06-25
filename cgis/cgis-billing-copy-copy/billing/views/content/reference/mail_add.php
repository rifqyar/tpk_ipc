
<div class="panel">
  <div class="ribbon ribbon-clip ribbon-primary">
    <span class="ribbon-inner">
    <i class="icon md-email margin-0" aria-hidden="true"></i> <?php echo $title; ?>
    </span>
  </div>
  <button type="submit" class="btn btn-sm btn-primary navbar-right navbar-btn waves-effect waves-light" onclick="save_post('form_data','divmail'); return false;">
    <i class="icon md-badge-check"></i> SAVE
  </button>
  <div class="panel-body container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('execute/process/'.$action.'/mail/'.$id); ?>" method="post" autocomplete="off" onsubmit="save_post('form_data','divmail'); return false;" popup="1">
          <div class="panel-body container-fluid">
            <div class="row">
              <div class="form-group form-material">
                <div class="col-sm-9">
                  <input type="hidden" name="DATA[ID]" id="ID" mandatory="no" class="form-control" value="<?php echo trim($arrdata['ID']); ?>">
                  <div class="hint">ID</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">E-MAIL</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[EMAIL]" id="EMAIL" mandatory="yes" class="form-control" placeholder="E-MAIL" value="<?php echo trim($arrdata['EMAIL']); ?>">
                  <div class="hint">NAMA E-MAIL</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">JENIS E-MAIL</label>
                <div class="col-sm-4">
                  <select class="form-control" id="product" name="DATA[JNS_EMAIL]" onchange="proses()">
                      <option value="TO">TO</option>
                      <option value="CC">CC</option>
                    </select>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NAMA USER</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NAMA_USER]" id="NO_PPKB" mandatory="no" class="form-control" placeholder="NAMA USER" value="<?php echo trim($arrdata['NAMA_USER']); ?>">
                  <div class="hint">NAMA USER</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">JENIS E-MAIL</label>
                <div class="col-sm-4">
                  <select class="form-control" id="product" name="DATA[KEGIATAN]" onchange="proses()">
                      <option value="ANNOUNCE">ANNOUNCMENET</option>
                      <option value="GATE">GATEPASS</option>
                    </select>
                </div>
              </div>
            </div>
          </div>
          <input type="hidden" name="action" id="action" readonly="readonly" value="<?php echo site_url('reference/mail/post'); ?>"/>
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
