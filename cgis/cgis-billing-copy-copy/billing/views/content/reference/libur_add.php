<div class="panel">
  <div class="ribbon ribbon-clip ribbon-primary">
    <span class="ribbon-inner">
    <i class="icon md-account-add margin-0" aria-hidden="true"></i> <?php echo $title; ?>
    </span>
  </div>
  <button type="submit" class="btn btn-sm btn-primary navbar-right navbar-btn waves-effect waves-light" onclick="save_post('form_data','divlibur'); return false;">
    <i class="icon md-badge-check"></i> SAVE
  </button>
  <div class="panel-body container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('reference/execute/'.$action.'/libur/'.$id); ?>" method="post" autocomplete="off" onsubmit="save_post('form_data','divlibur'); return false;" popup="1">
          <div class="panel-body container-fluid">
            <div class="row">
              <div class="form-group form-material">
                <div class="col-sm-9">
                  <input type="hidden" name="ID" id="ID" mandatory="no" class="form-control" value="<?php echo trim($arrdata['ID']); ?>">
                  <div class="hint">ID</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">TANGGAL</label>
                <div class="col-sm-9">
                  <input type="date" name="DATA[TANGGAL]" id="TANGGAL" mandatory="yes" class="form-control date" placeholder="TANGGAL" value="<?php echo validate($arrdata['TANGGAL'],'DATE'); ?>">
                  <div class="hint">TANGGAL</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">KETERANGAN</label>
                 <div class="col-sm-9">
                    <input type="text" name="DATA[KETERANGAN]" id="ID" mandatory="yes" class="form-control" value="<?php echo trim($arrdata['KETERANGAN']); ?>" placeholder="KETERANGAN LIBUR">
                  <div class="hint">KETERANGAN</div>
                </div>
              </div>

            </div>
          </div>
          <input type="hidden" name="action" id="action" readonly="readonly" value="<?php echo site_url('reference/hrlibur/post'); ?>"/>
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
