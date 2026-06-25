<?php 
	//print_r($arrdata);
?>
<div class="panel">
  <div class="ribbon ribbon-clip ribbon-info">
    <span class="ribbon-inner">
    <i class="icon md-boat margin-0" aria-hidden="true"></i> <?php echo $title; ?>
    </span>
  </div>
  <button type="submit" class="btn btn-sm btn-info navbar-right navbar-btn waves-effect waves-light" onclick="save_post('form_data','divgate'); return false;">
    <i class="icon md-badge-check"></i> SAVE
  </button>
  <div class="panel-body container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('execute/process/update/gatepass/'.$id); ?>" method="post" autocomplete="off" onsubmit="save_post('form_data','divgate'); return false;" popup="1">
          <div class="panel-body container-fluid">
            <div class="row">
              <div class="form-group form-material">
                <div class="col-sm-9">
                  <input type="hidden" name="DATA[ID]" id="ID" mandatory="no" class="form-control" value="<?php echo trim($arrdata['ID']); ?>">
                  <div class="hint">ID</div>
                </div>
              </div>
<!-- 			  <div class="form-group form-material">
                <div class="col-sm-9">
                  <input type="hidden" name="DATA[NO_SPK]" id="ID" mandatory="no" class="form-control" value="<?php echo trim($arrdata['NO_SPK']); ?>">
                  <div class="hint">NO. SPK</div>
                </div>
              </div> -->
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">JENIS DOKUMEN</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[JNS_DOK]" id="JNSDOK" mandatory="yes" class="form-control" placeholder="JENIS DOKUMEN" value="<?php echo trim($arrdata['JENIS DOKUMEN']); ?>" readonly="">
                  <div class="hint">JENIS DOKUMEN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NO. DOKUMEN</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NO_DOK]" id="NO_DOK" mandatory="yes" class="form-control" placeholder="NO. DOKUMEN" value="<?php echo trim($arrdata['NO. DOKUMEN']); ?>" readonly="">
                  <div class="hint">NO. DOKUMEN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">TANGGAL DOKUMEN</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[TGL_DOK]" id="TGL" mandatory="no" class="form-control date" placeholder="TANGGAL DOKUMEN" value="<?php echo trim($arrdata['TGL. DOKUMEN']); ?>" readonly="">
                  <div class="hint">TANGGAL DOKUMEN</div>
                </div>
              </div>
	     <div class="form-group form-material">
              <label class="col-sm-3 control-label">NAMA KAPAL</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NM_KAPAL]" id="NM_KAPAL" mandatory="yes" class="form-control" placeholder="NAMA KAPAL" value="<?php echo trim($arrdata['NAMA KAPAL']); ?>" >
                  <div class="hint">NAMA KAPAL</div>
                </div>
              </div>
	     <div class="form-group form-material">
              <label class="col-sm-3 control-label">NO. VOYAGE</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NO_VOY]" id="NO_VOY_FLIGHT" mandatory="yes" class="form-control" placeholder="NO. VOYAGE" value="<?php echo trim($arrdata['NO. VOYAGE']); ?>" readonly >
                  <div class="hint">NO. VOYAGE</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NAMA CUSTOMER</label>
                <div class="col-sm-8">
                  <input type="text" name="DATA[NAMA_CUST]" id="NAMA_CUST" mandatory="yes" class="form-control" placeholder="NAMA CUSTOMER" value="" readonly="">
                  <div class="hint">NAMA CUSTOMER</div>
                </div>
                <div class="col-sm-1">
                  <button type="button" class="btn btn-info btn-sm" onclick="popup_searchtwo('popup/popup_search/mt_customer/NPWP|NAMA_CUST/2');"><span class="icon md-search"></span></button>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NPWP</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NPWP]" id="NPWP" mandatory="yes" class="form-control" placeholder="NPWP" value="" readonly="">
                  <div class="hint">NPWP</div>
                </div>
              </div>
               <div class="form-group form-material">
                <label class="col-sm-3 control-label">JENIS KEGIATAN</label>
                <div class="col-sm-4">
                  <input type="text" name="DATA[JNS_KEGIATAN]" id="JNS_KEGIATAN" mandatory="no" class="form-control" placeholder="JENIS KEGIATAN" value="BEHANDLE 1" readonly="">
                  <div class="hint">JENIS KEGIATAN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NO KONTAINER</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NO_CONT]" id="NO_CONT" mandatory="yes" class="form-control" placeholder="NO. KONTAINER" value="<?php echo $arrdata['NO. KONTAINER']; ?>" readonly="">
                  <div class="hint">NO. KONTAINER</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">UKURAN KONTAINER</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[UKR_CONT]" id="UKR_CONT" mandatory="yes" class="form-control" placeholder="UKURAN KONTAINER" value="<?php echo $arrdata['UKURAN']; ?>" readonly="">
                  <div class="hint">UKURAN KONTAINER</div>
                </div>
              </div>
            </div>
          </div>
          <input type="hidden" name="action" id="action" readonly="readonly" value="<?php echo site_url('planning/get_pass_behandle/post'); ?>"/>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
$(function(){
date('date');
	autocomplete('ORGANISASI','/popup/autocomplete/mst_organisasi',function(event, ui){
		$('#KD_ORGANISASI').val(ui.item.KODE);
	});
	autocomplete('NM_KAPAL','/popup/autocomplete/mst_kapal',function(event, ui){    
		$('#NM_KAPAL').val(ui.item.label);
		$('#NO_VOY_FLIGHT').val(ui.item.NO_VOY);
	});
	
});
</script>
