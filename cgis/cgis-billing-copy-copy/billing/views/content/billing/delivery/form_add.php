<?php //print_r($arrdata);die(); ?>
<div class="panel">
	<div class="ribbon ribbon-clip ribbon-info">
		<span class="ribbon-inner">
			<i class="icon md-file-text margin-0" aria-hidden="true"></i> <?php echo $title; ?>
		</span>
	</div>
	<BR><BR>
	<div class="panel-body container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('billingDelivery/process/'.$action.'/'.$id); ?>" method="post" autocomplete="off" onsubmit="save_post('form_data','divtbldelivery'); return false;" popup="1">
				<div class="panel-body container-fluid">
					<div class="row">
						<div class="form-group form-material">
							<div class="col-sm-9">
								<input type="hidden" name="DATA[ID]" id="ID" mandatory="no" class="form-control" value="<?php echo trim($arrdata[0]->ID); ?>">
								<input type="hidden" name="DATA[TGL_DOK]" id="ID_REQ" class="form-control" value="<?php echo trim($arrdata[0]->TGL_DOK_INOUT); ?>">
								<input type="hidden" name="DATA[NM_KAPAL]" id="NO_BL" class="form-control" value="<?php echo trim($arrdata[0]->NM_ANGKUT); ?>">
								<div class="hint">TGL_DOK</div>
							</div>
						</div>
						<div class="form-group form-material">
							<label class="col-sm-3 control-label">NAMA KAPAL</label>
							<div class="col-sm-9">
								<input type="text" name="DATA[NM_KAPAL]" id="NM_KAPAL" mandatory="no" class="form-control" placeholder="NAMA KAPAL" value="<?php echo $arrdata[0]->NM_ANGKUT; ?>" maxlength="10">
								<div class="hint">NAMA KAPAL</div>
							</div>
						</div>
						<div class="form-group form-material">
							<label class="col-sm-3 control-label">VOYAGE</label>
							<div class="col-sm-9">
								<input type="text" name="DATA[VOYAGE]" id="NO_VOY_FLIGHT" mandatory="no" class="form-control" placeholder="VOYAGE" value="<?php echo $arrdata[0]->NO_VOY_FLIGHT; ?>" maxlength="10">
								<div class="hint">VOYAGE</div>
							</div>
						</div>
						<div class="form-group form-material">
							<label class="col-sm-3 control-label">CUSTOMER</label>
							<div class="col-sm-8">
								<input type="text" name="DATA[CUSTOMER]" id="CUSTOMER" mandatory="yes" readonly class="form-control" placeholder="CUSTOMER" value="<?php echo $arrdata[0]->CONSIGNEE; ?>" maxlength="10">
								<div class="hint">CUSTOMER</div>
							</div>
							<div class="col-sm-1">
								<button type="button" class="btn btn-info btn-sm" onclick="popup_searchtwo('popup/popup_search/mt_customer/NPWP|CUSTOMER/2');"><span class="icon md-search"></span></button>
							</div>
						</div>
						<div class="form-group form-material">
							<label class="col-sm-3 control-label">NPWP</label>
							<div class="col-sm-9">
								<input type="text" name="DATA[NPWP]" id="NPWP" mandatory="yes" readonly class="form-control" placeholder="NPWP" value="<?php echo $arrdata[0]->ID_CONSIGNEE; ?>" maxlength="10">
								<div class="hint">NPWP</div>
							</div>
						</div>
						<div class="form-group form-material">
							<label class="col-sm-3 control-label">NO. BL</label>
							<div class="col-sm-9">
								<input type="text" name="DATA[NO_BL]" id="NO_BL" mandatory="yes" class="form-control" placeholder="NO. BL" value="<?php echo trim($arrdata[0]->NO_BL_AWB); ?>" maxlength="50">
								<div class="hint">NO. BL</div>
							</div>
						</div>
						<div class="form-group form-material">
							<label class="col-sm-3 control-label">NO. DO</label>
							<div class="col-sm-9">
								<input type="text" name="DATA[NO_DO]" id="NO_DO" mandatory="yes" class="form-control" placeholder="NO. DO" value="<?php //echo $arrdata['CONTACT_PERSON']; ?>" maxlength="50">
								<div class="hint">NO. DO</div>
							</div>
						</div>
						<div class="form-group form-material">
							<label class="col-sm-3 control-label">TGL. DOKUMEN</label>
							<div class="col-sm-9">
								<input type="text" name="DATA[TYPE]" id="TYPE" readonly="readonly" mandatory="no" class="form-control" placeholder="TGL. DOKUMEN" value="<?php echo date('d-m-Y',strtotime($arrdata[0]->TGL_DOK_INOUT)) ?>" maxlength="10">
								<div class="hint">TGL. DOKUMEN</div>
							</div>
						</div>
						<div class="form-group form-material">
							<label class="col-sm-3 control-label">NO DOKUMEN</label>
							<div class="col-sm-9">
								<input type="text" name="DATA[NO_DOK]" id="NO_DOK" mandatory="no" readonly class="form-control" placeholder="NO_DOK" value="<?php echo $arrdata[0]->NO_DOK_INOUT; ?>" maxlength="10">
								<div class="hint">NO DOKUMEN</div>
							</div>
						</div>
						<div class="form-group form-material">
							<label class="col-sm-3 control-label">DATE OF DELIVERY</label>
							<div class="col-sm-9">
								<input type="text" name="DATA[PAIDTHRU]" id="ATD" mandatory="yes" class="form-control date" placeholder="PAIDTHRU" value="<?php //echo $arrdata['ATD']; ?>" maxlength="10" onclick="javascript:validate();">
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
							<th></th>
							<th >NO KONTAINER</th>
							<th>SIZE</th>
							<th>TYPE</th>
							<th>STATUS</th>
							<th>DG</th>
						</tr>
						<?php 
							$no = 0;
							foreach($arrdatacont as $data){
						?>
						<tr>
							<td>
								<span class="chexbox-custom chexbox-info">
									<input type="checkbox" onclick="check('chk_cont', 'cont_post')" name="chk_cont" id='chk_cont' value="<?php echo $data->ID."~".$data->NO_CONT; ?>">
									<label for="" id="ckk"></label>
								</span>
							</td>
							<td>
								<input type="text" class="form-control focus" name="DTL_<?php echo $data->NO_CONT; ?>[NO_CONT]" value="<?php echo $data->NO_CONT; ?>">
							</td>
							<td>
								<input type="text" class="form-control focus" id="ukrcont" name="DTL_<?php echo $data->NO_CONT; ?>[UKR_CONT]" value="<?php echo $data->KD_CONT_UKURAN; ?>">
							</td>
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
								<select class="form-control focus" id="dg_<?php echo $data->NO_CONT; ?>" name="DTL_<?php echo $data->NO_CONT; ?>[DG]" value="<?php echo $data->IMO; ?>">
									<?php 
										if ($data->IMO != '') {
											echo "	<option value='DG'>DG</option>
													<option value=''>NON DG</option>
													<option value='DGNL'>DG NON LABEL</option>";
										}else{
											echo "	<option value=''>NON DG</option>
													<option value='DG'>DG</option>
													<option value='DGNL'>DG NON LABEL</option>";
										}
									?>
								</select> 
							</td>
						</tr>
						<?php $no++; } ?>
						<tr>
						</tr>
					</table>            
				</div>  
				<input type="hidden" name="action" id="action" readonly="readonly" value="<?php echo site_url('billingDelivery/delivery/post'); ?>"/>
				<input type="hidden" name="cont_post" id="cont_post" readonly="readonly" mandatory="yes">
				</form>
				<button type="submit" class="btn btn-sm btn-info navbar-center navbar-btn waves-effect waves-light" onclick="save_post('form_data','divtbldelivery'); return false;">
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
<!-- <script>
$(function() {
	var checkbox = $("#CB_DG");
	var hidden_DG = $("#DG_TRUE");
	$(".DG_CONT").prop("disabled",true);
	checkbox.change(function() {
		if (checkbox.is(':checked')) {
			$(".DG_CONT").prop("disabled",false);
		} else {
			hidden_DG.val('');
			$(".DG_CONT").prop("disabled",true);
		}
	});
});
</script> -->
<script type="text/javascript">
    function validate() {

        var format = 'yyyy-MM-dd';

        if(isAfterCurrentDate(document.getElementById('start').value, format)) {
            alert('Date is after the current date.');
        } else {
            alert('Date is not after the current date.');
        }
</script>