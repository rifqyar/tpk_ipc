<?php //echo "sini"; ?>
<div class="panel">
  <div class="ribbon ribbon-clip ribbon-primary">
    <span class="ribbon-inner">
    <i class="icon md-boat margin-0" aria-hidden="true"></i> <?php echo $title; ?>
    </span>
  </div>
  <button type="submit" class="btn btn-sm btn-primary navbar-right navbar-btn waves-effect waves-light" onclick="save_post('form_data','divcustomer'); return false;">
    <i class="icon md-badge-check"></i> SAVE
  </button>
  <div class="panel-body container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('execute/process/update/gatepass2/'.$id); ?>" method="post" autocomplete="off" onsubmit="save_post('form_data','divtblkapal'); return false;" popup="1">
          <div class="panel-body container-fluid">
            <div class="row">
              <div class="form-group form-material">
                <div class="col-sm-9">
                  <input type="hidden" name="DATA[ID]" id="ID" mandatory="no" class="form-control" value="<?php echo trim($arrdata['X.ID']); ?>">
                  <div class="hint">ID</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">JENIS DOKUMEN</label>
                <div class="col-sm-8">
                  <input type="text" name="DATA[JNS_DOK]" id="JNS_DOK" mandatory="yes" class="form-control" placeholder="JENIS DOKUMEN" value="" readonly="">
                  <div class="hint">JENIS DOKUMEN</div>
                </div>
                <div class="col-sm-1">
                  <button type="button" class="btn btn-primary btn-sm" onclick="popup_searchtwo('popup/popup_search/mst_all_dok/JNS_DOK|NO_DOK|TGL_DOK/2');"><span class="icon md-search"></span></button>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NO. DOKUMEN</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NO_DOK]" id="NO_DOK" mandatory="yes" class="form-control" placeholder="NO. DOKUMEN" readonly="">
                  <div class="hint">NO. DOKUMEN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">TANGGAL DOKUMEN</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[TGL_DOK]" id="TGL_DOK" mandatory="yes" class="form-control" placeholder="TANGGAL DOKUMEN" readonly="">
                  <div class="hint">TANGGAL DOKUMEN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NAMA CUSTOMER</label>
                <div class="col-sm-8">
                  <input type="text" name="DATA[NAMA_CUST]" id="NAMA_CUST" mandatory="yes" class="form-control" placeholder="NAMA CUSTOMER" value="" readonly="">
                  <div class="hint">NAMA CUSTOMER</div>
                </div>
                <div class="col-sm-1">
                  <button type="button" class="btn btn-primary btn-sm" onclick="popup_searchtwo('popup/popup_search/mt_customer/NPWP|NAMA_CUST/2');"><span class="icon md-search"></span></button>
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
                  <input type="text" name="DATA[JNS_KEGIATAN]" id="NPWP" mandatory="no" class="form-control" placeholder="JENIS KEGIATAN" value="BEHANDLE 2" readonly="yes">
                  <div class="hint">JENIS KEGIATAN</div>
                </div>
              </div>

	      <div class="form-group form-material">
              <label class="col-sm-3 control-label">NAMA KAPAL</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NM_KAPAL]" id="KAPAL" mandatory="yes" class="form-control" placeholder="NO. NPWP" value="<?php echo trim($arrdata['NM_KAPAL']); ?>" readonly>
                  <div class="hint">NAMA KAPAL</div>
                </div>
              </div>
	     <div class="form-group form-material">
              <label class="col-sm-3 control-label">NO. VOYAGE</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NO_VOY]" id="VOY" mandatory="yes" class="form-control" placeholder="NO. VOYAGE" value="<?php echo trim($arrdata['NO_VOY']); ?>" readonly>
                  <div class="hint">NO. VOYAGE</div>
                </div>
              </div>

              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NO KONTAINER</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NO_CONT]" id="NAMA_CUST" mandatory="yes" class="form-control" placeholder="NAMA CUSTOMER" value="<?php echo $arrdata['NO_CONT']; ?>" readonly="">
                  <div class="hint">NO. KONTAINER</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">UKURAN KONTAINER</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[UKR_CONT]" id="NAMA_CUST" mandatory="yes" class="form-control" placeholder="NAMA CUSTOMER" value="<?php echo $arrdata['UKR_CONT']; ?>" readonly="">
                  <div class="hint">UKURAN KONTAINER</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NO DOK</label>
                <div class="col-sm-9">
                  <input type="text" name="DOK" id="NAMA_CUST" mandatory="yes" class="form-control" placeholder="NAMA CUSTOMER" value="<?php echo $arrdata['NO_DOK']; ?>" readonly="">
                  <div class="hint">UKURAN KONTAINER</div>
                </div>
              </div>
              <div class="form-group form-material">
                <div class="col-sm-9">
                  <input type="hidden" name="DATA[NO_SPK]" id="SPK" mandatory="no" class="form-control" placeholder="NAMA CUSTOMER" value="<?php echo $spk['NO_SPK']; ?>" readonly="">
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
