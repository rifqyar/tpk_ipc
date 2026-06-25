<?php //var_dump($arrdata).'dssdsd';die(); ?>
<div class="panel">
  <div class="ribbon ribbon-clip ribbon-info">
  	<span class="ribbon-inner">
		<i class="icon md-file-text margin-0" aria-hidden="true"></i> <?php echo $title; ?>
    </span>
  </div>
  <!--<button type="submit" class="btn btn-sm btn-primary navbar-right navbar-btn waves-effect waves-light" onclick="save_post('form_data','divtblkapal'); return false;">
  	<i class="icon md-badge-check"></i> SAVE
  </button>
  --><BR><BR>
  <div class="panel-body container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('billingBehandle/process/update_behandle1/'.$id); ?>" method="post" autocomplete="off" onsubmit="save_post('form_data','tblbehandle'); return false;" popup="1">
          <div class="panel-body container-fluid">
            <div class="row">
              <div class="form-group form-material">
                <div class="col-sm-9">
                  <input type="hidden" name="DATA[ID]" id="ID" mandatory="no" class="form-control" value="<?php echo $id ?>">
                  <div class="hint">ID</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NO. SPK</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NO_SPK]" id="NO_SPK" mandatory="no" class="form-control" placeholder="NO. SPK" value="<?php echo $arrdata[0]['NO_SPK']; ?>" maxlength="50" >
                  <div class="hint">NO. SPK</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">TANGGAL SPK</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[TGL_SPK]" id="ADDRESS" mandatory="no" class="form-control" placeholder="TANGGAL SPK" value="<?php echo $arrdata[0]['TGL_SPK']; ?>" maxlength="50">
                  <div class="hint">TANGGAL SPK</div>
                </div>
              </div>
			   <div class="form-group form-material">
                <label class="col-sm-3 control-label">DATA KAPAL</label>
                <div class="col-sm-5">
                  <input type="text" name="DATA[NM_KAPAL]" id="NM_KAPAL" mandatory="no" class="form-control" placeholder="NAMA KAPAL" value="<?php echo $arrdata[0]['NM_KAPAL']; ?>" maxlength="50" >
                  <div class="hint">NAMA KAPAL</div>
                </div>
				<div class="col-sm-4">
                  <input type="text" name="DATA[NO_VOY]" id="NO_VOY" mandatory="no" class="form-control" placeholder="NO. VOYAGE" value="<?php echo $arrdata[0]['NO_VOY']; ?>" maxlength="50" >
                  <div class="hint">NO. VOYAGE</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">PAKET BEHANDLE</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[JNS_KEGIATAN]" id="ADDRESS" mandatory="no" class="form-control" placeholder="PAKET BEHANDLE" value="<?php echo $arrdata[0]['JNS_KEGIATAN']; ?>" maxlength="50" >
                  <div class="hint">PAKET BEHANDLE</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">JENIS DOKUMEN</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[JNS_DOK]" id="JNS_DOK" mandatory="no" class="form-control" placeholder="JENIS DOKUMEN" value="<?php echo $arrdata[0]['JNS_DOK']; ?>" maxlength="20">
                  <div class="hint">JENIS DOKUMEN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <div class="col-sm-9">
                  <input type="hidden" name="DATA[TGL_DOK]" id="JNS_DOK" mandatory="no" class="form-control" placeholder="JENIS DOKUMEN" value="<?php echo $arrdata[0]['TGL_DOK']; ?>" maxlength="20" >
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NAMA CUSTOMER</label>
                <div class="col-sm-8">
                  <input type="text" name="DATA[CUSTOMER]" id="CUSTOMER" mandatory="no" class="form-control" placeholder="NAMA CUSTOMER" maxlength="20" value="<?php echo $arrdata[0]['NAMA_CUST']; ?>" required>
                  <div class="hint">NAMA CUSTOMER</div>
                </div>
                <div class="col-sm-1">
                  <button type="button" class="btn btn-info btn-sm" onclick="popup_searchtwo('popup/popup_search/mt_customer/NPWP|CUSTOMER/2');"><span class="icon md-search"></span></button>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NPWP</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NPWP]" id="NPWP" mandatory="no" class="form-control" placeholder="NPWP" value="<?php echo $arrdata[0]['NPWP']; ?>" maxlength="20" >
                  <div class="hint">NPWP</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NO. DOKUMEN</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NO_DOK]" id="CONTACT_PERSON" mandatory="no" class="form-control" placeholder="NO. DOKUMEN" value="<?php echo $arrdata[0]['NO_DOK']; ?>" maxlength="10" >
                  <div class="hint">NO. DOKUMEN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NO. DO</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NO_DO]" id="CONTACT_PERSON" mandatory="no" class="form-control" placeholder="NO. DO" value="<?php echo $arrdata[0]['NO_DO']; ?>" maxlength="10">
                  <div class="hint">NO. DO</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NO. BL</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NO_BL]" id="CONTACT_PERSON" mandatory="no" class="form-control" placeholder="NO. BL" value="<?php echo $arrdata[0]['NO_BL']; ?>" maxlength="10">
                  <div class="hint">NO. BL</div>
                </div>
              </div>
            </div>
          </div>
          <input type="hidden" name="action" id="action" readonly="readonly" value="<?php echo site_url('billingBehandle/behandle/post'); ?>"/>
        </form>
    	   	<button type="submit" class="btn btn-sm btn-info navbar-center navbar-btn waves-effect waves-light" onclick="save_post('form_data','tblbehandle'); return false;">
    		  <i class="icon md-badge-check"></i> SAVE
  	   </button>
      </div>
    </div>
  </div>
  <?php
	//echo $jadwal;
  ?>
</div>
<script>
$(function(){
	date('date');
	autocomplete('NM_KAPAL','/popup/autocomplete/mst_customer/nama',function(event, ui){
		$('#CUSTOMER').val(ui.item.CUSTOMER);
	});
	/*autocomplete('KD_PEL_MUAT','/popup/autocomplete/mst_port/kode',function(event, ui){
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
