<?php //print_r($arrdata);die(); ?>

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
    <i class="icon md-account margin-0" aria-hidden="true"></i> <?php echo $title; ?>
    </span>
  </div>
  <button type="submit" class="btn btn-sm btn-primary navbar-right navbar-btn waves-effect waves-light" onclick="save_post('form_data','divcustomer'); return false;">
    <i class="icon md-badge-check"></i> SAVE
  </button>
  <div class="panel-body container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('execute/process/'.$action.'/customs2/'.$id); ?>" method="post" autocomplete="off" onsubmit="save_post('form_data','divcustomer'); return false;" popup="1">
          <div class="panel-body container-fluid">
            <div class="row">
              <div class="form-group form-material">
                <div class="col-sm-9">
                  <input type="hidden" name="DATA[ID]" id="ID" mandatory="no" class="form-control" value="<?php echo trim($arrdata['ID']); ?>">
                  <div class="hint">ID</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NO. SPK</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NO_SPK]" id="NO_SPK" mandatory="yes" class="form-control" placeholder="NO. SPK" value="<?php echo trim($arrdata['NO_SPK']); ?>" readonly>
                  <div class="hint">NO. SPK</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NO. KONTAINER</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NO_CONT]" id="NO_CONT" mandatory="yes" class="form-control" placeholder="NO. KONTAINER" value="<?php echo $arrdata['NO_CONT']; ?>" readonly>
                  <div class="hint">NO. KONTAINER</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">JENIS DOKUMEN</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[JNS_DOK]" id="JNS_DOK" mandatory="yes" class="form-control" placeholder="JENIS DOKUMEN" value="<?php echo $arrdata['NAMA']; ?>" readonly>
                  <div class="hint">JENIS DOKUMEN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NO. DOKUMEN</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NO_DOK]" id="NO_DOK" mandatory="yes" class="form-control" placeholder="NO DOKUMEN" value="<?php echo $arrdata['NO_DOK']; ?>" readonly>
                  <div class="hint">NO. DOKUMEN</div>
                </div>
              </div>
                <div class="form-group form-material">
                <label class="col-sm-3 control-label">NAMA CUSTOMERS</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NAMA_CUST]" id="NAMA_CUST" mandatory="yes" mandatory="yes" class="form-control" placeholder="NAMA CUSTOMERS" value="<?php echo $arrdata['CONSIGNEE']; ?>" maxlength="15"  readonly> <!--onkeypress="return onlyNos(event,this);"-->
                  <div class="hint">NAMA CUSTOMERS</div>
                </div>
              </div>
              <div class="form-group form-material">
              <label class="col-sm-3 control-label">RESPON CUSTOMS</label>
              <div class="col-sm-9">
			  <!--onkeypress="return onlyNos(event,this);"-->
                <input type="text" name="DATA[RESPON]" id="RESPON" mandatory="yes" mandatory="yes" class="form-control" placeholder="RESPON CUSTOMS" value="<?php echo $arrdata['RESPON']; ?>" maxlength="15" >
                <div class="hint">RESPON CUSTOMS</div>
              </div>
            </div>
            </div>
          </div>
          <input type="hidden" name="action" id="action" readonly="readonly" value="<?php echo site_url('display/respon_custom/post'); ?>"/>
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
