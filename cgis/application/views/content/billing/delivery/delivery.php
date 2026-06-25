<?php //  print_r($arrdata[0]['NO_SPK']);die(); ?>
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
        <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('execute/process/update/delivery/'.$id); ?>" method="post" autocomplete="off" onsubmit="save_post('form_data','tblbehandle'); return false;" popup="1">
          <div class="panel-body container-fluid">
            <div class="row">
              <div class="form-group form-material">
                <div class="col-sm-9">
                  <input type="hidden" name="DATA[ID]" id="ID" mandatory="no" class="form-control" value="<?php echo $id ?>">
                  <div class="hint">ID</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NAMA KAPAL</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NM_KAPAL]" id="NM_KAPAL" mandatory="no" class="form-control" placeholder="NAMA KAPAL" value="<?php echo $arrdata[0]['NM_KAPAL']; ?>" maxlength="50" >
                  <div class="hint">NAMA KAPAL</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NO VOYAGE</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NO_VOY]" id="ADDRESS" mandatory="no" class="form-control" placeholder="NO VOYAGE" value="<?php echo $arrdata[0]['NO_VOY']; ?>" maxlength="50" >
                  <div class="hint">NO VOYAGE</div>
                </div>
              </div>  
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NAMA CUSTOMER</label>
                <div class="col-sm-8">
                  <input type="text" name="DATA[CUSTOMER]" id="CUSTOMER" mandatory="no" class="form-control" placeholder="NAMA CUSTOMER" maxlength="20" value="<?php echo $arrdata[0]['NAMA_CUST']; ?>" required>
                  <div class="hint">NAMA CUSTOMER</div>
                </div>
                <div class="col-sm-1">
                  <button type="button" class="btn btn-primary btn-sm" onclick="popup_searchtwo('popup/popup_search/mt_customer/NPWP|CUSTOMER/2');"><span class="icon md-search"></span></button>
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
                <label class="col-sm-3 control-label">NO DO</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NO_DO]" id="JNS_DOK" mandatory="no" class="form-control" placeholder="NO DO" value="<?php echo $arrdata[0]['NO_DO']; ?>" maxlength="20" readonly>
                  <div class="hint">NO DO</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NO. DOKUMEN</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NO_DOK]" id="CONTACT_PERSON" mandatory="no" class="form-control" placeholder="NO. DOKUMEN" value="<?php echo $arrdata[0]['NO_DOK']; ?>" maxlength="10" readonly>
                  <div class="hint">NO. DOKUMEN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">TANGGAL DOKUMEN</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[TGL_DOK]" id="CONTACT_PERSON" mandatory="no" class="form-control" placeholder="TANGGAL DOKUMEN" value="<?php echo $arrdata[0]['TGL_DOK']; ?>" maxlength="10">
                  <div class="hint">TANGGAL DOKUMEN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">DATE OF DELIVERY</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[EXPIRED]" id="CONTACT_PERSON" mandatory="no" class="form-control" placeholder="PAIDHTRU" value="<?php echo $arrdata[0]['EXPIRED']; ?>" maxlength="10">
                  <div class="hint">PAIDTHRU</div>
                </div>
              </div>
            </div>
          </div>
          <div class="container">
            <br><Br>
            <table class="table">
              <th></th>
              <th>NO KONTAINER</th>
              <th>SIZE</th>
              <th>TYPE</th>
              <th>STATUS</th>
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
              <td>
                <input type="text" class="form-control focus" name="DTL_<?php echo $data->NO_CONT; ?>[NO_CONT]" value="<?php echo $data->NO_CONT; ?>"></td>
                <th><input type="text" class="form-control focus" id="ukrcont" name="DTL_<?php echo $data->NO_CONT; ?>[UKR_CONT]" value="<?php echo $data->UKR_CONT; ?>"></th>
              <td>
                <select class="form-control focus" id="type_<?php echo $data->NO_CONT; ?>" name="DTL_<?php echo $data->NO_CONT; ?>[TYPE]">
                  <option value="DRY">DRY</option>
                  <option value="HQ">HQ</option>
                  <option value="QT">QT</option>
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
