<?php //print_r($action);die(); ?>
<div class="panel">
  <div class="ribbon ribbon-clip ribbon-primary">
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
        <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('execute/process/save/behandle2/'.$id); ?>" method="post" autocomplete="off" onsubmit="save_post('form_data','tblbehandle'); return false;" popup="1">
          <div class="panel-body container-fluid">
            <div class="row">
              <div class="form-group form-material">
                <div class="col-sm-9">
                  <input type="hidden" name="DATA[ID]" id="ID_REQ" mandatory="no" class="form-control" value="<?php echo trim($arrdata['ID']); ?>">
                  <div class="hint">ID</div>
                </div>
              </div>
			  <!--
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NO REQUEST</label>
                <div class="col-sm-5">
                  <input type="hidden" name="DATA[NO_REQ]" id="NO_REQ" mandatory="no" class="form-control" placeholder="NO_REQ" value="DEL/24-11-2016/001<?php //echo $arrdata['NO_REQ']; ?>" maxlength="10">
                  <div class="hint">NO REQUEST</div>
                </div>
              </div>
			  -->
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">JENIS DOKUMEN</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[JNS_DOK]" id="JNS_DOK" mandatory="no" class="form-control" placeholder="JENIS DOKUMEN" value="<?php echo $arrdata[0]->JNS_DOK; ?>" maxlength="10" readonly>
                  <div class="hint">JENIS DOKUMEN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NO. DOKUMEN</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NO_DOK]" id="NO_DOK" mandatory="no" class="form-control" placeholder="JENIS DOKUMEN" value="<?php echo $arrdata[0]->NO_DOK; ?>" maxlength="10" readonly>
                  <div class="hint">NO. DOKUMEN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">TANGGAL DOKUMEN</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[TGL_DOK]" id="JNS_DOK" mandatory="no" class="form-control" placeholder="TANGGAL DOKUMEN" value="<?php echo $arrdata[0]->TGL_DOK; ?>" maxlength="10" readonly>
                  <div class="hint">TANGGAL DOKUMEN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">PAKET BEHANDLE</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[JNS_KEGIATAN]" id="JNS_KEGIATAN" mandatory="no" class="form-control" placeholder="PAKET BEHANDLE" value="BEHANDLE 2" maxlength="10" readonly>
                  <div class="hint">PAKET BEHANDLE</div>
                </div>
              </div>
              <div class="form-group form-material">
                <div class="col-sm-9">
                  <input type="hidden" name="DATA[TGL_DOK]" id="JNS_DOK" mandatory="no" class="form-control" placeholder="JENIS DOKUMEN" value="<?php echo $arrdata[0]->TGL_DOK; ?>" maxlength="20" readonly>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">CUSTOMER</label>
                <div class="col-sm-8">
                  <input type="text" name="DATA[CUSTOMER]" id="CUSTOMER" mandatory="no" class="form-control" placeholder="CUSTOMER" value="<?php //echo $arrdata['CUSTOMER']; ?>" maxlength="50">
                  <div class="hint">CUSTOMER</div>
                </div>
                <div class="col-sm-1">
                  <button type="button" class="btn btn-primary btn-sm" onclick="popup_searchtwo('popup/popup_search/mt_customer/NPWP|CUSTOMER/2');"><span class="icon md-search"></span></button>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NPWP</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NPWP]" id="NPWP" mandatory="no" class="form-control" placeholder="NPWP" value="<?php echo $arrdata[0]->NPWP_PPJK; ?>" maxlength="20" >
                  <div class="hint">NPWP</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NO. DO</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NO_DO]" id="CONTACT_PERSON" mandatory="no" class="form-control" placeholder="NO. DO" value="<?php //echo $arrdata['CONTACT_PERSON']; ?>" maxlength="50">
                  <div class="hint">NO. DO</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NO. BL</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NO_BL]" id="CONTACT_PERSON" mandatory="no" class="form-control" placeholder="NO. BL" value="<?php //echo $arrdata['CONTACT_PERSON']; ?>" maxlength="10">
                  <div class="hint">NO. BL</div>
                </div>
              </div>
            </div>
          </div>
		  <div class="container">
         	<div class="form-group form-material">

		  <div class="ribbon ribbon-clip ribbon-primary">
			<span class="ribbon-inner">
				<i class="icon md-file-text margin-0" aria-hidden="true"></i> Detail Kontainer<?php //echo $title; ?>
			</span>
		  </div>
		  <br><Br><br><Br>
  			<table class="table">
            		<th>NO KONTAINER</th>
            		<th>SIZE</th>
            	</tr>
            	<tr>
            		<td><input type="text" class="form-control focus" name="DT[NO_CONT][]" value="<?php echo $arrdata[0]->NO_CONT; ?>" readonly></td>
            		<th><input type="text" class="form-control focus" id="ukrcont" name="DT[UKR_CONT][]" value="<?php echo $arrdata[0]->UKR_CONT; ?>" readonly></th>
 				       </tr>

 				 </table>
			 </div>
          <input type="hidden" name="action" id="action" readonly="readonly" value="<?php echo site_url('billing/behandle/post'); ?>"/>
        </form>
    	   	<button type="submit" class="btn btn-sm btn-primary navbar-center navbar-btn waves-effect waves-light" onclick="save_post('form_data','tblbehandle'); return false;">
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
