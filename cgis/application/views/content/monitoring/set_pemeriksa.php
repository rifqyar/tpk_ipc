<?php 
	//print_r($arrdata); die();
?>
<div class="panel">
  <div class="ribbon ribbon-clip ribbon-primary">
    <span class="ribbon-inner">
    <i class="icon margin-0" aria-hidden="true"></i> <?php echo "SET PEMERIKSA BC" ?>
    </span>
  </div>
  <button type="submit" class="btn btn-sm btn-primary navbar-right navbar-btn waves-effect waves-light" onclick="save_post('form_data','divsetpemeriksa'); return false;">
    <i class="icon md-badge-check"></i> SAVE
  </button>
  <div class="panel-body container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('display/pergerakan_jinspection/'.$action.'/'.$id); ?>" method="post" autocomplete="off" onsubmit="save_post('form_data','divsetpemeriksa'); return false;" popup="1">
          <div class="panel-body container-fluid">
            <div class="row">
              <div class="form-group form-material">
                <div class="col-sm-9">
                  <input type="hidden" name="DATA[NO_CONT]" id="NO_CONT" mandatory="no" class="form-control" value="<?php echo trim($no_cont); ?>">
                </div>
              </div>
              <div class="form-group form-material">
                <div class="col-sm-9">
                  <input type="hidden" name="DATA[no_dok]" id="no_dok" mandatory="no" class="form-control" value="<?php echo trim($no_respon); ?>">
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NAMA PEMERIKSA BC</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[PEMERIKSA_BC]" id="PEMERIKSA_BC" mandatory="yes" class="form-control" placeholder="NAMA PEMERIKSA BC" value="<?php if($hasil['id_pemeriksa_bc']){ echo trim($hasil['NAMA']); 
                  }else{
                    echo "";
                  }  ?>" >
                  <div class="hint">NAMA PEMERIKSA BC</div>
                </div>
              </div>
              <div class="form-group form-material">
                <div class="col-sm-9">
                  <input type="hidden" name="DATA[id_pemeriksa_bc]" id="PEMERIKSA_BC2" mandatory="no" class="form-control" placeholder="NAMA PEMERIKSA BC" value="<?php echo trim($hasil['id_pemeriksa_bc']); ?>" >
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">JADWAL PERIKSA</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[jadwal_bc]" id="JADWAL_PERIKSA" mandatory="no" class="form-control" readonly placeholder="JADWAL PERIKSA" value="<?php echo trim($hasil['jadwal']); ?>" >
                  <div class="hint">JADWAL PERIKSA</div>
                </div>
              </div>
       

            </div>
          </div>
          <input type="hidden" name="action" id="action" readonly="readonly" value="<?php echo site_url('display/pergerakan_jinspection/post'); ?>"/>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
$(function(){
date('date');
datetime('datetime');
  autocomplete('PEMERIKSA_BC','/popup/autocomplete/t_pemeriksa_ppk_bc',function(event, ui){    
    $('#PEMERIKSA_BC').val(ui.item.label);
    $('#PEMERIKSA_BC2').val(ui.item.id);
  });
  
});
</script>



