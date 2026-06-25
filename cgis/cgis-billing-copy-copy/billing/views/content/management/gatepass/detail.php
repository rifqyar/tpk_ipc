
<script language="Javascript" type="text/javascript">
       function onlyNos(e, t) {
           try {
               if (window.event) {
                   var charCode = window.event.keyCode;
               }
               else if (e) {
                   var charCode = e.which;
               }
               else { return true; }
               if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                   return false;
               }
               return true;
           }
           catch (err) {
               alert(err.Description);
           }
       }
   </script>

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
        <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('execute/process/update/gatepass/'.$id); ?>" method="post" autocomplete="off" onsubmit="save_post('form_data','divtblkapal'); return false;" popup="1">
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
                <div class="col-sm-9">
                  <input type="text" name="DATA[JNS_DOK]" id="JNSDOK" mandatory="yes" class="form-control" placeholder="NO. NPWP" value="<?php echo trim($arrdata['JENIS DOKUMEN']); ?>">
                  <div class="hint">JENIS DOKUMEN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NO. DOKUMEN</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NO_DOK]" id="NPWP" mandatory="yes" class="form-control" placeholder="NO. NPWP" value="<?php echo trim($arrdata['NO. DOKUMEN']); ?>">
                  <div class="hint">NO. DOKUMEN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">TANGGAL DOKUMEN</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[TGL_DOK]" id="TGL" mandatory="yes" class="form-control" placeholder="NO. NPWP" value="<?php echo trim($arrdata['TGL. DOKUMEN']); ?>">
                  <div class="hint">TANGGAL DOKUMEN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">STATUS</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[STATUS]" id="TGL" mandatory="yes" class="form-control" placeholder="STATUS" required>
                  <div class="hint">STATUS</div>
                </div>
              </div>
               <div class="form-group form-material">
                <label class="col-sm-3 control-label">JENIS KEGIATAN</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[JNS_KEGIATAN]" id="TGL" mandatory="yes" class="form-control" placeholder="JENIS KEGIATAN" required>
                  <div class="hint">STATUS</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NO KONTAINER</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NO_CONT]" id="NAMA_CUST" mandatory="yes" class="form-control" placeholder="NAMA CUSTOMER" value="<?php echo $arrdata['NO. KONTAINER']; ?>">
                  <div class="hint">NO. KONTAINER</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">UKURAN KONTAINER</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[UKR_CONT]" id="NAMA_CUST" mandatory="yes" class="form-control" placeholder="NAMA CUSTOMER" value="<?php echo $arrdata['UKURAN']; ?>">
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
