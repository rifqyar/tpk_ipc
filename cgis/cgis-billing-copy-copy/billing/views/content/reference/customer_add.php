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
  <div class="ribbon ribbon-clip ribbon-info">
    <span class="ribbon-inner">
    <i class="icon md-account margin-0" aria-hidden="true"></i> <?php echo $title; ?>
    </span>
  </div>
  <button type="submit" class="btn btn-sm btn-info navbar-right navbar-btn waves-effect waves-light" onclick="save_post('form_data','divcustomer'); return false;">
    <i class="icon md-badge-check"></i> SAVE
  </button>
  <div class="panel-body container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('execute/process/'.$action.'/customer2/'.$id); ?>" method="post" autocomplete="off" onsubmit="save_post('form_data','divcustomer'); return false;" popup="1">
          <div class="panel-body container-fluid">
            <div class="row">
              <div class="form-group form-material">
                <div class="col-sm-9">
                  <input type="hidden" name="DATA[ID]" id="ID" mandatory="no" class="form-control" value="<?php echo trim($arrdata['ID']); ?>">
                  <div class="hint">ID</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NO. NPWP</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NPWP]" id="NPWP" mandatory="yes" class="form-control" placeholder="NO. NPWP" value="<?php echo trim($arrdata['NPWP']); ?>">
                  <div class="hint">NO. NPWP</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NAMA CUSTOMER</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NAMA_CUST]" id="NAMA_CUST" mandatory="yes" class="form-control" placeholder="NAMA CUSTOMER" value="<?php echo $arrdata['NAMA_CUST']; ?>">
                  <div class="hint">NAMA_CUST</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">ALAMAT</label>
                <div class="col-sm-9">
                  <!--<input type="text" name="DATA[ALAMAT]" id="ALAMAT" mandatory="yes" class="form-control" placeholder="ALAMAT" value="<?php// echo $arrdata['ALAMAT']; ?>" maxlength="500">-->
				  <textarea class="form-control" name="DATA[ALAMAT]" id="ALAMAT" mandatory="yes" placeholder="ALAMAT"><?php echo $arrdata['ALAMAT']; ?></textarea>
                  <div class="hint">ALAMAT</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">E-MAIL</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[EMAIL]" id="EMAIL" mandatory="no" class="form-control" placeholder="E-MAIL" value="<?php echo $arrdata['EMAIL']; ?>" maxlength="30">
                  <div class="hint">E-MAIL</div>
                </div>
              </div>
                <div class="form-group form-material">
                <label class="col-sm-3 control-label">TELEPON</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[TELEPON]" id="TELEPON" mandatory="yes" mandatory="yes" class="form-control" placeholder="TELEPON" value="<?php echo $arrdata['TELEPON']; ?>" maxlength="15"  > <!--onkeypress="return onlyNos(event,this);"-->
                  <div class="hint">TELEPON</div>
                </div>
              </div>
              <div class="form-group form-material">
              <label class="col-sm-3 control-label">TELEPON KANTOR</label>
              <div class="col-sm-9">
			  <!--onkeypress="return onlyNos(event,this);"-->
                <input type="text" name="DATA[TLP_KANTOR]" id="TELEPON_KANTOR" mandatory="no" mandatory="yes" class="form-control" placeholder="TELEPON KANTOR" value="<?php echo $arrdata['TLP_KANTOR']; ?>" maxlength="15"  >
                <div class="hint">TELEPON KANTOR</div>
              </div>
            </div>
            </div>
          </div>
          <input type="hidden" name="action" id="action" readonly="readonly" value="<?php echo site_url('reference/customer/post'); ?>"/>
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
