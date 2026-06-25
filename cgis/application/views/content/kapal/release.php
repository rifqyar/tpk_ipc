<?php //print_r($action);die(); ?>
<div class="panel">
  <div class="ribbon ribbon-clip ribbon-primary">
  	<span class="ribbon-inner">
		<i class="icon md-boat margin-0" aria-hidden="true"></i> REALISASI<?php //echo $title; ?>
    </span>
  </div>
  <button type="submit" class="btn btn-sm btn-primary navbar-right navbar-btn waves-effect waves-light" onclick="save_post('form_data','tblkapallist'); return false;">
  	<i class="icon md-badge-check"></i> SAVE
  </button>
  <div class="panel-body container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('execute/process/'.$action.'/realisasi/'.$id); ?>" method="post" autocomplete="off" onsubmit="save_post('form_data','divtblkapal'); return false;" popup="1">
          <div class="panel-body container-fluid">
            <div class="row">
              <div class="form-group form-material">
                <div class="col-sm-9">
                  <input type="hidden" name="DATA[ID]" id="ID" mandatory="no" class="form-control" value="<?php echo trim($arrdata['ID']); ?>">
                  <div class="hint">ID</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">ATA</label>
                <div class="col-sm-5">
                  <input type="text" name="DATA[ATA]" id="ATA" mandatory="yes" class="form-control datetime" placeholder="ATA" value="<?php echo $arrdata['ATA']; ?>" maxlength="10">
                  <div class="hint">ATA</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">ATD</label>
                <div class="col-sm-5">
                  <input type="text" name="DATA[ATD]" id="ATD" mandatory="yes" class="form-control datetime" placeholder="ATD" value="<?php echo $arrdata['ATD']; ?>" maxlength="10">
                  <div class="hint">ATD</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NO. PPKB</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NO_PPKB]" id="NO_PPKB" mandatory="no" class="form-control" placeholder="NO. PPKB" value="<?php echo trim($arrdata['NO_PPKB']); ?>">
                  <div class="hint">NO. PPKB</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">WAKTU DISCHARGE</label>
                <div class="col-sm-9">
                  <input class="form-control datetime" type="text" placeholder="WAKTU DISCHARGE" name="DATA[WK_DISCH]" id="WK_DISCH" mandatory="yes" value="<?php echo $arrdata['WK_DISCH']; ?>">
                  <div class="hint">WAKTU DISCHARGE</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">JUMLAH MUATAN</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[JMLH_MUAT]" id="JMLH_MUAT" mandatory="no" class="form-control" placeholder="JUMLAH MUATAN" value="<?php echo trim($arrdata['JMLH_MUAT']); ?>">
                  <div class="hint">JUMLAH MUATAN</div>
                </div>
              </div>
            </div>
          </div>
          <input type="hidden" name="action" id="action" readonly="readonly" value="<?php echo site_url('planning/shipment/post'); ?>"/>
        </form>
      </div>
    </div>
  </div>
  <?php
	echo $jadwal;
  ?>
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
