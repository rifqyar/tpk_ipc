<div class="panel">
  <div class="ribbon ribbon-clip ribbon-primary">
    <span class="ribbon-inner">
    <i class="icon md-account-add margin-0" aria-hidden="true"></i> <?php echo $title; ?>
    </span>
  </div>
  <button type="submit" class="btn btn-sm btn-primary navbar-right navbar-btn waves-effect waves-light" onclick="save_post('form_data','divtruck'); return false;">
    <i class="icon md-badge-check"></i> SAVE
  </button>
  <div class="panel-body container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('reference/execute/'.$action.'/truck/'.$id); ?>" method="post" autocomplete="off" onsubmit="save_post('form_data','divtruck'); return false;" popup="1">
          <div class="panel-body container-fluid">
            <div class="row">
              <div class="form-group form-material">
                <div class="col-sm-9">
                  <input type="hidden" name="ID_TRUCK" id="ID_TRUCK" mandatory="no" class="form-control" value="<?php echo trim($arrdata['ID_TRUCK']); ?>">
                  <div class="hint">ID</div>
                </div>
              </div>
              
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NAMA PEMILIK TRUCK</label>
                 <div class="col-sm-9">
                    <input type="text" name="DATA[NM_PEMILIK]" id="ID" mandatory="yes" class="form-control" value="<?php echo trim($arrdata['NM_PEMILIK']); ?>" placeholder="NAMA PEMILIK TRUCK">
                  <div class="hint">NAMA PEMILIK TRUCK</div>
                </div>
              </div>

              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NO POLISI</label>
                 <div class="col-sm-9">
                    <input type="text" name="DATA[NO_TRUCK]" id="ID" mandatory="yes" class="form-control" value="<?php echo trim($arrdata['NO_TRUCK']); ?>" placeholder="NO POLISI">
                  <div class="hint">NO POLISI</div>
                </div>
              </div>

              <div class="form-group form-material">
                <label class="col-sm-3 control-label">UKURAN TRUCK</label>
                 <div class="col-sm-9">
                    <input type="text" name="DATA[UKURAN_TRUCK]" maxlength="2" id="ID" mandatory="yes" class="form-control" value="<?php echo trim($arrdata['UKURAN_TRUCK']); ?>" placeholder="UKURAN TRUCK">
                  <div class="hint">UKURAN TRUCK</div>
                </div>
              </div>

              
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NO PLAT</label>
                 <div class="col-sm-9">
                    <input type="text" name="DATA[NO_PLAT]" id="ID" mandatory="yes" class="form-control" value="<?php echo trim($arrdata['NO_PLAT']); ?>" placeholder="NO PLAT MOBIL">
                  <div class="hint">NO PLAT</div>
                </div>
              </div>

              
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">BERAT TRUCK</label>
                 <div class="col-sm-9">
                    <input type="text" name="DATA[BERAT_TRUCK]" id="ID" mandatory="yes" class="form-control" value="<?php echo trim($arrdata['BERAT_TRUCK']); ?>" placeholder="BERAT TRUCK">
                  <div class="hint">BERAT TRUCK</div>
                </div>
              </div>

            </div>
          </div>
          <input type="hidden" name="action" id="action" readonly="readonly" value="<?php echo site_url('reference/truck/post'); ?>"/>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
$(function(){
  date('date');
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
