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
        <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('execute/process/'.$action.'/delivery/'.$id); ?>" method="post" autocomplete="off" onsubmit="save_post('form_data','divtblkapal'); return false;" popup="1">
          <div class="panel-body container-fluid">
            <div class="row">
              <div class="form-group form-material">
                <div class="col-sm-9">
                  <input type="hidden" name="DATA[ID_REQ]" id="ID_REQ" mandatory="no" class="form-control" value="<?php echo trim($arrdata[0]->ID_REQ); ?>">
                  <div class="hint">ID_REQ</div>
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
                <label class="col-sm-3 control-label">VOYAGE</label>
                <div class="col-sm-5">
                  <input type="text" name="DATA[VOYAGE]" id="NO_DOK" mandatory="no" class="form-control" placeholder="VOYAGE" value="<?php echo $arrdata[0]->NO_VOY_FLIGHT; ?>" maxlength="10">
                  <div class="hint">VOYAGE</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">CUSTOMER</label>
                <div class="col-sm-5">
                  <input type="text" name="DATA[CUSTOMER]" id="CUSTOMER" mandatory="no" class="form-control" placeholder="CUSTOMER" value="<?php //echo $arrdata['CUSTOMER']; ?>" maxlength="10">
                  <div class="hint">CUSTOMER</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">ADDRESS</label>
                <div class="col-sm-5">
                  <input type="text" name="DATA[ADDRESS]" id="ADDRESS" mandatory="no" class="form-control" placeholder="ADDRESS" value="<?php //echo $arrdata[0]->ALAMAT_CONSIGNEE; ?>" maxlength="10">
                  <div class="hint">ADDRESS</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NPWP</label>
                <div class="col-sm-5">
                  <input type="text" name="DATA[NPWP]" id="NPWP" mandatory="no" class="form-control" placeholder="NPWP" value="<?php echo $arrdata[0]->NPWP_PPJK; ?>" maxlength="10">
                  <div class="hint">NPWP</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">CONTACT PERSON</label>
                <div class="col-sm-5">
                  <input type="text" name="DATA[CONTACT_PERSON]" id="CONTACT_PERSON" mandatory="no" class="form-control" placeholder="CONTACT PERSON" value="<?php //echo $arrdata['CONTACT_PERSON']; ?>" maxlength="10">
                  <div class="hint">CONTACT PERSON</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">TYPE</label>
                <div class="col-sm-5">
                  <input type="text" name="DATA[TYPE]" id="TYPE" mandatory="no" class="form-control" placeholder="TYPE" value="<?php echo $arrdata[0]->KD_DOK_INOUT; ?>" maxlength="10">
                  <div class="hint">TYPE</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NO DOKUMEN</label>
                <div class="col-sm-5">
                  <input type="text" name="DATA[NO_DOK]" id="NO_DOK" mandatory="no" class="form-control" placeholder="NO_DOK" value="<?php echo $arrdata[0]->NO_DAFTAR_PABEAN; ?>" maxlength="10">
                  <div class="hint">NO DOKUMEN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">DATE OF DELIVERY</label>
                <div class="col-sm-5">
                  <input type="text" name="DATA[PAIDTHRU]" id="ATD" mandatory="yes" class="form-control date" placeholder="PAIDTHRU" value="<?php //echo $arrdata['ATD']; ?>" maxlength="10">
                  <div class="hint">PAIDTHRU</div>
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
            		 <th>TYPE</th>
            		<th>STATUS</th>
            	</tr>
				<?php
					$no = 0;
					foreach($detail_cont as $data){
						//$no++;
				?>
            	<tr>
            		<td><input type="text" class="form-control focus" name="DATA[NO_CONT]" value="<?php echo $data->NO_CONT; ?>"></td>
            		<th><input type="text" class="form-control focus" id="ukrcont" name="DATA[UK_CONT]" value="<?php echo $data->KD_CONT_UKURAN; ?>"></th>
            		<td>
 					<select class="form-control focus" id="product" name="DATA[ISO_CODE]" onchange="proses()">
 						<option value="DRY">DRY</option>
 						<option value="HQ">HQ</option>
 						<option value="QT">QT</option>
 					</select>
 					</td>
 					<td>
 						<select class="form-control focus" id="product" name="DATA[STATUS]" onchange="proses()">
 						<option value="FULL">FULL</option>
 						<option value="EMPTY">EMPTY</option>
 					</select>
 					</td>
 				</tr>
				<?php } ?>
 				<tr>
 					<!--<td colspan="4" style="text-align: center"><input type="submit" class="btn btn-primary" value="SAVE" ></td>-->
 				</tr>
           	</table>
			</div>
          <input type="hidden" name="action" id="action" readonly="readonly" value="<?php echo site_url('billing/delivery/post'); ?>"/>
        </form>
		<button type="submit" class="btn btn-sm btn-primary navbar-center navbar-btn waves-effect waves-light" onclick="save_post('form_data','divtblkapal'); return false;">
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
