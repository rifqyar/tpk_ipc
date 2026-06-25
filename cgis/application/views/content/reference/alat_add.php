<div class="panel">
  <div class="ribbon ribbon-clip ribbon-primary">
    <span class="ribbon-inner">
    <i class="icon md-account-add margin-0" aria-hidden="true"></i> <?php echo $title; ?>
    </span>
  </div>
  <button type="submit" class="btn btn-sm btn-primary navbar-right navbar-btn waves-effect waves-light" onclick="save_post('form_data','divalat'); return false;">
    <i class="icon md-badge-check"></i> SAVE
  </button>
  <div class="panel-body container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('reference/execute/'.$action.'/alat/'.$id); ?>" method="post" autocomplete="off" onsubmit="save_post('form_data','divalat'); return false;" popup="1">
          <div class="panel-body container-fluid">
            <div class="row">
              <div class="form-group form-material">
                <div class="col-sm-9">
                  <input type="hidden" name="ID" id="ID" mandatory="no" class="form-control" value="<?php echo trim($arrdata['ID']); ?>">
                  <div class="hint">ID</div>
                </div>
              </div>
              
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NAMA ALAT</label>
                 <div class="col-sm-9">
                    <input type="text" name="DATA[NM_ALAT]" id="ID" mandatory="yes" class="form-control" value="<?php echo trim($arrdata['NM_ALAT']); ?>" placeholder="NAMA ALAT">
                  <div class="hint">NAMA ALAT</div>
                </div>
              </div>

               <div class="form-group form-material">
                <label class="col-sm-3 control-label">KEPEMILIKAN</label>
                 <div class="col-sm-9">
                    <input type="text" name="DATA[KEPEMILIKAN]" id="ID" mandatory="yes" class="form-control" value="<?php echo trim($arrdata['KEPEMILIKAN']); ?>" placeholder="NAMA ALAT">
                  <div class="hint">KEPEMILIKAN</div>
                </div>
              </div>

            <!--   <div class="form-group form-material">
                <label class="col-sm-3 control-label">NO POLISI</label>
                 <div class="col-sm-9">
                    <input type="text" name="DATA[NO_POLISI]" id="ID" mandatory="yes" class="form-control" value="<?php echo trim($arrdata['NO_POLISI']); ?>" placeholder="NO POLISI">
                  <div class="hint">NO POLISI</div>
                </div>
              </div>
 -->
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">JENIS PEKERJAAN</label>
                 <div class="col-sm-9">
                    <input type="text" name="DATA[JENIS_PEKERJAAN]" id="ID" mandatory="yes" class="form-control" value="<?php echo trim($arrdata['JENIS_PEKERJAAN']); ?>" placeholder="JENIS PEKERJAAN">
                  <div class="hint">JENIS PEKERJAAN</div>
                </div>
              </div>

              
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">DESCRIPTION</label>
                 <div class="col-sm-9">
                    <input type="text" name="DATA[DESCRIPTION]" id="ID" mandatory="yes" class="form-control" value="<?php echo trim($arrdata['DESCRIPTION']); ?>" placeholder="DESCRIPTION">
                  <div class="hint">DESCRIPTION</div>
                </div>
              </div>


            </div>
          </div>
          <input type="hidden" name="action" id="action" readonly="readonly" value="<?php echo site_url('reference/alat/post'); ?>"/>
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
