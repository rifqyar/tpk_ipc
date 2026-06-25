<?php //print_r($arrdata);die(); ?>

<div class="panel">
  <div class="ribbon ribbon-clip ribbon-info">
    <span class="ribbon-inner">
    <i class="icon md-file-text margin-0" aria-hidden="true"></i> <?php echo "BILLING DELIVERY EXT"; ?>
    </span>
  </div>
  <!--<button type="submit" class="btn btn-sm btn-primary navbar-right navbar-btn waves-effect waves-light" onclick="save_post('form_data','divtblkapal'); return false;">
    <i class="icon md-badge-check"></i> SAVE
  </button>
  --><BR><BR>
  <div class="panel-body container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('billingDeliveryExt/process/'.$action.'/'.$id); ?>" method="post" autocomplete="off" onsubmit="save_post('form_data','tbldeliveryext'); return false;" popup="1">
          <div class="panel-body container-fluid">
            <div class="row">
              <div class="form-group form-material">
                <div class="col-sm-9">
                  <input type="hidden" name="DATA[ID]" id="ID" mandatory="no" class="form-control" value="<?php echo trim($arrdata[0]->ID_REQ); ?>">
                  <input type="hidden" name="DATA[TGL_DOK]" id="ID_REQ" class="form-control" value="<?php echo trim($arrdata[0]->TGL_DOK); ?>">
                  <input type="hidden" name="DATA[NO_BL]" id="NO_BL" class="form-control" value="<?php echo trim($arrdata[0]->NO_BL); ?>">
                  <input type="hidden" name="DATA[NM_KAPAL]" id="NO_BL" class="form-control" value="<?php echo trim($arrdata[0]->NM_KAPAL); ?>">
                  <div class="hint">TGL_DOK</div>
                </div>
              </div>
        <!--
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NO REQUEST</label>
                <div class="col-sm-9">
                  <input type="hidden" name="DATA[NO_REQ]" id="NO_REQ" mandatory="no" class="form-control" placeholder="NO_REQ" value="DEL/24-11-2016/001<?php //echo $arrdata['NO_REQ']; ?>" maxlength="10">
                  <div class="hint">NO REQUEST</div>
                </div>
              </div>
        -->
			  <div class="form-group form-material">
                <label class="col-sm-3 control-label">NOTA OLD</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NOTA_OLD]" id="NOTA_OLD" mandatory="yes" readonly class="form-control" placeholder="NOTA OLD" value="<?php echo $arrdata[0]->NO_NOTA_DELIVERY; ?>" maxlength="10">
                  <div class="hint">NOTA OLD</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NAMA KAPAL</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NM_KAPAL]" id="NO_DOK" mandatory="no" readonly class="form-control" placeholder="NAMA KAPAL" value="<?php echo $arrdata[0]->NM_KAPAL; ?>" maxlength="10">
                  <div class="hint">NAMA KAPAL</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">VOYAGE</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[VOYAGE]" id="NO_DOK" mandatory="no" readonly class="form-control" placeholder="VOYAGE" value="<?php echo $arrdata[0]->NO_VOY; ?>" maxlength="10">
                  <div class="hint">VOYAGE</div>
                </div>
              </div>
              
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">CUSTOMER</label>
                <div class="col-sm-8">
                  <input type="text" name="DATA[CUSTOMER]" id="CUSTOMER" readonly mandatory="no" class="form-control" placeholder="CUSTOMER" value="<?php echo $arrdata[0]->NAMA_CUST; ?>" maxlength="10">
                  <div class="hint">CUSTOMER</div>
                </div>
              </div>
                <!--
                <div class="col-sm-1">
                  <button type="button" class="btn btn-primary btn-sm" onclick="popup_searchtwo('popup/popup_search/mt_customer/NPWP|CUSTOMER/2');"><span class="icon md-search"></span></button>
                </div>

              </div>-->
              <!--<div class="form-group form-material">
                <label class="col-sm-3 control-label">ADDRESS</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[ADDRESS]" id="ADDRESS" mandatory="no" class="form-control" placeholder="ADDRESS" value="<?php //echo $arrdata[0]->ALAMAT_CONSIGNEE; ?>" maxlength="10">
                  <div class="hint">ADDRESS</div>
                </div>
              </div>
              -->
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NPWP</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NPWP]" id="NPWP" mandatory="no" readonly class="form-control" placeholder="NPWP" value="<?php echo $arrdata[0]->NPWP; ?>" maxlength="10">
                  <div class="hint">NPWP</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NO. DO</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NO_DO]" id="CONTACT_PERSON" readonly mandatory="no" class="form-control" placeholder="NO. DO" value="<?php echo $arrdata[0]->NO_DO; ?>" maxlength="50">
                  <div class="hint">NO. DO</div>
                </div>
              </div>
              <!--
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">TYPE</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[TYPE]" id="TYPE" mandatory="no" class="form-control" placeholder="TYPE" value="<?php //echo $arrdata[0]->KD_DOK_INOUT; ?>" maxlength="10">
                  <div class="hint">TYPE</div>
                </div>
                
              </div>-->
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NO DOKUMEN</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NO_DOK]" id="NO_DOK" mandatory="no" readonly class="form-control" placeholder="NO_DOK" value="<?php echo $arrdata[0]->NO_DOK; ?>" maxlength="10">
                  <div class="hint">NO DOKUMEN</div>
                </div>
              </div>
              <div class="form-group form-material">
				<label class="col-sm-3 control-label">DATE OF DELIVERY</label>
				<div class="col-sm-9">
					<input type="text" name="DATA[PAIDTHRU]" id="ATD" mandatory="yes" class="form-control date" placeholder="PAIDTHRU" value="<?php //echo $arrdata['ATD']; ?>" maxlength="10">
					<div class="hint">PAIDTHRU</div>
				</div>
			</div>
			<div class="form-group form-material">
				<label class="col-sm-3 control-label"></label>
				<div class="col-sm-9">
					<input type="checkbox" id="CB_NHI" name="question"> NHI
				</div>
			</div>
			<div class="form-group form-material" id="TGLNHI">
				<label class="col-sm-3 control-label">TANGGAL NHI</label>
				<div class="col-sm-9">
					<input type="text" name="DATA[TGL_NHI]" id="ICB_NHI" mandatory="no" class="form-control date" placeholder="TGL NHI">
					<div class="hint">TANGGAL NHI</div>
				</div>
			</div>
			<div class="form-group form-material" id="TGLBUKASEGEL">
				<label class="col-sm-3 control-label">TANGGAL BUKA SEGEL</label>
				<div class="col-sm-9">
					<input type="text" name="DATA[TGL_BK_SEGEL]" id="ICB_BK_SEGEL" mandatory="no" class="form-control date" placeholder="TGL BUKA SEGEL">
					<div class="hint">BUKA SEGEL</div>
				</div>
			</div>
            </div>
          </div>
      <div class="container">
      <br>
        <table class="table">
               <tr> 
				<th>
                  <!--<input type="checkbox" class="chk_boxes" name="all" label="check all"  />All-->
                </th>
                <th>NO KONTAINER</th>
                <th>SIZE</th>
                <th>TYPE</th>
                <th>STATUS</th>
                <th>DG</th>
              </tr>
        <?php 
          $no = 0;
          foreach($detail_cont as $data){
            
        ?>
        <tr>
            <td>
              <span class="chexbox-custom chexbox-info">
                <input type="checkbox" onclick="check('chk_cont', 'cont_post')" class="chk_boxes1" name="chk_cont" id='chk_cont' value="<?php echo $data->ID_REQ."~".$data->NO_CONT; ?>">
                <label for="" id="ckk"></label>
              </span>
            </td>
            <td><input type="text" class="form-control focus" name="DTL_<?php echo $data->NO_CONT; ?>[NO_CONT]" value="<?php echo $data->NO_CONT; ?>"></td>
              <th><input type="text" class="form-control focus" id="ukrcont" name="DTL_<?php echo $data->NO_CONT; ?>[UKR_CONT]" value="<?php echo $data->UKR_CONT; ?>"></th>
                  <td>
            <select class="form-control focus" id="type_<?php echo $data->NO_CONT; ?>" name="DTL_<?php echo $data->NO_CONT; ?>[TYPE]">
                  <option value="DRY">DRY</option>
                  <option value="HQ">HQ</option>
                  <option value="OVD">OVD</option>
                  <option value="TNK">TNK</option>
                  <option value="OT">OT</option>
                  <option value="RFR">RFR</option>
            </select>
          </td>
          <td>
            <select class="form-control focus" id="status_<?php echo $data->NO_CONT; ?>" name="DTL_<?php echo $data->NO_CONT; ?>[STATUS]">
            <option value="FULL">FULL</option>
            <option value="EMPTY">EMPTY</option>
          </select> 
          </td>
		  <td>
			<select class="form-control focus" id="dg_<?php echo $data->NO_CONT; ?>" name="DTL_<?php echo $data->NO_CONT; ?>[DG]">
				<option value="">NON DG</option>
				<option value="DG">DG</option>
				<option value="DGNL">DG NON LABEL</option>
			</select> 
		</td>
        </tr>
        <?php $no++; } ?>
        <tr>
          <!--<td colspan="4" style="text-align: center"><input type="submit" class="btn btn-primary" value="SAVE" ></td>-->
        </tr>
            </table>            
      </div>  
          <input type="hidden" name="action" id="action" readonly="readonly" value="<?php echo site_url('billingDeliveryExt/delivery/post'); ?>"/>
          <input type="hidden" name="cont_post" id="cont_post" readonly="readonly" mandatory="yes">
        </form>
    <button type="submit" class="btn btn-sm btn-info navbar-center navbar-btn waves-effect waves-light" onclick="save_post('form_data','tbldeliveryext'); return false;">
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
	autocomplete('NM_KAPAL','/popup/autocomplete/mst_kapal',function(event, ui){    
		$('#NM_KAPAL').val(ui.item.label);
		$('#NO_VOY_FLIGHT').val(ui.item.NO_VOY);
	});
});
</script>
<script>
$(function() {
	var checkbox = $("#CB_NHI");
	var hidden_NHI = $("#TGLNHI");
	var hidden_SEGEL = $("#TGLBUKASEGEL");
	var ICB_NHI = $("#ICB_NHI");
	var ICB_BK_SEGEL = $("#ICB_BK_SEGEL");
	hidden_NHI.hide();
	hidden_SEGEL.hide();
	checkbox.change(function() {
		if (checkbox.is(':checked')) {
			hidden_NHI.show();
			hidden_SEGEL.show();
			ICB_NHI.prop("disabled", false);
			ICB_BK_SEGEL.prop("disabled", false);
		} else {
			var ok = confirm('Are you sure you want to remove all data?');                        
			if(ok) { 
				ICB_NHI.val('');
				ICB_BK_SEGEL.val('');
				hidden_NHI.hide();
				hidden_SEGEL.hide();
			}
		}
	});
});
</script>