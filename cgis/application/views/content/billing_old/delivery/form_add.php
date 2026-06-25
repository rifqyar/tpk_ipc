<?php //print_r($arrdata);die(); ?>
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
        <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('execute/process/'.$action.'/delivery/'.$id); ?>" method="post" autocomplete="off" onsubmit="save_post('form_data','divtbldelivery'); return false;" popup="1">
          <div class="panel-body container-fluid">
            <div class="row">
              <div class="form-group form-material">
                <div class="col-sm-9">
                  <input type="hidden" name="DATA[ID]" id="ID" mandatory="no" class="form-control" value="<?php echo trim($arrdata[0]->ID); ?>">
                 <input type="hidden" name="DATA[TGL_DOK]" id="ID_REQ" class="form-control" value="<?php echo trim($arrdata[0]->TGL_DOK_INOUT); ?>">
                   <!--<input type="hidden" name="DATA[NO_BL]" id="NO_BL" class="form-control" value="<?php //echo trim($arrdata[0]->NO_BL_AWB); ?>">-->
                  <input type="hidden" name="DATA[NM_KAPAL]" id="NO_BL" class="form-control" value="<?php echo trim($arrdata[0]->NM_ANGKUT); ?>">
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
                  <button type="button" class="btn btn-primary btn-sm" onclick="popup_searchtwo('popup/popup_search/mt_customer/NPWP|CUSTOMER/2');"><span class="icon md-search"></span></button>
                </div>
              </div>
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
              <!---->
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
                  <input type="text" name="DATA[PAIDTHRU]" id="ATD" mandatory="yes" class="form-control date" placeholder="PAIDTHRU" value="<?php //echo $arrdata['ATD']; ?>" maxlength="10">
                  <div class="hint">PAIDTHRU</div>
                </div>
              </div>
            </div>
          </div>
		  <div class="container">
      <!--
         <div class="form-group form-material">
            <div class="ribbon ribbon-clip ribbon-primary">
              <span class="ribbon-inner">
                <i class="icon md-file-text margin-0" aria-hidden="true"></i> Detail Kontainer<?php //echo $title; ?>
              </span>
          </div>
        </div>
        -->
      <br><Br><br><Br>
  			<table class="table">
                <th></th>
            		<th>NO KONTAINER</th>
            		<th>SIZE</th>
            		<th>TYPE</th>
            		<th>STATUS</th>
            	</tr>
				<?php 
					$no = 0;
					foreach($detail_cont as $data){
						
				?>
      	<tr>
            <td>
              <span class="chexbox-custom chexbox-primary">
                <input type="checkbox" onclick="check('chk_cont', 'cont_post')" name="chk_cont" id='chk_cont' value="<?php echo $data->ID."~".$data->NO_CONT; ?>">
                <label for="" id="ckk"></label>
              </span>
            </td>
            <td><input type="text" class="form-control focus" name="DTL_<?php echo $data->NO_CONT; ?>[NO_CONT]" value="<?php echo $data->NO_CONT; ?>"></td>
              <th><input type="text" class="form-control focus" id="ukrcont" name="DTL_<?php echo $data->NO_CONT; ?>[UKR_CONT]" value="<?php echo $data->KD_CONT_UKURAN; ?>"></th>
                  <td>
            <select class="form-control focus" id="type_<?php echo $data->NO_CONT; ?>" name="DTL_<?php echo $data->NO_CONT; ?>[TYPE]">
              <option value="DRY">DRY</option>
              <option value="HQ">HQ</option>
              <!-- <option value="QT">QT</option> -->
              <option value="OVD">OVD</option>
              <!-- <option value="HQ">HQ</option> -->
              <option value="TNK">TNK</option>
			  <option value="TNK">RFR</option>
			  <option value="TNK">DG</option>
            </select>
          </td>
          <td>
            <select class="form-control focus" id="status_<?php echo $data->NO_CONT; ?>" name="DTL_<?php echo $data->NO_CONT; ?>[STATUS]">
            <option value="FULL">FULL</option>
            <option value="EMPTY">EMPTY</option>
          </select> 
          </td>
        </tr>
        <?php $no++; } ?>
        <tr>
          <!--<td colspan="4" style="text-align: center"><input type="submit" class="btn btn-primary" value="SAVE" ></td>-->
        </tr>
            </table>            
      </div>  
          <input type="hidden" name="action" id="action" readonly="readonly" value="<?php echo site_url('billing/delivery/post'); ?>"/>
          <input type="hidden" name="cont_post" id="cont_post" readonly="readonly" mandatory="yes">
        </form>
		<button type="submit" class="btn btn-sm btn-primary navbar-center navbar-btn waves-effect waves-light" onclick="save_post('form_data','divtbldelivery'); return false;">
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